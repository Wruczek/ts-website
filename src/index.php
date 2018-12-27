<?php

use Wruczek\TSWebsite\Utils\TemplateUtils;
use Wruczek\TSWebsite\Utils\Utils;

require_once __DIR__ . "/private/php/load.php";

$newsStore = Utils::getNewsStore();

$perPage = 5; // news per page can be easily changed here, the rest of the code will adapt
$page = 1;    // starting page, if none provided

if (isset($_GET["page"])) {
    $page = (int) $_GET["page"];
}

$newsCount = $newsStore->getNewsCount();
$pageCount = (int) ceil($newsCount / $perPage);
$newsList = [];

// Fetch the news if we are on page 1 or higher
// pages 0 or lower are invalid. Otherwise newsList will be NULL
// and the template will show an invalid page message
if ($page >= 1) {
    try {
        $newsList = $newsStore->getNewsList($perPage, ($page - 1) * $perPage);
    } catch (\Exception $e) {
        $newsList = false;
    }
}

TemplateUtils::i()->renderTemplate("index", [
    "newsCount" => $newsCount,
    "pageCount" => $pageCount,
    "newsList" => $newsList,
    "currentPage" => $page,
]);
