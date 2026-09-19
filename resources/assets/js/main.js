$(document).ready(function () {
    $("#form-callus, #form-callus-lg, #form-callus-floating, #form-callus-landing, #form-callus-chat").on("submit", function(e){
        e.preventDefault();
        var form = $(this);
        var btn = form.find("button[type=submit]");
		var btn2= form.find("input[type=submit]");
        var act = form.attr("action");
        var infos = form.serialize();
        //btn.find(".fa").removeClass("fa-send").addClass("fa-spinner fa-spin");
        btn.html("<i class='fa fa-spinner fa-spin'></i>");
        btn.attr("disabled", true);
        btn2.attr("disabled", true);
        $.post(act, infos, function(resp){
            form.find(".has-form-error").remove();
            if ( resp.input ) {
                form.find('*[name='+resp.input+']').removeClass("animated flash").addClass("animated flash").focus();
                form.find('*[name='+resp.input+']').after("<small class='has-form-error error-"+resp.input+" text-danger'>"+resp.message+"</small>");
            } else {
                if ( resp.url ) {
                    location.replace(resp.url);
                } else if ( resp.html ) {
                    form.closest("#callus_content").html(resp.html);
					liveChat();
                } else {
                    alert(resp.message);
                }
				form.find(".form-control").val("");
            }
            //btn.find(".fa").removeClass("fa-spinner fa-spin").addClass("fa-send");
			btn.html('<img src="http://damas.net/public/img/send.png" class="img-responsive" alt="Send">');
            btn.removeAttr("disabled");
            btn2.removeAttr("disabled");
        });
        return false;
    });
	/*Chat*/
	$("#form-chat").on("submit", function(e){
        e.preventDefault();
        var form = $(this);
        var btn = form.find("button[type=submit]");
        var act = form.attr("action");
        var infos = form.serialize();
        btn.attr("disabled", true);
        $.post(act, infos, function(resp){
            form.closest("#callus_content").html(resp.html)
            btn.removeAttr("disabled");
        });
        return false;
    });
    /*newsletter*/
    $("#form-newsletter").on("submit", function(e){
        e.preventDefault();
        var form = $(this);
        var btn = form.find("button[type=submit]");
        var act = form.attr("action");
        var infos = form.serialize();
        btn.attr("disabled", true);
        $.post(act, infos, function(resp){
            console.log(resp);
            if ( resp.input ) {
                form.find('input[name='+resp.input+']').addClass("animated flash").attr("placeholder", resp.message).focus();
            } else {
                alert(resp.message);
				form.find(".form-control").val("");
            }
            btn.removeAttr("disabled");
        });
        return false;
    });
    /* input tel flag */
    $("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").intlTelInput({
        preferredCountries: ["undif","sa","tr","qa","sy","iq","kw","bh","ae","ye","jo","dz","ly","eg","sd","om"]
    });
	$("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").on("change", function(){
		var $this = $(this);
		var frm = $this.closest("form");
		var country = frm.find(".country-list .country.active .country-name").text();
		var input_country = frm.find("input[name=country]");
		if ( input_country.length > 0 ) {
			input_country.val(country);
		} else {
			frm.append("<input name='country' type='hidden' value='"+country+"' />");
		}
	});
	
    $(".intl-tel-input").addClass("bluring");
    /* share buttons */
    var options = {
        twitter: {
            text: $(document).find("title").text(),
            via: 'damasturk'
        },
        facebook : true,
        googlePlus : true
    };
    $('.socialShare').shareButtons(options);
    
    /* like project */
    $(".likeCardItem").on("click", function(e){
		e.preventDefault();
        var $this = $(this);
        var url = $this.attr("data-url");
        var id = $this.attr("data-code");
        var typ = $this.attr("data-typ");
        var csrf = $('input[name=_token]').val();
		if ( $this.children().length > 0 ) {
			//$this.find("i").removeClass("fa-heart-o").addClass("fa-heart");
			$this.children('i').addClass("ifffcolor");
		} else {
			//$this.removeClass("fa-heart-o").addClass("fa-heart");
			$this.children('i').addClass("ifffcolor");
		}
        $.ajax({
            type: "POST",
            url: url,
            data: {
                _token: csrf,
                id: id,
                typ: typ,
            }
        }).done(function(resp){
            /*$this.find("i").removeClass("fa-heart-o").addClass("fa-heart");*/
        });
        return false;
    });
    /*Share buttons*/
    $('.shareBtnsFloating a.btnshare').click(function(e) {
        e.preventDefault();
        var data_url = $(this).closest(".social").attr("data-url");
        var data_title = $(this).closest(".social").attr("data-text");
        if ( !data_url ) {
            data_url = window.location.href;
        }
        if ( !data_title ) {
            data_title = document.title;
        }
        var url = encodeURIComponent(data_url),
            title = encodeURIComponent(data_title),
            w = 500,
            h = 400,
            typ = $(this).attr("data-network"),
            left = (screen.width / 2) - (w / 2),
            top = (screen.height / 2) - (h / 2);
        
        var share_url = "";
        if ( typ == 'facebook' ) {
            share_url = 'https://facebook.com/sharer.php?u=' + url;
        } else if ( typ == 'twitter' ) {
            share_url = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title + '&via=damasturk';
        } else if ( typ == 'googleplus' ) {
            share_url = 'https://plus.google.com/share?url=' + url;
        } else if ( typ == 'linkedin' ) {
            share_url = 'https://www.linkedin.com/shareArticle?mini=true&url='+url+'&title='+title+'&source=damas.net';
        } else if ( typ == 'whatsapp' ) {
            share_url = 'https://api.whatsapp.com/send?text='+title+' '+url;
        }
		
        window.open(share_url, 'Social Share', 'toolbar=no, location=no, directories=no, status=no,' +
            ' menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
    });
    
    $("body").on("click",'.cshare', function(e){
		
        e.preventDefault();
        $(this).closest(".share").find(".social").fadeToggle(500);
        return false;
    });
	
	/*Show_Hide_Sharebar*/
	var loadshare = 0;
	$(".sharecollect").on("click", function(){
		show_sharefloating();
	});
	$(window).scroll(function () {
		clearTimeout($.data(this, 'scrollTimer'));
		if ( loadshare == 1 ) {
			show_sharefloating();
		} 
		$.data(this, 'scrollTimer', setTimeout(function() {
			hide_sharefloating(); loadshare = 1; 
		}, 1000));
	});
	function show_sharefloating() {
		var dv = $(".sharefloating"); /*old value:sharefloating*/
		dv.find(".btn").fadeIn();
		dv.find(".sharecollect").hide();
		/*Mobile*/
		$(".share-icon, .message-icon-mobile, .sharefloatingMobile").fadeOut();
		$(".top-icon-mobile").css('top', 75).fadeIn();
	}
	function hide_sharefloating() {
		var dv = $(".sharefloating"); /*old value:sharefloating*/
		/*dv.find(".btn").hide();*/
		dv.find(".sharecollect").fadeIn();
		/*Mobile*/
		$(".share-icon, .message-icon-mobile").fadeIn();
		$(".top-icon-mobile").hide();
		/*$(".top-icon-mobile.searchpage-icon-mobile").css('bottom', 60);*/
	}
	$(".share-icon").on("click", function(){
		$(".sharefloatingMobile").fadeToggle();
	});
    
    /**/
    $(".sectionblank a").attr("target", "_blank");
	
	/*prevent Click submenu*/
	$("#mainNav li > a").on("click", function(){
		var lk = $(this).attr("href");
		if ( lk == '#' ) {
			return false
		}
	});
	
	if ( $().unveil ) {
		$(document).ready(function() {
			$(".lazyimg").unveil(200);
		});		
	}
	
	/*Chat*/
	function liveChat() {
        var frm = $("#form-chat-replay");
        $.ajax({
            url: frm.attr("action"),
            data: {_token: $("input[name=_token]").val()},
            success:function(resp){
                $("#callus_content").html(resp.html);
                $('.msg_container_base').scrollTop($('.msg_container_base')[0].scrollHeight);
                $(".panel-footer").removeClass('hidden');
                frm.attr("action", resp.url_action);
                setTimeout(liveChat, 5000);
            },
            error:function(){
                setTimeout(liveChat, 10000);
            }
        });
    }
    $(document).on('click', '.icon_minim', function (e) {
        var $this = $(this);
        if (!$this.hasClass('panel-collapsed')) {
            $this.parents('.panel').find('.panel-body').slideUp();
            $this.addClass('panel-collapsed');
        } else {
            $this.parents('.panel').find('.panel-body').slideDown();
            $this.removeClass('panel-collapsed');
        }
    });
	$(document).on('submit', '#form-chat-replay', function (e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find("button[type=submit]");
        var act = form.attr("action");
        var infos = form.serialize();
        btn.attr("disabled", true);
        $.post(act, infos, function(resp){
            btn.removeAttr("disabled");
            form.find(".form-control").val("");
            liveChat();
        });
        return false;
    });
    
    /*NoFollowExternalLinks
    $("a[href^='http']:not([href*='damas.net'])").attr("rel", "nofollow");
    */
    /*Notifications*/
	/*
    if ("Notification" in window) {
       var permission = Notification.permission;

       if (permission === "denied") {
           return;
       } else if (permission === "granted") {
		   console.log('permission === "granted"');
           return checkRssFeed();
       }

       Notification.requestPermission().then(function() {
           checkRssFeed();
       });
    }
    function checkRssFeed() {
       var latest_item_rss = localStorage.getItem("latestItemRss");
       var feed = "https://www.damas.net/rss";
       $.ajax(feed, {
           accepts:{
               xml:"application/rss+xml"
           },
           dataType:"xml",
           success:function(data) {
			   console.log('ajax checkRssFeed success');
               var el = $(data).find("item").first();
               var title = el.find("title").text();
               var link = el.find("link").text();
               var description = el.find("description").text();
               var img = "https://www.damas.net/public/img/favicon.png";

               if ( latest_item_rss != link ) {
				   displayNotification(description, img, title, link);
                   localStorage.setItem("latestItemRss", link);
               }
           }
       });
    }
    function displayNotification(body, icon, title, link) {
        link = link || 0;
        var duration =  10000;
        var options = {
            body: body,
            icon: icon
        };
        var n = new Notification(title, options);
        if (link) {
            n.onclick = function () {window.open(link);};
        }
        setTimeout(n.close.bind(n), duration);
   }
	*/
	/*$(".linkElem").on("click", function(e){
		e.preventDefault();
		var lk = $(this).attr("data-link");
		console.log("lk");
		if ( lk ) {
			location.replace(lk);
		}
		return false;
	});*/
	
	$(".country-list .country").on("click", function(){
		var mbl = $(this).closest("form").find("input[name=mobile]").trigger("change");
	});

	
	
    
});
	
$("#ashowme").on("click", function(e) {
	if (!$(e.target).is('.wtsp')) {
	$("#ashowme").slideDown();
	$("#ashowme").hide();
	$(".callusslide").animate({
			right: 0
		},
		1000);
	}
});
$("#ahideme").on("click", function(e) {
	$(".callusslide").animate({
			right: -370
		},
		1000,function(){
			
	$("#ashowme").slideUp();
	$("#ashowme").show()
		});
});