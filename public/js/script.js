jQuery(document).ready(function() {

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
        position: 'bottom left',
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

function add_to_cart($product_slug, $option_slug, $url, $csrf_token){
    $url_path = '/' + $url.split("/").slice(3).join("/");
    // console.log($('input[name="_token"]').val());
    console.log($url_path);
    $.ajaxSetup({
        headers: { 'X-CSRF-Token': $('input[name="_token"]').val() }
    });

    $.ajax({
      type: "POST",
      url: $url_path,
      data: {
        'product_slug' : $product_slug, 
        'option_slug'  : $option_slug, 
        'quantity'     : $('#product_quantity').val(),
        'csrftoken'    : $csrf_token
      },
      success: function(){
        console.log("success");
      },
      error: function(xhr, ajaxOptions, thrownError){
        
            alert(xhr.status);
            alert(xhr.responseText);
      },
      dataType: "json"
    });
}

(function(){
    var StripeBillinForm = {
        init: function(){
            this.form = $('#paymentForm');
        }
    }
});
