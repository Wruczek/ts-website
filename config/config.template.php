<?php
/*
    Author: Wruczek
    Contact me:
        TeamSpeak: ts.wruczek.top
        Email: wruczekk@gmail.com
        Donate: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9PL5J7ULZQYJQ
*/



/************* General configuration *************/

$config["general"]["title"]         = "BestTS.NET";                                 // Website title - displayed in the menu
$config["general"]["icon"]          = "img/icon/icon-32.png";                       // Website icon
$config["general"]["subtitle"]      = " - Best TeamSpeak server!";                  // Website subtitle
$config["general"]["desc"]          = "Polski serwer TeamSpeak! Zapraszamy :)";     // Website description - displayed in Google search engine
$config["general"]["newsDir"]       = "config/news";                                // News folder (relative to project folder)

$config["general"]["enablehta"]     = false; // Enable / Disable additional website features (recommended, but
                                             // you need to have up-to-date version of Apache and install mod_rewrite)
                                             // After setting to true, go into .htaccess file and uncomment 19 line


/********* TeamSpeak configuration *********/

$config['teamspeak']['host']          = '127.0.0.1';          // TeamSpeak host address
$config['teamspeak']['login']         = 'serveradmin';        // Login
$config['teamspeak']['password']      = 'pa$$word';           // Password
$config['teamspeak']['server_port']   = 9987;                 // TeamSpeak server port
$config['teamspeak']['query_port']    = 10011;                // Query port
$config['teamspeak']['displayip']     = 'ts.server.net';       // IP shown to users and used for connections



/************* Additional navigation links - you can link to your stuff *************/

$config["navlinks"] = array(
    // TEMPLATE: array("icon", "displayed text", "link"), ICON is an icon name from: http://fontawesome.io/icons/
    array("fa-facebook-official", "Facebook", "https://facebook.com/bestteamspeakXd"),
    array("fa-comments", "Forum", "forum"),
    array("fa-shopping-cart", "Shop", "shop")
);



/************* Adminlist configuration *************/

// ID of servergroups displayed as admins in Adminlist. Put it in the same way you want it to be displayed.
$config["adminlist"] = array(6, 17, 19);



/************* Contact panel configuration *************/

// Set $config['contact']['text'] = ''; to hide this panel
$config['contact']['title'] = 'Contact the staff';
$config['contact']['text'] = '
<ul class="list-unstyled">
<li>TeamSpeak: <span class="pullright">channel <a href="ts3server://ts.wruczek.top?channel=Kana%C5%82y%20publiczne%2FPogaduchy%2FPogaduchy%205">Pomoc</a></span></li>
<li>Email: <span class="pullright"><a href="mailto:kontakt@email.com">konakt@email.com</a></span></li>
<li>GaduGadu: <span class="pullright"><a href="gg:123456789">123456789 <img src="https://status.gadu-gadu.pl/users/status.asp?id=49568758&styl=1"></a></span></li>
<li>Steam: <span class="pullright"><a href="http://steamcommunity.com/id/wruczek">Wruczek</a></span></li>
</ul>
';
