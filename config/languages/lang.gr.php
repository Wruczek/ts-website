<?php
/*
 * Greek language for ts-website
 * @copy Alligatoras
 */

$lang = array();

/************* General *************/

$lang["general"]["langcode"] = "el_GR";
$lang["general"]["scripterror"] = "Προέκυψε Σφάλμα! {0}: {1}";

/************* Navbar *************/

$lang["navbar"]["navigation"] = "Περιήγηση";

$lang["navbar"]["viewer"] = "Προβολή TS3";
$lang["navbar"]["bans"] = "Λίστα Αποκλεισμών";
$lang["navbar"]["rules"] = "Κανόνες";

$lang["navbar"]["connect"] = "Σύνδεση";
$lang["navbar"]["connecttooltip"] = "Κάντε κλικ για να συνδεθείτε στην IP: {0}";


/************* Footer *************/

$lang["footer"]["css"] = "CSS by";
$lang["footer"]["background"] = "background";


/************* Server status *************/

$lang["serverstatus"]["title"] = "Κατάσταση Server";
$lang["serverstatus"]["address"] = "Διεύθυνση";
$lang["serverstatus"]["loading"] = "Φορτώνει...";

$lang["serverstatus"]["online"] = "Σε Σύνδεση";
$lang["serverstatus"]["offline"] = "Εκτός Σύνδεσης";
$lang["serverstatus"]["uptime"] = "Συνδεσιμότητα";
$lang["serverstatus"]["version"] = "Έκδοση";
$lang["serverstatus"]["avgping"] = "Μέσος Όρος Ping";
$lang["serverstatus"]["avgpl"] = "Μέση Απώλεια Πακ.";


/************* Admin list *************/

$lang["adminlist"]["title"] = "Λίστα Διαχειριστών";
$lang["adminlist"]["emptygroup"] = "Αυτό το γκρουπ είναι άδειο.";
$lang["adminlist"]["status"]["online"] = "Online";
$lang["adminlist"]["status"]["away"] = "Away";
$lang["adminlist"]["status"]["offline"] = "Offline";
$lang["adminlist"]["lastupdate"] = "Τελευταία Ενημέρωση: {0}";


/************* Server viewer promo box (under adminlist and contact) *************/

$lang["svpb"]["title"] = "Προβολή TS3";
$lang["svpb"]["takealook"] = "Ρίξτε μια ματιά &raquo;";


/************************************/
/************* SUBPAGES *************/
/************************************/


/************* News - index.php *************/

$lang["index"]["title"] = "Νέα & Ειδοποιήσεις";
$lang["index"]["showmore"] = "Δείτε Περισσότερα";
$lang["index"]["showless"] = "Δείτε Λιγότερα";

$lang["index"]["errortitle"] = "Σημαντικό Σφάλμα: Ο κατάλογος για τα Νέα και τις Ειδοποιήσεις δεν βρέθηκε!";
$lang["index"]["errorsubtitle"] = "Παρακαλώ βεβαιωθείτε ότι θέση του καταλόγου στο <b><code>config/config.php</code></b> είναι σωστή.";


/************* Server viewer - viewer.php *************/

$lang["viewer"]["title"] = "Προβολή TS3";
$lang["viewer"]["lastupdate"] = "Τελευταία Ενημέρωση: {0}";


/************* Ban List - bans.php *************/

$lang["banlist"]["title"] = "Λίστα Αποκλεισμών";
$lang["banlist"]["datatablesurl"] = "//cdn.datatables.net/plug-ins/1.10.12/i18n/Greek.json";
$lang["banlist"]["emptylist"] = "Η λίστα αοκλεισμών είναι άδεια!";
$lang["banlist"]["lastupdate"] = "Τελευταία Ενημέρωση: {0}";

$lang["banlist"]["table"]["emptyreason"] = "(Χωρίς Λόγο)";
$lang["banlist"]["table"]["permaban"] = "Ποτέ";

$lang["banlist"]["table"]["nickname"] = "Όνομα";
$lang["banlist"]["table"]["reason"] = "Αιτία";
$lang["banlist"]["table"]["bannedby"] = "Αποκλείστηκε από";
$lang["banlist"]["table"]["bandate"] = "Ημερομηνία Αποκλεισμού";
$lang["banlist"]["table"]["expires"] = "Λήγει";

/************* Rules - rules.php *************/

$lang["rules"]["title"] = "Κανόνες";
$lang["rules"]["filenotfound"] = "Σημαντικό Σφάλμα: Το αρχείο <code>config/rules.md</code> δεν βρέθηκε!";
$lang["rules"]["readerror"] = "Σημαντικό Σφάλμα: Δεν υπάρχει πρόσβαση στο αρχείο <code>config/rules.md</code>!";
