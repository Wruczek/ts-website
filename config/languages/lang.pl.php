<?php
/*
 * Polish language for ts-website
 * @copy Wruczek <wruczekk@gmail.com>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "pl_PL";
$lang["general"]["scripterror"] = "Wystąpił błąd! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Nawigacja";

$lang["navbar"]["viewer"] = "Podgląd serwera";
$lang["navbar"]["bans"] = "Lista banów";
$lang["navbar"]["rules"] = "Regulamin";

$lang["navbar"]["connect"] = "Połącz z serwerem";
$lang["navbar"]["connecttooltip"] = "Kliknij, by połączyć się z serwerem {0}";


/************* Footer *************/

$lang["footer"]["website"] = "Strona";
$lang["footer"]["css"] = "CSS dzięki uprzejmości";
$lang["footer"]["background"] = "tło";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Status serwera";
$lang["serverstatus"]["address"] = "Adres";
$lang["serverstatus"]["loading"] = "Ładowanie...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Uptime";
$lang["serverstatus"]["version"] = "Wersja";
$lang["serverstatus"]["avgping"] = "Średni ping";
$lang["serverstatus"]["avgpl"] = "Średni packet loss";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Status administracji";
$lang["adminlist"]["emptygroup"] = "Ta grupa jest pusta";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Away";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Stan na {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Podgląd serwera";
$lang["svpb"]["takealook"] = "Zobacz &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Wiadomości";
$lang["index"]["showmore"] = "Pokaż wiecej";
$lang["index"]["showless"] = "Pokaż mniej";

$lang["index"]["errortitle"] = "Wystąpił błąd: folder z newsami nie został odnaleziony.";
$lang["index"]["errorsubtitle"] = "Sprawdź, czy lokalizacja ustawiona w pliku <code>config/config.php</code> jest poprawna.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Podgląd serwera";
$lang["viewer"]["lastupdate"] = "Stan na {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Lista banów";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Polish.json";
$lang["banlist"]["emptylist"] = "BRAK ZBANOWANYCH UŻYTKOWNIKÓW";
$lang["banlist"]["lastupdate"] = "Stan na {0}";

$lang["banlist"]["table"]["emptyreason"] = "(brak powodu)";
$lang["banlist"]["table"]["permaban"] = "Nigdy";

$lang["banlist"]["table"]["nickname"] = "Nick";
$lang["banlist"]["table"]["reason"] = "Powód";
$lang["banlist"]["table"]["bannedby"] = "Zbanowany przez";
$lang["banlist"]["table"]["bandate"] = "Data zbanowania";
$lang["banlist"]["table"]["expires"] = "Wygasa";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Regulamin serwera";
$lang["rules"]["filenotfound"] = "Wystąpił błąd: plik <code>config/rules.md</code> nie został odnaleziony!";
$lang["rules"]["readerror"] = "Wystąpił błąd: nie można odczytać pliku <code>config/rules.md</code>!";
