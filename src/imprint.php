<?php

use Wruczek\TSWebsite\Utils\TemplateUtils;

require_once __DIR__ . "/private/php/load.php";

$data = [
    "pagetitle" => "Page",
    "paneltitle" => '<i class="far fa-id-card"></i>Imprint',
    "panelcontent" => "Imprint in <b>HTML</b> for countries that require it"
];

TemplateUtils::i()->renderTemplate("simple-page", $data);
