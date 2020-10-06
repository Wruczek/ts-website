<?php

namespace Wruczek\TSWebsite\Utils;

class CsrfUtils {

    public const CSRF_TOKEN_BYTES_LENGTH = 32;

    /**
     * Generates and returns a new CSRF token
     * @param $bytes int length in bytes
     * @return string generated CSRF token
     * @throws \Exception when unable to generate a new token
     */
    public static function generateToken(int $bytes): string {
        return Utils::getSecureRandomString($bytes);
    }

    /**
     * Returns the current CSRF Token or creates a new one if needed.
     * @return string CSRF token
     * @throws \Exception When we cannot generate a new CSRF token
     */
    public static function getToken(): string {
        if (isset($_SESSION["csrfToken"])) {
            return $_SESSION["csrfToken"];
        }

        $token = self::generateToken(self::CSRF_TOKEN_BYTES_LENGTH);

        $_SESSION["csrfToken"] = $token;
        return $token;
    }

    /**
     * Compares user-provided $token against the one we have.
     * @param $toCheck string token to be checked
     * @return bool true if tokens match, false otherwise.
     */
    public static function validateToken(string $toCheck): bool {
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
    public static function validateRequest(): void {
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
