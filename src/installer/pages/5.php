<?php
if(!defined("__TSWEBSITE_VERSION")) die("Direct access not allowed");

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
        <h4 class="card-title text-center">Secure your web server</h4>

        <div class="col-md-10 offset-md-1">
            <div class="alert alert-warning text-center">
                Securing your web server is very important. Please read
                <a href="https://github.com/Wruczek/ts-website/wiki/%5BEN%5D-Securing-private-directory" target="_blank">this</a>
                guide on how to properly isolate the "private" directory
            </div>
        </div>
    </div>

    <div class="card-footer text-right">
        <a href="?step=<?= $stepNumber + 1 ?>" class="btn btn-primary float-right">
            Next <i class="fas fa-chevron-right"></i>
        </a>
    </div>
</div>

<script>
    $("#submitformalt").click(function () {
        $("#submitform").click();
    });
</script>
