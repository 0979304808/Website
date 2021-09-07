$(function () {
    //======== edit comment =========
    $('.btn-edit-submit-comment').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var type = $(this).data('type');
        var content = $('#editor-edit-' + type + '-' + id).html();
        if (content == '') {
            alert('Nhập dữ liệu!');
            return;
        }
        $.ajax({
            type: 'PUT',
            url: link_comment_update,
            data: {
                _method: 'PUT',
                _id: id,
                type: type,
                content: content.trim(),
            },
            success: function (res) {
                console.log(res);
                window.location.reload(true)
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
    //======== edit post =========
    $('.btn-edit-submit').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var content = $('#editor-edit-post-' + id).html();
        var title = $('#title-edit-post-' + id).val();
        var category = $('#category-edit-post-' + id).val();
        if (title == '' || content == '') {
            alert('Nhập dữ liệu!');
            return;
        }
        $.ajax({
            type: 'POST',
            url: link_post_create,
            data: {
                _method: 'POST',
                id: id,
                category_id: category,
                content: content.trim(),
                title: title.trim()
            },
            success: function (res) {
                window.location.reload(true)
            },
            error: function (e) {
                console.log(e);
            }
        });
    });

    //======== delete comment =========
    $('.btn-delete-comment').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var type = $(this).data('type');
        if (confirm('Bạn có chắc muốn xoá bài viết?')) {
            $.ajax({
                type: 'POST',
                url: link_comment_delete,
                data: {
                    id: id,
                    type: type,
                    _method: 'DELETE'
                },
                success: function (res) {
                    window.location.reload(true);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
        return;
    });
    //======== delete post =========
    $('.btn-delete-post').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (confirm('Bạn có chắc muốn xoá bài viết?')) {
            $.ajax({
                type: 'POST',
                url: link_post_delete,
                data: {
                    id: id,
                    _method: 'DELETE'
                },
                success: function (res) {
                    console.log(res);
                    window.location.reload(true);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
        return;
    });
    //======== submit editor =========
    $('.btn-submit').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var type = $(this).data('type');
        var content = $('#editor-' + id).html();
        var user = $('select[name="account"]').val();
        var data = {};
        console.log(user);

        if (content == '') {
            notify('Nhập nội dung!', 'danger');
            $('#editor-' + id).focus();
            return;
        }
        if (type == 'post') {
            var title = $('input[name="title"]').val();
            var link = $('input[name="link"]').val();
            var category_id = $('select[name="category"]').val();
            if (title == '') {
                notify('Nhập tiêu đề!', 'danger');
                $('input[name="title"]').focus();
                return;
            }
            data = {
                user_id: user,
                type: type,
                category_id: category_id,
                title: title,
                link: link,
                content: content,
                _method: 'POST'
            };
        } else {
            data = {
                id: id,
                user_id: user,
                type: type,
                content: content
            };
        }

        $.ajax({
            type: 'POST',
            url: (type == 'post') ? link_post_create : link_comment_create,
            data: data,
            success: function (res) {
                console.log(res);
                window.location.reload(true);
            },
            error: function (e) {
                console.log(e);
            }
        });

    });

    //========= end =========
    // show or hide box comment
    $('.btn-comment').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('.comments-' + id).toggle(10, function () {
            $(this).removeClass('hidden');
        });
    });

    // show or hide child comment
    $('.btn-child').on('click', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('.box-child-comments-' + id).toggle(10, function () {
            $(this).removeClass('hidden');
        })
    });

    // // language
    // $('select[name="language"]').change(function () {
    //     var language = $(this).val();
    //     var account = $('select[name="account"]').val();
    //     var category = $('select[name="se-category"]').val();
    //     window.location.href = link_socials_post + "?language=" + language + "&account=" + account + "&category=" + category;
    // });
    // // Account
    // $('select[name="account"]').change(function () {
    //     var account = $(this).val();
    //     var language = $('select[name="language"]').val();
    //     var category = $('select[name="se-category"]').val();
    //     window.location.href = link_socials_post + "?language=" + language + "&account=" + account + "&category=" + category;
    // });
    // // Category
    // $('select[name="se-category"]').change(function () {
    //     var category = $(this).val();
    //     var account = $('select[name="account"]').val();
    //     var language = $('select[name="language"]').val();
    //     window.location.href = link_socials_post + "?language=" + language + "&account=" + account + "&category=" + category;
    // });




});