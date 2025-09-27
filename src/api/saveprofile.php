<?php

use Wruczek\TSWebsite\Auth;
use Wruczek\TSWebsite\ProfileStore;
use Wruczek\TSWebsite\Utils\ApiUtils;

define("DISABLE_CSRF_CHECK", false);

require_once __DIR__ . "/../private/php/load.php";

ApiUtils::checkAuth();

$cldbid = Auth::getCldbid();

$allowedKeys = [
    "steamid", "facebook", "twitter", "instagram", "telegram",
    "youtube", "steam", "github", "tiktok", "spotify", "twitch"
];

$data = [];
foreach ($allowedKeys as $k) {
    if (isset($_POST[$k])) {
        $v = trim((string) $_POST[$k]);
        $data[$k] = $v !== "" ? $v : null;
    }
}

ProfileStore::upsert($cldbid, $data);

ApiUtils::jsonSuccess(["saved" => true]);

