jQuery(document).ready(function() {

    $('.toggle-nav').click(function(e) {
        console.log("trigger");
        $(this).toggleClass('active');
        $('.menu_links_ul').toggleClass('active');
        e.preventDefault();
    });
});

function render_ingredient(url){
    var data;
    jQuery.ajaxSetup({async:false});
    $.ajax({
        type: "GET",
        url: url,
        success: function(response){
            console.log("success");
            data = response
        },
        error: function(xhr, ajaxOptions, thrownError){
            console.log("error");
            alert(xhr.status);
            alert(xhr.responseText);
        },
    });
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
