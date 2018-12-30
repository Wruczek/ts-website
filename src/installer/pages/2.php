<?php
if(!defined("__TSWEBSITE_VERSION")) die("Direct access not allowed");

if(!empty($_POST["allow-metrics-checkbox"])) {
    // set a 7 day cookie that tells us later to send the metrics
    setcookie("tsw_allow_metrics", "true", time() + (86400 * 7));
}
?>

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Requirements check</h4>

        <div class="alert alert-dark text-center mb-3" id="filePermError" style="display: none">
            Looks like you have failed file permission checks. Try running:<br>
            <code>sudo chown -R www-data:www-data "<?= realpath(__BASE_DIR) ?>"</code>
        </div>

        <div class="text-center mb-2">
            <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#requirementsTableCollapse">
                Show details
            </button>
        </div>

        <div class="collapse" id="requirementsTableCollapse">
            <div class="text-center">
                <table class="table table-responsive requirements-check-table">
                    <tbody>
                    <?php checkRequirements(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if(defined("CANNOT_INSTALL")) { ?>
            <div class="col-md-10 offset-md-1">
                <div class="alert alert-danger">
                    <strong>Oh snap!</strong> Looks like your current web server configuration does not allow to run TS-website 2.0.
                    Please fix the above problems and try again.<br>If you have any problems, please check
                    <a href="https://github.com/Wruczek/ts-website/wiki" target="_blank">wiki</a> and follow the installation guide.
                </div>
            </div>
            <script>
                // Show requirements table on error
                $("#requirementsTableCollapse").collapse("show")

                <?php if(defined("FILE_PERM_ERROR")) { ?>
                    // Show file permission fix tip
                    $("#filePermError").show()
                <?php } ?>
            </script>
        <?php } else { ?>
            <div class="text-center">
                <div class="alert alert-success" style="display: inline-block">
                    <strong>Success!</strong> Looks like you can run TS-website 2.0!
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="card-footer text-right">
        <a href="?step=<?= $stepNumber - 1 ?>" class="btn btn-primary float-left">
            <i class="fas fa-chevron-left"></i> Back
        </a>

        <?php if(defined("CANNOT_INSTALL")) { ?>
            <a href="#" onclick="location.reload(); this.className += ' disabled'; return false" class="btn btn-warning float-right">
                Re-check <i class="fas fa-sync"></i>
            </a>
        <?php } else { ?>
            <a href="?step=<?= $stepNumber + 1 ?>" class="btn btn-primary float-right">
                Next <i class="fas fa-chevron-right"></i>
            </a>
        <?php } ?>
    </div>
</div>

<?php
function checkRequirements() {
    if (!defined("PHP_VERSION_ID")) {
        $version = explode(".", PHP_VERSION);
        define("PHP_VERSION_ID", $version[0] * 10000 + $version[1] * 100 + $version[2]);
    }

    // PHP version - 5.6.0 minimum, < 7 warning, > 7 ok
    {
        $result = PHP_VERSION_ID < 50600 ? 2 : (PHP_VERSION_ID < 70000 ? 1 : 0);
        showCheckResult(
                "PHP 5.6.0+ (7.0+ recommended)",
                $result,
                "Current PHP version: " . phpversion()
        );
    }

    // Check if we are using polyfill for utf8_encode
    {
        $result = defined("__USING_U8ENC_POLYFILL");

        showCheckResult(
            "Function <code>utf8_encode</code> exists",
            $result ? 1 : 0,
            $result ?
                "Function not found, using polyfill" :
                "Function exists"
        );
    }

    // password_hash and password_verify
    {
        $result = PHP_VERSION_ID >= 50500 && password_verify(
                "ayy-lmao-m88", password_hash("ayy-lmao-m88", PASSWORD_DEFAULT)
            );

        showCheckResult(
            "password_hash & password_verify",
            $result ? 0 : 2,
            $result ?
                "Functions exists and work" :
                "Please make sure your PHP version supports BCRYPT and BLOWFISH"
        );
    }

    displayCategory("Extension checks");

    // Extensions check
    {
        foreach (["mbstring", "json", "pdo_mysql", "tokenizer", "curl"] as $extension) {
            $result = extension_loaded($extension);

            showCheckResult(
                "<code>$extension</code> extension",
                $result ? 0 : 2,
                $result ?
                    "Extension installed and loaded" :
                    'Please install or enable <code>' . $extension . '</code> extension'
            );
        }
    }

    displayCategory("File / directory permission checks");

    // file / directory writable checks
    {
        // path => true if file, false if directory
        $paths = array(
            __CONFIG_FILE => true,
            __INSTALLER_LOCK_FILE => true,
            __CACHE_DIR => false,
            __CACHE_DIR . "/templates" => false,
            __CACHE_DIR . "/servericons" => false,
        );

        foreach ($paths as $path => $isFile) {
            $exists = file_exists($path);

            // If file / directory doesnt exists try to create it and update the variable
            if(!$exists)
                $exists = $isFile ? @touch($path) : @mkdir($path);

            $writable = is_writable($path);
            $basename = basename($path);

            // we are using a custom method instead of realpath,
            // because it does not work with non-existing files
            $realpath = resolveFilename($path);

            $msg = "Yes";

            if(!$writable)
                $msg = "Please make <code>$realpath</code> writable";

            if(!$exists)
                $msg = ($isFile ? "File" : "Directory") . " <code>$realpath</code> does not exists, please create it";

            $success = $exists && $writable;

            if (!$success && !defined("FILE_PERM_ERROR")) {
                define("FILE_PERM_ERROR", true);
            }

            showCheckResult("Is <code>$basename</code> writable?", $success ? 0 : 2, $msg);
        }
    }

    displayCategory("Miscellaneous");

    // cache test
    {
        $result = false;

        try {
            require_once __PRIVATE_DIR . "/vendor/autoload.php";
            $cache = new Wruczek\PhpFileCache\PhpFileCache();
            $teststring = "cachetest123";
            $cache->store("installertest", $teststring, 3);
            $result = $cache->retrieve("installertest") === $teststring;
            $cache->clearCache();
        } catch (Exception $e) {}

        showCheckResult(
                "Cache save and read test",
                $result ? 0 : 2,
                $result ?
                    "Save and read success" :
                    "Something went wrong! Please make sure that <code>private/cache</code> directory is writable"
        );
    }

    // template test
    {
        if($result) {
            if(extension_loaded("mbstring")) {
                $result = false;

                try {
                    $latte = new Latte\Engine();
                    $latte->setTempDirectory(__CACHE_DIR);
                    $latte->setLoader(new Latte\Loaders\StringLoader());

                    $render = @$latte->renderToString('Hello, {$test|upper}!', array("test" => "Wruczek"));

                    $result = $render === "Hello, WRUCZEK!";
                } catch (Exception $e) {}

                showCheckResult(
                    "Template render and cache test",
                    $result ? 0 : 2,
                    $result ?
                        "Render and cache success" :
                        "Something went wrong! Please make sure that <code>private/cache</code> directory is writable"
                );
            } else {
                showCheckResult("Template render and cache test", 2, "<code>mbstring</code> extension not found, cannot start the test");
            }
        } else {
            showCheckResult("Template render and cache test", 2, "<code>private/cache</code> directory is not writable, cannot start the test");
        }
    }

}

// Utils

function showCheckResult($name, $state, $resulttext) {
    if($state === 0) {
        $attr = "fa-check-circle color-success";
    } else if($state === 1) {
        $attr = "fa-minus-circle color-warning";
    } else {
        $attr = "fa-times-circle color-danger";

        if(!defined("CANNOT_INSTALL")) {
            define("CANNOT_INSTALL", true);
        }
    }

    ?>
    <tr>
        <td class="text-right"><?= $name ?></td>
        <td><i class="fas <?= $attr ?> fa-lg"></i></td>
        <td><?= $resulttext ?></td>
    </tr>
<?php }

function displayCategory($name) {
    echo '<tr><td colspan="3" class="text-center lead">' . $name . '</td></tr>';
}

// https://tomnomnom.com/posts/realish-paths-without-realpath
function resolveFilename($filename) {
    $filename = str_replace('//', '/', $filename);
    $parts = explode('/', $filename);
    $out = array();
    foreach ($parts as $part){
        if ($part === '.') continue;
        if ($part === '..') {
            array_pop($out);
            continue;
        }
        $out[] = $part;
    }
    return implode('/', $out);
}
