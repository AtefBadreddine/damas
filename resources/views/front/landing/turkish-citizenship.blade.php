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
            <?= Html::style("resources/assets/css/landing_new.css") ?>


        <?php } else { ?>

            <?= Html::style("css/intlTelInput.fancybox.min.css") ?>
            <?= Html::style("css/landing_new.min.css") ?>

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
                    <img class="flag" src="/img/landing/turkish-citizenship/flag.png" alt="Turkish flag" width="150" height="300"/>
                </div>
            </div>

            <div class="col-md-10 offset-md-1">



                <header class="sec">
                    <h1 class="page_title">{{ $landing->getTitle() }}</h1>
                    <p>
                        اغتنم الفرصة الآن بحصولك على الجنسية التركية<br>
                        مقابل شراء عقار بمبلغ   <b>$ 400.000</b>
                    </p>
                </header>

                <img class="top_photo" width="60" height="60" src="<?= asset("/img/landing/turkish-citizenship/top-photo-04.webp"); ?>" alt="الجنسية التركية" loading="lazy"/>
                <img class="top_passport" width="60" height="60" src="<?= asset("/img/landing/turkish-citizenship/passportS.webp"); ?>" alt="الجنسية التركية" loading="lazy"/>

            </div>
        </div>



        <div class="col-md-10 offset-md-1">
            <div class="full_sections">


                <div class="left_sec">




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




                    <!-- Start More Btn -->
                    <div class="more_sec">
                        <p>لاتفوت الفرصة اشتريِ عقار واحصل على الجنسية</p>
                        <a class="green open_form" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>
                    <!-- End More Btn -->




                    <!-- Start form mobile -->
                    <section  id="form_mobile" class="form shadow_type form_sec disabled">

                        @include("front.partials.call_us_fixed")
                    </section>
                    <!-- End form mobile -->




                    <!-- Start Information -->
                    <div class="sec new_sec">
                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold">كيفية الحصول على الجنسية التركية</strong>
                                <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                            </h2>
                            <h3>تعرف على خطوات الحصول على الجنسية التركية عند الاستثمار العقاري</h3>
                        </div>

                        <div class="steps_cont">
                            <div class="item">
                                <span class="number">01</span>
                                <img class="icon" width="40" height="40" src="<?= asset("/img/landing/turkish-citizenship/home.svg"); ?>" alt="damasturk" loading="lazy"/>
                                <h4>الحجز والمطابقة</h4>
<!--                                <p>
                                    هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
                                </p>-->
                            </div>
                            <div class="item">
                                <span class="number">02</span>
                                <img class="icon" width="40" height="40" src="<?= asset("/img/landing/turkish-citizenship/card.svg"); ?>" alt="damasturk" loading="lazy"/>
                                <h4>إقامة المستثمر</h4>
                            </div>
                            <div class="item">
                                <span class="number">03</span>
                                <img class="icon" width="40" height="40" src="<?= asset("/img/landing/turkish-citizenship/files.svg"); ?>" alt="damasturk" loading="lazy"/>
                                <h4>تسليم الملف للنفوس</h4>
                            </div>
                            <div class="item">
                                <img class="passport" src="/img/passportS2-SM.png" width="60" height="45" loading="lazy">
                                <span class="number">04</span>
                                <img class="icon" width="40" height="40" src="<?= asset("/img/landing/turkish-citizenship/archery.svg"); ?>" alt="damasturk" loading="lazy"/>
                                <h4>استلام الجنسية </h4>
                            </div>
                        </div>


                    </div>
                    <!-- End Information -->



                    <!-- Start Projects Offers -->
                    <div class="sec new_sec">
                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold">مشاريع مناسبة للجنسية التركية</strong>
                                <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                            </h2>
                            <h3>اخترنا لك أفضل المشاريع المناسبة للجنسية التركية</h3>
                        </div>


                        <div class="projects_list">
                            <div class="item">
                                <h4 class="pr_title">مشروع جديد </h4>
                                <p class="pr_sub_title">في منطقة كوتشوك شكمجة<br>وبالقرب من بحيرتها</p>
                                <a class="mobile_btn">اضغط لمعرفة العرض</a>
                                <img class="icon" width="100%" height="350" src="<?= asset("/img/landing/turkish-citizenship/pr01.png"); ?>" alt="damasturk" loading="lazy"/>
                                <div class="pr_info">
                                    <h5>معلومات العرض</h5>

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>النوع</th>
                                                <th>الغرف</th>
                                                <th>المساحة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>شقة</td>
                                                <td>3+1</td>
                                                <td>125<small>م2</small></td>
                                            </tr>
                                            <tr>
                                                <td>شقة</td>
                                                <td>2+1</td>
                                                <td>90<small>م2</small></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <span class="price">
                                        <img class="price_bg" width="100%" height="350" src="<?= asset("/img/offer-price-banner2.svg"); ?>" alt="damasturk" loading="lazy"/>
                                        <b>$ 439,000</b>
                                    </span>

                                    <div class="icon_video">
                                        <a data-fancybox="offer-video" href="https://www.youtube.com/embed/NgR9rzFPp3A"> 
                                            <div class="circle pulse"></div>
                                            <div class="circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                                                <polygon points="40,30 65,50 40,70"></polygon>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>

                                    <a href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000" class="contact_btn">تعرف على المزيد</a>
                                </div>

                            </div>
                            <div class="item">
                                <h4 class="pr_title">مشروع سكني</h4>
                                <p class="pr_sub_title">في منطقة بيوك شكمجة<br>بإطلالات بحرية ساحرة</p>
                                <a class="mobile_btn">اضغط لمعرفة العرض</a>
                                <img class="icon" width="100%" height="350" src="<?= asset("/img/landing/turkish-citizenship/pr02.png"); ?>" alt="damasturk" loading="lazy"/>
                                <div class="pr_info">
                                    <h5>معلومات العرض</h5>

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>النوع</th>
                                                <th>الغرف</th>
                                                <th>المساحة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>شقة دوبلكس</td>
                                                <td>2+1</td>
                                                <td>140<small>م2</small></td>
                                            </tr>
                                            <tr>
                                                <td>شقة</td>
                                                <td>1+1</td>
                                                <td>79<small>م2</small></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <span class="price">
                                        <img class="price_bg" width="100%" height="350" src="<?= asset("/img/offer-price-banner2.svg"); ?>" alt="damasturk" loading="lazy"/>
                                        <b>$ 435,000</b>
                                    </span>

                                    <div class="icon_video">
                                        <a data-fancybox="offer-video" href="https://www.youtube.com/embed/HTvN_yl_7hU"> 
                                            <div class="circle pulse"></div>
                                            <div class="circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                                                <polygon points="40,30 65,50 40,70"></polygon>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>

                                    <a href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000" class="contact_btn">تعرف على المزيد</a>
                                </div>
                            </div>
                            <div class="item">
                                <h4 class="pr_title">مشروع عائلي</h4>
                                <p class="pr_sub_title">في منطقة زيتون بورنو<br>بتشطيبات فاخرة وراقية</p>
                                <a class="mobile_btn">اضغط لمعرفة العرض</a>
                                <img class="icon" width="100%" height="350" src="<?= asset("/img/landing/turkish-citizenship/pr03.png"); ?>" alt="damasturk" loading="lazy"/>
                                <div class="pr_info">
                                    <h5>معلومات العرض</h5>

                                    <table>
                                        <thead>
                                            <tr>
                                                <th>النوع</th>
                                                <th>الغرف</th>
                                                <th>المساحة</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>شقة</td>
                                                <td>1+1</td>
                                                <td>74<small>م2</small></td>
                                            </tr>
                                            <tr>
                                                <td>شقة</td>
                                                <td>1+1</td>
                                                <td>74<small>م2</small></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <span class="price">
                                        <img class="price_bg" width="100%" height="350" src="<?= asset("/img/offer-price-banner2.svg"); ?>" alt="damasturk" loading="lazy"/>
                                        <b>$ 500,000</b>
                                    </span>

                                    <div class="icon_video">
                                        <a data-fancybox="offer-video" href="https://www.youtube.com/embed/_tLP7iN_Wl0"> 
                                            <div class="circle pulse"></div>
                                            <div class="circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                                                <polygon points="40,30 65,50 40,70"></polygon>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>

                                    <a href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000" class="contact_btn">تعرف على المزيد</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- End Projects Offers -->


                    <!-- Start More Btn -->
                    <div class="more_sec">
                        <p>لاتفوت الفرصة اشتريِ عقار واحصل على الجنسية</p>
                        <a class="green open_form" href="javascript:;"> <?= trans("front.gift landing page title btn"); ?></a>
                    </div>
                    <!-- End More Btn -->


                    <!-- Start FAQ -->
                    <div class="sec new_sec">
                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold">الأسئلة الشائعة عن للجنسية التركية</strong>
                                <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                            </h2>
                            <h3>يراود المستثمر الكثير من الاسئلة عن الجنسية التركية<br>اخترنا اهمها لكي نجاوبكم عليها واذا كان لديكم أسئلة<br>لا تترددو <a class="open_form">بالتواصل معنا</a> للإجابة على استفساراتكم</h3>
                        </div>


                        <!-- Accordion -->
                        <div class="acc-container sec sec_shadow">
                            <div class="acc">
                                <div class="acc-head">
                                    <h3>
                                        هل يسمح القانون التركي بازدواج الجنسية؟
                                    </h3>
                                </div>
                                <div class="acc-content">
                                    <p>
                                        نعم، يسمح القانون التركي بازدواج الجنسية، لكن عليك التأكد من الجهات المسؤولة في بلادك إن كان ذلك مسموحاً.
                                    </p>
                                </div>
                            </div>

                            <div class="acc">
                                <div class="acc-head">
                                    <h3>
                                        هل يمكن الحصول على الجنسية التركية دون حضوري؟
                                    </h3>
                                </div>
                                <div class="acc-content">
                                    <p>
                                        نعم، يمكن ذلك بإجراء توكيل رسمي في السفارات التركية في بلدك للفريق القانوني لداماس ترك، وسنتولى عنك كل الإجراءات.
                                    </p>
                                </div>
                            </div>

                            <div class="acc">
                                <div class="acc-head">
                                    <h3>
                                        ماهي الأوراق المطلوبة للتقدم للجنسية التركية عن طريق شراء العقارات؟
                                    </h3>
                                </div>
                                <div class="acc-content">
                                    <p>
                                        • وثيقة سند الملكية (الطابو).<br>
                                        • إيصال بالمبلغ المدفوع مقابل العقار، ويمكن الحصول عليه عن طريق البنك.<br>
                                        • جواز السفر.<br>
                                        • إقامة سارية المفعول في تركيا.<br>
                                        • وثيقة تثبيت العنوان.<br>
                                        ويتمّ تسليم هذه الأوراق لدائرة النفوس التابعة لولاية المحافظة التي يُقيم فيها.
                                    </p>
                                </div>
                            </div>


                        </div>


                    </div>
                    <!-- End FAQ -->



                    <!-- Start our clients -->
                    <div class="sec new_sec">
                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold"> عملاء حصلوا على الجنسية التركية</strong>
                                <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                            </h2>
                            <h3>ساعدنا الكثير من عملاؤنا بالحصول على الجنسية التركية<br>انضم إليهم ولا تتردد <a class="open_form">بالتواصل معنا</a></h3>
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



                    <!-- Start our services -->
                    <div class="sec new_sec">
                        <div class="section_title">
                            <h2>
                                <strong class="jazzira_font_bold">خدمات داماس ترك للجنسية التركية</strong>
                                <img class="title_paint" width="300" height="60px" src="<?= asset("/img/project-title-pattern.svg"); ?>" alt="damasturk" loading="lazy"/>
                            </h2>
                            <h3>بعد اختيار العقار المناسب نساعدكم فيما يلي</h3>
                        </div>


                        <ul class="services_list sec">
                            <li>
                                <div class="cont">
                                    <span class="icon">
                                        <img width="60" height="60" src="<?= asset("/img/Tabu.jpg"); ?>" alt="إجراءات الشراء وسند الملكية" loading="lazy"/>
                                    </span>
                                    <h4 class="text">إجراءات الشراء وسند الملكية</h4>
                                </div>
                            </li>
                            <li>
                                <div class="cont">
                                    <span class="icon">
                                        <img src="/img/landing/turkish-citizenship/home-icon.svg" alt="الحجز على العقار" width="60" height="60" loading="lazy"/>
                                    </span>
                                    <h4 class="text">الحجز على العقار</h4>
                                </div>
                            </li>
                            <li>
                                <div class="cont">
                                    <span class="icon">
                                        <img src="/img/landing/turkish-citizenship/uygunluk-belgesi.jpg" width="60" height="60" loading="lazy"/>
                                    </span>
                                    <h4 class="text">استخراج وثيقة المطابقة</h4>
                                </div>
                            </li>
                            <li>
                                <div class="cont">
                                    <span class="icon">
                                        <img src="/img/landing/turkish-citizenship/ikamet.jpg" width="60" height="60" loading="lazy"/>
                                    </span>
                                    <h4 class="text">استخراج إقامة المستثمر</h4>
                                </div>
                            </li>
                            <li>
                                <div class="cont">
                                    <span class="icon">
                                        <img src="/img/landing/turkish-citizenship/dosya-pembe.png" width="60" height="60" loading="lazy"/>
                                    </span>
                                    <h4 class="text">تسليم ملف الجنسية</h4>
                                </div>
                            </li>
                            <li>
                                <div class="cont">
                                    <span class="icon">
                                        <img src="/img/passportS2-SM.png" width="60" height="60" loading="lazy"/>
                                    </span>
                                    <h4 class="text">استخراج جوازات السفر</h4>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <!-- End our services -->







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
        <?php } else { ?>
			<?= Html::script("js/jquery.min.js") ?>
			<?= Html::script("js/intlTelInput.js") ?>
			<?= Html::script("js/jquery.fancybox.min.js") ?>
        <?php } ?>


        <script type="text/javascript">

$(document).ready(function () {
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
});

			var formHasChanged = false;
            $(document).ready(function () {



               
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
                e.preventDefault();
                formHasChanged = false;
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