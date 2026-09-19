$(document).ready(function() {
    "use strict";
    
    /*var navbarCollapse = function() {
        if ($("#mainNav").offset().top > 50) {
            $("#mainNav").addClass("navbar-shrink");
        } else {
            $("#mainNav").removeClass("navbar-shrink");
        }
    };
    navbarCollapse();
    $(window).scroll(navbarCollapse);*/
    
	
    
    if ( $().selectpicker ) {
        $(".owl-carousel").owlCarousel({
            autoplay: true,
            rtl: true,
            loop: true,
            margin: 15,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                1200: {
                    items: 3,
                    nav: true
                }
            }
        });
        
    }
    
    /*if ( $().selectpicker ) {
        $('.selectpicker').selectpicker({
            size: 5,
            width: '120px',
        });
    }*/
    
    // click on map corner
	$(".map-corner").on("click", function(){
		new Audio('mapaudio.mp3').play();
		$(this).removeClass("map-corner-anime-close").addClass("map-corner-anime");
		$('.results_content').removeClass("animated fadeOutDown").addClass("animated fadeInUp").css('visibility', 'visible');
	});
	// close content and show map
	$('.close_results_content').on('click', function () {
		$(".map-corner").removeClass("map-corner-anime").addClass("map-corner-anime-close");
		$('.results_content').removeClass("animated fadeInUp").addClass("animated fadeOutDown");
	});
	$('#SearchOtherDropdown .dropdown-menu').on({
		"click":function(e){
			e.stopPropagation();
		}
	});
	$('#MapAffix').affix({
		offset: {
			top: 0,
			bottom: function () {
				return (this.bottom = $('#footer').outerHeight(true)+$('.call-center').outerHeight(true));
			}
		}
	});
	
    
	
	
	
	
	
	
});
/* global window, $, document, setInterval, clearInterval */

