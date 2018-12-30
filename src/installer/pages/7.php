<?php
if(!defined("__TSWEBSITE_VERSION")) die("Direct access not allowed");

use Wruczek\TSWebsite\Utils\TeamSpeakUtils;

if(file_put_contents(__INSTALLER_LOCK_FILE, "WEBSITE_INSTALLED") === false) {
    die("Cannot write to <code>private/INSTALLER_LOCK</code>! Please check the file/directory permissions");
}

// If we are allowed to collect metrics
if(!empty($_COOKIE["tsw_allow_metrics"])) {
    setcookie("tsw_allow_metrics", "false", 1); // remove the cookie

    $data = [
        "tswVersion" => __TSWEBSITE_VERSION,
        "tswCommit" => __TSWEBSITE_COMMIT,
        "phpVersion" => PHP_VERSION,
        "os" => sprintf("%s %s %s %s", php_uname("s"), php_uname("r"), php_uname("v"), php_uname("m")), // no hostname
        "webServer" => $_SERVER["SERVER_SOFTWARE"],
        "loadedExtensions" => get_loaded_extensions()
    ];

    // Os details
    {
        $lsb = shell_exec('lsb_release -a | grep "Description"');

        if (strpos($lsb, "Description:") !== false) {
            // Split string by ":", get the 2nd part and trim the string
            // "Description:    Ubuntu 18.04.1 LTS" --> "Ubuntu 18.04.1 LTS"
            $osversion = trim(explode(":", $lsb, 2)[1]);
            $data["osDetails"] = $osversion;
        }
    }

    // TS info
    {
        try {
            require_once __DIR__ . "/../../private/vendor/autoload.php";
            $tsNode = TeamSpeakUtils::i()->getTSNodeHost();
            $tsAdmin = TeamSpeakUtils::i()->getTSNodeServer();

            $tsInfo = $tsAdmin->getInfo();

            $data["ts"] = [
                "uid" => (string) $tsInfo["virtualserver_unique_identifier"],
                "version" => (string) $tsInfo["virtualserver_version"],
                "platform" => (string) $tsInfo["virtualserver_platform"],
                "slotCount" => $tsInfo["virtualserver_maxclients"],
                "usingServeradmin" => $tsNode->whoami()["client_unique_identifier"] == "serveradmin"
            ];
        } catch (\Exception $e) {}
    }

    // Send it
    $data = json_encode($data);
    $url = "https://wruczek.tech/tsw-metrics/";

    // If cURL is available, use it
    if (function_exists("curl_version")) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        //echo $response;
    }
}
?>
<div class="card">
    <div class="card-body">
        <h3 class="card-title text-center">TS-website <?= __TSWEBSITE_VERSION ?> has been successfully installed! &#x1F44D;</h3>

        <p class="text-center">
            If you wish, you can remove the <code>installer</code> directory.
        </p>

        <br>

        <h1 class="card-title text-center mb-4">What now?</h1>

        <div class="col-lg-11" style="left: 4.166666666%">
            <div class="row whatnow-row">
                <div class="col-lg-2">
                    <i class="fab fa-paypal whatnow-icon fa-fw" style="color: #003087"></i>
                </div>
                <div class="col-lg-10">
                    <h1><a href="https://paypal.me/#" target="_blank">Donate</a></h1>
                    <h3>to keep this project alive</h3>
                </div>
            </div>
            <div class="row whatnow-row">
                <div class="col-lg-10 text-right">
                    <h1><a href="https://t.me/tswebsite" target="_blank">Join</a> <small>our telegram group</small></h1>
                    <h3>news, announcements and support</h3>
                </div>
                <div class="col-lg-2">
                    <i class="fab fa-telegram-plane whatnow-icon fa-fw" style="color: #0088cc"></i>
                </div>
            </div>
            <div class="row whatnow-row">
                <div class="col-lg-2">
                    <i class="fa fa-eye whatnow-icon fa-fw" style="color: #fbb034"></i>
                </div>
                <div class="col-lg-10">
                    <h1><a href="../">Visit</a> <small>your new website</small></h1>
                    <h3>or login to your <a href="../admin">Admin Panel</a></h3>
                </div>
            </div>
            <div class="row whatnow-row">
                <div class="col-lg-10 text-right">
                    <h1>Spread <small>the message</small></h1>
                    <h3>Let others know about this project</h3>
                </div>
                <div class="col-lg-2">
                    <i class="fa fa-heart whatnow-icon fa-fw" style="color: #ff4d4d"></i>
                </div>
            </div>
        </div>
    </div>
</div>
