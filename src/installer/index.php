<?php
require_once __DIR__ . "/../private/php/constants.php";

if(file_exists(__INSTALLER_LOCK_FILE) && filesize(__INSTALLER_LOCK_FILE) > 1) {
    die('File "private/INSTALLER_LOCK" exists. Please remove it if you wish to run the installer again.');
}

if (!file_exists(__PRIVATE_DIR . "/vendor/autoload.php")) {
    die(
        '<h2>Oops! We cannot find Composer\'s autoload file.</h2>' .
        '<h3>In 2.0, the installation procedure is a little different. Go to the ' .
        '<a href="https://github.com/Wruczek/ts-website/wiki/%5BEN%5D-Website-Installation" target="_blank">wiki</a> ' .
        'and follow the installation tutorial.</h3>' .
        'Or, if you know what you are doing, run <code>composer update</code> in the ' .
        '<code>' . realpath(__BASE_DIR) . '</code> directory'
    );
}

ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
set_time_limit(0);

$stepNumber = empty($_GET["step"]) || !file_exists(__DIR__ . "/pages/" . (int)$_GET["step"] . ".php") ? 1 : (int) $_GET["step"];

ob_start();
require __DIR__ . "/pages/$stepNumber.php";
$pageContent = ob_get_clean();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Step <?= $stepNumber ?> | TS-website 2.0 Installer</title>

    <!-- Bootswatch Lumen 4.1.3 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.1.3/lumen/bootstrap.min.css"
          integrity="sha256-S3sZnj5Uxoan2Z6rfF8V+lCFpdDl06yG+3aem63aLmE=" crossorigin="anonymous">

    <!-- Bootstrap nav wizard -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/gh/acornejo/bootstrap-nav-wizard@fd0d42fe0c0826e2c753fb67ce7b50c9e7374d56/bootstrap-nav-wizard.min.css"
          integrity="sha384-GKSXH8/4s0+zixsbqq0nRRjTCg0PT0t9vSofdQ15kK57B4AJIYjpHA6QQH2GdSoz"
          crossorigin="anonymous">

    <!-- FontAwesome (CSS) 5.2.0 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
          integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- Custom styles -->
    <link rel="stylesheet" href="style.css">

    <!-- jQuery 3.3.1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <!-- Popper UMD 1.13.0 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"
            integrity="sha256-pS96pU17yq+gVu4KBQJi38VpSuKN7otMrDQprzf/DWY=" crossorigin="anonymous"></script>

    <!-- Bootstrap 4.1.3 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha256-VsEqElsCHSGmnmHXGQzvoWjWwoznFSZc6hs7ARLRacQ=" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">

    <div class="text-center">
        <h1 class="m-5">TS-website 2.0 Installer</h1>
    </div>

    <div class="text-center">
        <ul class="nav nav-wizard">
            <li<?= $stepNumber == 1 ? ' class="active"' : "" ?>><a href="#">Introduction</a></li>
            <li<?= $stepNumber == 2 ? ' class="active"' : "" ?>><a href="#">Requirements check</a></li>
            <li<?= $stepNumber == 3 ? ' class="active"' : "" ?>><a href="#">Database details</a></li>
            <li<?= $stepNumber == 4 ? ' class="active"' : "" ?>><a href="#">Query details</a></li>
            <li<?= $stepNumber == 5 ? ' class="active"' : "" ?>><a href="#">Securing web server</a></li>
            <li<?= $stepNumber == 6 ? ' class="active"' : "" ?>><a href="#">Configure your site</a></li>
            <li<?= $stepNumber == 7 ? ' class="active"' : "" ?>><a href="#">Finish</a></li>
        </ul>
    </div>

    <?= $pageContent ?>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({"html": true, "placement": "right"})
    })
</script>

</body>
</html>
