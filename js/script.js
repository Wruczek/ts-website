$(function () {
    $('[data-toggle="tooltip"]').tooltip({"html": true})
})

$('.news-body').readmore({
    speed: 500,
    collapsedHeight: 300,
    moreLink: '<button type="button" class="btn btn-dark"><i class="fa fa-plus-circle" aria-hidden="true"></i> ' + textShowMore + '</button>',
    lessLink: '<button type="button" class="btn btn-dark"><i class="fa fa-minus-circle" aria-hidden="true"></i> ' + textShowLess + '</button>'
});
