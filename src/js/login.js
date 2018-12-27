var openLoginModal

$(function () {
    "use strict"
    var lm = $("#loginModal")
    var isModalShown = false
    var accounts
    var selectedCldbid
    var selectedNickname

    lm.find("#loginModal-codeconfirm").submit(function (e) {
        e.preventDefault()
        var codeInput = $(e.target[0])
        var code = codeInput.val()

        callLoginApi("login", {cldbid: selectedCldbid, code: code}, function (json) {
            if (json.success) {
                hideAll()
                lm.find(".status-loader").show()
                location.reload()
            } else {
                codeInput.addClass("is-invalid")
            }
        })
    })

    $(document).on("click", "[data-selectaccount]", function () {
        selectedCldbid = $(this).data("selectaccount")
        selectAccount()
    })

    $(".logoutUser").click(function (e) {
        callLoginApi("logout", {}, function () {
            location.reload()
        })
    })

    $("[data-openLoginModal]").click(function (e) {
        e.preventDefault()
        openLoginModal()
    })

    openLoginModal = function() {
        lm.modal("show")
        isModalShown = true;
        loadAccounts()
    }

    lm.on("hidden.bs.modal", function (e) {
        isModalShown = false;
    })

    function loadAccounts() {
        callLoginApi("getclients", {}, function (json) {
            if (!json.success) {
                showError()
                return
            }

            accounts = json.data
            var accountCount = Object.keys(accounts).length;
            hideAll()

            // If no accounts returned, show "not connected"
            if (accountCount === 0) {
                lm.find(".not-connected").show()

                setTimeout(function () {
                    if (isModalShown) {
                        loadAccounts()
                    }
                }, 2000)
            } else if (accountCount === 1) {
                // If only one account, auto-select it
                selectedCldbid = Object.keys(accounts)[0]

                selectAccount()
            } else {
                var html = ''
                var template = lm.find(".select-account #select-account-template").html()

                for (var i = 0; i < accountCount; i++) {
                    var cldbid = Object.keys(accounts)[i]
                    var nickname = escapeHtml(accounts[cldbid])

                    html += template.format(nickname, cldbid)
                }

                lm.find(".select-account .list-group").html(html)
                lm.find(".select-account").show()
            }
        })
    }

    function selectAccount() {
        callLoginApi("selectaccount", {cldbid: selectedCldbid}, function (json) {
            if (!json.success && json.code !== "CODE_ALREADY_GENERATED") {
                lm.find(".error-sendingcode").show()
                return
            }

            // get nickname by dbid
            selectedNickname = accounts[selectedCldbid]

            hideAll()
            lm.find(".selected-nickname").text(selectedNickname)
            lm.find(".confirmation-code").show()
        })
    }

    function callLoginApi(method, data, success) {
        data.method = method
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            url: "api/login.php",
            method: "post",
            data: data,
            success: success,
            error: function (result) {
                showError()
                console.log(result)
            }
        })
    }

    function showError() {
        hideAll()
        lm.find(".error-generic").show()
    }

    function hideAll() {
        lm.find(".error-generic").hide()
        lm.find(".error-sendingcode").hide()
        lm.find(".status-loader").hide()
        lm.find(".not-connected").hide()
        lm.find(".select-account").hide()
        lm.find(".confirmation-code").hide()
    }
})
