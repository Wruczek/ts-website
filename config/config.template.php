<?php
/*
    Author: Wruczek
    Donate: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9PL5J7ULZQYJQ

    I am happy to take any programming-related requests, add additional features or modify the code to suit your needs for a small donation :)
    I am experienced at Java, PHP, HTML, CSS, Javascript, SQL, server configurations ect.
    For business enquiries only: wruczekk at gmail.com, for anything else please join Telegram chat.


    Need help? Join our telegram group for news, announcements, help and general chat about ts-website: https://t.me/tswebsite
*/



/************* General configuration *************/

$config["general"]["title"]         = "BestTS.NET";                                 // Website title - displayed in the menu
$config["general"]["icon"]          = "img/icon/icon-32.png";                       // Website icon
$config["general"]["subtitle"]      = " - Best TeamSpeak server!";                  // Website subtitle
$config["general"]["desc"]          = "Polski serwer TeamSpeak! Zapraszamy :)";     // Website description - displayed in Google search engine
$config["general"]["newsDir"]       = "config/news";                                // News folder (relative to project folder)
$config["general"]["timezone"]      = "Europe/Warsaw";                              // Your timezone - http://php.net/manual/en/timezones.php
$config["general"]["christmasmode"] = true;                                         // Set to false to permanently disable christmas mode activated in December

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

// TEMPLATE: (ICON is an icon name from: http://fontawesome.io/icons/)
// $config["navlinks"][] = ["icon", "displayed text", "link"];

$config["navlinks"][] = ["fab fa-facebook-square", "Facebook", "https://facebook.com/Facebook"];
$config["navlinks"][] = ["fab fa-twitter-square", "Twitter", "https://twitter.com/Twitter"];
$config["navlinks"][] = ["fas fa-comments", "Forum", "forum"];



/************* Adminlist configuration *************/

// ID of servergroups displayed as admins in Adminlist. Put it in the same way you want it to be displayed.
$config["adminlist"] = [6, 17, 19];



/************* Contact panel configuration *************/

$config['contact']['title'] = 'Contact the staff';

/*
TIP: You can remove all items below to hide contact panel

CONTACT PANEL SYNTAX:
$config['contact']['items'][] = ["name", "link description", "link"];

FOR EXAMPLE:
$config['contact']['items'][] = ["Telegram", "@Wruczek", "https://t.me/Wruczek"];
*/

$config['contact']['items'][] = ["TeamSpeak", "Support channel", "ts3server://teamspeakip?cid=30"];
$config['contact']['items'][] = ["Email", "contact@email.com", "mailto:contact@email.com"];
$config['contact']['items'][] = ["Telegram", "@Telegram", "https://t.me/Telegram"];
$config['contact']['items'][] = ["Twitter", "@Twitter", "https://twitter.com/Twitter"];
