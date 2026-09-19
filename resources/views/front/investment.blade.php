<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
/*$arr_prices = [
    "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
];*/
$right = ($style_lang == 'ar' ? 'right' : 'left');
$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/faq.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/investment.css"); ?>

<?php } else { ?>

    <?php // echo Html::style("/css/index" . (Helper::get_device() != 'full' ? '-mob' : '') . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?>
    <style>
    <?php include(public_path() . "/css/investment.min.css"); ?>
    .collapse.in {
    display: block;
}
	</style>

<?php } ?>


@endsection





@extends('front.layout', [
"page_title"        =>    $page->getSeoTitle(),
"page_description"  =>    $page->getSeoDescription(),
"page_keywords"     =>    $page->getSeoKeywords(),
"og_image"          =>    ($page->getMediaId()?Helper::media_url_full(Helper::query("Media", "find", ["id" => $page->getMediaId()])):null),
/*"amp_url"           =>    route("amp.front.investment")*/
])


@section('main_content')


<div class="top_animate_sec">
    <div class="container">
        <div class="image_group">


            <h1 class="jazzira_font investment_page">
                <span><?= trans("front.investment page title 1"); ?></span>
                <span><?= trans("front.investment page title 2"); ?></span>
            </h1>

            <img class="passportB animate__animated" src="<?= asset("/img/Base.png"); ?>" alt="damasturk"/>
            <img class="turk_flag animate__animated" src="<?= asset("/img/Building.png"); ?>" alt="damasturk"/>
            <img class="turkey_text animate__animated" src="<?= asset("/img/Coins.png"); ?>" alt="damasturk"/>
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
                <div class="row">

                    <div class="col-md-6">
                        <?php
                        $pubs = Helper::getPub();
                        if (isset($pubs[0])) {
                            $pub = $pubs[0];
                            ?>
                            <div class="offer_sec one">

                                <h2><?= trans("front.Real estate investment options in Turkey"); ?></h2>

                                <div class="number-list"><span class="active"><strong>1</strong></span> <span><strong>2</strong></span> <span><strong>3</strong></span></div>

                                <img src="<?= Helper::media_url($pub->media); ?>" alt="damasturk"/>
                                <h3>{{ $pub->getTitle() }}</h3>


                                <ul class="jazzira_font">
                                    <?php
                                    $conts = explode('#;#', $pub->getContent());
                                    foreach ($conts as $c) {
                                        if ($c != '') {
                                            ?>
                                            <li>
                                                <p>{{ $c }}</p>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>

                                <?php /* <a class="more" href="{{ str_replace(['/fr/','/en/','/fa/','/pe/'],'/'.$current_lang.'/',$pub->link) }}"><?= trans("front.details"); ?></a> */ ?>


                                <a class="more" href="<?= $current_lang == 'ar' ? $pub->link : str_replace('damas.net/', 'damas.net/' . $current_lang . '/', $pub->link) ?>"><?= trans("front.details"); ?></a>

                            </div>
                        <?php } ?>
                    </div>


                    <div class="col-md-6">
                        <div class="citizenship_steps_sec">
                            <h2 class="main_title">
                                <span><?= trans("front.Global ranking of the Turkish economy"); ?></span>
                            </h2>

                            <img src="<?= asset("/img/invest1.svg"); ?>" alt="damasturk"/>


                            <div class="int_content">
                                <h3 class="int_title"><?= trans("front.Number of universities and university graduates"); ?>
                                    <span><?= trans("front.Thousands"); ?></span>
                                </h3>

                                <img src="<?= asset("/img/invest2.svg"); ?>" alt="damasturk"/>
                            </div>



                        </div>
                    </div>


                </div>
            </div>



            <?php if ($page->getContent() != '') { ?>
                <div class="col-md-12">
                    <div class="int_content turkish_citizenship_content">
                        <div class="cont sec">
                            <p class="jazzira_font">
                                {!! html_entity_decode($page->getContent()) !!}
                            </p>
                        </div>

                        <span class="show_more_btn"><strong class="more"><?= trans("front.read more"); ?></strong> <strong class="less"><?= trans("front.read less"); ?></strong></span>

                    </div>
                </div>
            <?php } ?>



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



            <div class="col-md-12 margin_bottom_20">
                <div class="row">
                    <div class="col-md-6">
                        <div class="int_content">
                            <h3 class="int_title">
                                <p class="num">2019</p>
                                <?= trans("front.skilled workforce"); ?>
                                <span><?= trans("front.Millions"); ?></span>
                            </h3>

                            <img src="<?= asset("/img/invest4.svg"); ?>" alt="damasturk"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="int_content">
                            <h3 class="int_title">
                                <p class="num">2018</p>
                                <?= trans("front.skilled workforce"); ?>
                                <span><?= trans("front.Millions"); ?></span>
                            </h3>

                            <img src="<?= asset("/img/invest3.svg"); ?>" alt="damasturk"/>
                        </div>
                    </div>
                </div>
            </div>



            <?php //if (Helper::get_device() == 'mob') { ?>
                <section class="form shadow_type mob_form">
                    @include("front.partials.call_us_fixed")
                </section>
            <?php //} ?>


            <div class="col-md-12 margin_bottom_20 incentives_sec">
                <div class="row">

                    <div class="col-md-6">
                        <h2 class="sub_title"><?= trans("front.High investment incentives"); ?></h2>


                        <div class="icons_group">
                            <div class="col-md-6">
                                <img src="<?= asset("/img/invest6.svg"); ?>" alt="damasturk"/>
                                <h4 class="jazzira_font">
                                    <?= trans("front.Equal treatment"); ?>
                                    <span><?= trans("front.for international and local investors"); ?></span>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <img src="<?= asset("/img/invest5.svg"); ?>" alt="damasturk"/>
                                <h4 class="jazzira_font">
                                    <?= trans("front.Easy accessing"); ?>
                                    <span><?= trans("front.to incentives and tax exemptions"); ?></span>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <img src="<?= asset("/img/invest8.svg"); ?>" alt="damasturk"/>
                                <h4 class="jazzira_font">
                                    <?= trans("front.Incentives available"); ?>
                                    <span><?= trans("front.in various sectors and scales"); ?></span>
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <img src="<?= asset("/img/invest7.svg"); ?>" alt="damasturk"/>
                                <h4 class="jazzira_font">
                                    <span><?= trans("front.One of the most competitive investment incentive systems"); ?></span>
                                    <?= trans("front.in the emerging markets"); ?>
                                </h4>
                            </div>
                        </div>



                        <div class="int_content brands">
                            <h3 class="int_title"><?= trans("front.Numerous global companies manage their operations in Turkey"); ?></h3>

                            <div class="icons_group">

                                <div class="col-md-6">
                                    <img src="<?= asset("/img/invest9.svg"); ?>" alt="damasturk"/>
                                    <h4 class="jazzira_font">
                                        <span><?= trans("front.These companies run, in Turkey, the world's largest production facilities"); ?></span>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <img src="<?= asset("/img/invest10.svg"); ?>" alt="damasturk"/>
                                    <h4 class="jazzira_font">
                                        <span><?= trans("front.Turkey stands out as the regional base of production for the Middle East and North Africa"); ?></span>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <img src="<?= asset("/img/invest11.svg"); ?>" alt="damasturk"/>
                                    <h4 class="jazzira_font">
                                        <span><?= trans("front.These companies export of its production from Turkey"); ?></span>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <img src="<?= asset("/img/invest12.svg"); ?>" alt="damasturk"/>
                                    <h4 class="jazzira_font">
                                        <span><?= trans("front.These companies export more than of its production from Turkey"); ?></span>
                                    </h4>
                                </div>
                            </div>


                        </div>


                    </div>

                    <div class="col-md-6">
                        <?php
                        if (isset($pubs[1])) {
                            $pub = $pubs[1];
                            ?>
                            <div class="offer_sec two">

                                <h2><?= trans("front.Real estate investment options in Turkey"); ?></h2>

                                <div class="number-list"><span><strong>1</strong></span> <span class="active"><strong>2</strong></span> <span><strong>3</strong></span></div>

                                <img src="<?= Helper::media_url($pub->media); ?>" alt="damasturk"/>
                                <h3>{{ $pub->getTitle() }}</h3>


                                <ul class="jazzira_font">
                                    <?php
                                    $conts = explode('#;#', $pub->getContent());
                                    foreach ($conts as $c) {
                                        if ($c != '') {
                                            ?>
                                            <li>
                                                <p>{{ $c }}</p>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>

                                <?php /* <a class="more" href="{{ str_replace(['/fr/','/en/','/fa/','/pe/'],'/'.$current_lang.'/',$pub->link) }}"><?= trans("front.details"); ?></a> */ ?>
                                <a class="more" href="<?= $current_lang == 'ar' ? $pub->link : str_replace('damas.net/', 'damas.net/' . $current_lang . '/', $pub->link) ?>"><?= trans("front.details"); ?></a>
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>



            <div class="col-md-12 inverse margin_bottom_20">
                <div class="row">

                    <div class="col-md-6">

                        <?php
                        if (isset($pubs[2])) {
                            $pub = $pubs[2];
                            ?>
                            <div class="offer_sec three">

                                <h2><?= trans("front.Real estate investment options in Turkey"); ?></h2>


                                <div class="number-list"><span><strong>1</strong></span> <span><strong>2</strong></span> <span class="active"><strong>3</strong></span></div>

                                <img src="<?= Helper::media_url($pub->media); ?>" alt="damasturk"/>
                                <h3>{{ $pub->getTitle() }}</h3>


                                <ul class="jazzira_font">
                                    <?php
                                    $conts = explode('#;#', $pub->getContent());
                                    foreach ($conts as $c) {
                                        if ($c != '') {
                                            ?>
                                            <li>
                                                <p>{{ $c }}</p>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>

                                <?php /* <a class="more" href="{{ str_replace(['/fr/','/en/','/fa/','/pe/'],'/'.$current_lang.'/',$pub->link) }}"><?= trans("front.details"); ?></a> */ ?>
                                <a class="more" href="<?= $current_lang == 'ar' ? $pub->link : str_replace('damas.net/', 'damas.net/' . $current_lang . '/', $pub->link) ?>"><?= trans("front.details"); ?></a>

                            </div>
                        <?php } ?>
                    </div>



                    <div class="col-md-6">
                        <div class="citizenship_steps_sec passport_strong shadow_type resale_sec">

                            <img class="earth_icon" src="<?= asset("/img/invest13.svg"); ?>" alt="damasturk"/>

                            <h2 class="jazzira_font_bold"><?= trans("front.resale guarantee title"); ?></h2>

                            <ul class="jazzira_font">
                                <?= trans("front.resale guarantee text"); ?>
                            </ul>

                        </div>
                    </div>



                </div>
            </div>


            <?php //if (Helper::get_device() == 'mob') { ?>
                <section class="form shadow_type mob_form">
                    @include("front.partials.call_us_fixed")
                </section>
            <?php //} ?>




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



            <div class="int_content faqContent shadow_type">
                <img class="icon" src="<?= asset("/img/faqIcon.png"); ?>" alt="damasturk"/>

                <h2 class="jazzira_font_bold faq_title"><?= trans("front.FAQ about"); ?> <?= trans("front.InvestmentTurkey"); ?></h2>

                <section class="faq-section sec">

                    <!-- ***** FAQ Start ***** -->
                    <div class="faq sec" id="accordion">


                        <?php
                        $faqs = DB::select("select * from dms_faq where faq_post=?  order by id asc LIMIT 6", [3]);

                        /* print_r($faqs);
                          echo $faqs[0]->q_ar;
                          exit; */
                        $i = 0;
                        foreach ($faqs as $r) {
                            $i++;
                            $q = 'q_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
                            $res = 'r_' . ($current_lang == 'pe' ? 'fa' : $current_lang);

                            if (trim($r->$q) != '') {
                                ?>
                                <div class="card sec">
                                    <div class="card-header" id="faqHeading-<?= $i ?>">
                                        <div class="mb-0">
                                            <h2 class="faq-title jazzira_font_bold" data-toggle="collapse" data-target="#faqCollapse-<?= $i ?>" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
                                                <i class="arrow"></i>
                                                <span class="num"><?= $i ?></span>
                                                <?= $r->$q ?>
                                            </h2>
                                        </div>
                                    </div>
                                    <div id="faqCollapse-<?= $i ?>" class="collapse" aria-labelledby="faqHeading-<?= $i ?>" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>
                                                <?= $r->$res ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>


                    </div>

                </section>



            </div>




            <div class="col-md-12">
                @include("front.partials.testimonials_slider", [])
            </div>


			@include("front.partials.top_visited_posts", ['cat_id'=>1])


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

<?php if (App::isLocal()) { ?>
    <!--<?= Html::script("resources/assets/js/swiper.min.js"); ?>-->
<?php } else { ?>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!--<?= Html::script("js/swiper.min.js"); ?>-->
<?php } ?>



<script>


    $(document).ready(function () {
        var decisionPhotoH = $('.decision-photo').height() - 20;
        $(".decision-arabic").css("max-height", decisionPhotoH);






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
    });



    $(document).ready(function () {

        var windowH = $(window).height();
        //$(".top_animate_sec").height(windowH);
        //$('.main_menu .links>li>a.turkish_citizenship').addClass("active");

        setTimeout(function () {
            $('.passportB').addClass("animate__fadeInUp");
            $('.cloud1').addClass("animate__zoomIn");
            $('.cloud2').addClass("animate__zoomIn");
            $('.cloud3').addClass("animate__zoomIn");
            $('.turkey_text').addClass("animate__fadeInTopLeft");
        }, 500);

        setTimeout(function () {
            $('.top_animate_sec .image_group h1 span:nth-child(1)').addClass("animate");
        }, 800);
        setTimeout(function () {
            $('.top_animate_sec .image_group h1 span:nth-child(2)').addClass("animate");
            $('.turk_flag').addClass("animate__fadeInLeft");
        }, 1000);
        setTimeout(function () {
            $('.cloud1').addClass("playing");
            $('.cloud2').addClass("playing");
            $('.cloud3').addClass("playing");
        }, 1500);



        var cloud1 = $(".cloud1");
        var cloud2 = $(".cloud2");
        var cloud3 = $(".cloud3");
        var turkeyText = $(".turkey_text");
        var turkFlag = $(".turk_flag");
        var passportB = $(".passportB");
        var H1 = $(".top_animate_sec .image_group h1");
        $("body").mousemove(function (event) {
            var x = event.pageX;
            var y = event.pageY;
            cloud1.css({'margin-top': y / 50, 'margin-left': x / 50}); // better use CSS
            cloud2.css({'margin-top': y / 40, 'margin-left': x / 40}); // better use CSS
            cloud3.css({'margin-top': y / 30, 'margin-left': x / 30}); // better use CSS
            turkeyText.css({'margin-top': y / 60, 'margin-left': x / 60}); // better use CSS
            turkFlag.css({'margin-top': y / 80, 'margin-left': x / 80}); // better use CSS
            passportB.css({'margin-top': y / 100, 'margin-left': x / 100}); // better use CSS
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
    })(jQuery);
*/


    $(".less").hide();
    $(document).on("click", ".show_more_btn", function () {
        $('html, body').animate({
            scrollTop: $('.turkish_citizenship_content').offset().top - 100
        }, 'slow');

        $(".turkish_citizenship_content").toggleClass("show");
        $(this).toggleClass("show");
        if ($(this).hasClass('show')) {
            $(".more").hide();
            $(".less").show();
        } else {
            $(".less").hide();
            $(".more").show();
        }
    });
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

<?php if (count($faqs) > 0) { ?>
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
        <?php
        $i = 0;
        foreach ($faqs as $r) {
            $i++;
            $q = 'q_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
            $res = 'r_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
            if (trim($r->$q) != '') {
                if ($i > 1)
                    echo ',';
                ?>

                {"@type": "Question",
                "name": " <?= htmlentities($r->$q) ?>",
                "acceptedAnswer": {"@type": "Answer","text": "<?= htmlentities($r->$res) ?>"}}
                <?php
            }
        }
        ?>
        ]}
    </script>
<?php } ?>

<script data-schema="Article" type="application/ld+json">
		{
		"@context":"http://schema.org",
		"@type":"Article",
		"mainEntityOfPage":{
			"@type":"WebPage",
			"@id":"<?= str_replace('/public/', '/', Request::url()); ?>"
			},
			"headline":"{{ htmlentities($page->getTitle())  }}",
			"articleBody":"{{ htmlentities(strip_tags(html_entity_decode($page->getContent())))  }}",
			"url":"<?= str_replace('/public/', '/', Request::url()); ?>",
			<?php if($page->media){ ?>
			"image":{
				"@type":"ImageObject",
				"url":"{{ Helper::media_url_full($page->media) }}",
				"width":1200,
				"height":640
				},
			<?php } ?>
			"articleSection":"{{ trans('front.TurkishCitizenship') }}",
			"datePublished":"<?= date(DATE_ISO8601, strtotime($page->created_at)) ?>",
			"dateModified":"<?= date(DATE_ISO8601, strtotime($page->update_date)) ?>",
			"author":{"@type":"Organization","name":"DamasTurk"},
			"publisher":{
				"@type":"Organization","name":"DamasTurk"
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
	{"@type":"ListItem","position":3,"name":"{{ trans('front.turkey investment') }}","item":"{{ route('front.investment') }}"}


	]
	}
</script>
@endsection