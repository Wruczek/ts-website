<?php
/*
 * Czech language for ts-website
 * @copy Najsr <https://github.com/Najsr>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "cs_CZ";
$lang["general"]["scripterror"] = "Nastala chyba! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigace";

$lang["navbar"]["viewer"] = "Prohlížeč serveru";
$lang["navbar"]["bans"] = "Banlist";
$lang["navbar"]["rules"] = "Pravidla";

$lang["navbar"]["connect"] = "Připojit";
$lang["navbar"]["connecttooltip"] = "Klikněte pro připojení na {0}";


/************* Footer *************/

$lang["footer"]["css"] = "CSS od";
$lang["footer"]["background"] = "pozadí";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Status";
$lang["serverstatus"]["address"] = "Adresa";
$lang["serverstatus"]["loading"] = "Načítání...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Doba zapnutí";
$lang["serverstatus"]["version"] = "Verze";
$lang["serverstatus"]["avgping"] = "Průměrný ping";
$lang["serverstatus"]["avgpl"] = "Průměrná ztrátovost paketů";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Seznam adminů";
$lang["adminlist"]["emptygroup"] = "Tato skupina je prázdná";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Pryč";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Poslední aktualizace: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Prohlížeč serveru";
$lang["svpb"]["takealook"] = "Otevřít &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Novinky";
$lang["index"]["showmore"] = "Zobrazit více";
$lang["index"]["showless"] = "Zobrazit méně";

$lang["index"]["errortitle"] = "Error: stránka s novinkami nenalezena!";
$lang["index"]["errorsubtitle"] = "Ujistěte se, že cesta zadaná v <b><code>config/config.php</code></b> je správná.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Prohlížeč serveru";
$lang["viewer"]["lastupdate"] = "Poslední aktualizace: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Banlist";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Czech.json";
$lang["banlist"]["emptylist"] = "Banlist je prázdný";
$lang["banlist"]["lastupdate"] = "Poslední aktualizace: {0}";
$lang["banlist"]["table"]["emptyreason"] = "(bez důvodu)";
$lang["banlist"]["table"]["permaban"] = "Až naprší a uschne";
$lang["banlist"]["table"]["nickname"] = "Nick";
$lang["banlist"]["table"]["reason"] = "Důvod";
$lang["banlist"]["table"]["bannedby"] = "Zabanován od";
$lang["banlist"]["table"]["bandate"] = "Datum";
$lang["banlist"]["table"]["expires"] = "Vyprší";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Pravidla serveru";
$lang["rules"]["filenotfound"] = "Error: soubor <code>config/rules.md</code> nebyl nalezen!";
$lang["rules"]["readerror"] = "Error: nemám přístup k <code>config/rules.md</code>!";
