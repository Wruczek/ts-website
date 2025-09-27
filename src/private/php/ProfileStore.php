<?php

namespace Wruczek\TSWebsite;

use Wruczek\TSWebsite\Utils\DatabaseUtils;

class ProfileStore {

    public static function ensureTable(): void {
        $db = DatabaseUtils::i()->getDb();
        $db->query(
            "CREATE TABLE IF NOT EXISTS tsw_user_profiles (
                cldbid INT PRIMARY KEY,
                steamid VARCHAR(32) NULL,
                facebook VARCHAR(255) NULL,
                twitter VARCHAR(255) NULL,
                instagram VARCHAR(255) NULL,
                telegram VARCHAR(255) NULL,
                youtube VARCHAR(255) NULL,
                steam VARCHAR(255) NULL,
                github VARCHAR(255) NULL,
                tiktok VARCHAR(255) NULL,
                spotify VARCHAR(255) NULL,
                twitch VARCHAR(255) NULL,
                discordid VARCHAR(64) NULL,
                updated_at INT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4"
        );
    }

    public static function getByCldbid(int $cldbid): array {
        self::ensureTable();
        $db = DatabaseUtils::i()->getDb();
        $row = $db->get("tsw_user_profiles", "*", ["cldbid" => $cldbid]);
        return $row ?: [];
    }

    public static function upsert(int $cldbid, array $data): void {
        self::ensureTable();
        $db = DatabaseUtils::i()->getDb();
        $data["cldbid"] = $cldbid;
        $data["updated_at"] = time();

        $exists = (bool) $db->has("tsw_user_profiles", ["cldbid" => $cldbid]);
        if ($exists) {
            $db->update("tsw_user_profiles", $data, ["cldbid" => $cldbid]);
        } else {
            $db->insert("tsw_user_profiles", $data);
        }
    }
}

