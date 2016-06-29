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
        <h3 class="panel-title"><i class="fa fa-ban" aria-hidden="true"></i> Lista banów</h3>
    </div>
    <div class="panel-body">

        <?php if(!$banlist[0]) { ?>
            <div class="alert alert-success">
                <p class="text-center">BRAK ZBANOWANYCH UŻYTKOWNIKÓW</p>
            </div>
        <?php } else { ?>
        <div class="table-responsive">
            <table id="banlist" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nick</th>
                        <th>Powód</th>
                        <th>Zbanowany przez</th>
                        <th>Data zbanowania</th>
                        <th>Wygasa</th>
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
        Stan na <?php echo $banlist[1]; ?><!-- <span style="float: right">Podgląd odświerza się co 60 sekund</span> -->
    </div>
</div>

<?php

function getBanlist() {
    
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
            
            if($duration == 0)
                $expires = "Ban permanentny";
            else
                $expires = date('d-m-Y H:i:s', $ban['created'] + $duration);
            
            $output .= "<tr><td>$lastnickname</td><td>$reason</td><td>$invokername</td><td>$created</td><td>$expires</td></tr>";
        }
        
        return $output;
    } catch(TeamSpeak3_Exception $e) {
        if($e->getCode() == 1281) {
            return false;
        } else {
            return '<div class="alert alert-danger"><p class="text-center">Wystąpił błąd ' . $e->getCode() . ': ' . $e->getMessage() . '</p></div>';
        }
    }
            
}


require_once __DIR__ . "/include/footer.php";
?>
