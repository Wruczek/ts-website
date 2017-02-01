<?php

function isPHPVersionSupported() {
    if (!defined('PHP_VERSION_ID')) {
        $version = explode('.', PHP_VERSION);
        define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
    }

    return PHP_VERSION_ID >= 50500;
}

if (!isPHPVersionSupported()) {
    $title = 'Unsupported PHP version';

    $text = '<p>You are using old, unsupported PHP version.</p><p>Your PHP version: <b>' . phpversion() . '</b>, required PHP version: <b>5.5.0</b>.</p><p>Please update your PHP installation and try again.</p>';

    showError($title, $text);
    die();
}

if (!function_exists("utf8_encode")) {
    $title = 'Required function "utf8_encode" is missing';

    $text = '<p>Required PHP extension: <code>mbstring</code> has not been found on the server.</p>
            <p>For PHP 7.0 (recommended), install this package: <code>sudo apt-get install php-xml php7.0-xml</code> and <u>restart apache</u>. Otherwise, installation instructions can be found <a href="https://www.google.com/?q=Call%20to%20undefined%20function%20utf8_encode()">on Google</a> ;)</p>
            <p>If you are using Web Hosting service, please contact the Hosting support for instruction on enabling needed packages.</p>';

    showError($title, $text);
    die();
}

if(!is_writable(__DIR__ . '/../cache')) {
    $title = 'Cache directory is not writable';
    $text = '<p>Please make sure that the <code>cache</code> directory is fully writable.</p>';
    showError($title, $text);
    die();
}

if (!file_exists(__DIR__ . "/../config/config.php")) {
    $title = 'config.php does not exists';

    $text = '<p>Please go into the directory <code>config</code> and rename <code>config.template.php</code> to <code>config.php</code>.</p>
            <p>Edit the new file and tweak it to suite your needs.</p>';

    showError($title, $text);
    die();
}


// FUNCTION

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
            &copy; <a href="https://wruczek.tech">Wruczek</a> 2016 - 2017 | <a href="https://github.com/Wruczek/ts-website">ts-website</a> v 1.4.1 | MIT License
        </div>
    </div>

    </div>
    <!-- /container -->
</body>

</html>
<?php }
