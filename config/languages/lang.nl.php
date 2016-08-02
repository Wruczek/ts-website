<?php
/*
 * Dutch language for ts-website
 * @copy MojoW <mojow@solidsn4ke.com>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "nl_NL";
$lang["general"]["scripterror"] = "Er is een fout opgetreden! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigatie";

$lang["navbar"]["viewer"] = "Server Bekijken";
$lang["navbar"]["bans"] = "Ban Lijst";
$lang["navbar"]["rules"] = "Server Regels";

$lang["navbar"]["connect"] = "Verbinden met server";
$lang["navbar"]["connecttooltip"] = "Klik om verbinding te maken met {0}";


/************* Footer *************/

$lang["footer"]["website"] = "Website";
$lang["footer"]["css"] = "CSS mogelijk gemaakt door";
$lang["footer"]["background"] = "achtergrond";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Server status";
$lang["serverstatus"]["address"] = "Adres";
$lang["serverstatus"]["loading"] = "Laden...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Uptijd";
$lang["serverstatus"]["version"] = "Versie";
$lang["serverstatus"]["avgping"] = "Gemiddelde ping";
$lang["serverstatus"]["avgpl"] = "Gemiddelde pakketverlies";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Adminlijst";
$lang["adminlist"]["emptygroup"] = "Deze groep is leeg";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Afwezig";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Laaste update: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Server Bekijken";
$lang["svpb"]["takealook"] = "Neem een kijkje &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Niews";
$lang["index"]["showmore"] = "Lees meer";
$lang["index"]["showless"] = "Minimaliseer";

$lang["index"]["errortitle"] = "Fout: niews map is niet gevonden!";
$lang["index"]["errorsubtitle"] = "Controleer A.U.B of de map locatie in <code>config/config.php</code> correct is.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Server Bekijken";
$lang["viewer"]["lastupdate"] = "Laaste update: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Ban Lijst";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Dutch.json";
$lang["banlist"]["emptylist"] = "BAN LIJST IS LEEG";
$lang["banlist"]["lastupdate"] = "Laaste update: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(Geen reden)";
$lang["banlist"]["table"]["permaban"] = "Nooit";

$lang["banlist"]["table"]["nickname"] = "Bijnaam";
$lang["banlist"]["table"]["reason"] = "Reden";
$lang["banlist"]["table"]["bannedby"] = "Gebanned door";
$lang["banlist"]["table"]["bandate"] = "Ban datum";
$lang["banlist"]["table"]["expires"] = "Verloopt op";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Server Regels";
$lang["rules"]["filenotfound"] = "Fout: kan het bestand <code>config/rules.md</code> niet vinden!";
$lang["rules"]["readerror"] = "Fout: Geen toegang tot het bestand <code>config/rules.md</code>!";
