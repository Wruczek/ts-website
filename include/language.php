<?php
session_start();
header('Cache-control: private');

if (isset($_GET['lang'])) {
    $langcode = $_GET['lang'];

    $_SESSION['lang'] = $langcode;

    setcookie('lang', $langcode, time() + (3600 * 24 * 60));
} else if (isset($_SESSION['lang'])) {
    $langcode = $_SESSION['lang'];
} else if (isset($_COOKIE['lang'])) {
    $langcode = $_COOKIE['lang'];
} else if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $langcode = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
} else {
    $langcode = "en";
}

if(!file_exists(getLanguagePath($langcode)))
    $langcode = "en";

require_once getLanguagePath($langcode);

function getLanguagePath($langcode) {
    return __DIR__ . '/../config/languages/lang.' . $langcode . '.php';
}

function tl($pattern, $args = null) {
    echo translate($pattern, $args);
}

function translate($pattern, $args = null) {

    if(!$args) {
        return $pattern;
    }

    $size = count($args);

    for ($i = 0; $i < $size; $i++) {
        $pattern = str_ireplace('{' . $i . '}', $args[$i], $pattern);
    }

    return $pattern;
}
