$(function () {
    "use strict"

    checkStatus()

    var intervalId = setInterval(function() {
        checkStatus()
    }, 10 * 1000)

    function checkStatus() {
        var showError = function () {
            $(".server-status .data").hide()
            $(".server-status .error").show()
        }

        var showData = function () {
            $(".server-status .data").show()
            $(".server-status .error").hide()
        }

        $.ajax({
            url: "api/getstatus.php",
            success: function(json) {
                var data = json.data

                if (!json.success) {
                    showError()
                    console.log(json)
                    return
                }

                showData()

                var clientsPrecent = Math.round(data.clientsOnline * 100 / data.maxClients);
                var badges = $(".server-status .data .badge")

                badges.eq(0).text(data.clientsOnline + " / " + data.maxClients + " (" + clientsPrecent + "%)")
                updateTooltipWithTranslation(badges.eq(0), data.reservedSlots)

                badges.eq(1).text(data.onlineRecord)
                updateTooltipWithTranslation(badges.eq(1), timestampToDate(data.onlineRecordDate, true))

                badges.eq(2).text(data.uptimeFormatted)

                badges.eq(3).html(data.version + " on " + getPlatformIcon(data.platform))
                updateTooltipWithTranslation(badges.eq(3), data.version, data.platform)

                badges.eq(4).text(Math.round(data.averagePing * 100) / 100 + " ms")
                badges.eq(5).text(Math.round(data.averagePacketloss * 10000) / 100 + "%")
            },
            error: function(result) {
                showError()
            },
            complete: function () {
                $(".server-status").addClass("loaded")
            }
        })
    }

    function getPlatformIcon(platform) {
        var platformIcon = '<i class="fab fa-[0] mr-0"></i>'

        switch (platform.toLowerCase()) {
            case "windows":
                platformIcon = platformIcon.format("windows")
                break;
            case "linux":
                platformIcon = platformIcon.format("linux")
                break;
            case "os x":
            case "macos":
                platformIcon = platformIcon.format("apple")
                break;
            default:
                platformIcon = platform
        }

        return platformIcon
    }
})
