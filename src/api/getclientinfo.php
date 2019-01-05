<?php

use Wruczek\TSWebsite\CacheManager;

require_once __DIR__ . "/../private/php/load.php";

if (empty($_GET["cldbid"])) {
    $returnJson = ["success" => false, "message" => "No CLDBID provided"];
} else {
    $cldbid = (int) $_GET["cldbid"];
    $clientList = CacheManager::i()->getClientList();
    $clientData = null;

    foreach ($clientList as $client) {
        if ($client["client_database_id"] === $cldbid) {
            $clientData = $client;
            break;
        }
    }

    if ($clientData !== null) {
        $returnJson = [
            "success" => true,
            "timenow" => time(),
            "data" => buildInfoArray($clientData)
        ];
    } else {
        $returnJson = ["success" => false, "message" => "Client not found"];
    }
}

header("Content-Type: application/json");
echo json_encode($returnJson);

// Helper function

function buildInfoArray($clientData) {
    $ret = [];

    $fields = [
        "clid",
        "cid",
        "client_database_id",
        "client_nickname",
        "client_type",
        "client_away",
        "client_away_message",
        "client_flag_talking",
        "client_input_muted",
        "client_output_muted",
        "client_input_hardware",
        "client_output_hardware",
        "client_talk_power",
        "client_is_talker",
        "client_is_priority_speaker",
        "client_is_recording",
        "client_is_channel_commander",
        "client_unique_identifier",
        "client_servergroups",
        "client_channel_group_id",
        "client_channel_group_inherited_channel_id",
        "client_version",
        "client_platform",
        "client_idle_time",
        "client_created",
        "client_lastconnected",
        "client_totalconnections",
        "client_icon_id",
        "client_country",
        "client_badges"
    ];

    // Get wanted fields from the clientData, convert TS String Objects
    // into normal strings and put everything into returnData
    foreach ($fields as $field) {
        $val = $clientData[$field];

        if ($val instanceof TeamSpeak3_Helper_String) {
            $val = (string) $val;
        }

        $ret[$field] = $val;
    }

    $ret["client_version_short"] = (string) TeamSpeak3_Helper_Convert::versionShort($ret["client_version"]);
    $ret["client_servergroups_list"] = array_map("intval", explode(",", $ret["client_servergroups"]));
    return $ret;
}
