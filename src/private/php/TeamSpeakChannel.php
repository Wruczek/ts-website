<?php

namespace Wruczek\TSWebsite;

use TeamSpeak3;
use TeamSpeak3_Helper_String;

/**
 * Class TeamSpeakChannel
 * Some functions copied from ts3-php-framework and modified
 */
class TeamSpeakChannel {

    private $channelList;
    private $info;
    private $clientList;

    public function __construct($cid) {
        if (is_array($cid)) {
            $cid = (int) $cid["cid"];
        }

        if (!is_int($cid)) {
            throw new \InvalidArgumentException("cid needs to be either an channel id (int)" .
                " or an array containing key named cid");
        }

        $this->channelList = CacheManager::i()->getChannelList();

        if (!isset($this->channelList[$cid])) {
            throw new \InvalidArgumentException("Channel with ID $cid was not found in the channel cache");
        }

        $this->info = $this->channelList[$cid];
    }

    private function getChannelList() {
        return $this->channelList;
    }

    private function getClientList() {
        if ($this->clientList === null) {
            $this->clientList = CacheManager::i()->getClientList();
        }

        return $this->clientList;
    }

    public function getInfo() {
        return $this->info;
    }

    public function getId() {
        return (int) $this->info["cid"];
    }

    public function getName() {
        return (string) $this->info["channel_name"];
    }

    public function getDisplayName() {
        if ($this->isSpacer()) {
            // If its a spacer, remove everything before the
            // first "]", and then the "]" itself.
            return mb_substr(mb_strstr($this->getName(), "]"), 1);
        }

        return $this->getName();
    }

    public function isPermanent() {
        return (bool) $this->info["channel_flag_permanent"];
    }

    public function getParentId() {
        return (int) $this->info["pid"];
    }

    public function isOccupied($checkChildrens = false, $includeQuery = false) {
        if ($checkChildrens) {
            // Loop through all the children channels, and check if they are occupied
            foreach ($this->getChildChannels(true) as $channel) {
                if ($channel->isOccupied(false, $includeQuery)) {
                    return true;
                }
            }

            return false;
        }

        // We could use the getChannelMembers method:
        // return count($this->getChannelMembers($includeQuery)) > 0;
        // But its much faster to return on the first instance then to
        // count up all users and then compare their number.
        foreach ($this->getClientList() as $client) {
            if (!$client["client_type"] && $client["cid"] === $this->getId()) {
                return true;
            }
        }

        return false;
    }

    public function hasPassword() {
        return $this->info["channel_flag_password"] === 1;
    }

    public function getTotalClients() {
        return (int) $this->info["total_clients"];
    }

    public function isFullyOccupied() {
        return $this->info["channel_maxclients"] !== -1 &&
                $this->info["channel_maxclients"] <= $this->info["total_clients"];
    }

    public function isDefaultChannel() {
        return $this->info["channel_flag_default"] === 1;
    }

    public function isTopChannel() {
        return $this->getParentId() === 0;
    }

    public function getParentChannels($max = -1) {
        $pid = (int) $this->info["pid"];
        $parents = [];

        while ($pid !== 0 && ($max < 0 || count($parents) < $max)) {
            $parent = new TeamSpeakChannel($pid);
            $parents[$pid] = $parent;
            $pid = $parent->getParentId();
        }

        return $parents;
    }

    public function getClosestParentChannel() {
        $parentChannels = $this->getParentChannels(1);
        return isset($parentChannels[0]) ? $parentChannels[0] : null;
    }

    public function getChildChannels($resursive = false) {
        $childList = [];

        foreach ($this->getChannelList() as $child) {
            if ($child["pid"] === $this->getId()) {
                $childTSC = new TeamSpeakChannel($child);
                $childList[$childTSC->getId()] = $childTSC;

                if ($resursive) {
                    $childList += $childTSC->getChildChannels(true);
                }
            }
        }

        return $childList;
    }

    public function getClosestChildChannel() {
        $childChannels = $this->getChildChannels(1);
        return isset($childChannels[0]) ? $childChannels[0] : null;
    }

    public function getChannelMembers($includeQuery = false) {
        $clientList = [];

        foreach ($this->getClientList() as $client) {
            if ($client["cid"] === $this->getId() && ($includeQuery || !$client["client_type"])) {
//                $childTSC = new TeamSpeakClient($child["clid"]);
                $clientList[$client["clid"]] = $client;
            }
        }

        return $clientList;
    }

    public function isSpacer() {
        return preg_match("/\[[^\]]*spacer[^\]]*\]/", $this->getName()) && $this->isPermanent() && !$this->getParentId();
    }

    /**
     * Returns the possible alignment of a channel spacer
     * @return int|false
     */
    public function getSpacerAlign() {
        if(!$this->isSpacer() || !preg_match("/\[(.*)spacer.*\]/", $this->getName(), $matches) || !isset($matches[1])) {
            return false;
        }

        if ($this->getSpacerType() !== TeamSpeak3::SPACER_CUSTOM) {
            return TeamSpeak3::SPACER_ALIGN_REPEAT;
        }

        switch($matches[1]) {
            case "*":
                return TeamSpeak3::SPACER_ALIGN_REPEAT;
            case "c":
                return TeamSpeak3::SPACER_ALIGN_CENTER;
            case "r":
                return TeamSpeak3::SPACER_ALIGN_RIGHT;
            default:
                return TeamSpeak3::SPACER_ALIGN_LEFT;
        }
    }

    public function getSpacerType() {
        if(!$this->isSpacer()) {
            return false;
        }

        switch((new TeamSpeak3_Helper_String($this->getName()))->section("]", 1)) {
            case "___":
                return TeamSpeak3::SPACER_SOLIDLINE;
            case "---":
                return TeamSpeak3::SPACER_DASHLINE;
            case "...":
                return TeamSpeak3::SPACER_DOTLINE;
            case "-.-":
                return TeamSpeak3::SPACER_DASHDOTLINE;
            case "-..":
                return TeamSpeak3::SPACER_DASHDOTDOTLINE;
            default:
                return TeamSpeak3::SPACER_CUSTOM;
        }
    }


    public function __toString() {
        return $this->getName();
    }
}
