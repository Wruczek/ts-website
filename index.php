<?php
require_once dirname(__FILE__) . "/include/modulecheck.php";
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/lib/parsedown/parsedown.php";
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title news-header"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <?php tl($lang["index"]["title"]); ?></h3>
    </div>
</div>

<!-- NEWSY -->

<?php

$parsedown = new Parsedown();

$path = __DIR__ . "/" . $config["general"]["newsDir"];

if(file_exists($path))
    showNews($path);
else
    echo '<div class="alert alert-danger"><p class="text-center">' . translate($lang["index"]["errortitle"]) . '</p><p class="text-center">' . translate($lang["index"]["errorsubtitle"]) . '</p></div>';

// *******
// METHODS
// *******

function showNews($path) {
    global $parsedown;

    $files = array_diff(scandir($path), array('..', '.'));
    foreach ($files as $newsFile) {

        if(!endsWith($newsFile, ".md"))
            continue;

        $file = readFileContent($path . "/" . $newsFile);
        $lines = explode("\n", $file);

        $title = $lines[0];
        $author = $lines[1];
        $text = implode("\n", array_slice($lines, 3));

        generateNewsBox($title, $author, $parsedown->text($text));
    }
}

function generateNewsBox($title, $author, $text) { ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><div class="row"><div class="col-md-8"><i class="fa fa-info-circle" aria-hidden="true"></i> <?php echo $title; ?></div><div class="col-md-4 news-author"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $author; ?></div></div></h3>
    </div>
    <div class="panel-body news-body">
        <?php echo $text; ?>
    </div>
</div>
<?php }

function readFileContent($file) {
    $fopen = @fopen($file, "r");
    if(!$fopen) return false;
    $text = fread($fopen,filesize($file));
    fclose($fopen);
    return $text;
}

function endsWith($haystack, $needle) {
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}


require_once __DIR__ . "/include/footer.php";
?>
