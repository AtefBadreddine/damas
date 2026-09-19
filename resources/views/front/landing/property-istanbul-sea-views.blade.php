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

        @if($landing->media)
        <meta property="og:image" content="{{ Helper::media_url_full($landing->media) }}" />
        @endif
        <meta property="og:description" content="{{ $landing->getSeoDescription() }}">
        <meta name="description" content="{{ $landing->getSeoDescription() }}">



        <style>


        </style>


        <?php if (App::isLocal()) { ?>
            <?= Html::style("resources/assets/css/intlTelInput.css") ?>
            <?= Html::style("resources/assets/css/jquery.fancybox.min.css") ?>
            <?= Html::style("https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css") ?>
            <?= Html::style("resources/assets/css/landing/apartments_istanbul.css") ?>


        <?php } else { ?>

            <?= Html::style("css/intlTelInput.fancybox.min.css") ?>
            <?= Html::style("https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css") ?>
            <?= Html::style("css/landing_apartments_istanbul.min.css") ?>

        <?php } ?>


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



    </head>

    <body>




        <div class="sec top_page">

            <div class="top_menu sec">
                <div class="col-md-10 offset-md-1">
                    <img class="logo" src="/img/damasturk.svg" alt="damasturk logo" width="200" height="35"/>
                    <a href="javascript:;" class="contact_btn open_form">
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
                        <path d="M16 10H16.01M12 10H12.01M8 10H8.01M3 10C3 4.64706 5.11765 3 12 3C18.8824 3 21 4.64706 21 10C21 15.3529 18.8824 17 12 17C11.6592 17 11.3301 16.996 11.0124 16.9876L7 21V16.4939C4.0328 15.6692 3 13.7383 3 10Z" stroke="#058687" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        تواصل الآن
                    </a>
                </div>
            </div>

            <div class="col-md-10 offset-md-1">



                <header class="sec">
                    <h1 class="page_title">{{ $landing->getTitle() }}</h1>
                    <p>
                        اغتنم الفرصة الآن بحصولك على الجنسية التركية<br>
                        مقابل شراء عقار بمبلغ   <b>$ 400.000</b>
                    </p>

                    <a href="javascript:;" class="booking_btn open_form">
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
                        <path d="M10 21H6.2C5.0799 21 4.51984 21 4.09202 20.782C3.71569 20.5903 3.40973 20.2843 3.21799 19.908C3 19.4802 3 18.9201 3 17.8V8.2C3 7.0799 3 6.51984 3.21799 6.09202C3.40973 5.71569 3.71569 5.40973 4.09202 5.21799C4.51984 5 5.0799 5 6.2 5H17.8C18.9201 5 19.4802 5 19.908 5.21799C20.2843 5.40973 20.5903 5.71569 20.782 6.09202C21 6.51984 21 7.0799 21 8.2V10M7 3V5M17 3V5M3 9H21M13.5 13.0001L7 13M10 17.0001L7 17M14 21L16.025 20.595C16.2015 20.5597 16.2898 20.542 16.3721 20.5097C16.4452 20.4811 16.5147 20.4439 16.579 20.399C16.6516 20.3484 16.7152 20.2848 16.8426 20.1574L21 16C21.5523 15.4477 21.5523 14.5523 21 14C20.4477 13.4477 19.5523 13.4477 19 14L14.8426 18.1574C14.7152 18.2848 14.6516 18.3484 14.601 18.421C14.5561 18.4853 14.5189 18.5548 14.4903 18.6279C14.458 18.7102 14.4403 18.7985 14.405 18.975L14 21Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        تواصل الآن
                    </a>
                    <a href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000" class="contact_btn">
                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
                        <path d="M16 10H16.01M12 10H12.01M8 10H8.01M3 10C3 4.64706 5.11765 3 12 3C18.8824 3 21 4.64706 21 10C21 15.3529 18.8824 17 12 17C11.6592 17 11.3301 16.996 11.0124 16.9876L7 21V16.4939C4.0328 15.6692 3 13.7383 3 10Z" stroke="#058687" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        راسلنا
                    </a>
                </header>

                <img class="top_photo float_animate" width="60" height="60" src="<?= asset("/img/landing/istanbul-sea-view/top-photo.webp"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>

            </div>
        </div>



        <div class="col-md-10 offset-md-1">
            <div class="full_sections">



                <!-- Start Why Istanbul section -->
                <div id="why_sec" class="sec section_padding">
                    <div class="section_title">
                        <h2>
                            <strong class="jazzira_font_bold">لماذا التملك في اسطنبول؟</strong>
                        </h2>
                        <h3>تتمتع اسطنبول بكثير من المزايا أهمها</h3>
                    </div>

                    <div class="steps_cont">
                        <div class="item">
                            <div class="num"><span>1</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/offer-icon-01.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>عروض عقارية متنوعة</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>2</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/house-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>سهولة التأجير وإعادة البيع</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>3</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/guarantee-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>مشاريع بالضمان الحكومي</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>4</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/family-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>بيئة مناسبة للعائلات</h4>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Why Istanbul section -->





                <!-- Start Projects Section -->
                <div id="projects_sec" class="sec section_padding">


                    <div class="project_item sec">

                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold">مشروع بكركوي الكبير</strong>
                            </h2>
                            <h3>إطلالة بحرية ساحرة على بحر مرمرة وقرب مركز المدينة</h3>
                        </div>

                        <img class="icon float_animate" width="400" height="400" src="<?= asset("/img/landing/istanbul-sea-view/pr-1.webp"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>

                        <div class="project_info">
                            <div class="list">
                                <svg class="list_icon" width="30" height="30" viewBox="0 0 24 24" fill="none">
                                <path opacity="1" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="#058687" stroke-width="1.5"></path>
                                <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#08bcbd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <b>منطقة المشروع</b>
                                <p>
                                    يقع المجمع في منطقة أتاكوي الراقية في بلدية بكركوي تماماً على شاطئ بحر مرمرة على بعد 5 دقائق فقط من مطار أتاترك ومن منطقة فلوريا، وعلى بعد 15 دقيقة فقط من منطقة أمينونو والسلطان أحمد ومضيق البوسفور عبر الطريق الساحلي الرائع بحدائقه الخضراء الممتدة من بكركوي وحتى يني كابي.
                                </p>
                                <!--                                <a class="region_video" data-fancybox="region-video" href="https://www.youtube.com/embed/ZMLjxWnbGvY">
                                                                    شاهد فيدو المنطقة
                                                                    <svg width="30" height="30" viewBox="0 -3 20 20" version="1.1"><title>youtube [#168]</title><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ff0000"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
                                                                </a>-->
                            </div>
                            <div class="list">
                                <svg class="list_icon" width="30" height="30" viewBox="0 0 24 24" fill="none">
                                <path opacity="1" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="#058687" stroke-width="1.5"></path>
                                <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#08bcbd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <b>معلومات المشروع</b>
                                <p>
                                    يتكون المجمع من 8 كتل سكنية بارتفاع 20 طابق تحتوي على 1401 شقة ريزيدانس فخمة، وغالبية الأبنية ذات إطلالات بحرية مباشرة نتيجة تصميمها بطريقة تمكِّن من رؤية البحر والحديقة الداخلية بنسبة عالية من أغلب شقق المجمع، كما يحتوي على فندق خمس نجوم يتكون من 200 غرفة.
                                    مساحة أرض المشروع 127.600 متر مربع، وطول المورنيش البحري الخاص بالمشروع 1200 متر.
                                    يتألف من عدة نماذج للشقق من 1+1 حتى 5+1.
                                </p>
                                <a class="region_video" data-fancybox="project-video" href="https://www.youtube.com/embed/jUf3Mw8wzOQ">
                                    شاهد فيدو المشروع
                                    <svg width="30" height="30" viewBox="0 -3 20 20" version="1.1"><title>youtube [#168]</title><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ff0000"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
                                </a>
                            </div>
                        </div>


                        <div class="sec">

                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-1-01.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-1-02.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-1-03.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-1-04.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-1-05.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-1-06.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-1-07.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>




                    <div class="project_item sec">

                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold">مشروع مال تبه الفاخر</strong>
                            </h2>
                            <h3>تشطبيات فاخرة ومساحات واسعة</h3>
                        </div>

                        <img class="icon float_animate" width="400" height="400" src="<?= asset("/img/landing/istanbul-sea-view/pr-2.webp"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>

                        <div class="project_info">
                            <div class="list">
                                <svg class="list_icon" width="30" height="30" viewBox="0 0 24 24" fill="none">
                                <path opacity="1" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="#058687" stroke-width="1.5"></path>
                                <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#08bcbd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <b>منطقة المشروع</b>
                                <p>
                                    يقع المشروع في منطقة مال تبه في القسم الآسيوي من مدينة اسطنبول
                                    <br>
                                    بلدية مال تبه تتوفر فيها جميع المؤسسات الخدمية، من الجامعات التعليمية، جامعة مال تبه وجامعة اسطنبول التجارية وجامعة مرمرة، والمدارس الحكومية بالإضافة الى المشافي الحكومية والمشافي الخاصة وأهمها مستشفى ارصوي ومركز مال تبه الطبي.                                </p>
<!--                                <a class="region_video" data-fancybox="region-video" href="https://www.youtube.com/embed/o_tKGIlEloI">
                                    شاهد فيدو المنطقة
                                    <svg width="30" height="30" viewBox="0 -3 20 20" version="1.1"><title>youtube [#168]</title><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ff0000"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
                                </a>-->
                            </div>
                            <div class="list">
                                <svg class="list_icon" width="30" height="30" viewBox="0 0 24 24" fill="none">
                                <path opacity="1" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="#058687" stroke-width="1.5"></path>
                                <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#08bcbd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <b>معلومات المشروع</b>
                                <p>
                                     وبتربع على مساحة أرض 14.000 متر مربع ومساحة انشائية 58.000 متر مربع, وهو عبارة عن 3 بلوكات مرتفعة تضم 456 شقة ريزيدانس بخيارات 1+1, 2+1, 3+1 و 4+1 Penthous باطلالات بحرية على جزر الأميرات.
                                </p>
                                <a class="region_video" data-fancybox="project-video" href="https://www.youtube.com/embed/NZeoI4y7DHY">
                                    شاهد فيدو المشروع
                                    <svg width="30" height="30" viewBox="0 -3 20 20" version="1.1"><title>youtube [#168]</title><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ff0000"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
                                </a>
                            </div>
                        </div>


                        <div class="sec">

                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-2-01.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-2-02.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-2-03.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-2-04.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-2-05.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-2-06.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-2-07.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>




                    <div class="project_item sec">

                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold">مشروع بندك المميز</strong>
                            </h2>
                            <h3>مشروع مميز في منطقة بندك قرب الطريق السريع</h3>
                        </div>

                        <img class="icon float_animate" width="400" height="400" src="<?= asset("/img/landing/istanbul-sea-view/pr-3.webp"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>

                        <div class="project_info">
                            <div class="list">
                                <svg class="list_icon" width="30" height="30" viewBox="0 0 24 24" fill="none">
                                <path opacity="1" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="#058687" stroke-width="1.5"></path>
                                <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#08bcbd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <b>منطقة المشروع</b>
                                <p>
                                    يقع مشروعنا الجديد والفريد من نوعه والذي يكتب قيمة استثمارية عالية لوجوده في منطقة بندك وتموضعه بجانب مطار صبيحة كوكجن الدولي بمحاذاة الطريق السريع الواصل بين شرياني إسطنبول (E80 و E5)

                                </p>
<!--                                <a class="region_video" data-fancybox="region-video" href="https://www.youtube.com/embed/y02HQE4CheY">
                                    شاهد فيدو المنطقة
                                    <svg width="30" height="30" viewBox="0 -3 20 20" version="1.1"><title>youtube [#168]</title><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ff0000"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
                                </a>-->
                            </div>
                            <div class="list">
                                <svg class="list_icon" width="30" height="30" viewBox="0 0 24 24" fill="none">
                                <path opacity="1" d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z" stroke="#058687" stroke-width="1.5"></path>
                                <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="#08bcbd" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <b>معلومات المشروع</b>
                                <p>
                                    يتربع على مساحة 8.800 متر مربع حيث يتكون من 4 أبنية (A, B1, B2, C) فندق 5 نجوم ومركز المعارض ومكاتب ومجمع للرعاية الصحية حيث توزع كالتالي:
                                    <br>
                                    - البناء A عبارة عن فندق خمس نجوم يتسع ل 212 غرفة فندقية يوفر أنماط استوديو 1+0 وغرفة وصالة 1+1 دوبلكس مع تراس

                                    <br>
                                    - البناء B1 مركز معارض مفتوح على مدار 24 ساعة

                                    <br>
                                    - البناء B2 مركز أعمال (مكاتب تجارية)

                                    <br>
                                    - البناء C مجمع صحي متخصص في السياحة الطبية

                                </p>
                                <a class="region_video" data-fancybox="project-video" href="https://www.youtube.com/embed/t-mhwYs8REM">
                                    شاهد فيدو المشروع
                                    <svg width="30" height="30" viewBox="0 -3 20 20" version="1.1"><title>youtube [#168]</title><desc>Created with Sketch.</desc><defs></defs><g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g id="Dribbble-Light-Preview" transform="translate(-300.000000, -7442.000000)" fill="#ff0000"><g id="icons" transform="translate(56.000000, 160.000000)"><path d="M251.988432,7291.58588 L251.988432,7285.97425 C253.980638,7286.91168 255.523602,7287.8172 257.348463,7288.79353 C255.843351,7289.62824 253.980638,7290.56468 251.988432,7291.58588 M263.090998,7283.18289 C262.747343,7282.73013 262.161634,7282.37809 261.538073,7282.26141 C259.705243,7281.91336 248.270974,7281.91237 246.439141,7282.26141 C245.939097,7282.35515 245.493839,7282.58153 245.111335,7282.93357 C243.49964,7284.42947 244.004664,7292.45151 244.393145,7293.75096 C244.556505,7294.31342 244.767679,7294.71931 245.033639,7294.98558 C245.376298,7295.33761 245.845463,7295.57995 246.384355,7295.68865 C247.893451,7296.0008 255.668037,7296.17532 261.506198,7295.73552 C262.044094,7295.64178 262.520231,7295.39147 262.895762,7295.02447 C264.385932,7293.53455 264.28433,7285.06174 263.090998,7283.18289" id="youtube-[#168]"></path></g></g></g></svg>
                                </a>
                            </div>
                        </div>


                        <div class="sec">

                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-3-01.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-3-02.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-3-03.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-3-04.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-3-05.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-3-06.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="swiper-slide-img">
                                            <img src="/img/landing/istanbul-sea-view/project-3-07.jpg" alt="project photo" width="250" height="150" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>




                </div>
                <!-- End Projects Section -->



                <!-- Start Gifts section -->
                <div id="gifts_sec" class="section">
                    <div class="sub_section">
                        <h2 class="sub_title font_bold">
                            هدايا مقدّمة من داماس ترك العقاريّة<br>
                            اكسب الهدايا معنا فور شرائك العقار في تركيا
                        </h2>

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

                                    <div class="slider__button-next">
                                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#058687" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs"><path d="M9 18l6-6-6-6"></path></svg>
                                    </div>
                                    <div class="slider__button-prev">
                                        <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="#058687" stroke-width="2" stroke-linecap="round" stroke-linejoin="arcs"><path d="M15 18l-6-6 6-6"></path></svg>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Gifts section -->






                <!-- Start our services -->
                <div class="sec new_sec our_services_sec">
                    <div class="section_title">
                        <h2>
                            <strong class="jazzira_font_bold">خدمات داماس ترك العقارية</strong>
                        </h2>
                        <h3>
                            تضمن داماس ترك من خلال <b>مشاريعنا العقارية ذات الضمان الحكومي</b>
                            <br>
                            تقديم تجربة آمنة وإيجابية لمن يقصدون تركيا بهدف العيش أو الاستثمار
                            <img class="stamp" width="85" height="65" src="<?= asset("/img/landing/services-icons/stamp.svg"); ?>" alt="مشاريعنا العقارية ذات الضمان الحكومي" loading="lazy"/>
                        </h3>

                    </div>


                    <ul class="services_list sec">
                        <li>
                            <div class="cont">
                                <span class="icon">
                                    <img width="60" height="60" src="<?= asset("/img/landing/services-icons/03.webp"); ?>" alt="الاستشارات العقارية" loading="lazy"/>
                                </span>
                                <h4 class="text">الاستشارات العقارية</h4>
                            </div>
                        </li>
                        <li>
                            <div class="cont">
                                <span class="icon">
                                    <img width="60" height="60" src="<?= asset("/img/landing/services-icons/06.webp"); ?>" alt="إجراءات الشراء وسند الملكية" loading="lazy"/>
                                </span>
                                <h4 class="text">قيادة عملية الشراء</h4>
                            </div>
                        </li>
                        <li>
                            <div class="cont">
                                <span class="icon">
                                    <img width="60" height="60" src="<?= asset("/img/landing/services-icons/05.webp"); ?>" alt="إجراءات الشراء وسند الملكية" loading="lazy"/>
                                </span>
                                <h4 class="text">معاملة الجنسية التركية</h4>
                            </div>
                        </li>
                        <li>
                            <div class="cont">
                                <span class="icon">
                                    <img width="60" height="60" src="<?= asset("/img/landing/services-icons/04.webp"); ?>" alt="إجراءات الشراء وسند الملكية" loading="lazy"/>
                                </span>
                                <h4 class="text">فرش وديكور الشقق</h4>
                            </div>
                        </li>
                        <li>
                            <div class="cont">
                                <span class="icon">
                                    <img width="60" height="60" src="<?= asset("/img/landing/services-icons/02.webp"); ?>" alt="إجراءات الشراء وسند الملكية" loading="lazy"/>
                                </span>
                                <h4 class="text">تأجير أو إعادة البيع</h4>
                            </div>
                        </li>
                        <li>
                            <div class="cont">
                                <span class="icon">
                                    <img width="60" height="60" src="<?= asset("/img/landing/services-icons/01.webp"); ?>" alt="إجراءات الشراء وسند الملكية" loading="lazy"/>
                                </span>
                                <h4 class="text">التملك عن بعد</h4>
                            </div>
                        </li>
                    </ul>

                </div>
                <!-- End our services -->





                <!-- Start our clients -->
                <div class="sec new_sec">
                    <div class="section_title">
                        <h2>
                            <strong class="jazzira_font_bold"> عملاء داماس ترك العقارية</strong>
                        </h2>
                        <h3>
                            بفضل المصداقية العالية التي اكتسبتها داماس ترك في السوق التركي
                            <br>
                            عبر مسيرتها الطويلة، استطعنا ولله الحمد كسب ثقة آلاف العملاء من مختلف الجنسيات والدول.
                        </h3>
                    </div>

                    <div class="gallery">
                        <div class="gallery__img" style="background-image: url('/img/landing/testimonial/02.jpg');"></div>
                        <div class="gallery__img gallery__img--tall" style="background-image: url('/img/landing/testimonial/01.jpg');"></div>
                        <div class="gallery__img" style="background-image: url('/img/landing/testimonial/03.jpg');"></div>
                        <div class="gallery__img" style="background-image: url('/img/landing/testimonial/04.jpg');"></div>
                        <div class="gallery__img" style="background-image: url('/img/landing/testimonial/05.jpg');"></div>
                        <div class="gallery__img" style="background-image: url('/img/landing/testimonial/06.jpg');"></div>
                        <div class="gallery__img" style="background-image: url('/img/landing/testimonial/07.jpg');"></div>
                    </div>

                </div>
                <!-- End our clients -->




                <section class="form shadow_type form_sec sec">
                    @include("front.partials.call_us_fixed")
                </section>





            </div>

        </div>





        <div class="whatsapp_direct_btn">
            <a target="_blank" class="whatsappBtn " href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000">
                <span class="fa fa-whatsapp">
                    <svg fill="#ffffff" width="34" height="34" viewBox="0 0 16 16"><path d="M11.42 9.49c-.19-.09-1.1-.54-1.27-.61s-.29-.09-.42.1-.48.6-.59.73-.21.14-.4 0a5.13 5.13 0 0 1-1.49-.92 5.25 5.25 0 0 1-1-1.29c-.11-.18 0-.28.08-.38s.18-.21.28-.32a1.39 1.39 0 0 0 .18-.31.38.38 0 0 0 0-.33c0-.09-.42-1-.58-1.37s-.3-.32-.41-.32h-.4a.72.72 0 0 0-.5.23 2.1 2.1 0 0 0-.65 1.55A3.59 3.59 0 0 0 5 8.2 8.32 8.32 0 0 0 8.19 11c.44.19.78.3 1.05.39a2.53 2.53 0 0 0 1.17.07 1.93 1.93 0 0 0 1.26-.88 1.67 1.67 0 0 0 .11-.88c-.05-.07-.17-.12-.36-.21z"/><path d="M13.29 2.68A7.36 7.36 0 0 0 8 .5a7.44 7.44 0 0 0-6.41 11.15l-1 3.85 3.94-1a7.4 7.4 0 0 0 3.55.9H8a7.44 7.44 0 0 0 5.29-12.72zM8 14.12a6.12 6.12 0 0 1-3.15-.87l-.22-.13-2.34.61.62-2.28-.14-.23a6.18 6.18 0 0 1 9.6-7.65 6.12 6.12 0 0 1 1.81 4.37A6.19 6.19 0 0 1 8 14.12z"/></svg>
                </span>
            </a>
        </div>


        <div class="sub_footer">
            <div class="logo_sec">
                <img width="155" height="76" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
            </div>
            <div class="copyright animate__animated"><?= trans("front.View the intellectual property rights of damasturk"); ?>  © <span class="num"><?= date('Y'); ?></span> <br> <span class="num">(Fikri Mülkiyet Hakları)</span> </div>
        </div>




        <?php if (App::isLocal()) { ?>
            <?= Html::script("resources/assets/js/jquery-3.6.0.min.js") ?>
            <?= Html::script("resources/assets/js/intlTelInput.js") ?>
            <!--<?= Html::script("resources/assets/js/jquery.lazy.min.js") ?>-->
            <?= Html::script("resources/assets/js/jquery.fancybox.min.js") ?>
            <?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js") ?>
        <?php } else { ?>
            <?= Html::script("js/jquery.min.js") ?>
            <?= Html::script("js/intlTelInput.js") ?>
            <?= Html::script("js/jquery.fancybox.min.js") ?>
			<?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.5/swiper-bundle.min.js") ?>
        <?php } ?>


        <script type="text/javascript">


            /*
             inspiration
             https://cz.pinterest.com/pin/830703093792161391/
             */
            var swiper = new Swiper(".swiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 100,
                    modifier: 2.5
                },
                // Enabled autoplay mode
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false
                },
                keyboard: {
                    enabled: true
                },
                spaceBetween: 30,
                loop: true,
                breakpoints: {
                    320: {
                        slidesPerView: 1.5
                    },
                    500: {
                        slidesPerView: 1.5
                    },
                    640: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    }
                }
            });








var formHasChanged = false;


            $(document).ready(function () {

                // Add the img element after the div with the ID "yourDivId"
                $('#form-callus-lg').after('<img src="/img/landing/contact-form-man.png" class="form_image" />');



                $('.acc-container .acc:nth-child(1) .acc-head').addClass('active');
                $('.acc-container .acc:nth-child(1) .acc-content').slideDown();
                $('.acc-head').on('click', function () {
                    if ($(this).hasClass('active')) {
                        $(this).siblings('.acc-content').slideUp();
                        $(this).removeClass('active');
                    } else {
                        $('.acc-content').slideUp();
                        $('.acc-head').removeClass('active');
                        $(this).siblings('.acc-content').slideToggle();
                        $(this).toggleClass('active');
                    }
                });



                


                $('.form-control').change(function () {
                    formHasChanged = true;
                });

                window.onbeforeunload = function (e) {
                    if (formHasChanged) {
                        var message = "You have not saved your changes.", e = e || window.event;
                        if (e) {
                            e.returnValue = message;
                        }
                        return message;
                    }
                }





                /*setTimeout(function () {
                 
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

            $("body").on("click", "#form-callus, #form-callus-lg, #form-callus-floating, #form-callus-landing, #form-callus-chat", function (e) {
				formHasChanged = false;
			});
			$("body").on("submit", "#form-callus, #form-callus-lg, #form-callus-floating, #form-callus-landing, #form-callus-chat", function (e) { 
				formHasChanged = false;
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
                $(".open_form").click(function () {
                    $("input[name='name']").focus();
                });
                $("#gifts_sec .item_image").click(function () {
                    $("input[name='name']").focus();
                });
            }




            if ($(window).width() < 813) {
                $(".open_form").click(function () {
                    $(".form_sec input[name='name']").focus();

                    $('html, body').animate({
                        scrollTop: $(".form_sec").offset().top - 90
                    }, 2000);
                });

                $("#gifts_sec .item_image").click(function () {
                    $(".form_sec input[name='name']").focus();

                    $('html, body').animate({
                        scrollTop: $(".form_sec").offset().top - 90
                    }, 2000);
                });
            }






            var oldsctop = 500;
            $(window).scroll(function () {

                /*console.log('old' + oldsctop + ' ----new: '+ $(this).scrollTop());*/
                if (($(this).scrollTop()) > oldsctop) {
                    $(".top_menu").addClass("scrolling");
                } else {
                    $(".top_menu").removeClass("scrolling");
                }
            });




        </script>


    </body>
</html>