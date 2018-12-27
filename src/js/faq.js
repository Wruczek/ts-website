$(document).ready(function() {
    var hash = decodeURIComponent(location.hash.substr(1))

    if (hash.startsWith("faq")) {
        var faqId = parseInt(hash.substr(3)) - 1 // IDs in faq start from 0

        // Check if FAQ is a number and is not lower than 0
        if (!faqId || faqId < 0) {
            return
        }

        var selectedCollapse = $("#faqcollapse-heading-" + faqId)

        // Check if element exists
        if (!selectedCollapse.length) {
            return
        }

        // Toggle collapse
        selectedCollapse.parent().find(".collapse").collapse({
            toggle: true
        })

        // Scroll body
        $("html,body").animate({
            scrollTop: selectedCollapse.offset().top - 60
        },"slow")
    }

    $(".copy-faq-url").click(function (e) {
        e.preventDefault()
        var currentUrl = window.location.href.split("#")[0]
        var faqid = parseInt($(this).data("faqid")) + 1
        var copied = copyTextToClipboard(currentUrl + "#faq" + faqid)

        $(this).tooltip("hide")
        updateTooltip($(this), copied ? FAQ_LANG.copy_success : FAQ_LANG.copy_error)
        $(this).tooltip("show")
    })
})
