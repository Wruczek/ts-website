<?php
require_once __DIR__ . "/tsutils.php";
require_once __DIR__ . "/../lib/phpfastcache/autoload.php";



use phpFastCache\Util;
use phpFastCache\CacheManager;

Util\Languages::setEncoding("UTF-8");
$cache = CacheManager::Files();

$adminlist = $cache->get('adminlist');

// $cache->clean();

if (is_null($adminlist)) {
    $adminlist = array(getAdminList(), date('d-m-Y H:i:s'));
    $cache->set('adminlist', $adminlist, 30);
}


// FUNCTIONS

function getAdminList() {
    global $config;
    global $lang;

    $admingroups = $config["adminlist"];
    $localIcons = array(100, 200, 300, 400, 500, 600);

    try {
        $tsAdmin = TeamSpeak3::factory(getTeamspeakURI(). "#no_query_clients");

        $output = "";

        foreach ($admingroups as $group) {

            if(!array_key_exists((string) $group, $tsAdmin->serverGroupList()))
                continue;

            $group = $tsAdmin->serverGroupGetById($group);

            $icon = '';

            if($group["iconid"]) {
                if(!$group->iconIsLocal("iconid")) {
                    $groupicon = getGroupIcon($tsAdmin, $group);

                    if($groupicon) {
                        $icon = '<img src="data:' . TeamSpeak3_Helper_Convert::imageMimeType($groupicon) . ';base64,' . base64_encode($groupicon) . '" alt="Ikona grupy" /> ';
                    }
                } elseif(in_array($group["iconid"], $localIcons)) {
                    $icon = '<img src="lib/ts3phpframework/images/viewer/group_icon_' . $group["iconid"] . '.png" alt="Ikona grupy" /> ';
                }
            }

            $output .= "<p class=\"groupname\">$icon$group</p>";

            $clients = $group->clientList();

            if(empty($clients)) {
                $output .= '<p class="text-center"><i>' . translate($lang["adminlist"]["emptygroup"]) . '</i></p>';
                continue;
            }

            foreach ($clients as $userInfo) {
                $user = getClientByDbid($tsAdmin, $userInfo['cldbid']);

                if(!$user) {
                    $output .=  '<p><span class="label label-primary iconspacer">' . $userInfo['client_nickname'] . '</span><span class="label label-danger pullright">' . translate($lang["adminlist"]["status"]["offline"]) . '</span></p>';
                    continue;
                }

                $output .=  '<p><img src="lib/ts3phpframework/images/viewer/' . $user->getIcon() . '.png" alt="Status użytkownika">' . '<span class="label label-primary">' . $user . '</span>' . ($user['client_away'] ? '<span class="label label-warning pullright">' . translate($lang["adminlist"]["status"]["away"]) . '</span>' : '<span class="label label-success pullright">' . translate($lang["adminlist"]["status"]["online"]) . '</span>') . '</p>';
            }
        }

        return $output;
    } catch(TeamSpeak3_Exception $e) {
        return '<div class="alert alert-danger"><p class="text-center">' . translate($lang["general"]["scripterror"], [$e->getCode(), $e->getMessage()]) . '</p></div>';
    }

}

function getClientByDbid($tsAdmin, $cldbid) {
    try {
        return $tsAdmin->clientGetByDbid($cldbid);
    } catch(TeamSpeak3_Exception $e) {
        return false;
    }
}

function getGroupIcon($tsAdmin, $group) {
    try {
        return $group->iconDownload();
    } catch(TeamSpeak3_Exception $e) {
        return false;
    }
}

// echo getAdminList();
