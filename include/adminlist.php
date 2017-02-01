<?php
require_once __DIR__ . "/tsutils.php";
require_once __DIR__ . "/cacheutils.class.php";

$cacheutils = new CacheUtils('adminlist');

if($cacheutils->isExpired()) {
    $cacheutils->setValue([getAdminList(), date('d-m-Y H:i:s')], 30);
}

$adminlist = $cacheutils->getValue();

// FUNCTIONS

function getAdminList() {
    global $config;
    global $lang;

    $admingroups = $config["adminlist"];
    $localIcons = array(100, 200, 300, 400, 500, 600);

    try {
        $tsAdmin = getTeamspeakConnection();

        $output = "";

        foreach ($admingroups as $group) {

            if (!array_key_exists((string)$group, $tsAdmin->serverGroupList()))
                continue;

            $group = $tsAdmin->serverGroupGetById($group);

            $icon = '';

            if ($group["iconid"]) {
                if (!$group->iconIsLocal("iconid")) {
                    $groupicon = getGroupIcon($tsAdmin, $group);

                    if ($groupicon) {
                        $icon = '<img src="data:' . TeamSpeak3_Helper_Convert::imageMimeType($groupicon) . ';base64,' . base64_encode($groupicon) . '" alt="Ikona grupy" /> ';
                    }
                } elseif (in_array($group["iconid"], $localIcons)) {
                    $icon = '<img src="lib/ts3phpframework/images/viewer/group_icon_' . $group["iconid"] . '.png" alt="Ikona grupy" /> ';
                }
            }

            $output .= "<p class=\"groupname\">$icon$group</p>";

            $clients = $group->clientList();

            if (empty($clients)) {
                $output .= '<p class="text-center"><i>' . translate($lang["adminlist"]["emptygroup"]) . '</i></p>';
                continue;
            }

            $onlineClients = [];
            $offlineClients = [];

            foreach ($clients as $userInfo) {
                $user = getClientByDbid($tsAdmin, $userInfo['cldbid']);

                if($user["client_type"]) continue;

                if (!$user) {
                    $offlineClients[] = '<p><span class="label label-primary iconspacer">' . $userInfo['client_nickname'] . '</span><span class="label label-danger pull-right">' . translate($lang["adminlist"]["status"]["offline"]) . '</span></p>';
                    continue;
                }

                $onlineClients[] = '<p><img src="lib/ts3phpframework/images/viewer/' . $user->getIcon() . '.png" alt="User status">' . '<span class="label label-primary">' . $user . '</span>' . ($user['client_away'] ? '<span class="label label-warning pull-right">' . translate($lang["adminlist"]["status"]["away"]) . '</span>' : '<span class="label label-success pull-right">' . translate($lang["adminlist"]["status"]["online"]) . '</span>') . '</p>';
            }

            foreach (array_merge($onlineClients, $offlineClients) as $str)
                $output .= $str;
        }

        return $output;
    } catch (TeamSpeak3_Exception $e) {
        return '<div class="alert alert-danger"><p class="text-center">' . translate($lang["general"]["scripterror"], [$e->getCode(), $e->getMessage()]) . '</p></div>';
    }

}

function getClientByDbid($tsAdmin, $cldbid) {
    try {
        return $tsAdmin->clientGetByDbid($cldbid);
    } catch (TeamSpeak3_Exception $e) {
        return false;
    }
}

function getGroupIcon($tsAdmin, $group) {
    try {
        return $group->iconDownload();
    } catch (TeamSpeak3_Exception $e) {
        return false;
    }
}

// echo getAdminList();
