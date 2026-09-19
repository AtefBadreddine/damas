<?php
$current_lang = LaravelLocalization::getCurrentLocale();

$style_lang = in_array($current_lang,['en','fr'])?'en':'ar';

$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$emptypic = asset('img/0.png');
?>
<!DOCTYPE html>
<html lang="<?= $style_lang; ?>" dir="<?= $style_lang == "ar" ? "ltr" : "ltr"; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php $infos = Helper::get_params(); ?>
        <title><?= $og_title = @$page_title ? $page_title : $infos->seo_title; ?></title>
        <link rel="shortcut icon" href="<?= asset("img/favicon.ico"); ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= asset("img/favicon.png"); ?>">
        <link rel="icon" type="image/png" href="<?= asset("img/favicon.png"); ?>" sizes="32x32">
        <meta name="application-name" content="<?= $og_title; ?>" />
        <link rel="alternate" href="<?= LaravelLocalization::getLocalizedURL("ar"); ?>" hreflang="ar" />
        <link rel="alternate" href="<?= LaravelLocalization::getLocalizedURL("en"); ?>" hreflang="en"/>

        <link rel="canonical" href="<?= str_replace('/public', '', Request::url()); ?>" />
        <meta property="og:url" content="<?= Request::url(); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= $og_title; ?>" />
        @if(@$amp_url)
        <link rel="amphtml" href="<?= str_replace('/public', '', $amp_url); ?>">
        @endif
        @if(@$og_image)
            <!--<meta property="og:image" content="<?php // str_replace("https", "http", $og_image);                 ?>" />-->
        <meta property="og:image" content="<?= $og_image; ?>" />
        <!--<meta property="og:image:type" content="image/jpeg" />-->
        <meta property="og:image:width" content="900" />
        <meta property="og:image:height" content="500" />
        @endif
        @if(@$page_description)
        <meta property="og:description" content="<?= htmlspecialchars($page_description); ?>" />
        <meta name="description" content="<?= htmlspecialchars($page_description); ?>" />
        @endif


        @if(@$page_index == "noindex")
        <meta name="robots" content="noindex">
        @endif
        <meta name="msvalidate.01" content="CC5D396D64E6055F8BBAAB11324D7AEF" />
        <?php /*    <!--<meta name="google-site-verification" content="UyXUqpKPXukfj_6RN8QIcy645LW36nMuG8rImcisoeA" />--> */ ?>
        <meta name="google-site-verification" content="PmYCX7XymrFMhPwuJbsruVgqsZcWxsWlNHFZufj-wd8" />
        <meta name="google-site-verification" content="oDTbMEnLspBQFrxxeMq2j6mTyS8fhlqiWizEOeYzf8I" />

        <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700&display=swap&subset=arabic" rel="stylesheet">

        <?php if (App::isLocal()) { ?>
            <!--pluguins.min.css-->
            @if(isset($is_page_search))
            <?= Html::style("resources/assets/css/bootstrap.min.css"); ?>
            @else
            <?= Html::style("resources/assets/css/bootstrap4.css"); ?>
            @endif
            <!--Helper::local_url-->
            <?= Html::style(("resources/assets/css/mycss.css")); ?>
            <?= Html::style("resources/assets/css/normalize.css"); ?>
            <?= Html::style("resources/assets/css/owl.carousel.min.css"); ?>
            <?= Html::style("resources/assets/css/intlTelInput.css"); ?>
            <?= Html::style("resources/assets/css/coolshare.css"); ?>
            <?= Html::style("resources/assets/css/flaticon.css"); ?>
            <?= Html::style("resources/assets/css/jquery.fancybox.min.css"); ?>
            <?= Html::style("resources/assets/css/font-awesome.min.css"); ?>
            <?= Html::style("resources/assets/css/share_buttons.css"); ?>
            <?= Html::style("resources/assets/css/header.css"); ?>
            <?= Html::style("resources/assets/css/animate.min.css"); ?>
            @yield('styles')

            <?= Html::style("resources/assets/css/footer.css"); ?>
            <?= Html::style("resources/assets/css/jquery-ui-autocomplete.css"); ?>
            @if($style_lang == 'ar')

            @else
            <?= Html::style("resources/assets/css/en.css"); ?>
            @endif

            <?php if ($style_lang == 'ar') { ?>
                <?= Html::style("resources/assets/css/new-css/global-ar.css"); ?>
            <?php } else { ?>
                <?= Html::style("resources/assets/css/new-css/global-ar.css"); ?>
                <?= Html::style("resources/assets/css/new-css/global-en.css"); ?>
                <?php
            }
            ?>
        <?php } else { //online ?>
            @yield('styles')
            <?php
        }
        ?>

		@if($current_lang == 'fr')
			@if (App::isLocal())
				<?= Html::style("resources/assets/css/fr.css"); ?>
			@else
				<style><?php include(public_path() . "/css/fr.min.css"); ?></style>
			@endif
		@endif


        <!--[if lt IE 9]>
        <script src="<?= asset("js/html5shiv.min.js"); ?>"></script>
        <script src="<?= asset("js/respond.min.js"); ?>"></script>
        <![endif]-->

        <!--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">-->

        <style>
            /* latin-ext */
            @font-face {
                font-family: 'Montserrat';
                font-style: normal;font-display: swap;
                font-weight: 400;
                src: local('Montserrat Regular'), local('Montserrat-Regular'), url(https://fonts.gstatic.com/s/montserrat/v13/JTUSjIg1_i6t8kCHKm459Wdhyzbi.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Montserrat';
                font-style: normal;font-display: swap;
                font-weight: 400;
                src: local('Montserrat Regular'), local('Montserrat-Regular'), url(https://fonts.gstatic.com/s/montserrat/v13/JTUSjIg1_i6t8kCHKm459Wlhyw.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }
            /* latin-ext */
            @font-face {
                font-family: 'Montserrat';
                font-style: normal;font-display: swap;
                font-weight: 700;
                src: local('Montserrat Bold'), local('Montserrat-Bold'), url(https://fonts.gstatic.com/s/montserrat/v13/JTURjIg1_i6t8kCHKm45_dJE3gfD_u50.woff2) format('woff2');
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }
            /* latin */
            @font-face {
                font-family: 'Montserrat';
                font-style: normal;font-display: swap;
                font-weight: 700;
                src: local('Montserrat Bold'), local('Montserrat-Bold'), url(https://fonts.gstatic.com/s/montserrat/v13/JTURjIg1_i6t8kCHKm45_dJE3gnD_g.woff2) format('woff2');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }

            .header{
                max-height: 90px;
            }
            .last-posts a p{    margin-bottom: 0;}
            .last-posts .h3{    margin-bottom: 25px;}
            footer .contain .post-contact a {
                overflow: hidden;}

            .ffdinn{font-family:dinnextlight!important;top:0!important}

            .open .dropdown-menu{display:block!important}




            .fancybox-container {
                z-index: 999999;
            }
            img:not([src]) {
                visibility: hidden;
            }@-moz-document url-prefix() {
                img:-moz-loading {
                    visibility: hidden;
                }
            }

            input[name=s]::-webkit-calendar-picker-indicator {
                display: none;
            }
            .ui-autocomplete-loading {
                background: white url(/img/show-loader.gif) -53px center no-repeat;
                background-size: 140px;
            }
            .ui-widget.ui-widget-content {
                direction: rtl;
                text-align: right;
                font-family: DroidNaskhRegular !important;
                z-index: 99999999;
            }
            #ui-id-2{
                position: relative !important;
                right: auto;
                left: 200px !important;
                width: 250px !important;
            }
            #hidden-search{display:none}

            .contact #first a{
                text-align:<?= $style_lang == 'ar' ? 'right' : 'left' ?>
            }

            <?php if (Helper::get_device() != 'full') { ?>

                .header .logo .background-logo {
                    width: 101px;
                    height: 86px;}
                .header .logo img {
                    width: 100px;
                    height: auto;}
                #page-top {
                    margin-top: 77px;
                }
                .header .navbar2 {
                    height: 40px;
                    padding-top: 3px;
                }
                .cover {
                    margin-top: 0;}
                .header .navbar2 .drop-menu {
                    margin-top: 2px;
                    border-top: 0.5px solid #ccc;
                    padding-top: 25px;}


                .down-form-content .down-form form input {
                    height: 35px;
                    border-radius: 0 0 0 15px;
                    border-right: 6px solid #1F3A73;
                    padding: 0 10px;
                    font-size: 13px;
                }

                .down-form-content .down-form form .text textarea {
                    @if($style_lang != 'en')
                    border-radius: 0 0 0 15px;
                    padding: 5px;
                    border-right: 6px solid #1F3A73;
                    @endif
                    font-size: 13px;
                }
                .down-form-content .down-form form .options select {
                    height: 35px;
                    font-size: 13px;
                    @if($style_lang != 'en')
                    border-right: 7px solid #1F3A73;
                    border-radius: 0 0 0 15px;
                    @endif
                }
                .down-form-content .down-form form .whatsapp .whatsapp-icon {
                    width: 36px;
                    height: 36px;}
                .down-form-content .down-form form .whatsapp i {
                    font-size: 25px;
                }
                .down-form-content .down-form form .options img {
                    width: 44px;
                    height: 44px;
                }
                .down-form-content .down-form {
                    padding: 20px 20px 20px 20px;
                }

                .down-form-content .title h2 {
                    font-size: 25px!important;
                    top: 28px!important;
                }




                #custom-search-input{
                    padding: 3px;
                    border: solid 12px #132467;
                    background-color: #fff;
                    position: absolute;
                    right: 48px;
                    border-radius: 21px 0px 21px 21px;
                }

                #custom-search-input input{
                    border: 0;
                    box-shadow: none;
                    float: right;
                    direction:rtl;padding-right:10px
                }

                #custom-search-input button{
                    margin: 2px 0 0 0;
                    background: none;
                    box-shadow: none;
                    border: 0;
                    color: #666666;
                    padding: 0 8px 0 10px;
                    border-right: solid 1px #ccc;
                    float: left;
                }
                #custom-search-input button:hover{
                    border: 0;
                    box-shadow: none;
                    border-left: solid 1px #ccc;
                }
                #custom-search-input .glyphicon-search{font-size:23px}

            <?php } ?>
        </style>




        <?php if (!App::isLocal()) { ?>

            <link rel="manifest" href="/manifest.json" />
            <?php /* ?>
              @if($style_lang == 'ar')
              <style>
              #onesignal-popover-container #onesignal-popover-dialog .popover-body-message{
              font-family: DroidNaskhRegular!important;
              text-align:right!important
              }
              #onesignal-popover-container #onesignal-popover-dialog .popover-footer{
              font-family: DroidNaskhRegular!important;
              text-align:right!important
              }
              #subscribe-notifications-container {
              position: fixed;
              width: 40px;
              height: 40px;
              bottom: 0;
              }
              </style>
              @endif
              <?php */ ?>

            <?php /* ?>
              <div id="subscribe-notifications-container" style="display:none;">
              <button id="subscribe-notifications">.</button>
              </div>
              <?php */ ?>


            <!-- Google Tag Manager -->
            <script>(function (w, d, s, l, i) {
                    w[l] = w[l] || [];
                    w[l].push({'gtm.start':
                                new Date().getTime(), event: 'gtm.js'});
                    var f = d.getElementsByTagName(s)[0],
                            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                    j.async = true;
                    j.src =
                            'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                    f.parentNode.insertBefore(j, f);
                })(window, document, 'script', 'dataLayer', 'GTM-NQMR57V');</script>
            <!-- End Google Tag Manager -->

        <?php } ?>
    </head>
    <body id="page-top">

        <?php if (!App::isLocal()) { ?>
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQMR57V"
                              height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            <!-- End Google Tag Manager (noscript) -->
        <?php } ?>

        <noscript>
        <div style="position:fixed; top:0px; left:0px; z-index:999999; height:100%; width:100%; background-color:#FFFFFF;">
            <div style="background-color:#264584; padding: 20px;margin-top: 60px;color:#FFF;text-align:center;">
                <p style="font-size:26px;font-weight:bold"><?= trans("front.javascript not enabled"); ?></p>
                <?= trans("front.activate javascript"); ?> : <a href="http://firefox.com" target="_blank" rel="nofollow" title="Mozilla Firefox">Firefox</a>, <a href="http://apple.com/safari/" target="_blank" rel="nofollow" title="Safari">Safari</a>, <a href="http://opera.com" target="_blank" rel="nofollow" title="Opera Web Browser">Opera</a>, <a href="http://www.google.com/chrome" target="_blank" rel="nofollow" title="Google Chrome">Chrome</a> <?= trans("front.or new version of"); ?> <a href="http://www.microsoft.com/windows/internet-explorer/" target="_blank" rel="nofollow" title="Internet Explorer">Internet Explorer</a>.
            </div>
        </div>
        </noscript>
        <!--------**** Start Show  notifications ****-------->
        <div class="notifications-top animated" id="subscribe-notifications-container" style="display:none;">
            <strong class="close-alert"><i class="fa fa-times" aria-hidden="true"></i></strong>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p>إضغط على زر «Allow» ليصلك أحدث العروض<br><strong>وتخفيضات العقارات في تركيا</strong></p>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 margin-top">
                <button id="block_subscribe">Block</button>
                <button id="subscribe-notifications">Allow</button>
                <span><i class="fa fa-angle-double-down bounce" aria-hidden="true"></i></span>
                <img src="<?= asset("img/alert-icon.svg"); ?>" alt="Damas"/>
