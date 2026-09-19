<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
$arr_prices = [
    "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
];
$right = ($style_lang == 'ar' ? 'right' : 'left');
//$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/legal.css"); ?>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("resources/assets/css/legal-en.css"); ?>
    <?php } ?>
<?php } else { ?>


    <?= Html::style("css/slider-project-card.min.css"); ?>
    <?= Html::style("css/legal.min.css"); ?>

    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("css/legal-en.min.css"); ?>
    <?php } ?>
<?php } ?>


@endsection




@extends('front.layout', [
"page_title"        =>    $page->getSeoTitle(),
"page_description"  =>    $page->getSeoDescription(),
"page_keywords"     =>    $page->getSeoKeywords(),
"og_image"          =>    ($page->media?Helper::media_url_full($page->media):null),
"amp_url"           =>    route("amp.front.legal")
])



@section('main_content')


<div class="top_animate_sec">
    <div class="container">
        <div class="image_group">


            <h1 class="jazzira_font legal_page">
                <span><?= trans("front.legal title page"); ?></span>
                <span><?= trans("front.legal sub title page"); ?></span>
            </h1>

            <img class="base animate__animated" src="<?= asset("/img/Base.png"); ?>" alt="damasturk"/>
            <img class="living_page_top_1 animate__animated" src="<?= asset("/img/legal-top-1.png"); ?>" alt="damasturk"/>
            <img class="living_page_top_2 animate__animated" src="<?= asset("/img/legal-top-2.png"); ?>" alt="damasturk"/>
            <img class="living_page_top_3 animate__animated" src="<?= asset("/img/legal-top-3.png"); ?>" alt="damasturk"/>


            <img class="cloud1 animate__animated" src="<?= asset("/img/cloud1.png"); ?>" alt="damasturk"/>
            <img class="cloud2 animate__animated" src="<?= asset("/img/cloud2.png"); ?>" alt="damasturk"/>
            <img class="cloud3 animate__animated" src="<?= asset("/img/cloud3.png"); ?>" alt="damasturk"/>
        </div>
    </div>
</div>




