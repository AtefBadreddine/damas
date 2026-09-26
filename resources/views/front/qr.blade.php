<?php
if (!isset($availables_langs))
    $availables_langs = ['ar', 'en', 'fr', 'pe', 'ru'];

$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
$current_locale = $current_lang;
$lang = $current_lang;
?>
@section('styles')
<?php
$infos = Helper::get_params();

$is_mobile = Helper::get_device() != 'full' ? true : false;


$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
?>
<!DOCTYPE html>
<html lang="<?= $lang; ?>" dir="<?= $lang == "ar" ? "ltr" : "ltr"; ?>">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?= asset("img/favicon.png"); ?>" />



        <title></title>
        <link rel="canonical" href="<?= Request::url(); ?>" />
        <meta property="og:url" content="<?= Request::url(); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="damasturk" />
        <meta property="og:image" content="" />
        <meta property="og:image:width" content="900" />
        <meta property="og:image:height" content="500" />

        <meta property="og:description" content="damasturk">
        <meta name="description" content="damasturk">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700;800&display=swap" rel="stylesheet">


        <style>

            .landing_header{
                display: block;
                padding-top: 25px;
                float: left;
                width: 100%;
                position: fixed;
                z-index: 9999;
                background-image: url('/img/pattern-body.svg');
                background-repeat: repeat-y;
                background-size: 100%;
                background-color: #fbfbfb;
            }

            .full_sections {
                padding-top: 40px;
            }
            .landing_header .main_menu{
                background-image: linear-gradient(to right, #0b7f7f 0,#008b8c 100%) !important;
                -webkit-box-shadow: 0px 2px 3px 0px rgba(95, 95, 95,1) !important;
            }
            .main_menu{
                float: right;
                width: calc(100% - 90px);
                height: 56px;
                position: relative;
                border-radius: 50px 0px 0px 50px;
                background-image: linear-gradient(to right, #0b7f7f 0,#008b8c 100%);
            }
            .main_menu .flag_header{
                width: 160px;
                position: absolute;
                z-index: -1;
                left: -106px;
                top: -26px;
            }

            .navbar-brand.full{
                width: 210px;
                padding: 0px;
                margin: 0px;
                position: relative;
                top: -11px;
                left: 2px;
                z-index: 99;
            }
            .navbar-brand.full img{
                width: 100%;
                z-index: 999;
                position: relative;
            }
            .page_title{
                font-size: 35px;
                text-align: center;
                color: #02898a;
                line-height: 60px;
            }
            .content_section{
                float: left;
                width: calc(100% - 0px);
                position: relative;
                left: 0px;
                background-color: #ffffff;
                -webkit-box-shadow: 0px 3px 6px 0px rgb(171 171 171 / 50%);
                -moz-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);
                box-shadow: 0px 3px 6px 0px rgb(171 171 171,0.5);
                border-radius: 20px;
                margin: 10px 0px 15px 0px;
                padding: 20px;
                text-align:right;
                direction: rtl;
                margin-top: 40px;
            }
            .content_section .cont {
                float: left;
                width: 100%;
                height: auto;
                max-height: 86px;
                overflow: hidden;
                transition: all 1s;
            }
            .content_section .cont p{
                font-size: 16px;
                color: #010101;
                line-height: 28px;
            }
            .action_content{
                float: left;
                width: 100%;
                text-align: center;
                background-color: rgba(255,255,255,0.5);
                padding: 36px 0px 0px 0px;
                display: block;
                position: relative;
                margin-top: -30px;
                cursor: pointer;
            }
            .action_content.type_less{
                background-color: transparent;
            }
            .show_less_btn,
            .show_more_btn{
                float: none;
                width: auto;
                text-align: center;
                background-color: rgba(255,255,255,0.5);
                padding: 8px 15px 10px 15px;
                display: inline-block;
                position: relative;
                margin: 0px 15px;
                cursor: pointer;
                box-shadow: 0 0.875rem 1.8125rem -0.8125rem rgb(0 0 0 / 30%), 0 0.875rem 1.8125rem -0.8125rem rgb(23 168 169);
                background-image: linear-gradient( 90deg ,#02898a,#17a8a9);
                border-radius: 37px;
                font-size: 15px;
                color: #fff;
            }
            .show_less_btn{
                display: none;
                background-color: #dcffff;
                color: #5090A5;
                background-image: none;
                border: 2px solid #5090A5;
                padding: 7px 15px 9px 15px;
            }
            .sub_title {
                width: 100%;
                text-align: center;
                margin-top: 20px;
                margin-bottom: 0px;
            }

            #turkish-citizenship {
                margin-top: 15px;
            }
            .sub_section {
                float: left;
                width: 100%;
            }
            #turkish-citizenship .sub_title {
                padding: 0px 0px;
            }


        </style>


        <?php if (App::isLocal()) { ?>
            <!--pluguins.min.css-->
            <?= Html::style("resources/assets/css/bootstrap.min.css"); ?>
            <!--<?= Html::style("resources/assets/css/header.css"); ?>-->
            <!--Helper::local_url-->
            <!--<?= Html::style("resources/assets/css/owl.carousel.min.css"); ?>-->
            <?= Html::style("resources/assets/css/intlTelInput.css"); ?>
            <?= Html::style("resources/assets/css/jquery.fancybox.min.css"); ?>
            <?= Html::style("resources/assets/css/font-awesome.min.css"); ?>
            <?= Html::style("resources/assets/css/bootstrap-select.min.css"); ?>
            <?= Html::style("resources/assets/css/jquery-ui-autocomplete.css"); ?>
            <?= Html::style("resources/assets/css/animate.min.css"); ?>
            <?= Html::style("resources/assets/css/font-awesome-animation.css"); ?>


            <?php // Html::style("resources/assets/css/header.css");  ?>
            <!--<?= Html::style("resources/assets/css/global.css"); ?>-->

            <?= Html::style("resources/assets/css/first_view.css"); ?>
            <?= Html::style("resources/assets/css/landing2.css"); ?>
            <?= Html::style("resources/assets/css/qr.css"); ?>


            <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
                <style>
                    .rightMenuModal .modal-body ul.links_list{text-align: left; direction: ltr;}.complaints_btn span, .complaints_btn p{text-align: left;}.complaints_btn img{left: auto; right: 5px;}.rightMenuModal .join_our_team_btn .damasturk_logo{float: left; right: auto; left: auto;}.complaints_btn p{font-size: 13px;}
                    .qr_page_sec .item a .icon {
                        right: auto !important;
                        left: 6px !important;
                    }

                    .qr_page_sec .item{
                        float: left;
                    }

                </style>
            <?php } ?>





            @yield('styles')




            <?php if ($style_lang == 'en') { ?>
                <?= Html::style("resources/assets/css/style-en.css"); ?>
            <?php } ?>
            <?php if ($current_lang == 'ar') { ?>
                <style>
                    @font-face { 
                        font-family: 'Al-Jazeera-Arabic-Regular';
                        src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot') }}');
                        src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.svg#Al-Jazeera-Arabic-Regular') }}') format('otf'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff') }}') format('woff'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff2') }}') format('woff2'); font-weight: normal; font-style: normal; } @font-face { font-family: 'Al-Jazeera-Arabic Bold'; src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot') }}'); src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.woff2') }}') format('woff2'); 
                                                                                                                                                                                                                font-weight: normal; 
                                                                                                                                                                                                                font-style: normal;
                                                                                                                                                                                                                font-display: swap;
                    }
                    @font-face { font-family: 'Al-Jazeera-Arabic-Bold'; 
                                 src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.svg#Al-Jazeera-Arabic-Bold') }}') format('otf'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.woff') }}') format('woff');
                                 font-weight: normal;
                                 font-style: normal;
                                 font-display: swap;
                    }
                </style>
            <?php } elseif ($current_lang == 'pe') { ?>
                <?= Html::style("resources/assets/css/fa.css"); ?>
            <?php } elseif ($current_lang == 'fr') { ?>
                <?= Html::style("resources/assets/css/fr.css"); ?>
            <?php } elseif ($current_lang == 'ru') { ?>
                <?= Html::style("resources/assets/css/ru.css"); ?>
            <?php } ?>




        <?php } else { //online  ?>

            <?php // Html::style("css/main.min.css?v=05"); ?>

            <link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css?v=05') }}">



            <style><?php include(public_path() . "/css/first_view.min.css") ?></style>



            <?= Html::style("css/landing2.min.css"); ?>
            <?= Html::style("css/qr.min.css"); ?>
			
            <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
                <style>
                    .rightMenuModal .modal-body ul.links_list{text-align: left; direction: ltr;}.complaints_btn span, .complaints_btn p{text-align: left;}.complaints_btn img{left: auto; right: 5px;}.rightMenuModal .join_our_team_btn .damasturk_logo{float: left; right: auto; left: auto;}.complaints_btn p{font-size: 13px;}
                </style>
            <?php } ?>

            @yield('styles')

            <?php if ($style_lang == 'en') { ?>
                <?= Html::style("css/style-en.min.css"); ?>
                <!--<style><?php //include(public_path() . "/css/style-en.min.css");             ?></style>-->
            <?php } ?>
            <?php if ($current_lang == 'ar') { ?>
                <style>
                    @font-face { font-family: 'Al-Jazeera-Arabic-Regular';
                                 src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot') }}');
                                 src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.svg#Al-Jazeera-Arabic-Regular') }}') format('otf'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff') }}') format('woff'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff2') }}') format('woff2'); 
                                 font-weight: normal; 
                                 font-style: normal;
                                 font-display: swap;
                    }
                    font-face { font-family: 'Al-Jazeera-Arabic Bold'; src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot') }}'); src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.woff2') }}') format('woff2'); 
                                font-weight: normal; 
                                font-style: normal;
                                font-display: swap;
                    }
                    @font-face { font-family: 'Al-Jazeera-Arabic-Bold'; src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.svg#Al-Jazeera-Arabic-Bold') }}') format('otf'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.woff') }}') format('woff'); 
                                 font-weight: normal; 
                                 font-style: normal;
                                 font-display: swap;
                    }
                </style>
            <?php } elseif ($current_lang == 'pe') { ?>
                <style><?php include(public_path() . "/css/fa.min.css"); ?></style>
            <?php } elseif ($current_lang == 'fr') { ?>
                <style><?php include(public_path() . "/css/fr.min.css"); ?></style>
            <?php } elseif ($current_lang == 'ru') { ?>
                <style><?php include(public_path() . "/css/ru.min.css"); ?></style>
            <?php } ?>
            <?php
        }
        ?>


        <?php if (!App::isLocal()) { ?>
            <!-- Google Tag Manager -->
            <script>
                setTimeout(function () {
                    (function (w, d, s, l, i) {
                        w[l] = w[l] || [];
                        w[l].push({'gtm.start':
                                    new Date().getTime(), event: 'gtm.js'});
                        var f = d.getElementsByTagName(s)[0],
                                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                        j.async = true;
                        j.src =
                                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                        f.parentNode.insertBefore(j, f);
                    })(window, document, 'script', 'dataLayer', 'GTM-NQMR57V');
                }, 3000);
            </script>
            <!-- End Google Tag Manager -->
        <?php } ?>




        <style>

        </style>

    </head>

    <body>


        <!-- Start Header -->
        <div class="landing_header">
            <div class="main_menu">
                <a class="navbar-brand full" href="{{ route('front.index') }}">
                    <img width="210" height="76" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
                </a>

                <div class="all_select_sec">

                    <select class="selectpicker language <?= $current_lang ?>" onchange="window.location = this.options[this.selectedIndex].value">
                        @if(in_array('ar',$availables_langs))
                        <option data-icon="flag_icon SAR" class="SAR" <?= $current_lang == 'ar' ? 'selected' : '' ?> value="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('ar')); ?>">عربي</option>
                        @endif
                        @if(in_array('en',$availables_langs))
                        <option data-icon="flag_icon USD" class="USD num" <?= $current_lang == 'en' ? 'selected' : '' ?> value="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('en')); ?>">English</option>
                        @endif
                        @if(in_array('fr',$availables_langs))
                        <option data-icon="flag_icon FR" class="fr num" <?= $current_lang == 'fr' ? 'selected' : '' ?> value="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('fr')); ?>">Français</option>
                        @endif
                        @if(in_array('pe',$availables_langs))
                        <option data-icon="flag_icon PE" class="fa fa_font" <?= $current_lang == 'pe' ? 'selected' : '' ?> value="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('pe')); ?>">فارسی</option>
                        @endif
                        @if(in_array('ru',$availables_langs))
                        <option data-icon="flag_icon RU" class="ru ru_font" <?= $current_lang == 'ru' ? 'selected' : '' ?> value="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('ru')); ?>">русский</option>
                        @endif
                    </select>

                </div>

            </div>
        </div>
        <!-- End Header -->


        <!-- Start Body -->
        <div class="col-md-10 offset-md-1">
            <div class="full_sections">

                <div class="qr_page_sec">

                    <h1 class="page_title"><?= trans("front.keep in touch"); ?></h1>
                    <p class="description">
                        <?= trans("front.qr page description"); ?>
                    </p>



                    <div class="item">
                        <a target="_blank" href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000"> 
                            <div class="icon whatsapp"> 
                                <span class="fa fa-whatsapp"></span>
                            </div>
                            <p class="num">WhatsApp</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://m.instagram.com/damasturk/"> 
                            <div class="icon">
                                <img loading="lazy" width="40" height="40" title="instagram" alt="instagram" src="/img/instagram-icon.svg">
                            </div>
                            <p class="num">instagram</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://m.facebook.com/damasturk/"> 
                            <div class="icon facebook"> 
                                <span class="fa fa-facebook"></span>
                            </div>
                            <p class="num">Facebook</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://m.me/damasturk"> 
                            <div class="icon messenger"> 
                                <svg width="20" height="20" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 345.6 185.7" style="enable-background:new 0 0 345.6 185.7;" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;}</style><path class="st0" d="M343.4,20.8l-83.5,132.4c-3.1,5-7.3,9.3-12.2,12.6c-4.9,3.3-10.4,5.6-16.2,6.6c-5.8,1.1-11.7,0.9-17.5-0.4c-5.7-1.3-11.1-3.9-15.8-7.4l-66.4-49.8c-3-2.2-6.5-3.4-10.2-3.4c-3.7,0-7.3,1.2-10.2,3.4l-89.6,68C9.9,191.9-5.8,177.6,2.2,165L85.6,32.6c3.1-5,7.3-9.3,12.2-12.6c4.9-3.3,10.4-5.6,16.2-6.6c5.8-1.1,11.7-0.9,17.5,0.4c5.7,1.3,11.1,3.9,15.8,7.4l66.4,49.8c3,2.2,6.5,3.4,10.2,3.4c3.7,0,7.3-1.2,10.2-3.4l89.6-68C335.8-6.3,351.5,8.1,343.4,20.8z"/></svg>
                            </div>
                            <p class="num">Messenger</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="viber://chat?number=905551605000"> 
                            <div class="icon"> 
                                <img loading="lazy" width="40" height="40" title="viber" alt="viber" src="/img/viber-icon.svg">
                            </div>
                            <p class="num">Viber</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://m.vk.com/damasturk"> 
                            <div class="icon vk"> 
                                <img loading="lazy" width="40" height="40" title="VK" alt="VK" src="/img/vk_logo2.png">
                            </div>
                            <p class="num">VK</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://tiktok.com/@damasturk_real_estate?_t=8Yy4eVpqjyQ&_r=1"> 
                            <div class="icon vk"> 
                                <img loading="lazy" width="40" height="40" title="tiktok" alt="tiktok" src="/img/tiktok-icon.svg">
                            </div>
                            <p class="num">tiktok</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://tr.pinterest.com/damasturk/"> 
                            <div class="icon vk"> 
                                <img loading="lazy" width="40" height="40" title="pinterest" alt="pinterest" src="/img/pinterest-icon.svg">
                            </div>
                            <p class="num">Pinterest</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://www.tumblr.com/damasturk"> 
                            <div class="icon tumblr"> 
                                <svg width="20" height="24" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 8.3 14.8" style="enable-background:new 0 0 8.3 14.8;" xml:space="preserve"><style type="text/css">.st0{fill:#FFFFFF;}</style><path class="st0" d="M0,4.1C1.6,3.6,2.3,2.6,2.8,0h2.1v3.9h2.7v2.2H4.9v4.3c0,1.3,1.1,2.1,2.6,1.1l0.8,2.4c-0.9,0.7-1.7,0.9-3.2,0.8c-1.4-0.1-3.3-1.2-3.3-3.4V6.1H0V4.1z"/></svg>
                            </div>
                            <p class="num">Tumblr</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="tel:00905551605000"> 
                            <div class="icon call"> 
                                <span class="fa fa-phone"></span>
                            </div>
                            <p class="num">Hotline Call</p>
                        </a>
                    </div>

                    <div class="item">
                        <a target="_blank" href="https://wa.me/905451605000"> 
                            <div class="icon whatsapp"> 
                                <span class="fa fa-whatsapp"></span>
                            </div>
                            <p><?= trans("front.quick menu link 18"); ?></p>
                        </a>
                    </div>

                </div>


                <!-- Start Share Page -->
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="shareSection">
                                <p><?= trans("front.SharePageTitle") ?></p>
                                <div class="shareBtnsFloating sharepost">
                                    <a href="#" target="_blank" class="btnshare" data-network="facebook">
                                        <svg class="facebook" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 156.6 310" xml:space="preserve"><g id="XMLID_834_"><path id="XMLID_835_" d="M5,165.1h34V305c0,2.8,2.2,5,5,5h57.6c2.8,0,5-2.2,5-5V165.8h39.1c2.5,0,4.7-1.9,5-4.4l5.9-51.5c0.2-1.4-0.3-2.8-1.2-3.9c-0.9-1.1-2.3-1.7-3.7-1.7h-45V72c0-9.7,5.2-14.7,15.6-14.7c1.5,0,29.4,0,29.4,0c2.8,0,5-2.2,5-5V5c0-2.8-2.2-5-5-5h-40.5c-0.3,0-0.9,0-1.9,0c-7,0-31.5,1.4-50.8,19.2C37,38.8,40,62.4,40.7,66.5v37.8H5c-2.8,0-5,2.2-5,5v50.8C0,162.9,2.2,165.1,5,165.1z"/></g></svg>
                                    </a>
                                    <a href="#" target="_blank" class="btnshare" data-network="twitter">
                                        <svg class="twitter" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 313.8 310" xml:space="preserve"><g id="XMLID_826_"><path id="XMLID_827_" d="M306.8,61.9c-4.9,2.2-9.9,4-15,5.5c6.1-6.8,10.7-14.9,13.5-23.7c0.6-2,0-4.1-1.6-5.4c-1.6-1.3-3.9-1.4-5.7-0.4c-10.9,6.4-22.6,11.1-34.9,13.8c-12.4-12.1-29.2-19-46.6-19c-36.7,0-66.5,29.9-66.5,66.5c0,2.9,0.2,5.8,0.5,8.6c-45.5-4-87.9-26.4-116.9-62c-1-1.3-2.6-2-4.3-1.8c-1.6,0.1-3.1,1-3.9,2.5c-5.9,10.1-9,21.7-9,33.5c0,16,5.7,31.2,15.8,43.1c-3.1-1.1-6.1-2.4-8.9-4c-1.5-0.9-3.4-0.8-4.9,0c-1.5,0.9-2.5,2.5-2.5,4.2c0,0.3,0,0.6,0,0.9c0,23.9,12.9,45.5,32.6,57.2c-1.7-0.2-3.4-0.4-5.1-0.7c-1.7-0.3-3.5,0.3-4.7,1.6c-1.2,1.3-1.6,3.2-1,4.8c7.3,22.8,26.1,39.5,48.7,44.6c-18.8,11.8-40.3,18-62.9,18c-4.7,0-9.5-0.3-14.1-0.8c-2.3-0.3-4.5,1.1-5.3,3.3c-0.8,2.2,0,4.6,2,5.9c29,18.6,62.6,28.4,97,28.4c67.8,0,110.1-31.9,133.8-58.8c29.5-33.4,46.4-77.7,46.4-121.4c0-1.8,0-3.7-0.1-5.5c11.6-8.8,21.6-19.4,29.8-31.5c1.2-1.8,1.1-4.3-0.3-6C311.2,61.5,308.9,61,306.8,61.9z"/></g></svg>
                                    </a>
                                    <a href="#" target="_blank" class="btnshare" data-network="whatsapp">
                                        <svg class="whatsapp" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 310 310" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style><path class="st0" d="M259.5,50.9C232.2,23.3,194.9,7.9,156.1,8C75.5,8,9.9,73.6,9.9,154.2c0,25.8,6.7,50.9,19.5,73.1L8.7,303l77.5-20.3c21.4,11.7,45.5,17.8,69.9,17.8h0.1c80.6,0,146.2-65.6,146.2-146.2C302.4,115.5,287,78.3,259.5,50.9 M156.1,275.8L156.1,275.8c-21.8,0-43.2-5.9-61.9-17l-4.4-2.6l-46,12.1l12.3-44.8l-2.9-4.6c-12.2-19.4-18.6-41.8-18.6-64.7c0-67,54.5-121.5,121.6-121.5c32.2-0.1,63.2,12.8,85.9,35.6c22.8,22.8,35.6,53.7,35.5,86C277.6,221.3,223.1,275.8,156.1,275.8 M222.8,184.8c-3.7-1.8-21.6-10.7-25-11.9c-3.3-1.2-5.8-1.8-8.2,1.8c-2.4,3.6-9.4,11.9-11.6,14.3c-2.1,2.4-4.3,2.7-7.9,0.9c-3.6-1.8-15.4-5.7-29.4-18.1c-10.9-9.7-18.2-21.6-20.3-25.3c-2.1-3.7-0.2-5.6,1.6-7.5c1.6-1.6,3.6-4.3,5.5-6.4c1.8-2.1,2.4-3.6,3.6-6.1c1.2-2.4,0.6-4.6-0.3-6.4c-0.9-1.8-8.2-19.8-11.3-27.1c-2.9-7.1-6-6.1-8.2-6.2c-2.3-0.1-4.7-0.1-7-0.1c-3.7,0.1-7.3,1.7-9.8,4.6c-3.4,3.7-12.8,12.5-12.8,30.5s13.1,35.4,14.9,37.8c1.8,2.4,25.8,39.3,62.4,55.2c8.7,3.8,15.5,6,20.8,7.7c8.7,2.8,16.7,2.4,23,1.4c7-1,21.6-8.8,24.7-17.4c3-8.5,3-15.8,2.1-17.4C228.9,187.5,226.4,186.6,222.8,184.8"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Share Page -->


                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>

            </div>
        </div>
        <!-- End Body -->






        <div class="sub_footer">
            <div class="logo_sec">
                <img width="155" height="76" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
            </div>
