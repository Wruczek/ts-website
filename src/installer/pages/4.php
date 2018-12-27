<?php
if(!defined("__TSWEBSITE_VERSION")) die("Direct access not allowed");

use Wruczek\TSWebsite\Config;

if (!empty($_POST)) {
    $queryhostname = trim($_POST["queryhostname"]);
    $queryport = trim($_POST["queryport"]);
    $queryserverport = trim($_POST["queryserverport"]);
    $queryusername = trim($_POST["queryusername"]);
    $querypassword = trim($_POST["querypassword"]);
    $querydisplayip = trim($_POST["querydisplayip"]);

    if (!empty($queryhostname) && !empty($queryport)
        && !empty($queryserverport) && !empty($queryusername)
        && !empty($querypassword) && !empty($querydisplayip)
    ) {
        require_once __PRIVATE_DIR . "/vendor/autoload.php";

        try {
            $tsNodeHost = TeamSpeak3::factory("serverquery://$queryhostname:$queryport/");
            $tsNodeHost->login($queryusername, $querypassword);
            $tsServer = $tsNodeHost->serverGetByPort($queryserverport);

            if(is_array($tsServer->getInfo())) {
                $utils = Config::i();

                $configdata = [
                    "query_hostname" => $queryhostname,
                    "query_port" => $queryport,
                    "tsserver_port" => $queryserverport,
                    "query_username" => $queryusername,
                    "query_password" => $querypassword,
                    "query_displayip" => $querydisplayip,
                ];

                foreach ($configdata as $key => $value) {
                    if(!$utils->setValue($key, $value)) {
                        die("Error while inserting query data to database, at " . htmlspecialchars($key) . " => " . htmlspecialchars($value));
                    }
                }

                header("Location: ?step=" . ($stepNumber + 1));
            } else {
                $errormessage .= '<br>Cannot retrieve server information';
            }
        } catch (Exception $e) {
            $errormessage = htmlspecialchars("Error " . $e->getCode() . ": " . $e->getMessage());

            if($e->getCode() === 520) {
                $errormessage .= '<br>You have entered wrong username and/or password. Please check it and try again.';
            }

            if($e->getCode() === 2568) {
                $errormessage .= '<br>Query account does not have permissions. ' . 'Click <a href="#" data-toggle="modal" ' .
                    'data-target="#queryperms">here</a> to view required permissions list.';
            }
        }
    }
}
?>

<!-- Modal -->
<div class="modal fade" id="queryperms" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Query permissions required by TS-website</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <?php
                    if(!empty($GLOBALS["__REQUIRED_QUERY_PERMS"])) {
                        foreach ($GLOBALS["__REQUIRED_QUERY_PERMS"] as $perm) {
                            echo "<li><code>" . htmlspecialchars($perm) . "</code></li>";
                        }
                    } else {
                        echo "Error! <code>\$GLOBALS[\"__REQUIRED_QUERY_PERMS\"]</code> is not defined!";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if(!empty($errormessage)) { ?>
<div class="text-center">
    <div class="alert alert-danger" style="display: inline-block">
        <?= $errormessage ?>
    </div>
</div>
<?php } ?>

<div class="card">

    <div class="card-body">
        <h4 class="card-title text-center">Query details</h4>

        <div class="row justify-content-md-center">
            <form id="tsform" class="col-md-4" method="post" action="<?= "?step=$stepNumber" ?>">

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-link fa-fw"></i></span>
                    </div>
                    <input class="form-control" name="queryhostname" placeholder="Hostname" required autofocus autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" data-toggle="tooltip" title="Your TeamSpeak IP address (without port).<br>Use '127.0.0.1' for localhost">
                            <i class="fa fa-question-circle fa-fw"></i>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-signal fa-fw"></i></span>
                        </div>
                        <input type="number" class="form-control" name="queryport" placeholder="Query port" required autocomplete="off">
                    </div>

                    <div class="col input-group mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-signal fa-fw"></i></span>
                        </div>
                        <input type="number" class="form-control" name="queryserverport" placeholder="Server port" required autocomplete="off">
                    </div>
                </div>

                <p class="text-muted text-center" style="font-size: 100%">
                    Default query port: 10011, default server port: 9987.
                </p>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user fa-fw"></i></span>
                    </div>
                    <input class="form-control" name="queryusername" placeholder="Query username" required autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" data-toggle="tooltip" title="Its recommended to create special user account instead of serveradmin">
                            <i class="fa fa-exclamation-triangle color-danger fa-fw"></i>
                        </span>
                    </div>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-lock fa-fw"></i></span>
                    </div>
                    <input type="password" class="form-control" name="querypassword" placeholder="Query password" required autocomplete="off">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-font fa-fw"></i></span>
                    </div>
                    <input class="form-control" name="querydisplayip" placeholder="Displayed address" required autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" data-toggle="tooltip"
                              title="Friendly server address displayed to end users.<br>For example 'myserver.com' or 'ts.myclan.net'">
                            <i class="fa fa-question-circle fa-fw"></i>
                        </span>
                    </div>
                </div>

                <a href="#" data-toggle="modal" data-target="#queryperms" class="text-center">
                    <p>Query permissions required by TS-website</p>
                </a>

                <button id="submitform" type="submit" style="display: none"></button>
            </form>
        </div>
    </div>

    <div class="card-footer text-right">
        <a href="#" id="submitformalt" class="btn btn-primary float-right">
            Submit <i class="fas fa-chevron-right"></i>
        </a>
    </div>
</div>

<script>
    $("#submitformalt").click(function () {
        $("#submitform").click();
    });
</script>
