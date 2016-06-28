jQuery(document).ready(function() {
    
    // unveil js
    $("img").unveil(150);

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







//  EXTERNAL

/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */

;(function($) {

  $.fn.unveil = function(threshold, callback) {

    var $w = $(window),
        th = threshold || 0,
        retina = window.devicePixelRatio > 1,
        attrib = retina? "data-src-retina" : "data-src",
        images = this,
        loaded;

    this.one("unveil", function() {
      var source = this.getAttribute(attrib);
      source = source || this.getAttribute("data-src");
      if (source) {
        this.setAttribute("src", source);
        if (typeof callback === "function") callback.call(this);
      }
    });

    function unveil() {
      var inview = images.filter(function() {
        var $e = $(this);
        if ($e.is(":hidden")) return;

        var wt = $w.scrollTop(),
            wb = wt + $w.height(),
            et = $e.offset().top,
            eb = et + $e.height();

        return eb >= wt - th && et <= wb + th;
      });

      loaded = inview.trigger("unveil");
      images = images.not(loaded);
    }

    $w.on("scroll.unveil resize.unveil lookup.unveil", unveil);

    unveil();

    return this;

  };

})(window.jQuery || window.Zepto);
