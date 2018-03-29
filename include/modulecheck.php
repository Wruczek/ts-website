<?php

if (!defined("PHP_VERSION_ID") || PHP_VERSION_ID < 50500) {
    $title = 'Unsupported PHP version';

    $text =
        '<p>You are using old, unsupported PHP version.</p>' .
        '<p>Your PHP version: <b>' . PHP_VERSION . '</b>, required PHP version: <b>5.5.0</b>.</p>' .
        '<p>Please update your PHP installation and try again.</p>';

    showError($title, $text);
    exit;
}

if (!function_exists("utf8_encode")) {
    showExtensionMissingError("xml");
    exit;
}

if (!extension_loaded("json")) {
    showExtensionMissingError("json");
    exit;
}

if (!extension_loaded("mbstring")) {
    showExtensionMissingError("mbstring");
    exit;
}

if((fileperms(__DIR__ . '/../cache') & 0777) !== 0777) {
    $title = 'Cache directory is not writable';

    $text =
        '<p>Please make sure that the <code>cache</code> directory is fully readable, writable and executable.</p>' .
        '<p>Running: <code>sudo chmod 777 -R ' . realpath(__DIR__ . '/../cache') . '</code> should fix the problem.</p>';

    showError($title, $text);
    exit;
}

if (!file_exists(__DIR__ . "/../config/config.php")) {
    $title = 'config.php does not exists';

    $text =
        '<p>Please go into the directory <code>config</code> and rename <code>config.template.php</code> to <code>config.php</code>.</p>' .
        '<p>Edit the new file and tweak it to suite your needs.</p>';

    showError($title, $text);
    exit;
}



// FUNCTION

function showExtensionMissingError($extension_name) {
    $title = 'Required extension "' . $extension_name . '" is missing';

    $text = '<p>Required PHP extension <code>' . $extension_name . '</code> is missing or is not loaded.</p>
            <p>Install it and restart your server. Usually running <code>sudo apt-get install php-' . $extension_name . '</code> should be enough.<br>
            <p>If you still get this error, try restarting your web server and <code>php-fpm</code> service or just reboot your machine</p>
            <p>If you are using Web Hosting service, please contact their support for instructions on enabling <code>' . $extension_name . '</code> extension</p>';

    showError($title, $text);
}

function showError($title, $text) { ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Wruczek">

    <title><?php echo $title; ?></title>

    <!-- Icon -->
    <link rel="shortcut icon" href="https://assets-cdn.github.com/images/icons/emoji/unicode/26a0.png">

    <!-- Twitter Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/superhero/bootstrap.min.css" rel="stylesheet">

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body { margin-top: 70px }
    </style>
</head>

<body>
    <div class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><img src="https://assets-cdn.github.com/images/icons/emoji/unicode/26a0.png" width="20px" alt="Error"> <?php echo $title; ?></h3>
        </div>
        <div class="panel-body">
            <?php echo $text; ?>
        </div>
        <div class="panel-footer">
            &copy; <a href="https://wruczek.tech">Wruczek</a> 2016 - 2018 | <a href="https://github.com/Wruczek/ts-website">ts-website</a> v 1.4.5 | MIT License
        </div>
    </div>

    </div>
    <!-- /container -->
</body>

</html>
<?php }
