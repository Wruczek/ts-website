<?php

namespace Wruczek\TSWebsite;

use function __get;
use TeamSpeak3;
use Wruczek\TSWebsite\Utils\Utils;

class ViewerRenderer {

    private $imgPath;
    private $resultHtml;

    private $serverInfo;
    private $channelList;
    private $clientList;
    private $serverGroupList;
    private $channelGroupList;

    private $renderQueryClients = false;

    private $hiddenChannels = [];

    public function __construct($imgPath) {
        $this->imgPath = $imgPath;

        $cm = CacheManager::i();
        $this->serverInfo = $cm->getServerInfo();
        $this->channelList = $cm->getChannelList();
        $this->clientList = $cm->getClientList();
        $this->serverGroupList = $cm->getServerGroupList();
        $this->channelGroupList = $cm->getChannelGroupList();
    }

    /**
     * Checks if we have successfully loaded all required data from cache.
     * Loading data from CacheManager might fail for example when the server is offline,
     * or when we dont have required permissions to check for a specific item.
     * @return bool true on success, false otherwise
     */
    public function checkRequiredData() {
        return isset($this->channelList, $this->clientList, $this->serverGroupList, $this->channelGroupList);
    }

    private function add($html, ...$args) {
        foreach ($args as $i => $iValue) {
            // Prevent argument placeholder injection
            $iValue = str_replace(["{", "}"], ["&#123;", "&#125;"], $iValue);

            $html = str_ireplace('{' . $i . '}', $iValue, $html);
        }

        $this->resultHtml .= $html;
    }

    public function renderViewer() {
        if (!$this->checkRequiredData()) {
            throw new \Exception("Failed to load required data from the cache. " .
                "Is the server online? Do we have enough permissions?");
        }

        $suffixIcons = "";

        if ($icon = $this->serverInfo["virtualserver_icon_id"]) {
            $suffixIcons = $this->getIcon($icon, __get("VIEWER_SERVER_ICON"));
        }

        $html = <<<EOD
<div class="channel-container is-server">
    <div class="channel" data-channelid="0" tabindex="0">
        <span class="channel-name">{0}{1}</span>
        <span class="channel-icons">{2}</span>
    </div>
</div>

EOD;

        $this->add(
            $html,
            $this->getIcon("server_green.svg"),
            Utils::escape($this->serverInfo["virtualserver_name"]),
            $suffixIcons
        );

        foreach ($this->channelList as $channel) {
            // Start rendering the top channels, they are gonna
            // render all the childrens recursively
            if ($channel["pid"] === 0) {
                $this->renderChannel(new TeamSpeakChannel($channel));
            }
        }

        return $this->resultHtml;
    }

    public function getIcon($name, $tooltip = null, $alt = "Icon") {
        if (is_string($name)) {
            $path = "{$this->imgPath}/$name";
        } else {
            $path = "api/geticon.php?iconid=" . (int) $name;
        }

        $ttip = $tooltip ? ' data-toggle="tooltip" title="' . Utils::escape($tooltip) . '"' : "";
        return '<img class="icon" src="' . $path . '" alt="' . Utils::escape($alt) . '"' . $ttip . '>';
    }

