<?php

use Wruczek\TSWebsite\Auth;
use Wruczek\TSWebsite\Utils\ApiUtils;

require_once __DIR__ . "/../private/php/load.php";

ApiUtils::checkAuth();

$cldbid = Auth::getCldbid();

$uploadDir = __PRIVATE_DIR . "/uploads/avatars";
@mkdir($uploadDir, 0755, true);

if (!isset($_FILES["avatar"])) {
    ApiUtils::jsonError(["message" => "No file uploaded"], 400);
    exit;
}

$file = $_FILES["avatar"];
if ($file["error"] !== UPLOAD_ERR_OK) {
    ApiUtils::jsonError(["message" => "Upload error: " . $file["error"]], 400);
    exit;
}

$tmp = $file["tmp_name"];
$mime = @mime_content_type($tmp);
$allowed = ["image/png" => "png", "image/jpeg" => "jpg", "image/gif" => "gif", "image/webp" => "webp"];

if (!isset($allowed[$mime])) {
    ApiUtils::jsonError(["message" => "Unsupported file type"], 400);
    exit;
}

$ext = $allowed[$mime];
$dest = $uploadDir . "/" . $cldbid . "." . $ext;

// Remove previous avatars for this user
foreach (glob($uploadDir . "/" . $cldbid . ".*") as $old) { @unlink($old); }

if (!move_uploaded_file($tmp, $dest)) {
    ApiUtils::jsonError(["message" => "Failed to store file"], 500);
    exit;
}

ApiUtils::jsonSuccess(["url" => "api/getavatar.php?cldbid=" . $cldbid]);