
$.ajax({
    url: 'js/responsiveslides.min.js',
    dataType: 'script',
    cache: true,
    success: function() {
        $('#slider').responsiveSlides({
            pager: true,
            speed: 2000,            // Integer: Speed of the transition, in milliseconds
            // nav: true,
            namespace: "centered-btns"
        });
    }
});


$.ajax({
    url: 'js/blazy.min.js',
    dataType: 'script',
    cache: true,
    success: function() {
        var bLazy = new Blazy({
            container: 'body', // Default is window
        });
    }
});

$.ajax({
    url: 'js/jquery-2.2.0.min.js',
    dataType: 'script',
    cache: true,
    success: function() {
        $('.hamburger_toggle').click(function(e) {
            $(this).toggleClass('active');
            $('.menu_links_ul').toggleClass('active');
            e.preventDefault();
            return false;
        });

        $(".noclick").click(function (obj){
            obj.preventDefault();
        });
    }
});


function add_to_cart(product_slug, option_slug, url, csrf_token){
    var url_path = '/' + url.split("/").slice(3).join("/");
    var quantity = parseInt($('#product_quantity').val());
    if(!quantity){
        return;
    }
    $.ajaxSetup({
        headers: { 'X-CSRF-Token': $('input[name="_token"]').val() }
    });

    $.ajax({
        type: "POST",
        url: url_path,
        data: {
            'product_slug' : product_slug, 
            'option_slug'  : option_slug, 
            'quantity'     : quantity,
            'csrftoken'    : csrf_token
        }, success: function(response){
            // get current count items
            $('.counter_number').html(response.total_items);
            
            $('.cart_count').css('background', 'black');
            $('.product_added_trigger').css('display','block');
            
            setTimeout(function(){  
                $('.product_added_trigger').css('display','none');
                $('.cart_count').css('background', '#a0d6d2');
            }, 1000);

            // $('.counter_number').parent().css('background', '#a0d6d2');
        }, error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.status);
            alert(xhr.responseText);
        }, dataType: "json"
    
    }).done(function(){

    });
}

(function(){
    var StripeBillinForm = {
        init: function(){
            this.form = $('#paymentForm');
        }
    }
});