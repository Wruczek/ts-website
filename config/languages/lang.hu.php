<?php
/*
 * Hungarian language for ts-website
 * @copy SmaCk <steamcommunity.com/id/smackiii>
 */

$lang = array();

/************* Általános *************/

$lang["general"]["langcode"] = "hu_HU";
$lang["general"]["scripterror"] = "Hiba történt! {0}: {1}";

/************* Navbár *************/

$lang["navbar"]["navigation"] = "Navigáció";

$lang["navbar"]["viewer"] = "Szerver Státusz";
$lang["navbar"]["bans"] = "Banlista";
$lang["navbar"]["rules"] = "Szabályzat";

$lang["navbar"]["connect"] = "CSATLAKOZÁS";
$lang["navbar"]["connecttooltip"] = "Csatlakozáshoz katt.. {0}";


/************* Lábrész *************/

$lang["footer"]["css"] = "CSS by ";


/************* Server Státusz *************/

$lang["serverstatus"]["title"] = "Státusz";
$lang["serverstatus"]["address"] = "IP Cím";
$lang["serverstatus"]["loading"] = "Betöltés...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Üzemidő";
$lang["serverstatus"]["version"] = "Verzió";
$lang["serverstatus"]["avgping"] = "Átlagos ping";
$lang["serverstatus"]["avgpl"] = "Csomagveszteség";


/************* Admin lista *************/

$lang["adminlist"]["title"] = "Staff";
$lang["adminlist"]["emptygroup"] = "A csoport üres.";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Távol";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Utoljára frissítve: {0}";


/************* Adminlista és Kapcsolat alatt megjelenő szövegek *************/

$lang["svpb"]["title"] = "Státusz";
$lang["svpb"]["takealook"] = "Megnéz";


/************************************/
/************* ALOLDALAK *************/
/************************************/


/************* Hírek - index.php *************/

$lang["index"]["title"] = "Hírek";
$lang["index"]["showmore"] = "olvass tovább";
$lang["index"]["showless"] = "kevesebb";

$lang["index"]["errortitle"] = "Hiba: hírek mappa nem található!";
$lang["index"]["errorsubtitle"] = "Kérlek állítsd be a fájlt megfelelően <b><code>config/config.php</code></b>.";


/************* Szerver Státusz - viewer.php *************/

$lang["viewer"]["title"] = "Szerver Státusz";
$lang["viewer"]["lastupdate"] = "Utoljára frissítve: {0}";


/************* BanLista - bans.php *************/

$lang["banlist"]["title"] = "Banlista";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Hungarian.json";
$lang["banlist"]["emptylist"] = "A banlista üres.";
$lang["banlist"]["lastupdate"] = "Utoljára frissítve: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(nincs indok)";
$lang["banlist"]["table"]["permaban"] = "Soha";

$lang["banlist"]["table"]["nickname"] = "Név";
$lang["banlist"]["table"]["reason"] = "Indok";
$lang["banlist"]["table"]["bannedby"] = "Admin";
$lang["banlist"]["table"]["bandate"] = "Dátum";
$lang["banlist"]["table"]["expires"] = "Lejár";

/************* Szabályok - rules.php *************/

$lang["rules"]["title"] = "Szabályzat";
$lang["rules"]["filenotfound"] = "Hiba: fájl <code>config/rules.md</code> nem található!";
$lang["rules"]["readerror"] = "Hiba: nincs megfelelő joga <code>config/rules.md</code>!";
