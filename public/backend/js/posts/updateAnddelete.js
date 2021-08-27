$(function(){
    var data = posts.data;
    // Delete post
    $('.btn-delete-post').click(function(e){
        if(confirm('Bạn có chắc muốn xoá quyền này?')){
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: link_delete_post,
                data: {
                    id: id,
                    _method: 'DELETE'
                },
                success:function(res){
                    console.log(res);
                    notify('Xoá thành công!', 'success');
                    setTimeout(() => {
                        window.location.reload(true);
                    }, 1000);
                },
                error: function(e){
                    notify('Có lỗi xảy ra', 'danger');
                }
            });
        }
    });
});