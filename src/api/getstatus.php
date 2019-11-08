<?php

use Wruczek\TSWebsite\CacheManager;
use Wruczek\TSWebsite\Config;

require_once __DIR__ . "/../private/php/load.php";

$sinfoMeta = CacheManager::i()->getServerInfo(true); // Server info + cache meta
$sinfo = $sinfoMeta["data"]; // Server info array

$returnJson = ["success" => false, "generated" => $sinfoMeta["time"]];

if ($sinfo !== null) {
    // START Online Record
    $onlineNow = $sinfo["virtualserver_clientsonline"] - $sinfo["virtualserver_queryclientsonline"];
    $onlineRecord = (int) Config::get("onlinerecord_value");
    $onlineRecordDate = (int) Config::get("onlinerecord_date");

    if ($onlineNow > $onlineRecord) {
        $onlineRecord = $onlineNow;
        $onlineRecordDate = time();

        Config::i()->setValue("onlinerecord_value", $onlineRecord);
        Config::i()->setValue("onlinerecord_date", $onlineRecordDate);
    }
    // END Online Record

    $returnJson["success"] = true;
    $returnJson["data"] = [
        "uid" => (string) $sinfo["virtualserver_unique_identifier"],
        "name" => (string) $sinfo["virtualserver_name"],
        "nicknames" => (string) @$sinfo["virtualserver_nickname"],
        "channelCount" => $sinfo["virtualserver_channelsonline"],
        "serverIconId" => $sinfo["virtualserver_icon_id"],
        "clientsOnline" => $onlineNow,
        "maxClients" => $sinfo["virtualserver_maxclients"],
        "reservedSlots" => $sinfo["virtualserver_reserved_slots"],
        "onlineRecord" => $onlineRecord,
        "onlineRecordDate" => $onlineRecordDate,
        "version" => (string) TeamSpeak3_Helper_Convert::versionShort($sinfo["virtualserver_version"]),
        "platform" => (string) $sinfo["virtualserver_platform"],
        "uptime" => $sinfo["virtualserver_uptime"],
        "uptimeFormatted" => describeSeconds($sinfo["virtualserver_uptime"]),
        "averagePacketloss" => (float) ((string) $sinfo["virtualserver_total_packetloss_total"]),
        "averagePing" => (float) ((string) $sinfo["virtualserver_total_ping"])
    ];
}

header("Content-Type: application/json");
echo json_encode($returnJson);

function describeSeconds($seconds) {
    return TeamSpeak3_Helper_Convert::seconds($seconds, false, "%dd %02dh %02dm");
}
