<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/lib/parsedown/parsedown.php";

$parsedown = new Parsedown();

$path = __DIR__ . "/config/rules.md";

if(!file_exists($path)) {
    echo '<div class="alert alert-danger"><p class="text-center">' . translate($lang["rules"]["filenotfound"]) . '</div>';
} else {
    $file = readFileContent($path);

    if(!$file) {
        echo '<div class="alert alert-danger"><p class="text-center">' . translate($lang["rules"]["readerror"]) . '</div>';
    } else {
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-book" aria-hidden="true"></i> <?php tl($lang["rules"]["title"]); ?></h3>
    </div>
    <div class="panel-body">
        <?php echo $parsedown->text($file); ?>
    </div>
</div>
<?php
}}

// *******
// METHODS
// *******

function readFileContent($file) {
    $fopen = @fopen($file, "r");
    if(!$fopen) return false;
    $text = fread($fopen,filesize($file));
    fclose($fopen);
    return $text;
}


require_once __DIR__ . "/include/footer.php";
?>
