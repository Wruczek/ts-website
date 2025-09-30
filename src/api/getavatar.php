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

// 1) Try uploaded avatar file
$uploadDir = __DIR__ . "/../private/uploads/avatars";
$uploaded = null;
foreach (["png","jpg","jpeg","gif","webp"] as $ext) {
    $p = $uploadDir . "/" . $cldbid . "." . $ext;
    if (file_exists($p)) { $uploaded = $p; break; }
}
if ($uploaded) {
    $bytes = @file_get_contents($uploaded);
    if ($bytes !== false) {
        header("Content-Type: " . TeamSpeak3_Helper_Convert::imageMimeType($bytes));
        echo $bytes;
        exit;
    }
}

// 2) Try avatar URL saved in profile
try { $profile = ProfileStore::getByCldbid($cldbid); } catch (\Throwable $e) { $profile = []; }
$avatarUrl = $profile["avatar_url"] ?? null;
if ($avatarUrl) {
    header("Location: " . $avatarUrl);
    exit;
}

// 3) Try TeamSpeak avatar via filetransfer: avatars/uid
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

// 4) Fallback to default icon
header("Location: ../img/icons/defaulticon-64.png");

