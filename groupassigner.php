<?php
ob_start();
$groupPage = true;
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/tsutils.php";
require_once __DIR__ . "/include/cacheutils.class.php";

$cacheutils = new CacheUtils('grouplist');

if($cacheutils->isExpired()) {
    $cacheutils->setValue([getServerGroups(), date('d.m.Y H:i:s')], 300);
}

$grouplist = $cacheutils->getValue();
try {
    $tsAdmin = getTeamspeakConnection("#no_query_clients");
} catch (Exception $e){
    if ($e->getCode() == 1281) {
        echo '';
    } else {
        echo '<div class="alert alert-danger"><p class="text-center">' . translate($lang["general"]["scripterror"], [$e->getCode(), $e->getMessage()]) . '</p></div>';
        exit;
    }
}


if(isset($_POST["absenden"])){
    $uid = htmlspecialchars($_POST['uid']);
    if(in_array(htmlspecialchars($_POST['group']), $config["groups"]["allowgroups"])){
        try {
            $tsAdmin->clientGetByUid($uid)->addServerGroup(htmlspecialchars($_POST['group']));
            setCookie("tsuid", $uid);
            $success = "success";
        } catch(Exception $e) {
            if(strpos($e, "invalid clientID") == true){
                $error = "offline";
            }elseif(strpos($e, "duplicate entry") == true){
                $error = "duplicate";
            }

        }
    }else{
         $error = "notallowed";
    }
}
?>
<?php if($config["groupassigner"] == 1){ ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-ban" aria-hidden="true"></i> <?php tl($lang["grouppage"]["title"]); ?></h3>
    </div>
    <div class="panel-body">
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger">
                <p class="text-center"><?php tl($lang["grouppage"]["error"][$error]); ?></p>
            </div>
        <?php } elseif(isset($success)) { ?>
        <div class="alert alert-success">
            <p class="text-center"><?php tl($lang["grouppage"]["success"][$success]) ?></p>
        </div>
        <? } ?>
        <form method="POST" action="groupassigner.php">
            <p align="center"><?php tl($lang["grouppage"]["tsuid"]); ?></p>
            <input type="text" name="uid" required placeholder="<?php tl($lang["grouppage"]["tsuid"]); ?>" value="<?php if(isset($_COOKIE['tsuid'])){echo $_COOKIE['tsuid']; } ?>" class="form-control" style="width: 70%; margin-left:15%; margin-bottom: 5%;">
            <p align="center"><?php tl($lang["grouppage"]["tsgroup"]); ?></p>
            <select name="group" class="form-control" style="width: 70%; margin-left:15%;">
                <?php
                $servergroups = $tsAdmin->servergroupList(array("type" => 1));
                foreach($servergroups as $sg){
                    if(!in_array($sg->sgid, $config["groups"]["allowgroups"])) continue;
                    echo "<option name='".$sg->name."' value='".$sg->sgid."'>".$sg->name."</option> ";
                }

                ?>
            </select>
            <br><br>
            <button type="submit" name="absenden" class="btn btn-success " style="margin-left: 45%;"><?php tl($lang["grouppage"]["send"]); ?></button>
        </form>


    </div>
</div>
<?php }?>


<?php

function getServerGroups() {
    global $lang;

    try {
        $tsAdmin = getTeamspeakConnection("#no_query_clients");


    } catch (TeamSpeak3_Exception $e) {
        if ($e->getCode() == 1281) {
            return '';
        } else {
            return '<div class="alert alert-danger"><p class="text-center">' . translate($lang["general"]["scripterror"], [$e->getCode(), $e->getMessage()]) . '</p></div>';
        }
    }

}

require_once __DIR__ . "/include/footer.php";
?>
