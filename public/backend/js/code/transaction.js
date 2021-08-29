$(function () {
    // Search
    $('.input-search').keypress(function (event) {
        if (event.which == 13) {
            var search = $(this).val();
            window.location.href = url_transaction + '?search=' + search;
        }
    })
    // Filter
    $('select[name="provider"]').change(function () {
        var provider = $(this).val();
        var sort = $('select[name="sort"]').val();
        window.location.href = url_transaction + "?filter=" + provider + "&sort=" + sort;
    })
    // Sort
    $('select[name="sort"]').change(function () {
        var sort = $(this).val();
        var provider = $('select[name="provider"]').val();
        window.location.href = url_transaction + "?filter=" + provider + "&sort=" + sort;
    })

    $('.purchase_detail').click(function(e){
        var code = $(this).data('code');
        $.ajax({
            type: "post",
            url: url_get_purchase,
            data: {
                code:code,
                _method: 'GET'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if(res.status == 200){
                    var purchase = res.data;
                    $("#name_p").html(' ' + purchase.name);
                    $("#code_p").html(' ' + purchase.code);
                    $("#items_p").html(' ' + purchase.items);
                    $("#price_p").html(' ' + purchase.price);
                    $("#created_at_p").html(' ' + purchase.created_at);
                    $("#email_p").html(' ' + purchase.email);
                    $("#address_p").html(' ' + purchase.address);
                    $("#phone_p").html(' ' + purchase.phone);
                    $("#time_success_p").html((purchase.time_success) ? ' ' + purchase.time_success : '');
                    $("#salesman_p").html((purchase.admin != null) ? ' ' + purchase.admin.username : '');
                    $("#care_dairy_p").html(' ' + $("<p>" +purchase.care_dairy + "</p>").text()); //trick strip_tag html
                }
            },
            error: function(res){
                $('.label_text').html(' ');
                e.preventDefault();
            }
        });
    });
})
