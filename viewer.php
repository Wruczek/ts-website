<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/tsutils.php";
require_once __DIR__ . "/include/cacheutils.class.php";

$cacheutils = new CacheUtils('tsviewer');

if($cacheutils->isExpired()) {
    $cacheutils->setValue([getViewer(), date('d-m-Y H:i:s')], 300);
}

$tsviewer = $cacheutils->getValue();

// print_r ($tsviewer);

function getViewer() {
    global $lang;

    try {
        $tsAdmin = getTeamspeakConnection("#no_query_clients");
        $base = "lib/ts3phpframework/images";
        return $tsAdmin->getViewer(new TeamSpeak3_Viewer_Html("$base/viewer/", "$base/flags/", "data:image"));
    } catch (TeamSpeak3_Exception $e) {
        return '<div class="alert alert-danger"><p class="text-center">' . translate($lang["general"]["scripterror"], [$e->getCode(), $e->getMessage()]) . '</p></div>';
    }
}

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-eye" aria-hidden="true"></i> <?php tl($lang["viewer"]["title"]); ?></h3>
    </div>
    <div class="panel-body">
        <?php echo $tsviewer[0]; ?>
    </div>
    <div class="panel-footer">
        <?php tl($lang["viewer"]["lastupdate"], [$tsviewer[1]]); ?><!-- <span style="float: right">Podgląd odświeża się co 30 sekund</span> -->
    </div>
</div>

<?php
require_once __DIR__ . "/include/footer.php";
?>