$(function () {
    
    
    /** Content Width **/
//    if()
//    $(".content").css("width", window.innerWidth - 128);
    

    /** Arabic Contact Animate **/
    $(".contact-ar").click(function () {
        
        if (parseInt($(".right-form-ar").css("right")) == 0) {
            
            $(".right-form-ar").animate({
                right: -$(".right-form-ar").innerWidth()
            }, 450)
            $(".contact-ar .arrow").html("<i class='fa fa-chevron-up'></i>");
            
        } else {
        
            $(".right-form-ar").animate({
                right: 0
            }, 450)
            $(".contact-ar .arrow").html("<i class='fa fa-chevron-down'></i>");
        }
    });
	
    $("#bcsearch").click(function () {
        if ($('#custom-search-input').css("display") == 'none') {
            $('#custom-search-input').show();
        } else {
			$('#custom-search-input').hide();
        }
    });
    
    
    /** Engish Contact Animate **/
    $(".contact-en").click(function () {
        
        if (parseInt($(".right-form-en").css("left")) === 0) {
            
            $(".right-form-en").animate({
                left: -$(".right-form-en").innerWidth()
            }, 450)
            $(".contact-en .arrow").html("<i class='fa fa-chevron-down'></i>");
            
        } else {
        
            $(".right-form-en").animate({
                left: 0
            }, 450)
            $(".contact-en .arrow").html("<i class='fa fa-chevron-up'></i>");
        }
    });

    /** Adjust Cover Height **/
    /*$(".cover img").height($(window).innerHeight() - 92);
    $(".cover").height($(window).innerHeight() - 92);
    
    $(window).resize(function () {
        $(".cover img").height($(window).innerHeight() - 92);
        $(".cover").height($(window).innerHeight() - 92);
    });*/
    
    
    
    
    /** How To Use Movement **/
    
    /*var sliding = $(".use img");
    var startClientX = nSliding = startPixelOffset = pixelOffset = currentSlide = 0;*/
    /*
    sliding.on("mousedown touchstart", slideStart);
    $(document).on('mouseup touchend', slideEnd);
    $(document).on('mousemove touchmove', slide);*/
    /*
    function slideStart(event) {
        if (event.originalEvent.touches)
            event = event.originalEvent.touches[0];
        
        if (nSliding == 0) {
            nSliding = 1;
            startClientX = event.clientX;
        }
      }

    function slide(event) {
        event.preventDefault();
        if (event.originalEvent.touches)
            event = event.originalEvent.touches[0];
        
        var deltaSlide = event.clientX - startClientX;
        
            
        if (nSliding == 1 && deltaSlide != 0) {
            nSliding = 2; 
            if($(".how-to-use").hasClass("use-ar")) {
                startPixelOffset = pixelOffset;
            } else {
                startPixelOffset = -pixelOffset;
            }
            
            if($(".how-to-use").hasClass("use-ar")) {
                if(deltaSlide > 0) {
                    $(".use-ar .use-move-left").hide();
                    $(".use-ar .use-move-right").show();
                } else {
                    $(".use-ar .use-move-right").hide();
                    $(".use-ar .use-move-left").show();
                }
            } else {
                if(deltaSlide < 0) {
                    $(".use-en .use-move-right").hide();
                    $(".use-en .use-move-left").show();
                } else {
                    $(".use-en .use-move-left").hide();
                    $(".use-en .use-move-right").show();
                }
            }
            
   
        }

        //  When user move image
        if (nSliding == 2) {
            var touchPixelRatio = 1;
            if($(".how-to-use").hasClass("use-ar")) {
                if (pixelOffset < 0 || pixelOffset > (sliding.width() - $(".use").width()))
                    touchPixelRatio = 4;
            } else {
                if (pixelOffset > 0 || pixelOffset < (sliding.width() - $(".use").width()))
                    touchPixelRatio = 4;
            }
            
            
            pixelOffset = startPixelOffset + deltaSlide / touchPixelRatio;
            console.log(pixelOffset);
            
            sliding.css('transform', 'translateX(' + pixelOffset + 'px').removeClass();
        }
      }

    function slideEnd(event) {
        
        
        if (nSliding == 2){
            
            nSliding = 0;
            
            if($(".how-to-use").hasClass("use-ar")) {
                currentSlide = pixelOffset > startPixelOffset ? currentSlide + 1 : currentSlide -1;
            } else {
                currentSlide = pixelOffset < startPixelOffset ? currentSlide + 1 : currentSlide -1;
            }
            
            currentSlide = Math.min(Math.max(currentSlide, 0), 1);
            pixelOffset = currentSlide *  (sliding.width() - $(".use").width() + 10);
            console.log("hhh " + currentSlide);
            $('#temp').remove();
            if($(".how-to-use").hasClass("use-ar")) {
                $('<style id="temp">.use .animate{transform:translateX(' + pixelOffset + 'px)}</style>').appendTo('head');
            } else {
                $('<style id="temp">.use .animate{transform:translateX(' + -pixelOffset + 'px)}</style>').appendTo('head');
            }
            
            sliding.addClass('animate').css('transform', '');
        }
    }
	*/

    /** Arabic Page **/
    /*$(".use-ar .use-move-left").click(function () {
        sliding.addClass("animate").css("transform", "translateX(" + (sliding.width() - $(".use").width() + 10) + "px)");
        pixelOffset = (sliding.width() - $(".use").width() + 10);
        $(".use-ar .use-move-left").hide();
        $(".use-ar .use-move-right").show();
    })
    
    $(".use-ar .use-move-right").click(function () {
        sliding.addClass("animate").css("transform", "translateX(0px)");
        pixelOffset = 0;
        $(".use-ar .use-move-right").hide();
        $(".use-ar .use-move-left").show();
    })
*/    
    
    /** English Page **/
   /* $(".use-en .use-move-left").click(function () {
        sliding.addClass("animate").css("transform", "translateX(0px)");
        pixelOffset = 0;
        $(".use-en .use-move-left").hide();
        $(".use-en .use-move-right").show();
    })
    
    $(".use-en .use-move-right").click(function () {
        sliding.addClass("animate").css("transform", "translateX("+ - (sliding.width() - $(".use").width() + 10) + "px)");
        pixelOffset =  (sliding.width() - $(".use").width() + 10);
        $(".use-en .use-move-right").hide();
        $(".use-en .use-move-left").show();
    })
    */
    
    $(".use-ar .owl-carousel").owlCarousel({
        rtl: true,
        smartSpeed: 600,
		singleItem:true,
		autoWidth: true,
		responsiveClass: true,
        nav: true,
		lazyLoad:true,
		navText : ['<i class="fa fa-chevron-right"></i>','<i class="fa fa-chevron-left"></i>'],
		responsive:{
			0:{
				items:2
		}}
    })
	//$('.use .owl-nav').removeClass('disabled');

	/*$(".use-ar .owl-next").html("<i class='fa fa-chevron-left'></i>");
    $(".use-ar .owl-prev").html("<i class='fa fa-chevron-right'></i>");	*/
	
    $(".use-en .owl-carousel").owlCarousel({
        rtl: false,
        nav: true,
        smartSpeed: 600,
		singleItem:true,
		autoWidth: true,
		navText : ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],

		responsiveClass: true,
    })

	/*
	$(".use-en .owl-next").html("<i class='fa fa-chevron-left'></i>");
    $(".use-en .owl-prev").html("<i class='fa fa-chevron-right'></i>");
	*/




    /** project slider **/
    $(".projects-ar .owl-carousel").owlCarousel({
        autoWidth: true,
        rtl: true,
        nav: true,
        smartSpeed: 600
    })
    
    $(".projects-en .owl-carousel").owlCarousel({
        autoWidth: true,
        nav: true,
        smartSpeed: 600
    })
	
	$('.project-build .drop-menu a').click(function(){
		//alert($(this).data('index'));
		//$('#content').load(href + ' #IDofDivToFind');
		
		$(this).parent('li').parent('ul').parent('div').parent('div').children('i').attr('class','iconhproj flaticon-'+$(this).data('icon'));
		$(this).parent('li').parent('ul').parent('div').parent('div').children('h3').text($(this).text());
		var container =$(this).parent('li').parent('ul').parent('div').parent('div').parent('div').parent('div').children('div.project-build-slider');
		
		container.html('<div id="testing" class="owl-carousel centermdl"><i class="fa fa-circle-o-notch fa-spin" style="color:#1f3a73;font-size:47px"></i></div>');

		container.children('#testing').load($(this).data('slug'), function() {
		container.children('#testing').removeClass('centermdl');
		//$(".projects-ar .owl-carousel").owlCarousel('refresh');
		//$(".projects-en .owl-carousel").owlCarousel('refresh');
		//alert( "Load was performed." );
		
		/*
		$("#testing").owlCarousel({
        autoWidth: true,
        rtl: true,
        nav: true,
        smartSpeed: 600
    })*/

		$(".projects-ar #testing").owlCarousel({
        autoWidth: true,
        rtl: true,
        nav: true,
        smartSpeed: 600
    })
    
    $(".projects-en #testing").owlCarousel({
        autoWidth: true,
        nav: true,
        smartSpeed: 600
    })
	$(".projects-ar .owl-next").html("<i class='fa fa-chevron-left'></i>");
    $(".projects-ar .owl-prev").html("<i class='fa fa-chevron-right'></i>");
   $(".projects .owl-dots").hide();
    
    $(".projects-en .owl-next").html("<i class='fa fa-chevron-right'></i>");
    $(".projects-en .owl-prev").html("<i class='fa fa-chevron-left'></i>");

		
		});

	})
	
	
    
    //Add Arrows To Slider Projects
    $(".projects-ar .owl-next").html("<i class='fa fa-chevron-left'></i>");
    $(".projects-ar .owl-prev").html("<i class='fa fa-chevron-right'></i>");
   $(".projects .owl-dots").hide();
    
    $(".projects-en .owl-next").html("<i class='fa fa-chevron-right'></i>");
    $(".projects-en .owl-prev").html("<i class='fa fa-chevron-left'></i>");

    
    
	
	
	
	
    // Silder Clients Certifacte Full Settings
    var inElement2 = $(".certificate-desktop .post .slider .items").length;
    var isliderWatched1 = $(".certificate-desktop .post .slider");
    var iclientHW1 = $(".certificate-desktop .post .slider .items").height() + 15;
    var inn = 0;
    
    $(".certificate-desktop .nav .down").addClass("disabled");
    
    $(".certificate-desktop .nav .up").click(function () {
        $(".certificate-desktop .nav .down").removeClass("disabled");
        if((inElement2 - inn - 1) >= 3) {
            inn++;
            isliderWatched1.animate({
                top: - iclientHW1 * inn
            }, 450);
            if((inElement2 - inn - 1) < 3) {
                $(".certificate-desktop .nav .up").addClass("disabled");
            }
        }
        
    });
    
    $(".certificate-desktop .nav .down").click(function () {
        
        $(".certificate-desktop .nav .up").removeClass("disabled");
        
        if(inn > 0) {
            inn--;
            isliderWatched1.animate({
                top: - iclientHW1 * inn
            }, 450);
            if(inn <= 0) {
                $(".certificate-desktop .nav .down").addClass("disabled");
            }
        }
        
    });
    /*var nElement1 = $(".certificate-desktop .post .slider .items").length;
    var slider = $(".certificate-desktop .post .slider");
    var postH = $(".certificate-desktop .post").height();
    var sliderH = slider.height();
    var clientH = $(".certificate-desktop .post .slider .items").height() + 15;
    var n = 0;
    
    $(".certificate-desktop .nav .down").addClass("disabled");
    
    $(".certificate-desktop .nav .up").click(function () {
        
        $(".certificate-desktop .nav .down").removeClass("disabled");
        if((nElement1 - n - 1) >= 3) {
            n++;
            slider.animate({
                top: -clientH*n
            }, 450);
            if((nElement1 - n - 1) < 3) {
                $(".certificate-desktop .nav .up").addClass("disabled");
            }
        }
        
    });
    
    $(".certificate-desktop .nav .down").click(function () {
        
        $(".certificate-desktop .nav .up").removeClass("disabled");
        
        if(n > 0) {
            n--;
            slider.animate({
                top: -clientH * n
            }, 450);
            if(n <= 0) {
                $(".certificate-desktop .nav .down").addClass("disabled");
            }
        }
        
    });*/
    
    // Silder Clients Certifacte Mobile Settings 
    var nElement1 = $(".certificate-mobile .post .slider .items").length;
    var slider2 = $(".certificate-mobile .post .slider");
    var postH = $(".certificate-mobile .post").height();
    var sliderH = slider2.height();
    var clientH = $(".certificate .post .slider .items").height() + 15;
    var ns = 0;
    
    $(".certificate-mobile .nav .down").addClass("disabled");
    
    $(".certificate-mobile .nav .up").click(function () {
        
        $(".certificate-mobile .nav .down").removeClass("disabled");
        if((nElement1 - ns - 1) >= 3) {
            ns++;
            slider2.animate({
                top: -clientH*ns
            }, 450);
            if((nElement1 - ns - 1) < 3) {
                $(".certificate-mobile .nav .up").addClass("disabled");
            }
        }
        
    });
    
    $(".certificate-mobile .nav .down").click(function () {
        
        $(".certificate-mobile .nav .up").removeClass("disabled");
        
        if(ns > 0) {
            ns--;
            slider2.animate({
                top: -clientH * ns
            }, 450);
            if(ns <= 0) {
                $(".certificate-mobile .nav .down").addClass("disabled");
            }
        }
        
    });
    
    
    // Most Watched desktop
    var nElement2 = $(".most-watched-desktop .post .slider .items").length;
    var sliderWatched1 = $(".most-watched-desktop .post .slider");
    var clientHW1 = $(".most-watched-desktop .post .slider .items").height() + 15;
    var nn = 0;
    
    $(".most-watched-desktop .nav .down").addClass("disabled");
    
    $(".most-watched-desktop .nav .up").click(function () {
        $(".most-watched-desktop .nav .down").removeClass("disabled");
        if((nElement2 - nn - 1) >= 3) {
            nn++;
            sliderWatched1.animate({
                top: - clientHW1 * nn
            }, 450);
            if((nElement2 - nn - 1) < 3) {
                $(".most-watched-desktop .nav .up").addClass("disabled");
            }
        }
        
    });
    
    $(".most-watched-desktop .nav .down").click(function () {
        
        $(".most-watched-desktop .nav .up").removeClass("disabled");
        
        if(nn > 0) {
            nn--;
            sliderWatched1.animate({
                top: - clientHW1 * nn
            }, 450);
            if(nn <= 0) {
                $(".most-watched-desktop .nav .down").addClass("disabled");
            }
        }
        
    });

    // Most Watched Mobile
    var nElement3 = $(".most-watched-mobile .post .slider .items").length;
    var sliderWatched2 = $(".most-watched-mobile .post .slider");
    var clientHW2 = $(".most-watched-mobile .post .slider .items").height() + 15;
    var nm = 0;
    
    $(".most-watched-mobile .nav .down").addClass("disabled");
    
    $(".most-watched-mobile .nav .up").click(function () {
        $(".most-watched-mobile .nav .down").removeClass("disabled");
        if((nElement3 - nm - 1) >= 3) {
            nm++;
            sliderWatched2.animate({
                top: - clientHW2 * nm
            }, 450);
            if((nElement3 - nm - 1) < 3) {
                $(".most-watched-mobile .nav .up").addClass("disabled");
            }
        }
        
    });
    
    $(".most-watched-mobile .nav .down").click(function () {
        
        $(".most-watched-mobile .nav .up").removeClass("disabled");
        
        if(nm > 0) {
            nm--;
            sliderWatched2.animate({
                top: - clientHW2 * nm
            }, 450);
            if(nm <= 0) {
                $(".most-watched-mobile .nav .down").addClass("disabled");
            }
        }
        
    });
    
    
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    // News Slider Settings mobile
    $(".news .news-slider").owlCarousel({
		items:1,
        rtl: true,
        nav: true,
        loop: true,
		margin:15,
        mouseDrag: false,
        touchDrag: false,
        smartSpeed: 800
    })
	}else{
    $(".news .news-slider").owlCarousel({
        items: 1,
        rtl: true,
        nav: true,
        loop: true,
		margin:10,
        mouseDrag: false,
        touchDrag: false,
        smartSpeed: 800
    })
	}
	
    $(".news .news-slider .owl-next").html("<i class='fa fa-chevron-left'></i>");
    $(".news .news-slider .owl-prev").html("<i class='fa fa-chevron-right'></i>");
    
    
    
        $(".news-ar .sub").owlCarousel({
            autoWidth: true,
            rtl: true,
            nav: false
        }) 
        $(".news-ar .subnews1 .owl-dots").hide();
		
		//full browser
        $(".langpostar .owl-item .post2 .sub").owlCarousel({
            autoWidth: true,
            rtl: true,
            nav: true,
			
		navText : ['<i class="fa fa-chevron-right"></i>','<i class="fa fa-chevron-left"></i>'],
        }) 
        $(".langposten .owl-item .post2 .sub").owlCarousel({
            autoWidth: true,
            rtl: false,
            nav: true,
			
		navText : ['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
        }) 
        $(".owl-item .post2 .sub .owl-dots").hide();


    // Sub News Post1 Slider Settings
    if($(window).width() <= 800) {
		$(".new-videos .sub-video").owlCarousel({
            autoWidth: true,
            rtl: true,
            nav: false,
            margin: 3,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: true
                },
                1200: {
                    items: 3,
                    nav: true
                }
            }
        })
        $(".sub-video .owl-dots").hide();
        $(".sub-video .owl-nav").hide();

    } 
    
    $(window).resize(function () {
		//alert('window resize');
        $(".news-ar .sub").owlCarousel({
                autoWidth: true,
                rtl: true,
                nav: false
        })
        $(".news-ar .subnews1 .owl-dots").hide();
        
        /*if($(window).width() > 800) {
            $(".news-ar .sub").owlCarousel("destroy");
        }*/
            
    })
    
    /***********/
    if($(window).width() <= 800) {
        $(".news-en .sub").owlCarousel({
            autoWidth: true,
            rtl: false,
            nav: false
        }) 
        $(".news-en .subnews1 .owl-dots").hide();
    } 
    
    $(window).resize(function () {
        $(".news-en .sub").owlCarousel({
                autoWidth: true,
                rtl: false,
                nav: false
        })
        $(".news-en .subnews1 .owl-dots").hide();
        
        /*if($(window).width() > 800) {
            $(".news-en .sub").owlCarousel("destroy");
        }*/
            
    })
    

    
    
    // Sub Videos Slider Settings
    if($(window).width() <= 900) {
        $(".new-videos .sub-video-ar").owlCarousel({
            autoWidth: true,
            rtl: true,
            nav: false
        }) 
        $(".new-videos .sub-video-ar .owl-dots").hide();
    } 
    
    $(window).resize(function () {
        $(".new-videos .sub-video-ar").owlCarousel({
                autoWidth: true,
                rtl: true,
                nav: false
        })
        $(".new-videos .sub-video-ar .owl-dots").hide();
        
        if($(window).width() > 900) {
            $(".new-videos .sub-video-ar").owlCarousel("destroy");
        }
            
    })
    
    
    if($(window).width() <= 900) {
        $(".new-videos .sub-video-en").owlCarousel({
            autoWidth: true,
            rtl: false,
            nav: false
        }) 
        $(".new-videos .sub-video-en .owl-dots").hide();
    } 
    
    $(window).resize(function () {
        $(".new-videos .sub-video-en").owlCarousel({
                autoWidth: true,
                rtl: false,
                nav: false
        })
        $(".new-videos .sub-video-en .owl-dots").hide();
        
        if($(window).width() > 900) {
            $(".new-videos .sub-video-en").owlCarousel("destroy");
        }
            
    })
    

    
    //Adjust Arrows Of News
    
    
    
    // Sub Vidoes Slider Settings
  
   
    
    
});