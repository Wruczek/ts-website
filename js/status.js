$(document).ready(function () {
    checkStatus();

    var intervalid = setInterval(function () {
        checkStatus();
    }, 10 * 1000);
});

function checkStatus() {

    $.ajax({
        url: apiurl,
        success: function (json) {

            json = json.tsstatus;

            var result = "";

            if (json.success) {
                var clientsonline = json.clientsonline;
                var maxclients = json.maxclients;
                var clientsprecent = Math.round(json.clientsonline * 100 / json.maxclients);
                var version = json.version;
                var platform = json.platform;
                var uptime = json.uptime;
                var averagePacketloss = Math.round(json.averagePacketloss * 100) / 100;
                var averagePing = Math.round(json.averagePing * 100) / 100;

                var platformIcon = '<i class="fa %s fa-fw" title="' + platform + '" aria-hidden="true"></i>';

                switch (platform.toLowerCase()) {
                    case "windows":
                        platformIcon = platformIcon.replace(/%s/, 'fa-windows');
                        break;
                    case "linux":
                        platformIcon = platformIcon.replace(/%s/, 'fa-linux');
                        break;
                    case "os x":
                    case "macos":
                        platformIcon = platformIcon.replace(/%s/, 'fa-apple');
                        break;
                    default:
                        platformIcon = platform;
                }

                result =
                    '<p><i class="fa fa-power-off fa-fw" aria-hidden="true"></i> ' + statusOnline + ': <span class="label label-success">' + clientsonline + ' / ' + maxclients + ' (' + clientsprecent + '%)</span></p>' +
                    '<p><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> ' + statusUptime + ': <span class="label label-success">' + uptime + '</span></p>' +
                    '<p><i class="fa fa-info-circle fa-fw" aria-hidden="true"></i> ' + statusVersion + ': <span class="label label-success">' + version + ' on ' + platformIcon + '</span></p>' +
                    '<p><i class="fa fa-signal fa-fw" aria-hidden="true"></i> ' + statusAvgping + ': <span class="label label-success">' + averagePing + ' ms</span></p>' +
                    '<p><i class="fa fa-bolt fa-fw" aria-hidden="true"></i> ' + statusAvgpl + ': <span class="label label-success">' + averagePacketloss + '%</span></p>';
            } else {
                result = '<p><i class="fa fa-power-off fa-fw" aria-hidden="true"></i> Online: <span class="label label-danger">' + statusOffline + '</span></p>';
            }

            $("#serverstatus").html(result);
        },
        error: function (result) {
            $("#serverstatus").html('<p><i class="fa fa-power-off fa-fw" aria-hidden="true"></i> ' + statusOnline + ': <span class="label label-danger">ERROR</span></p>');
        }
    })
}
