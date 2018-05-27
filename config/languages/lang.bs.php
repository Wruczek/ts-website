<?php
/*
 * Bosnian language for ts-website
 * @copy Izet Mulalić <github.com/kallefrombosnia>
 */
 
$lang = array();

/************* Generalno *************/

$lang["general"]["langcode"] = "bs";
$lang["general"]["languageflag"] = "ba";
$lang["general"]["scripterror"] = "Greška se pojavila! {0}: {1}";

/************* Navigacija *************/

$lang["navbar"]["navigation"] = "Navigacija";
$lang["navbar"]["viewer"] = "Pregled Servera";
$lang["navbar"]["bans"] = "Ban Lista";
$lang["navbar"]["rules"] = "Pravila Servera";
$lang["navbar"]["connect"] = "Poveži se na server";
$lang["navbar"]["connecttooltip"] = "Klikni da se spojiš na {0}";

/************* Footer *************/

$lang["footer"]["css"] = "CSS by";
$lang["footer"]["background"] = "pozadina";

/************* Server status *************/

$lang["serverstatus"]["title"] = "Server status";
$lang["serverstatus"]["address"] = "Adresa";
$lang["serverstatus"]["loading"] = "Učitavanje...";
$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Uptime";
$lang["serverstatus"]["version"] = "Verzija";
$lang["serverstatus"]["avgping"] = "Prosječni ping";
$lang["serverstatus"]["avgpl"] = "Prosječni packet loss";

/************* Admin lista *************/

$lang["adminlist"]["title"] = "Admin lista";
$lang["adminlist"]["emptygroup"] = "Ova grupa je prazna";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Odsutan";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Zadnji update: {0}";

/************* Pregled servera u promotivnom boxu (ispod admin liste i kontakata) *************/

$lang["svpb"]["title"] = "Pregled servera";
$lang["svpb"]["takealook"] = "Baci pogled &raquo;";


/************************************/
/************* SUBSTRANICE *************/
/************************************/


/************* Vijesti - index.php *************/

$lang["index"]["title"] = "Vijesti";
$lang["index"]["showmore"] = "Pročitaj više";
$lang["index"]["showless"] = "Prikaži manje";
$lang["index"]["errortitle"] = "Pogreška: direktorij sa vijestima nije pronađen!";
$lang["index"]["errorsubtitle"] = "Molimo postavite direktorij lokaciju u <b><code>config/config.php</code></b> da bude validna.";

/************* Server pregled - viewer.php *************/

$lang["viewer"]["title"] = "Pregled Servera";
$lang["viewer"]["lastupdate"] = "Zadnji update: {0}";

/************* Ban Lista - bans.php *************/

$lang["banlist"]["title"] = "Ban Lista";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json";
$lang["banlist"]["emptylist"] = "BAN LISTA JE PRAZNA";
$lang["banlist"]["lastupdate"] = "Zadnji update: {0}";
$lang["banlist"]["table"]["emptyreason"] = "(nema razloga)";
$lang["banlist"]["table"]["permaban"] = "Nikad";
$lang["banlist"]["table"]["nickname"] = "Nick";
$lang["banlist"]["table"]["reason"] = "Razlog";
$lang["banlist"]["table"]["bannedby"] = "Banned od strane";
$lang["banlist"]["table"]["bandate"] = "Vrijeme bana";
$lang["banlist"]["table"]["expires"] = "Ističe";

/************* Pravila - rules.php *************/

$lang["rules"]["title"] = "Pravila Servera";
$lang["rules"]["filenotfound"] = "Pogreška: fajl <code>config/rules.md</code> nije pronađen!";
$lang["rules"]["readerror"] = "Pogreška: ne možemo pristupiti fajlu <code>config/rules.md</code>!";