<div class="col-md-10 offset-md-1">
    <div class="full_sections">


        <div class="left_sec">

            <?php //if (Helper::get_device() == 'mob') { ?>
                <section class="form shadow_type mob_form">
                    @include("front.partials.call_us_fixed")
                </section>
            <?php //} ?>


            <div class="col-md-12">
                <div class="int_content population_sec">
                    <img class="icon" src="<?= asset("/img/Ikamet.png"); ?>" alt="damasturk"/>

                    <?= trans("front.Types of residence in Turkey"); ?>
                </div>
            </div>

            <div class="col-md-12">
                @include("front.partials.pub",['_index'=>1])
            </div>


            <div class="col-md-12">
                <div class="row">
                    @include("front.partials.share_links", [])
                </div>
            </div>

            <div class="col-md-12">
                <div class="row">
                    @include("front.partials.subscribe_youtube", [])
                </div>
            </div>




            <div class="col-md-12">
                <div class="int_content h_f_sec">
                    <div class="title">
                        <img class="icon" src="<?= asset("/img/h-title-icon-1.svg"); ?>" alt="damasturk"/>
                        <h2><?= trans("front.Documents required to obtain a residence permit in Turkey"); ?></h2>
                    </div>



                    <p class="jazzira_font margin_top_50">

                        <?= trans("front.Documents required to obtain a residence permit in Turkey text"); ?>

                    </p>



                    <div class="footer_document green"></div>
                </div>
            </div>





            <div class="col-md-12">
                <div class="int_content h_f_sec two">
                    <div class="title">
                        <img class="icon" src="<?= asset("/img/h-title-icon-2.svg"); ?>" alt="damasturk"/>
                        <h2><?= trans("front.The application for a residence permit in Turkey"); ?></h2>
                    </div>


                    <p class="jazzira_font margin_top_50">
                        <?= trans("front.The application for a residence permit in Turkey text"); ?>
                    </p>



                    <div class="footer_document blue"></div>
                </div>
            </div>



            <?php //if (Helper::get_device() == 'mob') { ?>
                <section class="form shadow_type mob_form">
                    @include("front.partials.call_us_fixed")
                </section>
            <?php //} ?>


            <div class="col-md-12">
                <div class="int_content h_f_sec three">
                    <div class="title">
                        <img class="icon" src="<?= asset("/img/h-title-icon-3.svg"); ?>" alt="damasturk"/>
                        <h2><?= trans("front.Real estate fees for purchasing a property in Turkey"); ?></h2>
                    </div>


                    <ul class="jazzira_font">

                        <p>
                            <?= trans("front.Real estate fees for purchasing a property in Turkey text"); ?>
                        </p>

                    </ul>


                    <div class="footer_document dark_blue"></div>
                </div>
            </div>


            <!-- Out Link Section -->
            <div class="col-md-12">
                <div class="row">
                    <div class="space_link investment_out_link">
                        <div class="content">
                            <p><?= trans("front.InvestmentTurkey"); ?></p>
                            <img class="icon" src="<?= asset("/img/out-link-button1.svg"); ?>" alt="damasturk"/>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- Out Link Section -->




            <div class="col-md-12">
                <div class="int_content tabu_sec">
                    <h2 class="sub_title"><?= trans("front.The title deed in Turkey that is known as Tapu"); ?></h2>

                    <div class="col-md-4 pull-right">
                        <a data-fancybox="tabu" href="<?= asset("/img/Tabu.jpg"); ?>">
                            <img class="icon" src="<?= asset("/img/Tabu.jpg"); ?>" alt="damasturk"/>
                        </a>
                    </div>
                    <div class="col-md-8 pull-right">


                        <p><?= trans("front.The title deed in Turkey that is known as Tapu text"); ?></p>

                    </div>



                    <?php if ($current_lang == 'ru') { ?>
                        <a class="more green" href="<?= route("front.blog") ?>"><?= trans("front.load more"); ?></a>
                    <?php } else { ?>
                        <a class="more green" href="<?= route("front.search", ["blog", "tabu-turkey"]) ?>"><?= trans("front.load more"); ?></a>
                    <?php } ?>



                </div>
            </div>


            <div class="col-md-12 inverse">

                <div class="citizenship_steps_sec passport_strong shadow_type">

                    <img class="earth_icon" src="<?= asset("/img/earth.svg"); ?>" alt="damasturk"/>
                    <img class="point_flag" src="<?= asset("/img/point-turkey-flag.svg"); ?>" alt="damasturk"/>
                    <img class="passport" src="<?= asset("/img/Passport2.png"); ?>" alt="damasturk"/>

                    <h2 class="jazzira_font_bold"><?= trans("front.Turkish citizenship heading top one"); ?> <br> <?= trans("front.Turkish citizenship heading top two"); ?> <br> <?= trans("front.Turkish citizenship heading top three"); ?></h2>

                    <ul class="jazzira_font">
                        <?= trans("front.turkish citizenship decisions"); ?>
                    </ul>

                    <a class="more green" href="{{ route('front.turkish_citizenship') }}"><?= trans("front.Learn more about Turkish citizenship"); ?></a>

                </div>

            </div>



            <!-- Out Link Section -->
