<?php
/*
 * Russian language for ts-website
 * @copy TRID <admin@awp.by>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "ru_RU";
$lang["general"]["scripterror"] = "Произошла ошибка! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Навигация";

$lang["navbar"]["viewer"] = "Обзор сервера";
$lang["navbar"]["bans"] = "Список забаненных";
$lang["navbar"]["rules"] = "Правила сервера";

$lang["navbar"]["connect"] = "Подключиться";
$lang["navbar"]["connecttooltip"] = "Нажмите, чтобы подключиться к {0}";


/************* Footer *************/

$lang["footer"]["website"] = "Веб-сайт";
$lang["footer"]["css"] = "CSS благодаря любезности";
$lang["footer"]["background"] = "фон";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Статус сервера";
$lang["serverstatus"]["address"] = "Адрес";
$lang["serverstatus"]["loading"] = "Загрузка...";

$lang["serverstatus"]["online"] = "В сети";
$lang["serverstatus"]["offline"] = "Не в сети";
$lang["serverstatus"]["uptime"] = "Аптайм";
$lang["serverstatus"]["version"] = "Версия";
$lang["serverstatus"]["avgping"] = "Средний пинг";
$lang["serverstatus"]["avgpl"] = "Ср. потеря пакетов";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Статус администрации";
$lang["adminlist"]["emptygroup"] = "Эта группа пуста";
$lang["adminlist"]["status"]["online"] = "В сети";
$lang["adminlist"]["status"]["away"] = "Нет на месте";
$lang["adminlist"]["status"]["offline"] = "Не в сети";
$lang["adminlist"]["lastupdate"] = "Последнее обновление: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Обзор сервера";
$lang["svpb"]["takealook"] = "Взглянуть &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Новости";
$lang["index"]["showmore"] = "Читать дальше";
$lang["index"]["showless"] = "Показать меньше";

$lang["index"]["errortitle"] = "Ошибка: каталог новостей не найден!";
$lang["index"]["errorsubtitle"] = "Пожалуйста, убедитесь, что местоположение папки в <b><code>config/config.php</code></b> установлено корректно.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Обзор сервера";
$lang["viewer"]["lastupdate"] = "Последнее обновление: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Список забаненных";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Russian.json";
$lang["banlist"]["emptylist"] = "Список забаненных пуст";
$lang["banlist"]["lastupdate"] = "Последнее обновление: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(причина не указана)";
$lang["banlist"]["table"]["permaban"] = "Никогда";

$lang["banlist"]["table"]["nickname"] = "Ник";
$lang["banlist"]["table"]["reason"] = "Причина";
$lang["banlist"]["table"]["bannedby"] = "Забанен";
$lang["banlist"]["table"]["bandate"] = "Дата бана";
$lang["banlist"]["table"]["expires"] = "Истекает";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Правила сервера";
$lang["rules"]["filenotfound"] = "Ошибка: файл <code>config/rules.md</code> не найден!";
$lang["rules"]["readerror"] = "Ошибка: нет доступа к файлу <code>config/rules.md</code>!";
