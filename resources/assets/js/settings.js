//document.oncontextmenu =new Function("return false;");

$(window).ready(function() {
 
    
    
   /* $('.active').owlCarousel({
        items: '2',
        nav: true,
        loop: true,
        rtl: true,
        navSpeed: 800,
    transitionStyle : 'fade',
    responsiveRefreshRate : 25,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 1
            },
            1100: {
                items: 2
            }
        }
    });

    
    
    
    
    $( ".owl-prev").html('<i class="fa fa-chevron-left"></i>');
    $( ".owl-next").html('<i class="fa fa-chevron-right"></i>');
    $(".owl-dots").css("display", "none");*/
    

    /*
   var $imgLast = $(".click .last img").attr("src");
   var $imgFirst = $(".click .first img").attr("src");
    
    $(".active .owl-item").click(function() {
        
        
        $('.click').owlCarousel({
            items: 1,
            nav: true,
            loop: true,
        });
        
        
        
        
        $(".carousel-onclick").css("display", "block");
        $( ".owl-prev").html('<i class="fa fa-chevron-left"></i>');
        $( ".owl-next").html('<i class="fa fa-chevron-right"></i>');
        $(".owl-dots").css("display", "none");
    })
    
    $(".exit").click(function() {
        $('.click').owlCarousel("destroy");
        $(".carousel-onclick").css("display", "none");
    })
    */
    
});



var maxdeg = 45;

var showmenu = false;
function rotate() {
    var deg = 0;
    showmenu = true;
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var line3 = document.getElementById("line3");
    var carousel = document.getElementById("carousel");
//    carousel.style.display = "none";
    line1.style.transformOrigin = "top left";
    line3.style.transformOrigin = "bottom left";
    if(document.documentElement.clientWidth <= 420) {
        maxdeg = 42;
    }
    var timer = setInterval(function() {
        line1.style.transform = "rotate("+deg+"deg)";
        line3.style.transform = "rotate("+-deg+"deg)";
        
        if(deg >= maxdeg) {
            line2.style.backgroundColor = "transparent";
            clearInterval(timer);
            
        }
        deg++;
    }, 5)
}



function rotateInverse() {
    if(document.documentElement.clientWidth <= 420) {
        maxdeg = 42;
    }
    var deg = maxdeg;
    showmenu = false;
    var line1 = document.getElementById("line1");
    var line2 = document.getElementById("line2");
    var line3 = document.getElementById("line3");
    var carousel = document.getElementById("carousel");
//    carousel.style.display = "block";
    line1.style.transformOrigin = "top left";
    line3.style.transformOrigin = "bottom left";
    
    line2.style.backgroundColor = "#fff";
    var timer = setInterval(function() {
        line1.style.transform = "rotate("+deg+"deg)";
        line3.style.transform = "rotate("+-deg+"deg)";
        if(deg <= 0) {
            line2.style.backgroundColor = "#fff";
            
            clearInterval(timer);
        }
        deg--;
    }, 5);
}

var showMenu = document.getElementById("show-menu");
showMenu.onclick = function() {
    
    var menu = document.getElementById("drop-menu");
    if(menu.style.display != "block" ) {
        rotate();
        menu.style.display = "block";
		$("body").css("overflow", "hidden");
    } else {
        rotateInverse();
        menu.style.display = "none";
		$("body").css("overflow", "visible");
    }
    
}



window.onresize = function () {
    var menu = document.getElementById("drop-menu");

    if(document.documentElement.clientWidth> 980) {
        menu.style.display = "none";  
    }
    if(showmenu  && document.documentElement.clientWidth <= 980) {
        menu.style.display = "block"; 
    }
    
}


// Initialize and add the map
/*function initMap() {
            var uluru = {
                lat: 41.066416666667, lng: 28.707555555556 }; var map = new google.maps.Map(document.getElementById('map'), { zoom: 8, center: uluru, gestureHandling: 'cooperative' }); var image = { url: 'images/marker.png', origin: new google.maps.Point(-18, -4), size: new google.maps.Size(70, 84), }; var marker = new google.maps.Marker({ position: uluru, map: map, icon: image, label: { text: "103",
                    color: "#162b75",
                    fontSize: "12px",
                    fontWeight: "bold",
                },
            });
        }*/




/*** Custom Select ***/
/*
$('.dev').each(function(){
                var $this = $(this), numberOfOptions = $(this).children('option').length;

                $this.addClass('select-hidden'); 
                $this.wrap('<div class="select"></div>');
                $this.after('<div class="select-styled"></div>');

                var $styledSelect = $this.next('div.select-styled');
                $styledSelect.text($this.children('option').eq(0).text());

                var $list = $('<ul />', {
                    'class': 'select-options'
                }).insertAfter($styledSelect);

                for (var i = 0; i < numberOfOptions; i++) {
                    $('<li />', {
                        text: $this.children('option').eq(i).text(),
                        rel: $this.children('option').eq(i).val()
                    }).appendTo($list);
                }

                var $listItems = $list.children('li');

                $styledSelect.click(function(e) {
                    e.stopPropagation();
                    $('div.select-styled.active').not(this).each(function(){
                        $(this).removeClass('active').next('ul.select-options').hide();
                    });
                    $(this).toggleClass('active').next('ul.select-options').toggle();
                });

                $listItems.click(function(e) {
                    e.stopPropagation();
                    $styledSelect.text($(this).text()).removeClass('active');
                    $this.val($(this).attr('rel'));
                    $list.hide();
                    //console.log($this.val());
                });

                $(document).click(function() {
                    $styledSelect.removeClass('active');
                    $list.hide();
                });

            });

*/











