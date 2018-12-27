<?php

namespace Wruczek\TSWebsite\Utils;


class CsrfUtils {

    /**
     * Generates and returns a new CSRF token
     * @param $length int length in bytes
     * @return string generated CSRF token
     * @throws \Exception when unable to generate a new token
     */
    public static function generateToken($length) {
        if (function_exists("random_bytes")) {
            $token = bin2hex(random_bytes($length));
        } else if (function_exists("mcrypt_create_iv")) {
            $token = bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        } else {
            $token = bin2hex(openssl_random_pseudo_bytes($length));
        }

        if (!is_string($token) || empty($token)) {
            throw new \Exception("Cannot generate new CSRF token");
        }

        return $token;
    }

    /**
     * Returns the current CSRF Token or creates a new one if needed.
     * @return string CSRF token
     * @throws \Exception When we cannot generate a new CSRF token
     */
    public static function getToken() {
        if (isset($_SESSION["csrfToken"])) {
            return $_SESSION["csrfToken"];
        }

        $length = 16; // in bytes
        $token = self::generateToken($length);

        $_SESSION["csrfToken"] = $token;
        return $token;
    }

    /**
     * Compares user-provided $token against the one we have.
     * @param $toCheck string token to be checked
     * @return bool true if tokens match, false otherwise.
     */
    public static function validateToken($toCheck) {
        $knownToken = @$_SESSION["csrfToken"];

        if ($knownToken === null) {
            return false;
        }

        return hash_equals($knownToken, $toCheck);
    }

    /**
     * Tries to get CSRF token from the request and then compares it.
     * If it fails, it returns the error page with message and exits the script.
     */
    public static function validateRequest() {
        if (isset($_POST["csrf-token"])) {
            $csrfToken = $_POST["csrf-token"];
        } else if (isset($_SERVER["HTTP_X_CSRF_TOKEN"])) {
            $csrfToken = $_SERVER["HTTP_X_CSRF_TOKEN"];
        }

        if (empty($csrfToken) || !self::validateToken($csrfToken)) {
            http_response_code(400);
            TemplateUtils::i()->renderErrorTemplate("", "Security error. Please go to the previous page and try again.", "CSRF token mismatch");
            exit;
        }
    }

}
