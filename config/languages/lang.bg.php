<?php
/*
 * Bulgarian language for ts-website
 * @copy toster234 <contact@csgo-24.pl>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "bg_BG";
$lang["general"]["scripterror"] = "Възникна грешка! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "навигация";

$lang["navbar"]["viewer"] = "Преглед на сървъра";
$lang["navbar"]["bans"] = "банове";
$lang["navbar"]["rules"] = "правилник";

$lang["navbar"]["connect"] = "Се свърже със сървъра";
$lang["navbar"]["connecttooltip"] = "Кликнете, за да се свържете със сървъра {0}";


/************* Footer *************/

$lang["footer"]["website"] = "страница";
$lang["footer"]["css"] = "CSS учтивост";
$lang["footer"]["background"] = "фон";


/************* Server status *************/

$lang["serverstatus"]["title"] = "сървъра Status";
$lang["serverstatus"]["address"] = "адрес";
$lang["serverstatus"]["loading"] = "товарене...";

$lang["serverstatus"]["online"] = "онлайн";
$lang["serverstatus"]["offline"] = "на линия";
$lang["serverstatus"]["uptime"] = "Uptime";
$lang["serverstatus"]["version"] = "версия";
$lang["serverstatus"]["avgping"] = "Средната пинг";
$lang["serverstatus"]["avgpl"] = "Средната загуба на пакет";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Статус администрация";
$lang["adminlist"]["emptygroup"] = "Тази група е празна";
$lang["adminlist"]["status"]["online"] = "онлайн";
$lang["adminlist"]["status"]["away"] = "далеч";
$lang["adminlist"]["status"]["offline"] = "на линия";
$lang["adminlist"]["lastupdate"] = "към {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Преглед на сървъра";
$lang["svpb"]["takealook"] = "изглед &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Публикации";
$lang["index"]["showmore"] = "Покажи още";
$lang["index"]["showless"] = "Покажи по-малко";

$lang["index"]["errortitle"] = "Грешка: папката на новини не е намерен.";
$lang["index"]["errorsubtitle"] = "Уверете се, местоположението, зададено във файла <code>config/config.php</code> Това е правилно.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Преглед на сървъра";
$lang["viewer"]["lastupdate"] = "към {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "банове";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Bulgarian.json";
$lang["banlist"]["emptylist"] = "NO забранени потребители";
$lang["banlist"]["lastupdate"] = "към {0}";

$lang["banlist"]["table"]["emptyreason"] = "(Няма причина)";
$lang["banlist"]["table"]["permaban"] = "някога";

$lang["banlist"]["table"]["nickname"] = "Nick";
$lang["banlist"]["table"]["reason"] = "причина";
$lang["banlist"]["table"]["bannedby"] = "забранена от";
$lang["banlist"]["table"]["bandate"] = "Дата на забрана";
$lang["banlist"]["table"]["expires"] = "изтича";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "правила за сървъри";
$lang["rules"]["filenotfound"] = "Грешка: файл <code>config/rules.md</code> Той не е намерен!";
$lang["rules"]["readerror"] = "Грешка: не може да чете файл <code>config/rules.md</code>!";
