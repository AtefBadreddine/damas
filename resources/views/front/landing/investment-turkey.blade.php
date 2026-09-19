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
            <?= Html::style("resources/assets/css/landing/investment.css") ?>


        <?php } else { ?>

            <?= Html::style("css/intlTelInput.fancybox.min.css") ?>
            <?= Html::style("css/landing_investment.min.css") ?>

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

                <img class="top_photo float_animate" width="60" height="60" src="<?= asset("/img/landing/investment/top-photo-03.webp"); ?>" alt="الاستثمار العقاري في تركيا" loading="lazy"/>

            </div>
        </div>



        <div class="col-md-10 offset-md-1">
            <div class="full_sections">


                <!-- Start Why Istanbul section -->
                <div id="why_sec" class="sec section_padding">
                    <div class="section_title">
                        <h2>
                            <strong class="jazzira_font_bold">لماذا الاستثمار في تركيا؟</strong>
                        </h2>
                        <h3>تتمتع تركيا بكثير من المميزات الاستثمارية أهمها</h3>
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
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/villas-istanbul/luxury-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>تشطبيات فاخرة</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>3</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/villas-istanbul/sea-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>إطلالات ساحرة</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>4</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/family-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>بيئة مناسبة للعائلات</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>5</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/family-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>بيئة مناسبة للعائلات</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>6</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/family-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>بيئة مناسبة للعائلات</h4>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Why Istanbul section -->




                <!-- Start Why Istanbul section -->
                <div id="why_sec" class="sec section_padding">
                    <div class="section_title">
                        <h2>
                            <strong class="jazzira_font_bold">إذا كنت ترغب بالسكن في تركيا</strong>
                        </h2>
                        <h3>فإن تركيا فيها مميزات كثيرة تميزها عن غيرها من البلدان</h3>
                    </div>

                    <div class="steps_cont steps_two">
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
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/villas-istanbul/luxury-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>تشطبيات فاخرة</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>3</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/villas-istanbul/sea-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>إطلالات ساحرة</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>4</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/family-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>بيئة مناسبة للعائلات</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>5</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/family-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>بيئة مناسبة للعائلات</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="num"><span>6</span></div>
                            <div class="cont">
                                <img class="icon" width="60" height="60" src="<?= asset("/img/landing/apartments-istanbul/family-icon.svg"); ?>" alt="شقق للبيع في اسطنبول" loading="lazy"/>
                                <h4>بيئة مناسبة للعائلات</h4>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- End Why Istanbul section -->






                <!-- Start Projects Offers -->
                <div class="sec new_sec">
                    <div class="section_title">
                        <h2>
                            <strong class="jazzira_font_bold">عروض استثمارية حقيقية</strong>
                        </h2>
                        <h3>اخترنا لك أفضل المشاريع ذات العائد الاستثماري الحقيقي  </h3>
                    </div>


                    <div class="projects_list">
                        <div class="item">
                            <img class="icon" width="100%" height="350" src="https://damas.net/uploads/offer-photo-38345ba3e2c4c080c42bcc745bd7072c0505.png" alt="damasturk" loading="lazy"/>

                            <h4 class="pr_title"> محل تجاري ضمن أكبر مركز تسوق </h4>
                            <p class="pr_sub_title"> مؤجر لبراند ألبسة عالمي لمدة 10 سنوات <br> 20000 دولار أجار شهري <br> عائد استثماري 20% </p>
                        </div>
                        <div class="item">
                            <img class="icon" width="100%" height="350" src="https://damas.net/uploads/offer-photo-1cecf56cc058c5270476ed4fcad002349628.png" alt="damasturk" loading="lazy"/>

                            <h4 class="pr_title">شقق فندقية ضمن مشروع فاخر</h4>
                            <p class="pr_sub_title">في منطقة بيوك شكمجة<br>بإطلالات بحرية ساحرة</p>

                        </div>
                        <div class="item">
                            <img class="icon" width="100%" height="350" src="https://damas.net/uploads/offer-photo-2de955ff335202875b0b38a4c0780fbbf485.png" alt="damasturk" loading="lazy"/>

                            <h4 class="pr_title">فلل بإطلالات بحرية قرب مركز المدينة</h4>
                            <p class="pr_sub_title">في منطقة زيتون بورنو<br>بتشطيبات فاخرة وراقية</p>
                        </div>
                    </div>

                </div>
                <!-- End Projects Offers -->




                <!-- Start FAQ -->
                <div class="sec new_sec">
                    <div class="section_title">
                        <h2>
                            <strong class="jazzira_font_bold">الأسئلة الشائعة عن الاستثمار في تركيا </strong>
                        </h2>
                        <h3>يراود المستثمر الكثير من الاسئلة عن العائد الاستثتماري<br>اخترنا اهمها لكي نجاوبكم عليها واذا كان لديكم أسئلة<br>لا تترددو <a class="open_form">بالتواصل معنا</a> للإجابة على استفساراتكم</h3>
                    </div>


                    <!-- Accordion -->
                    <div class="acc-container sec sec_shadow">

                        <div class="acc">
                            <div class="acc-head">
                                <h3>
                                    ما هو أفضل استثمار في تركيا؟
                                </h3>
                            </div>
                            <div class="acc-content">
                                <p>
                                    إن أفضل استثمار في تركيا، هو الاستثمار في العقارات التجارية، بشراء محل مؤجر لماركة عالمية في مول تجاري في منطقة متوسطة بسعر 400 ألف دولار أمريكي، وبيعة بعد 3 سنوات بهامش ربح معقول، وتحقيق عائد ايجاري 6-7% سنوياً، والحصول طبعاً على الجنسبة التركية لك ولأفراد عائلتك من هم دون سن الـ 18.
                                </p>
                            </div>
                        </div>

                        <div class="acc">
                            <div class="acc-head">
                                <h3>
                                    هل الاستثمار في فلل للبيع في تركيا استثمار ناجح؟
                                </h3>
                            </div>
                            <div class="acc-content">
                                <p>
                                    يقدّم الاستثمار في فلل للبيع في تركيا ميزة كبيرة ومثالية في حال التفكير بالاستثمار على المدى الطويل، كما أنّ الاستثمار في فلل تركيا يعتبر من أسهل وأسرع الطرق للحصول على الجنسية التركية التي تُمنح مقابل التملك في تركيا والتمتع بكافة حقوق الإقامة والعمل في تركيا. وأخيراً، تمتاز فلل للبيع في تركيا بإمكانية خيالية للتأجير، حيث يمكن أن تقدّم دخل تأجير صافي يزيد على 10% والميزة الأخرى في فلل تركيا أنّ أسعارها ترتفع بحدود 10% كل سنة.
                                </p>
                            </div>
                        </div>



                        <div class="acc">
                            <div class="acc-head">
                                <h3>
                                    ماهي مناطق الاستثمار في المحلات التجارية في إسطنبول؟
                                </h3>
                            </div>
                            <div class="acc-content">
                                <p> يمكن تقسيم مناطق اسطنبول من حيث الأهمية الاستثمارية للمحلات التجارية إلى قسمين:<br>
                                    1- المناطق المكتملة من حيث القيمة الاستثمارية: تتضمن الأسواق المشهورة التي تشكل مراكز جذب رئيسية مثل السوق المسقوف في منطقة فاتح والذي يحتضن أغلى المحلات التجارية على مستوى تركيا حيث يصل إيجار سعر المتر مربع الواحد إلى 3500 دولار شهرياً.<br>
                                    2-المناطق الواعدة من حيث القيمة الاستثمارية: وهي مناطق جديدة واعدة من حيث الاستثمار في المحلات التجارية تنمو وتتطّور بفضل كثرة المشاريع العقارية الحديثة التي تحتضنها، ومن أهم هذه المناطق شارع باسن إكسبرس ومناطق بيليك دوزو وباشاك شهير. </p>
                            </div>
                        </div>


                    </div>


                </div>
                <!-- End FAQ -->




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