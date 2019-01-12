<?php

namespace Wruczek\TSWebsite\Utils;

use Wruczek\TSWebsite\Config;
use Wruczek\TSWebsite\News\DefaultNewsStore;
use Wruczek\TSWebsite\News\INewsStore;

/**
 * Class Utils
 * @package Wruczek\TSWebsite\Utils
 * @author Wruczek 2017 - 2019
 */
class Utils {

    private function __construct() {}

    /**
     * Escapes HTML characters with htmlspecialchars
     * @param $string string String to be escaped
     * @return string escaped string
     */
    public static function escape($string) {
        return htmlspecialchars((string) $string, ENT_QUOTES, "UTF-8");
    }

    /**
     * Strips the first line from string
     * https://stackoverflow.com/a/7740485
     * @param $str
     * @return bool|string stripped text without the first line or false on failure
     */
    public static function stripFirstLine($str) {
        $position = strpos($str, "\n");

        if($position === false)
            return $str;

        return substr($str, $position + 1);
    }

    /**
     * Checks if $haystack starts with $needle
     * https://stackoverflow.com/a/860509
     * @param $haystack string
     * @param $needle string
     * @param bool $case set to false for case-insensitivity (default true)
     * @return bool true if $haystack starts with $needle, false otherwise
     */
    public static function startsWith($haystack, $needle, $case = true) {
        if ($case)
            return strpos($haystack, $needle, 0) === 0;

        return stripos($haystack, $needle, 0) === 0;
    }

    /**
     * Checks if $haystack ends with $needle
     * https://stackoverflow.com/a/860509
     * @param $haystack string
     * @param $needle string
     * @param bool $case set to false for case-insensitivity (default true)
     * @return bool true if $haystack ends with $needle, false otherwise
     */
    public static function endsWith($haystack, $needle, $case = true) {
        $expectedPosition = strlen($haystack) - strlen($needle);

        if ($case)
            return strrpos($haystack, $needle, 0) === $expectedPosition;

        return strripos($haystack, $needle, 0) === $expectedPosition;
    }

    /**
     * Returns IP address with last two octets replaced with "***"
     * @param $ip string IP to censor
     * @return bool|string Censored IP on success, false on failure
     * @throws \Exception When the IP address is invalid
     */
    public static function censorIpAddress($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $ip = explode(".", $ip);

            if (count($ip) >= 2) {
                return "{$ip[0]}.{$ip[1]}.***.***";
            }

            return "(IPv4)";
        }

        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ip = explode(":", $ip);

            if (count($ip) >= 2) {
                return "{$ip[0]}:{$ip[1]}:***:***";
            }

            return "(IPv6)";
        }

        throw new \Exception("Invalid IP address $ip");
    }

    /**
     * Returns client IP from REMOTE_ADDR or from HTTP_CF_CONNECTING_IP if using CF IP
     * @param bool $useCfip if true, check and use HTTP_CF_CONNECTING_IP header if present.
     *             Falls back to REMOTE_ADDR if empty
     * @return string IP address
     */
    public static function getClientIp($useCfip = null) {
        if ($useCfip === null) {
            $useCfip = Config::get("usingcloudflare");
        }

        // If IPv6 localhost, return IPv4 localhost
        if ($_SERVER["REMOTE_ADDR"] === "::1") {
            return "127.0.0.1";
        }

        if ($useCfip && !empty($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            return $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        return $_SERVER["REMOTE_ADDR"];
    }

    /**
     * Returns currently used news store
     * @return INewsStore|null
     */
    public static function getNewsStore() {
        $newsStore = null;

        // if the current implementation is default
        if (true) {
            $newsStore = new DefaultNewsStore();
        }

        return $newsStore;
    }
}
