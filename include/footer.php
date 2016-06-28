            </div>
        </div>
        
        <!-- Footer -->
        <hr>
        <footer>
            <p class="pull-left">&copy; twojanazwa 2016</p>
            <div class="pull-right">
                <ul class="list-inline">
                    <li>Strona &copy; <a href="http://wruczek.top">Wruczek</a> 2016 | <a href="https://github.com/Wruczek/ts-website">ts-website</a> v 1.1.0 | MIT License</li>
                </ul>
            </div>
        </footer>
    </div>
    <!-- /container -->

    <!-- ################ -->
    <!-- #  JAVASCRIPT  # -->
    <!-- ################ -->

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Twitter Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <!-- Readmore.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Readmore.js/2.2.0/readmore.min.js"></script>

    <?php if(isset($bansPage)) { ?>
    <!-- DataTables for Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <script src="js/bans.js"></script>
    <?php } ?>

    <!-- Custom JS -->
    <script src="js/script.js"></script>
    <script src="js/status.js"></script>
</body>

</html>
<?php
$end = microtime(true);
$creationtime = ($end - $start);
printf("<!-- Page generated " . date('d-m-Y H:i:s') . " in %.6f seconds. -->", $creationtime);
?>
