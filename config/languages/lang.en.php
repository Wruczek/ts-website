<?php
/*
 * English language for ts-website
 * @copy Wruczek <wruczekk@gmail.com>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "en_GB";
$lang["general"]["scripterror"] = "An error occured! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigation";

$lang["navbar"]["viewer"] = "Server Viewer";
$lang["navbar"]["bans"] = "Ban List";
$lang["navbar"]["rules"] = "Server Rules";

$lang["navbar"]["connect"] = "Connect to server";
$lang["navbar"]["connecttooltip"] = "Click to connect to {0}";


/************* Footer *************/

$lang["footer"]["website"] = "Website";
$lang["footer"]["css"] = "CSS thanks to courtesy of";
$lang["footer"]["background"] = "background";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Server status";
$lang["serverstatus"]["address"] = "Address";
$lang["serverstatus"]["loading"] = "Loading...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Uptime";
$lang["serverstatus"]["version"] = "Version";
$lang["serverstatus"]["avgping"] = "Average ping";
$lang["serverstatus"]["avgpl"] = "Average packet loss";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Adminlist";
$lang["adminlist"]["emptygroup"] = "This group is empty";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Away";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Last update: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Server Viewer";
$lang["svpb"]["takealook"] = "Take a look &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "News";
$lang["index"]["showmore"] = "Read more";
$lang["index"]["showless"] = "Show less";

$lang["index"]["errortitle"] = "Error: news directory has not been found!";
$lang["index"]["errorsubtitle"] = "Please make sure that directory location set in <code>config/config.php</code> is valid.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Server Viewer";
$lang["viewer"]["lastupdate"] = "Last update: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Ban List";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json";
$lang["banlist"]["emptylist"] = "BAN LIST IS EMPTY";
$lang["banlist"]["lastupdate"] = "Last update: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(no reason set)";
$lang["banlist"]["table"]["permaban"] = "Never";

$lang["banlist"]["table"]["nickname"] = "Nick";
$lang["banlist"]["table"]["reason"] = "Reason";
$lang["banlist"]["table"]["bannedby"] = "Banned by";
$lang["banlist"]["table"]["bandate"] = "Ban date";
$lang["banlist"]["table"]["expires"] = "Expires";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Server Rules";
$lang["rules"]["filenotfound"] = "Error: file <code>config/rules.md</code> has not been found!";
$lang["rules"]["readerror"] = "Error: cannot access the file <code>config/rules.md</code>!";
