<?php

use Wruczek\TSWebsite\Utils\Language\LanguageUtils;

require_once __DIR__ . "/../private/php/load.php";

if (empty($_POST["lang"])) {
    http_response_code(400);
    echo 'Required post parameter "lang" not set or is empty';
    exit;
}

$lang = LanguageUtils::i()->getLanguageByCode($_POST["lang"]);

if ($lang === null) {
    http_response_code(400);
    echo 'Invalid language code';
    exit;
}

setcookie("tswebsite_language", $lang->getLanguageCode(), time() + (60 * 60 * 24) * 60, "/"); // 60 days
$_SESSION["userlanguageid"] = $lang->getLanguageId();

$returnTo = "../";

if (!empty($_POST["return-to"])) {
    // Check if the address start with a "/" and is not for example with "http://evilwebsite.com"
    if (mb_strpos($_POST["return-to"], "/") === 0) {
        $returnTo = $_POST["return-to"];
    }
}

header("Location: $returnTo");
