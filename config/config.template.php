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
$config["general"]["theme"]         = "superhero";                                  // Motyw strony - http://bootswatch.com/ (ALPHA)
$config["general"]["icon"]          = "img/icon/icon-32.png";                       // Ikona używana na pasku nawigacji
$config["general"]["subtitle"]      = " - Najlepszy serwer Teamspeak!";             // Dodatkowy tekst dodawany do tytułu na pasku przeglądarki
$config["general"]["desc"]          = "Polski serwer TeamSpeak! Zapraszamy :)";     // Opis strony - wyświetlany np. w wynikach wyszukiwarki Google
$config["general"]["newsDir"]       = "config/news";                                // Folder z newsami (relatywnie do głównego folderu)

$config["general"]["enablehta"]     = false; // Właczenie / wyłączenie dodatkowych usprawnień strony w htaccess (zalecane,
                                             // wymaga jednak aktualnej wersji Apache oraz włączenia htaccess oraz mod_rewrite)


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

// ID grup wyświetlanych na liście administracji. Kolejność grup decyduje o kolejności wyświetlania na stronie
$config["adminlist"] = array(6, 17, 19);



/************* Konfiguracja panelu "kontakt" *************/

// Ustaw $config['contact']['text'] = ''; by kompletnie wyłączyć wyświetlanie panelu
$config['contact']['title'] = 'Kontakt z właścicielem';
$config['contact']['text'] = '
<ul class="list-unstyled">
<li>TeamSpeak: <span class="pullright">kanał <a href="ts3server://ts.wruczek.top?channel=Kana%C5%82y%20publiczne%2FPogaduchy%2FPogaduchy%205">Pomoc</a></span></li>
<li>Email: <span class="pullright"><a href="mailto:kontakt@email.com">konakt@email.com</a></span></li>
<li>GaduGadu: <span class="pullright"><a href="gg:49568758">49568758 <img src="http://status.gadu-gadu.pl/users/status.asp?id=49568758&styl=1"></a></span></li>
<li>Steam: <span class="pullright"><a href="http://steamcommunity.com/id/wruczek">Wruczek</a></span></li>
</ul>
';
