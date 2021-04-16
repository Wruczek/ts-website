$(document).ready(function() {
    var hash = decodeURIComponent(location.hash.substr(1))

    // use an function so we can return early
    function displayFaq(hash) {
        var faqId = parseInt(hash.substr(3)) - 1 // IDs in faq start from 0

        // Check if FAQ is a number and is not lower than 0
        if (isNaN(faqId) || faqId < 0) {
            return
        }

        var selectedCollapse = $("#faqcollapse-heading-" + faqId)

        // Check if element exists
        if (selectedCollapse.length) {
            // Toggle collapse
            selectedCollapse.parent().find(".collapse").collapse({
                toggle: true
            })

            // Scroll body
            $("html,body").animate({
                scrollTop: selectedCollapse.offset().top - 60
            }, "slow")
        }
    }

    if (hash.startsWith("faq")) {
        displayFaq(hash)
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
