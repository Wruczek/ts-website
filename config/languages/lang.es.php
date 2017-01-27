<?php
/*
 * Spanish language for ts-website
 * @copy Vinanrra <staff@teamworkers.es>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "es-ES";
$lang["general"]["scripterror"] = "Ha ocurrido un error {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navegación";

$lang["navbar"]["viewer"] = "Server Viewer";
$lang["navbar"]["bans"] = "Lista de baneados";
$lang["navbar"]["rules"] = "Reglas del servidor";

$lang["navbar"]["connect"] = "Conectar al ts3";
$lang["navbar"]["connecttooltip"] = "Click para conectar a {0}";


/************* Footer *************/

$lang["footer"]["css"] = "CSS por";
$lang["footer"]["background"] = "fondo";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Estado del servidor";
$lang["serverstatus"]["address"] = "Direción";
$lang["serverstatus"]["loading"] = "Cargando...";

$lang["serverstatus"]["online"] = "En linea";
$lang["serverstatus"]["offline"] = "Desconectado";
$lang["serverstatus"]["uptime"] = "Tiempo activo";
$lang["serverstatus"]["version"] = "Versión";
$lang["serverstatus"]["avgping"] = "Ping promedio";
$lang["serverstatus"]["avgpl"] = "Pérdida de paquetes";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Lista de ADM/MOD";
$lang["adminlist"]["emptygroup"] = "Grupo vacio";
$lang["adminlist"]["status"]["online"] = "En linea";
$lang["adminlist"]["status"]["away"] = "AFK";
$lang["adminlist"]["status"]["offline"] = "Desconectado";
$lang["adminlist"]["lastupdate"] = "Última actualización: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Ver servidor";
$lang["svpb"]["takealook"] = "Echar un vistazo &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Noticias";
$lang["index"]["showmore"] = "Leer más";
$lang["index"]["showless"] = "Mostar menos";

$lang["index"]["errortitle"] = "Error: El directorio de noticias no fue encontrado";
$lang["index"]["errorsubtitle"] = "Por favor asegurate que el directorio que está en <b><code>config/config.php</code></b> es válido.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Ver servidor";
$lang["viewer"]["lastupdate"] = "Última actualización: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Lista de baneados";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json";
$lang["banlist"]["emptylist"] = "La lista de baneados está vacia";
$lang["banlist"]["lastupdate"] = "Última actualización: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(sin razón)";
$lang["banlist"]["table"]["permaban"] = "Nunca";

$lang["banlist"]["table"]["nickname"] = "Usuario";
$lang["banlist"]["table"]["reason"] = "Razón";
$lang["banlist"]["table"]["bannedby"] = "Baneado por";
$lang["banlist"]["table"]["bandate"] = "Fecha de baneo";
$lang["banlist"]["table"]["expires"] = "Expiración";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Reglas del servidor";
$lang["rules"]["filenotfound"] = "Error: archivo <code>config/rules.md</code> no ha sido encontrado";
$lang["rules"]["readerror"] = "Error: no se puede acceder al archivo <code>config/rules.md</code>";
