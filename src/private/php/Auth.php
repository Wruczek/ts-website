<?php

namespace Wruczek\TSWebsite;

use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\Utils\Language\LanguageUtils;
use Wruczek\TSWebsite\Utils\TeamSpeakUtils;
use Wruczek\TSWebsite\Utils\Utils;

class Auth {

    public static function isLoggedIn() {
        return self::getCldbid() !== null && self::getUid() !== null;
    }

    public static function getUid(): ?string {
        return @$_SESSION["tsuser"]["uid"];
    }

    public static function getCldbid(): ?int {
        return @$_SESSION["tsuser"]["cldbid"];
    }

    public static function getNickname(): ?string {
        return @$_SESSION["tsuser"]["nickname"];
    }

    public static function logout(): void {
        unset($_SESSION["tsuser"]);
    }

    public static function getTsUsersByIp(string $ip = null): ?array {
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

            $clientIp = (string) $client["connection_client_ip"];

            if ($clientIp === $ip) {
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
    public static function checkClientIp(int $cldbid, string $ip = null): bool {
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
     * @throws \TeamSpeak3_Adapter_ServerQuery_Exception
     */
    public static function generateConfirmationCode(int $cldbid, ?bool $poke = null) {
        if ($poke === null) {
            $poke = (bool) Config::get("loginpokeclient");
        }

        if (TeamSpeakUtils::i()->checkTSConnection()) {
            try {
                $client = TeamSpeakUtils::i()->getTSNodeServer()->clientGetByDbid($cldbid);
                $code = (string) Utils::getSecureRandomInt(100000, 999999);
                $msg = __get("LOGIN_CONFIRMATION_CODE", $code);

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

                throw $e;
            } catch (\Exception $e) {
                // ignore exceptions from Utils::getSecureRandomInt
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
    public static function getConfirmationCode(int $cldbid): ?string {
        return (new PhpFileCache(__CACHE_DIR, "confirmationcodes"))->retrieve("c_$cldbid");
    }

    /**
     * Saves confirmation code for the user
     * @param $cldbid int
     * @param $code string
     */
    public static function saveConfirmationCode(int $cldbid, string $code): void {
        (new PhpFileCache(__CACHE_DIR, "confirmationcodes"))->store("c_$cldbid", $code, (int) Config::get("cache_logincode"));
    }

    /**
     * Deletes confirmation code for the user
     * @param $cldbid int
     */
    public static function deleteConfirmationCode(int $cldbid): void {
        (new PhpFileCache(__CACHE_DIR, "confirmationcodes"))->eraseKey("c_$cldbid");
    }

    /**
     * Checks confirmation code and logs user in if its correct.
     * @param $cldbid
     * @param $userCode
     * @return bool true if authentication was successful
     */
    public static function checkCodeAndLogin(int $cldbid, string $userCode): bool {
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
    public static function checkConfirmationCode(int $cldbid, string $userCode): bool {
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
    public static function loginUser(int $cldbid): bool {
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

    public static function invalidateUserGroupCache(): void {
        unset($_SESSION["tsuser"]["servergroups"]);
    }

    /**
     * Returns an array containing cached array with group IDs of the user
     * @param $cacheTime int for how long we should cache the IDs?
     * @return array array with server group IDs of the user as ints
     * @throws UserNotAuthenticatedException if user is not logged in
     * @throws \TeamSpeak3_Exception when we cannot get data from the TS server
     */
    public static function getUserServerGroupIds(int $cacheTime = 60): array {
        if (!self::isLoggedIn()) {
            throw new UserNotAuthenticatedException("User is not authenticated");
        }

        // Check if we data is already cached and if we can use it
        // no caching in dev mode
        if (isset($_SESSION["tsuser"]["servergroups"]) && !__DEV_MODE) {
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
        // That gives us an array with ID's of user groups
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
    public static function getUserServerGroups(int $cacheTime = 60): array {
        $serverGroupIds = self::getUserServerGroupIds($cacheTime);
        $serverGroups = CacheManager::i()->getServerGroupList();

        return array_filter($serverGroups, function (array $serverGroup) use ($serverGroupIds) {
            // If the group id is inside $serverGroupIds,
            // keep that group. Otherwise filter it out.
            return in_array($serverGroup["sgid"], $serverGroupIds, true);
        });
    }
}

class UserNotAuthenticatedException extends \Exception {}
