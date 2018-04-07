<?php
require_once __DIR__ . "/include/header.php";
require_once __DIR__ . "/include/tsutils.php";
require_once __DIR__ . "/include/cacheutils.class.php";
require_once __DIR__ . "/config/assignerconfig.php";

$clientgroups = [];

try {
    $tsAdmin = getTeamspeakConnection("#no_query_clients");

    $userip = $_SERVER["HTTP_CF_CONNECTING_IP"]; // $_SERVER["REMOTE_ADDR"];

    echo "<!-- IP: {$_SERVER["REMOTE_ADDR"]}, CFIP: {$_SERVER["HTTP_CF_CONNECTING_IP"]} -->";

    $clients = $tsAdmin->clientList(["connection_client_ip" => $userip]);
    $servergroups = $tsAdmin->serverGroupList();

    if(!empty($clients)) {
        $client = array_values($clients)[0];
        $clientgroups = explode(",", $client["client_servergroups"]);
    }

    if(isset($client)) {
        $cacheutils = new CacheUtils('logincodes-' . $client["client_database_id"]);

        if(empty($_SESSION["loggedin"])) {
            if($cacheutils->isExpired()) {
                $logincode = mt_rand(100000, 999999);
                $client->poke(translate($lang["groupassigner"]["codepoke"], [$logincode]));
                $cacheutils->setValue($logincode, 120);
            } else {
                $logincode = $cacheutils->getValue();
            }

            if(!empty($_POST["logincode"])) {
                if($logincode === (int)$_POST["logincode"]) {
                    $cacheutils->remove();
                    $_SESSION["loggedin"] = true;
                } else {
                    $failedlogin = true;
                }
            }
        }

        if(!empty($_POST["submitted"]) && !empty($_SESSION["loggedin"])) {
            $allgroups = [];

            foreach ($assignerconfig as $item) {
                foreach ($item["sgids"] as $sgid) {
                    if(!in_array($sgid, $allgroups))
                        $allgroups[] = (int)$sgid;
                }
            }

            $submittedgroups = [];

            if(!empty($_POST["sgs"]) && is_array($_POST["sgs"])) {
                foreach ($_POST["sgs"] as $sg) {
                    $submittedgroups[] = (int)$sg;
                }
            }

            $groupsremove = array_diff($allgroups, $submittedgroups);

            foreach ($groupsremove as $grid) {
                try {
                    $client->remServerGroup((int)$grid);
                } catch (Exception $e) {}
            }

            foreach ($submittedgroups as $gaid) {
                try {
                    if(in_array($gaid, $allgroups)) {
                        $client->addServerGroup((int)$gaid);
                    }
                } catch (Exception $e) {}
            }

            $client = $tsAdmin->clientGetByDbid($client["client_database_id"]); // refresh
            $clientgroups = explode(",", $client["client_servergroups"]);

            $success = true;
        }
    }
} catch (Exception $e) {
    echo "Connection failed! $e";
}
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-picture-o" aria-hidden="true"></i> <?php tl($lang["groupassigner"]["title"]); ?></h3>
    </div>
    <div class="panel-body">
        <?php if(isset($success)) { ?>
            <div class="alert alert-success">
                <?php tl($lang["groupassigner"]["success"]) ?>
            </div>
        <?php } ?>

        <?php if (!isset($client)) { ?>
            <script>
                setTimeout(function () {
                    location.reload()
                }, 5000);
            </script>
            <div class="text-center">
                <h3><?php tl($lang["groupassigner"]["connectbeforeusing"]) ?></h3>
                <a class="btn btn-info" href="<?php echo "ts3server://" . $config['teamspeak']['displayip'] ?>"><i class="fa fa-sign-in"></i> <?php tl($lang["groupassigner"]["joints"]) ?></a>
            </div>
        <?php } else if (empty($_SESSION["loggedin"])) { ?>
            <div class="text-center">
                <h3><?php tl($lang["groupassigner"]["entercode"]) ?></h3>
                <form method="post">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="input-group">
                                <input name="logincode" type="number" class="form-control" placeholder="<?php tl($lang["groupassigner"]["logincode"]) ?>" required autofocus autocomplete="off">
                                <span class="input-group-btn">
                                <button class="btn btn-info">
                                    <i class="fa fa-arrow-right" style="margin: 0" aria-hidden="true"></i>
                                </button>
                            </span>
                            </div>
                        </div>
                    </div>
                </form>
                <?php if(isset($failedlogin)) { ?>
                <div class="alert alert-danger" style="display: inline-block; margin-top: 15px">
                    <?php tl($lang["groupassigner"]["failedlogin"]) ?>
                </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <form method="post">
                <?php foreach ($assignerconfig as $item) { ?>
                    <div class="ga-group">
                        <p class="group-label">
                            <?php echo $item["name"] ?><span class="label label-info pull-right"><?php tl($lang["groupassigner"]["limit"], [$item["limit"]]) ?></span>
                        </p>

                        <select name="sgs[]" class="selectpicker" multiple data-live-search="true" data-max-options="<?php echo $item["limit"] ?>" data-width="100%">
                            <?php
                            foreach ($item["sgids"] as $sgid) {
                                if (!isset($servergroups[$sgid])) continue;

                                $sg = $servergroups[$sgid];
                                $name = (string)$sg["name"];
                                $icon = $tsAdmin->serverGroupGetById($sgid)->iconDownload();
                                $iconhtml = '';

                                if ($icon)
                                    $iconhtml = 'data:' . TeamSpeak3_Helper_Convert::imageMimeType($icon) . ';base64,' . base64_encode($icon);
                                ?>
                                <option value="<?php echo $sgid ?>" data-content="<img class='ga-icon' src='<?php echo $iconhtml ?>'></img> <?php echo $name ?>"></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>
                <input name="submitted" value="true" hidden>
                <button class="btn btn-primary btn-block" style="margin-top: 3rem"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php tl($lang["groupassigner"]["save"]) ?></button>
            </form>
        <?php } ?>
    </div>
</div>

<?php
require_once __DIR__ . "/include/footer.php";
?>

<script>
    $('.selectpicker').selectpicker('val', <?php echo json_encode($clientgroups) ?>);
</script>