<!--            <div class="logo_sec">
                <svg width="15" height="20" class="d1 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 40 56" style="enable-background:new 0 0 40 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-129.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-129.2z M-137.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-137.5-95.8z M74.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C83,16.4,79.3,15.3,74.3,15.3z M74.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8c1.4-0.7,3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L74.7,47.5z M-22.5-123.1 c2.2,2.4,2.8,6.4,1.7,12l-4.3,22.8h-9.4L-30-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8 c0.1,1.9,0,4-0.4,6.3l-4.3,22.8h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2 c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9H-81l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9 c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6C-28.3-126.7-24.7-125.5-22.5-123.1z M5.3-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9 l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5 c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9 l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6C14.1-125.6,10.4-126.7,5.3-126.7z M5.8-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5 c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4 L5.8-94.5z M51.5-126.2c2.2,0.4,3.6,0.7,4.2,1l-2.7,7.1c-2.4-0.8-5.5-1.2-9.2-1.2c-5,0-7.8,1.1-8.2,3.4c-0.1,0.6-0.1,1.2,0.2,1.7 c0.3,0.5,0.8,0.9,1.5,1.3c0.8,0.4,1.5,0.7,2.1,0.9c0.6,0.2,1.6,0.5,3,0.9c1.7,0.5,3.2,1,4.4,1.6c1.2,0.5,2.3,1.3,3.4,2.2 c1.1,0.9,1.8,2.1,2.1,3.5c0.4,1.4,0.4,3.1,0,4.9c-0.8,4-2.7,6.9-5.9,8.8c-3.2,1.9-7.3,2.8-12.3,2.8c-2.1,0-4.1-0.2-6-0.5 c-1.9-0.3-3.3-0.6-4.1-1l-1.3-0.5l2.6-7.1c2.7,1.1,6.1,1.6,10.1,1.6c4.9,0,7.5-1.2,7.9-3.5c0.2-1.3-0.2-2.2-1.2-2.9 c-1.1-0.6-2.8-1.3-5.3-2c-1.6-0.5-3-0.9-4.1-1.5c-1.2-0.5-2.3-1.2-3.5-2.2c-1.2-0.9-2-2.1-2.4-3.6c-0.4-1.5-0.5-3.2-0.1-5.1 c0.8-4,2.8-6.9,6.1-8.6c3.3-1.8,7.2-2.7,11.9-2.7C47.1-126.7,49.4-126.5,51.5-126.2z M77-125.9h10l-1.4,7.5h-10l-3.1,16.5 C71.6-97.3,73-95,76.7-95c0.8,0,1.6-0.1,2.5-0.2c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6 c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5l9.6-1.4L77-125.9z M119.1-125.9h9.4l-6.7,35.3 c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8 h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L119.1-125.9z M157-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1 C154.2-126.6,155.7-126.5,157-126.3z M189.4-95.3l1.9-0.2l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8 l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4l5.7,9C186.3-96.4,187.8-95.3,189.4-95.3z M30.9,2l-2.7,14.2 c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9 s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9L40.3,2H30.9z M22.6,46.2c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1 c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1c2.1,0,4,0.3,5.7,0.9L22.6,46.2z"/> </svg>
                <svg width="15" height="20" class="a2 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 35 56" style="enable-background:new 0 0 35 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-131.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-131.2z M-139.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-139.5-95.8z M21.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9L9,24.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C30,16.4,26.3,15.3,21.3,15.3z M21.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L21.7,47.5z M-24.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-32-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 H-83l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-30.3-126.7-26.7-125.5-24.5-123.1z M3.3-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C12.1-125.6,8.4-126.7,3.3-126.7z M3.8-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L3.8-94.5z M49.5-126.2c2.2,0.4,3.6,0.7,4.2,1 l-2.7,7.1c-2.4-0.8-5.5-1.2-9.2-1.2c-5,0-7.8,1.1-8.2,3.4c-0.1,0.6-0.1,1.2,0.2,1.7c0.3,0.5,0.8,0.9,1.5,1.3 c0.8,0.4,1.5,0.7,2.1,0.9c0.6,0.2,1.6,0.5,3,0.9c1.7,0.5,3.2,1,4.4,1.6c1.2,0.5,2.3,1.3,3.4,2.2c1.1,0.9,1.8,2.1,2.1,3.5 c0.4,1.4,0.4,3.1,0,4.9c-0.8,4-2.7,6.9-5.9,8.8c-3.2,1.9-7.3,2.8-12.3,2.8c-2.1,0-4.1-0.2-6-0.5c-1.9-0.3-3.3-0.6-4.1-1l-1.3-0.5 l2.6-7.1c2.7,1.1,6.1,1.6,10.1,1.6c4.9,0,7.5-1.2,7.9-3.5c0.2-1.3-0.2-2.2-1.2-2.9c-1.1-0.6-2.8-1.3-5.3-2c-1.6-0.5-3-0.9-4.1-1.5 c-1.2-0.5-2.3-1.2-3.5-2.2c-1.2-0.9-2-2.1-2.4-3.6c-0.4-1.5-0.5-3.2-0.1-5.1c0.8-4,2.8-6.9,6.1-8.6c3.3-1.8,7.2-2.7,11.9-2.7 C45.1-126.7,47.4-126.5,49.5-126.2z M75-125.9h10l-1.4,7.5h-10l-3.1,16.5C69.6-97.3,71-95,74.7-95c0.8,0,1.6-0.1,2.5-0.2 c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5 l9.6-1.4L75-125.9z M117.1-125.9h9.4l-6.7,35.3c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9 c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4 c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L117.1-125.9z M155-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1 c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1C152.2-126.6,153.7-126.5,155-126.3z M187.4-95.3l1.9-0.2 l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4 l5.7,9C184.3-96.4,185.8-95.3,187.4-95.3z"/> </svg>
                <svg width="15" height="20" class="m3 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 61 56" style="enable-background:new 0 0 61 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-130.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-130.2z M-138.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-138.5-95.8z M161.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C170,16.4,166.3,15.3,161.3,15.3z M161.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L161.7,47.5z M-56.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-64-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 h-9.4l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-62.3-126.7-58.7-125.5-56.5-123.1z M4.3-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C13.1-125.6,9.4-126.7,4.3-126.7z M4.8-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L4.8-94.5z M50.5-126.2c2.2,0.4,3.6,0.7,4.2,1 l-2.7,7.1c-2.4-0.8-5.5-1.2-9.2-1.2c-5,0-7.8,1.1-8.2,3.4c-0.1,0.6-0.1,1.2,0.2,1.7c0.3,0.5,0.8,0.9,1.5,1.3 c0.8,0.4,1.5,0.7,2.1,0.9c0.6,0.2,1.6,0.5,3,0.9c1.7,0.5,3.2,1,4.4,1.6c1.2,0.5,2.3,1.3,3.4,2.2c1.1,0.9,1.8,2.1,2.1,3.5 c0.4,1.4,0.4,3.1,0,4.9c-0.8,4-2.7,6.9-5.9,8.8c-3.2,1.9-7.3,2.8-12.3,2.8c-2.1,0-4.1-0.2-6-0.5c-1.9-0.3-3.3-0.6-4.1-1l-1.3-0.5 l2.6-7.1c2.7,1.1,6.1,1.6,10.1,1.6c4.9,0,7.5-1.2,7.9-3.5c0.2-1.3-0.2-2.2-1.2-2.9c-1.1-0.6-2.8-1.3-5.3-2c-1.6-0.5-3-0.9-4.1-1.5 c-1.2-0.5-2.3-1.2-3.5-2.2c-1.2-0.9-2-2.1-2.4-3.6c-0.4-1.5-0.5-3.2-0.1-5.1c0.8-4,2.8-6.9,6.1-8.6c3.3-1.8,7.2-2.7,11.9-2.7 C46.1-126.7,48.4-126.5,50.5-126.2z M76-125.9h10l-1.4,7.5h-10l-3.1,16.5C70.6-97.3,72-95,75.7-95c0.8,0,1.6-0.1,2.5-0.2 c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5 l9.6-1.4L76-125.9z M118.1-125.9h9.4l-6.7,35.3c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9 c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4 c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L118.1-125.9z M156-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1 c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1C153.2-126.6,154.7-126.5,156-126.3z M188.4-95.3l1.9-0.2 l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4 l5.7,9C185.3-96.4,186.8-95.3,188.4-95.3z M58.9,19.2c2.2,2.4,2.8,6.4,1.7,12L56.3,54H47l4.5-23.7c0.5-2.9,0.2-4.8-0.9-5.7 c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3L33.1,54h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7 c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3L9.8,54H0.4l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9 c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6C53.1,15.6,56.7,16.8,58.9,19.2z"/> </svg>
                <svg width="15" height="20" class="a4 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 35 56" style="enable-background:new 0 0 35 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-131.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-131.2z M-139.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-139.5-95.8z M21.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9L9,24.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C30,16.4,26.3,15.3,21.3,15.3z M21.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L21.7,47.5z M-24.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-32-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 H-83l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-30.3-126.7-26.7-125.5-24.5-123.1z M3.3-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C12.1-125.6,8.4-126.7,3.3-126.7z M3.8-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L3.8-94.5z M49.5-126.2c2.2,0.4,3.6,0.7,4.2,1 l-2.7,7.1c-2.4-0.8-5.5-1.2-9.2-1.2c-5,0-7.8,1.1-8.2,3.4c-0.1,0.6-0.1,1.2,0.2,1.7c0.3,0.5,0.8,0.9,1.5,1.3 c0.8,0.4,1.5,0.7,2.1,0.9c0.6,0.2,1.6,0.5,3,0.9c1.7,0.5,3.2,1,4.4,1.6c1.2,0.5,2.3,1.3,3.4,2.2c1.1,0.9,1.8,2.1,2.1,3.5 c0.4,1.4,0.4,3.1,0,4.9c-0.8,4-2.7,6.9-5.9,8.8c-3.2,1.9-7.3,2.8-12.3,2.8c-2.1,0-4.1-0.2-6-0.5c-1.9-0.3-3.3-0.6-4.1-1l-1.3-0.5 l2.6-7.1c2.7,1.1,6.1,1.6,10.1,1.6c4.9,0,7.5-1.2,7.9-3.5c0.2-1.3-0.2-2.2-1.2-2.9c-1.1-0.6-2.8-1.3-5.3-2c-1.6-0.5-3-0.9-4.1-1.5 c-1.2-0.5-2.3-1.2-3.5-2.2c-1.2-0.9-2-2.1-2.4-3.6c-0.4-1.5-0.5-3.2-0.1-5.1c0.8-4,2.8-6.9,6.1-8.6c3.3-1.8,7.2-2.7,11.9-2.7 C45.1-126.7,47.4-126.5,49.5-126.2z M75-125.9h10l-1.4,7.5h-10l-3.1,16.5C69.6-97.3,71-95,74.7-95c0.8,0,1.6-0.1,2.5-0.2 c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5 l9.6-1.4L75-125.9z M117.1-125.9h9.4l-6.7,35.3c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9 c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4 c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L117.1-125.9z M155-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1 c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1C152.2-126.6,153.7-126.5,155-126.3z M187.4-95.3l1.9-0.2 l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4 l5.7,9C184.3-96.4,185.8-95.3,187.4-95.3z"/> </svg>
                <svg width="15" height="20" class="s5 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 34 56" style="enable-background:new 0 0 34 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-131.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-131.2z M-139.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-139.5-95.8z M160.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C169,16.4,165.3,15.3,160.3,15.3z M160.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L160.7,47.5z M-57.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-65-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 h-9.4l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-63.3-126.7-59.7-125.5-57.5-123.1z M3.3-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C12.1-125.6,8.4-126.7,3.3-126.7z M3.8-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L3.8-94.5z M29.5,15.8c2.2,0.4,3.6,0.7,4.2,1 L31,23.8c-2.4-0.8-5.5-1.2-9.2-1.2c-5,0-7.8,1.1-8.2,3.4c-0.1,0.6-0.1,1.2,0.2,1.7c0.3,0.5,0.8,0.9,1.5,1.3c0.8,0.4,1.5,0.7,2.1,0.9 c0.6,0.2,1.6,0.5,3,0.9c1.7,0.5,3.2,1,4.4,1.6c1.2,0.5,2.3,1.3,3.4,2.2c1.1,0.9,1.8,2.1,2.1,3.5c0.4,1.4,0.4,3.1,0,4.9 c-0.8,4-2.7,6.9-5.9,8.8c-3.2,1.9-7.3,2.8-12.3,2.8c-2.1,0-4.1-0.2-6-0.5c-1.9-0.3-3.3-0.6-4.1-1l-1.3-0.5l2.6-7.1 c2.7,1.1,6.1,1.6,10.1,1.6c4.9,0,7.5-1.2,7.9-3.5c0.2-1.3-0.2-2.2-1.2-2.9c-1.1-0.6-2.8-1.3-5.3-2c-1.6-0.5-3-0.9-4.1-1.5 c-1.2-0.5-2.3-1.2-3.5-2.2c-1.2-0.9-2-2.1-2.4-3.6c-0.4-1.5-0.5-3.2-0.1-5.1c0.8-4,2.8-6.9,6.1-8.6c3.3-1.8,7.2-2.7,11.9-2.7 C25.1,15.3,27.4,15.5,29.5,15.8z M75-125.9h10l-1.4,7.5h-10l-3.1,16.5C69.6-97.3,71-95,74.7-95c0.8,0,1.6-0.1,2.5-0.2 c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5 l9.6-1.4L75-125.9z M117.1-125.9h9.4l-6.7,35.3c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9 c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4 c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L117.1-125.9z M155-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1 c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1C152.2-126.6,153.7-126.5,155-126.3z M187.4-95.3l1.9-0.2 l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4 l5.7,9C184.3-96.4,185.8-95.3,187.4-95.3z"/> </svg>
                <svg width="15" height="20" class="t6 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 26 56" style="enable-background:new 0 0 26 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-131.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-131.2z M-139.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-139.5-95.8z M160.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C169,16.4,165.3,15.3,160.3,15.3z M160.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L160.7,47.5z M-57.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-65-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 h-9.4l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-63.3-126.7-59.7-125.5-57.5-123.1z M3.3-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C12.1-125.6,8.4-126.7,3.3-126.7z M3.8-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L3.8-94.5z M75-125.9h10l-1.4,7.5h-10l-3.1,16.5 C69.6-97.3,71-95,74.7-95c0.8,0,1.6-0.1,2.5-0.2c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6 c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5l9.6-1.4L75-125.9z M117.1-125.9h9.4l-6.7,35.3 c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8 h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L117.1-125.9z M155-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1 C152.2-126.6,153.7-126.5,155-126.3z M187.4-95.3l1.9-0.2l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8 l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4l5.7,9C184.3-96.4,185.8-95.3,187.4-95.3z M15.4,16.1h10L24,23.5H14 l-3.1,16.5c-0.9,4.6,0.5,6.9,4.2,6.9c0.8,0,1.6-0.1,2.5-0.2c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6 c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5H0l1.4-7.5h4.6l1.8-9.5l9.6-1.4L15.4,16.1z"/> </svg>
                <svg width="15" height="20" class="u7 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 39 56" style="enable-background:new 0 0 39 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-130.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-130.2z M-138.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-138.5-95.8z M161.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C170,16.4,166.3,15.3,161.3,15.3z M161.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L161.7,47.5z M-56.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-64-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 h-9.4l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-62.3-126.7-58.7-125.5-56.5-123.1z M4.3-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C13.1-125.6,9.4-126.7,4.3-126.7z M4.8-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L4.8-94.5z M76-125.9h10l-1.4,7.5h-10l-3.1,16.5 C70.6-97.3,72-95,75.7-95c0.8,0,1.6-0.1,2.5-0.2c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6 c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5l9.6-1.4L76-125.9z M118.1-125.9h9.4l-6.7,35.3 c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8 h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L118.1-125.9z M156-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1 C153.2-126.6,154.7-126.5,156-126.3z M188.4-95.3l1.9-0.2l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8 l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4l5.7,9C185.3-96.4,186.8-95.3,188.4-95.3z M29.1,16h9.4l-6.7,35.3 c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1L5.6,16 h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L29.1,16z"/> </svg>
                <svg width="15" height="20" class="r8 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 27 56" style="enable-background:new 0 0 27 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-142.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-142.2z M-150.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-150.5-95.8z M149.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C158,16.4,154.3,15.3,149.3,15.3z M149.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L149.7,47.5z M-68.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-76-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 h-9.4l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-74.3-126.7-70.7-125.5-68.5-123.1z M-7.7-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C1.1-125.6-2.6-126.7-7.7-126.7z M-7.2-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L-7.2-94.5z M64-125.9h10l-1.4,7.5h-10l-3.1,16.5 C58.6-97.3,60-95,63.7-95c0.8,0,1.6-0.1,2.5-0.2c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6 c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5l9.6-1.4L64-125.9z M106.1-125.9h9.4l-6.7,35.3 c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8 h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L106.1-125.9z M144-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1 C141.2-126.6,142.7-126.5,144-126.3z M176.4-95.3l1.9-0.2l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8 l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4l5.7,9C173.3-96.4,174.8-95.3,176.4-95.3z M26.6,16l-2,7.8 c-0.4,0-1.2-0.1-2.4-0.1c-2.2,0-4.5,0.3-6.8,1L9.8,54H0.4L7,18.8c4.2-2,9.3-3.1,15.1-3.1C23.8,15.7,25.3,15.8,26.6,16z"/> </svg>
                <svg width="15" height="20" class="k9 animate__animated" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 41 56" style="enable-background:new 0 0 41 56;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><path class="st0" d="M-142.2-140l-2.7,14.2c-2.2-0.6-4.4-0.9-6.4-0.9c-11.5,0-18.5,6.5-21,19.6c-1.2,6.5-0.7,11.4,1.5,14.7 c2.2,3.3,6.5,4.9,12.8,4.9c2.6,0,5.3-0.3,8-0.9s4.6-1.1,5.6-1.4c0.9-0.3,1.7-0.6,2.2-0.9l9.3-49.4H-142.2z M-150.5-95.8 c-1.7,0.5-3.7,0.8-6,0.8c-3.3,0-5.3-1-6.2-3.1c-0.9-2-0.9-5.1-0.2-9c0.7-3.9,1.9-6.9,3.6-9c1.7-2,4.1-3.1,7.3-3.1 c2.1,0,4,0.3,5.7,0.9L-150.5-95.8z M149.3,15.3c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C158,16.4,154.3,15.3,149.3,15.3z M149.7,47.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L149.7,47.5z M-68.5-123.1c2.2,2.4,2.8,6.4,1.7,12 l-4.3,22.8h-9.4L-76-112c0.5-2.9,0.2-4.8-0.9-5.7c-1.2-1-2.8-1.5-4.9-1.5c-2.6,0-5.2,0.6-7.8,1.8c0.1,1.9,0,4-0.4,6.3l-4.3,22.8 h-9.4l4.5-23.7c0.5-2.9,0.3-4.8-0.8-5.7c-1.1-1-2.7-1.4-5-1.4c-1.2,0-2.4,0.1-3.5,0.2c-1.1,0.2-2,0.3-2.5,0.4l-0.9,0.3l-5.7,29.9 h-9.4l6.7-35.3c0.5-0.2,1.3-0.5,2.3-0.9c1-0.3,3-0.8,6-1.4c3-0.6,5.9-0.9,8.8-0.9c4.8,0,8.3,0.9,10.5,2.6c4.4-1.7,8.8-2.6,13.2-2.6 C-74.3-126.7-70.7-125.5-68.5-123.1z M-7.7-126.7c-5.3,0-10,0.9-14.2,2.7l0.5,6.9l1.4-0.5c0.9-0.4,2.3-0.7,4.1-1.1 c1.8-0.3,3.5-0.5,5.3-0.5c5.4,0,7.7,2,7,6.1l-0.8,4.2c-1.9-0.3-4-0.5-6.4-0.5c-10.4,0-16.3,3.7-17.7,11c-1.4,7.3,3.1,11,13.4,11 c2.9,0,5.9-0.3,8.8-0.9c2.9-0.6,4.8-1.1,5.7-1.4c0.9-0.3,1.6-0.6,2.1-0.9l4.2-22.2c0.9-4.9,0.2-8.5-2.1-10.6 C1.1-125.6-2.6-126.7-7.7-126.7z M-7.2-94.5l-0.9,0.2c-0.5,0.2-1.3,0.3-2.4,0.5c-1.1,0.1-2.1,0.2-3.2,0.2c-2,0-3.6-0.3-4.6-1 c-1-0.7-1.3-1.9-1-3.7c0.4-1.9,1.2-3.1,2.6-3.8s3.2-1,5.5-1c1.4,0,3.2,0.1,5.5,0.4L-7.2-94.5z M64-125.9h10l-1.4,7.5h-10l-3.1,16.5 C58.6-97.3,60-95,63.7-95c0.8,0,1.6-0.1,2.5-0.2c0.9-0.2,1.5-0.3,2-0.5l0.7-0.2l-0.2,6.9c-2.2,1.1-5,1.6-8.5,1.6 c-8.5,0-11.9-4.8-10.1-14.4l3.1-16.5h-4.6l1.4-7.5h4.6l1.8-9.5l9.6-1.4L64-125.9z M106.1-125.9h9.4l-6.7,35.3 c-0.6,0.2-1.4,0.5-2.4,0.9c-1,0.3-3,0.8-6,1.4c-3,0.6-5.9,0.9-8.7,0.9c-5.6,0-9.5-1.2-11.8-3.5c-2.3-2.3-2.8-6.4-1.8-12.1l4.3-22.8 h9.3l-4.5,23.7c-0.5,2.9-0.2,4.8,1,5.7c1.2,1,3,1.4,5.4,1.4c1.1,0,2.3-0.1,3.4-0.2c1.1-0.2,1.9-0.3,2.5-0.5l0.9-0.2L106.1-125.9z M144-126.3l-2,7.8c-0.4,0-1.2-0.1-2.4-0.1c-2.2,0-4.5,0.3-6.8,1l-5.6,29.4h-9.4l6.7-35.2c4.2-2,9.3-3.1,15.1-3.1 C141.2-126.6,142.7-126.5,144-126.3z M176.4-95.3l1.9-0.2l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8 l-3.1,16.4h-9.4l9.8-51.7h9.4l-5.9,31.1l16.2-17h10.5l-17.7,18.4l5.7,9C173.3-96.4,174.8-95.3,176.4-95.3z M33.2,47.6l1.9-0.2 l-1.3,6.9c-1.2,0.6-2.7,0.9-4.6,0.9c-3.7,0-6.8-2-9.4-6.1l-6.7-10.8L10,54.6H0.6l9.8-51.7h9.4L13.9,34l16.2-17h10.5L22.9,35.4l5.7,9 C30,46.6,31.5,47.6,33.2,47.6z"/> </svg>
            </div>-->
            <div class="copyright animate__animated"><?= trans("front.View the intellectual property rights of damasturk"); ?> © <span class="num"><?= date('Y'); ?></span> <br> <span class="num">(Fikri Mülkiyet Hakları)</span> </div>
        </div>


        <?php if (App::isLocal()) { ?>
            <?= Html::script("resources/assets/js/jquery1.12.4.min.js"); ?>
            <?= Html::script("resources/assets/js/popper.min.js"); ?>
            <?= Html::script("resources/assets/js/bootstrap.min.js"); ?>

            <!--<?php // Html::script("resources/assets/js/jquery-2.2.4.min.js");                                                                                                            ?>-->

            <!-- <?php // Html::script("resources/assets/js/bootstrap.min.js");                                                                                                             ?>-->
            <!-- <?php // Html::script("resources/assets/js/jquery-3.2.1.slim.min.js");                                                                                                             ?>-->

            <!--<?= Html::script("resources/assets/js/owl.carousel.js"); ?>-->
            <?= Html::script('resources/assets/js/bootstrap-select.js'); ?>

            <?= Html::script("resources/assets/js/intlTelInput.js"); ?>
            <?= Html::script("resources/assets/js/coolshare.js"); ?>
            <?= Html::script("resources/assets/js/jquery.lazy.min.js"); ?>
            <?= Html::script("resources/assets/js/jquery.fancybox.min.js"); ?>
            <?= Html::script("resources/assets/js/jquery-ui-autocomplete.js"); ?>
            <?= Html::script("resources/assets/js/main.js"); ?>
        <?php } else { ?>
            <?= Html::script("js/landing2.min.js") ?>
            <?= Html::script("js/bootstrap.min.js"); ?>
			<?= Html::script('js/bootstrap-select.min.js'); ?>
        <?php } ?>

        <script>


            $(document).ready(function () {
                var i = 1;
                var off_length = $('.offers_list .offer_item').length;
                $('.offers_list .offer_item').each(function () {

                    $(this).find('.ready_sec').find('strong').html(i + ' / ' + off_length);
                    i++;
                });
            });
            $('.slider__button-next').click(function () {
                var thisScroll = $(this).parents(".slider").find(".slider__wrap");
                var right = $(thisScroll).scrollLeft() + 200;
                $(thisScroll).scrollLeft(right);
            });
            $('.slider__button-prev').click(function () {
                var thisScroll = $(this).parents(".slider").find(".slider__wrap");
                var left = $(thisScroll).scrollLeft() - 200;
                $(thisScroll).scrollLeft(left);
            });


            //** Loading images **//
            /*$('.lazy').Lazy({
                afterLoad: function (element) {
                    element.addClass("loaded");
                    element.parents(".item").addClass("loaded");
                }
            });*/


            /* input tel flag */
            $("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").intlTelInput({
                preferredCountries: ["undif", "sa", "tr", "qa", "sy", "iq", "kw", "bh", "ae", "ye", "jo", "dz", "ly", "eg", "sd", "om"]
            });

            $('form input,form textarea,form select').change(function () {
                $(this).removeClass('flash');
                $(this).parent('div').find('.has-form-error').remove();
            });

            $("body").on("submit", "#form-callus, #form-callus-lg, #form-callus-floating, #form-callus-landing, #form-callus-chat", function (e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find("button[type=submit]");
                var btn2 = form.find("input[type=submit]");
                var act = form.attr("action");

                var tmessage = form.find('textarea[name=message]');
                /*if (tmessage.val() == '')
                 tmessage.val(tmessage.attr('placeholder'));*/

                var infos = form.serialize();
                btn.html("<i class='fa fa-spinner fa-spin'></i>");
                btn.attr("disabled", true);
                btn2.attr("disabled", true);
                $.post(act, infos, function (resp) {
                    form.find(".has-form-error").remove();
                    if (resp.input) {
                        form.find('*[name=' + resp.input + ']').removeClass("animated flash").addClass("animated flash").focus();
                        form.find('*[name=' + resp.input + ']').after("<small class='has-form-error error-" + resp.input + " text-danger'>" + resp.message + "</small>");
                    } else {
                        if (resp.url) {
                            window.location.href = resp.url;
                        } else if (resp.success) {
                            $(".form").fadeOut();
                            setTimeout(function () {
                                $(".shear-content").fadeIn();
                            }, 200);
                        } else if (resp.html) {
                            form.closest("#callus_content").html(resp.html);
                            liveChat();
                        } else {
                            alert(resp.message);
                        }
                        form.find(".form-control").val("");
                    }
                    btn.html('<img class="icon" src="https://damas.net/img/sendIconW.svg" class="img-responsive" alt="Send">');
                    btn.removeAttr("disabled");
                    btn2.removeAttr("disabled");
                });
                return false;
            });



            var counter = 1;

            $(".show_less_btn").hide();
            $(document).on("click", ".show_more_btn", function () {

                if (counter == 1) {
                    $('.content_section .cont').animate({'max-height': '400px'}, 200);
                    $('html, body').animate({
                        scrollTop: $('.content_section').offset().top - 100
                    }, 'slow');
                    $(".show_less_btn").show();
                    counter++;
                    return true;
                } else if (counter == 2) {
                    var height_div = $('.content_section .cont').css({'max-height': 'initial'}).height();
                    $('.content_section .cont').animate({'max-height': height_div}, 200);
                    $('html, body').animate({
                        scrollTop: $('.content_section').offset().top + 250
                    }, 'slow');
                    $(".show_more_btn").hide();
                    $(".show_less_btn").show();
                    $(".action_content").addClass("type_less");
                    return false;
                } else {
                    counter = 1;
                    return false;
                }

            });



            $(document).on("click", ".show_less_btn", function () {
                $('.content_section .cont').animate({'max-height': '86px'}, 300);
                $('html, body').animate({
                    scrollTop: $('.content_section').offset().top - 100
                }, 'slow');
                counter = 1;
                $(".action_content").removeClass("type_less");
                setTimeout(function () {
                    $(".show_less_btn").hide();
                    $(".show_more_btn").show();
                }, 300);
            });








            /*- Countdown Timer -*/

            function makeTimer(i, endTime) {

                var endTime = new Date(endTime);
                endTime = (Date.parse(endTime) / 1000);

                var now = new Date();
                now = (Date.parse(now) / 1000);

                var timeLeft = endTime - now;

                var days = Math.floor(timeLeft / 86400);
                var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
                var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
                var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));

                if (hours < "10") {
                    hours = "0" + hours;
                }
                if (minutes < "10") {
                    minutes = "0" + minutes;
                }
                if (seconds < "10") {
                    seconds = "0" + seconds;
                }

                $("#days" + i).html(days + "<span>Days</span>");
                $("#hours" + i).html(hours + "<span>Hours</span>");
                $("#minutes" + i).html(minutes + "<span>Minutes</span>");
                $("#seconds" + i).html(seconds + "<span>Seconds</span>");

            }

            /*
             setInterval(function () {
             
             }, 1000);
             */




            $('body').on('click', '.btnshare', function (e) {
                /*if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && $(this).attr('href')!='') {
                 alert('mob 00');
                 }else{
                 */
                e.preventDefault();
                var data_url = $(this).attr("data-url");
                var data_title = $(this).attr("data-text");
                if (!data_url) {
                    data_url = window.location.href;
                }
                if (!data_title) {
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
                if (typ == 'facebook') {
                    share_url = 'https://facebook.com/sharer.php?u=' + url;
                } else if (typ == 'twitter') {
                    share_url = 'https://twitter.com/intent/tweet?url=' + url + '&text=' + title + '&via=damasturk';
                } else if (typ == 'googleplus') {
                    share_url = 'https://plus.google.com/share?url=' + url;
                } else if (typ == 'linkedin') {
                    share_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' + url + '&title=' + title + '&source=damas.net';
                } else if (typ == 'whatsapp') {
                    share_url = 'https://api.whatsapp.com/send?text=' + title + ' ' + url;
                }



                if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) && $(this).attr('href') == '') {
                    window.open(share_url, '_blank');
                } else {
                    window.open(share_url, 'Social Share', 'toolbar=no, location=no, directories=no, status=no,' +
                            ' menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
                }

            });

        </script>


    </body>
</html>