    /**
     * @param $channel TeamSpeakChannel
     */
    public function renderChannel($channel) {
        $hasParent = $channel->getParentId();

        $isHidden = in_array($channel->getId(), $this->hiddenChannels);
        $channelDisplayName = $channel->getDisplayName();
        $channelClasses = $hasParent ? "has-parent" : "no-parent";
        $channelIcon = "";
        $suffixIcons = "";

        // If this channel is occupied
        if ($channel->isOccupied(false, $this->renderQueryClients) && !$isHidden) {
            $channelClasses .= " is-occupied";
        } else if ($channel->isOccupied(true, $this->renderQueryClients) && !$isHidden) {
            $channelClasses .= " occupied-childs";
        } else {
            $channelClasses .= " not-occupied";
        }

        if ($channel->isSpacer()) {
            $channelClasses .= " is-spacer";

            switch($channel->getSpacerAlign()) {
                case TeamSpeak3::SPACER_ALIGN_REPEAT:
                    $channelClasses .= " spacer-repeat";
                    $channelDisplayName = str_repeat($channelDisplayName, 200);
                    break;
                case TeamSpeak3::SPACER_ALIGN_CENTER:
                    $channelClasses .= " spacer-center";
                    break;
                case TeamSpeak3::SPACER_ALIGN_RIGHT:
                    $channelClasses .= " spacer-right";
                    break;
                case TeamSpeak3::SPACER_ALIGN_LEFT:
                    $channelClasses .= " spacer-left";
                    break;
            }
        } else {
            $channelIcon = $this->getChannelIcon($channel, $isHidden);
            $suffixIcons = $this->getChannelSuffixIcons($channel);
        }

        $html = <<<EOD
<div class="channel-container {0}">
    <div class="channel" data-channelid="{1}"{2}>
        <span class="channel-name">{3}{4}</span>
        <span class="channel-icons">{5}</span>
    </div>

EOD;

        $this->add(
            $html,
            $channelClasses,
            $channel->getId(),
            $channel->isSpacer() ? "" : ' tabindex="0"',
            $channelIcon,
            Utils::escape($channelDisplayName),
            $suffixIcons
        );

        if (!$isHidden) {
            foreach ($channel->getChannelMembers($this->renderQueryClients) as $member) {
                $this->renderClient($member);
            }
        }

        foreach ($channel->getChildChannels() as $member) {
            $this->renderChannel($member);
        }

        $this->add('</div>' . PHP_EOL . PHP_EOL);
    }

    public function renderClient($client) {
        $isQuery = (bool) $client["client_type"];

        $clientSGIDs = explode(",", $client["client_servergroups"]);
        $clientServerGroups = [];

        $beforeName = [];
        $afterName = [];

        if (isset($client["client_away_message"])) {
            $afterName[] = "[{$client["client_away_message"]}]";
        }

        foreach ($this->serverGroupList as $servergroup) {
            $groupid = $servergroup["sgid"];

            if (in_array($groupid, $clientSGIDs)) {
                $clientServerGroups[$groupid] = $servergroup;

                if ($servergroup["namemode"] === TeamSpeak3::GROUP_NAMEMODE_BEFORE) {
                    $beforeName[] = "[{$servergroup["name"]}]";
                }

                if ($servergroup["namemode"] === TeamSpeak3::GROUP_NAMEMODE_BEHIND) {
                    $afterName[] = "[{$servergroup["name"]}]";
                }
            }
        }

        $clientIcon = $this->getClientIcon($client);
        $suffixIcons = $this->getClientSuffixIcons($client, $clientServerGroups, 0);

        $html = <<<EOD
<div class="client-container{0}" data-clientdbid="{1}" tabindex="0">
    <span class="client-name">{2}{3}</span>
    <span class="client-icons">{4}</span>
</div>

EOD;

        $clientName = implode(" ", $beforeName);           // prefix groups
        $clientName .= " {$client["client_nickname"]} ";   // nickname
        $clientName .= implode(" ", $afterName);           // suffix groups
        $clientName = Utils::escape(trim($clientName)); // trim and sanitize

        $this->add(
            $html,
            $isQuery ? " is-query" : "", $client["client_database_id"],
            $clientIcon,
            $clientName,
            $suffixIcons
        );
    }

    private function getChannelIcon(TeamSpeakChannel $channel, $isHidden) {
        $subscribed = $isHidden ? "" : "_subscribed";
        $unsub = $isHidden ? __get("VIEWER_CHANNEL_UNSUB1") : "";

        if ($channel->isDefaultChannel()) {
            return $this->getIcon("channel_default.svg", __get("VIEWER_DEFAULT_CHANNEL"));
        }

        if ($channel->isFullyOccupied()) {
            return $this->getIcon("channel_red{$subscribed}.svg", __get("VIEWER_CHANNEL_OCCUPIED") . $unsub);
        }

        if ($channel->hasPassword()) {
            return $this->getIcon("channel_yellow{$subscribed}.svg", __get("VIEWER_CHANNEL_PASSWORD") . $unsub);
        }

        return $this->getIcon("channel_green{$subscribed}.svg", $isHidden ? __get("VIEWER_CHANNEL_UNSUB2") : null);
    }

