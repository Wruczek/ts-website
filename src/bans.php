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
        // Bans abbreviations:
        // if we see a UID, IP or MyTSID ban, and we know
        // the nickname of the banned user, we will show
        // the user's name and then the type of ban
        // that should be enough info for most users.
        // it is possible to hover over the ban type to
        // view the exact ban target
        //
        // for example, Wruczek got banned on his UID. we know that
        // his last nickname was "Wruczek", so we simply show, that
        // the ban is issued for:
        // Wruczek (UID)
        // after hovering over the "UID", you will see the exact UID
        //
        // if we dont know the last name of the banned user, we
        // will just show the UID, IP or MyTSID

        $target = "(unknown)";
        $lastNickname = Utils::escape($ban["lastnickname"]);
        $filter = "";
        $abbreviation = null;

        if ($ban["ip"]) {
            $ip = str_replace("\\", "", (string)$ban["ip"]);

            try {
                $ip = Utils::censorIpAddress($ip);
            } catch (\Exception $e) {}

            if ($lastNickname) {
                $abbreviation = [$ip, "IP"];
            } else {
                $target = $ip;
            }

            if ($ip === Utils::getClientIp()) {
                $ipbanned = [
                    "invoker" => (string)$ban["invokername"],
                    "reason" => (string)$ban["reason"]
                ];
            }
        } else if ($ban["uid"]) {
            if ($lastNickname) {
                $abbreviation = [$ban["uid"], "UID"];
            } else {
                $target = new Html("<code>" . $ban["uid"] . "</code>");
            }
        } else if ($ban["name"]) {
            $target = $ban["name"];
        } else if (!empty($ban["mytsid"])) { // empty, older TS servers dont have MYTS bans, so the key might not exist
            if ($lastNickname) {
                $abbreviation = [$ban["mytsid"], "MyTSID"];
            } else {
                $target = new Html("<code>" . $ban["mytsid"] . "</code>");
            }
        }

        if ($abbreviation) {
            $html =  '%s (<span class="bans-highlight" data-toggle="tooltip" title="%s">%s</span>)';
            $target = new Html(sprintf($html, $lastNickname, $abbreviation[0], $abbreviation[1]));

            // make sure that the "full" data is also searchable in DataTables
            $filter = "{$abbreviation[0]} $lastNickname";
        }

        $data[] = [
            "filter" => $filter,
            "target" => $target,
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
