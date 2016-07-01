<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . "/../lib/ts3phpframework/libraries/TeamSpeak3/TeamSpeak3.php";

function pingTeamspeakServerFromConfig() {
    return pingTeamspeakServer(getTeamspeakURI() . "&use_offline_as_virtual=1&no_query_clients=1");
}

function pingTeamspeakServer($uri) {
    try {
        $tsAdmin = TeamSpeak3::factory($uri);

        if(!$tsAdmin->getProperty("virtualserver_status"))
            throw new Exception("Server is offline");

        return $tsAdmin->getInfo();
    } catch(TeamSpeak3_Exception $e) {
        return false;
    }

}

function getTeamspeakURI() {
    global $config;
    $host   = $config['teamspeak']['host'];
    $login  = $config['teamspeak']['login'];
    $passwd = $config['teamspeak']['password'];
    $sport  = $config['teamspeak']['server_port'];
    $qport  = $config['teamspeak']['query_port'];
    return "serverquery://$login:$passwd@$host:$qport/?server_port=$sport";
}
