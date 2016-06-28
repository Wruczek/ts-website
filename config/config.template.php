<?php
/*
    Autor: Wruczek
    Kontakt:
        TeamSpeak: ts.wruczek.top
        E-mail: wruczekk@gmail.com
        Prześlij dotację: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9PL5J7ULZQYJQ
*/



/************* Konfiguracja generalna strony *************/

$config["general"]["title"]         = "TwojTS.PL";                                  // Tytuł strony - wyświetlany np. w menu i na pasku nawigacji
$config["general"]["icon"]          = "img/icon/icon-32.png";                       // Ikona używana na pasku nawigacji
$config["general"]["subtitle"]      = " - Najlepszy serwer Teamspeak!";             // Dodatkowy tekst dodawany do tytułu na pasku przeglądarki
$config["general"]["desc"]          = "Polski serwer TeamSpeak! Zapraszamy :)";     // Opis strony - wyświetlany np. w wynikach wyszukiwarki Google
$config["general"]["newsDir"]       = "news";                                       // Folder z newsami (relatywnie do głównego folderu)
$config["general"]["contactEmail"]  = "email@strona.pl";                            // Twój email kontaktowy



/********* Konfiguracja serwera TeamSpeak *********/

$config['teamspeak']['host']          = '127.0.0.1';          // Adres serwera TeamSpeak
$config['teamspeak']['login']         = 'serveradmin';        // Login konta Query
$config['teamspeak']['password']      = 'pa$$word';           // Hasło konta Query
$config['teamspeak']['server_port']   = 9987;                 // Port serwera TeamSpeak
$config['teamspeak']['query_port']    = 10011;                // Port Query
$config['teamspeak']['displayip']     = 'ts.serwer.pl';       // IP wyświetlane na stronie i używane do połączeń



/************* Dodatkowe linki na pasku nawigacji *************/

$config["navlinks"] = array(
    // WZÓR: array("ikona", "tekst", "link") GDZIE ikona to nazwa ikony ze strony: http://fontawesome.io/icons/
    array("fa-facebook-official", "Facebook", "https://facebook.com/najlepszytsXd"),
    array("fa-comments", "Forum", "forum"),
    array("fa-shopping-cart", "Sklep", "sklep")
);

/************* Konfiguracja listy administratorow *************/

// ID grup wyświetlanych na liście administracji
$config["adminlist"] = array(6, 17, 19);
