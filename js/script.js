$(function () {
    $('[data-toggle="tooltip"]').tooltip({"html": true})
})

$('.news-body').readmore({
    speed: 500,
    collapsedHeight: 300,
    moreLink: '<button type="button" class="btn btn-info">Pokaż wiecej</button>',
    lessLink: '<button type="button" class="btn btn-info">Pokaż mniej</button>'
});
