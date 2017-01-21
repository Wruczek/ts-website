<?php
/*
 * Ukrainian language for ts-website
 * @copy TRID <admin@live.ovh>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "uk_UA";
$lang["general"]["scripterror"] = "Виникла помилка! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Навігація";

$lang["navbar"]["viewer"] = "Огляд сервера";
$lang["navbar"]["bans"] = "Перелік заблокованих";
$lang["navbar"]["rules"] = "Правила сервера";

$lang["navbar"]["connect"] = "Підключитися";
$lang["navbar"]["connecttooltip"] = "Натисніть, щоб підключитися до {0}";


/************* Footer *************/

$lang["footer"]["website"] = "Веб-сайт";
$lang["footer"]["css"] = "CSS завдяки люб'язності";
$lang["footer"]["background"] = "фон";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Статус сервера";
$lang["serverstatus"]["address"] = "Адрес";
$lang["serverstatus"]["loading"] = "Завантаження...";

$lang["serverstatus"]["online"] = "В мережі";
$lang["serverstatus"]["offline"] = "Не в мережі";
$lang["serverstatus"]["uptime"] = "Аптайм";
$lang["serverstatus"]["version"] = "Версія";
$lang["serverstatus"]["avgping"] = "Сер. пінг";
$lang["serverstatus"]["avgpl"] = "Сер. втрата пакетів";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Статус адміністрації";
$lang["adminlist"]["emptygroup"] = "Ця група порожня";
$lang["adminlist"]["status"]["online"] = "В мережі";
$lang["adminlist"]["status"]["away"] = "Немає на місці";
$lang["adminlist"]["status"]["offline"] = "Не в мережі";
$lang["adminlist"]["lastupdate"] = "Останнє оновлення: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Огляд сервера";
$lang["svpb"]["takealook"] = "Поглянути &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Новини";
$lang["index"]["showmore"] = "Читати далі";
$lang["index"]["showless"] = "Показати менше";

$lang["index"]["errortitle"] = "Помилка: каталога новин не знайдено!";
$lang["index"]["errorsubtitle"] = "Будь ласка, переконайтеся, що місце розташування папки в <b><code>config/config.php</code></b> встановлено коректно.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Огляд сервера";
$lang["viewer"]["lastupdate"] = "Останнє оновлення: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Перелік заблокованих";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Russian.json";
$lang["banlist"]["emptylist"] = "Перелік заблокованих порожній";
$lang["banlist"]["lastupdate"] = "Останнє оновлення: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(не вказано причини)";
$lang["banlist"]["table"]["permaban"] = "Ніколи";

$lang["banlist"]["table"]["nickname"] = "Нік";
$lang["banlist"]["table"]["reason"] = "Причина";
$lang["banlist"]["table"]["bannedby"] = "Забанен";
$lang["banlist"]["table"]["bandate"] = "Дата бана";
$lang["banlist"]["table"]["expires"] = "Завершується";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Правила сервера";
$lang["rules"]["filenotfound"] = "Помилка: файл <code>config/rules.md</code> не знайден!";
$lang["rules"]["readerror"] = "Помилка: немає доступу до файлу <code>config/rules.md</code>!";