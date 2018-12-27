<?php
if(!defined("__TSWEBSITE_VERSION")) die("Direct access not allowed");

use Wruczek\TSWebsite\Config;

require_once __PRIVATE_DIR . "/../private/vendor/autoload.php";

if (!empty($_POST)) {
    $baseUrl = @$_POST["base-url"];
    $websiteName = @$_POST["website-name"];
    $timezone = @$_POST["timezone"];
    $usingCloudflare = isset($_POST["using-cloudflare"]);

    if (!in_array($timezone, timezone_identifiers_list())) {
        $errormessage = "Invalid timezone";
    } else {
        try {
            Config::i()->setValue("baseurl", $baseUrl);
            Config::i()->setValue("website_title", $websiteName);
            Config::i()->setValue("nav_brand", $websiteName);
            Config::i()->setValue("timezone", $timezone);
            Config::i()->setValue("usingcloudflare", $usingCloudflare);

            header("Location: ?step=" . ($stepNumber + 1));
        } catch (\Exception $e) {
            $errormessage = "Error saving config: " . htmlspecialchars($e->getMessage());
        }
    }
}

$defaultTimezone = date_default_timezone_get();

$defaultBase = (@$_SERVER["HTTPS"] === "on" ? "https" : "http") . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
$defaultBase = dirname(dirname($defaultBase)); // get the path for the previous directory, not the installer

$displayip = Config::get("query_displayip"); // default website name to the display IP
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
        <h4 class="card-title text-center">Configure your site</h4>

        <div class="row justify-content-md-center">
            <form id="configureform" class="col-md-5" method="post" action="<?= "?step=$stepNumber" ?>">

                <div class="alert alert-info mb-4">
                    <b>Almost done!</b> Here you can adjust some basic settings of ts-website.
                    Don't worry, you will be able to change them in the admin panel after installation.
                </div>

                <div class="form-group mb-4">
                    <label for="base-url">Base URL of ts-website. No trailing slash!</label>
                    <input class="form-control"
                           id="base-url"
                           name="base-url"
                           placeholder="Base URL of ts-website. No trailing slash!"
                           value="<?= htmlspecialchars($defaultBase) ?>"
                           required autofocus autocomplete="off">
                </div>

                <div class="form-group mb-4">
                    <label for="website-name">Website name / title</label>
                    <input class="form-control"
                           id="website-name"
                           name="website-name"
                           placeholder="Website name / title"
                           value="<?= htmlspecialchars($displayip) ?>"
                           required autocomplete="off">
                </div>

                <div class="form-group mb-4">
                    <label for="timezone">Choose your time zone</label>
                    <select class="form-control" name="timezone" id="timezone" required>
                        <!-- Set this as selected if there is no default timezone -->
                        <option <?= empty($defaultTimezone) ? "selected" : "" ?> disabled value="">
                            Choose your time zone
                        </option>

                        <?php foreach (timezone_identifiers_list() as $timezone) {
                            $selected = $timezone === $defaultTimezone;
                            $time = (new DateTime("now", new DateTimeZone($timezone)))->format("H:i (P)");
                            ?>
                            <option <?= $selected ? "selected" : "" ?> value="<?= $timezone ?>">
                                <?= "$timezone - $time" ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="using-cloudflare" name="using-cloudflare">
                        <label class="custom-control-label" for="using-cloudflare">
                            I am using CloudFlare
                        </label>
                    </div>
                    <p><small>This will change the way ts-website detects user IP address</small></p>
                </div>

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
