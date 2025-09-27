<?php

use Wruczek\TSWebsite\CacheManager;
use Wruczek\TSWebsite\Utils\TemplateUtils;
use Wruczek\TSWebsite\Utils\Utils;
use Wruczek\TSWebsite\ProfileStore;

require_once __DIR__ . "/private/php/load.php";

// Avoid fatal 500 on unexpected errors, surface a friendly page instead
set_exception_handler(function ($e) {
    try {
        \Wruczek\TSWebsite\Utils\TemplateUtils::i()->renderErrorTemplate("500", "Profile error", $e->getMessage());
    } catch (\Throwable $t) {
        http_response_code(500);
        echo "Profile error";
    }
    exit;
});

$cldbid = @$_GET["cldbid"];

if (!isset($cldbid) || !is_numeric($cldbid)) {
    TemplateUtils::i()->renderErrorTemplate("400", "Bad request", "Missing or invalid cldbid parameter");
    exit;
}

$cldbid = (int) $cldbid;

try {
    $clientOnline = CacheManager::i()->getClient($cldbid);
} catch (\Throwable $e) {
    $clientOnline = null;
}
try {
    $profile = ProfileStore::getByCldbid($cldbid);
} catch (\Throwable $e) {
    $profile = [];
}

// Prepare base data for template
$data = [
    "title" => "Profile",
    "navActiveIndex" => 0,
    "client" => null,
    "clientOnline" => $clientOnline,
    "profile" => $profile,
];

// If online info is present, augment with derived fields used in viewer tooltip
if ($clientOnline !== null) {
    $fields = [
        "clid", "cid", "client_database_id", "client_nickname", "client_type",
        "client_away", "client_away_message", "client_flag_talking",
        "client_input_muted", "client_output_muted", "client_input_hardware",
        "client_output_hardware", "client_talk_power", "client_is_talker",
        "client_is_priority_speaker", "client_is_recording", "client_is_channel_commander",
        "client_unique_identifier", "client_servergroups", "client_channel_group_id",
        "client_channel_group_inherited_channel_id", "client_version", "client_platform",
        "client_idle_time", "client_created", "client_lastconnected", "client_icon_id",
        "client_country", "client_badges"
    ];

    $online = [];
    foreach ($fields as $f) {
        $val = $clientOnline[$f] ?? null;
        if ($val instanceof \TeamSpeak3_Helper_String) {
            $val = (string) $val;
        }
        $online[$f] = $val;
    }
    try {
        $online["client_version_short"] = (string) \TeamSpeak3_Helper_Convert::versionShort($online["client_version"] ?? "");
    } catch (\Throwable $e) {
        $online["client_version_short"] = null;
    }
    $online["client_servergroups_list"] = array_map("intval", explode(",", (string) ($online["client_servergroups"] ?? "")));
    // Determine admin status: any server group with a typical admin icon id/name
    $online["is_admin"] = false;
    $serverGroups = CacheManager::i()->getServerGroupList();
    if ($serverGroups) {
        foreach ($serverGroups as $sg) {
            if (in_array($sg["sgid"], $online["client_servergroups_list"], true)) {
                $name = strtolower((string) $sg["name"]);
                if (strpos($name, "admin") !== false) {
                    $online["is_admin"] = true; break;
                }
            }
        }
    }
    // Offline statistics from DB info (works regardless of online)
    try {
        $dbInfo = CacheManager::i()->getClientDbInfo($cldbid);
    } catch (\Throwable $e) {
        $dbInfo = null;
    }
    if ($dbInfo) {
        $online["client_totalconnections"] = (int) $dbInfo["client_totalconnections"];
        $online["client_created"] = (int) $dbInfo["client_created"]; // first connection
        $online["client_lastconnected"] = (int) $dbInfo["client_lastconnected"]; // last seen
    }

    $data["client"] = $online;
}

// Ensure we still provide minimal client structure from DB info when offline
if ($data["client"] === null) {
    try {
        $dbInfo = CacheManager::i()->getClientDbInfo($cldbid);
    } catch (\Throwable $e) {
        $dbInfo = null;
    }
    if ($dbInfo) {
        $data["client"] = [
            "client_database_id" => $cldbid,
            "client_nickname" => (string) ($dbInfo["client_nickname"] ?? "User #$cldbid"),
            "client_created" => (int) ($dbInfo["client_created"] ?? 0),
            "client_lastconnected" => (int) ($dbInfo["client_lastconnected"] ?? 0),
            "client_totalconnections" => (int) ($dbInfo["client_totalconnections"] ?? 0),
            "client_version_short" => null,
            "client_platform" => null,
            "client_country" => null,
            "client_servergroups_list" => [],
            "client_badges" => null,
            "client_idle_time" => 0,
        ];
    }
}

TemplateUtils::i()->renderTemplate("profile", $data);

