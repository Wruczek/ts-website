<?php
/*
 * Belarussian language for ts-website
 * @copy kidi <@goodgame.by>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "be_BY";
$lang["general"]["scripterror"] = "Адбылася памылка! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Навігацыя";

$lang["navbar"]["viewer"] = "Агляд сервера";
$lang["navbar"]["bans"] = "Спіс забаненых";
$lang["navbar"]["rules"] = "Правілы сервера";

$lang["navbar"]["connect"] = "Падклучыцца";
$lang["navbar"]["connecttooltip"] = "Націсніце, што б падключыцца да {0}";

/************* Footer *************/

$lang["footer"]["website"] = "Вэб-сайт";
$lang["footer"]["css"] = "CSS дзякуючы ласкі";
$lang["footer"]["background"] = "фон";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Статус сервера";
$lang["serverstatus"]["address"] = "Адрас";
$lang["serverstatus"]["loading"] = "Загрузка...";

$lang["serverstatus"]["online"] = "Працуе";
$lang["serverstatus"]["offline"] = "Не працуе";
$lang["serverstatus"]["uptime"] = "Аптайм";
$lang["serverstatus"]["version"] = "Версія";
$lang["serverstatus"]["avgping"] = "Сярэдні пінг";
$lang["serverstatus"]["avgpl"] = "Сяр. страта пакетаў";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Статус адміністрацыі";
$lang["adminlist"]["emptygroup"] = "Эта группа пуста";
$lang["adminlist"]["status"]["online"] = "У анлайне";
$lang["adminlist"]["status"]["away"] = "Няма на месцы";
$lang["adminlist"]["status"]["offline"] = "У афлайне";
$lang["adminlist"]["lastupdate"] = "Апошнее абнаўленне: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Агляд сервера";
$lang["svpb"]["takealook"] = "Зірнуць на &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Навіны";
$lang["index"]["showmore"] = "Чытаць далей";
$lang["index"]["showless"] = "Паказаць менш";

$lang["index"]["errortitle"] = "Памылка: каталог навін не знойдзены!";
$lang["index"]["errorsubtitle"] = "Калі ласка, ўпэўніцеся, што месцазнаходжанне тэчкі у <b><code>config/config.php</code></b> ўстаноўлена карэктна.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Агляд сервера";
$lang["viewer"]["lastupdate"] = "Апошнее абнаўленне: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Спіс забаненых";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Belarusian.json";
$lang["banlist"]["emptylist"] = "Спіс забаненых пусты";
$lang["banlist"]["lastupdate"] = "Апошнее абнаўленне: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(прычына адсутнічае)";
$lang["banlist"]["table"]["permaban"] = "Ніколі";

$lang["banlist"]["table"]["nickname"] = "Нік";
$lang["banlist"]["table"]["reason"] = "Прычына";
$lang["banlist"]["table"]["bannedby"] = "Забанены";
$lang["banlist"]["table"]["bandate"] = "Дата бана";
$lang["banlist"]["table"]["expires"] = "Заканчваецца";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Правілы сервера";
$lang["rules"]["filenotfound"] = "Памылка: файл <code>config/rules.md</code> не знойдзены!";
$lang["rules"]["readerror"] = "Памылка: няма доступу да файла <code>config/rules.md</code>!";
