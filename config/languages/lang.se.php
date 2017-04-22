<?php
/*
 * Swedish language for ts-website
 * @copy Mattias G. <mattiasghodsian@gmail.com>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "se_SV";
$lang["general"]["scripterror"] = "Ett fel inträffade! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigering";

$lang["navbar"]["viewer"] = "Server överblick";
$lang["navbar"]["bans"] = "Ban Lista";
$lang["navbar"]["rules"] = "Server Regler";

$lang["navbar"]["connect"] = "Anslut till servern";
$lang["navbar"]["connecttooltip"] = "Klicka för att ansluta till {0}";


/************* Footer *************/

$lang["footer"]["css"] = "CSS av";
$lang["footer"]["background"] = "bakgrund";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Serverstatus";
$lang["serverstatus"]["address"] = "Adress";
$lang["serverstatus"]["loading"] = "Laddar...";

$lang["serverstatus"]["online"] = "Uppkopplad";
$lang["serverstatus"]["offline"] = "Nerkopplad";
$lang["serverstatus"]["uptime"] = "Upp tid";
$lang["serverstatus"]["version"] = "Version";
$lang["serverstatus"]["avgping"] = "Genomsnittlig ping";
$lang["serverstatus"]["avgpl"] = "Genomsnittlig paketförlust";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Admin lista";
$lang["adminlist"]["emptygroup"] = "Den här gruppen är tom";
$lang["adminlist"]["status"]["online"] = "Uppkopplad";
$lang["adminlist"]["status"]["away"] = "Bort";
$lang["adminlist"]["status"]["offline"] = "Nerkopplad";
$lang["adminlist"]["lastupdate"] = "Senaste uppdateringen: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Server överblick";
$lang["svpb"]["takealook"] = "Ta en titt &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Nyheter";
$lang["index"]["showmore"] = "Läs mer";
$lang["index"]["showless"] = "Visa mindre";

$lang["index"]["errortitle"] = "Fel: Nyhetskatalog har inte hittats!";
$lang["index"]["errorsubtitle"] = "Se till att katalogplatsen som anges i <b><code>config/config.php</code></b> är giltig. ";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Server överblick";
$lang["viewer"]["lastupdate"] = "Senaste uppdateringen: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Ban ListA";
$lang["banlist"]["datatablesurl"] = "/cdn.datatables.net/plug-ins/1.10.12/i18n/Swedish.json";
$lang["banlist"]["emptylist"] = "BANLISTAN ÄR TOM";
$lang["banlist"]["lastupdate"] = "Senaste uppdateringen: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(Ingen anledning inställd)";
$lang["banlist"]["table"]["permaban"] = "Aldrig";

$lang["banlist"]["table"]["nickname"] = "Nick";
$lang["banlist"]["table"]["reason"] = "Anledning";
$lang["banlist"]["table"]["bannedby"] = "Banned av";
$lang["banlist"]["table"]["bandate"] = "Ban tid";
$lang["banlist"]["table"]["expires"] = "Löper ut";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Server Regler";
$lang["rules"]["filenotfound"] = "Fel: filen <code>config/rules.md</code> har inte hittats!";
$lang["rules"]["readerror"] = "Fel: kan inte komma åt filen <code>config/rules.md</code>!";
