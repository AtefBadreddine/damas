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
    
    @if(@$page_keywords)
    <meta name="keywords" content="<?= $page_keywords; ?>">
    @endif
    <meta name="msvalidate.01" content="CC5D396D64E6055F8BBAAB11324D7AEF" />    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Changa">
    <link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/droidarabicnaskh.css">
    
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    
    <script async custom-element="amp-form" src="https://cdn.ampproject.org/v0/amp-form-0.1.js"></script>
    <script async custom-template="amp-mustache" src="https://cdn.ampproject.org/v0/amp-mustache-0.2.js"></script>
    <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
    <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
        
    <style amp-custom>
        .section_links_bottom {padding:40px 0;background:#fafafa;position:relative;}
        @font-face {
            font-family: "Flaticon";
            src: url("<?= asset("ampcss/Flaticon.eot"); ?>");
            src: url("<?= asset("ampcss/Flaticon.eot"); ?>?#iefix") format("embedded-opentype"),
               url("<?= asset("ampcss/Flaticon.woff"); ?>") format("woff"),
               url("<?= asset("ampcss/Flaticon.ttf"); ?>") format("truetype"),
               url("<?= asset("ampcss/Flaticon.svg#Flaticon"); ?>") format("svg");
            font-weight: normal;
            font-style: normal;
        }
        @media screen and (-webkit-min-device-pixel-ratio:0) {
          @font-face {
            font-family: "Flaticon";
            src: url("<?= asset("ampcss/Flaticon.svg#Flaticon"); ?>") format("svg");
          }
        }
        @font-face {
          font-family: 'logo';
          src:  url('<?= asset("ampfonts/logo.eot?6dipm4"); ?>');
          src:  url('<?= asset("ampfonts/logo.eot?6dipm4#iefix"); ?>') format('embedded-opentype'),
            url('<?= asset("ampfonts/logo.ttf?6dipm4"); ?>') format('truetype'),
            url('<?= asset("ampfonts/logo.woff?6dipm4"); ?>') format('woff'),
            url('<?= asset("ampfonts/logo.svg?6dipm4#logo"); ?>') format('svg');
          font-weight: normal;
          font-style: normal;
        }
        /*Plugins*/
        *,.intl-tel-input input,:after,:before{box-sizing:border-box}hr,img{border:0}.form-control,body{background-color:#fff;font-family:"Droid Arabic Naskh";}.btn,img{vertical-align:middle}.collapsing,.glyphicon,.input-group,.input-group .form-control,.input-group-btn,.input-group-btn>.btn,.nav>li,.nav>li>a,.navbar{position:relative}.form-control:focus,.navbar-toggle:focus,a:active,a:hover{outline:0}.carousel-caption,.carousel-control{text-shadow:0 1px 2px rgba(0,0,0,.6);text-align:center}.fa,.glyphicon{-moz-osx-font-smoothing:grayscale}.btn,.intl-tel-input .flag-dropdown,.likeCardItem,.showSocialButtons,[role=button]{cursor:pointer}html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}article,aside,details,figcaption,figure,footer,header,hgroup,main,menu,nav,section,summary{display:block}button,input,optgroup,select,textarea{font:inherit;color:inherit}button,html input[type=button],input[type=reset],input[type=submit]{-webkit-appearance:button;cursor:pointer}.glyphicon{top:1px;display:inline-block;font-family:Glyphicons Halflings;font-style:normal;font-weight:400;line-height:1;-webkit-font-smoothing:antialiased}.glyphicon-chevron-left:before{content:"\e079"}.glyphicon-chevron-right:before{content:"\e080"}html{font-size:10px;-webkit-tap-highlight-color:transparent}body{font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:14px;line-height:1.42857143;color:#333}a{color:#337ab7;text-decoration:none}a:focus,a:hover{color:#23527c;text-decoration:underline}.carousel-inner>.item>a>img,.carousel-inner>.item>img,.img-responsive,.thumbnail a>img,.thumbnail>img{display:block;max-width:100%;height:auto}hr{margin-top:20px;margin-bottom:20px;border-top:1px solid #eee}.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6{font-family:inherit;font-weight:500;line-height:1.1;color:inherit}.h1,.h2,.h3,h1,h2,h3{margin-top:20px;margin-bottom:10px}.h4,.h5,.h6,h4,h5,h6{margin-top:10px;margin-bottom:10px}.h1,h1{font-size:36px}.h2,h2{font-size:30px}.h3,h3{font-size:24px}.h4,h4{font-size:18px}.btn,.form-control,output{font-size:14px;line-height:1.42857143}p{margin:0 0 10px}.text-center{text-align:center}ol,ul{margin-top:0;margin-bottom:10px}ol ol,ol ul,ul ol,ul ul{margin-bottom:0}.list-inline,.list-unstyled{padding-left:0;list-style:none}.list-inline{margin-left:-5px}.list-inline>li{display:inline-block;padding-right:5px;padding-left:5px}.container,.container-fluid{padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto}.row{margin-right:-15px;margin-left:-15px}.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{position:relative;min-height:1px;padding-right:15px;padding-left:15px}.btn,.form-control{padding:6px 12px;background-image:none}.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{float:left}.col-xs-12{width:100%}.form-control,output{display:block;color:#555}.form-control{width:100%;border:1px solid #ccc;border-radius:4px;box-shadow:inset 0 1px 1px rgba(0,0,0,.075);transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out}.form-control:focus{border-color:#66afe9;box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 8px rgba(102,175,233,.6)}.form-control::-webkit-input-placeholder{color:#999}textarea.form-control{height:auto}.form-group{margin-bottom:15px}.btn,.nav{margin-bottom:0}.btn{display:inline-block;font-weight:400;text-align:center;white-space:nowrap;-ms-touch-action:manipulation;touch-action:manipulation;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;border:1px solid transparent;border-radius:4px}.btn.focus,.btn:focus,.btn:hover{color:#333;text-decoration:none}.btn-primary{color:#fff;background-color:#337ab7;border-color:#2e6da4}.btn-primary.active,.btn-primary:active,.btn-primary:hover,.open>.dropdown-toggle.btn-primary{color:#fff;background-color:#286090;border-color:#204d74}.btn-group-lg>.btn,.btn-lg{padding:10px 16px;font-size:18px;line-height:1.3333333;border-radius:6px}.btn-block{display:block;width:100%}.collapse{display:none}.collapse.in{display:block}.collapsing{height:0;overflow:hidden;transition-timing-function:ease;transition-duration:.35s;transition-property:height,visibility}.input-group{display:table;border-collapse:separate}.input-group .form-control{z-index:2;float:left;width:100%;margin-bottom:0}.input-group .form-control,.input-group-addon,.input-group-btn{display:table-cell}.media-object,.nav>li,.nav>li>a,.navbar-brand>img{display:block}.input-group-addon,.input-group-btn{width:1%;white-space:nowrap;vertical-align:middle}.input-group .form-control:first-child,.input-group-addon:first-child,.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group>.btn,.input-group-btn:first-child>.dropdown-toggle,.input-group-btn:last-child>.btn-group:not(:last-child)>.btn,.input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle){border-top-right-radius:0;border-bottom-right-radius:0}.input-group .form-control:last-child,.input-group-addon:last-child,.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,.input-group-btn:first-child>.btn:not(:first-child),.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group>.btn,.input-group-btn:last-child>.dropdown-toggle{border-top-left-radius:0;border-bottom-left-radius:0}.input-group-btn{font-size:0;white-space:nowrap}.input-group-btn>.btn:active,.input-group-btn>.btn:focus,.input-group-btn>.btn:hover{z-index:2}.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group{z-index:2;margin-left:-1px}.nav{padding-left:0;list-style:none}.nav>li>a{padding:10px 15px}.nav>li>a:focus,.nav>li>a:hover{text-decoration:none;background-color:#eee}.navbar{min-height:50px;margin-bottom:20px;border:1px solid transparent}.navbar-collapse{padding-right:15px;padding-left:15px;overflow-x:visible;-webkit-overflow-scrolling:touch;border-top:1px solid transparent;box-shadow:inset 0 1px 0 hsla(0,0%,100%,.1)}.navbar-collapse.in{overflow-y:auto}.navbar-fixed-bottom .navbar-collapse,.navbar-fixed-top .navbar-collapse{max-height:340px}.container-fluid>.navbar-collapse,.container-fluid>.navbar-header,.container>.navbar-collapse,.container>.navbar-header{margin-right:-15px;margin-left:-15px}.navbar-fixed-bottom,.navbar-fixed-top{position:fixed;right:0;left:0;z-index:1030}.carousel,.carousel-inner,.navbar-toggle{position:relative}.navbar-fixed-top{top:0;border-width:0 0 1px}.navbar-brand{float:left;height:50px;padding:15px;font-size:18px;line-height:20px}.navbar-brand:focus,.navbar-brand:hover{text-decoration:none}.navbar-toggle{float:right;padding:9px 10px;margin-top:8px;margin-right:15px;margin-bottom:8px;background-color:transparent;background-image:none;border:1px solid transparent;border-radius:4px}.navbar-toggle .icon-bar{display:block;width:22px;height:2px;border-radius:1px}.navbar-toggle .icon-bar+.icon-bar{margin-top:4px}.navbar-nav{margin:7.5px -15px}.navbar-nav>li>a{padding-top:10px;padding-bottom:10px;line-height:20px}.navbar-default{background-color:#f8f8f8;border-color:#e7e7e7}.navbar-default .navbar-brand{color:#777}.navbar-default .navbar-brand:focus,.navbar-default .navbar-brand:hover{color:#5e5e5e;background-color:transparent}.navbar-default .navbar-nav>li>a,.navbar-default .navbar-text{color:#777}.navbar-default .navbar-nav>li>a:focus,.navbar-default .navbar-nav>li>a:hover{color:#333;background-color:transparent}.navbar-default .navbar-toggle{border-color:#ddd}.navbar-default .navbar-toggle:focus,.navbar-default .navbar-toggle:hover{background-color:#ddd}.navbar-default .navbar-toggle .icon-bar{background-color:#888}.navbar-default .navbar-collapse,.navbar-default .navbar-form{border-color:#e7e7e7}.media{margin-top:15px}.media:first-child{margin-top:0}.media,.media-body{overflow:hidden;zoom:1}.media-body{width:10000px}.media-left,.media>.pull-left{padding-right:10px}.media-body,.media-left,.media-right{display:table-cell;vertical-align:top}.panel{margin-bottom:20px;background-color:#fff;border:1px solid transparent;border-radius:4px;box-shadow:0 1px 1px rgba(0,0,0,.05)}.carousel-control,a{background-color:transparent}.panel-body{padding:15px}.panel-heading{padding:10px 15px;border-bottom:1px solid transparent;border-top-left-radius:3px;border-top-right-radius:3px}.btn-group-vertical>.btn-group:after,.btn-group-vertical>.btn-group:before,.btn-toolbar:after,.btn-toolbar:before,.clearfix:after,.clearfix:before,.container-fluid:after,.container-fluid:before,.container:after,.container:before,.dl-horizontal dd:after,.dl-horizontal dd:before,.form-horizontal .form-group:after,.form-horizontal .form-group:before,.modal-footer:after,.modal-footer:before,.modal-header:after,.modal-header:before,.nav:after,.nav:before,.navbar-collapse:after,.navbar-collapse:before,.navbar-header:after,.navbar-header:before,.navbar:after,.navbar:before,.pager:after,.pager:before,.panel-body:after,.panel-body:before,.row:after,.row:before{display:table;content:" "}.btn-group-vertical>.btn-group:after,.btn-toolbar:after,.clearfix:after,.container-fluid:after,.container:after,.dl-horizontal dd:after,.form-horizontal .form-group:after,.modal-footer:after,.modal-header:after,.nav:after,.navbar-collapse:after,.navbar-header:after,.navbar:after,.pager:after,.panel-body:after,.row:after{clear:both}.pull-right{float:right}.pull-left{float:left}.hide,.visible-lg,.visible-lg-block,.visible-lg-inline,.visible-lg-inline-block,.visible-md,.visible-md-block,.visible-md-inline,.visible-md-inline-block,.visible-sm,.visible-sm-block,.visible-sm-inline,.visible-sm-inline-block,.visible-xs,.visible-xs-block{display:none}.visible-xs{display:block}.hidden-xs{display:none}
        .fa{display:inline-block;font:normal normal normal 14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased}.fa.pull-left{margin-right:.3em}.fa-search:before{content:"\f002"}.fa-list:before{content:"\f03a"}.fa-map-marker:before{content:"\f041"}.fa-plus-circle:before{content:"\f055"}.fa-heart-o:before{content:"\f08a"}.fa-phone:before{content:"\f095"}.fa-twitter:before{content:"\f099"}.fa-facebook-f:before,.fa-facebook:before{content:"\f09a"}.fa-google-plus:before{content:"\f0d5"}.fa-envelope:before{content:"\f0e0"}.fa-linkedin:before{content:"\f0e1"}.fa-comment-o:before{content:"\f0e5"}.fa-angle-up:before{content:"\f106"}.fa-instagram:before{content:"\f16d"}.fa-paper-plane:before,.fa-send:before{content:"\f1d8"}.fa-at:before{content:"\f1fa"}.fa-bed:before,.fa-hotel:before{content:"\f236"}.fa-map-o:before{content:"\f278"}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);border:0}button,hr,input{overflow:visible}body{margin:0}article,aside,footer,header,nav,section{display:block}h1{font-size:2em;margin:.67em 0}hr{box-sizing:content-box;height:0}a{-webkit-text-decoration-skip:objects}b,strong{font-weight:inherit;font-weight:bolder}img{border-style:none}button,input,optgroup,select,textarea{font-family:sans-serif;font-size:100%;line-height:1.15;margin:0}button,select{text-transform:none}[type=reset],[type=submit],button,html [type=button]{-webkit-appearance:button}textarea{overflow:auto}
        .socialPlugin .socials{width:260px;color:#fff;line-height:10px;text-align:center;margin-left:-35px;display:block;transform-origin:50% 0;-webkit-transform:scale(0) translateY(-150px);transform:scale(0) translateY(-150px);transition:.5s;opacity:0;margin-top:-90px}.socialPlugin .socials .fa{height:2.5em;overflow:hidden;position:relative;text-decoration:none;width:2.5em;-webkit-backface-visibility:hidden}.socialPlugin .socials .fa:after,.socialPlugin .socials .fa:before{left:0;position:absolute;text-align:center;transition:.5s;top:50%;width:100%}.socialPlugin .socials .fa:before{color:#fff;-webkit-transform:translate3D(0,-50%,0);transform:translate3D(0,-50%,0);z-index:2}.socialPlugin .socials .fa:after{padding-bottom:25%;padding-top:300%;top:0}.socialPlugin .socials .fa-twitter:after{background-image:linear-gradient(#00acee 25%,#fff 75%);content:"\f099";color:#00acee}.socialPlugin .socials .fa-facebook:after{background-image:linear-gradient(#3b5998 25%,#fff 75%);content:"\f09a";color:#3b5998}.socialPlugin .socials .fa-google-plus:after{background-image:linear-gradient(#b00 25%,#fff 75%);content:"\f0d5";color:#b00}[class*=" flaticon-"]:after,[class*=" flaticon-"]:before,[class^=flaticon-]:after,[class^=flaticon-]:before{font-family:Flaticon;font-size:20px;font-style:normal;margin-left:20px}
        /* Bootsrap rtl */
        .col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9,.input-group .form-control,.navbar-brand{float:right}body,html{direction:rtl}.list-inline{padding-right:0;padding-left:initial;margin-right:-5px;margin-left:0}.col-lg-1,.col-lg-10,.col-lg-11,.col-lg-12,.col-lg-2,.col-lg-3,.col-lg-4,.col-lg-5,.col-lg-6,.col-lg-7,.col-lg-8,.col-lg-9,.col-md-1,.col-md-10,.col-md-11,.col-md-12,.col-md-2,.col-md-3,.col-md-4,.col-md-5,.col-md-6,.col-md-7,.col-md-8,.col-md-9,.col-sm-1,.col-sm-10,.col-sm-11,.col-sm-12,.col-sm-2,.col-sm-3,.col-sm-4,.col-sm-5,.col-sm-6,.col-sm-7,.col-sm-8,.col-sm-9,.col-xs-1,.col-xs-10,.col-xs-11,.col-xs-12,.col-xs-2,.col-xs-3,.col-xs-4,.col-xs-5,.col-xs-6,.col-xs-7,.col-xs-8,.col-xs-9{position:relative;min-height:1px;padding-left:15px;padding-right:15px}.col-xs-12{width:100%}.input-group .form-control:first-child,.input-group-addon:first-child,.input-group-btn:first-child>.btn,.input-group-btn:first-child>.btn-group>.btn,.input-group-btn:first-child>.dropdown-toggle,.input-group-btn:last-child>.btn-group:not(:last-child)>.btn,.input-group-btn:last-child>.btn:not(:last-child):not(.dropdown-toggle){border-radius:0 4px 4px 0}.input-group .form-control:last-child,.input-group-addon:last-child,.input-group-btn:first-child>.btn-group:not(:first-child)>.btn,.input-group-btn:first-child>.btn:not(:first-child),.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group>.btn,.input-group-btn:last-child>.dropdown-toggle{border-radius:4px 0 0 4px}.input-group-btn:last-child>.btn,.input-group-btn:last-child>.btn-group{margin-right:-1px;margin-left:auto}.nav{padding-right:0;padding-left:initial}.navbar-collapse{padding-right:15px;padding-left:15px}.navbar-toggle{float:left;margin-left:15px;margin-right:auto}.media-left,.media>.pull-left{padding-left:10px;padding-right:initial}.carousel-control{right:0;bottom:0}
        /* app styles */
        body,button,input,select,textarea{font-family:"Droid Arabic Naskh"}.message-icon span,.top-icon{cursor:pointer;text-align:center}#mainNav ul,.footer-links li{list-style:none}*{-o-box-sizing:border-box;box-sizing:border-box}body{background-color:#fff}body,html{overflow-x:hidden}html{width:100vw}::-webkit-input-placeholder{color:#264584}.colored{font-style:normal;color:#264584;line-height:35px;font-weight:700}.banner,.message-icon span{color:#fff;transition:all .3s ease-out}.colored:before{font-size:30px}a{text-decoration:none}.banner{padding:10px;position:absolute;top:5px;right:10px;font-weight:700;border-radius:0 5px 0 0;background-color:transparent}.message-icon{position:fixed;bottom:15px;z-index:9999;transition:all .3s ease-out;padding-right:30px}.message-icon:hover{right:-5px}.message-icon:hover>span.fa-comment-o{opacity:0}.message-icon span{width:50px;height:50px;background-color:#4463a2;position:relative;top:4px;line-height:50px;font-size:26px}.message-icon span.fa-envelope,.top-icon{background-color:#264584}.message-icon{right:auto}.message-icon,.message-icon:hover{left:-50px}
        /*navbar*/
        #mainNav ul li a:only-child:after,#mainNav ul ul li a:only-child:after{content:""}#mainNav ul li ul,#mainNav ul ul,.hidden-visibility{visibility:hidden}.navbar>.container-fluid{width:90%}#mainNav .navbar-toggle{margin-left:0;padding-left:0}#mainNav ul a{display:block}#mainNav ul ul li a:after{content:"\f104";position:absolute;left:15px}.container-fluid>.navbar-collapse,.container-fluid>.navbar-header,.container>.navbar-collapse,.container>.navbar-header{padding:0 10px}#mainNav .navbar-collapse.in{overflow-y:auto}#mainNav .navbar-collapse,.navbar-collapse{overflow-x:hidden}#mainNav{background-color:#264584;font-family:Changa,sans-serif;z-index:999999999;padding:0;min-height:60px;margin:0;border:none;transition:all .2s}#mainNav .navbar-brand{font-weight:700;color:#fff;padding:8px 0;margin:4px 0 0;transition:all 2s linear;float:left}#mainNav .navbar-toggle{float:left;font-size:14px;font-weight:700;color:#222}#mainNav .navbar-nav a.nav-link{border-bottom:1px solid #fff;color:#fff;font-size:14px;display:inline-block}.navbar{display:flex;align-items:center;justify-content:space-between}#mainNav ul{list-style:none;position:relative}#mainNav ul a{padding:10px 15px 10px 0}#mainNav ul li{position:relative;margin:0;padding:5px 0}#mainNav ul li ul{opacity:0;position:absolute;top:100%;right:0;padding:0;z-index:99999}#mainNav ul ul li{float:none;min-width:220px;border-bottom:1px solid #e9e9e9}#mainNav ul ul{margin:4px 0 0;background-color:#fff;opacity:0;transition:all .25s;transform:translate3d(0,15px,0)}#mainNav ul ul:before{content:"123";position:absolute;width:100%;height:10px;top:-10px;opacity:0}#mainNav ul li a:after,#mainNav ul ul li a:after{font-family:Flaticon;opacity:.7}#mainNav ul li a:after{content:"\f111";padding-right:8px;font-size:10px}#mainNav ul li a:only-child:after{padding:0}#mainNav ul ul li:last-child{border-bottom:none}#mainNav ul li:hover ul a,#mainNav ul ul a{line-height:27px;padding:8px 30px 8px 15px;color:#707070;text-decoration:none;font-size:15px}.navbar-header .icons a span[class*=flaticon],.topmoblink a{color:#fff}.container-fluid>.navbar-collapse{padding:0 10px}.rotate-right{transform:rotate(40deg)}.rotate-left{transform:rotate(-40deg)}.navbar>.container-fluid{padding:0}.navbar-default .navbar-toggle{border-color:transparent;transition:all .3s ease-out;float:left;margin-top:2px}.navbar-default .navbar-toggle:focus,.navbar-default .navbar-toggle:hover{background-color:transparent}.navbar-default .navbar-toggle .icon-bar{transition:all .3s ease-out;margin-top:5px;background-color:#fff}.navbar-default .navbar-toggle .icon-bar.num1{transform-origin:top left}.navbar-default .navbar-toggle .icon-bar.num3{transform-origin:bottom left}.navbar-header .icons a{margin-top:10px}.navbar-header .icons a span[class*=flaticon]:before{margin-left:0;margin-right:13px;font-size:22px}[class*=flaticon]:before{font-size:18px}.topmoblink{display:block;float:left;font-size:17px;border-bottom:1px solid #fff;padding:10px 15px 10px 0;line-height:20px;font-weight:700;color:#fff}.topmoblink i:before{margin-left:5px}
        .logo-Damas-Logo {font-family: 'logo';speak: none;font-style: normal;font-weight: normal;font-variant: normal;text-transform: none;line-height: 50px;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}
        .logo-Damas-Logo:before {content: "\e900";color: #FFF;font-size: 200px;}
        #mainNav .logo-Damas-Logo:before {float: left;width: 170px;}
        .call-center h2,.main-head{color:#264584;margin-top:0;border-bottom:2px solid #264584;padding-bottom:20px;width:auto;position:relative;font-weight:700;font-size:24px;letter-spacing:0}.call-center h2:after,.main-head:after{position:absolute;bottom:-10px;left:calc(50% - 10px);width:20px;height:20px;border-radius:50%;background-color:#fff;border:2px solid #264584}.call-center h2:before,.main-head:before{position:absolute;bottom:-5px;z-index:20;left:calc(50% - 5px);width:10px;height:10px;border-radius:50%;background-color:#264584}.footer-links li,.main-head,footer{position:relative}.call-center{clear:both;padding-top:10px}.call-center h2{margin:20px auto 40px}.call-center aside{margin-bottom:10px}.call-center aside img{height:350px;margin-top:-146px}.call-center .form-group{margin-bottom:40px}.call-center textarea{margin-bottom:30px;max-width:100%;min-height:130px}.call-center .form-control{border-radius:0;outline:0;box-shadow:none;border:0;border-bottom:2px solid #5877b6;height:40px;background-color:#fafafa}.call-center button[type=submit]{background-color:#264584;color:#fff;box-shadow:5px 5px 10px 2px hsla(0,0%,39%,.15)}.call-center h2{width:auto}footer{overflow:hidden;color:#d5d5d5;background:#264584;font-size:13px;line-height:22px;padding:30px 0}footer h4{color:#fff;font-size:23px;margin-bottom:25px;border-bottom:1px solid #d5d5d5;padding-bottom:10px}ul.footer-links{margin:0 0 15px;padding:0;box-sizing:border-box}.footer-links li a{padding:0 0 9px 16px;display:inline-block;color:#d5d5d5;transition:all .2s ease-in-out;line-height:21px}.socialicons{margin:18px auto 0;overflow:hidden;text-align:center}.socialicons a{width:34px;height:34px;line-height:34px;margin:0 0 5px 5px;padding:0;border:1px solid;text-align:center;font-size:18px;display:inline-block;color:#fff;transition:all .4s ease-in 0s}.socialicons a:hover{color:#fff;border-color:transparent}.socialicons .facebook-icon:hover{background-color:#3b5998}.socialicons .twitter-icon:hover{background-color:#22b1e5}.socialicons .googleplus-icon:hover{background-color:#d94a38}.socialicons .linkedin-icon:hover{background-color:#0075a1}.socialicons .instagram-icon:hover{background:radial-gradient(circle farthest-corner at 35% 90%,#fec564,transparent 50%),radial-gradient(circle farthest-corner at 0 140%,#fec564,transparent 50%),radial-gradient(ellipse farthest-corner at 0 -25%,#5258cf,transparent 50%),radial-gradient(ellipse farthest-corner at 20% -50%,#5258cf,transparent 50%),radial-gradient(ellipse farthest-corner at 100% 0,#893dc2,transparent 50%),radial-gradient(ellipse farthest-corner at 60% -20%,#893dc2,transparent 50%),radial-gradient(ellipse farthest-corner at 100% 100%,#d9317a,transparent),linear-gradient(#6559ca,#bc318f 30%,#e33f5f 50%,#f77638 70%,#fec66d)}footer a{color:#d5d5d5}.main-head{color:#264584;margin-top:0;border-bottom:2px solid #264584;padding-bottom:20px;width:auto;font-weight:700;font-size:24px;letter-spacing:0}.main-head:after,.main-head:before{position:absolute;content:""}.main-head:after{bottom:-10px;left:calc(50% - 10px);width:20px;height:20px;border-radius:50%;background-color:#fff;border:2px solid #264584}.main-head:before{bottom:-5px;z-index:20;left:calc(50% - 5px);width:10px;height:10px;border-radius:50%;background-color:#264584}
        .alikes>aside{min-height:100px}.alikes .btn{display:block;width:200px;margin:20px auto}.alikes>aside>h3{padding:15px 0;margin:0 0 20px;background-color:#fafafa}.alikes .alike-item{position:relative;overflow:hidden}.alikes .alike-item:hover aside{}.alikes .alike-item img{height:200px;width:100%}.alikes .alike-item .try{padding:10px;position:absolute;z-index:9999;top:0;left:10px;font-weight:bolder;background-color:#fff;font-size:20px;color:#264584;transition:all .3s ease-out;clip-path:polygon(0 0,100% 0,100% 70%,50% 100%,0 70%)}.alikes .alike-item aside{width:100%;transition:all .3s ease-out;position:relative;border:2px solid #d7d7d7;border-top:0;border-right:0;border-left:0;background-color:#fafafa;top:-56px}.alikes .alike-item aside h3{color:#fff;background-color:#264584;font-weight:bolder;text-align:left;padding:10px;margin-bottom:20px;font-size:20px}.alikes .alike-item aside h3 a{color:#fff}.alikes .alike-item aside h3 .social{display:none}.alikes .alike-item aside h3 .share{cursor:pointer}.alikes .alike-item aside h3 i{margin-left:5px;margin-right:5px}.alikes .alike-item aside h3 .flaticon-multimedia:before,.alikes .alike-item aside h3 i:before{font-size:20px;margin-left:0}@media (max-width:767px){.alikes .alike-item aside h3 i{margin-left:-6px;}}.alikes .alike-item aside p{padding:0 10px;font-size:13.33px;line-height:20px;font-weight:700;text-align:justify;color:#264584}.alikes .alike-item aside ul{list-style:none;color:#264584;display:flex;justify-content:space-around;flex-direction:row-reverse;font-size:10px;padding:5px 0;font-family:Changa}.alikes .alike-item aside ul li{line-height:30px;font-weight:700;font-size:16px}.alikes .alike-item aside ul li img{width:19px;height:19px;display:block;}.alikes .alike-item aside ul li span{line-height:26px;font-size:20px;display:block;text-align:center}.alikes .alike-item aside ul li span:before{line-height:30px;font-size:20px;margin-left:2px}.alikes .alike-item aside button{width:120px;margin:10px auto;display:block;background-color:#264584;color:#fff;padding:10px;border-radius:10px;border:0;outline:0;font-family:Changa;}
        form.amp-form-submit-success [submit-success],
        form.amp-form-submit-error [submit-error]{margin-top: 16px;}
        form.amp-form-submit-success [submit-success] {color: green;}
        form.amp-form-submit-error [submit-error] {color: red;}
        form.amp-form-submit-success.hide-inputs > input {display: none;}
        #sidebar {padding:0 10px;}
        .callus-phone{text-align:center;color:#FFF;font-size:18px;padding:5px;text-shadow:0 2px 5px rgba(0,0,0,.9);background:#314755;background:-webkit-linear-gradient(to right,#314755,#26a0da);background:linear-gradient(to right,#314755,#26a0da)}.whatsapp-pulse,.whatsapp-pulse:hover{color:#fff}.whatsapp-pulse{position:fixed;width:50px;height:50px;background:#42ce6c;color:#fff;border-radius:50%;text-align:center;line-height:50px;font-size:48px;z-index:999999999;right:80px;top:10px}.whatsapp-icon{position:relative;display:block;right:inherit;top:inherit;margin:auto}.whatsapp-pulse i.fa.fa-whatsapp{font-size:35px}.whatsapp-pulse:after,.whatsapp-pulse:before{content:'';display:block;position:absolute;border:50%;border:1px solid #009688;left:-20px;right:-20px;top:-20px;bottom:-20px;border-radius:50%;animation:animatepulse 1.5s linear infinite;opacity:0}.whatsapp-pulse:after{animation-delay:.5s}@keyframes animatepulse{0%{transform:scale(.5);opacity:0}50%{opacity:1}100%{transform:scale(1.2);opacity:0}}
        h1, h2, h3, h4, h5, h6 {font-family: Changa;}
        .results-container .container {padding-left: 15px;}
        .floating-message-inline {margin: 20px 0;}
        .floating-message-inline .header-contactform {width: 100%;margin: auto;background-color: rgba(203,223,255,.9);padding: 20px 20px 0;border-radius: 20px;border: 0;}
        .floating-message-inline .header-contactform h4 {font-size: 15px;margin: 0;padding: 0;font-weight: 700;color: #264584;border: 0;}
        .floating-message-inline .header-contactform .form-group {margin-bottom: 10px;}
        .floating-message-inline .header-contactform .form-group .form-control {margin-bottom: 0;border: 0;border-radius: 5px 0 0 5px;border-right: 4px solid #0d8dd3;color: #fff;background-color: rgba(18,38,71,.7);clip-path: polygon(5% 0,100% 0,100% 100%,0 100%);}
        .floating-message-inline .form-control::-webkit-input-placeholder, .formindex .form-control::-webkit-input-placeholder{color:hsla(0,0%,100%,.8)}
        .floating-message-inline .form-control::-moz-placeholder, .formindex .form-control::-moz-placeholder{color:hsla(0,0%,100%,.8)}
        .floating-message-inline .form-control:-ms-input-placeholder, .formindex .form-control:-ms-input-placeholder{color:hsla(0,0%,100%,.8)}
        .floating-message-inline .btn {padding: 10px 20px;font-size: 14px;text-align: right;background-color: #0d8dd3;outline: none;border: 0;width: auto;clip-path: none;border-radius: 0 0 0 10px;}
        .col-xs-6 {width: 50%;}
        .pl5 {padding-left: 5px;}
        .pr5{padding-right:5px}
        .alikes .alike-item aside h3 i {margin-left: 5px;margin-right: 5px;}
        header{margin-top:60px;}
        .share-icon {position: fixed;left: 10px;top: 75px;font-size: 20px;border-radius: 50%;z-index: 99999;width: 40px;height: 40px;background-color: #264584;color: #fff;line-height: 40px;text-align: center;cursor: pointer;}
        .formindex h2>span>span:after,.formindex h2>span>span:before{animation:signal 1.5s ease-in-out infinite forwards}.formindex{background-color:#cdddf4;padding:10px;border-radius:10px}.formindex h2{color:#264584;font-size:20px;padding:10px;margin:20px 0;font-weight:700}.formindex h2>span>span{padding:5px;width:40px;height:40px;text-align:center;border-radius:50%;line-height:30px;display:block;margin-top:-10px;position:relative}.formindex h2>span>span:after,.formindex h2>span>span:before{position:absolute;content:'';top:0;left:0;width:100%;height:100%;transform-origin:center;transform:scale(1,1);border-radius:50%;border:1px solid #264584}.formindex h2>span>span:after{animation-delay:.75s}.formindex h2>span i:before{font-size:30px;margin-left:0}.formindex>div .input-group{display:block}.formindex>div .input-group.number{display:flex;justify-content:center}.formindex>div .input-group.number .form-control{width:calc(100% - 70px);border-radius:0}.formindex>div .input-group.number p{width:70px;background-color:#465b78;height:40px;padding:13px 0;color:#fff;border-radius:5px 0 0 5px;font-weight:700;margin:0}.formindex>div .input-group.number p img{height:15px;width:20px;margin:0 5px}.formindex>div .select button i:before,.formindex>div div span:before{margin-left:0}.formindex>div .select{display:flex;justify-content:space-between;height:40px;margin-bottom:10px}.formindex>div .select select{width:47.619047619%;background-color:#465b78;color:#cbdfe6;font-size:12px;border:0;border-right:5px solid #0a8fd4;border-radius:0 0 0 10px}.formindex>div .select button{border:0;background-color:#264584;color:#fff;width:100px;clip-path:polygon(12% 0,100% 0,100% 100%,0 100%);line-height:30px}.formindex>div .select button i{position:relative;top:2px;transform:rotateY(180deg);display:inline-block}.formindex>div .select p{background-color:#0b8ed2;direction:ltr;color:#fff;font-size:17px;text-align:center;height:40px;line-height:40px;width:calc(100% - 100px);clip-path:polygon(0 0,100% 0,94% 100%,0 100%);border-radius:0 0 0 10px;font-weight:700}.formindex>div .form-control{background-color:#465b78;color:#cbdfe6;border:0;border-right:5px solid #0a8fd4;border-radius:5px 0 0 5px;padding:18px 5px;margin-bottom:5px;font-size:12px;width:100%;}.formindex>div textarea{height:100px}@keyframes signal{0%{transform:scale(1,1);border:1px solid rgba(11,142,210,0)}10%{transform:scale(1.1,1.1);border:1px solid rgba(11,142,210,.1)}20%{transform:scale(1.2,1.2);border:1px solid rgba(11,142,210,.3)}30%{transform:scale(1.3,1.3);border:1px solid rgba(11,142,210,.4)}40%{transform:scale(1.4,1.4);border:1px solid rgba(11,142,210,.5)}50%{transform:scale(1.5,1.5);border:1px solid rgba(11,142,210,.5)}60%{transform:scale(1.6,1.6);border:1px solid rgba(11,142,210,.4)}70%{transform:scale(1.7,1.7);border:1px solid rgba(11,142,210,.3)}80%{transform:scale(1.8,1.8);border:1px solid rgba(11,142,210,.2)}90%{transform:scale(1.9,1.9);border:1px solid rgba(11,142,210,.1)}100%{transform:scale(2,2);border:1px solid rgba(11,142,210,0)}}::-webkit-input-placeholder{color:#cbdfe6}::-moz-placeholder{color:#cbdfe6}:-ms-input-placeholder{color:#cbdfe6}:-moz-placeholder{color:#cbdfe6}
        .colored {font-style: normal;color: #264584;line-height: 35px;font-weight: 700;}
        .flaticon-null:before { content: "\f100"; }
.flaticon-gift:before { content: "\f101"; }
.flaticon-money:before { content: "\f102"; }
.flaticon-shapes:before { content: "\f103"; }
.flaticon-house-key:before { content: "\f104"; }
.flaticon-travel:before { content: "\f105"; }
.flaticon-social-media:before { content: "\f106"; }
.flaticon-alarm-clock:before { content: "\f107"; }
.flaticon-placeholder:before { content: "\f108"; }
.flaticon-shapes-1:before { content: "\f109"; }
.flaticon-cancel:before { content: "\f10a"; }
.flaticon-share:before { content: "\f10b"; }
.flaticon-payment-method:before { content: "\f10c"; }
.flaticon-round:before { content: "\f10d"; }
.flaticon-gps:before { content: "\f10e"; }
.flaticon-city:before { content: "\f10f"; }
.flaticon-search:before { content: "\f110"; }
.flaticon-buildings:before { content: "\f111"; }
.flaticon-globe:before { content: "\f112"; }
.flaticon-tool:before { content: "\f113"; }
.flaticon-app:before { content: "\f114"; }
.flaticon-arrows:before { content: "\f115"; }
.flaticon-magnifying-glass:before { content: "\f116"; }
.flaticon-note:before { content: "\f117"; }
.flaticon-filter:before { content: "\f118"; }
.flaticon-sign:before { content: "\f119"; }
.flaticon-buildings-1:before { content: "\f11a"; }
.flaticon-bed:before { content: "\f11b"; }
.flaticon-key:before { content: "\f11c"; }
.flaticon-resize:before { content: "\f11d"; }
.flaticon-money-1:before { content: "\f11e"; }
        @yield("styles")
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
                    <a class="pull-right" href="{{ Helper::whatsapp_share($infos->tel_1,$infos->whatsapp_share) }}?icon=1">
                        <span class="flaticon-app"></span>
                    </a>
                    <a class="pull-right" href="https://www.damas.net/property-for-sale/turkey">
                        <span class="flaticon-search"></span>
                    </a>
                    <a class="pull-right" href="">
                        <span class="flaticon-note"></span>
                    </a>
                </div>
                <a class="navbar-brand" href="<?= route("front.index"); ?>"><amp-img src="<?= asset("ampimg/logo2.png"); ?>" width="104" height="33"></amp-img></a>
            </div>
            
        </div>
    </nav>
    
    <amp-sidebar id="sidebar" layout="nodisplay" side="right">
        <amp-img class="amp-close-image" src="/ampimg/ic_close_black_18dp_2x.png" width="200" height="20" alt="close sidebar" on="tap:sidebar.close" role="button" tabindex="0"></amp-img>
        <?= Helper::menu_tree_front(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", $current_locale]])->toArray()); ?>
    </amp-sidebar>
    <!-- end nav -->
   
    @yield('main_content')
    
    <?php $menu_tree_footer = Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", $current_locale]])->where("footer_section", "links")->toArray(); ?>
    @if(count($menu_tree_footer) > 0)
    <section class="section_links_bottom">
        <div class="container">            
             <?= Helper::menu_tree_footer(0, 0, $menu_tree_footer); ?>
        </div>
    </section>
    @endif
    
    <a href="<?= @$canonical; ?>?targetamp=.share-icon" rel="nofollow,noindex" class="fa fa-share-alt share-icon"></a>
    
    <footer>
        <div class="container">
            <div class="row">
                
                <?php $u_links = Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", $current_locale]])->where("footer_section", "useful")->toArray(); ?>
                <div class="col-md-3 col-sm-6">
                    <h4><?= trans("front.useful links"); ?></h4>
                    <ul class="footer-links">
                        @foreach($u_links as $u_link)
                            <li><a href="<?= $u_link["link"]; ?>"><?= $u_link["title_$current_locale"]; ?></a></li>
                        @endforeach
                    </ul>
                </div>
                
                <?php $q_links = Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", $current_locale]])->where("footer_section", "quick")->toArray(); ?>
                <div class="col-md-3 col-sm-6">
                    <h4><?= trans("front.quick links"); ?></h4>
                    <ul class="footer-links">
                        @foreach($q_links as $q_link)
                            <li><a href="<?= $q_link["link"]; ?>"><?= $q_link["title_$current_locale"]; ?></a></li>
                        @endforeach
                    </ul>
                </div>
                
                <?php
                    $viewed_post = @$viewed_post ? $viewed_post : -1;
                    $posts_limit = $viewed_post > 0 ? 6 : 5;
                    $posts = Helper::query("Post", "latest", ["limit" => $posts_limit]);
                ?>
                <div class="col-md-3 col-sm-6">
                    <h4><?= trans("front.latest posts"); ?></h4>
                    <div class="clearfix">
                        @foreach($posts as $pst)
                        <?php if ( $viewed_post == $pst->id ) continue; ?>
                        <div class="media">
                            <div class="media-left">
                                <a href="<?= route("front.blog.post", $pst->slug); ?>">
                                    <amp-img src="<?= Helper::get_thumbnail($pst->photoCard, 64, 64); ?>" width="64" height="64" layout="responsive"></amp-img>
                                </a>
                            </div>
                            <div class="media-body"><a href="<?= route("front.blog.post", $pst->slug); ?>"><?= $pst->getTitle(); ?></a></div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <h4><?= trans("front.contact information"); ?></h4>
                    <div class="text-widget" dir="ltr">
                        <i class="fa fa-map-marker"></i> <?= $infos->address; ?> <br>
                        <b><i class="fa fa-phone"></i> Phone:</b> <?= $infos->tel_1." / ".$infos->tel_2; ?><br>
                        <b><i class="fa fa-at"></i> Email:</b> <?= $infos->email; ?>
                    </div>
                    <div class="socialicons">
                        <a href="<?= $infos->facebook; ?>" class="facebook-icon" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="<?= $infos->twitter; ?>" class="twitter-icon" target="_blank"><i class="fa fa-twitter"></i></a>
                        <a href="<?= $infos->linkedin; ?>" class="linkedin-icon" target="_blank"><i class="fa fa-linkedin"></i></a>
                        <a href="<?= $infos->instagram; ?>" class="instagram-icon" target="_blank"><i class="fa fa-instagram"></i></a>
                        <a href="<?= $infos->youtube; ?>" class="youtube-icon" target="_blank"><i class="fa fa-youtube"></i></a>
                    </div>
                    <hr>
                    <p><?= trans("front.signup to our newsletter"); ?></p>
                    <div class="input-group form-group">
                        <input type="text" class="form-control" placeholder="<?= trans("front.your email"); ?>...">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><?= trans("front.sign up"); ?></button>
                        </span>
                    </div>
                    <div class="text-center">
                        <ul class="list-inline">
                            <li><a href="<?= route("front.privacy"); ?>"><?= trans("front.privacy policy"); ?></a></li>
                            <li><a href="<?= route("front.terms"); ?>"><?= trans("front.terms of use"); ?></a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="clearfix"></div><br><br>
                <div class="text-center">
                    <a href="<?= url('/'); ?>">
                        <amp-img src="<?= asset("ampimg/logo.png"); ?>" width="160" height="50"></amp-img><br><br>
                    </a>
                    <p><?= trans("front.copyright"); ?> 2018</p>
                </div>

            </div>

        </div>
    </footer>
    
    @yield('schemaorg')
    
  </body>
</html>
