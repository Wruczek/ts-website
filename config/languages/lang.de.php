<?php
/*
 * German language for ts-website
 * @copy NothingTV <contact@tactical-gaming.com> with derrobin154 <derrobin154@gmail.com>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "de_DE";
$lang["general"]["scripterror"] = "Es ist ein Fehler aufgetreten! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigation";

$lang["navbar"]["viewer"] = "Server Viewer";
$lang["navbar"]["bans"] = "Bann Liste";
$lang["navbar"]["rules"] = "Server Regeln";

$lang["navbar"]["connect"] = "Mit Server verbinden";
$lang["navbar"]["connecttooltip"] = "Klicken um mit {0} zu verbinden";


/************* Footer *************/

$lang["footer"]["website"] = "Webseite";
$lang["footer"]["css"] = "CSS bereitgestellt von";
$lang["footer"]["background"] = "Hintergrund";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Server Status";
$lang["serverstatus"]["address"] = "Adresse";
$lang["serverstatus"]["loading"] = "Laden...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Uptime";
$lang["serverstatus"]["version"] = "Server Version";
$lang["serverstatus"]["avgping"] = "Ø Ping";
$lang["serverstatus"]["avgpl"] = "Ø Paketverlust";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Admin Liste";
$lang["adminlist"]["emptygroup"] = "Diese Gruppe ist leer";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Abwesend";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Letzte Aktualisierung: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Server Viewer";
$lang["svpb"]["takealook"] = "Riskier 'n Blick &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Neuigkeiten";
$lang["index"]["showmore"] = "Mehr anzeigen";
$lang["index"]["showless"] = "Weniger anzeigen";

$lang["index"]["errortitle"] = "Fehler: Neuigkeiten Ordner konnte nicht gefunden werden!";
$lang["index"]["errorsubtitle"] = "Bitte stelle sicher, dass der Ordner Pfad in <code>config/config.php</code> richtig angegeben wurde.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Server Viewer";
$lang["viewer"]["lastupdate"] = "Letzte Aktualisierung: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Bann Liste";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/German.json";
$lang["banlist"]["emptylist"] = "Es gibt derzeit keine Gebannten User";
$lang["banlist"]["lastupdate"] = "Letzte Aktualisierung: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(kein Grund angegeben)";
$lang["banlist"]["table"]["permaban"] = "Niemals";

$lang["banlist"]["table"]["nickname"] = "Benutzername";
$lang["banlist"]["table"]["reason"] = "Grund";
$lang["banlist"]["table"]["bannedby"] = "Gebannt von";
$lang["banlist"]["table"]["bandate"] = "Bann Zeitpunkt";
$lang["banlist"]["table"]["expires"] = "Läuft ab am";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Server Regeln";
$lang["rules"]["filenotfound"] = "Fehler: Die Datei <code>config/rules.md</code> wurde nicht gefunden!";
$lang["rules"]["readerror"] = "Fehler: Nicht genügend Rechte um auf <code>config/rules.md</code> zuzugreifen!";

/************** Group assigner - assigner.php **************/

$lang["groupassigner"]["title"] = "Gruppenzuweiser";
$lang["groupassigner"]["languageurl"] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-de_DE.min.js";
$lang["groupassigner"]["limit"] = "Limit: {0}";
$lang["groupassigner"]["connectbeforeusing"] = "Bitte verbinde vorher mit dem Server.";
$lang["groupassigner"]["joints"] = "Auf den Teamspeak verbinden";
$lang["groupassigner"]["success"] = "Deine Gruppen haben sich geändert!";
$lang["groupassigner"]["save"] = "Speichern";
$lang["groupassigner"]["entercode"] = "Bitte gebe deinen Logincode ein.";
$lang["groupassigner"]["codepoke"] = "Dein Logincode lautet: [B]{0}[/B]. Er läuft in 2 Minuten aus.";
$lang["groupassigner"]["logincode"] = "Logincode";
$lang["groupassigner"]["failedlogin"] = "Login fehlgeschlagen! Bitte versuche es erneut, oder warte bis der Code ausgelaufen ist und lade die Seite dann neu.";
