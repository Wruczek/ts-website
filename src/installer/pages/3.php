<?php

use Medoo\Medoo;

if(!defined("__TSWEBSITE_VERSION")) die("Direct access not allowed");

if (!empty($_POST)) {
    $dbhostname = trim($_POST["dbhostname"]);
    $dbusername = trim($_POST["dbusername"]);
    $dbpassword = trim($_POST["dbpassword"]);
    $dbname = trim($_POST["dbname"]);
    $dbprefix = trim($_POST["dbprefix"]);
    $usingMysql = true;

    require_once __PRIVATE_DIR . "/vendor/autoload.php";

    if (empty($dbprefix)) {
        $dbprefix = "tsw_";
    }

    if (!empty($dbhostname) && !empty($dbusername) && !empty($dbname)) {
        $dbconfig = [
            "database_type" => "mysql",
            "server" => $dbhostname,
            "username" => $dbusername,
            "password" => $dbpassword,
            "database_name" => $dbname,
            "prefix" => $dbprefix,
            "port" => 3306,
            "charset" => "utf8mb4"
        ];
    } else {
        // no sqlite support for now :(
        $errormessage = "Please fill in your database details";

//        $usingMysql = false;
//        $dbconfig = [
//            "database_type" => "sqlite",
//            "database_file" => __LOCALDB_FILE
//        ];
    }

    // try to connect only if dbconfig is defined
    if (isset($dbconfig)) {
        try {
            $db = new Medoo($dbconfig);

            $sqlfiles = [];

            if ($usingMysql) {
                $sqlfiles = [
                    "dbinstall_mysql",
                    "dbinstall_mysql_lang"
                ];
            } else {
                // no other option yet
            }

            foreach ($sqlfiles as $file) {
                $sqlquery = file_get_contents(__DIR__ . "/../$file.sql");

                if($sqlquery === false) {
                    throw new Exception("Cannot read SQL file: $file.sql");
                }

                $sqlquery = str_replace("DBPREFIX", $dbprefix, $sqlquery);
                $sqlresult = $db->pdo->exec($sqlquery);

                if ($sqlresult === false) {
                    throw new Exception("EXEC returned false");
                }
            }

            // if all queries succeeded, create a config file and save connection info there
            $phpcode = <<<EOT
<?php
/*
 * TS-website database config file
 * Generated at %s with TS-website %s (%s)
 */

return [
%s
];

EOT;
            $confarray = "";

            // Add all variables to the config
            foreach ($dbconfig as $key => $value) {
                $confarray .= sprintf("    '%s' => '%s'," . PHP_EOL, addcslashes($key, '"'), addcslashes($value, '"'));
            }

            // Remove semicolon and new line from the end
            $confarray = rtrim($confarray, "," . PHP_EOL);

            // Replace all variables with sprintf
            $phpcode = sprintf($phpcode, date("d-m-Y H:i:s"), __TSWEBSITE_VERSION, __TSWEBSITE_COMMIT, $confarray);

            if(file_put_contents(__CONFIG_FILE, $phpcode) === false) {
                $errormessage = "Cannot write to <code>" . __CONFIG_FILE . "</code>! Please check the file/directory permissions";
            } else {
                // redirect to next step on success
                header("Location: ?step=" . ($stepNumber + 1));
            }
        } catch (Exception $e) {
            $errormessage = htmlspecialchars("Error " . $e->getCode() . ": " . $e->getMessage());

            if($e->getCode() === 1045) {
                $errormessage .= '<br>You have entered wrong username and/or password. Please check it and try again.';
            }

            if($e->getCode() === 1049) {
                $errormessage .= '<br>Please manually create database "' . htmlspecialchars($dbname) . '" and try again.';
            }
        }
    }

}
?>

<?php if(!empty($errormessage)) { ?>
<div class="text-center">
    <div class="alert alert-danger" style="display: inline-block">
        <?= $errormessage ?>
    </div>
</div>
<?php } ?>

<div class="card">

    <div class="card-body">
        <h3 class="card-title text-center">Database details</h3>

        <div class="text-center mb-3">
            <div class="custom-control custom-radio">
                <input type="radio" id="use-mysql-db" name="dbselection" class="custom-control-input" checked>
                <label class="custom-control-label" for="use-mysql-db">Use MySQL / MariaDB</label>
            </div>
            <div class="custom-control custom-radio">
                <input type="radio" id="use-sqlite-db" name="dbselection" class="custom-control-input" disabled>
                <label class="custom-control-label" for="use-sqlite-db">Use SQLite database</label>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <form id="dbform" class="col-md-4" method="post" action="<?= "?step=$stepNumber" ?>"> <!-- style="display: none" novalidate -->

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-link fa-fw"></i></span>
                    </div>
                    <input class="form-control" name="dbhostname" placeholder="Hostname" required autofocus autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" data-toggle="tooltip" title="Use '127.0.0.1' for localhost">
                            <i class="fa fa-question-circle fa-fw"></i>
                        </span>
                    </div>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user fa-fw"></i></span>
                    </div>
                    <input class="form-control" name="dbusername" placeholder="Username" required autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" data-toggle="tooltip" title="Its recommended to create seperate user account instead of using root">
                            <i class="fa fa-exclamation-triangle color-danger fa-fw"></i>
                        </span>
                    </div>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-lock fa-fw"></i></span>
                    </div>
                    <input type="password" class="form-control" name="dbpassword" placeholder="Password" autocomplete="off">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-database fa-fw"></i></span>
                    </div>
                    <input class="form-control" name="dbname" placeholder="Database name" required autocomplete="off">
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-font fa-fw"></i></span>
                    </div>
                    <input class="form-control" name="dbprefix" placeholder="Table prefix (optional)" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text" data-toggle="tooltip" title="Defaults to 'tsw_'">
                            <i class="fa fa-question-circle fa-fw"></i>
                        </span>
                    </div>
                </div>

                <button id="submitform" type="submit" style="display: none"></button>
            </form>
        </div>
    </div>

    <div class="card-footer text-right">
        <a href="?step=<?= $stepNumber - 1 ?>" class="btn btn-primary float-left">
            <i class="fas fa-chevron-left"></i> Back
        </a>
        <a href="#" id="submitformalt" class="btn btn-primary float-right">
            Submit <i class="fas fa-chevron-right"></i>
        </a>
    </div>
</div>

<script>
    $("#submitformalt").click(function () {
        $("#submitform").click()
    });

    $("#use-mysql-db").change(function () {
        $("#dbform").show()
        $("#dbform").removeAttr("novalidate")
    });

    $("#use-sqlite-db").change(function () {
        $("#dbform").hide()
        $("#dbform").attr("novalidate", "")
    });
</script>
