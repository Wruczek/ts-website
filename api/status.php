<?php
// error_reporting(0);
header('Content-Type: application/json');
set_error_handler("exception_error_handler", E_ALL);

require_once __DIR__ . "/../include/tsutils.php";
require_once __DIR__ . "/../lib/phpfastcache/autoload.php";

use phpFastCache\Util;
use phpFastCache\CacheManager;

Util\Languages::setEncoding("UTF-8");
$cache = CacheManager::Files();

$serverstatus = $cache->get('serverstatus');

// $cache->clean();

if (is_null($serverstatus)) {
    $serverstatus = getResult();
    $cache->set('serverstatus', $serverstatus, 10);
}

die ($serverstatus);

// *********
//  METHODS
// *********

function getResult() {
    try {
        $start = microtime(true);

        $tsstatus = getTeamspeakServerStatus();

        $stop = microtime(true);

        return json_encode(array(
            "tsstatus" => $tsstatus,
            "generated" => date('d-m-Y H:i:s')
        ));
    } catch (Exception $e) {
        scriptFail($e);
    }
}

function scriptFail($error) {
    die(json_encode(array(
        "success" => false,
        "id" => "script_error",
        "message" => "There has been an error while retrieving the server status"
        ,"error" => $error
    )));
}

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    scriptFail("[$errfile @ $errline] " . $errstr);
}

function getTeamspeakServerStatus() {

    $response = pingTeamspeakServerFromConfig();

    if ($response) {
        return array(
            "success"           => $response["virtualserver_status"]->toString() == "online",
            "name"              => $response["virtualserver_name"]->toString(),
            "clientsonline"     => $response["virtualserver_clientsonline"] - $response["virtualserver_queryclientsonline"],
            "maxclients"        => $response["virtualserver_maxclients"],
            "version"           => TeamSpeak3_Helper_Convert::versionShort($response["virtualserver_version"]->toString())->toString(),
            "platform"          => $response["virtualserver_platform"]->toString(),
            "uptime"            => TeamSpeak3_Helper_Convert::seconds($response["virtualserver_uptime"], false, "%dd %02dh %02dm"),
            "averagePacketloss" => $response["virtualserver_total_packetloss_total"]->toString(),
            "averagePing"       => $response["virtualserver_total_ping"]->toString()
        );
    } else {
        return array(
            "success" => false,
            "id" => "not_responding",
            "message" => "Server is not responding"
        );
    }
}
