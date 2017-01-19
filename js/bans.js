$(document).ready(function () {
    $('#banlist').dataTable({
        "order": [[3, "desc"]],
        "language": {
            "url": datatablesUrl
        }
    });
});
