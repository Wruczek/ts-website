<?php

use Latte\Runtime\Html;
use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\CacheManager;
use Wruczek\TSWebsite\Utils\TemplateUtils;
use Wruczek\TSWebsite\Utils\Utils;

require_once __DIR__ . "/private/php/load.php";

$cache = new PhpFileCache(__CACHE_DIR, "banspage");

$banlist = CacheManager::i()->getBanList();
$data = null;
$ipbanned = false;

if ($banlist !== null) {
    $data = [];

    foreach ($banlist as $ban) {

        $name = "(cannot determine a name)";

        if ($ban["lastnickname"]) {
            $name = (string)$ban["lastnickname"];
        } else if ($ban["uid"]) {
            $name = new Html("<code>" . $ban["uid"] . "</code>");
        } else if ($ban["name"]) {
            $name = (string)$ban["name"];
        } else if ($ban["ip"]) {
            $ip = str_replace("\\", "", (string) $ban["ip"]);

            try {
                $name = Utils::censorIpAddress($ip);
            } catch (\Exception $e) {}

            if ($ip === Utils::getClientIp()) {
                $ipbanned = [
                    "invoker" => (string)$ban["invokername"],
                    "reason" => (string)$ban["reason"]
                ];
            }
        }

        $data[] = [
            "name" => $name,
            "reason" => (string)$ban["reason"],
            "invoker" => (string)$ban["invokername"],
            "created" => $ban["created"],
            "duration" => $ban["duration"]
        ];
    }
}

TemplateUtils::i()->renderTemplate("bans", [
    "banlist" => $data,
    "ipbanned" => $ipbanned
]);