    private function getChannelSuffixIcons(TeamSpeakChannel $channel) {
        $info = $channel->getInfo();
        $html = "";

        if($channel->isDefaultChannel()) {
            $html .= $this->getIcon("default.svg", __get("VIEWER_DEFAULT_CHANNEL"));
        }

        if($info["channel_flag_password"]) {
            $html .= $this->getIcon("channel_private.svg", __get("VIEWER_CHANNEL_PASSWORD"));
        }

        $codec = $info["channel_codec"];
        if($codec === TeamSpeak3::CODEC_CELT_MONO || $codec === TeamSpeak3::CODEC_OPUS_MUSIC) {
            $html .= $this->getIcon("music.svg", __get("VIEWER_CHANNEL_MUSIC_CODED"));
        }

        if($info["channel_needed_talk_power"]) {
            $html .= $this->getIcon("moderated.svg", __get("VIEWER_CHANNEL_MODERATED"));
        }

        if($info["channel_icon_id"]) {
            $html .= $this->getIcon($info["channel_icon_id"], __get("VIEWER_CHANNEL_ICON"));
        }

        return $html;
    }

    public function getClientIcon($client) {
        if($client["client_type"]) {
            return $this->getIcon("server_query.svg");
        }

        if($client["client_away"]) {
            return $this->getIcon("away.svg", Utils::escape($client["client_away_message"]) ?: __get("VIEWER_CLIENT_AWAY"));
        }

        if(!$client["client_output_hardware"]) {
            return $this->getIcon("hardware_output_muted.svg", __get("VIEWER_CLIENT_OUTPUT_DISABLED"));
        }

        if($client["client_output_muted"]) {
            return $this->getIcon("output_muted.svg", __get("VIEWER_CLIENT_OUTPUT_MUTED"));
        }

        if(!$client["client_input_hardware"]) {
            return $this->getIcon("hardware_input_muted.svg", __get("VIEWER_CLIENT_MIC_DISABLED"));
        }

        if($client["client_input_muted"]) {
            return $this->getIcon("input_muted.svg", __get("VIEWER_CLIENT_MIC_MUTED"));
        }

        if($client["client_is_channel_commander"]) {
            return $this->getIcon("player_commander_off.svg", __get("VIEWER_CLIENT_COMMANDER"));
        }

        return $this->getIcon("player_off.svg");
    }

    public function getClientSuffixIcons($client, $groups, $cntp) {
        $html = "";

        if($client["client_is_priority_speaker"]) {
            $html .= $this->getIcon("capture.svg", __get("VIEWER_CLIENT_PRIORITY_SPEAKER"));
        }

        if($client["client_is_channel_commander"]) {
            $html .= $this->getIcon("channel_commander.svg", __get("VIEWER_CLIENT_COMMANDER"));
        }

        if($client["client_is_talker"]) {
            $html .= $this->getIcon("talk_power_grant.svg", __get("VIEWER_CLIENT_TALK_POWER_GRANTED"));
        }  else if($cntp && $cntp > $client["client_talk_power"]) {
            $html .= $this->getIcon("input_muted.svg", __get("VIEWER_CLIENT_TALK_POWER_INSUFFICIENT"));
        }

        foreach ($groups as $group) {
            if ($group["iconid"]) {
                $icon = $group["iconid"];
            } else {
                $icon = "broken_image.svg";
                continue;
                // If the group does not have an icon, we skip this group.
                // However, you can comment out the above "continue" statement
                // to show the group with a "broken-image" icons.
            }

            $html .= $this->getIcon($icon, Utils::escape($group["name"]));
        }

        if($client["client_icon_id"]) {
            $html .= $this->getIcon($client["client_icon_id"], __get("VIEWER_CLIENT_ICON"));
        }

        if($client["client_country"]) {
            $country = $client["client_country"];
            $countryLower = strtolower($country);
            $html .= '<i class="icon-flag famfamfam-flags ' . $countryLower . '" ' .
                        'data-toggle="tooltip" title="' . $country . '" aria-hidden="true"></i>';
        }

        return $html;
    }
}
