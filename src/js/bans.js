$(document).ready(function() {
    var bansTable = $("#banlist").DataTable({
        responsive: {
            details: {
                type: "column",
                target: "tr"
            }
        },
        order: [
            [3, "desc"]
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/" + DATATABLES_LANGUAGE_NAME + ".json"
        },
        initComplete: function(settings, json) {
            console.log("DataTables Loaded")
            $("#banlist-loader").hide()
            $("#banlist").show()
        }
        /*
        TODO:
        It looks better with the "search" text as an placeholder instead of the label
        But its impossible to combine the translation from a CDN. Either gets overwritten by another
        It might be worth experimenting more with DataTables API to make it somehow work...
        oLanguage: {
            sSearch: "_INPUT_",
            sSearchPlaceholder: {_"DATATABLES_PLACEHOLDER_SEARCH"}
        }
        */
    });

    var responsiveTip = $("#responsive-table-details-tip")

    // show / hide the tip about responsive tables
    bansTable.on("responsive-resize", function () {
        if (bansTable.responsive.hasHidden() && !Cookies.get("tswebsite_banrowtip_hide")) {
            responsiveTip.show()
        } else {
            responsiveTip.hide()
        }
    });

    // preserve alert dismiss with a cookie
    responsiveTip.find(".close").click(function (e) {
        e.preventDefault()
        Cookies.set("tswebsite_banrowtip_hide", true, {expires: 365});
    })
});