<!--                <img class="arrow-gif" src="<?= asset("img/Arrow.gif"); ?>" alt="Damas"/>-->
            </div>
        </div>
        <!--------**** End Show  notifications ****-------->

        <!-- start nav -->
        <?php
        $localecode = $style_lang == "en" ? "ar" : "en";
        $is_mobile = Helper::is_mobile();
        ?>
        <div class="homepage">
            @include("front.partials.call_us_fixed")

            <?php if (!isset($is_quiz_page)) { ?>
                <header class="header" id="test">

                    <?php if (Helper::get_device() != 'mob') { ?>
                        <div class="logo one">
                            <div class="image-logo">
                                <div class="contentLogo">
                                    <a><img src="<?= asset("img/Logo1.svg"); ?>" alt="Damas"/></a>
                                </div>
                            </div>
                            <!--                        <div class="text">
                                                        <span>Real Estate Experts</span><br/>
                                                            <span id="last">Experts</span>
                                                    </div>-->
                        </div>
                    <?php } ?>



                    <div class="menu-links">
						@if(Helper::get_device()!='mob')
                        <nav class="navbar1">
                            <ul class="contain">
                                <li class="language">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                        <img src="<?= asset("img/" . $current_lang . ".svg"); ?>"/>
                                        <span><a href="#"><?= $current_lang == 'en' ? 'English' : ($current_lang == 'fr' ? 'Francais' :'عربي') ?></a></span>
                                        </button>
                                        
										<div class="dropdown-menu">
										
										<?php if($current_lang != 'ar'){ ?>
                                        <a class="dropdown-item" href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('ar')); ?>">
                                        <img src="<?= asset("img/ar.svg"); ?>"/>
                                        <span>عربي</span>
                                        </a>
										<?php } ?>
										
										<?php if($current_lang != 'en'){ ?>
                                        <a class="dropdown-item" href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('en')); ?>">
                                        <img src="<?= asset("img/en.svg"); ?>"/>
                                        <span>English</span>
                                        </a>
										<?php } ?>
										
										<?php if($current_lang != 'fr'){ ?>
                                        <a class="dropdown-item" href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('fr')); ?>">
                                        <img src="<?= asset("img/fr.svg"); ?>"/>
                                        <span>Francais</span>
                                        </a>
										<?php } ?>
										
                                        </div>
                                        <!--<a class="dropdown-item" href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL($localecode)); ?>">
                                            <img src="<?= asset("img/" . ($localecode == 'en' ? 'usd' : 'sar') . ".svg"); ?>"/>
                                            <span><?= $localecode == 'en' ? 'English' : 'عربي' ?></span>
                                        </a>-->

                                    </div>
                                </li>

                                <?php if (Helper::get_device(true) == 'full') { ?>
                                    <li><!-- Room Select -->
                                        <div class="col s4 dropOption select-room">
                                            <div class="input-field select">
                                                <div class="dropdown dropdown--image" value="">
                                                    <div class="dropdown__select">
                                                        <img src="<?= asset("img/bedW.svg"); ?>" alt="Damas"/>
                                                        <div class="dropdown__select-wrap">
                                                            <?php $selected_rooms = session()->get("filter_rooms") == '' ? trans('front.rooms') : session()->get("filter_rooms"); ?>
                                                            <span><?= str_replace('_', '+', $selected_rooms) ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown__options-wrap">
                                                        <?php $arr_rooms = array('1_0', '1_1', '1_2', '1_3', '1_4', '1_5', '2_3', '2_4', '2_5', '2_6'); ?>
                                                            <!--<option value="<?= route('front.filter_rooms', ['all']); ?>">{{ trans('front.all') }}</option>-->
                                                        <?php
                                                        foreach ($arr_rooms as $k) {
                                                            if ($selected_rooms != $k) {
                                                                ?>
                                                                <a href="<?= route('front.filter_rooms', [$k]); ?>" class="dropdown__option">
                                                                    <span>(<?= str_replace('_', '+', $k) ?>)</span>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>	
                                    </li>




                                    <li><!-- currency Select -->
                                        <div class="col s4 dropOption select-currency">
                                            <div class="input-field select">
                                                <div class="dropdown dropdown--image" value="">
                                                    <div class="dropdown__select">
                                                        <div class="dropdown__select-wrap">
                                                            <?php $selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;     ?>
                                                            <img src="<?= asset("img/Flags/" . strtolower($selected_curr) . ".svg"); ?>" alt="Damas"/>
                                                            <span><?= $selected_curr ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown__options-wrap">
                                                        <?php
                                                        $ex = unserialize($infos->exchange);
                                                        if ($ex)
                                                            foreach ($ex as $k => $v) {
                                                                if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND'))) {
                                                                    if ($selected_curr != $k) {
                                                                        ?>
                                                                        <a class="dropdown__option <?= $k ?>" href="<?= route('front.currency', [$k]); ?>"/>
                        <!--<img src="<?= asset("img/Flags/" . strtolower($k) . ".svg"); ?>" alt="<?= $k ?>"/>-->
                                                                        <span><?= $k ?></span>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>


                                <?php if (Helper::get_device(true) != 'full') { ?>
                                    <li class="devise">
        <!--                                        <i class="flaticon-coin-of-dollar"></i>-->
                                        <img class="coins-icon" src="<?= asset("img/coins-icon.svg"); ?>" alt="Damas"/>
                                        <select  onchange="window.location = this.options[this.selectedIndex].value">
                                            <?php $selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;   ?>
                                            <?php
                                            $ex = unserialize($infos->exchange);
                                            if ($ex)
                                                foreach ($ex as $k => $v) {
                                                    if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND'))) {
                                                        ?>
                                                        <option <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= route('front.currency', [$k]); ?>"><?= $k ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </li>
                                    <li class="room">
                                        <div class="arrwo"></div>
                                        <i class="flaticon-bed2"></i>
                                        <select id="selectdevice" onchange="window.location = this.options[this.selectedIndex].value">
                                            <?php $selected_rooms = session()->get("filter_rooms") == '' ? trans('front.rooms') : session()->get("filter_rooms"); ?>

                                            <?php $arr_rooms = array('1_0', '1_1', '1_2', '1_3', '1_4', '1_5', '2_3', '2_4', '2_5', '2_6'); ?>
                                            <option value="<?= route('front.filter_rooms', ['all']); ?>">{{ trans('front.all') }}</option>
                                            <?php foreach ($arr_rooms as $k) { ?>
                                                <option <?= $selected_rooms == $k ? 'selected' : '' ?> value="<?= route('front.filter_rooms', [$k]); ?>"><?= str_replace('_', '+', $k) ?></option>
                                            <?php } ?>


                                        </select>
                                    </li>
                                <?php } ?>
                                <li class="whatsapp1">
                                    <a target="_blank" href="<?= Helper::whatsapp_share(str_replace(array('+', ' '), '', $infos->tel_1), $infos->whatsapp_share) . "?icon=1" ?>">
                                        <i class="fa fa-whatsapp"></i>
                                        <span id="num"><?= $infos->tel_1; ?></span>
                                    </a>
                                    <div id="ar">للعملاء العرب</div>
                                    <div id="en">Müşteriler iseniz</div>
                                </li>
                                <li class="whatsapp2">
                                    <a target="_blank" href="<?= Helper::whatsapp_share(str_replace(array('+', ' '), '', $infos->tel_1), $infos->whatsapp_share) . "?icon=01" ?>">
                                        <i class="fa fa-whatsapp"></i>
                                        <span id="num"><?= $infos->tel_2; ?></span>
                                    </a>
                                    <span id="ar">Satış Ofisi</span>
                                    <span id="en">iseniz</span>
                                </li>
                            </ul>
                        </nav>
						@endif
						
                        <nav class="navbar2" >

                            <!-- Start Btn Menu Mob -->
                            <div class="show-menu" id="show-menu">
                                <div id="line1"></div>
                                <div id="line2"></div>
                                <div id="line3"></div>
                            </div><!-- End Menu Mob -->

                            <!-- Start Top Input Search -->
                            <?php if (Helper::get_device() == 'mob') { ?>
                                <div class='search-content-mobile animated'>
                                    <form action="<?= route("front.searchpage"); ?>">
                                        <input class="bluring" type="text" name="s" <!--list="json-datalist" --> required  autocomplete="off" placeholder="{{trans('front.whatAreYouLookingFor')}}...">
                                               <button class="srhbtn"><img src="<?= asset("/img/send-icon.svg"); ?>" alt="Damas"/></button>
                                    </form>
                                </div>
                            <?php } ?>
                            <!-- End Top Input Search -->
                            <!-- Logo Mobile -->
                            <div class="logo two">
                                <div class="image-logo">
                                    <div class="contentLogo">
                                        <a href="<?= route("front.index"); ?>"><img class="normal-logo" src="<?= asset("img/Logo2.svg"); ?>" alt="Damas"/><img class="property-for-sale-logo" src="<?= asset("img/Logo1.svg"); ?>" alt="Damas"/></a>
                                    </div>
                                </div>

                                <!--                            <div class="text">
                                                                <span>Real Estate Experts</span><br/>
                                                                    <span id="last">Experts</span>
                                                            </div>-->
                            </div>








                            <ul class="homes-icons">
                                <li class="home-page">
                                    <a href="/"><img src="<?= asset("img/home-icon.svg"); ?>"></a>
                                </li>
                                <li class="home-search">
                                    <a href="<?= route("front.search", ["property-for-sale", "turkey"]) ?>"><img src="<?= asset("img/home-search.svg"); ?>"></a>
                                </li>
                            </ul>






                            <?php
                            /* display only on full */
                            echo Helper::menu_tree_front(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", $current_lang]])->toArray());
                            ?>

                            <?php if (Helper::get_device() != 'mob') { ?>
                                <ul class="contain blk_search englishType">
                                    <li class="search search_form">
                                        <form action="<?= route("front.searchpage"); ?>">
                                            <input class="bluring" type="text" name="s" <!--list="json-datalist" --> required  autocomplete="off" placeholder="{{trans('front.search')}} ...">
                                                   <button class="srhbtn"><i class="fa fa-search"></i></button>
                                        </form>
                                    </li>
                                </ul>
                            <?php } ?>

                            <?php if (Helper::get_device() != 'mob') { ?>
                                <ul class="contain blk_search arabicType">
                                    <li class="search search_form">
                                        <form action="<?= route("front.searchpage"); ?>">
                                            <input class="bluring" type="text" name="s" <!--list="json-datalist" --> required  autocomplete="off" placeholder="{{trans('front.search')}} ...">
                                                   <button class="srhbtn"><i class="fa fa-search"></i></button>
                                        </form>
                                    </li>
                                </ul>
                            <?php } ?>
                            <?php /* ?><datalist id="json-datalist">
                              <?php $arr = DB::table("search")->select("id","word","cnt_search")->limit(10)->orderBy('cnt_search','desc')->get();
                              foreach($arr as $r){
                              ?>
                              <option value="<?= $r->word ?>">
                              <?php } ?>
                              </datalist><?php */ ?>

                            <ul class="contain">
                                <li class="whatsapp"><a href="<?= Helper::whatsapp_share($infos->tel_1, $infos->whatsapp_share); ?>?icon=1" target="_blank"><i class="fa fa-whatsapp"></i></a></li>



                                <li class="home-search notFull">
                                    <a href="<?= route("front.search", ["property-for-sale", "turkey"]) ?>"><img src="<?= asset("img/home-search.svg"); ?>"></a>
                                </li>


                                <li class="after-search">
                                    <div class="drop-search"  data-toggle="dropdown"><i class="fa fa-search"></i></div>
                                    <div class="dropdown-menu">
                                        <form action="<?= route("front.searchpage"); ?>">
                                            <input class="bluring" type="text" name="s" <!--list="json-datalist" --> required  autocomplete="off" placeholder="{{trans('front.whatAreYouLookingFor')}} ...">
                                                   <button  class="srhbtn" style="background-color:transparent;border:0px"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>
                                </li>
                                <li class="envelope"><a class="navscroll" href="#section_callcenter"><i class="fa fa-envelope"></i></a></li>

                                <?php if (Helper::get_device() == 'mob') { ?>
                                    <li class="mobile-search-btn"><a><i class="fa fa-search"></i></a></li>

                                    <li class="devise">
                                        <img class="coins-icon" src="<?= asset("img/coins-icon.svg"); ?>" alt="Damas"/>
                                        <select  onchange="window.location = this.options[this.selectedIndex].value">
                                            <?php $selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;   ?>
                                            <?php
                                            $ex = unserialize($infos->exchange);
                                            if ($ex)
                                                foreach ($ex as $k => $v) {
                                                    if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND'))) {
                                                        ?>
                                                        <option <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= route('front.currency', [$k]); ?>"><?= $k ?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </li>
                                <?php } ?>


                            </ul>


                            <!-- Start Menu Mob -->
                            <div class="drop-menu" dir="rtl" id="drop-menu">
                                <div class="empty-section"></div>
                                <div class="cont animated">
                                    <div class="top">
                                        <ul>
                                            <li><a href="tel:<?= str_replace(' ', '', $infos->tel_1) ?>"><i class="fa fa-phone"></i><p><?= $infos->tel_1; ?></p><span class="arabic">للعملاء العرب</span></a></li>
                                            <li><a href="tel:<?= str_replace(' ', '', $infos->tel_2) ?>"><i class="fa fa-phone"></i><p><?= $infos->tel_2; ?></p><span>Satış Ofisi iseniz</span></a></li>
                                        </ul>
                                    </div>

                                    <ul class="menu">
                                        <?php
                                        /* display only on mobile */
                                        echo Helper::menu_tree_front_mobile(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", $current_lang]])->toArray());
                                        ?>

                                        <ul class="langList">
                                            @if($current_lang=='en')
                                            <li><a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('ar')); ?>"><img src="<?= asset('/img/ar.svg') ?>" alt="Lang"/><span>عربي</span></a></li>
                                            <li class="active"><a href="#"><img src="<?= asset('/img/en.svg') ?>" alt="Lang"/><span>English</span></a></li>
											<li><a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('fr')); ?>"><img src="<?= asset('/img/fr.svg') ?>" alt="Lang"/><span>Francais</span></a></li>
                                            @elseif($current_lang=='fr')
											<li><a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('ar')); ?>"><img src="<?= asset('/img/ar.svg') ?>" alt="Lang"/><span>عربي</span></a></li>
											<li><a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('en')); ?>"><img src="<?= asset('/img/en.svg') ?>" alt="Lang"/><span>English</span></a></li>
                                            <li class="active"><a href="#"><img src="<?= asset('/img/fr.svg') ?>" alt="Lang"/><span>Francais</span></a></li>
                                            @else
                                            <li class="active"><a href="#"><img src="<?= asset('/img/ar.svg') ?>" alt="Lang"/><span>عربي</span></a></li>
											<li><a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('en')); ?>"><img src="<?= asset('/img/en.svg') ?>" alt="Lang"/><span>English</span></a></li>
											<li><a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : LaravelLocalization::getLocalizedURL('fr')); ?>"><img src="<?= asset('/img/fr.svg') ?>" alt="Lang"/><span>Francais</span></a></li>
                                            @endif
                                        </ul>


                                        <ul class="ampstart-social-follow">
                                            <li> <a href="<?= $infos->facebook; ?>" target="_blank" aria-label="Facebook"> <i class="fa fa-facebook"></i> </a> </li>
                                            <li> <a href="<?= $infos->twitter; ?>" target="_blank" aria-label="Twitter"> <i class="fa fa-twitter"></i> </a> </li>
                                            <li> <a href="<?= $infos->instagram; ?>" target="_blank" aria-label="Instagram"> <i class="fa fa-instagram"></i> </a> </li>
                                            <li> <a href="<?= $infos->youtube; ?>" target="_blank" aria-label="youtube"> <i class="fa fa-youtube"></i> </a> </li>
                                            <li> <a href="https://www.damas.net/whatsapp_share?icon=1" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-whatsapp"></i> </a> </li>
                                        </ul>

                                </div>
                            </div><!-- End Menu Mob -->



                        </nav><!-- End navbar2 -->
                    </div><!-- end menu-links -->
                </header>
            <?php } else { // display logo only ?>
                <header class="header" id="test">
                    <div class="menu-links">
                        <nav class="navbar1">
                        </nav>
                        <nav class="navbar2" >
                            <div class="show-menu" id="show-menu"></div>
                            <div class="logo two" style="margin:-15px auto 0 auto;width:100%;">
                                <div class="image-logo">
                                    <div class="ncontentLogo">
                                        <img src="<?= asset("img/Logo1.svg"); ?>" alt="Damas"/>
                                    </div>
                                </div>
                            </div>
                        </nav><!-- End navbar2 -->
                    </div><!-- end menu-links -->
                </header>
            <?php } ?>
            <!-- end Header -->


            <!-- Start Fade Section -->
            <div class="fade-section"></div>
            @yield('main_content')


        </div><!--.homepage div-->

        @if(Helper::get_device()=='mob')

        <div class="loader_spin hidden" style="
             text-align: center;clear:both"><i class="fa fa-spinner fa-spin" style="
             color: #0d8dd3;
             font-size: 36px;
             margin: 10px 0;
             "></i></div>
        @endif
        <?php $menu_tree_footer = Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", $current_lang]])->where("footer_section", "links")->toArray(); ?>
        @if(count($menu_tree_footer) > 0)
        <section style="padding:40px 0;background:#fafafa;position:relative;">
            <div class="container">
                <?= Helper::menu_tree_footer(0, 0, $menu_tree_footer); ?>
            </div>
        </section>
        @endif

        <?php if (!isset($is_quiz_page)) { ?>
            @include("front.partials.call_us_floating")  

            <div style="clear: both"></div>
            <footer>
                <div class="sticky-stopper"></div>
                <div class="contain">
                    <div class="links">
                        <div class="links1">
                            <?php $u_links = Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", $current_lang]])->where("footer_section", "useful")->toArray(); ?>
                            <strong class="h3"><?= trans("front.useful links"); ?></strong>
                            <ul>
                                @foreach($u_links as $u_link)
                                <li><a href="<?= ($current_lang == 'ar' ? $u_link["link"] : str_replace('.net/', '.net/'.$current_lang.'/', $u_link["link"])); ?>"><?= $u_link["title_$current_lang"]; ?></a></li>
                                @endforeach
                            </ul>
                        </div>



                        <div class="links2">

                            <?php $q_links = Helper::query("FooterLink", "orderByPlacement", ["lang" => ["all", $current_lang]])->where("footer_section", "quick")->toArray(); ?>

                            <strong class="h3"><?= trans("front.quick links"); ?></strong>
                            <ul>
                                @foreach($q_links as $q_link)
                                <li><a href="<?= ($current_lang == 'ar' ? $q_link["link"] : str_replace('.net/', '.net/'.$current_lang.'/', $q_link["link"])); ?>"><?= $q_link["title_$current_lang"]; ?></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>



                    <div class="post-contact">
                        <div class="last-posts">
                            <?php
                            $viewed_post = @$viewed_post ? $viewed_post : -1;
                            $posts_limit = $viewed_post > 0 ? 6 : 6;
                            //$posts = Helper::query("Post", "latest", ["limit" => $posts_limit]);

                            $posts = Helper::query("Post", "orderBy", ["field" => "created_at", "value" => "DESC"])->where("published", 1)->where('title_'.$current_lang,'!=','')->limit($posts_limit)->get();
                            ?>
                            <strong class="h3"><?= trans("front.latest posts"); ?></strong>

                            <?php $i = 0; ?>
                            @foreach($posts as $pst)
                            <?php if ($viewed_post == $pst->id) continue; ?>
                            <?php $i++; ?>
                            <div class="post2">
                                <a href="<?= route("front.blog.post", $pst->slug); ?>">
                                    <img class="media-object lazyimg" src="<?= $emptypic ?>" data-src="<?= Helper::get_thumbnail($pst->photoCard, 100, 53, false); ?>" width="100" height="53" alt="<?= $pst->getTitle(); ?>">
                                    <p><?= $pst->getTitle(); ?></p>
                                </a>
                            </div>
                            @endforeach


                        </div>


                        <div class="contact">
                            <strong class="h3"><?= trans("front.contact information"); ?></strong>
                            <div class="info">
                                <div id="first">


                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;padding:2px;background-color:#fff;border-radius:7px;" xml:space="preserve" width="13px" height="13px" class=""><g><g><g><path d="M256,0C153.755,0,70.573,83.182,70.573,185.426c0,126.888,165.939,313.167,173.004,321.035 c6.636,7.391,18.222,7.378,24.846,0c7.065-7.868,173.004-194.147,173.004-321.035C441.425,83.182,358.244,0,256,0z M256,278.719 c-51.442,0-93.292-41.851-93.292-93.293S204.559,92.134,256,92.134s93.291,41.851,93.291,93.293S307.441,278.719,256,278.719z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#264584"></path></g></g></g></svg>

                                    <span class="fn">
                                        <a data-fancybox="" href="https://goo.gl/maps/hb48k2tjZsgTPdGr7">Damas Turk Real Estate</a>
                                    </span>
                                    <span class="adr">
                                        <a data-fancybox="" href="https://www.google.com/maps/search/?api=1&query=%D8%AF%D8%A7%D9%85%D8%A7%D8%B3+%D8%AA%D9%88%D8%B1%D9%83+%D8%A7%D9%84%D8%B9%D9%82%D8%A7%D8%B1%D9%8A%D8%A9">
											<span class="street-address">Yeşilköy Mah. Atatürk Cad. (Istanbul World Trade Center) NO: B3/387, 388 </span>
                                            <span class="locality">Bakırköy/</span>
                                            <span class="region">İstanbul</span>
                                        </a>
                                    </span>
                                </div><br>
                                <span id="second">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 480.56 480.56" style="enable-background:new 0 0 480.56 480.56;padding: 3px;background-color: #fff;border-radius: 7px;" xml:space="preserve" width="13px" height="13px" class=""><g><g><g><path d="M365.354,317.9c-15.7-15.5-35.3-15.5-50.9,0c-11.9,11.8-23.8,23.6-35.5,35.6c-3.2,3.3-5.9,4-9.8,1.8    c-7.7-4.2-15.9-7.6-23.3-12.2c-34.5-21.7-63.4-49.6-89-81c-12.7-15.6-24-32.3-31.9-51.1c-1.6-3.8-1.3-6.3,1.8-9.4    c11.9-11.5,23.5-23.3,35.2-35.1c16.3-16.4,16.3-35.6-0.1-52.1c-9.3-9.4-18.6-18.6-27.9-28c-9.6-9.6-19.1-19.3-28.8-28.8    c-15.7-15.3-35.3-15.3-50.9,0.1c-12,11.8-23.5,23.9-35.7,35.5c-11.3,10.7-17,23.8-18.2,39.1c-1.9,24.9,4.2,48.4,12.8,71.3    c17.6,47.4,44.4,89.5,76.9,128.1c43.9,52.2,96.3,93.5,157.6,123.3c27.6,13.4,56.2,23.7,87.3,25.4c21.4,1.2,40-4.2,54.9-20.9    c10.2-11.4,21.7-21.8,32.5-32.7c16-16.2,16.1-35.8,0.2-51.8C403.554,355.9,384.454,336.9,365.354,317.9z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#264584"></path><path d="M346.254,238.2l36.9-6.3c-5.8-33.9-21.8-64.6-46.1-89c-25.7-25.7-58.2-41.9-94-46.9l-5.2,37.1    c27.7,3.9,52.9,16.4,72.8,36.3C329.454,188.2,341.754,212,346.254,238.2z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#264584"></path><path d="M403.954,77.8c-42.6-42.6-96.5-69.5-156-77.8l-5.2,37.1c51.4,7.2,98,30.5,134.8,67.2c34.9,34.9,57.8,79,66.1,127.5    l36.9-6.3C470.854,169.3,444.354,118.3,403.954,77.8z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#264584"></path></g></g></g> </svg>

                                    <b>Phone:</b><span class="telephone"><a href="tel:<?= str_replace(' ', '', $infos->tel_1) ?>"><?= $infos->tel_1 ?></a></span>
									<!--<span class="telephone two"> <?= $infos->tel_2 ?></span>--></span>
                                <span id="third">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;padding: 3px;background-color: #fff;border-radius: 7px;" xml:space="preserve" width="13px" height="13px" class=""><g><g>
                                    <g><path d="M256,141.176c-63.306,0-114.809,51.503-114.809,114.809S192.694,370.795,256,370.795s114.809-51.503,114.809-114.809    S319.306,141.176,256,141.176z M256,329.43c-40.498,0-73.445-32.947-73.445-73.445c0-40.498,32.947-73.445,73.445-73.445    c40.499,0,73.445,32.947,73.445,73.445C329.445,296.483,296.499,329.43,256,329.43z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#264584"></path>
                                    </g></g><g><g><path d="M437.008,74.97C388.656,26.623,324.375,0,256,0c-0.005,0-0.013,0-0.017,0C187.603,0.004,123.318,26.637,74.97,74.992    C26.62,123.347-0.005,187.637,0,256.017c0.004,68.379,26.637,132.666,74.992,181.014C123.344,485.377,187.625,512.001,256,512    c0.004,0,0.012,0,0.017,0c55.945-0.004,111.216-18.738,155.631-52.752c9.07-6.945,10.792-19.927,3.846-28.995    c-6.945-9.069-19.926-10.794-28.995-3.846c-37.24,28.518-83.58,44.224-130.486,44.228c-0.006,0-0.006,0-0.014,0    c-57.324,0-111.224-22.324-151.761-62.856c-40.542-40.536-62.871-94.435-62.875-151.766    C41.357,137.663,137.636,41.372,255.986,41.364c0.007,0,0.006,0,0.014,0c118.34,0,214.628,96.279,214.636,214.622v23.532    c0,27.523-22.39,49.913-49.913,49.913c-27.523,0-49.913-22.391-49.913-49.913v-23.532c0-11.422-9.259-20.682-20.682-20.682    s-20.682,9.26-20.682,20.682v23.532c0,50.33,40.947,91.278,91.278,91.278S512,329.848,512,279.518v-23.534    C511.995,187.604,485.362,123.318,437.008,74.97z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#264584"></path>
                                    </g></g></g> </svg>
                                    <b>Email:</b><span class="email"><a class="email" href="mailto:<?= $infos->email; ?>"><?= $infos->email; ?></a></span></span>
                            </div>
                            <div class="socialicon">
                                <a href="<?= $infos->youtube; ?>" rel="nofollow" target="_blank"><i class="fa fa-youtube-play"></i></a>
                                <a href="<?= $infos->instagram; ?>" rel="nofollow" target="_blank"><i class="fa fa-instagram"></i></a>
                                <a href="<?= $infos->linkedin; ?>" rel="nofollow" target="_blank"><i class="fa fa-linkedin"></i></a>
                                <a href="<?= $infos->twitter; ?>" rel="nofollow" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="<?= $infos->facebook; ?>" rel="nofollow" target="_blank"><i class="fa fa-facebook"></i></a>
                            </div>
                            <span class="newsletter-title"><?= trans("front.signup to our newsletter"); ?></span>
                            <div style="clear: both"></div>
                            <?= Form::open(["url" => route("front.newsletter"), "id" => "form-newsletter"]); ?>
                            <input type="email" name="email" placeholder="<?= trans("front.your email"); ?>...">
                            <button><?= trans("front.sign up"); ?></button>
                            <?= Form::close(); ?>
                            <div style="clear: both"></div>
                            <div class="privacy">
                                <a href="<?= route("front.privacy"); ?>" id="privacy">

                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve" width="16px" height="16px" class=""><g><g>
                                    <g><path d="M437.333,192h-32v-42.667C405.333,66.99,338.344,0,256,0S106.667,66.99,106.667,149.333V192h-32    C68.771,192,64,196.771,64,202.667v266.667C64,492.865,83.135,512,106.667,512h298.667C428.865,512,448,492.865,448,469.333    V202.667C448,196.771,443.229,192,437.333,192z M287.938,414.823c0.333,3.01-0.635,6.031-2.656,8.292    c-2.021,2.26-4.917,3.552-7.948,3.552h-42.667c-3.031,0-5.927-1.292-7.948-3.552c-2.021-2.26-2.99-5.281-2.656-8.292l6.729-60.51    c-10.927-7.948-17.458-20.521-17.458-34.313c0-23.531,19.135-42.667,42.667-42.667s42.667,19.135,42.667,42.667    c0,13.792-6.531,26.365-17.458,34.313L287.938,414.823z M341.333,192H170.667v-42.667C170.667,102.281,208.948,64,256,64    s85.333,38.281,85.333,85.333V192z" data-original="#000000" class="active-path" data-old_color="#000000" fill="#ffffff"></path></g></g></g> </svg>

                                    <?= trans("front.privacy policy"); ?></a>
                                <a href="<?= route("front.terms"); ?>" id="use">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 347.971 347.971" style="enable-background:new 0 0 347.971 347.971;" xml:space="preserve" width="16px" height="16px" class=""><g><path d="M317.309,54.367C257.933,54.367,212.445,37.403,173.98,0C135.519,37.403,90.033,54.367,30.662,54.367  c0,97.405-20.155,236.937,143.317,293.604C337.463,291.305,317.309,151.773,317.309,54.367z M162.107,225.773l-47.749-47.756  l21.379-21.378l26.37,26.376l50.121-50.122l21.378,21.378L162.107,225.773z" data-original="#000000" class="active-path" data-old_color="#ffffff" fill="#ffffff"/></g></svg>							<?= trans("front.terms of use"); ?></a>
                            </div>
                        </div>

                    </div>
                    <div style="clear: both"></div>
                    <div class="logo">
                        <img src="<?= asset("img/Logo1.svg"); ?>" alt="Damas Turk">
                    </div>
                    <div class="copyright"> &copy; <?= trans("front.copyright"); ?> <a href="<?= route("front.index"); ?>"><?= trans("front.company name"); ?></a> <?= date('Y'); ?></div>
                </div>
            </footer>
        <?php }else { //display mini footer ?>

            <div style="clear: both"></div>
            <footer>
                <div class="sticky-stopper"></div>
                <div class="contain">

                    <div class="post-contact">




                        <div style="clear: both"></div>
                        <div class="logo">
                            <img src="<?= asset("img/Logo1.svg"); ?>" alt="Damas Turk">
                        </div>
                        <div class="copyright"> &copy; <?= trans("front.copyright"); ?> <?= trans("front.company name"); ?> <?= date('Y'); ?></div>
                    </div>
            </footer>

        <?php } ?>
        @if(!Helper::is_mobile() and $style_lang=='ar')
        @include("front.partials.call_us_slide", ["form_type" => "Pop Up"])
        @endif
        @if(Helper::is_mobile())
        <?php $searchpage = (Route::currentRouteName() == "front.search") ? " searchpage-icon-mobile" : ""; ?>
        <span class="fa fa-share-alt share-icon"></span>
        @include("front.partials.floatingsharebuttons", ["class_mobile" => "sharefloatingMobile"])

<!--<div class="message-icon message-icon-mobile<?= $searchpage; ?>">
    <span class="fa fa-envelope"></span>
    <span class="fa fa-comment-o"></span>
</div>-->
        <span class="fa fa-angle-down top-icon top-icon-mobile<?= $searchpage; ?>"></span>
        @else
        @include("front.partials.floatingsharebuttons")

        <div class="message-icon">
            <span class="fa fa-envelope"></span>
            <span class="fa fa-comment-o"></span>
        </div>
        <span class="fa fa-angle-up top-icon"></span>
        @endif




        <style>
<?= include(public_path() . "/fonts/" . $style_lang . ".css") ?>
        </style>

        <?php if (App::isLocal()) { ?>

            <?= Html::script("resources/assets/js/jquery-3.1.1.min.js"); ?>
            <?= Html::script("resources/assets/js/bootstrap.min.js"); ?>
            <?= Html::script("resources/assets/js/owl.carousel.js"); ?>



            <?= Html::script("resources/assets/js/intlTelInput.js"); ?>
            <?= Html::script("resources/assets/js/coolshare.js"); ?>
            <?= Html::script("resources/assets/js/lazyload.min.js"); ?>


            @yield('scriptjs')

            <!--app.min.js-->
            <?= Html::script("resources/assets/js/settings.js"); ?>
            <?= Html::script("resources/assets/js/plugin.js"); ?>
            <?= Html::script("resources/assets/js/main.js"); ?>
            <?= Html::script("resources/assets/js/custom.js"); ?>

            <?= Html::script("resources/assets/js/jquery.fancybox.min.js"); ?>

            <?= Html::script("resources/assets/js/jquery.nicescroll.min.js"); ?>
            <?= Html::script("resources/assets/js/jquery-ui-autocomplete.js"); ?>
        <?php } else { ?>

            <?php /* ?><!--<?= Html::script("js/jquery-3.1.1.min.js"); ?>
              <?= Html::script("js/plugins.min.js"); ?>
              @yield('scriptjs')
              <?= Html::script("js/app.min.js"); ?>-->



              <?= Html::script("resources/assets/js/jquery-3.1.1.min.js"); ?>
              <?= Html::script("resources/assets/js/bootstrap.min.js"); ?>
              <?= Html::script("resources/assets/js/owl.carousel.js"); ?>
              <?= Html::script("resources/assets/js/intlTelInput.js"); ?>
              <?= Html::script("resources/assets/js/coolshare.js"); ?>
              <?= Html::script("resources/assets/js/lazyload.min.js"); ?>
              @yield('scriptjs')
              <!--app.min.js-->
              <?= Html::script("resources/assets/js/settings.js"); ?>
              <?= Html::script("resources/assets/js/plugin.js"); ?>
              <?= Html::script("resources/assets/js/main.js"); ?>
              <?= Html::script("resources/assets/js/custom.js"); ?>
              <?= Html::script("resources/assets/js/jquery.fancybox.min.js"); ?>
              <?php  ?>



              <?= Html::script("js/main.min.js"); */ ?>
            <?php if(!isset($page_turkish_citeznship)){ ?>
			<script type="text/javascript" src="{{ URL::to('js/main.min.js') }}"></script>
			<?php } ?>

            @yield('scriptjs')
            <?= Html::script("js/jquery-ui-autocomplete.js"); ?>
        <?php } ?>

        <?php if (!App::isLocal()) { ?>
            <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
            <script>



                                        var OneSignal = window.OneSignal || [];
                                        OneSignal.push(function () {
                                            OneSignal.init({
                                                appId: "001fe1dd-342f-4613-a349-ab7156bb48c4",
                                                notifyButton: {
                                                    enable: false,
                                                },
                                            });
                                        });
                                        function createCookie(name, value, days) {
                                            if (days) {
                                                var date = new Date();
                                                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                                                var expires = "; expires=" + date.toGMTString();
                                            } else
                                                var expires = "";
                                            document.cookie = name + "=" + value + expires + "; path=/";
                                        }

                                        function readCookie(name) {
                                            var nameEQ = name + "=";
                                            var ca = document.cookie.split(';');
                                            for (var i = 0; i < ca.length; i++) {
                                                var c = ca[i];
                                                while (c.charAt(0) == ' ')
                                                    c = c.substring(1, c.length);
                                                if (c.indexOf(nameEQ) == 0)
                                                    return c.substring(nameEQ.length, c.length);
                                            }
                                            return null;
                                        }
                                        /* Close Notification */
                                        $('#block_subscribe , .close-alert').on('click', function () {
                                            $(".notifications-top").addClass("bounceOut");
                                            setTimeout(function () {
                                                $(".notifications-top").addClass("close");

                                                createCookie('tblock_notif', '1', 1);

                                            }, 2000);
                                        });
            </script>
            <script data-cfasync="false">


                window.OneSignal = window.OneSignal || [];
                window.OneSignal.push(function () {
                    /*console.log('window.OneSignal.push');*/
                    window.OneSignal.isPushNotificationsEnabled(function (isPushEnabled) {
                        /*console.log('isPushNotificationsEnabled');*/
                        if (isPushEnabled) {
                            /* Don't show the subscription container if this visitor is already subscribed to web push 
                             console.log('Don t show the subscription container if this visitor is already subscribed to web push');*/
                            return;
                        } else {
                            /*console.log('Prompt for permission when the button is clicked');
                             Prompt for permission when the button is clicked*/
                            var subscribeButton = document.querySelector("#subscribe-notifications");

                            if (subscribeButton) {
                                /*console.log('onSubscribeNotificationsButtonClicked');*/
                                subscribeButton.addEventListener("click", onSubscribeNotificationsButtonClicked);
                            }

                            /* Get the subscription container*/
                            var subscriptionContainer = document.querySelector("#subscribe-notifications-container");

                            /* Show the container*/
                            if (subscriptionContainer) {
                                /*console.log('Show the container');*/
                                if (readCookie('tblock_notif') == null) {
                                    subscriptionContainer.style = "";
                                }
                            }
                        }
                    });
                });


                function onSubscribeNotificationsButtonClicked() {
                    //* See SDK API documentation: https://documentation.onesignal.com/docs/web-push-sdk *
                    /*console.log("onSubscribeNotificationsButtonClicked()");*/
                    window.OneSignal.registerForPushNotifications();
                    $("#subscribe-notifications-container").hide();
                }


                /*createCookie('tblock_notif','',-1);*/
            </script>
        <?php } ?>









        <script>

            /** Loading Logo **/
            $(document).on("click", ".logo .contentLogo", function () {
                $(this).addClass("load");
                setTimeout(function () {
                    $(".contentLogo").addClass("loading");
                }, 100);

                setTimeout(function () {
                    window.location.href = '<?= route("front.index"); ?>';
                }, 200);
            });

            /** Close Menu On Click Outside **/
            $(document).on("click", ".show-menu", function () {
                $(".fade-section").toggleClass("show");
                $(".header .navbar2 .drop-menu .cont").addClass("fadeInLeft").removeClass("fadeOutLeft");
            });
            $(document).on("click", ".header .navbar2 .drop-menu .empty-section", function () {
                /*$(".header .navbar2 .drop-menu .cont").removeClass("fadeInLeft").addClass("fadeOutLeft");*/
                $(".show-menu").trigger("click");
                /*$(".fade-section").removeClass("show");*/
            });
<?php if (Helper::get_device() == 'mob') { ?>
                $(document).on("click", ".mobile-search-btn", function () {
                    $(".search-content-mobile").toggleClass("fast open fadeInDown");
                    setTimeout(function () {
                        $(".search-content-mobile.fast").removeClass("fast open fadeInDown");
                    }, 7000);
                });
                $(document).on("focus", ".search-content-mobile input", function () {
                    $(".search-content-mobile").removeClass("fast");
                    setTimeout(function () {
                        $(".search-content-mobile").removeClass("open fadeInDown");
                    }, 15000);
                });
<?php } ?>


            /*Nice Scroll Dropdown Menu*/
            $(".header .dropdown__options-wrap").niceScroll({cursorborder: "", cursorcolor: "#b7b7b7", boxzoom: true});
            $(".header .select-room .dropdown__options-wrap").niceScroll({cursorborder: "", cursorcolor: "#b7b7b7", boxzoom: true});

            /* Dropdown Menu Selection*/
            $(document).ready(function () {
                $('.dropdown__select').on('click', function () {
                    $(this).siblings('.dropdown__options-wrap').toggleClass('active');
                    if ($(this).hasClass("active")) {
                        $(this).removeClass("active");
                    } else {
                        $(this).addClass("active");
                    }
                });
                $('.dropdown .dropdown__option').on('click', function () {
                    var html = $(this).html();
                    var value = $(this).find('span').data('value');
                    console.log(value);
                    $(this).closest('.dropdown__options-wrap').siblings('.dropdown__select').find('.dropdown__select-wrap').html(html);
                    $(this).closest('.dropdown__options-wrap').removeClass('active');
                    $(this).closest('.dropdown__options-wrap').prev().removeClass('active');
                    $(this).closest('.dropdown').data('value', value);
                    console.log($(this).closest('.dropdown').data('value'));
                });
            });
            /* Close DropDown*/
            $(function () {
                var $win = $(window); /* or $box parent container*/
                var $box = $(".dropdown__options-wrap");
                var $boxTitle = $(".dropOption");
                $win.on("click.Bst", function (event) {
                    if (
                            $box.has(event.target).length == 0 /*checks if descendants of $box was clicked*/
                            &&
                            !$box.is(event.target)
                            &&
                            $boxTitle.has(event.target).length == 0 /*checks if descendants of $box was clicked*/
                            &&
                            !$boxTitle.is(event.target)
                            /*checks if the $box itself was clicked*/
                            ) {
                        $(".dropdown__select").removeClass("active");
                        $(".dropdown__options-wrap").removeClass("active");
                    } else {
                        /*alert("you clicked inside the box");*/
                    }
                });
            });
            $(".select-room").on("click", function () {
                $(".select-currency .dropdown__select").removeClass("active");
                $(".select-currency .dropdown__options-wrap").removeClass("active");
            });
            $(".select-currency").on("click", function () {
                $(".select-room .dropdown__select").removeClass("active");
                $(".select-room .dropdown__options-wrap").removeClass("active");
            });
            $(".header .contain .language button").on("click", function () {
                $(".select-room .dropdown__select").removeClass("active");
                $(".select-room .dropdown__options-wrap").removeClass("active");
                $(".select-currency .dropdown__select").removeClass("active");
                $(".select-currency .dropdown__options-wrap").removeClass("active");
            });
            function open_tab(url) {
                window.location.href = url;
            }

            $(function () {
                /*$('a[target="_blank"]').removeAttr('target');*/


                $(".navscroll").click(function (e) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $($(this).attr('href')).offset().top - 66
                    }, {duration: 1600});
                });

                $('body').on("click", ".btnFilter", function (e) {
                    var frm = $(this).closest("form");
                    var city = frm.find("select[name=city]").val();
                    var type = frm.find("select[name=project_type]").val();
                    var tag = frm.find("select[name=project_category]").val();
                    var rooms = (frm.find("select[name=rooms]").length > 0) ? frm.find("select[name=rooms]").val() : '';
                    var price = (frm.find("select[name=price]").length > 0) ? frm.find("select[name=price]").val() : '';

                    var str = "";
                    if (rooms != '' && price != '') {
                        str = '?price=' + price + '&rooms=' + rooms;
                    } else if (rooms == '' && price != '') {
                        str = '?price=' + price;
                    } else if (rooms != '' && price == '') {
                        str = '?rooms=' + rooms;
                    }


                    if (!city)
                        city = "turkey";
                    if (!type)
                        type = "property-for-sale";
                    if (tag)
                        tag = "/" + tag;
                    window.location.href = "<?= route("front.search"); ?>/" + type + "/" + city + tag + str;
                    return false;
                });
            });
        </script>
        <?php $input_targetamp = Input::get("targetamp"); ?>
        @if($input_targetamp)
        <script>
            $(document).ready(function () {
                var tagr = "<?= $input_targetamp; ?>";
                $(tagr).trigger("click");
            });
        </script>
        @endif
        <?php if (Route::currentRouteName() != 'front.search') { ?>
            <script type="application/ld+json">
                {
                "@context":"http://schema.org",
                "@type":"RealEstateAgent",
                "name":"{{$infos->name}}",
                "address":{
                "@type":"PostalAddress",
                "streetAddress":"{{$infos->address}}"
                },
                "image":"<?= asset('img/logo2.png'); ?>",
                "email":"<?= $infos->email; ?>",
                "telePhone":"<?= $infos->tel_1; ?>",
                "geo":{
                "@type":"GeoCoordinates",
                "latitude":"<?= $infos->latitude; ?>",
                "longitude":"<?= $infos->longitude; ?>"
                },
                "priceRange": "$50000 - $2000000",



                "openingHours":"Mo-Sa 09:00-19:30",
                "url":"<?= url("/"); ?>","sameAs":["<?= $infos->facebook ?>","<?= $infos->twitter ?>","<?= $infos->gplus ?>","<?= $infos->linkedin ?>","<?= $infos->instagram ?>","<?= $infos->youtube ?>"],
                "contactPoint": [
                {   "@type": "ContactPoint",
                "telephone": "<?= $infos->tel_1; ?>",
                "contactType": "customer service",
                "areaServed": "Turkey",
                "availableLanguage": "Arabic,English,Turkish,French,farsi",
                "contactOption": "HearingImpairedSupported"
                }
                ]
                }
            </script>
        <?php } ?>
        @yield('schemaorg')

        <script>
