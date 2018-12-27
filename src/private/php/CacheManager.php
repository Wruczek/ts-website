<?php

namespace Wruczek\TSWebsite;

use Wruczek\PhpFileCache\PhpFileCache;
use Wruczek\TSWebsite\Utils\SingletonTait;
use Wruczek\TSWebsite\Utils\TeamSpeakUtils;

class CacheManager {
    use SingletonTait;

    private $cache;

    private $serverInfo;
    private $banList;
    private $clientList;
    private $channelList;
    private $serverGroupList;
    private $channelGroupList;

    public function __construct() {
        $this->cache = new PhpFileCache(__CACHE_DIR, "cachemanager");
    }

    private function tsNodeObjectToArray(array $object, $extendInfo = false) {
        if (!is_array($object)) {
            throw new \Exception("object must be a array filled with TeamSpeak3_Node_Abstract objects");
        }

        $data = [];

        foreach ($object as $obj) {
            $data[$obj->getId()] = $obj->getInfo($extendInfo);
        }

        return $data;
    }

    public function getServerInfo($meta = false) {
        if ($this->serverInfo) {
            return $this->serverInfo;
        }

        return $this->serverInfo = $this->cache->refreshIfExpired("serverinfo", function () {
            if(TeamSpeakUtils::i()->checkTSConnection()) {
                try {
                    return TeamSpeakUtils::i()->getTSNodeServer()->getInfo();
                } catch (\TeamSpeak3_Exception $e) {
                    TeamSpeakUtils::i()->addExceptionToExceptionsList($e);
                }
            }
            return null;
        }, Config::get("cache_serverinfo"), $meta);
    }

    public function getBanList($meta = false) {
        if ($this->banList) {
            return $this->banList;
        }

        return $this->banList = $this->cache->refreshIfExpired("banlist", function () {
            if(TeamSpeakUtils::i()->checkTSConnection()) {
                try {
                    return TeamSpeakUtils::i()->getTSNodeServer()->banList();
                } catch (\TeamSpeak3_Exception $e) {
                    if ($e->getCode() === 1281) { // database empty result set
                        return [];
                    }

                    TeamSpeakUtils::i()->addExceptionToExceptionsList($e);
                }
            }
            return null;
        }, Config::get("cache_banlist"), $meta);
    }

    public function getClientList($meta = false) {
        if ($this->clientList) {
            return $this->clientList;
        }

        return $this->clientList = $this->cache->refreshIfExpired("clientlist", function () {
            if(TeamSpeakUtils::i()->checkTSConnection()) {
                try {
                    return $this->tsNodeObjectToArray(TeamSpeakUtils::i()->getTSNodeServer()->clientList());
                } catch (\TeamSpeak3_Exception $e) {
                    TeamSpeakUtils::i()->addExceptionToExceptionsList($e);
                }
            }
            return null;
        }, Config::get("cache_clientlist"), $meta); // Lower cache time because of login system
    }
    
    public function getClient($cldbid) {
        $clients = $this->getClientList();

        if ($clients === null) {
            return null;
        }

        foreach ($clients as $client) {
            if ($client["client_database_id"] === $cldbid) {
                return $client;
            }
        }

        return null;
    }

    public function getChannelList($meta = false) {
        if ($this->channelList) {
            return $this->channelList;
        }

        return $this->channelList = $this->cache->refreshIfExpired("channellist", function () {
            if(TeamSpeakUtils::i()->checkTSConnection()) {
                try {
                    return $this->tsNodeObjectToArray(TeamSpeakUtils::i()->getTSNodeServer()->channelList());
                } catch (\TeamSpeak3_Exception $e) {
                    TeamSpeakUtils::i()->addExceptionToExceptionsList($e);
                }
            }
            return null;
        }, Config::get("cache_channelist"), $meta);
    }

    public function getServerGroupList($meta = false) {
        if ($this->serverGroupList) {
            return $this->serverGroupList;
        }

        return $this->serverGroupList = $this->cache->refreshIfExpired("servergrouplist", function () {
            if(TeamSpeakUtils::i()->checkTSConnection()) {
                try {
                    return $this->tsNodeObjectToArray(TeamSpeakUtils::i()->getTSNodeServer()->serverGroupList());
                } catch (\TeamSpeak3_Exception $e) {
                    TeamSpeakUtils::i()->addExceptionToExceptionsList($e);
                }
            }
            return null;
        }, Config::get("cache_servergroups"), $meta);
    }

    public function getChannelGroupList($meta = false) {
        if ($this->channelGroupList) {
            return $this->channelGroupList;
        }

        return $this->channelGroupList = $this->cache->refreshIfExpired("channelgrouplist", function () {
            if(TeamSpeakUtils::i()->checkTSConnection()) {
                try {
                    return $this->tsNodeObjectToArray(TeamSpeakUtils::i()->getTSNodeServer()->channelGroupList());
                } catch (\TeamSpeak3_Exception $e) {
                    TeamSpeakUtils::i()->addExceptionToExceptionsList($e);
                }
            }
            return null;
        }, Config::get("cache_channelgroups"), $meta);
    }
}
