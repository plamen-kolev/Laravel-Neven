jQuery(document).ready(function() {
    $('#slider').responsiveSlides({
        pager: true,
        speed: 2000,            // Integer: Speed of the transition, in milliseconds
        // nav: true,
        namespace: "centered-btns"
    });

    var bLazy = new Blazy({
        container: 'body', // Default is window
    });
    
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


/*! http://responsiveslides.com v1.54 by @viljamis */
(function(c,I,B){c.fn.responsiveSlides=function(l){var a=c.extend({auto:!0,speed:500,timeout:4E3,pager:!1,nav:!1,random:!1,pause:!1,pauseControls:!0,prevText:"Previous",nextText:"Next",maxwidth:"",navContainer:"",manualControls:"",namespace:"rslides",before:c.noop,after:c.noop},l);return this.each(function(){B++;var f=c(this),s,r,t,m,p,q,n=0,e=f.children(),C=e.size(),h=parseFloat(a.speed),D=parseFloat(a.timeout),u=parseFloat(a.maxwidth),g=a.namespace,d=g+B,E=g+"_nav "+d+"_nav",v=g+"_here",j=d+"_on",
w=d+"_s",k=c("<ul class='"+g+"_tabs "+d+"_tabs' />"),x={"float":"left",position:"relative",opacity:1,zIndex:2},y={"float":"none",position:"absolute",opacity:0,zIndex:1},F=function(){var b=(document.body||document.documentElement).style,a="transition";if("string"===typeof b[a])return!0;s=["Moz","Webkit","Khtml","O","ms"];var a=a.charAt(0).toUpperCase()+a.substr(1),c;for(c=0;c<s.length;c++)if("string"===typeof b[s[c]+a])return!0;return!1}(),z=function(b){a.before(b);F?(e.removeClass(j).css(y).eq(b).addClass(j).css(x),
n=b,setTimeout(function(){a.after(b)},h)):e.stop().fadeOut(h,function(){c(this).removeClass(j).css(y).css("opacity",1)}).eq(b).fadeIn(h,function(){c(this).addClass(j).css(x);a.after(b);n=b})};a.random&&(e.sort(function(){return Math.round(Math.random())-0.5}),f.empty().append(e));e.each(function(a){this.id=w+a});f.addClass(g+" "+d);l&&l.maxwidth&&f.css("max-width",u);e.hide().css(y).eq(0).addClass(j).css(x).show();F&&e.show().css({"-webkit-transition":"opacity "+h+"ms ease-in-out","-moz-transition":"opacity "+
h+"ms ease-in-out","-o-transition":"opacity "+h+"ms ease-in-out",transition:"opacity "+h+"ms ease-in-out"});if(1<e.size()){if(D<h+100)return;if(a.pager&&!a.manualControls){var A=[];e.each(function(a){a+=1;A+="<li><a href='#' class='"+w+a+"'>"+a+"</a></li>"});k.append(A);l.navContainer?c(a.navContainer).append(k):f.after(k)}a.manualControls&&(k=c(a.manualControls),k.addClass(g+"_tabs "+d+"_tabs"));(a.pager||a.manualControls)&&k.find("li").each(function(a){c(this).addClass(w+(a+1))});if(a.pager||a.manualControls)q=
k.find("a"),r=function(a){q.closest("li").removeClass(v).eq(a).addClass(v)};a.auto&&(t=function(){p=setInterval(function(){e.stop(!0,!0);var b=n+1<C?n+1:0;(a.pager||a.manualControls)&&r(b);z(b)},D)},t());m=function(){a.auto&&(clearInterval(p),t())};a.pause&&f.hover(function(){clearInterval(p)},function(){m()});if(a.pager||a.manualControls)q.bind("click",function(b){b.preventDefault();a.pauseControls||m();b=q.index(this);n===b||c("."+j).queue("fx").length||(r(b),z(b))}).eq(0).closest("li").addClass(v),
a.pauseControls&&q.hover(function(){clearInterval(p)},function(){m()});if(a.nav){g="<a href='#' class='"+E+" prev'>"+a.prevText+"</a><a href='#' class='"+E+" next'>"+a.nextText+"</a>";l.navContainer?c(a.navContainer).append(g):f.after(g);var d=c("."+d+"_nav"),G=d.filter(".prev");d.bind("click",function(b){b.preventDefault();b=c("."+j);if(!b.queue("fx").length){var d=e.index(b);b=d-1;d=d+1<C?n+1:0;z(c(this)[0]===G[0]?b:d);if(a.pager||a.manualControls)r(c(this)[0]===G[0]?b:d);a.pauseControls||m()}});
a.pauseControls&&d.hover(function(){clearInterval(p)},function(){m()})}}if("undefined"===typeof document.body.style.maxWidth&&l.maxwidth){var H=function(){f.css("width","100%");f.width()>u&&f.css("width",u)};H();c(I).bind("resize",function(){H()})}})}})(jQuery,this,0);


/*!
  hey, [be]Lazy.js - v1.6.2 - 2016.05.09
  A fast, small and dependency free lazy load script (https://github.com/dinbror/blazy)
  (c) Bjoern Klinggaard - @bklinggaard - http://dinbror.dk/blazy
*/
  (function(p,m){"function"===typeof define&&define.amd?define(m):"object"===typeof exports?module.exports=m():p.Blazy=m()})(this,function(){function p(b){var c=b._util;c.elements=B(b.options.selector);c.count=c.elements.length;c.destroyed&&(c.destroyed=!1,b.options.container&&k(b.options.container,function(a){n(a,"scroll",c.validateT)}),n(window,"resize",c.save_viewportOffsetT),n(window,"resize",c.validateT),n(window,"scroll",c.validateT));m(b)}function m(b){for(var c=b._util,a=0;a<c.count;a++){var d=c.elements[a],f=d.getBoundingClientRect();if(f.right>=e.left&&f.bottom>=e.top&&f.left<=e.right&&f.top<=e.bottom||q(d,b.options.successClass))b.load(d),c.elements.splice(a,1),c.count--,a--}0===c.count&&b.destroy()}function x(b,c,a){if(!q(b,a.successClass)&&(c||a.loadInvisible||0<b.offsetWidth&&0<b.offsetHeight))if(c=b.getAttribute(r)||b.getAttribute(a.src)){c=c.split(a.separator);var d=c[y&&1<c.length?1:0],f="img"===b.nodeName.toLowerCase();if(f||void 0===b.src){var l=new Image,u=function(){a.error&&a.error(b,"invalid");t(b,a.errorClass);g(l,"error",u);g(l,"load",h)},h=function(){if(f){b.src=d;v(b,"srcset",a.srcset);var c=b.parentNode;c&&"picture"===c.nodeName.toLowerCase()&&k(c.getElementsByTagName("source"),function(b){v(b,"srcset",a.srcset)})}else b.style.backgroundImage='url("'+d+'")';w(b,a);g(l,"load",h);g(l,"error",u)};n(l,"error",u);n(l,"load",h);l.src=d}else b.src=d,w(b,a)}else"video"===b.nodeName.toLowerCase()?(k(b.getElementsByTagName("source"),function(b){v(b,"src",a.src)}),b.load(),w(b,a)):(a.error&&a.error(b,"missing"),t(b,a.errorClass))}function w(b,c){t(b,c.successClass);c.success&&c.success(b);b.removeAttribute(c.src);k(c.breakpoints,function(a){b.removeAttribute(a.src)})}function v(b,c,a){var d=b.getAttribute(a);d&&(b[c]=d,b.removeAttribute(a))}function q(b,c){return-1!==(" "+b.className+" ").indexOf(" "+c+" ")}function t(b,c){q(b,c)||(b.className+=" "+c)}function B(b){var c=[];b=document.querySelectorAll(b);for(var a=b.length;a--;c.unshift(b[a]));return c}function z(b){e.bottom=(window.innerHeight||document.documentElement.clientHeight)+b;e.right=(window.innerWidth||document.documentElement.clientWidth)+b}function n(b,c,a){b.attachEvent?b.attachEvent&&b.attachEvent("on"+c,a):b.addEventListener(c,a,!1)}function g(b,c,a){b.detachEvent?b.detachEvent&&b.detachEvent("on"+c,a):b.removeEventListener(c,a,!1)}function k(b,c){if(b&&c)for(var a=b.length,d=0;d<a&&!1!==c(b[d],d);d++);}function A(b,c,a){var d=0;return function(){var f=+new Date;f-d<c||(d=f,b.apply(a,arguments))}}var r,e,y;return function(b){if(!document.querySelectorAll){var c=document.createStyleSheet();document.querySelectorAll=function(a,b,d,h,e){e=document.all;b=[];a=a.replace(/\[for\b/gi,"[htmlFor").split(",");for(d=a.length;d--;){c.addRule(a[d],"k:v");for(h=e.length;h--;)e[h].currentStyle.k&&b.push(e[h]);c.removeRule(0)}return b}}var a=this,d=a._util={};d.elements=[];d.destroyed=!0;a.options=b||{};a.options.error=a.options.error||!1;a.options.offset=a.options.offset||100;a.options.success=a.options.success||!1;a.options.selector=a.options.selector||".b-lazy";a.options.separator=a.options.separator||"|";a.options.container=a.options.container?document.querySelectorAll(a.options.container):!1;a.options.errorClass=a.options.errorClass||"b-error";a.options.breakpoints=a.options.breakpoints||!1;a.options.loadInvisible=a.options.loadInvisible||!1;a.options.successClass=a.options.successClass||"b-loaded";a.options.validateDelay=a.options.validateDelay||25;a.options.save_viewportOffsetDelay=a.options.save_viewportOffsetDelay||50;a.options.srcset=a.options.srcset||"data-srcset";a.options.src=r=a.options.src||"data-src";y=1<window.devicePixelRatio;e={};e.top=0-a.options.offset;e.left=0-a.options.offset;a.revalidate=function(){p(this)};a.load=function(a,b){var c=this.options;void 0===a.length?x(a,b,c):k(a,function(a){x(a,b,c)})};a.destroy=function(){var a=this._util;this.options.container&&k(this.options.container,function(b){g(b,"scroll",a.validateT)});g(window,"scroll",a.validateT);g(window,"resize",a.validateT);g(window,"resize",a.save_viewportOffsetT);a.count=0;a.elements.length=0;a.destroyed=!0};d.validateT=A(function(){m(a)},a.options.validateDelay,a);d.save_viewportOffsetT=A(function(){z(a.options.offset)},a.options.save_viewportOffsetDelay,a);z(a.options.offset);k(a.options.breakpoints,function(a){if(a.width>=window.screen.width)return r=a.src,!1});setTimeout(function(){p(a)})}});