<?php
/*
  // Get the <datalist> and <input> elements.
  var dataList = document.getElementById('json-datalist');
  var input = document.getElementById('ajax');

  // Create a new XMLHttpRequest.
  var request = new XMLHttpRequest();

  // Handle state changes for the request.
  request.onreadystatechange = function(response) {
  if (request.readyState === 4) {
  if (request.status === 200) {
  // Parse the JSON
  var jsonOptions = JSON.parse(request.responseText);

  // Loop over the JSON array.
  jsonOptions.forEach(function(item) {
  // Create a new <option> element.
  var option = document.createElement('option');
  // Set the value using the item in the JSON array.
  option.value = item;
  // Add the <option> element to the <datalist>.
  dataList.appendChild(option);
  });

  // Update the placeholder text.
  input.placeholder = "e.g. datalist";
  } else {
  // An error occured :(
  input.placeholder = "Couldn't load datalist options :(";
  }
  }
  };

  // Update the placeholder text.
  input.placeholder = "Loading options...";

  // Set up and make the request.
  request.open('GET', '<?= route("front.ajaxkeywords"); ?>?s='+$('input[name=s]').val(), true);
  request.send(); */
?>
<?php /* ?>
  <?php */ ?>
            $(function () {

                var local = '<?= LaravelLocalization::getCurrentLocale() ?>';
                $("input[name=s]").autocomplete({
                    source: "<?= route("front.ajaxkeywords"); ?>",
                    minLength: 1,
                    autoFocus: false,
                    select: function (event, ui) {
                        /*console.log("Label: " + ui.item.label + " - Value: " + ui.item.value + " - ID: " + ui.item.id + ' -URL: ' + ui.item.url);
                         $(this).parent('form').submit();*/

                        if (ui.item.url != '')
                            if (local == 'ar')
                                window.location.href = ui.item.url.replace('/en', '');
                            else
                                window.location.href = ui.item.url;
                        else
                            window.location.href = '<?= route("front.searchpage"); ?>?s=' + ui.item.value;
                    }
                });

                $('[class="srhbtn"]').click(function (e) {
                    console.log($(this).parent('form').children('input').val());
                    var search_val = $(this).parent('form').children('input').val();
                    if (search_val == '') {
                        alert('يرجى تحديد كلمة البحث');
                        return false;
                    }
                    /*e.preventDefault();
                     return false;*/
                    /*$.fancybox.open({
                     src  : '#hidden-search',
                     type : 'inline',
                     opts : {
                     beforeShow : function( instance, current ) {
                     $('#hidden-search .proj_sec').attr('href',"<?= route("front.search") . "/property-for-sale/turkey" ?>?searchkeyword="+search_val);
                     $('#hidden-search .post_sec').attr('href',"<?= route("front.searchpage") ?>?s="+search_val);
                     }
                     }
                     });
                     e.preventDefault();
                     return false;*/
                });
            });
        </script>

        <!--<div id="hidden-search" style="text-align:center">
        <a class="btn btn-primary proj_sec" href="#">البحث في قسم المشاريع</a>
        <a class="btn btn-primary post_sec" href="#" >البحث في قسم المقالات</a>
        </div>-->

    </body>
</html>