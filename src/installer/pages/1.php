<?php if (!defined("__TSWEBSITE_VERSION")) die("Direct access not allowed"); ?>

<?php if(file_exists(__CONFIG_FILE)) { ?>
    <div class="alert alert-danger text-center" role="alert">
        dbconfig.php file found! TS-website might have already been installed.
        If you proceed, you will loose data!
    </div>
<?php } ?>

<div class="modal" tabindex="-1" role="dialog" id="dev-release-notice">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Welcome to the development version of TS-website 2!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <b>Development version</b> is great to test and explore TS-website.
                    Remember, that this version is not finished and only intended for testing.
                    <b>We strongly advise you to NOT use it in production.</b>
                </p>

                <p><b>Continue only if you:</b></p>

                <ul>
                    <li class="mb-2">
                        <b>Want to try out development version of TS-website</b>
                    </li>
                    <li class="mb-2">
                        <b>Understand how websites work</b> and will be able to fix common problems with PHP, your web server and your database
                    </li>
                </ul>

                <p><b>Things that you might not like:</b></p>

                <ul>
                    <li class="mb-2">
                        <b>There is NO admin panel</b><br>
                        Configure it by modifying files and values in the database
                    </li>
                    <li class="mb-2">
                        <b>You break it, you fix it</b><br>
                        If something breaks, you need to read the error messages and fix the problem yourself.
                    </li>
                    <li>
                        <b>You might find bugs and problems</b><br>
                        If you do, please
                        <a href="https://github.com/Wruczek/ts-website/issues" target="_blank">create an issue</a>
                        on GitHub
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">I understand</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="metrics-info">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Metrics send by TS-website</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    You might allow TS-website to send one-time metrics during the installation process.
                    The data send contains only publicly known information, no private info is send.
                    The collected data will be used only to learn more about our users and improve TS-website.
                    We will never sell or share it to 3rd-parties. We might, however, publish some statistics
                    collected via the metrics. The published data will always be fully anonymous.
                </p>

                <p>
                    The data send will be indexed with the sending server's IP address, to prevent abuse.
                </p>

                <p>
                    You can check all of the data send yourself by looking at the source code:
                    <code>installer/pages/2.php</code>
                </p>

                <p><b>Data send by TS-website:</b></p>

                <ul>
                    <li class="mb-1">
                        Version of TS-website and PHP
                    </li>
                    <li class="mb-1">
                        List of loaded PHP extensions names
                    </li>
                    <li class="mb-1">
                        Server identification string (contains mainly web server name and version)
                    </li>
                    <li class="mb-1">
                        Basic OS info (type, version, architecture, hostname)
                    </li>
                    <li class="mb-1">
                        TeamSpeak server info (version, build number, host OS name, slot count,
                        are you using serveradmin for query, server's unique ID)
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center mb-0">Welcome to TS-website Installer!</h4>

        <p class="card-text text-center text-muted font-italic mb-5">
            Version <?= __TSWEBSITE_VERSION ?> (<?= __TSWEBSITE_COMMIT ?>)
        </p>

        <p class="card-text">This wizard will guide you through the installation process of TS-website.</p>
        <p class="card-text text-danger" id="hidejs">Please enable Javascript before continuing!</p>
        <p class="card-text">
            If you encounter any problems please make sure you check the
            <a href="https://github.com/Wruczek/ts-website/wiki" target="_blank">wiki</a>.
        </p>
        <p class="card-text">Go to the next step whenever you are ready!</p>

        <form method="post" action="?step=<?= $stepNumber + 1 ?>">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="allow-metrics-checkbox" name="allow-metrics-checkbox" checked>
                <label class="custom-control-label" for="allow-metrics-checkbox">
                    Send one-time statistics to help improve TS-website
                    <a href="#" data-toggle="modal" data-target="#metrics-info">(learn more)</a>
                </label>
            </div>

            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="accept-license-checkbox" name="accept-license-checkbox" required>
                <label class="custom-control-label" for="accept-license-checkbox">
                    I read and accept the <a href="https://github.com/Wruczek/ts-website/blob/2.0/LICENSE.txt" target="_blank">license</a>
                </label>
            </div>

            <button id="submitform" type="submit" style="display: none"></button>
        </form>
    </div>
    <div class="card-footer">
        <a id="nextbutton" href="#" class="btn btn-primary float-right disabled" style="display: none">
            Start <i class="fas fa-chevron-right"></i>
        </a>
    </div>
</div>

<script>
    $("#dev-release-notice").modal("show")

    $("#hidejs").css("display", "none");
    $("#nextbutton").css("display", "inline-block");

    $("#nextbutton").click(function () {
        $("#submitform").click();
    });

    $("#accept-license-checkbox").change(function () {
        if (this.checked) {
            $("#nextbutton").removeClass("disabled");
        } else {
            $("#nextbutton").addClass("disabled");
        }
    });
</script>
