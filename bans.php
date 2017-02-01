<?php
$bansPage = true;
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/tsutils.php";
require_once __DIR__ . "/include/cacheutils.class.php";

$cacheutils = new CacheUtils('banlist');

if($cacheutils->isExpired()) {
    $cacheutils->setValue([getBanlist(), date('d-m-Y H:i:s')], 300);
}

$banlist = $cacheutils->getValue();
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
        <?php tl($lang["banlist"]["lastupdate"], [$banlist[1]]); ?><!-- <span style="float: right">Podgląd odświeża się co 60 sekund</span> -->
    </div>
</div>

<?php

function getBanlist() {
    global $lang;

    try {
        $tsAdmin = getTeamspeakConnection("#no_query_clients");

        $bans = $tsAdmin->banList();

        $output = "";

        foreach ($bans as $ban) {

            $user = null;

            if (!empty($ban['ip']))
                $user = censorIP($ban['ip']->toString());

            if (!empty($ban['lastnickname']))
                $user = $ban['lastnickname']->toString();

            if (empty($user))
                $user = "<i>Unknown</i>";


            $reason = $ban['reason'];
            $invokername = $ban['invokername']->toString();
            $duration = $ban['duration'];
            $createdepoch = $ban['created'];
            $expiresepoch = $ban['created'] + $duration;
            $created = date('d-m-Y H:i:s', $createdepoch);

            if (empty($reason))
                $reason = "<b>" . translate($lang["banlist"]["table"]["emptyreason"]) . "</b>";

            if ($duration == 0)
                $expires = translate($lang["banlist"]["table"]["permaban"]);
            else
                $expires = date('d-m-Y H:i:s', $expiresepoch);

            $output .= "<tr><td>$user</td><td>$reason</td><td>$invokername</td><td data-order=\"$createdepoch\">$created</td><td data-order=\"$expiresepoch\">$expires</td></tr>";
        }

        return $output;
    } catch (TeamSpeak3_Exception $e) {
        if ($e->getCode() == 1281) {
            return '';
        } else {
            return '<div class="alert alert-danger"><p class="text-center">' . translate($lang["general"]["scripterror"], [$e->getCode(), $e->getMessage()]) . '</p></div>';
        }
    }

}

function censorIP($ip) {
    return preg_replace("/(\d+\.\d+\.)\d+\.\d+/", "$1***.***", $ip);
}

require_once __DIR__ . "/include/footer.php";
?>
