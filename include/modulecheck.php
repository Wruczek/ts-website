<?php if(!in_array('mod_rewrite', apache_get_modules())) { ?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Brak wymaganych rozszerzeń">
    <meta name="author" content="Wruczek">

    <title>BŁĄD: Brak wymaganych rozszerzeń</title>

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
            <h3 class="panel-title"><img src="https://assets-cdn.github.com/images/icons/emoji/unicode/26a0.png" width="20px">Brak wymaganych rozszerzeń</h3>
        </div>
        <div class="panel-body">
            <p>Na swoim serwerze nie posiadasz modułu <code>rewrite</code> wymaganego do poprawnego działania tej strony.</p>
            <p>Posiadasz system Ubuntu? Świetnie! Uruchom poniższe komendy, by włączyć wymagany moduł:</p>
<pre>sudo a2enmod rewrite
sudo service apache2 reload</pre>
            <p>Używasz system Debian? Uruchom owe komendy pomijając przedrostek <code>sudo</code>:</p>
<pre>a2enmod rewrite
service apache2 reload</pre>
            <p>Jeśli używasz hostingu i nie masz dostępu do konsoli, skontaktuj się z administratorem lub pomocą techniczną Twojego hostingu.</p>
        </div>
    </div>

    </div>
    <!-- /container -->
</body>

</html>

<?php
die();
}
