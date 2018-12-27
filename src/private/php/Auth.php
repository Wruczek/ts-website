<?php

namespace Wruczek\TSWebsite;

use function array_filter;
use function array_keys;
use Exception;
use function in_array;
use function time;
use function var_dump;
use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\Utils\Language\LanguageUtils;
use Wruczek\TSWebsite\Utils\TeamSpeakUtils;
use Wruczek\TSWebsite\Utils\Utils;

class Auth {

    public static function isLoggedIn() {
        return !empty(self::getCldbid()) && !empty(self::getUid());
    }

    public static function getUid() {
        return @$_SESSION["tsuser"]["uid"];
    }

    public static function getCldbid() {
        return @$_SESSION["tsuser"]["cldbid"];
    }

    public static function getNickname() {
        return @$_SESSION["tsuser"]["nickname"];
    }

    public static function logout() {
        unset($_SESSION["tsuser"]);
    }

    public static function getTsUsersByIp($ip = null) {
        if ($ip === null) {
            $ip = Utils::getClientIp();
        }

        $clientList = CacheManager::i()->getClientList();

        if ($clientList === null) {
            return null;
        }

        $ret = [];

        foreach ($clientList as $client) {
            // Skip query clients
            if ($client["client_type"]) continue;

            if ((string) $client["connection_client_ip"] === $ip) {
                $ret[$client["client_database_id"]] = (string) $client["client_nickname"];
            }
        }

        return $ret;
    }

    /**
     * Returns true if the $cldbid is connected with the same IP address as $ip
     * @param $cldbid int cldbid to check
     * @param $ip string optional, defaults to Utils::getClientIp
     * @return bool true if the cldbid have the same IP address as $ip
     */
    public static function checkClientIp($cldbid, $ip = null) {
        if ($ip === null) {
            $ip = Utils::getClientIp();
        }

        $users = self::getTsUsersByIp($ip);

        if ($users === null) {
            return false;
        }

        return array_key_exists($cldbid, $users);
    }

    /**
     * Tries to generate and send confirmation code to the TS client
     * @param $cldbid int
     * @param $poke bool|null true = poke user, false = send a message, null = default value from config
     * @return string|null|false Returns code as string on success, null when
     *         client cannot be found and false when other error occurs.
     */
    public static function generateConfirmationCode($cldbid, $poke = null) {
        if ($poke === null) {
            $poke = (bool) Config::get("loginpokeclient");
        }

        if (TeamSpeakUtils::i()->checkTSConnection()) {
            try {
                $client = TeamSpeakUtils::i()->getTSNodeServer()->clientGetByDbid($cldbid);
                $code = (string) mt_rand(100000, 999999); // TODO: replace it with a CSPRNG
                $msg = LanguageUtils::tl("LOGIN_CONFIRMATION_CODE", $code);

                if ($poke) {
                    $client->poke(mb_substr($msg, 0, 100)); // Max 100 characters for pokes
                } else {
                    $client->message(mb_substr($msg, 0, 1024)); // Max 1024 characters for messages
                }

                self::saveConfirmationCode($cldbid, $code);
                return $code;
            } catch (\TeamSpeak3_Adapter_ServerQuery_Exception $e) {
                if ($e->getCode() === 512) {
                    return null;
                }
            }
        }

        return false;
    }

    /**
     * Checks if there is already a confirmation code cached for this user.
     * Returns the code of found, otherwise NULL.
     * @param $cldbid int
     * @return string|null Confirmation code, null if not found
     */
    public static function getConfirmationCode($cldbid) {
        return (new PhpFileCache(__CACHE_DIR, "confirmationcodes"))->retrieve("c_$cldbid");
    }

    /**
     * Saves confirmation code for the user
     * @param $cldbid int
     * @param $code string
     */
    public static function saveConfirmationCode($cldbid, $code) {
        (new PhpFileCache(__CACHE_DIR, "confirmationcodes"))->store("c_$cldbid", $code, (int) Config::get("cache_logincode"));
    }

    /**
     * Deletes confirmation code for the user
     * @param $cldbid int
     */
    public static function deleteConfirmationCode($cldbid) {
        (new PhpFileCache(__CACHE_DIR, "confirmationcodes"))->eraseKey("c_$cldbid");
    }

