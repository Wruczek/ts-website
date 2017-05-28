<?php
/*
 * Danish language for ts-website
 * @copy Cadmium
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "da_DK";
$lang["general"]["scripterror"] = "En fejl opstod! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigation";

$lang["navbar"]["viewer"] = "Server Fremvisning";
$lang["navbar"]["bans"] = "Ban Liste";
$lang["navbar"]["rules"] = "Server Regler";

$lang["navbar"]["connect"] = "Forbind til server";
$lang["navbar"]["connecttooltip"] = "Klik for at fobinde til {0}";


/************* Footer *************/

$lang["footer"]["css"] = "CSS af";
$lang["footer"]["background"] = "baggrund";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Server status";
$lang["serverstatus"]["address"] = "Adresse";
$lang["serverstatus"]["loading"] = "Indlæser...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Oppetid";
$lang["serverstatus"]["version"] = "Version";
$lang["serverstatus"]["avgping"] = "Gennemsnitlig ping";
$lang["serverstatus"]["avgpl"] = "Gennemsnitlig pakketab";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Admin Liste";
$lang["adminlist"]["emptygroup"] = "Denne gruppe er tom";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Borte";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Sidste opdatering: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Server Fremvisning";
$lang["svpb"]["takealook"] = "Tag et kig &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Nyheder";
$lang["index"]["showmore"] = "Læs mere";
$lang["index"]["showless"] = "Vis mindre";

$lang["index"]["errortitle"] = "Fejl: nyheden kunne ikke findes!";
$lang["index"]["errorsubtitle"] = "Tjek venligst, at den angivne lokation i filen <b><code>config/config.php</code></b> findes.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Server Fremvisning";
$lang["viewer"]["lastupdate"] = "Sidst opdateret: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Ban Liste";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Danish.json";
$lang["banlist"]["emptylist"] = "BAN LISTEN ER TOM";
$lang["banlist"]["lastupdate"] = "Sidst opdateret: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(ingen grund givet)";
$lang["banlist"]["table"]["permaban"] = "Aldrig";

$lang["banlist"]["table"]["nickname"] = "Navn";
$lang["banlist"]["table"]["reason"] = "Grund";
$lang["banlist"]["table"]["bannedby"] = "Banlyst af";
$lang["banlist"]["table"]["bandate"] = "Dato for ban";
$lang["banlist"]["table"]["expires"] = "Udløber";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Server Regler";
$lang["rules"]["filenotfound"] = "Fejl: filen <code>config/rules.md</code> kunne ikke findes!";
$lang["rules"]["readerror"] = "Fejl: adgang til filen <code>config/rules.md</code> nægtet!";
