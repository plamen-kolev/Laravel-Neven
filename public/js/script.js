jQuery(document).ready(function() {
    
    // unveil js
    $("img").unveil();

    $('.hamburger_toggle').click(function(e) {
        console.log("trigger");
        $(this).toggleClass('active');
        $('.menu_links_ul').toggleClass('active');
        e.preventDefault();
        return false;
    });

    $(".noclick").click(function (obj){
        obj.preventDefault();
    });

});

function drop_ingredient(data, slug){
    var drop = new Drop({
        target: document.querySelector('#'+ slug +''),
        content: data,
        position: 'bottom center',
    });

    drop.toggle();

}

function render_ingredient(url, slug){
    var data;
    if(loaded_ingredients[slug]){
        data = loaded_ingredients[slug];
        drop_ingredient(data, slug)
    } else {

        $.ajax({
            type: "GET",
            url: url,
            success: function(response){
                data = response
            },
            error: function(xhr, ajaxOptions, thrownError){
                console.log("error");
                alert(xhr.status);
                alert(xhr.responseText);
            },
        }).done(function(){
            drop_ingredient(data, slug)

        });

        loaded_ingredients[slug] = data;
    }

    return data;
}

function add_to_cart(product_slug, option_slug, url, csrf_token){
    var url_path = '/' + url.split("/").slice(3).join("/");
    var quantity = parseInt($('#product_quantity').val());
    if(!quantity){
        console.log("positive numbers please :/");
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
