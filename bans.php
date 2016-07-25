<?php
$bansPage = true;
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/tsutils.php";
require_once __DIR__ . "/lib/phpfastcache/autoload.php";



use phpFastCache\Util;
use phpFastCache\CacheManager;

Util\Languages::setEncoding("UTF-8");
$cache = CacheManager::Files();

$banlist = $cache->get('banlist');

// $cache->clean();

if (is_null($banlist)) {
    $banlist = array(getBanlist(), date('d-m-Y H:i:s'));
    $cache->set('banlist', $banlist, 600);
}


?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-ban" aria-hidden="true"></i> <?php tl($lang["banlist"]["title"]); ?></h3>
    </div>
    <div class="panel-body">

        <?php if(empty($banlist[0])) { ?>
            <div class="alert alert-success">
                <p class="text-center"><?php tl($lang["banlist"]["emptylist"]); ?></p>
            </div>
        <?php } else { ?>
        <div class="table-responsive">
            <table id="banlist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th><?php tl($lang["banlist"]["table"]["nickname"]); ?></th>
                        <th><?php tl($lang["banlist"]["table"]["reason"]); ?></th>
                        <th><?php tl($lang["banlist"]["table"]["bannedby"]); ?></th>
                        <th><?php tl($lang["banlist"]["table"]["bandate"]); ?></th>
                        <th><?php tl($lang["banlist"]["table"]["expires"]); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $banlist[0]; ?>
                </tbody>
            </table>
        </div>
        <?php } ?>

    </div>
    <div class="panel-footer">
        <?php tl($lang["banlist"]["lastupdate"], [$banlist[1]]); ?><!-- <span style="float: right">Podgląd odświerza się co 60 sekund</span> -->
    </div>
</div>

<?php

function getBanlist() {
    global $lang;

    try {
        $tsAdmin = TeamSpeak3::factory(getTeamspeakURI(). "#no_query_clients");

        $bany = $tsAdmin->banList();

        $output = "";

        foreach ($bany as $ban) {

            if(!isset($ban['lastnickname']))
                continue;

            $lastnickname =     $ban['lastnickname']->toString();
            $reason =           $ban['reason'];
            $invokername =      $ban['invokername']->toString();
            $created =          date('d-m-Y H:i:s', $ban['created']);
            $duration =         $ban['duration'];

            if(empty($reason))
                $reason = "<b>" . translate($lang["banlist"]["table"]["emptyreason"]) . "</b>";

            if($duration == 0)
                $expires = translate($lang["banlist"]["table"]["permaban"]);
            else
                $expires = date('d-m-Y H:i:s', $ban['created'] + $duration);

            $output .= "<tr><td>$lastnickname</td><td>$reason</td><td>$invokername</td><td>$created</td><td>$expires</td></tr>";
        }

        return $output;
    } catch(TeamSpeak3_Exception $e) {
        if($e->getCode() == 1281) {
            return '';
        } else {
            return '<div class="alert alert-danger"><p class="text-center">' . translate($lang["general"]["scripterror"], [$e->getCode(), $e->getMessage()]) . '</p></div>';
        }
    }

}


require_once __DIR__ . "/include/footer.php";
?>
