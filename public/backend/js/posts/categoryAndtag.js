$(function(){
    var data = posts.data;
    // Role and Permission
    // Save change categories for post
    $('.btn-save-change-role-admin').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var categories = [];
        $('.roles').each(function(){
            if(this.checked){
                categories.push($(this).val());
            }
        });
        $.ajax({
            type: 'POST',
            url: link_update_post_category,
            data: {
                id: id,
                categories: categories,
                _method: 'PUT'
            },
            success:function(res){
                $('.modal-role-admin').modal('hide');
                notify('Thêm thành công', 'success');
                setTimeout(() => {
                    window.location.reload(1)
                }, 1000);
            },
            error: function(e){
                $('.modal-role-admin').modal('hide');
                notify('Có lỗi xảy ra.','danger');
            }
        });
    });

    // Save change tags for post
    $('.btn-save-change-permission').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var tags = [];
        $('.permissions').each(function(){
            if(this.checked){
                tags.push($(this).val());
            }
        });
        $.ajax({
            type: 'POST',
            url: link_update_post_tag,
            data: {
                id: id,
                tags: tags,
                _method: 'PUT'
            },
            success:function(res){
                $('.modal-permission-admin').modal('hide');
                notify('Thêm thành công', 'success');
                setTimeout(() => {
                    window.location.reload(1)
                }, 1000);
            },
            error: function(e){
                $('.modal-permission-admin').modal('hide');
                notify('Có lỗi xảy ra.','danger');
            }
        });
    });

    // Show Modal Category
    $('.btn-role-for-admin').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');

        var key = $(this).data('key');
        var post = data[key];
        var categories = post.categories.map(function(item){
            return item.title;
        });
        //
        $('.roles').each(function(){
            var category = $(this).attr('name');
            (categories.indexOf(category) > -1) ? this.checked = true : this.checked = false;
        })
        $('.btn-save-change-role-admin').data('id', id);
        $('.modal-role-admin').modal('toggle');
    })

    // Show Modal Tag
    $('.btn-permission-for-admin').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var key = $(this).data('key');
        var post = data[key];
        var tags = post.tags.map(function(item){
            return item.title;
        });

        $('.permissions').each(function(){
            var tag = $(this).attr('name');
            (tags.indexOf(tag) > -1) ? this.checked = true : this.checked = false;
        })
        $('.btn-save-change-permission').data('id', id);
        $('.modal-permission-admin').modal('toggle');
    });
    //======= end role permission =======
    // action active account
    // $('.btn-active').click(function(){
    //     var id = $(this).data('id');
    //     var active = $(this).data('active');
    //     $.ajax({
    //         type: 'POST',
    //         url: link_active,
    //         data: {
    //             id: id,
    //             active: active,
    //             _method: 'PUT'
    //         },
    //         success:function(res){
    //             notify('Thành công', 'success');
    //             setTimeout(() => {
    //                 window.location.reload(true);
    //             }, 1000);
    //         },
    //         error: function(e){
    //             notify('Có lỗi xảy ra', 'danger');
    //         }
    //     });
    // });
});