/*
refreshViewer()

var intervalId = setInterval(function() {
    refreshViewer()
}, 10 * 1000)

function refreshViewer() {
    var showError = function () {
        $(".viewer-container").hide()
        $(".viewer-error").show()
    }

    var showData = function () {
        $(".viewer-container").show()
        $(".viewer-error").hide()
    }

    $.ajax({
        url: "api/getviewerhtml.php",
        success: function (result) {
            $(".viewer-container").html(result)
            updateHooks()
            showData()
        },
        error: function(result) {
            showError()
        },
        complete: function () {
            $(".viewer-container").addClass("loaded")
        }
    })
}
*/

// show the viewer tip if no cookie present
if (!Cookies.get("tswebsite_viewertip_hide")) {
    var alert = $("#server-viewer-tip")
    alert.show()

    // preserve alert dismiss with a cookie
    alert.find(".close").click(function (e) {
        e.preventDefault()
        Cookies.set("tswebsite_viewertip_hide", true, {expires: 365});
    })
}

// The show-empty-channels button
$("[data-emptychannels]").click(function (e) {
    var el = $(this)
    var show = el.data("emptychannels") === "show"
    $("[data-emptychannels]").show()
    el.hide()

    var emptyChannels = $(".viewer-container .not-occupied")
    show ? emptyChannels.show() : emptyChannels.hide()
})

// Press ENTER to connect to a focused channel
$("[data-channelid]").keypress(function (e) {
    if (e.which === 13) {
        $(this).click()
    }
})

// Click to connect to the channel
$("[data-channelid]").click(function (e) {
    if ($(this).parent(".channel-container").hasClass("is-spacer")) {
        return // dont connect when clicking on a spacer
    }

    if (!confirm(VIEWER_LANG.connection_alert)) {
        return
    }

    var cid = $(this).data("channelid")

    window.location = "ts3server://" + TS3_DISPLAY_IP + "/?cid=" + cid
})

// START Code for showing the customised popover when you hover over the client
// Mouse in / out
$(".viewer-container .client-container").hover(function () {
    showPopover($(this).find(".client-name"))
}, function () {
    $(this).find(".client-name").popover("hide")
})

// Keyboard focus (TAB)
$(".viewer-container .client-container").on("focusin focusout", function (e) {
    if (e.type === "focusin") {
        showPopover($(this).find(".client-name"))
    } else {
        $(this).find(".client-name").popover("hide")
    }
})
// END

// Popover code, to be shown at the bottom of .client-name
$(".viewer-container .client-container .client-name").popover({
    title: VIEWER_LANG.client_info,
    content: function () {
        var el = $(this)

        return '<div class="status-loader position-relative p-3">' +
            '<div class="loader"></div>' +
            '</div>'
    },
    html: true,
    template: '<div class="popover" role="tooltip"><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
    placement: "bottom",
    trigger: "manual"
})

function showPopover(el) {
    el.popover("show")

    var cldbid = el.parent().data("clientdbid")

    if (!cldbid) {
        return
    }

    var popoverDebounceMs = 250

    // Debounce the hovers
    setTimeout(function () {
        var popoverId = el.attr("aria-describedby")

        if (!$("#" + popoverId).length) {
            return
        }

        $.ajax({
            url: "api/getclientinfo.php",
            data: { cldbid: cldbid },
            success: function (result) {
                if (!result.success) {
                    updatePopover(el.attr("aria-describedby"), "Result error", result.message || ":(")
                    return
                }

                var describeSeconds = function (seconds) {
                    return moment().seconds(-seconds).fromNow()
                }

                var describeTimestamp = function (timestamp, skipSuffix) {
                    if (skipSuffix === undefined)
                        skipSuffix = true

                    return moment.unix(timestamp).fromNow(skipSuffix)
                }

                var time = result.timenow
                var data = result.data
                var title = escapeHtml(data.client_nickname)

                var idleSeconds = Math.round(data.client_idle_time / 1000)
                var onlineTimestamp = data.client_lastconnected
                var createdTimestamp = data.client_created

                var clientInfo = []

                clientInfo.push([VIEWER_LANG.last_active, describeSeconds(idleSeconds)])
                clientInfo.push([VIEWER_LANG.online_time, describeTimestamp(onlineTimestamp)])
                clientInfo.push([VIEWER_LANG.first_joined, describeTimestamp(createdTimestamp, false)])

                var body = '<table>'

                clientInfo.forEach(function (entry) {
                    var description = entry[0]
                    var value = entry[1]

                    body += '<tr>'
                    body += '<td><b>' + description + '&nbsp;</b></td>'
                    body += '<td>' + value + '</td>'
                    body += '</tr>'
                })

                body += '</table>'

                updatePopover(popoverId, title, body)
            },
            error: function (result) {
                updatePopover(popoverId, "Ajax error", VIEWER_LANG.viewer_error)
            },
            complete: function (result) {
                el.popover("update")
            }
        })
    }, popoverDebounceMs)
}

function updatePopover(id, header, body) {
    if (!id) {
        return
    }

    var popover = $("#" + id)
    popover.find(".popover-header").html(header)
    popover.find(".popover-body").html(body)
}
