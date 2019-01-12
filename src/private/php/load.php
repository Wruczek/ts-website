<?php

use Wruczek\TSWebsite\Config;
use Wruczek\TSWebsite\ServerIconCache;
use Wruczek\TSWebsite\Utils\CsrfUtils;
use Wruczek\TSWebsite\Utils\Language\LanguageUtils;
use Wruczek\TSWebsite\Utils\Utils;

session_name("tswebsite_sessionid");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("__RENDER_START", microtime(true));

require_once __DIR__ . "/constants.php";

@header("TSW_DevMode: " . (__DEV_MODE ? "enabled" : "disabled"));

if(__DEV_MODE) {
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);
}

if(!file_exists(__INSTALLER_LOCK_FILE)) {
    if(file_exists(__BASE_DIR . "/installer")) {
        header("Location: installer/index.php");
    } else {
        echo '&#129300; Something is not right! Looks like the website is not installed ("private/INSTALLER_LOCK" not found or is empty), but ' .
            'installation wizard folder "installer" cannot be found! Please start the installation again and follow installation guide step-by-step.';
    }

    exit;
}

require_once __PRIVATE_DIR . "/vendor/autoload.php";

// Check CSRF token if needed and validate it
if (!defined("DISABLE_CSRF_CHECK") &&
    in_array($_SERVER["REQUEST_METHOD"], ["POST", "PUT", "DELETE", "PATCH"])
) {
    CsrfUtils::validateRequest();
}

// Try to guess user language and store it
// If the current language is not defined, or is invalid then return to default
if(!isset($_SESSION["userlanguageid"])) {
    $lang = LanguageUtils::i()->detectUserLanguage();

    if(!$lang) {
        $lang = LanguageUtils::i()->getDefaultLanguage();
    }

    $_SESSION["userlanguageid"] = $lang->getLanguageId();
}

// Shortcut to language functions
{
    /**
     * Shortcut to translate and output the result
     */
    function __($identifier, $args = []) {
        echo __get($identifier, $args);
    }

    /**
     * Shortcut to translate and return the result
     */
    function __get($identifier, $args = []) {
        try {
            return LanguageUtils::i()->translate($identifier, $args);
        } catch (\Exception $e) {
            return "(unknown translation for " . Utils::escape($identifier) . ")";
        }
    }
}

// Set timezone
date_default_timezone_set(Config::get("timezone"));

// Init TS3 library
// This makes it possible to cache TS3 library objects
TeamSpeak3::init();

// Sync server icon cache if needed
ServerIconCache::syncIfNeeded();
