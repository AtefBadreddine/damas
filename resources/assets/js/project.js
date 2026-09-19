/*global $, alert, console, prompt*/
$(document).ready(function () {
    'use strict';
    
    $(".sliding1 .owl-carousel").owlCarousel({
        autoplay: false,
        rtl: true,
        margin: 0,
        loop: true,
        autoplaySpeed: 2500,
        navSpeed: 1000,
        responsiveClass: true,
		lazyLoad: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                mergeFit: true
            },
            1200: {
                items: 5,
                nav: true
            }
        }

    });

    $(".sliding2 .owl-carousel").owlCarousel({
        autoplay: false,
        rtl: true,
        margin: 0,
        loop: true,
        autoplaySpeed: 2500,
        navSpeed: 1000,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            1200: {
                items: 1,
                nav: true
            }
        }

    });
    
    // project page
    // input focus
    $(".form-section .form-control").focusin(function () {
        $(this).siblings("label").addClass("label-focus");
    });
    $(".form-section .form-control").blur(function () {
        $(this).siblings("label").removeClass("label-focus");
    });
/*
    var form_offset = ($(".form-section .form1").offset().top - 50);
	var direct = $("html").attr("dir");
    $(window).on("scroll", function () {
        if ($(window).width() > 767) {
            if ($(window).scrollTop() >= form_offset) {
                $(".form-section .form1").css({
                    position: "fixed",
                    top: "60px",
                    width: "360px",
                    margin: "auto",
                    boxShadow: "0 0 10px 1px rgba(50, 50, 50, .4)"
                });
				if ( direct == "ltr" ) {
					$(".form-section .form1").css({
						left: "auto",
						right: "70px",
					});
				}
                $(".form-section .form1 input[type='submit']").siblings().slideUp(2000);
                $(".merits").css("width"," 150%");
                
            }
            if ($(window).scrollTop() <= form_offset) {
                $(".form-section .form1").css({
                    position: "relative",
                    top: "-30px",
                    width: "100%",
                    margin: "auto",
                    left: "auto",

                });
				if ( direct == "ltr" ) {
					$(".form-section .form1").css({
						right: "0",
					});
				}
                $(".merits").css("width"," 100% ");
                $(".form-section .form1 input[type='submit']").siblings().slideDown(2000);
                
            }
        }
    });*/
    
    $(".form-section .form1 input[type='submit']").click(function () {
        $(this).siblings().slideDown(700);
    });
    
    // plan slider
    $("#slidingPlan .owl-carousel").owlCarousel({
        autoplay: true,
        rtl: true,
        loop: true,
        margin: 15,
        responsiveClass: true,
		lazyLoad: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            }/*,
            1200: {
                items: 3,
                nav: true
            }*/
        }
    });
    $("#slidingPlan .owl-nav .owl-prev").text("").addClass("fa fa-chevron-right");
    $("#slidingPlan .owl-nav .owl-next").text("").addClass("fa fa-chevron-left");
    
    // show modal sliding
    /*$(document).on("click", ".sliding1 a[href^='#modal']", function(){
        var mdl = $(this).attr("data-modalid");
        var img = $(this).find('img').attr("data-src");
        $("div[data-remodal-id="+mdl+"] img:first").attr("src", img);
    });*/
    
});
