$(function(){

    //change select option status
    $('.statusOption').change(function(){
        var status = $(this).val();
        var lang = $('.languageOption').val();
        window.location.href = link_socials_release + '?status=' + status + '&lang=' + lang;
    });
    //change select option language
    $('.languageOption').change(function(){
        var status = $('.statusOption').val();
        var lang = $(this).val();
        window.location.href = link_socials_release + '?status=' + status + '&lang=' + lang;
    });

    //change Sale
    $('.btn-sale').click(function(){
        id = $(this).attr('data-id');
        status = $(this).attr('data-status');
        _this = $(this);
        $.ajax({
            type: "PUT",
            url: link_change_sale,
            data: {id : id},
            success: function (response) {
                notify('Thành công','success');
                if(status==0){
                    _this.attr('class','btn btn-xs btn-sale btn-success');
                    _this.attr('data-status',1);
                }else{
                    _this.attr('class','btn btn-xs btn-sale btn-default');
                    _this.attr('data-status',0);
                }
            }
        });
    });

    //change status 
    $('.btn-action').click(function(e){
        e.preventDefault();
        var title = $(this).attr('data-text');
        var type = $(this).data('type');
        var id = $(this).data('id');
        var reason = '';
        var kind = $(this).attr('data-kind');
        if((type == 'delete' || type=='spam') && kind == 1){
            var reason = prompt('Nhập lý do xóa bài viết');
            if(reason == null){
                return false;
            }else if(reason == ''){
                alert('Bạn chưa nhập lý do');
                return false;
            }
        }
        $.ajax({
            type: 'POST',
            url: link_update_status_post,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: id,
                type: type,
                title: title,
                reason: reason,
                kind: kind,
                _method: 'PUT'
            },
            success:function(res){
                console.log(res);
                notify('Thành công','success');
                setTimeout(function() { 
                    window.location.reload();
                }, 1000);
            },
            error: function(e){
                console.log(e);
            }
        });
        
    })

    //========= end =========
    // show or hide box comment
    $('.btn-comment').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('.comments-'+id).toggle(200, function(){
            $(this).removeClass('hidden');
        });
    });

    // show or hide child comment
    $('.btn-child').on('click', function(e){
        e.preventDefault();
        var id = $(this).data('id');
        $('.box-child-comments-'+id).toggle(200, function(){
            $(this).removeClass('hidden');
        })
    });

});