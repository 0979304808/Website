$(function() {
    // Search
    $('.input-search').keypress(function(event) {
        if (event.which == 13) {
            var search = $(this).val();
            var start_time = $('select[name="start_time"]').val();
            window.location.href = url_usersubscribe + '?start_time=' + start_time + '&search=' + search;
        }
    })
    // Sort
    $('select[name="start_time"]').change(function() {
        var start_time = $(this).val();
        var search = $('.input-search').val()
        window.location.href = url_usersubscribe + "?start_time=" + start_time + '&search=' + search;
    })
})