    /**
     * Checks confirmation code and logs user in if its correct.
     * @param $cldbid
     * @param $userCode
     * @return bool true if authentication was successful
     */
    public static function checkCodeAndLogin($cldbid, $userCode) {
        if (!is_int($cldbid)) {
            throw new \InvalidArgumentException("cldbid must be an int");
        }

        $codeCheck = self::checkConfirmationCode($cldbid, $userCode);

        if ($codeCheck !== true) {
            return false;
        }

        $login = self::loginUser($cldbid);
        if ($login) {
            self::deleteConfirmationCode($cldbid);
            return true;
        }

        return false;
    }

    /**
     * Checks if the provided confirmation code matches the saved one and returns true on success.
     * @param $cldbid int
     * @param $userCode string
     * @return bool
     */
    public static function checkConfirmationCode($cldbid, $userCode) {
        $knownCode = self::getConfirmationCode($cldbid);

        if ($knownCode === null) {
            return false;
        }

        return hash_equals($knownCode, $userCode);
    }

    /**
     * Logins user to this account
     * @param $cldbid int
     * @return bool true on success, false otherwise
     */
    public static function loginUser($cldbid) {
        $clientList = CacheManager::i()->getClientList();

        foreach ($clientList as $client) {
            if ($client["client_database_id"] === $cldbid) {
                $_SESSION["tsuser"]["uid"] = (string) $client["client_unique_identifier"];
                $_SESSION["tsuser"]["cldbid"] = $client["client_database_id"];
                $_SESSION["tsuser"]["nickname"] = (string) $client["client_nickname"];
                return true;
            }
        }

        return false;
    }

    public static function invalidateUserGroupCache() {
        unset($_SESSION["tsuser"]["servergroups"]);
    }

    /**
     * Returns an array containing cached array with group IDs of the user
     * @param $cacheTime int for how long we should cache the IDs?
     * @return array array with server group IDs of the user
     * @throws UserNotAuthenticatedException if user is not logged in
     * @throws \TeamSpeak3_Exception when we cannot get data from the TS server
     */
    public static function getUserServerGroupIds($cacheTime = 60) {
        if (!self::isLoggedIn()) {
            throw new UserNotAuthenticatedException("User is not authenticated");
        }

        // Check if we data is already cached and if we can use it
        if (isset($_SESSION["tsuser"]["servergroups"])) {
            $cached = $_SESSION["tsuser"]["servergroups"];

            // Calculate how old is the cached data (in seconds)
            $secondsSinceCache = time() - $cached["timestamp"];

            // If we dont need to refresh it, return the data
            if ($secondsSinceCache <= $cacheTime) {
                return $cached["data"];
            }
        }

        // If we end up here, it means we need to refresh the cache

        if (!TeamSpeakUtils::i()->checkTSConnection()) {
            throw new \TeamSpeak3_Exception("Cannot connect to the TeamSpeak server");
        }

        try {
            $tsServer = TeamSpeakUtils::i()->getTSNodeServer();
            // Get all user groups from TS server
            $serverGroups = $tsServer->clientGetServerGroupsByDbid(self::getCldbid());
        } catch (\TeamSpeak3_Exception $e) {
            TeamSpeakUtils::i()->addExceptionToExceptionsList($e);
            throw $e;
        }

        // Since the array in indexed with server group ID's, we can just separate the keys
        // That gives us an array with ID's if user groups
        $serverGroupIds = array_keys($serverGroups);

        // Cache it in session with current time for later cachebusting
        $_SESSION["tsuser"]["servergroups"] = [
            "timestamp" => time(),
            "data" => $serverGroupIds
        ];

        return $serverGroupIds;
    }

    /**
     * Combines sever group ID's from getUserServerGroupIds() with cached
     * server group list and returns full array with user's server groups
     * @see self::getUserServerGroupIds
     * @param int $cacheTime value passed to getUserServerGroupIds()
     * @return array array with user server groups
     * @throws UserNotAuthenticatedException if user is not logged in
     * @throws \TeamSpeak3_Exception when we cannot get data from the TS server
     */
    public static function getUserServerGroups($cacheTime = 60) {
        $serverGroupIds = self::getUserServerGroupIds($cacheTime);
        $serverGroups = CacheManager::i()->getServerGroupList();

        $resut = array_filter($serverGroups, function ($serverGroup) use ($serverGroupIds) {
            // If the group id is inside $serverGroupIds,
            // keep that group. Otherwise filter it out.
            return in_array($serverGroup["sgid"], $serverGroupIds);
        });

        return $resut;
    }
}

class UserNotAuthenticatedException extends \Exception {}
