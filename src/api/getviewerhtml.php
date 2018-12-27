<?php

use Wruczek\TSWebsite\ViewerRenderer;

require_once __DIR__ . "/../private/php/load.php";

$html = null;
$viewerRenderer = new ViewerRenderer("img/ts-icons");

if ($viewerRenderer->checkRequiredData()) {
    $html = $viewerRenderer->renderViewer();
}

echo $html;
