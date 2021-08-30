$(function () {
    // Search
    $('.input-search').keypress(function (event) {
        if (event.which == 13) {
            var code = $(this).val();
            window.location.href = url_codesended + '?code=' + code;
        }
    })
    // status
    $('select[name="state"]').change(function () {
        var state = $(this).val();
        var sort = $('select[name="sort"]').val();
        window.location.href = url_codesended + "?status=" + state + "&sort=" + sort;
    })
    // Sort
    $('select[name="sort"]').change(function () {
        var sort = $(this).val();
        var state = $('select[name="state"]').val();
        window.location.href = url_codesended + "?status=" + state + "&sort=" + sort;
    })
    // Thu hồi code
    $('.btn-recalled:not(.disabled)').click(function () {
        if (confirm('Bạn muốn thu hồi mã code?')) {
            var key = $(this).data('key');
            $.ajax({
                type: 'post',
                url: url_recalled,
                data: {
                    key: key,
                    _method : 'POST'
                },
                success: function (res) {
                    // res = res.trim();
                    if (res) {
                        $.notify({
                            message: "Thu hồi mã thành công !"
                        }, {
                            type: "success"
                        });
                    }
                },
                error: function (e) {
                    $.notify({
                        message: "Có lỗi !"
                    }, {
                        type: "danger"
                    });
                }
            });
        } else {
            return;
        }
    })
})
