$(function() {
    $('.btn-user-update-image').click(function () {
        var image = document.querySelector('#image').files;
        var id = $('#id').val();
        if (image.length > 0) {
            var image = image[0];
            var images = new FileReader();
            images.onload = function (FileLoadEvent) {
                var base64 = FileLoadEvent.target.result;
                console.log(base64);
                $.ajax({
                    type: 'POST',
                    url: window.location.origin + '/auth/profile/' + id + '/image',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id : id,
                        base64: base64,
                        _method: 'PUT'
                    },
                    success: function (res) {
                        console.log(res);
                        notify('Cập nhật thành công', 'success');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function (e) {
                        notify('Có lỗi', 'danger');
                    }
                });
            }
            images.readAsDataURL(image)
        }
    });
});
