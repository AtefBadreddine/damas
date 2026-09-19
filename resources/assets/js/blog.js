/*global $, alert, console, prompt*/

$(document).ready(function () {

    'use strict';
    
    /* blog page */
    /*$(".sliding3 .owl-carousel").owlCarousel({
        autoplay: true,
        rtl: true,
        margin: 0,
        loop: true,
        autoplaySpeed: 2500,
        navSpeed: 1000,
        autoplayHoverPause: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            1200:{
                items: 2,
                nav: true
            }
           
        }

    });*/
    function change_slider(cnt)
    {
        var gitem = $(".sliding3-item");
        var img = cnt.find("img").attr("src");
        var href = cnt.find("a").attr("href");
        var title = cnt.attr("title");
        var tm = cnt.attr("data-time");
        
        gitem.find("a").attr("href", href);
        gitem.find("img").attr("src", img);
        gitem.find("h3").text(title);
        gitem.find(".sliding3-time").text(tm);
        $(".sliding3-thumb").removeClass("active");
        cnt.addClass("active");
    }
    $(".sliding3 .sliding3-thumb").on("click", function(){
		alert('');
        change_slider($(this));
        return false;
    });
    
    setInterval( function() {
        var e = $(".sliding3 .sliding3-thumb.active:first");
        var $next =  e.next().length ? e.next() : $('.sliding3 .sliding3-thumb:first');
        change_slider($next);
    }, 4000);
    

});
