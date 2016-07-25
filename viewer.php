<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/tsutils.php";
require_once __DIR__ . "/lib/phpfastcache/autoload.php";


use phpFastCache\Util;
use phpFastCache\CacheManager;

Util\Languages::setEncoding("UTF-8");
$cache = CacheManager::Files();

$tsviewer = $cache->get('tsviewer');

// $cache->clean();

if (is_null($tsviewer)) {
    $tsviewer = array(getViewer(), date('d-m-Y H:i:s'));
    $cache->set('tsviewer', $tsviewer, 300);
}

// print_r ($tsviewer);

function getViewer() {
    global $lang;

    try {
        $tsAdmin = TeamSpeak3::factory(getTeamspeakURI(). "#no_query_clients");
        return $tsAdmin->getViewer(new TeamSpeak3_Viewer_Html("lib/ts3phpframework/images/viewer/", "lib/ts3phpframework/images/flags/", "data:image"));
    } catch(TeamSpeak3_Exception $e) {
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
        <?php tl($lang["viewer"]["lastupdate"], [$tsviewer[1]]); ?><!-- <span style="float: right">Podgląd odświerza się co 30 sekund</span> -->
    </div>
</div>

<?php
require_once __DIR__ . "/include/footer.php";
?>
