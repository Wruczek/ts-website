<?php

namespace Wruczek\TSWebsite;

use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\Utils\TeamSpeakUtils;

class ServerIconCache {

    private static $iconsCacheDir = __CACHE_DIR . "/servericons";

    /**
     * Returns contents of an icon
     * @param string|int $iconId icon id
     * @return string|null returns contents as string or null if not found
     * @throws \Exception
     */
    public static function getIconBytes($iconId): ?string {
        if (!is_numeric($iconId)) {
            throw new \Exception("iconid need to be an int or numeric string");
        }

        $file = @file_get_contents(self::$iconsCacheDir . "/" . $iconId);

        // return null on error
        if ($file === false) {
            return null;
        }

        return $file;
    }

    public static function hasIcon($iconId): bool {
        return self::getIconBytes($iconId) !== null;
    }

    public static function syncIcons(): void {
        if (!file_exists(self::$iconsCacheDir) && !mkdir(self::$iconsCacheDir)) {
            throw new \Exception("Cannot create icons cache directory at " . self::$iconsCacheDir);
        }

        foreach (self::ftDownloadIconList() as $iconElement) {
            $iconName = (string) $iconElement["name"];
            $iconId = self::iconIdFromName($iconName);

            if (self::hasIcon($iconId)) {
                continue;
            }

            try {
                $iconData = (string) self::downloadIcon($iconId);
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

    public static function syncIfNeeded(): void {
        (new PhpFileCache(__CACHE_DIR))->refreshIfExpired("lasticonsync", function () {
            // Do not sync icons if we cannot connect the the TS server
            if (!TeamSpeakUtils::i()->checkTSConnection()) {
                return null;
            }

            ServerIconCache::syncIcons();
            return true;
        }, Config::get("cache_servericons", 300));
    }

    public static function isLocal(int $iconId): bool {
        return $iconId > 0 && $iconId < 1000;
    }

    public static function iconIdFromName(string $iconName): string {
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
    public static function unsignIcon(int $iconId): int {
        if (!is_int($iconId)) {
            throw new \InvalidArgumentException("iconId must be an integer");
        }

        return ($iconId < 0) ? (2 ** 32) - ($iconId * -1) : $iconId;
    }

    public static function downloadIcon($iconId): \TeamSpeak3_Helper_String {
        return TeamSpeakUtils::i()->ftDownloadFile("/icon_$iconId");
    }

    public static function ftDownloadIconList(): array {
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
