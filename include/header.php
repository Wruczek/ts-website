<?php
$start = microtime(true);
require_once __DIR__ . "/../include/modulecheck.php";
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../include/language.php";
require_once __DIR__ . "/../include/adminlist.php";

$htalink = $config["general"]["enablehta"] ? "" : ".php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="<?php echo $config["general"]["desc"]; ?>">
    <meta name="author" content="Wruczek">

    <title><?php echo $config["general"]["title"] . $config["general"]["subtitle"]; ?></title>

    <!-- Icon -->
    <link rel="shortcut icon" href="img/icon/icon-64.png">

    <!-- Bootswatch -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.7/superhero/bootstrap.min.css" rel="stylesheet">
    <link href="css/theme.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <?php if(isset($bansPage)) { ?>
    <!-- DataTables for Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <?php } ?>

    <link href="css/flags/famfamfam-flags.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <?php if(!empty($config["general"]["christmasmode"])) { ?>
    <script src="js/christmas.js"></script>
    <?php } ?>

    <script src="api/i18n.php"></script>

    <!--[if IE]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only"><?php tl($lang["navbar"]["navigation"]); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" href="."><img style="width: 64px;" src="img/icon/icon-64.png" alt="Logo strony"><?php echo $config["general"]["title"]; ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="viewer<?php echo $htalink ?>"><i class="fa fa-eye" aria-hidden="true"></i> <?php tl($lang["navbar"]["viewer"]); ?></a></li>
                    <li><a href="bans<?php echo $htalink ?>"><i class="fa fa-ban" aria-hidden="true"></i> <?php tl($lang["navbar"]["bans"]); ?></a></li>
                    <li><a href="rules<?php echo $htalink ?>"><i class="fa fa-book" aria-hidden="true"></i> <?php tl($lang["navbar"]["rules"]); ?></a></li>
                    <!-- Nie mam na to czasu
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-television" aria-hidden="true"></i></i>Ranking <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i>Ranking Aktywności</a></li>
                            <li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i>Ranking Połaczeń</a></li>
                            <li><a href="#"><i class="fa fa-sign-out" aria-hidden="true"></i>Ranking Połączenia</a></li>
                        </ul>
                    </li>
                    -->
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php foreach ($config["navlinks"] as $navlink) {
                        $icon = $navlink[0];
                        $text = $navlink[1];
                        $link = $navlink[2]; ?>
                    <li><a href="<?php echo $link; ?>"><i class="fa <?php echo $icon; ?>" aria-hidden="true"></i> <?php echo $text; ?></a></li>
                    <?php } ?>

                    <li data-toggle="tooltip" data-placement="bottom" title="<?php tl($lang["navbar"]["connecttooltip"], [$config['teamspeak']['displayip']]); ?>"><a href="ts3server://<?php echo $config['teamspeak']['displayip']; ?>"><i class="fa fa-sign-in" aria-hidden="true"></i><?php tl($lang["navbar"]["connect"]); ?></a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="famfamfam-flags <?php echo $langcode == "en" ? "gb" : $langcode; ?>" aria-hidden="true"></i> Language <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="?lang=en"><i class="famfamfam-flags gb" aria-hidden="true"></i> English</a></li>
                            <li><a href="?lang=pl"><i class="famfamfam-flags pl" aria-hidden="true"></i> Polski</a></li>
                            <li><a href="?lang=de"><i class="famfamfam-flags de" aria-hidden="true"></i> Deutsch</a></li>
                            <li><a href="?lang=nl"><i class="famfamfam-flags nl" aria-hidden="true"></i> Nederlands</a></li>
                            <li><a href="?lang=ru"><i class="famfamfam-flags ru" aria-hidden="true"></i> Русский</a></li>
                            <li><a href="?lang=by"><i class="famfamfam-flags by" aria-hidden="true"></i> Беларуская мова</a></li>
                            <li><a href="?lang=tr"><i class="famfamfam-flags tr" aria-hidden="true"></i> Türkçe</a></li>
                            <li><a href="?lang=cz"><i class="famfamfam-flags cz" aria-hidden="true"></i> Česky</a></li>
                            <li><a href="?lang=br"><i class="famfamfam-flags br" aria-hidden="true"></i> Português</a></li>
                            <li><a href="?lang=fr"><i class="famfamfam-flags fr" aria-hidden="true"></i> Français</a></li>
                            <li><a href="?lang=it"><i class="famfamfam-flags it" aria-hidden="true"></i> Italiano</a></li>
                            <li><a href="?lang=ua"><i class="famfamfam-flags ua" aria-hidden="true"></i> Українська</a></li>
                            <li><a href="?lang=es"><i class="famfamfam-flags es" aria-hidden="true"></i> Español</a></li>
                            <li><a href="?lang=gr"><i class="famfamfam-flags gr" aria-hidden="true"></i> Ελληνικά</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="container">

        <div class="row">

            <div class="col-md-3 col-md-push-9">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i> <?php tl($lang["serverstatus"]["title"]); ?></div>
                    <div class="panel-body">
                        <div class="serverstatus">
                            <p><i class="fa fa-globe fa-fw" aria-hidden="true"></i> <?php tl($lang["serverstatus"]["address"]); ?>: <a href="ts3server://<?php echo $config['teamspeak']['displayip']; ?>"><?php echo $config['teamspeak']['displayip']; ?></a></p>
                            <div id="serverstatus">
                                <div class="text-center">
                                    <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
                                    <span class="sr-only"><?php tl($lang["serverstatus"]["loading"]); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-shield" aria-hidden="true"></i> <?php tl($lang["adminlist"]["title"]); ?> <span class="pull-right"><i class="fa fa-question-circle" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="<?php tl($lang["adminlist"]["lastupdate"], [$adminlist[1]]); ?>"></i></span></div>
                    <div class="panel-body adminlist">
                        <?php echo $adminlist[0]; ?>
                    </div>
                </div>

                <?php if(!empty($config['contact']['items'])) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-envelope" aria-hidden="true"></i> <?php echo $config['contact']['title']; ?></div>
                    <div class="panel-body">
                        <ul class="list-unstyled">
                            <?php foreach ($config['contact']['items'] as $item) {
                                $name = $item[0];
                                $linkdesc = $item[1];
                                $link = $item[2];
                                echo '<li>' . $name . ' <span class="pull-right"><a href="' . $link . '">' . $linkdesc . '</a></span></li>';
                            } ?>
                        </ul>
                    </div>
                </div>
                <?php } ?>

                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-eye" aria-hidden="true"></i> <?php tl($lang["svpb"]["title"]); ?></div>
                    <div class="panel-body">
                        <a href="viewer<?php echo $htalink ?>" class="btn btn-primary btn-lg btn-block"><i class="fa fa-eye" aria-hidden="true"></i> <?php tl($lang["svpb"]["takealook"]); ?></a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-md-pull-3">
