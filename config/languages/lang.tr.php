<?php
/*
 * Turkish language for ts-website
 * @copy Eikichi <kontakt@eiki.moe>
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "tr_TR";
$lang["general"]["languageflag"] = "tr";
$lang["general"]["scripterror"] = "Bir hata olmustur! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Navigasyon";

$lang["navbar"]["viewer"] = "Sunucu Görüntüleyici";
$lang["navbar"]["bans"] = "Ban listesi";
$lang["navbar"]["rules"] = "Sunucu kurallari";

$lang["navbar"]["connect"] = "Sunucuya Baglan";
$lang["navbar"]["connecttooltip"] = "Baglanmak için {0} tiklayin";


/************* Footer *************/

$lang["footer"]["css"] = "CSS tarafindan saglanan";
$lang["footer"]["background"] = "Arka plân";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Sunucu durumu";
$lang["serverstatus"]["address"] = "Adres";
$lang["serverstatus"]["loading"] = "Yükleme...";

$lang["serverstatus"]["online"] = "Online";
$lang["serverstatus"]["offline"] = "Offline";
$lang["serverstatus"]["uptime"] = "Çalisma süresi";
$lang["serverstatus"]["version"] = "Sunucu sürümü";
$lang["serverstatus"]["avgping"] = "Ø Ping";
$lang["serverstatus"]["avgpl"] = "Ø Paket kaybi";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Yönetici listesi";
$lang["adminlist"]["emptygroup"] = "Bu grup bos";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Yok";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Son güncelleme: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Sunucu Görüntüleyici";
$lang["svpb"]["takealook"] = "Görüntüle &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Haber";
$lang["index"]["showmore"] = "Daha görüntüle";
$lang["index"]["showless"] = "Daha az";

$lang["index"]["errortitle"] = "Hata: Haber klasörü bulunamadi!";
$lang["index"]["errorsubtitle"] = "Klasör yolu <code>config / config.php</code> dogru belirtilen emin olun.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Sunucu Görüntüleyici";
$lang["viewer"]["lastupdate"] = "Son güncelleme: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Ban listesi";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Turkish.json";
$lang["banlist"]["emptylist"] = "Hiçbir lanetli Kullanici su anda yok";
$lang["banlist"]["lastupdate"] = "Son güncelleme: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(Verilen hiçbir neden)";
$lang["banlist"]["table"]["permaban"] = "Asla";

$lang["banlist"]["table"]["nickname"] = "Kullanici adi";
$lang["banlist"]["table"]["reason"] = "Neden";
$lang["banlist"]["table"]["bannedby"] = "Banlayan kisi";
$lang["banlist"]["table"]["bandate"] = "Ban zaman";
$lang["banlist"]["table"]["expires"] = "Sona eriyor";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Sunucu kurallari";
$lang["rules"]["filenotfound"] = "Hata: Dosya <code>config / rules.md</code> bulunamadi!";
$lang["rules"]["readerror"] = "Hata: erisim için yeterli haklar <code>config / rules.md</code>!";
