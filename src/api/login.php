<?php

use Wruczek\TSWebsite\Auth;
use Wruczek\TSWebsite\Utils\ApiUtils;

require_once __DIR__ . "/../private/php/load.php";

$method = ApiUtils::getPostParam("method");

if ($method === "logout") {
    Auth::logout();
    ApiUtils::jsonSuccess();
} else if ($method === "getclients") {
    $users = Auth::getTsUsersByIp();

    if ($users === null) {
        ApiUtils::jsonError("Cannot retrieve client list", "ERROR_CLIENT_LIST");
    } else {
        ApiUtils::jsonSuccess(["data" => $users]);
    }
} else if ($method === "selectaccount") {
    $cldbid = (int) ApiUtils::getPostParam("cldbid");

    if (!Auth::checkClientIp($cldbid)) {
        ApiUtils::jsonError("User not found", "USER_NOT_FOUND");
        exit;
    }

    if (Auth::getConfirmationCode($cldbid) !== null) {
        ApiUtils::jsonError("Code is already generated for this user", "CODE_ALREADY_GENERATED");
        exit;
    }

    $code = Auth::generateConfirmationCode($cldbid);

    if ($code === null) {
        ApiUtils::jsonError("User not found", "USER_NOT_FOUND");
    } else if ($code === false) {
        ApiUtils::jsonError("Error sending code. Try again.", "ERROR_SENDING_CODE");
    } else {
        ApiUtils::jsonSuccess();
    }
} else if ($method === "login") {
    if (Auth::isLoggedIn()) {
        ApiUtils::jsonError("You are already logged in", "ALREADY_AUTHENTICATED");
        exit;
    }

    $code = ApiUtils::getPostParam("code");
    $cldbid = (int) ApiUtils::getPostParam("cldbid");

    if (Auth::checkCodeAndLogin($cldbid, $code)) {
        ApiUtils::jsonSuccess();
    } else {
        ApiUtils::jsonError("Invalid or expired code", "INVALID_CODE");
    }
} else {
    ApiUtils::jsonError("Invalid method name", "INVALID_METHOD");
}
