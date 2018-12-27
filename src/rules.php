<?php

use Wruczek\TSWebsite\Utils\TemplateUtils;

require_once __DIR__ . "/private/php/load.php";

$data = [
    "pagetitle" => __get("RULES_TITLE"),
    "navActiveIndex" => 4,
    "paneltitle" => '<i class="fas fa-book"></i>' . __get("RULES_PANEL_TITLE"),
    "panelcontent" => "Rules in <b>HTML</b>"
];

TemplateUtils::i()->renderTemplate("simple-page", $data);
