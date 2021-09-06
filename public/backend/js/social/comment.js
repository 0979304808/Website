$(function () {

    //change select option status
    $('.statusOptionCmt').change(function () {
        var status = $(this).val();
        var lang = $('.languageOptionCmt').val();
        var type_cmt = $('.cmtOption').val();
        window.location.href = link_getcomment + '?status=' + status + '&lang=' + lang + '&typecmt=' + type_cmt;
    })
    //change select option language
    $('.languageOptionCmt').change(function () {
        var status = $('.statusOptionCmt').val();
        var lang = $(this).val();
        var type_cmt = $('.cmtOption').val();
        window.location.href = link_getcomment + '?status=' + status + '&lang=' + lang + '&typecmt=' + type_cmt;
    })
    //change select option type comment
    $('.cmtOption').change(function () {
        var status = $('.statusOptionCmt').val();
        var lang = $('.languageOptionCmt').val();
        var type_cmt = $(this).val();
        window.location.href = link_getcomment + '?status=' + status + '&lang=' + lang + '&typecmt=' + type_cmt;
    })

    //change status 
    $('.btn-action').click(function (e) {
        e.preventDefault();
        var title = $(this).attr('data-text');
        var type = $(this).data('type');
        var id = $(this).data('id');
        var reason = '';
        var kind = $(this).attr('data-kind');

        $.ajax({
            type: 'POST',
            url: link_update_status_post,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                type: type,
                title:title,
                reason: reason,
                kind: kind,
                _method: 'PUT'
            },
            success: function (res) {
                notify('Thành công', 'success');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            },
            error: function (e) {
                console.log(e);
            }
        });
    })

})
