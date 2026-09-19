<?php
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



        <title>{{ $landing->getSeoTitle() }}</title>
        <link rel="canonical" href="<?= Request::url(); ?>" />
        <meta property="og:url" content="<?= Request::url(); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ $landing->getSeoTitle() }}" />
        <meta property="og:image" content="" />
        <meta property="og:image:width" content="900" />
        <meta property="og:image:height" content="500" />

        <meta property="og:description" content="{{ $landing->getSeoDescription() }}">
        <meta name="description" content="{{ $landing->getSeoDescription() }}">


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
                /*                background-image: url('/img/pattern-body.svg');
                                background-repeat: repeat-y;
                                background-size: 100%;*/
                background-color: #dceae8;
            }

            .full_sections {
                padding-top: 40px;
            }
            .landing_header .main_menu{
                background-image: linear-gradient(to right, #0b7f7f 0,#008b8c 100%) !important;
                -webkit-box-shadow: 0px 2px 3px 0px rgba(95, 95, 95,1) !important;
            }
            .main_menu{
                padding-left: 20px;
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
                width: 155px;
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
            #gifts_sec .item{
                padding: 30px;
            }
            #gifts_sec .item_image{
                width: 100%;
                border-radius: 10px;
                overflow: hidden;
                -webkit-box-shadow: 0px 0px 30px 0px rgb(176, 176, 176);
                -moz-box-shadow: 0px 0px 30px 0px rgb(176, 176, 176);
                box-shadow: 0px 0px 30px 0px rgb(176, 176, 176);
            }


        </style>


        <?php if (App::isLocal()) { ?>
            <!-- <?= Html::style("/assets/css/bootstrap.min.css") ?>-->
            <?= Html::style("resources/assets/css/intlTelInput.css") ?>
            <?= Html::style("resources/assets/css/jquery.fancybox.min.css") ?>

            <!--            <?= Html::style("resources/assets/css/global.css") ?>-->
            <?= Html::style("resources/assets/css/slider-project-card.css") ?>
            <!-- <?= Html::style("resources/assets/css/offers.css") ?>-->
            <?= Html::style("resources/assets/css/landing2.css") ?>


            <?php if ($current_lang == 'en' || $current_lang == 'fr') { ?>
                <?= Html::style("resources/assets/css/landing2-en.css"); ?>
            <?php } ?>

            <?php if ($current_lang == 'ru') { ?>
                <?= Html::style("resources/assets/css/landing2-ru.css"); ?>
            <?php } ?>


        <?php } else { ?>


            <?= Html::style("css/landing2.min.css"); ?>

            <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
                <?= Html::style("css/landing2-en.min.css"); ?>
            <?php } ?>
            <?php if ($current_lang == 'ru') { ?>
                <?= Html::style("css/landing2-ru.min.css"); ?>
            <?php } ?>


        <?php } ?>


            <?= Html::style("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css"); ?>
            <?= Html::style("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css"); ?>
            
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


        <script>
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
        </script>

        <style>

        </style>

    </head>

    <body class="type_3">


        <!-- Start Header -->
        <div class="landing_header">
            <div class="main_menu">
                <a href="#"> <img width="160" height="123" class="flag_header" src="<?= asset("img/Flag-Header.svg"); ?>" alt="damasturk"/></a>
                <a class="navbar-brand full" href="{{ route('front.index') }}">
                    <img width="210" height="76" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
                </a>

            </div>
        </div>
        <!-- End Header -->

        <div class="col-md-10 offset-md-1">
            <div class="full_sections">


                <div class="left_sec">

                    <h1 class="page_title font_bold">{{ $landing->getTitle() }}</h1>

                    <!--                    <div class="content_section">
                                            <div  id="about-content" class="cont">
                    <?= $landing->getContent() ?>
                                            </div>
                    
                                            <div class="action_content">
                                                <span class="show_more_btn"><?= trans("front.read more"); ?></span>
                                                <span class="show_less_btn"><?= trans("front.read less"); ?></span>
                                            </div>
                                        </div>-->



                    <!-- Start Gifts section -->
                    <div id="gifts_sec" class="section">
                        <div class="sub_section">
                            <h2 class="sub_title font_bold"><?= trans("front.gift slider title"); ?></h2>

                            <div class="wrapper sec">
                                <div class=" scrollbar slider">

                                    <div class="slider__wrap swiper-wrapper">
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/gifts/001.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/gifts/002.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/gifts/003.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/gifts/004.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/gifts/005.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/gifts/006.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/gifts/007.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                    </div>

                                    <div class="slider__controls">

                                        <div class="slider__pagination"></div>

                                        <div class="slider__button-next"></div>
                                        <div class="slider__button-prev"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Gifts section -->




                    <!-- Start form mobile -->
                    <section  id="form_mobile" class="form shadow_type form_sec disabled">
                        <h2 class="sub_title font_bold">
                            <?= trans("front.form offer title"); ?>
                        </h2>

                        @include("front.partials.call_us_fixed")
                    </section>
                    <!-- End form mobile -->


                    <!-- Start contact btn -->
                    <div class="more_sec">
                        <p><?= trans("front.gift landing page caption btn"); ?></p>
                        <a class="green" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>
                    <!-- End contact btn -->



                    <!-- Start Share Page -->
                    <!--                    <div class="col-md-12">
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
                                        </div>-->
                    <!-- End Share Page -->



                    <div class="int_content">
                        <h2 class="sub_title int"><?= trans("front.gift landing page offers title"); ?></h2>

                        <!--                        <div class="offers_list">
                                                    <?//php $offers = []; ?>
                                                    @include("front.partials.offers",  ['landing2_resell_offers'=>$landing2_resell_offers,'icon'=>12])
                        
                                                </div>-->



                        <div class="project_item sec">
                            <div class="project_title">
                                <h3>
                                    <strong class="jazzira_font_bold">شقق للبيع في اسطنبول بكركوي</strong>
                                    <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                                </h3>
                                <h4>منطقة أتاكوي الراقية بإطلالة بحرية ساحرة</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text_sec">
                                        <ul>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">معلومات المشروع</strong>
                                                    يقع المجمع في منطقة أتاكوي الراقية في بلدية بكركوي تماماً على شاطئ بحر مرمرة على بعد 5 دقائق فقط من مطار أتاترك ومن منطقة فلوريا، وعلى بعد 15 دقيقة فقط من منطقة أمينونو والسلطان أحمد ومضيق البوسفور عبر الطريق الساحلي الرائع بحدائقه الخضراء الممتدة من بكركوي وحتى يني كابي.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">تصاميم عصرية ومساحات واسعة</strong>
                                                    يتكون المجمع من 8 كتل سكنية بارتفاع 20 طابق تحتوي على 1401 شقة ريزيدانس فخمة، وغالبية الأبنية ذات إطلالات بحرية مباشرة نتيجة تصميمها بطريقة تمكِّن من رؤية البحر والحديقة الداخلية بنسبة عالية من أغلب شقق المجمع، كما يحتوي على فندق خمس نجوم يتكون من 200 غرفة.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">ميزات موقع المشروع</strong>
                                                    - يحتوي المجمع على محلات تجارية ستشكل مركز تسوق فخم، ستحتوي على مطاعم ومقاهي وجميع الماركات التركية والعالمية من أطعمة وألبسة وغيرها.<br>
                                                    - مسابح مغلقة وحمام تركي وساونا وغرف بخار.
                                                    <br>
                                                    - منتجع صحي SPA وصالات لليوغا.
                                                    <br>
                                                    - صالة لياقة بدنية في كل مبنى
                                                    <br>
                                                    - ملاعب كرة سلة وكرة قدم وتنس وطائرة.
                                                </p>
                                            </li>
                                        </ul>


                                        <div class="project_services sec">
                                            <h5 class="services_title">خدمات المشروع</h5>

                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/01.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">ساونا</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/02.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام سباحة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/03.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام تركي</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/07.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">موقف سيارات </span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/05.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">كميرات مراقبة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/06.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">صالة لياقة</span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">صور المشروع</h5>

                                        <div class="owl-carousel owl-theme owl-loaded owl-drag gallery_1">
                                            <div class="owl-stage-outer">
                                                <div class="owl-stage">

                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-5/01.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-5/02.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-5/03.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-5/04.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-5/05.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-5/06.jpg"); ?>"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="owl-nav disabled">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">فيديو المشروع</h5>
                                        <section class="youtube-video" id="section_images_videos">
                                            <a data-fancybox="project_video" class="video_fancybox" href="https://www.youtube.com/embed/jUf3Mw8wzOQ">
                                                <svg class="faa-ring animated" height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                                                <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/jUf3Mw8wzOQ/maxresdefault.jpg"/>
                                            </a>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>


                        
                        
                        
                        <!-- Start contact btn -->
                    <div class="more_sec">
                        <p><?= trans("front.gift landing page caption btn"); ?></p>
                        <a class="green" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>
                    <!-- End contact btn -->
                        


                        <div class="project_item sec">
                            <div class="project_title">
                                <h3>
                                    <strong class="jazzira_font_bold">شقق فندقية فخمة في اسطنبول</strong>
                                    <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                                </h3>
                                <h4>فرصة ذهبية للاستثمار في أحد الفنادق الفخمة في اسطنبول</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text_sec">
                                        <ul>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">معلومات المشروع</strong>
                                                    المشروع عبارة عن فرصة ذهبية للاستثمار في أحد الفنادق الفخمة في اسطنبول، تؤمن للمستثمر فرصة الحصول على الجنسية التركية وضمان استثمار أمواله فهو عباره عن شقق فندقية مؤثثة بأرقى التصاميم والألوان.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">تصاميم عصرية ومساحات واسعة</strong>
                                                    - يقع الفندق في منطقة بغجلار على الأوتوستراد السريع ضمن مجمع يضم عدة أبنية سكنية ومكاتب ومدرسة ومناطق خضراء وأجواء ترفيهية ومطاعم ومقاهي.
                                                    <br>
                                                    - يتألف المشروع من 175 شقة فندقية مؤثثة بالكامل وبإطلالات متنوعة إما على حديقة الفندق أو على أحياء المدينة والأوتوستراد السريع، حيث تحتوي كل شقة على بلكون أو تراس.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">ميزات موقع المشروع</strong>
                                                    - مطبخ مجهز بأحدث المعدات والأجهزة الكهربائية<br>
                                                    - غسالة وجلاية أطباق وثلاجة<br>
                                                    إطلالة مميزة على حديقة ساحرة<br>
                                                    - واي فاي   - ميني بار   - خزنة  - تلفاز
                                                </p>
                                            </li>
                                        </ul>


                                        <div class="project_services sec">
                                            <h5 class="services_title">خدمات المشروع</h5>

                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/01.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">ساونا</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/02.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام سباحة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/03.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام تركي</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/07.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">موقف سيارات </span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/05.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">كميرات مراقبة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/06.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">صالة لياقة</span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">صور المشروع</h5>

                                        <div class="owl-carousel owl-theme owl-loaded owl-drag gallery_2">
                                            <div class="owl-stage-outer">
                                                <div class="owl-stage">

                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-6/01.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-6/02.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-6/03.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-6/04.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-6/05.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-6/06.jpg"); ?>"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="owl-nav disabled">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">فيديو المشروع</h5>
                                        <section class="youtube-video" id="section_images_videos">
                                            <a data-fancybox="project_video" class="video_fancybox" href="https://www.youtube.com/embed/WZCpVrsLUj0">
                                                <svg class="faa-ring animated" height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                                                <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/WZCpVrsLUj0/maxresdefault.jpg"/>
                                            </a>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>


                    <!-- Start contact btn -->
                    <div class="more_sec">
                        <p><?= trans("front.gift landing page caption btn"); ?></p>
                        <a class="green" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>
                    <!-- End contact btn -->


                        <div class="project_item sec">
                            <div class="project_title">
                                <h3>
                                    <strong class="jazzira_font_bold">شقق للبيع قرب قناة إسطنبول</strong>
                                    <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                                </h3>
                                <h4>حيث يبعد عنها مسافة 1 كم وبإطلالات ساحرة على القناة والبحيرة</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text_sec">
                                        <ul>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">معلومات المشروع</strong>
                                                    يقع مشروعنا الجديد في منطقة اسبارطه كوله في الجانب الأوربي من اسطنبول وبالقرب من قناة اسطنبول الجديدة حيث يبعد عنها مسافة 1 كم وبإطلالات ساحرة على القناة والبحيرة كما يتموضع بالقرب من محطة مرمراي 2 كم وأيضاً بالقرب من مترو M7 بمسافة 1.5 كم.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">تصاميم عصرية ومساحات واسعة</strong>
                                                    مساحة المشروع الاجمالية 52.000 متر مربع ويوفر مساحات خضراء بمساحة 40.000 متر مربع وهو عبارة عن 6 أبنية بارتفاعات بين 17 و 20 طابق, ويضم 582 شقة سكنية بمساحات واسعة وأنماط متعددة 2+1, 3+1 و 4+1 بالاضافة لوجود 55 محل تجاري ضمن المجمع.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">ميزات موقع المشروع</strong>
                                                    - اطلالات ساحرة على القناة و البحيرة<br>
                                                    - بالقرب من قناة اسطنبول مسافة 1km<br>
                                                    - مطار اسطنبول الدولي : 35 دقيقة<br>
                                                    - 10دقائق عن مول Marmara Park
                                                </p>
                                            </li>
                                        </ul>


                                        <div class="project_services sec">
                                            <h5 class="services_title">خدمات المشروع</h5>

                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/01.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">ساونا</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/02.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام سباحة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/03.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام تركي</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/07.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">موقف سيارات </span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/05.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">كميرات مراقبة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/06.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">صالة لياقة</span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">صور المشروع</h5>

                                        <div class="owl-carousel owl-theme owl-loaded owl-drag gallery_3">
                                            <div class="owl-stage-outer">
                                                <div class="owl-stage">

                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-7/01.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-7/02.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-7/03.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-7/04.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-7/05.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-7/06.jpg"); ?>"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="owl-nav disabled">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">فيديو المشروع</h5>
                                        <section class="youtube-video" id="section_images_videos">
                                            <a data-fancybox="project_video" class="video_fancybox" href="https://www.youtube.com/embed/JXfax42oPF8">
                                                <svg class="faa-ring animated" height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                                                <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/JXfax42oPF8/maxresdefault.jpg"/>
                                            </a>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>


                    
                    <!-- Start contact btn -->
                    <div class="more_sec">
                        <p><?= trans("front.gift landing page caption btn"); ?></p>
                        <a class="green" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>
                    <!-- End contact btn -->


                        <div class="project_item sec">
                            <div class="project_title">
                                <h3>
                                    <strong class="jazzira_font_bold">فلل للبيع مناسبة للجنسية التركية</strong>
                                    <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
        <!--                            <img class="passport" alt="damasturk" title="damasturk" src="<?= asset("/img/passportS2-SM-2.png"); ?>" loading="lazy" width="51" height="37">-->
                                </h3>
                                <h4>مجمع فلل يقدم نمط حياة فريدة</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text_sec">
                                        <ul>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">معلومات المشروع</strong>
                                                    - يقع المشروع في منطقة بيليك دوزو في الجانب الأوربي من مدينة اسطنبول على مقربة من الساحل
                                                    <br>
                                                    هو عبارة عن فلل تتموضع على شكل ثلاث بلوكات A, B و C ويتكون من 22 فيلا اثنتان منها فلل مستقلة فيما تكون باقي الفلل 20 فيلا مزدوجة بخيارت تبدأ من 5+1 حتى 7+1 حيث يتوفر في كل غرفة نوم حمام خاص بها مع امكانية التعديل على مساحات الفرف وتوزيعها وهذه ميزة جيدة تقدمها الشركة الانشائية لتقديم فرص أكثر راحة لتتناسب مع ساكني العقار.
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">تصاميم عصرية ومساحات واسعة</strong>
                                                    تتمتع الفلل بخدمات عدة ومسابح خارجية كبيرة وحدائق خاصة ومصاعد بالإضافة لإطلالة رائعة على بحر مرمرة, حيث تبدأ مساحات الحدائق من 60 متر مربع فيما تكون مساحات المسابح عبارة عن 24 متر مربع, أما بالنسبة لمواقف السيارات فتكون في البلوك A و C عبارة عن مواقف مغلقة أما في البلوك B تكون مواقف مفتوحة
                                                </p>
                                            </li>
                                            <li>
                                                <p>
                                                    <strong class="jazzira_font_bold">ميزات موقع المشروع</strong>
                                                   - مستوى عالي من الخصوصية للعائلات<br>
                                                    - يتم تسليم الشقة بتشطيبات كاملة<br>
                                                   - موقع استراتيجي هادئ بعيد عن الازدحام<br>
                                                   - مناظر خلابة على البحر<br>
                                                   - حمامات سباحة خاصة
                                                </p>
                                            </li>
                                        </ul>


                                        <div class="project_services sec">
                                            <h5 class="services_title">خدمات المشروع</h5>

                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/08.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">مساحات خضراء</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/02.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام سباحة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/03.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">حمام تركي</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/07.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">موقف سيارات </span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/05.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">كميرات مراقبة</span>
                                            </div>
                                            <div class="item">
                                                <img loading="lazy" src="<?= asset("img/citizenship-icons/06.svg"); ?>" width="50" height="50"/> 
                                                <span class="jazzira_font_bold">صالة لياقة</span>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">صور المشروع</h5>

                                        <div class="owl-carousel owl-theme owl-loaded owl-drag gallery_4">
                                            <div class="owl-stage-outer">
                                                <div class="owl-stage">

                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-8/01.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-8/02.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-8/03.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-8/04.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-8/05.jpg"); ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="owl-item">
                                                        <div class="item">
                                                            <img class="lazy" loading="lazy" src="<?= asset("img/citizenship-icons/projects/project-8/06.jpg"); ?>"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="owl-nav disabled">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="gallery_sec sec">
                                        <h5 class="gallery_sec_title jazzira_font_bold">فيديو المشروع</h5>
                                        <section class="youtube-video" id="section_images_videos">
                                            <a data-fancybox="project_video" class="video_fancybox" href="https://www.youtube.com/embed/kF4_pZfH0ig">
                                                <svg class="faa-ring animated" height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                                                <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/kF4_pZfH0ig/maxresdefault.jpg"/>
                                            </a>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>


                    <div class="more_sec">
                        <p><?= trans("front.gift landing page caption btn"); ?></p>
                        <a class="green" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>



                    <!-- Start Share Page -->
                    <div class="col-md-12 sec">
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





                    <!-- Start services section -->
                    <div id="gifts_sec" class="section">
                        <div class="sub_section">
                            <h2 class="sub_title font_bold"><?= trans("front.gift landing page our services"); ?></h2>

                            <div class="wrapper sec">
                                <div class=" scrollbar slider">

                                    <div class="slider__wrap swiper-wrapper">
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/01.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/002.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/03.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/004.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/08.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/09.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/10.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/services/11.jpg"); ?>" alt="damasturk"/>
                                        </section>
                                    </div>

                                    <div class="slider__controls">

                                        <div class="slider__pagination"></div>

                                        <div class="slider__button-next"></div>
                                        <div class="slider__button-prev"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End services section -->



                    <!-- Start testimonial section -->
                    <div id="gifts_sec" class="section">
                        <div class="sub_section">
                            <h2 class="sub_title font_bold"><?= trans("front.gift landing page testimonials"); ?></h2>

                            <div class="wrapper sec">
                                <div class=" scrollbar slider">

                                    <div class="slider__wrap swiper-wrapper">
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/testimonial/001.png"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("img/testimonial/002.png"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("/img/testimonial/003.png"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("/img/testimonial/004.png"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("/img/testimonial/005.png"); ?>" alt="damasturk"/>
                                        </section>
                                        <section class="item swiper-slide">
                                            <img class="item_image" loading="lazy" src="<?= asset("/img/testimonial/006.png"); ?>" alt="damasturk"/>
                                        </section>
                                    </div>

                                    <div class="slider__controls">

                                        <div class="slider__pagination"></div>

                                        <div class="slider__button-next"></div>
                                        <div class="slider__button-prev"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End testimonial section -->




                    <div class="more_sec">
                        <p><?= trans("front.gift landing page caption btn"); ?></p>
                        <a class="green" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>


                </div>
                <!-- End Left Section -->


                <!-- Start Fixed Section -->
                <div class="right_sec">

                    <div class="fixed_sec fixed">

                        <section class="form shadow_type form_sec">
                            @include("front.partials.call_us_fixed")
                        </section>

                        <!-- About Us 
                        @include("front.partials.about_sec", [])
                        -->

                    </div>
                </div>


            </div>
            <!-- End Fixed Section -->

        </div>



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
            <div class="copyright animate__animated"><?= trans("front.View the intellectual property rights of damasturk"); ?>  © <span class="num"><?= date('Y'); ?></span> <br> <span class="num">(Fikri Mülkiyet Hakları)</span> </div>
        </div>



        <!-- Start pop up Section -->
        <!--        <div class="pop_up_sec pop">
                    <div class="col-md-10 offset-md-1">
                        <img class="banner_popup" src="https://damas.net/uploads/stthmr-laakrt1534aac284400a78fca8ddd9e164533e95.jpg" alt="الاستثمار العقاري في تركيا" width="100%">
                        
                        <div class="more_sec close_popup">
                            <a class="green" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                        </div>
                    </div>
                </div>-->
        <!-- Start pop up Section -->


        <?php if (App::isLocal()) { ?>
            <?= Html::script("resources/assets/js/jquery-3.6.0.min.js") ?>
            <?= Html::script("resources/assets/js/intlTelInput.js") ?>
            <?= Html::script("resources/assets/js/jquery.lazy.min.js") ?>
            <?= Html::script("resources/assets/js/jquery.fancybox.min.js") ?>
        <?php } else { ?>
            <?= Html::script("js/landing2.min.js") ?>
        <?php } ?>

        <?= Html::script("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"); ?>

        <script>


            var owl_1 = $('.gallery_1');
            owl_1.owlCarousel({
                items: 1,
                // items change number for slider display on desktop

                loop: true,
                lazyLoad: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });

            var owl_2 = $('.gallery_2');
            owl_2.owlCarousel({
                items: 1,
                // items change number for slider display on desktop

                loop: true,
                lazyLoad: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });

            var owl_3 = $('.gallery_3');
            owl_3.owlCarousel({
                items: 1,
                // items change number for slider display on desktop

                loop: true,
                lazyLoad: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });

            var owl_4 = $('.gallery_4');
            owl_4.owlCarousel({
                items: 1,
                // items change number for slider display on desktop

                loop: true,
                lazyLoad: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 300000,
                autoplayHoverPause: true
            });



            $(document).ready(function () {

                /*
                 setTimeout(function() {
                 $(".pop_up_sec").addClass("pop");
                 }, 2000);*/



<?php
$get = '';
foreach ($_GET as $k => $v) {
    if ($get == '')
        $get = $k . '=' . $v;
    else
        $get = $get . '&' . $k . '=' . $v;
}
if (isset($_GET['sHTTP_REFERER']) && isset($_GET['sREQUEST_URI'])) {
    $js_gets = "";
} else {
    $js_gets = "'&sHTTP_REFERER=' + encodeURIComponent(document.referrer) + '&sREQUEST_URI=' + '/' + encodeURIComponent(window.location.pathname.substr(1))";
}
?>
                $.getJSON("/ajax/call_country?<?= $get ?>" + <?= $js_gets ?>, function (data) {
                    var call_ctry = data.call_country;
                    $('input[name=mobile]').val(call_ctry);
                    $('input[name=phone]').val(call_ctry);



                    call_ctry = call_ctry.replace('+', '');
                    var country_abr = $('input[name=mobile]:eq(0)').parent('div').find('.country-list').find('li[data-dial-code="' + call_ctry + '"]').data('country-code');
                    $('input[name=mobile]').parent('div').find('.selected-flag').find('.flag').attr('class', 'flag ' + country_abr);
                    $('input[name=phone]').parent('div').find('.selected-flag').find('.flag').attr('class', 'flag ' + country_abr);


                });




            });

            $(document).on("click", ".close_popup", function () {
                $(".pop_up_sec").removeClass("pop");
            });




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


            /* Loading images
             $('.lazy').Lazy({
             afterLoad: function (element) {
             element.addClass("loaded");
             element.parents(".item").addClass("loaded");
             }
             });
             */

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


            /*
             setInterval(function () {*/
<?php
/* for ($i = 0; $i < count($offers); $i++) {
  if ($offers[$i]->offer_end_date != '') {
  ?>
  makeTimer(<?= $i ?>,'<?= $offers[$i]->offer_end_date ?>');
  <?php
  }
  } */
?>
            /*
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



            if ($(window).width() > 812) {
                $(".more_sec a").click(function () {
                    $("input[name='name']").focus();
                });
                $("#gifts_sec .item_image").click(function () {
                    $("input[name='name']").focus();
                });
            }




            if ($(window).width() < 813) {
                $(".more_sec a").click(function () {
                    $("#form_mobile input[name='name']").focus();

                    $('html, body').animate({
                        scrollTop: $("#form_mobile").offset().top - 90
                    }, 2000);
                });

                $("#gifts_sec .item_image").click(function () {
                    $("#form_mobile input[name='name']").focus();

                    $('html, body').animate({
                        scrollTop: $("#form_mobile").offset().top - 90
                    }, 2000);
                });
            }



        </script>


    </body>
</html>