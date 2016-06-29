<?php

/* Od wersji 1.2.0 sprawny htaccess nie jest już wymagany
if (!isset($_SERVER['HTACCESS'])) {
    
    $title = 'Plik .htaccess nie jest włączony';
    
    $text = '<p>Strona wymaga włączonej obsługi pliku <code>.htaccess</code>.</p>
            <p><a href="https://www.digitalocean.com/community/tutorials/how-to-use-the-htaccess-file">Poradnik na temat właczania pliku htaccess</a></p>';
    
    die(showError($title, $text));
}
*/

/* Od wersji 1.2.0 mod_rewrite nie jest już wymagany
if(!in_array('mod_rewrite', apache_get_modules())) {
    
    $title = 'Brak wymaganych rozszerzeń';
    
    $text = '<p>Na swoim serwerze nie posiadasz modułu <code>rewrite</code> wymaganego do poprawnego działania tej strony.</p>
            <p>Posiadasz system Ubuntu? Świetnie! Uruchom poniższe komendy, by włączyć wymagany moduł:</p>
<pre>sudo a2enmod rewrite
sudo service apache2 reload</pre>
            <p>Używasz system Debian? Uruchom owe komendy pomijając przedrostek <code>sudo</code>:</p>
<pre>a2enmod rewrite
service apache2 reload</pre>
            <p>Jeśli używasz hostingu i nie masz dostępu do konsoli, skontaktuj się z administratorem lub pomocą techniczną Twojego hostingu.</p>';
    
    die(showError($title, $text));
}
*/

if(!file_exists(__DIR__ . "/../config/config.php")) {
    
    $title = 'Brak pliku config.php';
    
    $text = '<p>Przejdź do folderu <code>config</code> i zmień nazwę pliku z <code>config.template.php</code> na <code>config.php</code>.</p>
            <p>Skonfiguruj stronę według własnych potrzeb.</p>';
    
    die(showError($title, $text));
}


// FUNCTION

function showError($title, $text) { ?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Brak wymaganych rozszerzeń">
    <meta name="author" content="Wruczek">

    <title><?php echo $title; ?></title>

    <!-- Icon -->
    <link rel="shortcut icon" href="https://assets-cdn.github.com/images/icons/emoji/unicode/26a0.png">

    <!-- Twitter Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.6/superhero/bootstrap.min.css" rel="stylesheet">

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style>
        body { margin-top: 70px }
    </style>
</head>

<body>
    <div class="container">

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><img src="https://assets-cdn.github.com/images/icons/emoji/unicode/26a0.png" width="20px"> <?php echo $title; ?></h3>
        </div>
        <div class="panel-body">
            <?php echo $text; ?>
        </div>
        <div class="panel-footer">
            Strona &copy; <a href="http://wruczek.top">Wruczek</a> 2016 | <a href="https://github.com/Wruczek/ts-website">ts-website</a> v 1.2.0 | MIT License
        </div>
    </div>

    </div>
    <!-- /container -->
</body>

</html>
<?php }
