<?php
/*
 * Italian language for ts-website
 * @copy JohnnyKing94 <https://github.com/JohnnyKing94>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "it";
$lang["general"]["scripterror"] = "Un errore si è verificato! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigazione";

$lang["navbar"]["viewer"] = "Visualizza Server";
$lang["navbar"]["bans"] = "Lista Ban";
$lang["navbar"]["rules"] = "Regolamento";

$lang["navbar"]["connect"] = "Unisciti a noi!";
$lang["navbar"]["connecttooltip"] = "Clicca per connetterti a {0}";


/************* Footer *************/

$lang["footer"]["css"] = "CSS di";
$lang["footer"]["background"] = "sfondo";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Stato Server";
$lang["serverstatus"]["address"] = "Indirizzo";
$lang["serverstatus"]["loading"] = "In caricamento...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Uptime";
$lang["serverstatus"]["version"] = "Versione";
$lang["serverstatus"]["avgping"] = "Ping medio";
$lang["serverstatus"]["avgpl"] = "Perdita media dei pacchetti";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Lista admin";
$lang["adminlist"]["emptygroup"] = "Questo gruppo è vuoto";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Assente";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Ultimo aggiornamento: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Visualizza server";
$lang["svpb"]["takealook"] = "Guarda &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "News";
$lang["index"]["showmore"] = "Leggi di più";
$lang["index"]["showless"] = "VIsualizza meno";

$lang["index"]["errortitle"] = "Errore: la directory news non è stata trovata!";
$lang["index"]["errorsubtitle"] = "Si prega di assicurarsi che la posizione della cartella impostata in <b><code>config/config.php</code></b> sia valida.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Visualizza Server";
$lang["viewer"]["lastupdate"] = "Ultimo aggiornamento: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Lista Ban";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json";
$lang["banlist"]["emptylist"] = "LA LISTA BAN E' VUOTA";
$lang["banlist"]["lastupdate"] = "Ultimo aggiornamento: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(nessun motivo)";
$lang["banlist"]["table"]["permaban"] = "Permanente";

$lang["banlist"]["table"]["nickname"] = "Nick";
$lang["banlist"]["table"]["reason"] = "Motivo";
$lang["banlist"]["table"]["bannedby"] = "Bananto da";
$lang["banlist"]["table"]["bandate"] = "Data del Ban";
$lang["banlist"]["table"]["expires"] = "Scade";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Regolamento";
$lang["rules"]["filenotfound"] = "Errore: il file <code>config/rules.md</code> non è stato trovato!";
$lang["rules"]["readerror"] = "Errore: impossibile accede al file <code>config/rules.md</code>!";
