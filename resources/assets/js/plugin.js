/*global $, alert, console, prompt*/
$(document).ready(function(){
    'use strict';
    
    // wow
    //new WOW({mobile: false}).init();
	
	$(".navbar-default .navbar-toggle").on("click", function(){
        $(this).children(".num1").toggleClass("rotate-right");
        $(this).children(".num2").toggleClass("hidden-visibility");
        $(this).children(".num3").toggleClass("rotate-left");
    });
    
	
	
	
	var isMobile = 0;
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		isMobile = 1;	
	}
    // floating call us form
	if( !isMobile ) {
    //nicescroll plugin
    /*$("html, .floating-message").niceScroll({
        cursorborder: 'none',
        cursorcolor: "#167ac6",
        scrollspeed: '80',
        cursorwidth: '12px',
        zindex: '999999999',
        horizrailenabled: false
    });*/
    }
    // disable context menu & select & copy
    $("body").on("contextmenu",function(e){
        if ( $(e.target).hasClass("bluring") ) return true;
        return false;
    });
    $('body').bind('cut copy paste select', function (e) {
		if ( $(e.target).hasClass("bluring") ) return true;
		e.preventDefault();
	});
    $("body").css("user-select", "none");
    jQuery(document).bind("keyup keydown", function(e){
        if(e.ctrlKey && e.keyCode == 80){
            return false;
        }
    });
	/*
	var isMobile = 0;
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		isMobile = 1;	
	}
	
    // floating call us form
	if( !isMobile ) {
		window.setTimeout(function () {
			$(".floating-message").fadeIn(1000);
		}, 60000);		
	}
	
    $(".floating-message .close-it").on("click", function(){       
        $(".floating-message").fadeOut(1000);
		
		if( !isMobile ) {
			window.setTimeout(function () {
				$(".floating-message").fadeIn(1000);
			}, 120000);	
		}
    });
    $(".floating-message").click(function(e) {
        var container = $(".bluring");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".floating-message").fadeOut(1000);
        }
		if( !isMobile ) {
			window.setTimeout(function () {
				$(".floating-message").fadeIn(1000);
			}, 120000);
		}
    });
	$(document).on("click", ".btn-floating-message", function(){
		$(".floating-message").fadeIn(1000);
		return false;
	});*/
    
    // navbar
    $('#cssmenu').prepend('<div id="menu-button">Menu</div>');
    $('#cssmenu #menu-button').on('click', function(){
        var menu = $(this).next('ul');
        if (menu.hasClass('open')) {
            menu.removeClass('open');
        }
        else {
            menu.addClass('open');
        }
    });
    
    //top-button
    var top = $(".top-icon");
    $(window).scroll(function () {
        if (($(this).scrollTop()) >= 50) {
            top.fadeIn(1000);
        } else {
            top.fadeOut(1000);
        }
    });
    top.click(function () {
        $("html,body").animate({
            scrollTop: 0
        }, 1000);
    });
    
    // message icon click
    $(".message-icon .fa-envelope , .about .more").on("click", function () {
        $("html,body").animate({
            scrollTop: ($(".call-center").offset().top - 60)
        }, 1000);
    });
    
    // nav carousel
    $(".owl-carousel .owl-nav .owl-prev").text("").addClass("fa fa-angle-left");
    $(".owl-carousel .owl-nav .owl-next").text("").addClass("fa fa-angle-right");
    $(".owl-carousel .owl-prev").css({
        position: 'absolute',
        left: 0
    });
    $(".owl-carousel .owl-next").css({
        position: 'absolute',
        right: 0
    });
        
});

$(document).ready(function () {
    
    // map search
    $(".map-corner").on("click", function () {
        new Audio('mapaudio.mp3').play();
        $(this).removeClass("map-corner-anime-close").addClass("map-corner-anime");
        $('.results_content').removeClass("animated fadeOutDown").addClass("animated fadeInUp").css('visibility', 'visible');
    });
    $('.close_results_content').on('click', function () {
        $(".map-corner").removeClass("map-corner-anime").addClass("map-corner-anime-close");
        $('.results_content').removeClass("animated fadeInUp").addClass("animated fadeOutDown");
    });

});
