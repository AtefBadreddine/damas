<?php $current_locale = LaravelLocalization::getCurrentLocale(); ?>
<!DOCTYPE html>
<html amp lang="<?= $current_locale; ?>" dir="<?= $current_locale == "ar" ? "rtl" : "ltr"; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
        <script async src="https://cdn.ampproject.org/v0.js"></script>
        <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>

        <?php $infos = Helper::get_params(); ?>
        <title><?= $og_title = @$page_title ? $page_title : $infos->seo_title; ?></title>
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?= asset("ampimg/favicon.png"); ?>" />

        <link rel="canonical" href="<?= $canonical = str_replace("/amp", "", Request::url()); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $og_title }}" />
        @if(@$og_image)
        <meta property="og:image" content="<?= $og_image; ?>" />
        @endif
        @if(@$page_description)
        <meta name="og:description" content="<?= htmlspecialchars($page_description); ?>">
        <meta name="description" content="<?= htmlspecialchars($page_description); ?>">
        @endif

        <meta name="msvalidate.01" content="CC5D396D64E6055F8BBAAB11324D7AEF" />    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Changa">
        <link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/droidarabicnaskh.css">

        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">



        <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
        <script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>
        <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
        <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
        <script async custom-element="amp-accordion" src="https://cdn.ampproject.org/v0/amp-accordion-0.1.js"></script>

        <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
        <script async custom-element="amp-bind" src="https://cdn.ampproject.org/v0/amp-bind-0.1.js"></script>

        <script async custom-element="amp-selector" src="https://cdn.ampproject.org/v0/amp-selector-0.1.js"></script>


        <script async custom-element="amp-social-share" src="https://cdn.ampproject.org/v0/amp-social-share-0.1.js"></script>



        <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
        <style amp-custom>
            @font-face{font-family:'29LTBukra-Regular';src:url(/fonts/ar/29LTBukra-Regular.svg#29LTBukra-Regular) format('svg'),url(/fonts/ar/29LTBukra-Regular.ttf) format('truetype'),url(/fonts/ar/29LTBukra-Regular.woff) format('woff');font-weight:400;font-style:normal;font-display:swap}@font-face{font-family:'29LTBukra-Bold';src:url(/fonts/ar/29LTBukra-Bold.svg#29LTBukra-Bold) format('svg'),url(/fonts/ar/29LTBukra-Bold.ttf) format('truetype'),url(/fonts/ar/29LTBukra-Bold.woff) format('woff');font-weight:400;font-display:swap;font-style:normal}@font-face{font-family:DroidNaskhRegular;src:url(/fonts/ar/DroidNaskh-Regular.ttf);font-display:fallback}.section_links_bottom{padding:40px 0;background:#fafafa;position:relative}@font-face{font-family:Flaticon;src:url("<?= asset("ampcss/Flaticon.eot"); ?>");src:url("<?= asset("ampcss/Flaticon.eot"); ?>?#iefix") format("embedded-opentype"),url("<?= asset("ampcss/Flaticon.woff"); ?>") format("woff"),url("<?= asset("ampcss/Flaticon.ttf"); ?>") format("truetype"),url("<?= asset("ampcss/Flaticon.svg#Flaticon"); ?>") format("svg");font-weight:400;font-style:normal}@media screen and (-webkit-min-device-pixel-ratio:0){@font-face{font-family:Flaticon;src:url("<?= asset("ampcss/Flaticon.svg#Flaticon"); ?>") format("svg")}}@font-face{font-family:logo;src:url('<?= asset("ampfonts/logo.eot?6dipm4"); ?>');src:url('<?= asset("ampfonts/logo.eot?6dipm4#iefix"); ?>') format('embedded-opentype'),url('<?= asset("ampfonts/logo.ttf?6dipm4"); ?>') format('truetype'),url('<?= asset("ampfonts/logo.woff?6dipm4"); ?>') format('woff'),url('<?= asset("ampfonts/logo.svg?6dipm4#logo"); ?>') format('svg');font-weight:400;font-style:normal}.glyphicon{top:1px;display:inline-block;font-family:Glyphicons Halflings;font-style:normal;font-weight:400;line-height:1;-webkit-font-smoothing:antialiased}.glyphicon-chevron-left:before{content:"\e079"}.glyphicon-chevron-right:before{content:"\e080"}.nav{padding-left:0;list-style:none}.nav>li>a{padding:10px 15px}.nav>li>a:focus,.nav>li>a:hover{text-decoration:none;background-color:#eee}.navbar{min-height:50px;margin-bottom:20px;border:1px solid transparent}.navbar-collapse{padding-right:15px;padding-left:15px;overflow-x:visible;-webkit-overflow-scrolling:touch;border-top:1px solid transparent;box-shadow:inset 0 1px 0 hsla(0,0%,100%,.1)}.navbar-collapse.in{overflow-y:auto}.navbar-fixed-bottom .navbar-collapse,.navbar-fixed-top .navbar-collapse{max-height:340px}.container-fluid>.navbar-collapse,.container-fluid>.navbar-header,.container>.navbar-collapse,.container>.navbar-header{margin-right:0;margin-left:0}.navbar-fixed-bottom,.navbar-fixed-top{position:fixed;right:0;left:0;z-index:1030}.carousel,.carousel-inner,.navbar-toggle{position:relative}.navbar-fixed-top{top:0;border-width:0 0 1px}.navbar-brand{float:left;height:50px;padding:15px;font-size:18px;line-height:20px}.navbar-brand:focus,.navbar-brand:hover{text-decoration:none}.navbar-toggle{float:right;padding:9px 10px;margin-top:8px;margin-right:15px;margin-bottom:8px;background-color:transparent;background-image:none;border:1px solid transparent;border-radius:4px}.navbar-toggle .icon-bar{display:block;width:22px;height:2px;border-radius:1px}.navbar-toggle .icon-bar+.icon-bar{margin-top:4px}.navbar-nav{margin:7.5px -15px}.navbar-nav>li>a{padding-top:10px;padding-bottom:10px;line-height:20px}.navbar-default{background-color:#f8f8f8;border-color:#e7e7e7}.navbar-default .navbar-brand{color:#777}.navbar-default .navbar-brand:focus,.navbar-default .navbar-brand:hover{color:#5e5e5e;background-color:transparent}.navbar-default .navbar-nav>li>a,.navbar-default .navbar-text{color:#777}.navbar-default .navbar-nav>li>a:focus,.navbar-default .navbar-nav>li>a:hover{color:#333;background-color:transparent}.navbar-default .navbar-toggle{border-color:#ddd}.navbar-default .navbar-toggle:focus,.navbar-default .navbar-toggle:hover{background-color:#ddd}.navbar-default .navbar-toggle .icon-bar{background-color:#888}.navbar-default .navbar-collapse,.navbar-default .navbar-form{border-color:#e7e7e7}.pull-right{float:right}.pull-left{float:left}.fa{display:inline-block;font:normal normal normal 14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased}.fa.pull-left{margin-right:.3em}.fa-search:before{content:"\f002"}.fa-list:before{content:"\f03a"}.fa-map-marker:before{content:"\f041"}.fa-plus-circle:before{content:"\f055"}.fa-heart-o:before{content:"\f08a"}.fa-phone:before{content:"\f095"}.fa-twitter:before{content:"\f099"}.fa-facebook-f:before,.fa-facebook:before{content:"\f09a"}.fa-google-plus:before{content:"\f0d5"}.fa-envelope:before{content:"\f0e0"}.fa-linkedin:before{content:"\f0e1"}.fa-comment-o:before{content:"\f0e5"}.fa-angle-up:before{content:"\f106"}.fa-instagram:before{content:"\f16d"}.fa-paper-plane:before,.fa-send:before{content:"\f1d8"}.fa-at:before{content:"\f1fa"}.fa-bed:before,.fa-hotel:before{content:"\f236"}.fa-map-o:before{content:"\f278"}.navbar>.container-fluid{width:100%}#mainNav ul a{display:block}#mainNav ul ul li a:after{content:"\f104";position:absolute;left:15px}.container-fluid>.navbar-collapse,.container-fluid>.navbar-header,.container>.navbar-collapse,.container>.navbar-header{padding:0 10px}#mainNav .navbar-collapse.in{overflow-y:auto}#mainNav .navbar-collapse,.navbar-collapse{overflow-x:hidden}#mainNav{background-color:#264584;font-family:Changa,sans-serif;z-index:999999999;padding:0;min-height:60px;margin:0;border:none;transition:all .2s}#mainNav .navbar-brand{z-index:999;font-weight:700;color:#fff;padding:8px 0;margin:4px 0 0;transition:all 2s linear;float:left}#mainNav .navbar-toggle{float:left;font-size:14px;font-weight:700;color:#222;z-index:999;margin-left:0;padding-left:0}#mainNav .navbar-nav a.nav-link{border-bottom:1px solid #fff;color:#fff;font-size:14px;display:inline-block}.navbar{display:flex;align-items:center;justify-content:space-between}#mainNav ul{list-style:none;position:relative}#mainNav ul a{padding:10px 15px 10px 0}#mainNav ul li{position:relative;margin:0;padding:5px 0}#mainNav ul li ul{opacity:0;position:absolute;top:100%;right:0;padding:0;z-index:99999}#mainNav ul ul li{float:none;min-width:220px;border-bottom:1px solid #e9e9e9}#mainNav ul ul{margin:4px 0 0;background-color:#fff;opacity:0;transition:all .25s;transform:translate3d(0,15px,0)}#mainNav ul ul:before{content:"123";position:absolute;width:100%;height:10px;top:-10px;opacity:0}#mainNav ul li a:after,#mainNav ul ul li a:after{font-family:Flaticon;opacity:.7}#mainNav ul li a:after{content:"\f111";padding-right:8px;font-size:10px}#mainNav ul li a:only-child:after{padding:0}#mainNav ul ul li:last-child{border-bottom:none}#mainNav ul li:hover ul a,#mainNav ul ul a{line-height:27px;padding:8px 30px 8px 15px;color:#707070;text-decoration:none;font-size:15px}.navbar-header .icons a span{color:#fff;width:35px;height:35px;display:block}.navbar-header .icons a span{padding:3px 0 0 0}.navbar-header .icons a span:before{font-size:27px}.navbar-header .icons a span.fa-search{position:relative;top:3px}.container-fluid>.navbar-collapse{padding:0 10px}.rotate-right{transform:rotate(40deg)}.rotate-left{transform:rotate(-40deg)}.navbar>.container-fluid{padding:0}.navbar-default .navbar-toggle{border-color:transparent;transition:all .3s ease-out;float:left;margin-top:2px}.navbar-default .navbar-toggle:focus,.navbar-default .navbar-toggle:hover{background-color:transparent}.navbar-default .navbar-toggle .icon-bar{transition:all .3s ease-out;margin-top:5px;background-color:#fff}.navbar-default .navbar-toggle .icon-bar.num1{transform-origin:top left}.navbar-default .navbar-toggle .icon-bar.num3{transform-origin:bottom left}.navbar-header .icons a{margin:10px 0 0 20px;position:relative;z-index:999}[class*=flaticon]:before{font-size:22px;margin:0}.logo-Damas-Logo{font-family:logo;speak:none;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;line-height:50px;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.logo-Damas-Logo:before{content:"\e900";color:#fff;font-size:200px}#mainNav .logo-Damas-Logo:before{float:left;width:170px}.call-center h2,.main-head{color:#264584;margin-top:0;padding-bottom:0;width:auto;position:relative;font-weight:700;font-size:22px;letter-spacing:0;font-family:'29LTBukra-Bold'}.footer-links li,.main-head,footer{position:relative}footer input{height:34px}.call-center{clear:both;padding-top:10px}.call-center h2{margin:20px auto 40px}.call-center aside{margin-bottom:10px}.call-center aside img{height:350px;margin-top:-146px}.call-center .form-group{margin-bottom:40px}.call-center textarea{margin-bottom:30px;max-width:100%;min-height:130px}.call-center .form-control{border-radius:0;outline:0;box-shadow:none;border:0;border-bottom:2px solid #5877b6;height:40px;background-color:#fafafa}.call-center button[type=submit]{background-color:#264584;color:#fff;box-shadow:5px 5px 10px 2px hsla(0,0%,39%,.15)}.call-center h2{width:auto}footer{float:left;width:100%;overflow:hidden;color:#d5d5d5;background:0 0;font-size:13px;line-height:22px;padding:30px 0;z-index:99999}footer .sub{float:right;width:50%;padding:0 10px 0 20px}footer p{font-weight:700;font-size:12px;margin:0}footer a{color:#123985}.flaticon-null:before{content:"\f100"}.flaticon-gift:before{content:"\f101"}.flaticon-money:before{content:"\f102"}.flaticon-shapes:before{content:"\f103"}.flaticon-house-key:before{content:"\f104"}.flaticon-travel:before{content:"\f105"}.flaticon-social-media:before{content:"\f106"}.flaticon-alarm-clock:before{content:"\f107"}.flaticon-placeholder:before{content:"\f108"}.flaticon-shapes-1:before{content:"\f109"}.flaticon-cancel:before{content:"\f10a"}.flaticon-share:before{content:"\f10b"}.flaticon-payment-method:before{content:"\f10c"}.flaticon-round:before{content:"\f10d"}.flaticon-gps:before{content:"\f10e"}.flaticon-city:before{content:"\f10f"}.flaticon-search:before{content:"\f110"}.flaticon-buildings:before{content:"\f111"}.flaticon-globe:before{content:"\f112"}.flaticon-tool:before{content:"\f113"}.flaticon-app:before{content:"\f114"}.flaticon-arrows:before{content:"\f115"}.flaticon-magnifying-glass:before{content:"\f116"}.flaticon-note:before{content:"\f117"}.flaticon-filter:before{content:"\f118"}.flaticon-sign:before{content:"\f119"}.flaticon-buildings-1:before{content:"\f11a"}.flaticon-bed:before{content:"\f11b"}.flaticon-key:before{content:"\f11c"}.flaticon-resize:before{content:"\f11d"}.flaticon-money-1:before{content:"\f11e"}body{font-family:'29LTBukra-Regular';background-color:#c7eafb}#sidebar{background-color:#fff;width:280px;padding:0 10px;padding-top:50px}.naviga{padding-right:0}.parent_menu{list-style:none;font-family:'29LTBukra-Regular'}.parent_menu .drop a{color:#fff}.parent_menu .dropdown-menu li{list-style:none}.parent_menu .dropdown-menu li a{color:#fff}amp-accordion section[expanded]>h2{background-color:#264584;color:#fff}amp-accordion section>h2:focus{outline:0}.amp-close-image{background-color:#264584;margin-bottom:15px;position:absolute;top:10px;left:10px;border-radius:100%;width:30px;height:30px;text-align:center;padding:0px;font-size:16px;color:#fff;border:1px solid #264584}.ampstart-social-follow{padding:0;width:100%;float:left;text-align:center;display:table;position:relative;top:60px;left:0}.ampstart-social-follow li{float:none;display:-webkit-inline-box;margin:10px}.ampstart-social-follow li a{font-size:18px;color:#264584}.ampstart-social-follow li a:active,.ampstart-social-follow li a:focus{color:#f7b44d}.accordionheader{cursor:pointer;background-color:transparent;padding-right:20px;border:1px solid #264584;padding-left:10px;text-align:right;font-size:15px;color:#264584;padding:10px;border-radius:0 0 0 15px}.accordionheader i{position:absolute;left:5px;top:11px}.accordionheader i.fa-minus{display:none}amp-accordion section[expanded]>h2 i.fa-minus{display:block}amp-accordion section[expanded]>h2 i.fa-plus{display:none}amp-accordion>section{margin-bottom:5px}.accordcontent{padding:5px;background-color:#f5f5f5;border-radius:0 0 0 15px}.amp-menu-links{padding:0;margin:0}.amp-menu-links li{list-style:none;margin-bottom:5px;border-bottom:1px solid #ccc;padding-bottom:5px}.amp-menu-links li:last-child{border-bottom:0}.amp-menu-links li a{color:#264584;width:100%;display:block;font-family:'29LTBukra-Regular'}.floating-message-inline .header-contactform .form-group .form-control::-webkit-input-placeholder,.formindex>div .form-control::-webkit-input-placeholder{color:#1f3a73}.floating-message-inline .header-contactform .form-group .form-control::-moz-placeholder,.formindex>div .form-control::-moz-placeholder{color:#1f3a73}.floating-message-inline .header-contactform .form-group .form-control:-ms-input-placeholder,.formindex>div .form-control:-ms-input-placeholder{color:#1f3a73}.floating-message-inline .header-contactform .form-group .form-control:-moz-placeholder,.formindex>div .form-control:-moz-placeholder{color:#1f3a73}h1,h2,h3{color:#264584}span.price{float:left;width:100%;text-align:center;margin:5px 0;color:#264584;font-size:25px;direction:ltr;font-family:Montserrat,sans-serif;font-weight:700}span.price p{width:auto;float:none;display:-webkit-inline-box;font-family:'29LTBukra-Regular';font-size:18px;font-weight:400;padding:0;margin:0}.content-shear{position:absolute;left:0;top:5px;z-index:999}.content-shear i{font-size:25px;color:#fff}.content-shear i.flaticon-share{margin:-6px 6px 0 0}.content-shear i.flaticon-share:before{font-size:21px;margin-left:10px}.news-construct .item a .layer h3{font-size:20px;position:absolute;bottom:16px;color:#fff;text-align:right;width:100%;margin:0;left:0;padding:0 5px}.select-form .col-xs-6{float:right;width:38%}.leaad{background-color:#fff;margin:20px 0 0 0;padding:10px;border-radius:5px}.leaad p{color:#555;font-family:DroidNaskhRegular;font-size:16px;text-align:justify}.leaad h2{font-size:18px;text-align:right;font-family:'29LTBukra-Bold';line-height:35px}.searchtab span:before{color:#fff}amp-accordion section[expanded] .show-more{display:none}amp-accordion section:not([expanded]) .show-less{display:none}#form-search button{background-color:transparent;border:none}.amp-section-search{position:absolute;right:0;top:15px;width:100%}.amp-section-search h5{color:#fff;width:25px;height:25px;padding:0;right:110px}.amp-section-search h5:focus{outline:0}.amp-section-search h5 span{font-size:22px;position:relative;top:-9px;right:3px}.amp-section-search .accordcontent{left:-40px;top:24px;right:auto;background-color:rgba(255,255,255,.8);border-radius:100px;width:calc(100% - 80px);border:1px solid rgba(38,69,132,.8)}.amp-section-search .accordcontent button{position:absolute;top:12px;left:10px;background-color:transparent;border:none;background-image:url(/img/send-icon.svg);background-repeat:no-repeat;background-size:24px}.amp-section-search .accordcontent button span{opacity:0}.amp-section-search .accordcontent input{border:none;background-color:transparent;color:#264584;height:40px}.amp-section-search .accordcontent input::-webkit-input-placeholder{color:#264584}.amp-section-search .accordcontent input::-moz-placeholder{color:#264584}.amp-section-search .accordcontent input:-ms-input-placeholder{color:#264584}.amp-section-search .accordcontent input:-moz-placeholder{color:#264584}.amp-whatsapp-icon{width:35px;height:35px;text-align:center;border-radius:50%;background-color:#00b04c;margin-left:10px;position:relative;color:transparent}.amp-whatsapp-icon:after{content:"";width:100%;height:100%;border-radius:50%;border:1px solid rgba(0,176,76,1);display:inline-block;position:absolute;top:0;left:0;animation-name:test;animation-duration:1.5s;animation-delay:.65s;animation-iteration-count:infinite;animation-timing-function:ease-in-out}@keyframes test{from{transform:scale(1);border:1px solid rgba(0; 176,76,1)}to{transform:scale(2);border:1px solid rgba(0,176,76,0)}}.amp-carousel-button-next,.amp-carousel-button-prev{background-color:#264584;border-radius:100%}.amp-carousel-button-next{right:6px}.amp-carousel-button-prev{left:6px}.amp-telephone-list{width:100%;padding:0;margin-bottom:15px;display:grid;margin-top:10px}.amp-telephone-list li{float:left;width:100%;list-style:none;margin-bottom:10px}.amp-telephone-list li a{float:left;width:100%;color:#264584}.amp-telephone-list li a i{float:left;font-size:20px;margin-right:5px}.amp-telephone-list li a p{float:left;margin:0;direction:ltr;font-size:15px}.amp-telephone-list li a span{float:left;font-size:11px;color:#555;margin:3px 0 0 5px}.icon-bg{background-image:url(/img/citizenship-icons9.png);background-repeat:no-repeat}.topPhoto{float:left;width:100%;height:auto;position:relative;z-index:99999;margin-top:52px}.topPhoto img{width:100%}.topPhoto .section-text{position:absolute;top:0;left:0;width:100%;text-align:right;padding:15px 30px 0 10px}.topPhoto .section-text .icon-bg{position:absolute;top:19px;right:11px;width:26px;height:85px;background-size:106px;background-position:-37px 4px}.topPhoto .section-text p{font-size:21px;color:#002f45;-moz-transform:scale(1) rotate(0) translate(0,0) skew(10deg,0deg);-webkit-transform:scale(1) rotate(0) translate(0,0) skew(10deg,0deg);-o-transform:scale(1) rotate(0) translate(0,0) skew(10deg,0deg);-ms-transform:scale(1) rotate(0) translate(0,0) skew(10deg,0deg);transform:scale(1) rotate(0) translate(0,0) skew(10deg,0deg)}.topPhoto .section-text p strong{font-size:23px}.big-content{float:left;width:100%;height:auto;min-height:400px;position:relative;z-index:99999;text-align:center;display:table}.big-content:before{content:"";width:100%;height:400px;position:fixed;top:360px;left:0;background-image:url(/img/contentBg.png);background-repeat:no-repeat;background-position:top center;background-size:100%;z-index:-1}.photo-content{float:left;width:100%;height:auto;min-height:250px;position:relative;z-index:9}amp-img.pricePhoto{position:relative;left:20px;top:-15px;z-index:99;width:53%;float:none;display:inline-block}amp-img.passport{position:relative;right:20px;top:-71px;z-index:9;width:42%;float:none;display:inline-block}.new-content{float:left;width:100%;height:auto;position:relative;z-index:9999;padding:15px}.new-content h2{float:left;width:100%;font-size:19px;color:#264584;margin-bottom:20px;line-height:29px}.timeline{float:left;width:100%;margin:10px auto;padding:0 10px 0 10px;position:relative}.timeline:before{content:"";position:absolute;top:0;left:18.5px;right:auto;bottom:0;width:6.5px;background-color:#b0ccda;border-radius:5px}.timeline .point-top{position:absolute;top:0;left:14px;width:16px;height:16px;background-color:#a1bbc8;border-radius:100%}.timeline .point-bottom{position:absolute;bottom:0;left:14px;width:16px;height:16px;background-color:#a1bbc8;border-radius:100%}.timeline .cont{float:right;width:calc(100% - 60px);min-height:150px;padding:10px;background-color:#fff;font-size:16px;line-height:1.7;position:relative;border-radius:20px 0 0 20px;padding-right:55px;margin-bottom:45px;-webkit-box-shadow:2px 2px 5px 2px rgba(18,27,33,.2);-moz-box-shadow:2px 2px 5px 2px rgba(18,27,33,.2);box-shadow:2px 2px 5px 2px rgba(18,27,33,.2)}.timeline .cont:first-of-type{margin-top:0}.timeline .cont:last-of-type{margin-bottom:0}.timeline .cont .icon{width:45px;height:45px;background-color:#fff;border-radius:50%;position:absolute;left:-70px;top:50%;margin-top:-22.5px;background-color:#35a5db}.timeline .cont .icon:after{content:"";width:39px;height:39px;background-color:#fff;border-radius:50%;position:absolute;left:3px;top:3px}.timeline .cont .date{position:absolute;width:63px;left:-78px;top:63%;font-size:10px;font-weight:700;font-style:italic;color:#4f4f4f;font-family:Montserrat}.timeline .cont .date strong{font-size:18px;position:relative;top:-8px}.timeline .cont:after{content:"";width:0;height:0;border-top:15px solid transparent;border-bottom:15px solid transparent;border-right:22px solid #fff;position:absolute;left:-21px;top:50%;margin-top:-15px}.timeline .cont p{font-size:15px;line-height:23px;color:#606060;font-family:DroidNaskhRegular;text-align:right;direction:rtl}.timeline .cont a{background-color:#0e8bd2;color:#fff;padding:9px 20px 9px 20px;border-radius:20px;font-size:13px}.timeline .cont a:focus{background-color:#132467;outline:0}.timeline .cont .title{position:absolute;top:-15px;right:-10px;height:calc(100% + 30px);width:52px;background-color:transparent;border-radius:0 20px 20px 0;writing-mode:vertical-rl}.timeline .cont .title:before{content:"";position:absolute;top:0;left:-15px;width:0;height:0;border-style:solid;border-width:0 0 15px 15px;z-index:99;border-color:transparent transparent #1c449c transparent}.timeline .cont .title:after{content:"";position:absolute;bottom:0;left:-15px;width:0;height:0;border-style:solid;border-width:0 15px 15px 0;z-index:99;border-color:transparent #1c449c transparent transparent}.timeline .cont .title span{height:auto;width:100%;display:inline-block;text-align:center;padding:14px;font-size:15px;color:#fff;text-shadow:-1px 1px 0 rgba(0,0,0,.5);position:relative;line-height:21px;z-index:9999}.timeline .cont .title .luster{position:absolute;left:0;top:0;width:100%;height:100%;overflow:hidden;z-index:999;border-radius:0 20px 20px 0;background-color:#35a5db}.timeline .cont:nth-child(1) .icon .icon-bg{width:45px;height:45px;background-size:75px;background-position:-15px -1630px;z-index:99;position:relative;display:block}.timeline .cont:nth-child(2) .icon .icon-bg{width:45px;height:45px;background-size:65px;background-position:-10px -1364px;z-index:99;position:relative;display:block}.timeline .cont:nth-child(3) .icon .icon-bg{width:45px;height:45px;background-size:67px;background-position:-13px -730px;z-index:99;position:relative;display:block}.timeline .cont:nth-child(4) .icon .icon-bg{width:45px;height:45px;background-size:45px;background-position:1px -1126px;z-index:99;position:relative;display:block}amp-selector[role=tablist].tabs-with-flex{display:flex;flex-wrap:wrap}amp-selector[role=tablist].tabs-with-flex [role=tab]{flex-grow:1;text-align:center;padding:var(--space-1);display:block;padding:4px;background-color:#35a5db;border:1px solid #a1bbc8;text-align:center;color:#000;text-decoration:none;border-radius:15px 15px 0 0;color:#fff;overflow:hidden;position:relative;border-bottom:0}amp-selector[role=tablist].tabs-with-flex [role=tab][selected]{outline:0;border-bottom:2px solid var(--color-primary);background-color:#fff;color:#000;background-image:linear-gradient(to left,#fff 0,#fff 100%)}amp-selector[role=tablist].tabs-with-flex [role=tabpanel]{display:none;width:100%;order:1}amp-selector[role=tablist].tabs-with-flex [role=tab][selected]+[role=tabpanel]{display:block}amp-selector[role=tablist].tabs-with-selector{display:flex}amp-selector[role=tablist].tabs-with-selector [role=tab][selected]{outline:0;border-bottom:2px solid var(--color-primary)}amp-selector[role=tablist].tabs-with-selector{display:flex}amp-selector[role=tablist].tabs-with-selector [role=tab]{width:100%;text-align:center;padding:var(--space-1)}amp-selector.tabpanels [role=tabpanel]{display:none;padding:var(--space-4)}amp-selector.tabpanels [role=tabpanel][selected]{outline:0;display:block}.decision-arabic{width:100%;max-height:250px;overflow:auto;text-align:right;direction:ltr;padding:10px;background-color:#fff;-webkit-box-shadow:0 0 4px 0 #aeaeae;-moz-box-shadow:0 0 4px 0 #aeaeae;box-shadow:0 0 4px 0 #aeaeae}.decision-arabic h2,.decision-arabic ol,.decision-arabic p,.decision-arabic ul{direction:rtl}.decision-arabic p{font-family:DroidNaskhRegular}.decision-arabic ol,.decision-arabic ul{padding-right:15px}.form-content .form .info{float:left;width:100%;position:relative;margin:20px 0 0 0;display:block}.form-content .form .info .icon-bg{width:74px;height:76px;position:absolute;top:-82px;left:50%;margin-left:-30px;background-position:0 -124px;background-size:75px}.form-content .form .info .clientimg{float:right;width:51px}.form-content .form .info .tel{text-align:center;width:calc(100% - 93px);float:right;color:#fff;margin-top:3px}.form-content .form .info .tel .service{font-size:14px}.form-content .form .info .tel .num{color:#fff;direction:ltr}.form-content .form .info .whatsapp{float:left;width:42px;margin:5px 0 0 0}.form-content .form .info .whatsapp .whatsapp-icon{background-color:#00b04c;color:#00b04c;width:42px;height:42px;border-radius:50%;padding:6px 0 0 0;position:relative}.form-content .form .info .whatsapp i{font-size:32px;color:#fff}.form-content .form .info .whatsapp .whatsapp-icon:after{content:"";width:100%;height:100%;border-radius:50%;border:1px solid rgba(0,176,76,1);display:inline-block;position:absolute;top:0;left:0;animation-name:test;animation-duration:1.5s;animation-delay:.65s;animation-iteration-count:infinite;animation-timing-function:ease-in-out}@keyframes test{from{transform:scale(1);border:1px solid rgba(0; 176,76,1)}to{transform:scale(2);border:1px solid rgba(0,176,76,0)}}.form-content .form form{margin:15px 0 0 0;width:100%;overflow:hidden;position:relative;padding:0 0 5px 0}.form-content .form form .name{float:right;width:50%;padding:0 0 0 6px}.form-content .form form .fame{width:50%;float:left}.form-content .form form .time{float:right;width:44%;margin-top:4px;padding:0 0 0 6px}.form-content .form form .budget{float:right;width:56%;margin-top:4px;padding-left:52px}.form-content .form form .send{position:absolute;bottom:6px;left:-3px;right:auto;width:50px;height:50px}.form-content .form input,.form-content .form select,.form-content .form textarea{width:100%;height:38px;float:right;font-size:12px;border:0;color:#1f3a73;direction:rtl;border-radius:0 25px 25px 40px;padding:0 10px 0 10px;margin:0 0 10px 0}.form-content .form input#mobile-sm{text-align:left;direction:ltr;padding-left:50px}.form-content .form select{border-radius:0 25px 25px 25px}.form-content .form textarea{height:100px;padding:10px;margin-bottom:5px;border-radius:0 20px 20px 40px}.form-content{float:left;width:100%;border-radius:0 0 40px 0;padding:20px 20px 10px 20px;margin:30px 0 15px 0;position:relative;background-image:linear-gradient(to bottom right,#063760 0,#114b73 40%,#1b5f89 70%,#26739d 100%)}.form-content .form{position:relative;z-index:999}.intl-tel-input .flag-dropdown{position:absolute;z-index:99;cursor:pointer;left:7px;top:4px}.intl-tel-input .flag-dropdown .country-list{text-align:left}.required-documents{float:left;width:100%;height:auto;min-height:370px;padding:55px 15px 15px 15px;position:relative;margin:60px 0 0 0}.required-documents amp-img.required-documents-bg{position:absolute;top:0;left:0;width:100%;height:100%}.required-documents .icon-bg{width:66px;height:66px;position:absolute;top:-3px;left:50%;margin-left:-27px;background-size:74px;background-position:-3px -314px}.required-documents h2{float:left;width:100%;font-size:19px;color:#fff;margin:15px 0 20px 0;line-height:29px;position:relative;z-index:9}.required-documents ul{float:left;width:100%;height:auto;padding:0 5px 55px 0;margin:0;position:relative;z-index:99}.required-documents ul li{float:left;width:100%;height:auto;list-style:none;margin-bottom:5px}.required-documents ul li .check-icon{float:right;width:21px;height:21px;margin-left:10px;background-size:73px;background-position:-6px -385px;position:relative;top:0;left:auto}.required-documents ul li p{float:right;font-size:15px;color:#fff;text-align:right;font-family:DroidNaskhRegular;margin:0;width:calc(100% - 32px);direction:rtl}.required-documents a{background-color:transparent;color:#fff;padding:10px 25px 10px 25px;border-radius:20px;font-size:15px;border:1px solid #fff;position:relative;top:20px}.required-documents a:focus{background-color:#fff;color:#264584;outline:0}.steps-to-progress h2{margin-bottom:10px}.steps-to-progress{margin-top:10px}.timeline-steps{float:left;width:100%;min-height:400px;margin:0 0 10px 0;padding:0;position:relative}.timeline-steps:before{content:"";position:absolute;top:70px;left:10px;right:auto;bottom:0;width:12px;border-radius:5px;z-index:-1;background-image:linear-gradient(to left,#c8d4dd 0,#eef5f8 30%,#a7b5bf 70%,#d7dde0 100%)}.timeline-steps .flag-pole-top{position:absolute;left:6px;top:48px;opacity:.8;width:19px}.timeline-steps .flag-pole-bottom{position:absolute;left:6px;bottom:-22px;opacity:.8;width:19px}.timeline-steps .item{float:right;width:calc(100% - 45px);background-color:#fdfdfd;border-radius:15px;min-height:135px;position:relative;margin-bottom:80px;padding-bottom:30px}.timeline-steps .item amp-img.arrow-white-bottom{position:absolute;left:0;bottom:-55px;width:100%}.timeline-steps .item .title{float:right;width:100%;padding:15px 10px 10px 10px;position:relative;border-radius:15px;z-index:99}.timeline-steps .item .title amp-img{position:absolute;left:0;bottom:-48px;width:100%}.timeline-steps .item .title span{font-size:18px;color:#fff;text-shadow:1px 1px 0 rgba(0,0,0,.5);z-index:99;position:relative;top:5px}.timeline-steps .item .title strong{color:#004569;position:relative;top:13px;display:block;width:100%;text-align:center}.timeline-steps .item .sub-title{float:right;width:100%;padding:0 10px 0 10px;border-radius:15px;padding-top:65px;margin-top:-45px;position:relative}.timeline-steps .item .sub-title amp-img{position:absolute;left:0;bottom:-48px;width:100%}.timeline-steps .item .sub-title span{font-size:18px;color:#004569;z-index:9;position:relative;top:0}.timeline-steps .number-list{float:left;width:100%;padding:0;text-align:center;direction:rtl;position:relative;top:22px}.timeline-steps .number-list span{float:none;width:25px;height:25px;background-color:#fff;border-radius:100%;text-align:center;color:#a6a6a6;display:-webkit-inline-box;position:relative}.timeline-steps .number-list span.active{width:29px;height:29px;top:2px}.timeline-steps .number-list span strong{color:#a6a6a6;position:absolute;top:-1px;left:7px;font-size:18px;font-family:Montserrat,sans-serif}.timeline-steps .number-list span.active strong{font-size:22px;left:10px;color:#fff}.section-contents{float:left;width:100%;height:275px;margin-top:35px;overflow:hidden}.timeline-steps .item a.more-btn,.timeline-steps .item a.steps-back-btn{color:#fff;padding:11px 30px 10px 30px;border-radius:20px;font-size:13px;z-index:99;width:110px;text-align:center;position:absolute;bottom:-15px;left:50%;margin-left:-55px}.timeline-steps .item .date-title{position:absolute;top:196px;left:-55px;font-size:15px;color:#004569;width:50px;text-align:center;line-height:13px;padding-top:7px}.timeline-steps .item .date-title strong{float:left;width:100%;font-size:18px;font-family:Montserrat,sans-serif}.timeline-steps .date-photo{width:67px;position:absolute;left:-55px;top:163px;z-index:-1}.timeline-steps .stamp{position:absolute;bottom:-15px;width:160px;left:50%;margin-left:-80px;z-index:999}.timeline-steps .item.three .number-list span.active strong,.timeline-steps .item.two .number-list span.active strong{left:8px;top:-2px}.timeline-steps .item.one .number-list span.active,.timeline-steps .item.one .title,.timeline-steps .item.one a.more-btn,.timeline-steps .item.one a.steps-back-btn{background-image:linear-gradient(to right,#0173b2 0,#2293cc 50%,#3fafe3 100%)}.timeline-steps .item.one .sub-title{background-image:linear-gradient(to right,#7abee8 0,#8fcef0 50%,#a4def9 100%)}.timeline-steps .item.result-steps{width:calc(100% - 21px);border-radius:0;background-color:transparent;margin-bottom:0}.timeline-steps .item .int-content{width:100%;height:135px;border-radius:0;background-color:#fdfdfd;background-image:url(/img/man.jpg);background-size:52%;background-repeat:no-repeat;background-position:right 13px bottom 0}.timeline-steps .item .int-content amp-img.arrow-right-transparent-blue{position:absolute;right:-1px;top:-1px;height:137px;width:27px}.timeline-steps .item .text{float:left;width:50%;height:135px;border-radius:0;padding:2px;position:relative;z-index:999}.timeline-steps .item .text span{position:relative;top:16px;right:11px;float:initial;text-align:center;font-size:25px;color:#fff;padding:4px 0 7px 0;margin-bottom:5px;border-bottom:1px solid #fff;display:inline-flex;direction:ltr}.timeline-steps .item .text span strong{margin:0 4px}.timeline-steps .item .text span strong:nth-child(1){font-weight:400}.timeline-steps .item .text p{position:relative;top:17px;margin:0;font-size:13px;color:#fff;width:auto;display:inline-block;margin-right:21px}.timeline-steps .item amp-img.result_steps-hand{position:absolute;left:-16.5px;top:-5px;z-index:9;height:146px;width:55%}.all-content{width:100%;height:230px;overflow:auto;text-align:right;direction:ltr;padding:10px;margin:0}.all-content p{font-size:14px;color:#606060;text-align:justify;font-family:DroidNaskhRegular;direction:rtl}.all-content ol,.all-content ul{font-family:DroidNaskhRegular;padding-right:20px}.all-content h2,.all-content ol,.all-content p,.all-content ul{direction:rtl}.required-documents.red-section{padding:175px 0 100px 0;margin-top:0;background-image:none}.required-documents.red-section amp-img.RedBG{position:absolute;top:0;left:0;width:100%;height:100%}.required-documents.red-section h2{position:relative;z-index:9}.required-documents.red-section .icon-bg.flagW{width:116px;height:83px;position:absolute;top:104px;left:50%;margin-left:-58px;background-size:115px;background-position:0 -93px}.required-documents.red-section ul{padding:0 10px 0 10px;position:relative;z-index:9}.required-documents.red-section ul p{font-size:14px}.required-documents.red-section .arrow-down-blue{position:absolute;top:-1px;left:0;width:100%}.required-documents.red-section .arrow-down-transparent-blue{position:absolute;bottom:-2px;left:0;width:100%}amp-img.map{width:100%;margin:40px 0 0 0}.section-map .top-title{float:left;width:100%;height:auto}.section-map .top-title amp-img.passport{position:absolute;left:4px;right:auto;top:0;width:90px;bottom:auto}.section-map .top-title .text{float:left;width:100%;height:auto;min-height:70px;position:relative;overflow:hidden;border-radius:0 0 30px 0;background-color:#fff}.section-map .top-title .text h2{text-align:right;font-size:15px;color:#fff;margin:0;padding:3px 10px 3px 0;background-image:linear-gradient(to left,#055ea2 0,#2972b0 40%,#6b9bc8 60%,#a1bfdf 80%,#d0e6f4 100%)}.section-map .top-title .text ul{float:left;width:100%;padding:0 5px 0 100px;text-align:center;display:block;margin:0 0 10px 0}.section-map .top-title .text ul li{list-style:none;width:50%;padding:0 10px;float:right;text-align:center}.section-map .top-title .text ul li span{float:left;width:100%;font-size:14px;color:#264584;margin:5px 0}.section-map .top-title .text .pointer{float:left;width:100%;height:26px;position:relative}.section-map .top-title .text .pointer.green{background-color:#00a651}.section-map .top-title .text .pointer.blue{background-color:#0066b3}.section-map .top-title .text .pointer:after{content:"";position:absolute;right:-1px;bottom:0;width:0;height:0;border-right:13px solid #fff;border-top:13px solid transparent;border-bottom:13px solid transparent}.section-map .top-title .text .pointer:before{content:"";position:absolute;left:-13px;bottom:0;width:0;height:0;border-top:13px solid transparent;border-bottom:13px solid transparent}.section-map .top-title .text .pointer.green:before{border-right:13px solid #00a651}.section-map .top-title .text .pointer.blue:before{border-right:13px solid #0066b3}.section-map .top-title .text .pointer span{font-size:14px;color:#fff;margin:0;direction:rtl;padding:3px 15px 3px 3px}ul.countries{float:left;width:100%;padding:0;text-align:center;display:block;direction:rtl}ul.countries li{list-style:none;width:50%;display:block;float:right;margin-bottom:20px}ul.countries li .icon-bg{width:85px;height:77px;margin:auto}ul.countries li span{width:100%;font-size:14px;color:#264584}ul.countries li:nth-child(1) .icon-bg{background-size:85px;background-position:0 -1039px}ul.countries li:nth-child(2) .icon-bg{background-size:85px;background-position:0 -1120px}ul.countries li:nth-child(3) .icon-bg{background-size:85px;background-position:0 -1203px}ul.countries li:nth-child(4) .icon-bg{background-size:85px;background-position:0 -1283px}ul.countries.two li:nth-child(1) .icon-bg{background-size:85px;background-position:0 -2036px}ul.countries.two li:nth-child(2) .icon-bg{background-size:85px;background-position:0 -565px}ul.countries.two li:nth-child(3) .icon-bg{background-size:85px;background-position:0 -648px}ul.countries.two li:nth-child(4) .icon-bg{background-size:85px;background-position:0 -728px}ul.countries.three li:nth-child(1) .icon-bg{background-size:85px;background-position:0 -2372px}ul.countries.three li:nth-child(2) .icon-bg{background-size:85px;background-position:0 -2207px}ul.countries.three li:nth-child(3) .icon-bg{background-size:85px;background-position:0 -2452px}ul.countries.three li:nth-child(4) .icon-bg{background-size:85px;background-position:0 -2290px}.progress-circle{background-color:#ddd;border-radius:50%;display:inline-block;height:125px;margin:0 10px;position:relative;width:125px}.progress-circle:before{align-items:center;background-color:#fff;border-radius:50%;content:attr(data-progress) '%';display:flex;font-size:25px;color:#264584;justify-content:center;position:absolute;left:10px;right:10px;top:10px;bottom:10px;transition:-webkit-transform .2s ease;transition:transform .2s ease;transition:transform .2s ease,-webkit-transform .2s ease;font-family:Montserrat;font-weight:700}.progress-circle:after{background-color:#0083ff;border-radius:50%;content:'';display:inline-block;height:100%;width:100%}.progress-circle:focus:before,.progress-circle:hover:before{-webkit-transform:scale(.9);transform:scale(.9)}.progress-circle span{position:absolute;top:-32px;font-size:20px;color:#264584;font-family:Montserrat;font-weight:700;width:60px;text-align:center;left:50%;margin-left:-30px}.progress h2{margin-bottom:65px}.progress-circle[data-progress="50"]{height:150px;width:150px;margin-bottom:20px}.progress-circle[data-progress="50"] span{font-size:30px;top:-42px}.progress-circle[data-progress="50"]:before{font-size:30px}.progress-circle[data-progress="75"]{margin:0 0 0 30px}.progress-circle[data-progress="25"]{margin:0 30px 0 0}.progress-circle[data-progress="25"]:after{background-image:linear-gradient(90deg,#ddd 50%,transparent 50%,transparent),linear-gradient(180deg,#264584 50%,#ddd 50%,#ddd)}.progress-circle[data-progress="50"]:after{background-image:linear-gradient(-90deg,#00adb4 50%,transparent 50%,transparent),linear-gradient(270deg,#00adb4 50%,#ddd 50%,#ddd)}.progress-circle[data-progress="75"]:after{background-image:linear-gradient(0deg,#32c5f4 50%,transparent 50%,transparent),linear-gradient(270deg,#32c5f4 50%,#ddd 50%,#ddd)}amp-social-share.rounded{border-radius:50%;background-size:60%}@media (min-width:481px) and (max-width:767px){.timeline .cont{min-height:165px}.timeline-steps .item .sub-title img,.timeline-steps .item .title img,.timeline-steps .item img.arrow-white-bottom{display:none}.timeline-steps .item .sub-title span{top:-4px}.header .navbar2 .contain{margin-top:-3px}.topPhoto{margin-top:45px}.header .navbar2{padding-left:5px}.header .devise select{padding:0 18px 0 0;height:25px;top:0}img.passport{width:27%}img.pricePhoto{width:30%}.timeline-steps .item .title span{top:-5px}.timeline-steps .item .title strong{top:0}.timeline-steps .number-list{top:-5px}.timeline-steps .item .int-content .text p{width:100%}.multiselect-selected-text{max-width:150px}.multiselect-container{right:0;left:auto}.timeline-steps .item img.result_steps-hand{width:50%}}@media (min-width:320px) and (max-width:480px){.multiselect-container{right:0;left:auto}.header .navbar2{padding-left:5px}.header .devise select{padding:0 18px 0 0;height:25px;top:0}}.text-center{ text-align: center;}*,.intl-tel-input input,:after,:before{box-sizing:border-box}hr,img{border:0}.form-control,body{background-color:#fff;font-family:"Droid Arabic Naskh"}.btn,img{vertical-align:middle}.collapsing,.glyphicon,.input-group,.input-group .form-control,.input-group-btn,.input-group-btn>.btn,.nav>li,.nav>li>a,.navbar{position:relative}.form-control:focus,.navbar-toggle:focus,a:active,a:hover{outline:0}.carousel-caption,.carousel-control{text-shadow:0 1px 2px rgba(0,0,0,.6);text-align:center}.fa,.glyphicon{-moz-osx-font-smoothing:grayscale}.btn,.intl-tel-input .flag-dropdown,.likeCardItem,.showSocialButtons,[role=button]{cursor:pointer}html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section,summary{display:block}button,input,optgroup,select,textarea{font:inherit;color:inherit}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}html{font-size:10px;-webkit-tap-highlight-color:transparent}body{font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333}a{color:#337ab7;text-decoration:none}a:focus,a:hover{color:#23527c;text-decoration:underline}.carousel-inner>.item>a>img,.carousel-inner>.item>img,.img-responsive,.thumbnail a>img,.thumbnail>img{display:block;max-width:100%;height:auto}hr{margin-top:20px;margin-bottom:20px;border-top:1px solid #eee}.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6{font-family:inherit;font-weight:500;line-height:1.1;color:inherit}.h1,.h2,.h3,h1,h2,h3{margin-top:20px;margin-bottom:10px}.h4,.h5,.h6,h4,h5,h6{margin-top:10px;margin-bottom:10px}.h1,h1{font-size:30px}.h2,h2{font-size:25px}.h3,h3{font-size:20px}.h4,h4{font-size:15px}.btn,.form-control,output{font-size:14px;line-height:1.42857143}p{margin:0 0 10px}.text-center{text-align:center}ol,ul{margin-top:0;margin-bottom:10px}ol ol,ol ul,ul ol,ul ul{margin-bottom:0}.list-inline,.list-unstyled{padding-left:0;list-style:none}.list-inline{margin-left:-5px}.list-inline>li{display:inline-block;padding-right:5px;padding-left:5px}.amp-border-link{border:1px solid #fff;border-radius:5px;padding:5px 10px}.container,.container-fluid{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.row{margin-right:-15px;margin-left:-15px}.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{position:relative;min-height:1px;padding-right:15px;padding-left:15px}.btn,.form-control{padding:6px 12px;background-image:none}.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{float:left}.col-xs-12{width:100%}.form-control,output{display:block;color:#555}.form-control{width:100%;border:1px solid #ccc;border-radius:4px;box-shadow:inset 0 1px 1px rgba(0,0,0,.075);transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}.form-control:focus{border-color:#66afe9;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)}.form-control::-webkit-input-placeholder{color:#999}textarea.form-control{height:auto}.form-group{margin-bottom:15px}.btn,.nav{margin-bottom:0}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;-ms-touch-action:manipulation;touch-action:manipulation;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;border-radius:4px}.btn.focus,.btn:focus,.btn:hover{color:#333;text-decoration:none}.btn-primary{color:#fff;background-color:#337ab7;border-color:#2e6da4}.btn-primary.active,.btn-primary:active,.btn-primary:hover,.open>.dropdown-toggle.btn-primary{color:#fff;background-color:#286090;border-color:#204d74}.btn-group-lg>.btn,.btn-lg{padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}.btn-block{display:block;width:100%}.collapse{display:none}.collapse.in{display:block}.collapsing{height:0;overflow:hidden;transition-timing-function:ease;transition-duration:.35s;transition-property:height,visibility}.input-group{display:table;border-collapse:separate}.input-group .form-control{z-index:2;float:left;width:100%;margin-bottom:0}.input-group .form-control,.input-group-addon,.input-group-btn{display:table-cell}.media-object,.nav>li,.nav>li>a,.navbar-brand>img{display:block}.input-group-addon,.input-group-btn{width:1%;white-space:nowrap;vertical-align:middle}.input-group .form-control:first-child,.input-group-addon:first-child,.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group>.btn,.input-group-btn:first-child>.dropdown-toggle,.input-group-btn:last-child>.btn-group:not(:last-child)>.btn,.input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle){border-top-right-radius:0;border-bottom-right-radius:0}.input-group .form-control:last-child,.input-group-addon:last-child,.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,.input-group-btn:first-child>.btn:not(:first-child),.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group>.btn,.input-group-btn:last-child>.dropdown-toggle{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-btn{font-size:0;white-space:nowrap}.input-group-btn>.btn:active,.input-group-btn>.btn:focus,.input-group-btn>.btn:hover{z-index:2}.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group{z-index:2;margin-left:-1px}.nav{padding-left:0;list-style:none}.nav>li>a{padding:10px 15px}.nav>li>a:focus,.nav>li>a:hover{text-decoration:none;background-color:#eee}.navbar{min-height:50px;margin-bottom:20px;border:1px solid transparent}.navbar-collapse{padding-right:15px;padding-left:15px;overflow-x:visible;-webkit-overflow-scrolling:touch;border-top:1px solid transparent;box-shadow:inset 0 1px 0 hsla(0,0%,100%,.1)}.navbar-collapse.in{overflow-y:auto}.navbar-fixed-bottom .navbar-collapse,.navbar-fixed-top .navbar-collapse{max-height:340px}.container-fluid>.navbar-collapse,.container-fluid>.navbar-header,.container>.navbar-collapse,.container>.navbar-header{margin-right:-15px;margin-left:-15px}.navbar-fixed-bottom,.navbar-fixed-top{position:fixed;right:0;left:0;z-index:1030}.carousel,.carousel-inner,.navbar-toggle{position:relative}.navbar-fixed-top{top:0;border-width:0 0 1px}.navbar-brand{float:left;height:50px;padding:15px;font-size:18px;line-height:20px}.navbar-brand:focus,.navbar-brand:hover{text-decoration:none}.navbar-toggle{float:right;padding:9px 10px;margin-top:8px;margin-right:15px;margin-bottom:8px;background-color:transparent;background-image:none;border:1px solid transparent;border-radius:4px}.navbar-toggle .icon-bar{display:block;width:22px;height:2px;border-radius:1px}.navbar-toggle .icon-bar+.icon-bar{margin-top:4px}.navbar-nav{margin:7.5px -15px}.navbar-nav>li>a{padding-top:10px;padding-bottom:10px;line-height:20px}.navbar-default{background-color:#f8f8f8;border-color:#e7e7e7}.navbar-default .navbar-brand{color:#777}.navbar-default .navbar-brand:focus,.navbar-default .navbar-brand:hover{color:#5e5e5e;background-color:transparent}.navbar-default .navbar-nav>li>a,.navbar-default .navbar-text{color:#777}.navbar-default .navbar-nav>li>a:focus,.navbar-default .navbar-nav>li>a:hover{color:#333;background-color:transparent}.navbar-default .navbar-toggle{border-color:#ddd}.navbar-default .navbar-toggle:focus,.navbar-default .navbar-toggle:hover{background-color:#ddd}.navbar-default .navbar-toggle .icon-bar{background-color:#888}.navbar-default .navbar-collapse,.navbar-default .navbar-form{border-color:#e7e7e7}.media{margin-top:15px}.media:first-child{margin-top:0}.media,.media-body{overflow:hidden;zoom:1}.media-body{width:10000px}.media-left,.media>.pull-left{padding-right:10px}.media-body,.media-left,.media-right{display:table-cell;vertical-align:top}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;box-shadow:0 1px 1px rgba(0,0,0,.05)}.carousel-control,a{background-color:transparent}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-left-radius:3px;border-top-right-radius:3px}.btn-group-vertical>.btn-group:after,.btn-group-vertical>.btn-group:before,.btn-toolbar:after,.btn-toolbar:before,.clearfix:after,.clearfix:before,.container-fluid:after,.container-fluid:before,.container:after,.container:before,.dl-horizontal dd:after,.dl-horizontal dd:before,.form-horizontal .form-group:after,.form-horizontal .form-group:before,.modal-footer:after,.modal-footer:before,.modal-header:after,.modal-header:before,.nav:after,.nav:before,.navbar-collapse:after,.navbar-collapse:before,.navbar-header:after,.navbar-header:before,.navbar:after,.navbar:before,.pager:after,.pager:before,.panel-body:after,.panel-body:before,.row:after,.row:before{display:table;content:" "}.btn-group-vertical>.btn-group:after,.btn-toolbar:after,.clearfix:after,.container-fluid:after,.container:after,.dl-horizontal dd:after,.form-horizontal .form-group:after,.modal-footer:after,.modal-header:after,.nav:after,.navbar-collapse:after,.navbar-header:after,.navbar:after,.pager:after,.panel-body:after,.row:after{clear:both}.pull-right{float:right}.pull-left{float:left}.hide,.visible-lg,.visible-lg-block,.visible-lg-inline,.visible-lg-inline-block,.visible-md,.visible-md-block,.visible-md-inline,.visible-md-inline-block,.visible-sm,.visible-sm-block,.visible-sm-inline,.visible-sm-inline-block,.visible-xs,.visible-xs-block{display:none}.visible-xs{display:block}.hidden-xs{display:none}.fa{display:inline-block;font:normal normal normal 14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased}.fa.pull-left{margin-right:.3em}.fa-search:before{content:"\f002"}.fa-list:before{content:"\f03a"}.fa-map-marker:before{content:"\f041"}.fa-plus-circle:before{content:"\f055"}.fa-heart-o:before{content:"\f08a"}.fa-phone:before{content:"\f095"}.fa-twitter:before{content:"\f099"}.fa-facebook-f:before,.fa-facebook:before{content:"\f09a"}.fa-google-plus:before{content:"\f0d5"}.fa-envelope:before{content:"\f0e0"}.fa-linkedin:before{content:"\f0e1"}.fa-comment-o:before{content:"\f0e5"}.fa-angle-up:before{content:"\f106"}.fa-instagram:before{content:"\f16d"}.fa-paper-plane:before,.fa-send:before{content:"\f1d8"}.fa-at:before{content:"\f1fa"}.fa-bed:before,.fa-hotel:before{content:"\f236"}.fa-map-o:before{content:"\f278"}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}button,hr,input{overflow:visible}body{margin:0}article,aside,footer,header,nav,section{display:block}h1{font-size:2em;margin:.67em 0}hr{box-sizing:content-box;height:0}a{-webkit-text-decoration-skip:objects}b,strong{font-weight:inherit;font-weight:bolder}img{border-style:none}button,input,optgroup,select,textarea{font-family:sans-serif;font-size:100%;line-height:1.15;margin:0}button,select{text-transform:none}[type=reset],[type=submit],button,html [type=button]{-webkit-appearance:button}textarea{overflow:auto}.socialPlugin .socials{width:260px;color:#fff;line-height:10px;text-align:center;margin-left:-35px;display:block;transform-origin:50% 0;-webkit-transform:scale(0) translateY(-150px);transform:scale(0) translateY(-150px);transition:.5s;opacity:0;margin-top:-90px}.socialPlugin .socials .fa{height:2.5em;overflow:hidden;position:relative;text-decoration:none;width:2.5em;-webkit-backface-visibility:hidden}.socialPlugin .socials .fa:after,.socialPlugin .socials .fa:before{left:0;position:absolute;text-align:center;transition:.5s;top:50%;width:100%}.socialPlugin .socials .fa:before{color:#fff;-webkit-transform:translate3D(0,-50%,0);transform:translate3D(0,-50%,0);z-index:2}.socialPlugin .socials .fa:after{padding-bottom:25%;padding-top:300%;top:0}.socialPlugin .socials .fa-twitter:after{background-image:linear-gradient(#00acee 25%,#fff 75%);content:"\f099";color:#00acee}.socialPlugin .socials .fa-facebook:after{background-image:linear-gradient(#3b5998 25%,#fff 75%);content:"\f09a";color:#3b5998}.socialPlugin .socials .fa-google-plus:after{background-image:linear-gradient(#b00 25%,#fff 75%);content:"\f0d5";color:#b00}[class*=" flaticon-"]:after,[class*=" flaticon-"]:before,[class^=flaticon-]:after,[class^=flaticon-]:before{font-family:Flaticon;font-size:20px;font-style:normal;margin-left:20px}.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9,.input-group .form-control,.navbar-brand{float:right}body,html{direction:rtl}.list-inline{padding-right:0;padding-left:initial;margin-right:-5px;margin-left:0}.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{position:relative;min-height:1px;padding-left:15px;padding-right:15px}.col-xs-12{width:100%}.input-group .form-control:first-child,.input-group-addon:first-child,.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group>.btn,.input-group-btn:first-child>.dropdown-toggle,.input-group-btn:last-child>.btn-group:not(:last-child)>.btn,.input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle){border-radius:0 4px 4px 0}.input-group .form-control:last-child,.input-group-addon:last-child,.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,.input-group-btn:first-child>.btn:not(:first-child),.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group>.btn,.input-group-btn:last-child>.dropdown-toggle{border-radius:4px 0 0 4px}.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group{margin-right:-1px;margin-left:auto}.nav{padding-right:0;padding-left:initial}.navbar-collapse{padding-right:15px;padding-left:15px}.navbar-toggle{float:left;margin-left:15px;margin-right:auto}.media-left,.media>.pull-left{padding-left:10px;padding-right:initial}.carousel-control{right:0;bottom:0}body,button,input,select,textarea{font-family:"Droid Arabic Naskh"}#mainNav ul{list-style:none}*{-o-box-sizing:border-box;box-sizing:border-box}body{background-color:#fff}body,html{overflow-x:hidden}html{width:100vw}::-webkit-input-placeholder{color:#264584}.colored{font-style:normal;color:#264584;line-height:35px;font-weight:700}.banner{color:#fff;transition:all .3s ease-out}.colored:before{font-size:30px}a{text-decoration:none}.banner{padding:10px;position:absolute;top:5px;right:10px;font-weight:700;border-radius:0 5px 0 0;background-color:transparent}#mainNav ul li a:only-child:after,#mainNav ul ul li a:only-child:after{content:""}#mainNav ul li ul,#mainNav ul ul,.hidden-visibility{visibility:hidden}.navbar>.container-fluid{width:90%}#mainNav .navbar-toggle{z-index: 999;margin-left:0;padding-left:0}#mainNav ul a{display:block}.navbar-header .icons a span{color:#fff;font-size:22px}.navbar-header .icons a span.fa-search{position:relative;top:3px}footer{overflow:hidden;color:#d5d5d5;background:#264584;font-size:13px;line-height:22px;padding:30px 0}footer .sub{float:right;width:50%;padding:0 10px 0 20px}footer a{color:#d5d5d5}.alikes>aside{min-height:100px}.alikes .btn{display:block;width:200px;margin:20px auto}.alikes>aside>h3{padding:15px 0;margin:0 0 20px;background-color:#fff}.alikes .alike-item{position:relative;overflow:hidden;margin-bottom:15px;border-radius:5px}.alikes .alike-item img{height:200px;width:100%}.alikes .alike-item .try{padding:2px 10px 2px 15px;position:absolute;z-index:9999;top:10px;right:0;background-color:rgba(38,69,132,.8);font-size:20px;color:#fff;transition:all .3s ease-out;clip-path:polygon(15px 0,100% 0,100% 100%,50% 100%,0 100%);font-family:Montserrat,sans-serif;font-weight:400;font-style:italic}.alikes .alike-item aside{width:100%;transition:all .3s ease-out;position:relative;border-top:0;border-right:0;border-left:0;background-color:#fff}.alikes .alike-item aside h3{color:#fff;background-color:#264584;font-weight:bolder;text-align:left;padding:10px;margin-bottom:20px;font-size:20px;margin-top:0}.alikes .alike-item aside h3 a{color:#fff}.alikes .alike-item aside h3 .social{display:none}.alikes .alike-item aside h3 .share{cursor:pointer}.alikes .alike-item aside p{padding:0 10px;font-size:13.33px;line-height:20px;font-weight:700;text-align:right;direction:rtl;color:#264584;max-height:40px;overflow:hidden}.alikes .alike-item aside ul{list-style:none;color:#264584;display:flex;justify-content:space-around;flex-direction:row-reverse;font-size:10px;padding:5px 0;font-family:Changa;margin-bottom:0}.alikes .alike-item aside ul li{line-height:30px;font-weight:700;font-size:16px}.alikes .alike-item aside ul li img{width:19px;height:19px;display:block}.alikes .alike-item aside ul li span{line-height:26px;font-size:20px;display:block;text-align:center}.alikes .alike-item aside ul li span:before{line-height:30px;font-size:20px;margin-left:2px}.alikes .alike-item aside button{width:120px;margin:10px auto;display:block;background-color:#264584;color:#fff;padding:10px;border-radius:10px;border:0;outline:0;font-family:Changa}form.amp-form-submit-error [submit-error],form.amp-form-submit-success [submit-success]{margin-top:16px}form.amp-form-submit-success [submit-success]{color:green}form.amp-form-submit-error [submit-error]{color:red}form.amp-form-submit-success.hide-inputs>input{display:none}.callus-phone{text-align:center;color:#fff;font-size:18px;padding:5px;text-shadow:0 2px 5px rgba(0,0,0,.9);background:#314755;background:-webkit-linear-gradient(to right,#314755,#26a0da);background:linear-gradient(to right,#314755,#26a0da)}.whatsapp-pulse,.whatsapp-pulse:hover{color:#fff}.whatsapp-pulse{position:fixed;width:50px;height:50px;background:#42ce6c;color:#fff;border-radius:50%;text-align:center;line-height:50px;font-size:48px;z-index:999999999;right:80px;top:10px}.whatsapp-icon{position:relative;display:block;right:inherit;top:inherit;margin:auto}.whatsapp-pulse i.fa.fa-whatsapp{font-size:35px}.whatsapp-pulse:after,.whatsapp-pulse:before{content:'';display:block;position:absolute;border:50%;border:1px solid #009688;left:-20px;right:-20px;top:-20px;bottom:-20px;border-radius:50%;animation:animatepulse 1.5s linear infinite;opacity:0}.whatsapp-pulse:after{animation-delay:.5s}@keyframes animatepulse{0%{transform:scale(.5);opacity:0}50%{opacity:1}100%{transform:scale(1.2);opacity:0}}h1,h2,h3,h4,h5,h6{font-family:Changa}.results-container .container{padding-left:15px;background-color:#e9ebee}.floating-message-inline{margin:20px 0}.floating-message-inline .header-contactform{width:100%;margin:auto;background-color:#fff;padding:10px 0 0 0;border-radius:10px;border:0;margin-top:20px}.floating-message-inline .header-contactform h4{font-size:20px;margin:0;padding:0;font-weight:700;color:#264584;border:0;font-family:'29LTBukra-Bold'}.floating-message-inline .header-contactform .form-group{margin-bottom:10px}.floating-message-inline .header-contactform .form-group .form-control,.form-section .form1 .form-group .form-control{height:40px;margin-bottom:0;border:0;border-radius:5px 0 0 5px;border-right:6px solid #1f3a73;color:#1f3a73;background-color:#e9ebee;border-radius:0 0 0 15px}.floating-message-inline .header-contactform .form-group textarea.form-control{height:100px}.floating-message-inline .form-control::-webkit-input-placeholder,.formindex .form-control::-webkit-input-placeholder{color:hsla(0,0%,100%,.8)}.col-xs-6{width:50%}.pl5{padding-left:5px}.pr5{padding-right:5px}header{margin-top:60px}::-webkit-input-placeholder{color:#cbdfe6}::-moz-placeholder{color:#cbdfe6}:-ms-input-placeholder{color:#cbdfe6}:-moz-placeholder{color:#cbdfe6}.blog-heading{font-family:'29LTBukra-Bold';font-size:20px;line-height:30px;text-align:center;margin:30px 0 10px 0}.blog-heading:after{display:none}.colored{font-style:normal;color:#264584;line-height:35px;font-weight:700}.colored a{color:#264584}.clearboth{clear:both}div.send button.send{background:transparent;border:0px;outline: none}.horiz_scroll{background-color:#e9ebee;height:464px;border:1px solid #e9ebee;overflow-x:auto;}
        </style>

        <!-- Google Tag Manager -->
        <!--<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-NQMR57V');</script>-->
        <!-- End Google Tag Manager -->

    </head>
    <body id="page-top">

        <!-- Google Tag Manager (noscript) -->
        <!--<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQMR57V"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>-->
        <!-- End Google Tag Manager (noscript) -->

        <!-- start nav -->
        <nav class="navbar navbar-default navbar-fixed-top" id="mainNav">
            <div class="container-fluid">
                <div class="navbar-header navbar-left">
                    <button on="tap:sidebar.toggle" type="button" class="navbar-toggle ampstart-btn caps m2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar num1"></span>
                        <span class="icon-bar num2"></span>
                        <span class="icon-bar num3"></span>
                    </button>
                    <div class="icons">
                        <a class="pull-right amp-whatsapp-icon" href="{{ Helper::whatsapp_share($infos->tel_1,$infos->whatsapp_share) }}?icon=1">
                            <span class="flaticon-app"></span>
                        </a>
                        <a class="pull-right" href="<?= route("front.search") . "/property-for-sale/turkey"; ?>">
                            <amp-img src="<?= asset('img/home_search.png') ?>" width="30" height="30" alt='home_search'></amp-img>
                        </a>
                        <!--<a class="pull-right" href="">
                            <span class="fa fa-search"></span>
                        </a>-->


                        <amp-accordion class="sample amp-section-search" disable-session-states>
                            <section>
                                <h5 class="accordionheader">
                                    <span class="show-more"><i class="fa fa-search"></i></span>
                                    <span class="show-less"><i class="fa fa-search"></i></span>
                                </h5>
                                <div class="accordcontent">
                                    <form target="_top" action="<?= route('front.searchpage') ?>" method="GET" class="quick-search mx2">
                                        <div class="ampstart-input">
                                            <input type="text" value="" name="s"  class="block" placeholder="{{trans('front.search')}}">
                                        </div>
                                        <div>
                                            <button type="submit">
                                                <span class="flaticon-magnifying-glass" id="btnFilter"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </section>
                        </amp-accordion>


                    </div>
                    <a class="navbar-brand" href="<?= route("front.index"); ?>"><amp-img src="<?= asset("img/damas-logo.svg"); ?>" width="104" height="33" alt='logo'></amp-img></a>
                </div>

            </div>
        </nav>


    <amp-sidebar id="sidebar" class='amp-sidebar' layout="nodisplay" side="left">
        <button class="amp-close-image" on="tap:sidebar.close"><i class="fa fa-close"></i></button>

        <ul class="amp-telephone-list">
            <li><a href="tel:+905551605000" class="bluring"><i class="fa fa-phone"></i><p>+90 555 160 5000 </p><span class="arabic">للعملاء العرب</span></a></li> 
            <li><a href="tel:+905541869003" class="bluring"><i class="fa fa-phone"></i><p>+90 554 186 90 03</p><span>Satış Ofisi iseniz</span></a></li> 
        </ul>

        <amp-accordion disable-session-states>



            <?php
            /* display only on mobile */
            echo Helper::menu_tree_front_mobile_amp(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", $current_locale]])->toArray());
            ?>

        </amp-accordion>

        <!-- <?= Helper::menu_tree_front(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", $current_locale]])->toArray()); ?> -->

        <ul class="ampstart-social-follow list-reset flex justify-around items-center flex-wrap m0 mb4 mx2 social-follow-icon">
            <li>
                <a href="https://www.facebook.com/damasturk/" target="_blank" aria-label="Link to AMP HTML Facebook">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            <li>
                <a href="https://twitter.com/damasturk" target="_blank" aria-label="Link to AMP HTML Twitter">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/damasturk/" target="_blank" aria-label="Link to AMP HTML Instagram">
                    <i class="fa fa-instagram"></i>
                </a>
            </li>
            <li>
                <a href="https://www.youtube.com/damasturk" target="_blank" aria-label="Link to AMP HTML pin trest">
                    <i class="fa fa-youtube"></i>
                </a>
            </li>
            <li>
                <a href="https://api.whatsapp.com/send?phone=905551605000" target="_blank" aria-label="Link to AMP HTML pin trest">
                    <i class="fa fa-whatsapp"></i>
                </a>
            </li>
        </ul>

    </amp-sidebar>
    <!-- end nav -->


    <!-- Start Content -->
    <div class="topPhoto">
        <amp-img src="<?= asset('/img/topPhoto2.png') ?>" width="300" height="200" layout="responsive" alt="Citizenship" ></amp-img>
        <div class="section-text"><div class="icon-bg"></div><p>تملك في تركيا<br>واحصل على<br><strong>الجنسية التركية</strong></p></div> 
    </div>

    <div class="big-content">
        <div class="photo-content">
            <amp-img class="passport" width="150" height="222" layout="responsive" src="<?= asset('/img/passport-new.png') ?>" alt="Citizenship"></amp-img>
            <amp-img class="pricePhoto" width="190" height="230" layout="responsive" src="<?= asset('/img/pricePhoto.svg') ?>" alt="Citizenship"></amp-img>
        </div>

        <!-- Srart Firt Timeline -->
        <div class="new-content">
            <h2>آخر تحديثات قانون<br>الجنسية التركية من خلال التملك</h2>
            <!-- Starting TimeLine -->
            <div class="timeline">
                <div class="cont">
                    <div class="title"><div class="luster"></div><span>صدور قانون التجنيس</span></div>
                    <div class="icon"><div class="icon-bg"></div></div>
                    <div class="date">September<br><strong>2018</strong></div>
                    <p>
                        الرئيس التركي يصدر قراراً يمنح الأجانب المتملكين عقاراً <strong>جاهزاً</strong> بقيمة 250 ألف دولار الحق بالحصول على الجنسية التركية ابتداءً من تاريخ 19/09/2018
                    </p>
                </div>

                <div class="cont">
                    <div class="title"><div class="luster"></div><span>العقارات قيد الإنشاء</span></div>
                    <div class="icon"><div class="icon-bg"></div></div>
                    <div class="date">December<br><strong>2018</strong></div>
                    <p>
                        صدور تعديل جديد يمنح الأجانب المتملكين عقاراً <strong>قيد الإنشاء</strong> بقيمة 250 ألف دولار الحق بالحصول على الجنسية التركية ابتداءً من تاريخ 19/09/2018
                    </p>
                </div>

                <div class="cont">
                    <div class="title"><div class="luster"></div><span>تملك الفلسطينيين</span></div>
                    <div class="icon"><div class="icon-bg"></div></div>
                    <div class="date">March<br><strong>2019</strong></div>
                    <p>
                        صدور قرار جديد يمنح الفلسطينيين الحاملين لوثائق سفر الحق بالتملك والحصول على الجنسية التركية.
                    </p>
                </div>

                <div class="cont">
                    <div class="title"><div class="luster"></div><span>تسهيلات جديدة</span></div>
                    <div class="icon"><div class="icon-bg"></div></div>
                    <div class="date">June<br><strong>2019</strong></div>
                    <p>
                        صدور تسهيلات جديدة تمنح أصحاب العقارات الحاصلين على صك التمليك بعد صدور القرار الحق بالتقدم للحصول على الجنسية التركية.
                    </p>
                </div>

                <div class="point-top"></div>
                <div class="point-bottom"></div>

            </div><!-- Ending TimeLine -->
        </div>
        <!-- End First Timeline -->


        <!-- Start Tabs -->
        <div class="new-content">
            <amp-selector class="tabs-with-flex"
                          role="tablist">
                <div id="tab1" role="tab" aria-controls="tabpanel1" option selected>القرار 1</div>
                <div id="tabpanel1" role="tabpanel" aria-labelledby="tab1">
                    <amp-img width="150" height="200" layout="responsive" class="decision-photo" src="<?= Helper::media_url($page->nationalitydecisionmedia1) ?>" alt="Decision"></amp-img>
                    <div class="decision-arabic">
                        <p><?php
                            $post = Helper::query("Post", "where", ["field" => "id", "value" => $page->nationality_decision1_trans])->first();
                            if ($post)
                                echo preg_replace("/<img[^>]+\>/i", "", html_entity_decode($post->getContent()));
                            ?></p>
                    </div>
                </div>

                <div id="tab2" role="tab" aria-controls="tabpanel2" option>القرار 2</div>
                <div id="tabpanel2" role="tabpanel" aria-labelledby="tab2">
                    <amp-img width="150" height="200" layout="responsive" class="decision-photo" src="<?= Helper::media_url($page->nationalitydecisionmedia2) ?>" alt="Decision"></amp-img>
                    <div class="decision-arabic">
                        <p><?php
                            $post = Helper::query("Post", "where", ["field" => "id", "value" => $page->nationality_decision2_trans])->first();
                            if ($post)
                                echo preg_replace("/<img[^>]+\>/i", "", html_entity_decode($post->getContent()));
                            ?></p>
                    </div>
                </div>

                <div id="tab3" role="tab" aria-controls="tabpanel3" option>القرار 3</div>
                <div id="tabpanel3" role="tabpanel" aria-labelledby="tab3">
                    <amp-img width="150" height="200" layout="responsive" class="decision-photo" src="<?= Helper::media_url($page->nationalitydecisionmedia3) ?>" alt="Decision"></amp-img>
                    <div class="decision-arabic">
                        <p><?php
                            $post = Helper::query("Post", "where", ["field" => "id", "value" => $page->nationality_decision3_trans])->first();
                            if ($post)
                                echo preg_replace("/<img[^>]+\>/i", "", html_entity_decode($post->getContent()));
                            ?></p>
                    </div>
                </div>

                <div id="tab4" role="tab" aria-controls="tabpanel4" option>القرار 4</div>
                <div id="tabpanel4" role="tabpanel" aria-labelledby="tab4">
                    <amp-img width="150" height="200" layout="responsive" class="decision-photo" src="<?= Helper::media_url($page->nationalitydecisionmedia4) ?>" alt="Decision"></amp-img>
                    <div class="decision-arabic">
                        <p><?php
                            $post = Helper::query("Post", "where", ["field" => "id", "value" => $page->nationality_decision4_trans])->first();
                            if ($post)
                                echo preg_replace("/<img[^>]+\>/i", "", html_entity_decode($post->getContent()));
                            ?></p>
                    </div>
                </div>

            </amp-selector>
        </div>
        <!-- End Tabs -->


        <!-- Start First Slider Project -->
        <div class="new-content project-slider">
            <h2>مشاريع مجمعات شقق<br>متوافقة مع قانون الجنسية</h2>
			<?php
			$project_cat = Helper::query("ProjectCategory", "whereIn", ["field" => "slug", "value" => ['sea-views', 'luxury-real-estate']])->get();
			$q = \App\Models\Project::where("published", 1);
			foreach ($project_cat as $project_cat_row)
				$q->whereIn("id", function($q_pf) use ($project_cat_row) {
					$q_pf->select("project_id")->from("project_category")->where("project_category_id", $project_cat_row->id);
				});
			$q->orderBy("created_at", "desc");
			$projects = $q->get();
			?>
<div class="alikes horiz_scroll">
	@foreach($projects as $prj)
		<aside class="col-md-4 col-sm-6 col-xs-12">
			@include("amp.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
		</aside>
	@endforeach
</div>

        </div>
        <!-- End First Slider Project -->

        <!-- Start Shear icons -->
        <div class="shareSection">
            <p>شارك هذا الصفحة مع أصدقائك!</p>
            <amp-social-share class="rounded" type="facebook" data-param-app_id="254325784911610" width="48" height="48"></amp-social-share>
            <amp-social-share class="rounded" type="twitter" width="48" height="48"></amp-social-share>
            <amp-social-share class="rounded" type="whatsapp" width="48" height="48"></amp-social-share>
        </div>
        <!-- End Shear icons -->


        <!-- Start Customers service Form -->
        <div class="new-content">
            <h2>تواصل مع أحد مستشارينا واحصل على تفاصيل أكثر واستشارة مجانية</h2>
			
			@include("amp.partials.callus_consulting_department", ['place'=>'Body',"form_type" => "citizenship - consulting department"])
            
        </div>
        <!-- End Customers service Form -->



        <!-- Srart Required Documents -->
        <div class="required-documents">
            <amp-img width="400" height="400" layout="responsive" class="required-documents-bg" src="<?= asset('/img/required-documents-bg.png') ?>" alt="arrow"></amp-img>
            <div class="icon-bg"></div>
            <h2>المستندات المطلوبة للحصول<br>على الجنسية التركية للمستثمرين</h2>
            <ul>
                <li><span class="check-icon icon-bg"></span><p>جواز سفر مقدم الطلب</p></li>
                <li><span class="check-icon icon-bg"></span><p>شهادة الميلاد</p></li>
                <li><span class="check-icon icon-bg"></span><p>شهادة تصف الحالةالمدنية لمقدم الطلب</p></li>
                <li><span class="check-icon icon-bg"></span><p>وثيقة تثبت الرابطة العائلية للمتزوجين</p></li>
                <li><span class="check-icon icon-bg"></span><p>لا حكم عليه</p></li>
                <li><span class="check-icon icon-bg"></span><p>صور بيرومترية حديثة عدد 6</p></li>
                <li><span class="check-icon icon-bg"></span><p>إيصال دفع رسوم الطلب</p></li>
                <li><span class="check-icon icon-bg"></span><p>تأمين صحي</p></li>
                <li><span class="check-icon icon-bg"></span><p>شهادة مطابقة</p></li>
            </ul>
        </div>
        <!-- End Required Documents -->



        <!-- Srart Steps to progress on Turkish nationality-->
        <div class="new-content steps-to-progress">
            <h2>خطوات التقدم على الجنسية<br>التركية من خلال التملك</h2>
            <div class="timeline-steps">
                <amp-img width="19" height="26" layout="responsive" class="flag-pole-top" src="<?= asset('/img/flag-pole-top.png') ?>" alt="Flag Pole Top"></amp-img>
                <amp-img width="19" height="26" layout="responsive" class="flag-pole-bottom" src="<?= asset('/img/flag-pole-bottom.png') ?>" alt="Flag Pole Bottom"></amp-img>

                <div class="item one">
                    <amp-img width="160" height="75" layout="responsive" class="stamp" src="<?= asset('/img/stamp-1.jpg') ?>" alt="stamp"></amp-img>
                    <amp-img width="67" height="81" layout="responsive" class="date-photo" src="<?= asset('/img/date-photo-one.png') ?>" alt="date photo"></amp-img>
                    <amp-img width="300" height="75" layout="responsive" class="arrow-white-bottom" src="<?= asset('/img/arrow-white-bottom2.png') ?>" alt="arrow"></amp-img>
                    <span class="date-title"><strong>15</strong>يوم</span>
                    <div class="title">
                        <amp-img width="300" height="66" layout="responsive" src="<?= asset('/img/arrow-title-one.png') ?>" alt="arrow"></amp-img>
                        <span>الحصول على شهادة المطابقة</span>
                        <strong>(السجل العقاري)</strong>
                    </div>
                    <div class="sub-title">
                        <amp-img width="300" height="66" layout="responsive" src="<?= asset('/img/arrow-subTitle-one.png') ?>" alt="arrow"></amp-img>
                        <div class="number-list">
                            <span class="active"><strong>1</strong></span>
                            <span><strong>2</strong></span>
                            <span><strong>3</strong></span>
                        </div>
                    </div>

                    <div class="section-contents">
                        <div class="all-content">
                            <p>
                                <?= $page->steps_progress_nationality1 ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="item one">
                    <amp-img width="160" height="75" layout="responsive" class="stamp" src="<?= asset('/img/stamp-1.jpg') ?>" alt="stamp"></amp-img>
                    <amp-img width="67" height="81" layout="responsive" class="date-photo" src="<?= asset('/img/date-photo-one.png') ?>" alt="date photo"></amp-img>
                    <amp-img width="300" height="75" layout="responsive" class="arrow-white-bottom" src="<?= asset('/img/arrow-white-bottom2.png') ?>" alt="arrow"></amp-img>
                    <span class="date-title"><strong>15</strong>يوم</span>
                    <div class="title">
                        <amp-img width="300" height="66" layout="responsive" src="<?= asset('/img/arrow-title-one.png') ?>" alt="arrow"></amp-img>
                        <span>الحصول على إقامة مستثمر</span>
                        <strong>(دائرة الهجرة)</strong>
                    </div>
                    <div class="sub-title">
                        <amp-img width="300" height="66" layout="responsive" src="<?= asset('/img/arrow-subTitle-one.png') ?>" alt="arrow"></amp-img>
                        <div class="number-list">
                            <span><strong>1</strong></span>
                            <span class="active"><strong>2</strong></span>
                            <span><strong>3</strong></span>
                        </div>
                    </div>

                    <div class="section-contents">
                        <div class="all-content">
                            <p>
                                <?= $page->steps_progress_nationality2 ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="item one">
                    <amp-img width="160" height="75" layout="responsive" class="stamp" src="<?= asset('/img/stamp-2.jpg') ?>" alt="stamp"></amp-img>
                    <amp-img width="67" height="81" layout="responsive" class="date-photo" src="<?= asset('/img/date-photo-one.png') ?>" alt="date photo"></amp-img>
                    <amp-img width="300" height="75" layout="responsive" class="arrow-white-bottom" src="<?= asset('/img/arrow-white-bottom2.png') ?>" alt="arrow"></amp-img>
                    <span class="date-title"><strong>15</strong>يوم</span>
                    <div class="title">
                        <amp-img width="300" height="66" layout="responsive" src="<?= asset('/img/arrow-title-one.png') ?>" alt="arrow"></amp-img>
                        <span>التقديم على الجنسية التركية</span>
                        <strong>(النفوس العامة)</strong>
                    </div>
                    <div class="sub-title">
                        <amp-img width="300" height="66" layout="responsive" src="<?= asset('/img/arrow-subTitle-one.png') ?>" alt="arrow"></amp-img>
                        <div class="number-list">
                            <span><strong>1</strong></span>
                            <span><strong>2</strong></span>
                            <span class="active"><strong>3</strong></span>
                        </div>
                    </div>

                    <div class="section-contents">
                        <div class="all-content">
                            <p>
                                <?= $page->steps_progress_nationality3 ?>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="item result-steps">
                    <amp-img width="170" height="146" layout="responsive" class="result_steps-hand" src="<?= asset('/img/arrow-result-steps.png') ?>" alt="result_steps-hand"></amp-img>
                    <div class="text">
                        <span><strong>يوماً</strong> <strong>45</strong></span>
                        <p>للحصول على<br>الجنسية التركية</p>
                    </div>
                    <div class="int-content">
                        <amp-img width="27" height="137" layout="responsive" class="arrow-right-transparent-blue" src="<?= asset('/img/arrow-right-transparent-blue.png') ?>" alt="result_steps-hand"></amp-img>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Steps to progress on Turkish nationality -->



        <!-- Start Second Slider Project -->
        <div class="new-content project-slider">
            <h2>مشاريع مجمعات فلل<br>متوافقة مع قانون الجنسية</h2>
            <?php
			$q = \App\Models\Project::where("published", 1);
			$project_type_row = Helper::query("ProjectType", "where", ["field" => "slug", "value" => 'villas-for-sale'])->first();
			$q->whereIn("id", function($q_typ) use ($project_type_row) {
				$q_typ->select("project_id")->from("project_type")->where("project_type_id", $project_type_row->id);
			});
			$city_row = Helper::query("City", "where", ["field" => "slug", "value" => 'istanbul'])->first();
			$q->where("city_id", $city_row->id);
			$q->orderBy("created_at", "desc");
			$projects = $q->get();
			?>
<div class="alikes horiz_scroll">
	@foreach($projects as $prj)
		<aside class="col-md-4 col-sm-6 col-xs-12">
			@include("amp.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
		</aside>
	@endforeach
</div>

        </div>
        <!-- End Second Slider Project -->

        <!-- Start Shear icons -->
        <div class="shareSection">
            <p>شارك هذا الصفحة مع أصدقائك!</p>
            <amp-social-share class="rounded" type="facebook" data-param-app_id="254325784911610" width="48" height="48"></amp-social-share>
            <amp-social-share class="rounded" type="twitter" width="48" height="48"></amp-social-share>
            <amp-social-share class="rounded" type="whatsapp" width="48" height="48"></amp-social-share>
        </div>
        <!-- End Shear icons -->



        <!-- Start Customers service Form -->
        <div class="new-content">
            <h2>تواصل مع أحد مستشارينا واحصل على تفاصيل أكثر واستشارة مجانية</h2>
            @include("amp.partials.callus_consulting_department", ['place'=>'Body',"form_type" => "citizenship - consulting department"])
        </div>
        <!-- End Customers service Form -->



        <!-- Srart Required Documents -->
        <div class="required-documents red-section">
            <amp-img width="360" height="725" layout="responsive" class="RedBG" src="<?= asset('/img/RedBG.png') ?>" alt="arrow"></amp-img>
            <div class="icon-bg flagW"></div>
            <h2>قوة الجواز التركي</h2>
            <ul>
                <li><span class="check-icon icon-bg"></span><p>الدخول الى 72 بلد بدون فيزا وإلى 44 دولة بفيزا فورية عند
                        الوصول إلى المطار و الدخول إلى أكثر من 7 دول
                        بموجب تأشيرة إلكترونية تصدر على الإنترنت.</p></li>
                <li><span class="check-icon icon-bg"></span><p>يحلّ جواز السفر التركي في المرتبة الـ37 عالمياً وفق
                        تصنيف عام 2019.</p></li>
                <li><span class="check-icon icon-bg"></span><p>يخول حامله الحصول على كامل الحقوق الطبية.
                    </p></li>
                <li><span class="check-icon icon-bg"></span><p>يخول حامله الاستفادة ﻣن برامج التقاعد كمواطن تركي.</p></li>
                <li><span class="check-icon icon-bg"></span><p>يوفر التعليم المجاني وخطط دفع للجامعة.</p></li>
                <li><span class="check-icon icon-bg"></span><p>يعطي حقوق التصويت لجميع أنواع الانتخابات.</p></li>
                <li><span class="check-icon icon-bg"></span><p>يسمح بازدواجية الجنسية للذين يحملون جوازات سفر غير تركية.</p></li>
                <li><span class="check-icon icon-bg"></span><p>له صلاحية لمدة 10 سنوات ويكون متجدداً مدى الحياة.</p></li>
                <li><span class="check-icon icon-bg"></span><p>جوازات السفر التي أصدرت منذ 1 يونيو 2010 هي
                        جوازات سفر إلكترونية.</p></li>
            </ul>
        </div>
        <!-- End Required Documents -->



        <!-- Start Section Map -->
        <div class="new-content section-map">
            <div class="top-title">
                <amp-img  width="90" height="132" layout="responsive" class="passport" src="<?= asset('/img/passport-new.png') ?>" alt="passport"></amp-img>
                <div class="text">
                    <h2>قوة الجواز التركي 2019: </h2>
                    <ul>
                        <li>
                            <span>بدون فيزا</span>
                            <div class="pointer green"><span><strong>72</strong> <strong>دولة</strong></span></div>
                        </li>
                        <li>
                            <span>فيزا بالمطار</span>
                            <div class="pointer blue"><span><strong>44</strong> <strong>دولة</strong></span></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <amp-img  width="360" height="215" layout="responsive" class="map" src="<?= asset('/img/map.svg') ?>" alt="Map"></amp-img>
        <!-- End Section Map  -->


        <!-- Start Section Countries -->
        <div class="new-content">
            <h2>أبرز الدول التي لا تحتاج إلى فيزا</h2>
            <ul class="countries">
                <li><div class="icon-bg"></div><span>روسيا</span></li>
                <li><div class="icon-bg"></div><span>اليابان</span></li>
                <li><div class="icon-bg"></div><span>سينغافورة</span></li>
                <li><div class="icon-bg"></div><span>كوريا الجنوبية</span></li>
            </ul>
        </div>
        <!-- End Section Countries  -->
        <!-- Start Section Countries -->
        <div class="new-content">
            <h2>الجنسيات التي لا يشملها قانون<br>التجنيس من خلال التملك</h2>

            <ul class="countries two">
                <li><div class="icon-bg"></div><span>سوريا</span></li>
                <li><div class="icon-bg"></div><span>كوريا الشمالية</span></li>
                <li><div class="icon-bg"></div><span>كوبا</span></li>
                <li><div class="icon-bg"></div><span>أرمينيا</span></li>
            </ul>
        </div>
        <!-- End Section Countries  -->
        <!-- Start Section Countries -->
        <div class="new-content">
            <h2>الجنسيات العربية الأكثر إقبالا<br>على الجنسية التركية</h2>

            <ul class="countries three">
                <li><div class="icon-bg"></div><span>اليمن</span></li>
                <li><div class="icon-bg"></div><span>الأردن</span></li>
                <li><div class="icon-bg"></div><span>فلسطين</span></li>
                <li><div class="icon-bg"></div><span>مصر</span></li>
            </ul>
        </div>
        <!-- End Section Countries  -->
        <!-- Start Section Percentage of sales -->
        <div class="new-content progress">
            <h2>نسبة ارتفاع مبيعات العقارات<br>آخر ثلاث أعوام</h2>
            <div class="col-xs-12">
                <div class="progress-circle" data-progress="50"><span>2018</span></div>
            </div>
            <div class="progress-circle" data-progress="75"><span>2017</span></div>
            <div class="progress-circle" data-progress="25"><span>2016</span></div>
        </div>
        <!-- End Section Percentage of sales  -->



        <!-- Start Third Slider Project -->
        <div class="new-content project-slider">
            <h2>مشاريع محلات تجارية<br>متوافقة مع قانون الجنسية</h2>
            <?php
			$q = \App\Models\Project::where("published", 1);
			$project_type_row = Helper::query("ProjectType", "where", ["field" => "slug", "value" => 'shops-for-sale'])->first();
			$q->whereIn("id", function($q_typ) use ($project_type_row) {
				$q_typ->select("project_id")->from("project_type")->where("project_type_id", $project_type_row->id);
			});
//$city_row = Helper::query("City", "where", ["field" => "slug", "value" => 'istanbul'])->first();
			$q->where("city_id", $city_row->id);
			$q->orderBy("created_at", "desc");
			$projects = $q->get();
			?>
<div class="alikes horiz_scroll">
	@foreach($projects as $prj)
		<aside class="col-md-4 col-sm-6 col-xs-12">
			@include("amp.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
		</aside>
	@endforeach
</div>
        </div>
        <!-- End Third Slider Project -->


        <!-- Start Shear icons -->
        <div class="shareSection">
            <p>شارك هذا الصفحة مع أصدقائك!</p>
            <amp-social-share class="rounded" type="facebook" data-param-app_id="254325784911610" width="48" height="48"></amp-social-share>
            <amp-social-share class="rounded" type="twitter" width="48" height="48"></amp-social-share>
            <amp-social-share class="rounded" type="whatsapp" width="48" height="48"></amp-social-share>
        </div>
        <!-- End Shear icons -->




        <!-- Start Customers service Form -->
        <div class="new-content">
            <h2>تواصل مع أحد مستشارينا واحصل على تفاصيل أكثر واستشارة مجانية</h2>
            @include("amp.partials.callus_consulting_department", ['place'=>'Body',"form_type" => "citizenship - consulting department"])
        </div>
        <!-- End Customers service Form -->



    </div>
    <!-- End Content -->




<div class="new-content">
@include("amp.partials.about_damass_mob")
</div>
   


    <footer>
        <div class="container">
            <div class="row">

                <div class="clearfix"></div><br><br>
                <div class="text-center">
                    <a href="<?= url('/'); ?>">
                        <amp-img src="<?= asset("img/damasGroupLogoD.svg"); ?>" width="160" height="50"></amp-img><br><br>
                    </a>
                    <p><?= trans("front.copyright"); ?> <a href="<?= route("front.index"); ?>"><?= trans("front.company name"); ?></a> <?= date('Y'); ?></p>
                </div>

            </div>

        </div>
    </footer>

    @yield('schemaorg') 

</body>
</html>