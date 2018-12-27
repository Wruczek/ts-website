<?php

namespace Wruczek\TSWebsite\Utils;

use function is_array;
use Wruczek\TSWebsite\Auth;

class ApiUtils {

    /**
     * Checks if the user is logged in, and if not outputs a JSON error and terminates the script
     */
    public static function checkAuth() {
        if (!Auth::isLoggedIn()) {
            self::jsonError("You must be logged in to perform this action", "NOT_AUTHENTICATED", 401);
            exit;
        }
    }

    /**
     * Calls jsonResponse with true as success parameter
     */
    public static function jsonSuccess($data = null, $code = null, $statusCode = null) {
        self::jsonResponse(true, $data, $code, $statusCode);
    }

    /**
     * Calls jsonResponse with false as success parameter
     */
    public static function jsonError($data = null, $code = null, $statusCode = null) {
        self::jsonResponse(false, $data, $code, $statusCode);
    }

    /**
     * Outputs json with key "success" set to the $success parameter.
     * If $data is null, it skips it. If data is a string, it adds
     * it to the json with key "message".
     * If $data is an array, it merges it with the success key.
     * Else it sets key "data" to $data
     * @param $success bool
     * @param $data null|string|array
     * @param $code int|string error code
     * @param $statusCode int Status code to return. null to not change
     */
    public static function jsonResponse($success, $data = null, $code = null, $statusCode = null) {
        if (!is_bool($success)) {
            throw new \InvalidArgumentException("success must be a boolean");
        }

        $json = ["success" => $success];

        if ($code !== null) {
            $json["code"] = $code;
        }

        if (is_string($data)) {
            $json["message"] = $data;
        } else if (is_array($data)) {
            $json = array_merge($json, $data);
        } else if($data !== null) {
            $json["data"] = $data;
        }

        if (is_int($statusCode)) {
            @http_response_code($statusCode);
        }

        self::outputJson($json);
    }

    public static function outputJson($array) {
        @header("Content-Type: application/json");
        echo json_encode($array);
    }

    public static function getPostParam($key) {
        return self::getParam($_POST, $key);
    }

    public static function getGetParam($key) {
        return self::getParam($_GET, $key);
    }

    /**
     * Returns $array[$key] if exists, otherwise throws an jsonerror and
     * terminates the script
     * @param $array array
     * @param $key string
     * @param $canBeArray bool whenever the data can be an array
     * @return mixed
     */
    public static function getParam($array, $key, $canBeArray = false) {
        if (!isset($array[$key])) {
            self::jsonError("Parameter $key is not provided", 400);
            exit;
        }

        $data = $array[$key];

        if (is_array($data) && !$canBeArray) {
            self::jsonError("Parameter $key cannot be an array", 400);
            exit;
        }

        return $data;
    }

}
