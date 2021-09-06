$(function(){
    // ========= update =========
    $('.editable').editable({
        validate: function(value){
            if(!value) return "Không để rỗng!";
        },
        success: function(res, value){
            var $this = $(this)[0].dataset;
            var field = $this.field;
            var id = $this.id;
            var country = $this.country;
            var value = value.trim();

            $.ajax({
                type: 'POST',
                url: link_update_package,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    field: field,
                    id: id,
                    country: country,
                    value: value,
                    _method: 'PUT'
                },
                success:function(res){
                    notify('Cập nhật thành công', 'success');
                },
                error: function(e){
                    notify('Có lỗi', 'danger');
                }
            });
        }
    })
    
    $('.editable-time').editable({
        validate: function(value){
            if(!value) return "Không để rỗng!";
        },
        success: function(res, value){
            var $this = $(this)[0].dataset;
            var field = $this.field;
            var id = $this.id;
            var country = $this.country;
            var value = new Date(value).toISOString().slice(0, 10);

            $.ajax({
                type: 'POST',
                url: link_update_package,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    field: field,
                    id: id,
                    country: country,
                    value: value,
                    time: true,
                    _method: 'PUT'
                },
                success:function(res){
                    notify('Cập nhật thành công', 'success');
                },
                error: function(e){
                    notify('Có lỗi', 'danger');
                }
            });
        }
    })


    $('.btn-delete').click(function(e){
        var id = $(this).data('id');
        if(confirm('Bạn có chắc muốn xoá gói nâng cấp này?')){
            $.ajax({
                type: 'POST',
                url: link_delete_package,
                data: {
                    id: id,
                    _method: 'DELETE'
                },
                success:function(res){
                    notify('Xoá thành công', 'success');
                    window.location.reload(true);
                },
                error: function(e){
                    notify('Có lỗi xảy ra', 'danger');
                    console.log(e);
                }
            });
        }
    })
    $('.btn-publish').click(function(e){
        var id = $(this).data('id');
        var publish = $(this).data('publish');
        $.ajax({
            type: 'POST',
            url: link_publish_package,
            data: {
                id: id,
                publish: publish,
                _method: 'PUT'
            },
            success:function(res){
                notify('Phát hành thành công', 'success');
                window.location.reload(true);
            },
            error: function(e){
                notify('Có lỗi xảy ra', 'danger');
                console.log(e);
            }
        });
    })
})