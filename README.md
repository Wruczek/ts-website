<p align="center">
<b>Need help? <a href="https://telegram.me/tswebsite">Join our telegram group</a></b> for news, announcements, help and general chat about ts-website.
</p>

<br>

[![Website screenshot](http://i.imgur.com/9UZV6NG.png)](http://imgur.com/a/RUSi2)

<p align="center"><a href="http://imgur.com/a/RUSi2">More screenshots</a></p>

<br>

**ts-website** - free website for your TeamSpeak 3 server<br>

#### Useful links
- [Demo](https://ts.wruczek.tech/)
- [Download](https://github.com/Wruczek/ts-website/archive/master.zip)
- [Report Issues](https://github.com/Wruczek/ts-website/issues/new)
- **[ts-website Telegram group](https://telegram.me/tswebsite) - help, announcements, and general chat**

<br>

**I am happy to take any programming-related requests, add additional features or modify the code to suit your needs** for a small donation :) I am experienced at Java, PHP, HTML, CSS, Javascript, SQL, server configurations ect.

For business enquiries only: **wruczekk** at **gmail.com**, for anything else please join Telegram chat.

#### Main Features
- News page, dynamic server status, admin list with status, server viewer, ban list and rules page
- Multiple languages with auto-detection for default language
- PHP 7.0, Apache 2 and nginx support
- Modern and responsive design
- Caching [WIP]
- Free, Open source, under MIT license

#### Christmas update
[Christmas update](http://i.imgur.com/R0lPz6b.png) introduced on the 01 December 2016 adds a new theme, background and snow effect.
Website checks the user's date on the device and enables the effects throughout the whole December.

If you want to enable this feature, make sure you have ``$config["general"]["christmasmode"]`` set to ``true`` in your config file. Set it to ``false`` will disable this theme forever for everyone.

### Requirements
PHP Installation:
- PHP 5.5 or newer (although latest PHP version is highly recommended!)
- Installed and enabled ``mbstring`` extension

Recommended nginx configuration:
 - Up-to-date nginx server
 - ``enablehta`` in config.php set to ``true``
 - nginx config set to the following: (**Remember that you need to adjust this config to suit your server!**)
 ````
 server {
 	listen 80 default_server;
 	listen [::]:80 default_server;
 
 	root /var/www/html;
 
 	# Add index.php to the list if you are using PHP
 	index index.php index.html index.htm;
 
 	server_name _;
 
 	location / {
 		# First attempt to serve request as file, then
 		# as directory, then fall back to displaying a 404.
 		try_files $uri $uri/ $uri.html $uri.php$is_args$query_string;
 	}
 
 	# pass the PHP scripts to FastCGI server listening on 127.0.0.1:9000
 	
 	location ~ \.php$ {
 		include snippets/fastcgi-php.conf;
 	
 		# With php7.0-cgi alone:
 		#fastcgi_pass 127.0.0.1:9000;
 		# With php7.0-fpm:
 		fastcgi_pass unix:/run/php/php7.0-fpm.sock;
 	}
 
 	 #deny access to .htaccess files, if Apache's document root
 	 #concurs with nginx's one
 	location ~ /\.ht {
 		deny all;
 	}
 
 	#error pages - REMEBER TO CHANGE THE PATH!
 	error_page 403 /path_to_ts-website_please_change_me/errorpages/403.html;
 	error_page 404 /path_to_ts-website_please_change_me/errorpages/404.html;
 	error_page 500 502 503 504 /path_to_ts-website_please_change_me/errorpages/500.html;
 }
 ````

Recommended Apache configuration:
 - Up-to-date Apache server
 - Enabled mod_rewrite (``sudo a2enmod rewrite && sudo service apache2 restart``)
 - Enabled support of htaccess
 - ``enablehta`` in config.php set to ``true``

**If you experience any problems, make sure that directory ``/var/www`` is writeable.**

<br><br>
<p align="center">
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9PL5J7ULZQYJQ" target="_blank"><img src="https://i.imgur.com/s1u7rju.png?1"></a>
</p>
