<?php

use Wruczek\TSWebsite\Auth;
use Wruczek\TSWebsite\ProfileStore;
use Wruczek\TSWebsite\Utils\TemplateUtils;

require_once __DIR__ . "/private/php/load.php";

if (!Auth::isLoggedIn()) {
    TemplateUtils::i()->renderErrorTemplate("401", "Unauthorized", "You need to be logged in to edit your profile.");
    exit;
}

$cldbid = Auth::getCldbid();
$profile = ProfileStore::getByCldbid($cldbid);

TemplateUtils::i()->renderTemplate("edit-profile", [
    "title" => "Edit Profile",
    "profile" => $profile,
]);

