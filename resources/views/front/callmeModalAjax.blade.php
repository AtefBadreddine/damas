<?php
if (!isset($availables_langs))
    $availables_langs = ['ar', 'en', 'fr', 'pe', 'ru'];


if (!isset($hide_whatsapp))
    $hide_whatsapp = false;

$current_lang = LaravelLocalization::getCurrentLocale();

$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';

?>
<!DOCTYPE html>
<html lang="<?= ($current_lang == 'pe' ? 'fa' : $current_lang); ?>" dir="<?= $style_lang == "ar" ? "ltr" : "ltr"; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php $infos = Helper::get_params(); ?>
        <title><?= $og_title = @$page_title ? $page_title : $infos->seo_title; ?></title>
        <link rel="shortcut icon" href="<?= asset("img/favicon.ico"); ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= asset("img/favicon.png"); ?>">
        <link rel="icon" type="image/png" href="<?= asset("img/favicon.png"); ?>" sizes="32x32">

        <link rel="canonical" href="<?= str_replace('/public/', '/', Request::url()); ?>" />


        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <?php /*        <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800,900&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,800,900&display=swap&subset=arabic" rel="stylesheet"> */ ?>



        <?php /* css and js */ ?>



        @if(isset($page) and $page=='vac')
        <?php /* <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0111/1113.js" async="async" ></script> */ ?>
        @endif

    </head>
    <body id="page-top">

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


            <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
                <style>
                    .rightMenuModal .modal-body ul.links_list{text-align: left; direction: ltr;}.complaints_btn span, .complaints_btn p{text-align: left;}.complaints_btn img{left: auto; right: 5px;}.rightMenuModal .join_our_team_btn .damasturk_logo{float: left; right: auto; left: auto;}.complaints_btn p{font-size: 13px;}
                </style>
            <?php } ?>








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



            <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
                <style>
                    .rightMenuModal .modal-body ul.links_list{text-align: left; direction: ltr;}.complaints_btn span, .complaints_btn p{text-align: left;}.complaints_btn img{left: auto; right: 5px;}.rightMenuModal .join_our_team_btn .damasturk_logo{float: left; right: auto; left: auto;}.complaints_btn p{font-size: 13px;}
                </style>
            <?php } ?>

    

            <?php if ($style_lang == 'en') { ?>
                <?= Html::style("css/style-en.min.css"); ?>
                                <!--<style><?php //include(public_path() . "/css/style-en.min.css");   ?></style>-->
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
					@font-face { font-family: 'Al-Jazeera-Arabic Bold'; src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot') }}'); src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.woff2') }}') format('woff2'); 
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
        






        <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800,900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,800,900&display=swap&subset=arabic" rel="stylesheet">
        
		
		
		
		
		
        <!-- Modal role="document" -->
        <div class=" fade callmeModal" id="callmeModal" tabindex="-1" role="dialog" aria-labelledby="callmeModalLabel" aria-hidden="true">
            <div class="modal_sec">

                <div class="image_cont">
                    <img loading="lazy" alt="damasturk" title="damasturk" src="https://damas.net/img/form-photo.jpg">
                </div>

                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title jazzira_font_bold" id="callmeModalLabel"><?= trans("front.keep in touch"); ?></span>

                    </div>
                    <div class="modal-body">

                        <ul class="social_media_icons">
                            <?php if ($hide_whatsapp == false) { ?>
                                <li>
                                    <a target="_blank" class="whatsappBtn faa-tada animated" href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000">
                                        <img loading="lazy" width="65" height="65" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="whatsapp-icon"/>
                                    </a>
                                </li>
                            <?php } ?>
                            <!--<li>
                                <a target="_blank" class="imoBtn faa-wrench animated" href="https://imo.im/">
                                    <img src="<?= asset("img/imo.svg"); ?>" alt="imo-icon"/>
                                </a>
                            </li>-->
                            <li>
                                <a target="_blank" class="viberBtn faa-horizontal animated" href="viber://chat?number=905551605000">
                                    <img loading="lazy" width="52" height="50" src="<?= asset("img/viber-w.svg"); ?>" alt="viber-icon"/>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" class="telegramBtn animated" href="https://t.me/damasturk_real_estate">
                                    {!! Helper::get_pic(asset("img/telegram.png"),'','','','telegram-icon', 'width="50" height="50"') !!}
                                </a>
                            </li>
                            <li>
                                <a target="_blank" class="massengerBtn faa-shake animated" href="https://m.me/damasturk">
                                    {!! Helper::get_pic(asset("img/messenger.png"),'','','','messenger-icon', 'width="50" height="50"') !!}
                                </a>
                            </li>
                            <li>
                                <a target="_blank" class="phoneBtn faa-ring animated" href="tel:<?= str_replace(' ', '', $infos->tel_1) ?>">
                                    <svg width="25" height="25" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 294.2 288.2" xml:space="preserve"> <g> <path d="M270.5,220.9c-0.6,3.1-1,6.3-1.9,9.3c-4.1,13.5-8.2,27.1-12.5,40.6c-4.4,14-13.8,19.6-28.2,16.8 C150,272.2,88.4,231.8,43.8,166c-9.8-14.5-18-30.1-24.9-46.5c-8.2-19.5-14.1-39.4-18.2-60c-2.4-12.4,2.2-22.1,14.1-26.2 C30.3,27.9,46,23,61.9,18.8c13.1-3.5,22.4,2.4,26.3,15.3c5.5,18,10.9,36,16.6,53.9c2.7,8.6,0.3,15.4-6.3,21 c-5.9,4.9-12.1,9.4-18,14.3c-6.5,5.3-7.3,10.9-2.5,17.9c18.7,27.4,41.8,50.4,69.1,69.2c7.2,4.9,12.7,4.1,18.2-2.7 c4.5-5.6,8.8-11.3,13.3-16.9c6.4-7.9,12.8-9.9,22.5-6.9c18,5.5,36,11,53.9,16.5C265.8,203.6,270.3,209.6,270.5,220.9z"/> <path d="M294.2,142.3c-0.2,1.1,0,3.7-0.9,5.9c-1.1,2.8-8.6,4.7-12.6,2.6c-2.2-1.1-4.4-4.4-4.5-6.8 c-2.8-63.1-53.6-117.7-116.5-124.9c-3-0.3-6-0.7-8.9-0.9c-6.4-0.5-8.3-3.1-7.9-11.1c0.3-5.3,2.7-7.5,8.6-7.1 c32.4,1.9,61.5,12.8,86.7,33.3c32.4,26.4,50.7,60.7,55.7,102.1C294,137.3,294,139.2,294.2,142.3z"/> <path d="M241.9,140.7c-0.3,7.9-2.3,10.5-7,10.8c-8,0.5-10.2-1.2-11.3-8.3c-5.7-40.4-33-67.5-73.5-72.7c-6.5-0.8-8.2-3.7-7.3-12 c0.5-4.6,3.2-6.6,9-6.1c42.1,3.6,78.5,34.3,88.1,77.3C240.9,133.8,241.5,138.1,241.9,140.7z"/> </g> </svg>
                                </a>
                            </li>
                        </ul>


                        <section class="form form_sec">
                            @include("front.partials.call_us_fixed")
                        </section>
                    </div>

                    <img loading="lazy" class="logo" src="<?= asset("/img/damasturk.svg"); ?>" alt="damasturk"/>
                    <svg class="logo" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 139.9 20.6" style="enable-background:new 0 0 139.9 20.6;" xml:space="preserve"><style type="text/css">.st0{fill:url(#SVGID_1_);}</style><linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="69.9741" y1="20.5996" x2="69.9741" y2="-9.094947e-13"><stop offset="4.475343e-07" style="stop-color:#D0D0D0"/><stop offset="7.444685e-02" style="stop-color:#D6D6D6"/><stop offset="0.4946" style="stop-color:#F4F4F4"/><stop offset="0.7328" style="stop-color:#FFFFFF"/></linearGradient><path class="st0" d="M12.1,0l-1,5.6c-0.9-0.2-1.7-0.3-2.5-0.3c-4.5,0-7.3,2.6-8.2,7.7c-0.5,2.6-0.3,4.5,0.6,5.8c0.9,1.3,2.6,1.9,5,1.9c1,0,2.1-0.1,3.1-0.3s1.8-0.4,2.2-0.5c0.4-0.1,0.7-0.2,0.9-0.3L15.7,0H12.1z M8.8,17.3c-0.7,0.2-1.5,0.3-2.4,0.3c-1.3,0-2.1-0.4-2.4-1.2c-0.3-0.8-0.4-2-0.1-3.5c0.3-1.5,0.8-2.7,1.4-3.5C6,8.6,7,8.2,8.2,8.2c0.8,0,1.6,0.1,2.2,0.3L8.8,17.3z M24,5.2c-2.1,0-3.9,0.4-5.6,1.1L18.6,9l0.5-0.2c0.4-0.1,0.9-0.3,1.6-0.4c0.7-0.1,1.4-0.2,2.1-0.2c2.1,0,3,0.8,2.7,2.4l-0.3,1.6c-0.7-0.1-1.6-0.2-2.5-0.2c-4.1,0-6.4,1.4-6.9,4.3c-0.5,2.9,1.2,4.3,5.3,4.3c1.2,0,2.3-0.1,3.4-0.3c1.1-0.2,1.9-0.4,2.2-0.5c0.4-0.1,0.6-0.2,0.8-0.3l1.6-8.7c0.4-1.9,0.1-3.3-0.8-4.2C27.4,5.6,26,5.2,24,5.2z M24.2,17.9l-0.3,0.1c-0.2,0.1-0.5,0.1-0.9,0.2c-0.4,0.1-0.8,0.1-1.2,0.1c-0.8,0-1.4-0.1-1.8-0.4c-0.4-0.3-0.5-0.8-0.4-1.5c0.1-0.7,0.5-1.2,1-1.5c0.5-0.3,1.2-0.4,2.2-0.4c0.5,0,1.3,0.1,2.2,0.2L24.2,17.9z M53.9,6.6c0.9,1,1.1,2.5,0.7,4.7l-1.7,8.9h-3.7L51,11c0.2-1.1,0.1-1.9-0.4-2.3c-0.5-0.4-1.1-0.6-1.9-0.6c-1,0-2.1,0.2-3.1,0.7c0.1,0.7,0,1.6-0.2,2.5l-1.7,8.9h-3.7l1.8-9.3c0.2-1.1,0.1-1.9-0.3-2.2c-0.4-0.4-1.1-0.6-2-0.6c-0.5,0-0.9,0-1.4,0.1c-0.4,0.1-0.8,0.1-1,0.2l-0.3,0.1l-2.2,11.7H31l2.6-13.8c0.2-0.1,0.5-0.2,0.9-0.3c0.4-0.1,1.2-0.3,2.4-0.5c1.2-0.2,2.3-0.3,3.5-0.3c1.9,0,3.3,0.3,4.1,1c1.7-0.7,3.5-1,5.2-1C51.6,5.2,53.1,5.7,53.9,6.6z M64.8,5.2c-2.1,0-3.9,0.4-5.6,1.1L59.4,9L60,8.8c0.4-0.1,0.9-0.3,1.6-0.4c0.7-0.1,1.4-0.2,2.1-0.2c2.1,0,3,0.8,2.7,2.4l-0.3,1.6c-0.7-0.1-1.6-0.2-2.5-0.2c-4.1,0-6.4,1.4-6.9,4.3c-0.5,2.9,1.2,4.3,5.3,4.3c1.2,0,2.3-0.1,3.4-0.3c1.1-0.2,1.9-0.4,2.2-0.5c0.4-0.1,0.6-0.2,0.8-0.3l1.6-8.7c0.4-1.9,0.1-3.3-0.8-4.2C68.2,5.6,66.8,5.2,64.8,5.2z M65,17.9l-0.3,0.1c-0.2,0.1-0.5,0.1-0.9,0.2c-0.4,0.1-0.8,0.1-1.2,0.1c-0.8,0-1.4-0.1-1.8-0.4c-0.4-0.3-0.5-0.8-0.4-1.5c0.1-0.7,0.5-1.2,1-1.5c0.5-0.3,1.2-0.4,2.2-0.4c0.5,0,1.3,0.1,2.2,0.2L65,17.9z M82.9,5.4c0.9,0.1,1.4,0.3,1.7,0.4l-1.1,2.8c-1-0.3-2.2-0.5-3.6-0.5c-2,0-3,0.4-3.2,1.3c0,0.2,0,0.5,0.1,0.7c0.1,0.2,0.3,0.4,0.6,0.5c0.3,0.1,0.6,0.3,0.8,0.3c0.3,0.1,0.6,0.2,1.2,0.3c0.7,0.2,1.2,0.4,1.7,0.6c0.5,0.2,0.9,0.5,1.3,0.9c0.4,0.4,0.7,0.8,0.8,1.4c0.1,0.6,0.1,1.2,0,1.9c-0.3,1.6-1.1,2.7-2.3,3.5c-1.3,0.7-2.9,1.1-4.8,1.1c-0.8,0-1.6-0.1-2.4-0.2c-0.7-0.1-1.3-0.2-1.6-0.4l-0.5-0.2l1-2.8c1.1,0.4,2.4,0.6,4,0.6c1.9,0,2.9-0.5,3.1-1.4c0.1-0.5-0.1-0.9-0.5-1.1c-0.4-0.2-1.1-0.5-2.1-0.8c-0.6-0.2-1.2-0.4-1.6-0.6c-0.5-0.2-0.9-0.5-1.4-0.9c-0.5-0.4-0.8-0.8-0.9-1.4c-0.2-0.6-0.2-1.2,0-2c0.3-1.6,1.1-2.7,2.4-3.4c1.3-0.7,2.8-1,4.7-1C81.2,5.2,82.1,5.3,82.9,5.4z M92.9,5.5h3.9l-0.6,2.9h-3.9l-1.2,6.5c-0.3,1.8,0.2,2.7,1.7,2.7c0.3,0,0.6,0,1-0.1c0.3-0.1,0.6-0.1,0.8-0.2l0.3-0.1L94.8,20c-0.9,0.4-2,0.6-3.3,0.6c-3.3,0-4.7-1.9-3.9-5.7l1.2-6.5h-1.8l0.6-2.9h1.8L90,1.8l3.8-0.5L92.9,5.5z M109.4,5.5h3.7l-2.6,13.8c-0.2,0.1-0.5,0.2-0.9,0.3c-0.4,0.1-1.2,0.3-2.3,0.5c-1.2,0.2-2.3,0.3-3.4,0.3c-2.2,0-3.7-0.5-4.6-1.4c-0.9-0.9-1.1-2.5-0.7-4.8l1.7-8.9h3.7l-1.8,9.3c-0.2,1.1-0.1,1.9,0.4,2.2c0.5,0.4,1.2,0.6,2.1,0.6c0.4,0,0.9,0,1.3-0.1c0.4-0.1,0.8-0.1,1-0.2l0.3-0.1L109.4,5.5z M124.3,5.4l-0.8,3c-0.2,0-0.5,0-0.9,0c-0.9,0-1.7,0.1-2.7,0.4l-2.2,11.5H114l2.6-13.8c1.7-0.8,3.6-1.2,5.9-1.2C123.2,5.3,123.8,5.3,124.3,5.4z M137,17.5l0.7-0.1l-0.5,2.7c-0.5,0.2-1.1,0.3-1.8,0.3c-1.5,0-2.7-0.8-3.7-2.4l-2.6-4.2l-1.2,6.4h-3.7L128.1,0h3.7l-2.3,12.2l6.4-6.7h4.1l-6.9,7.2l2.2,3.5C135.8,17.1,136.4,17.5,137,17.5z"/></svg>

                    <?php /*
                      <!--                    <svg class="logo" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 356.84 52.53" xml:space="preserve"><path class="st0" d="M30.75,0l-2.67,14.15c-2.25-0.59-4.39-0.88-6.43-0.88c-11.52,0-18.52,6.53-20.98,19.59 c-1.23,6.53-0.73,11.44,1.5,14.73c2.24,3.29,6.51,4.93,12.81,4.93c2.59,0,5.26-0.3,8.03-0.88s4.62-1.05,5.57-1.39 c0.95-0.34,1.69-0.62,2.24-0.85L40.13,0H30.75z M22.41,44.16c-1.74,0.54-3.74,0.82-6.01,0.82c-3.27,0-5.33-1.02-6.19-3.06 c-0.86-2.04-0.92-5.06-0.16-9.05c0.75-3.95,1.95-6.94,3.6-8.98c1.65-2.04,4.09-3.06,7.31-3.06c2.13,0,4.03,0.3,5.68,0.88 L22.41,44.16z M61.24,13.27c-5.31,0-10.04,0.91-14.19,2.72l0.46,6.94l1.38-0.48c0.93-0.36,2.29-0.71,4.08-1.05 c1.79-0.34,3.54-0.51,5.27-0.51c5.4,0,7.72,2.02,6.95,6.06l-0.78,4.15c-1.89-0.32-4.04-0.48-6.44-0.48 c-10.43,0-16.34,3.65-17.72,10.95c-1.38,7.3,3.1,10.95,13.44,10.95c2.95,0,5.87-0.3,8.77-0.88c2.9-0.59,4.8-1.05,5.71-1.39 c0.9-0.34,1.6-0.62,2.1-0.85l4.2-22.25c0.93-4.94,0.22-8.49-2.14-10.65C69.97,14.35,66.27,13.27,61.24,13.27z M61.68,45.52 l-0.85,0.2c-0.53,0.18-1.33,0.34-2.4,0.48c-1.07,0.14-2.13,0.2-3.17,0.2c-2.04,0-3.57-0.34-4.57-1.02 c-1.01-0.68-1.34-1.93-0.99-3.74c0.35-1.86,1.2-3.13,2.56-3.81s3.19-1.02,5.5-1.02c1.36,0,3.19,0.14,5.5,0.41L61.68,45.52z M137.47,16.91c2.2,2.43,2.77,6.43,1.71,12.01l-4.3,22.79h-9.39l4.47-23.68c0.54-2.86,0.23-4.77-0.92-5.75 c-1.15-0.97-2.78-1.46-4.86-1.46c-2.63,0-5.24,0.59-7.82,1.77c0.15,1.86,0,3.97-0.45,6.33l-4.3,22.79h-9.39l4.48-23.75 c0.54-2.86,0.28-4.76-0.79-5.72c-1.07-0.95-2.74-1.43-5-1.43c-1.22,0-2.41,0.08-3.55,0.24c-1.14,0.16-1.98,0.31-2.5,0.44l-0.87,0.27 l-5.65,29.94h-9.39l6.67-35.31c0.54-0.23,1.32-0.51,2.34-0.85c1.02-0.34,3.02-0.8,6.01-1.39c2.99-0.59,5.94-0.88,8.84-0.88 c4.81,0,8.3,0.86,10.47,2.58c4.41-1.72,8.81-2.58,13.21-2.58C131.61,13.27,135.27,14.48,137.47,16.91z M165.27,13.27 c-5.31,0-10.04,0.91-14.19,2.72l0.46,6.94l1.38-0.48c0.93-0.36,2.29-0.71,4.08-1.05c1.79-0.34,3.54-0.51,5.27-0.51 c5.4,0,7.72,2.02,6.95,6.06l-0.78,4.15c-1.89-0.32-4.04-0.48-6.44-0.48c-10.43,0-16.34,3.65-17.72,10.95 c-1.38,7.3,3.1,10.95,13.44,10.95c2.95,0,5.87-0.3,8.77-0.88c2.9-0.59,4.8-1.05,5.71-1.39c0.9-0.34,1.6-0.62,2.1-0.85l4.2-22.25 c0.93-4.94,0.22-8.49-2.14-10.65C174,14.35,170.3,13.27,165.27,13.27z M165.71,45.52l-0.85,0.2c-0.53,0.18-1.33,0.34-2.4,0.48 c-1.07,0.14-2.13,0.2-3.17,0.2c-2.04,0-3.57-0.34-4.57-1.02c-1.01-0.68-1.34-1.93-0.99-3.74c0.35-1.86,1.2-3.13,2.56-3.81 s3.19-1.02,5.5-1.02c1.36,0,3.19,0.14,5.5,0.41L165.71,45.52z M211.46,13.81c2.18,0.36,3.58,0.68,4.21,0.95l-2.7,7.08 c-2.43-0.82-5.48-1.22-9.16-1.22c-5.04,0-7.77,1.13-8.2,3.4c-0.12,0.64-0.05,1.19,0.2,1.67c0.25,0.48,0.76,0.9,1.53,1.26 c0.77,0.36,1.47,0.66,2.11,0.88c0.64,0.23,1.63,0.52,2.96,0.88c1.72,0.5,3.19,1.02,4.4,1.57c1.21,0.54,2.35,1.27,3.4,2.18 c1.05,0.91,1.76,2.08,2.13,3.5c0.37,1.43,0.37,3.07,0.02,4.93c-0.75,3.99-2.73,6.93-5.92,8.81c-3.19,1.88-7.28,2.82-12.27,2.82 c-2.13,0-4.14-0.16-6.03-0.48c-1.89-0.32-3.26-0.64-4.11-0.95l-1.27-0.48l2.56-7.08c2.74,1.09,6.11,1.63,10.1,1.63 c4.85,0,7.5-1.16,7.93-3.47c0.24-1.27-0.17-2.22-1.23-2.86c-1.06-0.63-2.82-1.29-5.27-1.97c-1.59-0.45-2.97-0.94-4.15-1.46 c-1.17-0.52-2.34-1.25-3.5-2.18c-1.16-0.93-1.96-2.13-2.38-3.61c-0.43-1.47-0.46-3.16-0.1-5.07c0.75-3.99,2.77-6.87,6.05-8.64 c3.28-1.77,7.24-2.65,11.86-2.65C207.02,13.27,209.29,13.45,211.46,13.81z M236.96,14.08h10l-1.41,7.48h-10l-3.12,16.53 c-0.87,4.58,0.54,6.87,4.21,6.87c0.77,0,1.59-0.08,2.46-0.24c0.87-0.16,1.55-0.33,2.03-0.51l0.72-0.2l-0.21,6.87 c-2.2,1.09-5.05,1.63-8.54,1.63c-8.53,0-11.88-4.81-10.07-14.42l3.12-16.53h-4.63l1.41-7.48h4.63l1.8-9.53l9.65-1.36L236.96,14.08z M279.08,14.08h9.39L281.8,49.4c-0.59,0.23-1.38,0.51-2.37,0.85c-0.99,0.34-2.99,0.81-5.98,1.39c-2.99,0.59-5.89,0.88-8.71,0.88 c-5.58,0-9.5-1.17-11.76-3.5c-2.26-2.33-2.84-6.38-1.75-12.14l4.3-22.79h9.32l-4.48,23.75c-0.54,2.86-0.22,4.76,0.96,5.72 c1.18,0.95,2.97,1.43,5.38,1.43c1.13,0,2.26-0.08,3.38-0.24c1.12-0.16,1.94-0.33,2.48-0.51l0.85-0.2L279.08,14.08z M316.91,13.68 l-2.01,7.76c-0.4-0.04-1.19-0.07-2.37-0.07c-2.18,0-4.46,0.32-6.85,0.95l-5.55,29.39h-9.39l6.66-35.24 c4.24-2.04,9.26-3.06,15.07-3.06C314.15,13.4,315.63,13.49,316.91,13.68z M349.36,44.7l1.88-0.21l-1.3,6.87 c-1.2,0.59-2.73,0.88-4.59,0.88c-3.72,0-6.85-2.04-9.39-6.12l-6.67-10.82l-3.1,16.4h-9.39L326.57,0h9.39l-5.87,31.09l16.21-17.01 h10.55l-17.69,18.37l5.71,9.05C346.18,43.64,347.68,44.7,349.36,44.7z"/> </svg>--> */ ?>
                </div>
            </div>
        </div>
		
		
        <?php if (App::isLocal()) { ?>

            <?php /* Html::script("https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"); ?>
              <?= Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"); */ ?>

            <?= Html::script("resources/assets/js/jquery1.12.4.min.js"); ?>
            <?= Html::script("resources/assets/js/popper.min.js"); ?>
            <?= Html::script("resources/assets/js/bootstrap.min.js"); ?>

            <!--<?php // Html::script("resources/assets/js/jquery-2.2.4.min.js");                                                                                                  ?>-->

            <!-- <?php // Html::script("resources/assets/js/bootstrap.min.js");                                                                                                   ?>-->
            <!-- <?php // Html::script("resources/assets/js/jquery-3.2.1.slim.min.js");                                                                                                   ?>-->

            <!--<?= Html::script("resources/assets/js/owl.carousel.js"); ?>-->
            <?= Html::script('resources/assets/js/bootstrap-select.js'); ?>

            <?= Html::script("resources/assets/js/intlTelInput.js"); ?>
            <?= Html::script("resources/assets/js/coolshare.js"); ?>
            <?= Html::script("resources/assets/js/jquery.lazy.min.js"); ?>
            <?= Html::script("resources/assets/js/jquery.fancybox.min.js"); ?>
            <?= Html::script("resources/assets/js/jquery-ui-autocomplete.js"); ?>
            <?= Html::script("resources/assets/js/main.js"); ?>




        <?php } else { ?>                         


				<script type="text/javascript" src="{{ asset('js/main.min.js') }}?v=07"></script>

        <?php } ?>
		
	<script>
	/*			$("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").intlTelInput({
    preferredCountries: ["undif", "sa", "tr", "qa", "sy", "iq", "kw", "bh", "ae", "ye", "jo", "dz", "ly", "eg", "sd", "om"]
});*/
				
				<?php
				$get = '';
				foreach($_GET as $k=>$v){
					if($get=='')
						$get = $k . '=' . $v;
					else
						$get = $get .'&'. $k . '=' . $v;
				}
				if(isset($_GET['sHTTP_REFERER']) && isset($_GET['sREQUEST_URI'])){
					$js_gets = "";
				}else{
					$js_gets = "'&sHTTP_REFERER=' + encodeURIComponent(document.referrer) + '&sREQUEST_URI=' + '/' + encodeURIComponent(window.location.pathname.substr(1))";
				}
				?>
				$.getJSON( "{{ route('front.ajax','call_country')  }}?{{ $get }}" + <?= $js_gets ?> , function(data){
					var call_ctry = data.call_country;
					$('input[name=mobile]').val(call_ctry);
					$('input[name=phone]').val(call_ctry);
					
					
					
					call_ctry = call_ctry.replace('+','');
					var country_abr = $('input[name=mobile]:eq(0)').parent('div').find('.country-list').find('li[data-dial-code="'+call_ctry+'"]').data('country-code');
					$('input[name=mobile]').parent('div').find('.selected-flag').find('.flag').attr('class','flag '+country_abr);
					$('input[name=phone]').parent('div').find('.selected-flag').find('.flag').attr('class','flag '+country_abr);
					
					
				});
				
       



                /*$(document).on('click', '.support_links_btn', function () {
                    $.fancybox.open({
                        src: '#callmeModal',
                        type: 'inline'
                    });
                });*/






            $("input[name=mobile]").keydown((function (e) {
                if (e.keyCode != 8 && e.keyCode != 107 && e.keyCode != 37 && e.keyCode != 39)
                    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105))
                        e.preventDefault();
            }));
			
        </script>

    </body>
</html>