<?php

use Wruczek\TSWebsite\Utils\TemplateUtils;

require_once __DIR__ . "/private/php/load.php";

TemplateUtils::i()->renderErrorTemplate("404", "Page not found");
