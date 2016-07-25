<?php
header('Content-Type:application/javascript');
require_once __DIR__ . "/../include/language.php";
?>
var textShowMore = "<?php json_encode(tl($lang["index"]["showmore"])); ?>", textShowLess = "<?php json_encode(tl($lang["index"]["showless"])); ?>", statusOnline = "<?php json_encode(tl($lang["serverstatus"]["online"])); ?>", statusOffline = "<?php json_encode(tl($lang["serverstatus"]["offline"])); ?>", statusUptime = "<?php json_encode(tl($lang["serverstatus"]["uptime"])); ?>", statusVersion = "<?php json_encode(tl($lang["serverstatus"]["version"])); ?>", statusAvgping = "<?php json_encode(tl($lang["serverstatus"]["avgping"])); ?>", statusAvgpl = "<?php json_encode(tl($lang["serverstatus"]["avgpl"])); ?>";
