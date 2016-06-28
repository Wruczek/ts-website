<?php if(!file_exists(__DIR__ . "/../config/config.php")) { ?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Brak wymaganych rozszerzeń">
    <meta name="author" content="Wruczek">

    <title>BŁĄD: Brak pliku config.php</title>

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
            <h3 class="panel-title"><img src="https://assets-cdn.github.com/images/icons/emoji/unicode/26a0.png" width="20px">Brak pliku config.php</h3>
        </div>
        <div class="panel-body">
            <p>Przejdź do folderu <code>config</code> i zmień nazwę pliku z <code>config.template.php</code> na <code>config.php</code>.</p>
            <p>Skonfiguruj stronę według własnych potrzeb.</p>
        </div>
    </div>

    </div>
    <!-- /container -->
</body>

</html>

<?php
die();
}
