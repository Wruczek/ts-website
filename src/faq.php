<?php

use Wruczek\TSWebsite\Utils\DatabaseUtils;
use Wruczek\TSWebsite\Utils\TemplateUtils;

require_once __DIR__ . "/private/php/load.php";

$db = DatabaseUtils::i()->getDb();
$qa = $db->select("faq", "*");

$data = [
    "additionaltext" => '<div class="alert alert-info"><i class="fas fa-info-circle"></i>If you have any more questions feel free to <a href="#">contact us</a></div>',
    "qa" => $qa
];

TemplateUtils::i()->renderTemplate("faq", $data);
