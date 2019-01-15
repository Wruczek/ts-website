<?php
define("__TSWEBSITE_VERSION",   "dev-2.0.2");
define("__TSWEBSITE_COMMIT",    "no-commit");
define("__BASE_DIR",            __DIR__ . "/../..");
define("__PRIVATE_DIR",         __BASE_DIR . "/private");
define("__CACHE_DIR",           __PRIVATE_DIR . "/cache");
define("__TEMPLATES_DIR",       __PRIVATE_DIR . "/templates");
define("__CONFIG_FILE",         __PRIVATE_DIR . "/dbconfig.php");
define("__LOCALDB_FILE",        __PRIVATE_DIR . "/.sqlite.db.php");
define("__INSTALLER_LOCK_FILE", __PRIVATE_DIR . "/INSTALLER_LOCK");
define("__DEV_MODE",            defined("DEV_MODE") || getenv("DEV_MODE") || file_exists(__PRIVATE_DIR . "/dev_mode"));

// utf8_encode polyfill - function required by TS3PHPFramework
// Taken from: https://github.com/symfony/polyfill (MIT License)
if (!function_exists("utf8_encode")) {
    define("__USING_U8ENC_POLYFILL", true);
    function utf8_encode($s) {
        $s .= $s;
        $len = strlen($s);
        for ($i = $len >> 1, $j = 0; $i < $len; ++$i, ++$j) {
            switch (true) {
                case $s[$i] < "\x80": $s[$j] = $s[$i]; break;
                case $s[$i] < "\xC0": $s[$j] = "\xC2"; $s[++$j] = $s[$i]; break;
                default: $s[$j] = "\xC3"; $s[++$j] = chr(ord($s[$i]) - 64); break;
            }
        }
        return substr($s, 0, $j);
    }
}
