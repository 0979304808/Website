$(function () {
    // Search
    $('.input-search').keypress(function (event) {
        if (event.which == 13) {
            var search = $(this).val();
            window.location.href = link_post + '?search=' + search;
        }
    })
    // category
    $('select[name="category"]').change(function () {
        var category = $(this).val();
        var tag = $('select[name="tag"]').val();
        window.location.href = link_post + "?category=" + category + "&tag=" + tag;
    })
    // tag
    $('select[name="tag"]').change(function () {
        var tag = $(this).val();
        var category = $('select[name="category"]').val();
        window.location.href = link_post + "?category=" + category + "&tag=" + tag;
    })

})
