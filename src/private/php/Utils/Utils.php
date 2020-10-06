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
    public static function escape(string $string): string {
        return htmlspecialchars($string, ENT_QUOTES, "UTF-8");
    }

    /**
     * Strips the first line from string
     * https://stackoverflow.com/a/7740485
     * @param $str
     * @return bool|string stripped text without the first line or false on failure
     */
    public static function stripFirstLine(string $str) {
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
    public static function startsWith(string $haystack, string $needle, bool $case = true): bool {
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
    public static function endsWith(string $haystack, string $needle, bool $case = true): bool {
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
    public static function censorIpAddress(string $ip): string {
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
    public static function getClientIp(bool $useCfip = null): string {
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
    public static function getNewsStore(): ?INewsStore {
        $newsStore = null;

        // if the current implementation is default
        if (true) {
            $newsStore = new DefaultNewsStore();
        }

        return $newsStore;
    }

    /**
     * Generate secure random int in specified bounds
     * @see \random_int()
     * @param int $min
     * @param int $max
     * @return int
     * @throws \Exception
     */
    public static function getSecureRandomInt(int $min, int $max): int {
        return \random_int($min, $max);
    }

    /**
     * Generate secure random bytes and convert them into hex
     * @see \random_bytes()
     * @see \bin2hex()
     * @param int $bytes
     * @return string
     * @throws \Exception
     */
    public static function getSecureRandomString(int $bytes): string {
        return \bin2hex(\random_bytes($bytes));
    }
}
