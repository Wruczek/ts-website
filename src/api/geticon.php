<?php

use Wruczek\TSWebsite\ServerIconCache;

require_once __DIR__ . "/../private/php/load.php";

if (!isset($_GET["iconid"])) {
    http_response_code(400);
    echo "You need to provide an iconid";
    exit;
}

$iconId = $_GET["iconid"];

if (!is_numeric($iconId)) {
    http_response_code(400);
    echo "iconid need to be a numeric value";
    exit;
}

$iconId = (int) $iconId;

if (ServerIconCache::isLocal($iconId)) {
    header("Location: ../img/ts-icons/group_$iconId.svg");
    return;
}

$iconIdUnsigned = ServerIconCache::unsignIcon($iconId);
$iconData = ServerIconCache::getIconBytes($iconIdUnsigned);

if ($iconData === null) {
    http_response_code(404);
    echo "404 icon not found";
    exit;
}

header("Content-Type: " . TeamSpeak3_Helper_Convert::imageMimeType($iconData));
header('ETag: "' . $iconIdUnsigned . '"');
header('Cache-Control: only-if-cached');
echo $iconData;
