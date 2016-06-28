<?php
$bansPage = true;
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
    
    try {
        $tsAdmin = TeamSpeak3::factory(getTeamspeakURI(). "#no_query_clients");
        $serverGroupList = $tsAdmin->serverGroupList();
        
        $output = "";
        
        foreach ($serverGroupList as $group) {
            
            if(!isAdminGroup($group->getId()))
                continue;
            
            $output .= "<p class=\"groupname\">$group</p>";
            
            foreach ($group->clientList() as $userInfo) {
                $user = getClientByDbid($tsAdmin, $userInfo['cldbid']);
                
                if(!$user) {
                    $output .=  '<p><span class="label label-primary iconspacer">' . $userInfo['client_nickname'] . '</span><span class="label label-danger pullright">Offline</span></p>';
                    continue;
                }
                
                $output .=  '<p>' . '<img src="lib/ts3phpframework/images/viewer/' . $user->getIcon() . '.png">' . '<span class="label label-primary">' . $user . '</span>' . ($user['client_away'] ? '<span class="label label-warning pullright">Away</span>' : '<span class="label label-success pullright">Online</span>') . '</p>';
            }
        }
        
        return $output;
    } catch(TeamSpeak3_Exception $e) {
        return '<div class="alert alert-danger"><p class="text-center">Wystąpił błąd ' . $e->getCode() . ': ' . $e->getMessage() . '</p></div>';
    }
            
}

function isAdminGroup($groupid) {
    global $config;
    $admingroups = $config["adminlist"];
    
    return in_array($groupid, $admingroups);
}

function getClientByDbid($tsAdmin, $cldbid) {
    try {
        return $tsAdmin->clientGetByDbid($cldbid);
    } catch(TeamSpeak3_Exception $e) {
        return false;
    }
}

// echo getAdminList();