<!--            <div class="col-md-12">
                <div class="row">
                    <div class="space_link citizenship_out_link">
                        <div class="content">
                            <p><?= trans("front.TurkishCitizenship"); ?></p>
                            <img class="icon" src="<?= asset("/img/out-link-button1.svg"); ?>" alt="damasturk"/>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Out Link Section -->
            
            
            
                 
            <!-- Slider Pages links -->
            @include("front.partials.slider_pages_links")
            <!-- Slider Pages links -->



            <div class="col-md-12 faq_sec margin_bottom_20">
                <div class="row">
                    <div class="col-md-12">
                        <div class="int_content shadow_type">

                            <h2 class="jazzira_font_bold"><?= trans("front.FAQ about"); ?> <?= trans("front.Legal Affairs"); ?></h2>

                            <img class="icon" src="<?= asset("/img/invest14.svg"); ?>" alt="damasturk"/>

                            <ul class="jazzira_font">
                                <?php
                                $rows = DB::select("select * from dms_faq where faq_post=?  order by id asc LIMIT 3", [5]);

                                /* print_r($rows);
                                  echo $rows[0]->q_ar;
                                  exit; */
                                $i = 0;
                                foreach ($rows as $r) {
                                    $i++;
                                    $q = 'q_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
                                    $res = 'r_' . ($current_lang == 'pe' ? 'fa' : $current_lang);

                                    if (trim($r->$q) != '') {
                                        ?>
                                        <li>
                                            <span class="jazzira_font_bold"><?= $r->$q ?></span>
                                            <p><?= $r->$res ?></p>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>

                            <div class="col-md-12">
                                <a class="more green" href="<?= route("front.faq_show", ["legal-affairs"]) ?>"><?= trans("front.view more"); ?></a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-12">
                <div class="row">
                    @include("front.partials.subscribe_allow", [])
                </div>
            </div>



            <div class="col-md-12">
                @include("front.partials.testimonials_slider", [])
            </div>

            @include("front.partials.top_visited_posts", ['cat_id'=>2])


        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div class="fixed_sec">

                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>

                <!-- About Us -->
                @include("front.partials.about_sec", [])


            </div>
        </div>

    </div>
    <!-- End Fixed Section -->

</div>






@endsection



@section('scriptjs')

<!--<?= Html::script("js/swiper.min.js"); ?>-->


<script>


    $(document).ready(function () {
        var decisionPhotoH = $('.decision-photo').height() - 20;
        $(".decision-arabic").css("max-height", decisionPhotoH);




        $('#checkbox').change(function () {
            if ($(this).is(':checked')) {
                window.OneSignal.registerForPushNotifications();
            }
        });




    });





    $(window).scroll(function () {
        var scrollingPage = 700;
        var scrollingPage2 = 700;
        var scroll = $(window).scrollTop();
        if (scroll >= scrollingPage) {
            $(".header").addClass("scrolling");
        } else {
            $(".header").removeClass("scrolling");
        }
        if (scroll >= scrollingPage2) {
            $(".fixed_sec").addClass("fixed");
        } else {
            $(".fixed_sec").removeClass("fixed");
        }
    });



    $(document).ready(function () {

        var windowH = $(window).height();
        //$(".top_animate_sec").height(windowH);
        //$('.main_menu .links>li>a.turkish_citizenship').addClass("active");

        setTimeout(function () {
            $('.base').addClass("animate__fadeInUp");
            $('.cloud1').addClass("animate__zoomIn");
            $('.cloud2').addClass("animate__zoomIn");
            $('.cloud3').addClass("animate__zoomIn");
            $('.living_page_top_1').addClass("animate__zoomIn");
            $('.living_page_top_2').addClass("animate__zoomIn");
            $('.living_page_top_3').addClass("animate__zoomIn");
            $('.living_page_top_4').addClass("animate__zoomIn");
        }, 500);

        setTimeout(function () {
            $('.top_animate_sec .image_group h1 span').addClass("animate");
        }, 800);
        setTimeout(function () {
            $('.top_animate_sec .image_group h1 span').addClass("animate");
        }, 1000);
        setTimeout(function () {
            $('.cloud1').addClass("playing");
            $('.cloud2').addClass("playing");
            $('.cloud3').addClass("playing");
        }, 1500);



        var cloud1 = $(".cloud1");
        var cloud2 = $(".cloud2");
        var cloud3 = $(".cloud3");
        var livingPageTop1 = $(".living_page_top_1");
        var livingPageTop2 = $(".living_page_top_2");
        var livingPageTop3 = $(".living_page_top_3");
        var livingPageTop4 = $(".living_page_top_4");
        var base = $(".base");
        var H1 = $(".top_animate_sec .image_group h1");
        $("body").mousemove(function (event) {
            var x = event.pageX;
            var y = event.pageY;
            cloud1.css({'margin-top': y / 50, 'margin-left': x / 50}); // better use CSS
            cloud2.css({'margin-top': y / 40, 'margin-left': x / 40}); // better use CSS
            cloud3.css({'margin-top': y / 30, 'margin-left': x / 30}); // better use CSS
            livingPageTop1.css({'margin-top': y / 60, 'margin-left': x / 60}); // better use CSS
            livingPageTop2.css({'margin-top': y / 50, 'margin-left': x / 60}); // better use CSS
            livingPageTop3.css({'margin-top': y / 40, 'margin-left': x / 60}); // better use CSS
            livingPageTop4.css({'margin-top': y / 30, 'margin-left': x / 60}); // better use CSS
            base.css({'margin-top': y / 100, 'margin-left': x / 100}); // better use CSS
            H1.css({'margin-top': y / 70, 'margin-left': x / 70}); // better use CSS
        });


    });


    /*
     (function ($) {
     $(function () {
     
     var agSwiper = $('.slider');
     
     if (agSwiper.length > 0) {
     
     var sliderView = 3;
     var ww = $(window).width();
     if (ww >= 1700)
     sliderView = 3;
     if (ww <= 1700)
     sliderView = 3;
     if (ww <= 1560)
     sliderView = 2;
     if (ww <= 1400)
     sliderView = 2;
     if (ww <= 1060)
     sliderView = 2;
     if (ww <= 800)
     sliderView = 2;
     if (ww <= 560)
     sliderView = 1;
     if (ww <= 400)
     sliderView = 1;
     
     var swiper = new Swiper('.slider', {
     slidesPerView: sliderView,
     spaceBetween: 0,
     pagination: {
     el: '.slider__pagination',
     clickable: true,
     },
     navigation: {
     nextEl: '.slider__button-next',
     prevEl: '.slider__button-prev',
     },
     autoplay: {delay: 5000, },
     //loop: true,
     //loopedSlides: 16,
     speed: 700,
     autoplay: true,
     autoplayDisableOnInteraction: true,
     //centeredSlides: true
     });
     
     $(window).resize(function () {
     var ww = $(window).width();
     if (ww >= 1700)
     sliderView = 3;
     if (ww <= 1700)
     sliderView = 3;
     if (ww <= 1560)
     sliderView = 2;
     if (ww <= 1400)
     sliderView = 2;
     if (ww <= 1060)
     sliderView = 2;
     if (ww <= 800)
     sliderView = 2;
     if (ww <= 560)
     sliderView = 1;
     if (ww <= 400)
     sliderView = 1;
     });
     
     $(window).trigger('resize');
     
     var mySwiper = document.querySelector('.slider').swiper;
     
     agSwiper.mouseenter(function () {
     mySwiper.autoplay.stop();
     console.log('slider stopped');
     });
     
     agSwiper.mouseleave(function () {
     mySwiper.autoplay.start();
     console.log('slider started again');
     });
     }
     
     });
     })(jQuery);*/

</script>


@endsection



@section('schemaorg')

<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "{{url('/')}}",
    "logo": "<?= asset('img/logo2.png'); ?>"
    }
</script>
<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "WebSite",
    "url": "{{url('/')}}",
    "potentialAction": {
    "@type": "SearchAction",
    "target": "{{url('/')}}/search?s={search_term_string}",
    "query-input": "required name=search_term_string"
    }
    }
</script>

<script type="application/ld+json">
	{
	"@context":"http://schema.org",
	"@type":"BreadcrumbList",
	"itemListElement":[

	{"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
	{"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trans('front.legal affairs turkey') }}","item":"{{ route('front.legal') }}"}


	]
	}
</script>
@endsection