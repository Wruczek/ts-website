<?php

use Wruczek\TSWebsite\CacheManager;
use Wruczek\TSWebsite\ProfileStore;
use Wruczek\TSWebsite\Utils\TeamSpeakUtils;

require_once __DIR__ . "/../private/php/load.php";

if (!isset($_GET["cldbid"]) || !is_numeric($_GET["cldbid"])) {
    http_response_code(400);
    echo "Missing cldbid";
    exit;
}

$cldbid = (int) $_GET["cldbid"];

// 1) Prefer Steam avatar if steamid set
$profile = ProfileStore::getByCldbid($cldbid);
$steamId = $profile["steamid"] ?? null;

if ($steamId) {
    $steamApi = "https://steamcommunity.com/openid/id/$steamId"; // not direct JSON; we will try profile avatar via steamcommunity public
    // Try Steam Web API vanity? Without API key, fallback to Steam community public avatar via profile JSON endpoint
    $avatarUrl = null;
    $summaryUrl = "https://steamcommunity.com/profiles/$steamId/?xml=1";
    $xml = @simplexml_load_string(@file_get_contents($summaryUrl));
    if ($xml && isset($xml->avatarFull)) {
        $avatarUrl = (string) $xml->avatarFull;
    }
    if ($avatarUrl) {
        header("Location: $avatarUrl");
        exit;
    }
}

// 2) Try TeamSpeak avatar via filetransfer: avatars/uid
$client = CacheManager::i()->getClient($cldbid);
if ($client) {
    try {
        $uid = (string) $client["client_unique_identifier"];
        $path = "avatars/" . $uid;
        $bytes = TeamSpeakUtils::i()->ftDownloadFile($path);
        if ($bytes) {
            header("Content-Type: " . TeamSpeak3_Helper_Convert::imageMimeType($bytes));
            echo $bytes;
            exit;
        }
    } catch (Exception $e) {
        // ignore
    }
}

// 3) Fallback to default icon
header("Location: ../img/icons/defaulticon-64.png");

