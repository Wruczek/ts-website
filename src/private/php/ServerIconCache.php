<?php

namespace Wruczek\TSWebsite;

use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\Utils\TeamSpeakUtils;

class ServerIconCache {

    private static $iconsCacheDir = __CACHE_DIR . "/servericons";

    public static function getIconBytes($iconId) {
        if (!is_numeric($iconId)) {
            throw new \Exception("iconid need to be an int or numeric string");
        }

        $file = @file_get_contents(self::$iconsCacheDir . "/" . $iconId);
        return $file === false ? null : $file; // return null on error
    }

    public static function hasIcon($iconId) {
        return self::getIconBytes($iconId) !== null;
    }

    public static function syncIcons() {
        if (!file_exists(self::$iconsCacheDir) && !mkdir(self::$iconsCacheDir, true)) {
            throw new \Exception("Cannot create icons cache directory at " . self::$iconsCacheDir);
        }

        foreach (self::ftDownloadIconList() as $iconElement) {
            $iconName = (string) $iconElement["name"];
            $iconId = self::iconIdFromName($iconName);

            if (self::hasIcon($iconId)) {
                continue;
            }

            try {
                $iconData = self::downloadIcon($iconId);
            } catch (\Exception $e) {
                trigger_error("Cannot download icon $iconId");
                continue;
            }

            $createFile = file_put_contents(self::$iconsCacheDir . "/$iconId", $iconData);

            if ($createFile === false) {
                throw new \Exception("Cannot create icon file for icon $iconId, check folder permissions");
            }
        }
    }

    public static function syncIfNeeded() {
        (new PhpFileCache(__CACHE_DIR))->refreshIfExpired("lasticonsync", function () {
            // Do not sync icons if we cannot connect the the TS server
            if (!TeamSpeakUtils::i()->checkTSConnection()) {
                return null;
            }

            ServerIconCache::syncIcons();
            return true;
        }, Config::get("cache_servericons", 300));
    }

    public static function isLocal($iconId) {
        return $iconId > 0 && $iconId < 1000;
    }

    public static function iconIdFromName($iconName) {
        return substr($iconName, 5);
    }

    /**
     * Converts a 32-bit int to a unsigned int
     * 32-bit int is obtained for example from the servergroup details (iconid)
     * Returned value can be used with ServerIconCache's methods like getIconBytes
     * @see http://yat.qa/resources/tools/ (Icon Filename Tool)
     * @param $iconId int
     * @return int
     */
    public static function unsignIcon($iconId) {
        if (!is_int($iconId)) {
            throw new \InvalidArgumentException("iconId must be an integer");
        }

        return ($iconId < 0) ? (2 ** 32) - ($iconId * -1) : $iconId;
    }

    public static function downloadIcon($iconId) {
        return TeamSpeakUtils::i()->ftDownloadFile("/icon_$iconId");
    }

    public static function ftDownloadIconList() {
        try {
            return TeamSpeakUtils::i()->getTSNodeServer()->channelFileList(0, "", "/icons/");
        } catch (\TeamSpeak3_Adapter_ServerQuery_Exception $e) {
            if ($e->getCode() === 1281) { // database empty result set
                return [];
            }

            throw $e;
        }
    }

}
