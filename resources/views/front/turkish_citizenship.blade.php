<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;

$right = ($style_lang == 'ar' ? 'right' : 'left');
//$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>

<link rel="preload" as="image" href="<?= asset("/img/topPhoto2.png"); ?>" />


<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/bootstrap-multiselect.css"); ?>
    <?= Html::style("resources/assets/css/myChart.css"); ?>
    <?= Html::style("resources/assets/css/faq.css"); ?>
    <?= Html::style("resources/assets/css/citizenship.css"); ?>

    <?= Html::style("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css"); ?>
    <?= Html::style("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css"); ?>


    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("resources/assets/css/citizenship-en.css"); ?>
    <?php } ?>

<?php } else { ?>

    <?= Html::style("css/citizenship.min.css"); ?>
	
    <?= Html::style("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css"); ?>
    <?= Html::style("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.theme.default.min.css"); ?>

    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("css/citizenship-en.min.css"); ?>
    <?php } ?>
    <?php // echo Html::style("/css/index" . (Helper::get_device() != 'full' ? '-mob' : '') . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?>
    <style>
    <?php //include(public_path() . "/css/index" . (Helper::get_device() != 'full' ? '-mob' : '') . ($style_lang == 'en' ? '-en' : '') . ".min.css");                                                                                ?>
        .collapse.in{display:block}
    </style>

<?php } ?>

<style>


    .top_animate_sec{
        float: left;
        width: 100%;
        height: auto;
        overflow: hidden;
        background-image: linear-gradient(to bottom,#d8e4e5 0,#bbfcff 100%);

        /*    float: left;
            width: 100%;
            height: 970px;
            overflow: hidden;
            background-image: url('/img/Background.jpg');
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: top;*/
        /*    background: rgb(0,25,45);
            background: linear-gradient(180deg, rgba(0,25,45,1) 0%, rgba(0,33,49,1) 4%, rgba(74,117,132,1) 46%, rgba(187,252,255,1) 100%);*/
    }
    .top_animate_sec .image_group,
    .top_animate_sec .container{
        height: auto;
        position: relative;
    }
    .top_animate_sec .image_group{
        float: left;
        width: 100%;
        margin-top: 150px;
    }
    .top_animate_sec .image_group h1{
        float: left;
        width: 100%;
        position: relative;
        color: #0a7474;
        font-size: 30px;
        text-align: center;
        line-height: 38px;
        margin: 0px;
    }
    .top_animate_sec .image_group h1 span{
        float: left;
        width: 100%;
        direction: rtl;
        opacity: 1;
        position: relative;
        /*    left: -500%;*/
    }
    .top_animate_sec .image_group h1 span a{
        color: #a32a3d;
    }
    .top_animate_sec .image_group h1 span a:hover{
        text-decoration: none;
    }
    .top_animate_sec .image_group h1 span.animate{
        opacity: 1;
        left: 0%;
        transition: all 1s;
    }
    .topPhoto_sec{
        float: left;
        width: 100%;
        text-align: center;
    }
    .topPhoto_sec img{
        width: 600px;
        height: auto;
    }

    @media (max-width: 500px){
        section.form {
            margin-bottom: 10px;
        }
        .col-md-10.offset-md-1{
            padding: 0px;
            overflow: hidden;
        }
        .top_animate_sec {
            background-size: 100% 63%;
            background-position: bottom;
            position: relative;
            margin-top: 110px;
            background-color: transparent;
            background-image: none;
        }
        .top_animate_sec .image_group h1 {
            font-size: 22px;
            line-height: 30px;
        }
        .top_animate_sec .image_group h1 span:nth-child(3),
        .top_animate_sec .image_group h1 span:nth-child(2),
        .top_animate_sec .image_group h1 span:nth-child(1) {
            transform: skew( 0deg, 0deg);
            letter-spacing: 0px;
            top: 0px;
        }
        .top_animate_sec .image_group h1 span:nth-child(1) {
            font-size: 18px;
        }
        .top_animate_sec .image_group h1 span:nth-child(2) {
            top: -1px;
        }
        .top_animate_sec .image_group {
            margin-top: 30px;
        }
        .topPhoto_sec img{
            width: 300px;
        }
    }

</style>


@endsection




@extends('front.layout', [
"page_title"        =>    $page->getSeoTitle(),
"page_description"  =>    $page->getSeoDescription(),
"page_keywords"     =>    null,
"og_image"          =>    ($page->media?Helper::media_url_full($page->media):null),
"amp_url"           =>    route("amp.front.turkish_citizenship"),
"page_index" => '',
"page_turkish_citeznship" => true
])



@section('main_content')


<div class="top_animate_sec citizenship_page">
    <div class="container">
        <div class="image_group">


            <h1 class="jazzira_font_bold">
                <span class=""><?= trans("front.Turkish citizenship heading top one"); ?></span>
                <span class=""><?= trans("front.Turkish citizenship heading top two"); ?></span>
                <span class=""><?= trans("front.Turkish citizenship heading top three"); ?></span>
            </h1>

            <div class="topPhoto_sec">
                <img width="500" height="500" src="<?= asset("/img/topPhoto2.png"); ?>" alt="damasturk turkish citizenship"/>
            </div>

<!--            <img class="passportB animate__animated" src="<?= asset("/img/passportB.png"); ?>" alt="damasturk"/>
            <img class="turk_flag animate__animated" src="<?= asset("/img/plane.png"); ?>" alt="damasturk"/>
            <img class="turkey_text animate__animated" src="<?= asset("/img/turkey-text.png"); ?>" alt="damasturk"/>
            <img class="cloud1 animate__animated" src="<?= asset("/img/cloud1.png"); ?>" alt="damasturk"/>
            <img class="cloud2 animate__animated" src="<?= asset("/img/cloud2.png"); ?>" alt="damasturk"/>
            <img class="cloud3 animate__animated" src="<?= asset("/img/cloud3.png"); ?>" alt="damasturk"/>
            <img class="cloud4 animate__animated" src="<?= asset("/img/cloud4.png"); ?>" alt="damasturk"/>-->
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



            <h2 class="main_title"><?= trans("front.Ways to obtain Turkish citizenship"); ?></h2>

            <div class="time_line_sec">

                <div class="section">
                    <div class="point bg_color1"></div>
<!--                    <div class="date num"> 2018 <strong>September</strong></div>-->
                    <div class="content">
                        <span class="number num bg_color1">1</span>

                        <div class="text_cont">
                            <h3>
                                <span><?= trans("front.Ways to obtain Turkish citizenship one title"); ?></span> 
                                <img width="25" height="25" class="icon" src="<?= asset("/img/home-icon.svg"); ?>" alt="damasturk"/>
                            </h3>
                            <p class="jazzira_font"><?= trans("front.Ways to obtain Turkish citizenship one text"); ?></p>
                        </div>

                    </div>
                </div>

                <div class="section">
                    <div class="point bg_color2"></div>
                    <div class="content">
                        <span class="number num bg_color2">2</span>

                        <div class="text_cont">
                            <h3>
                                <span><?= trans("front.Ways to obtain Turkish citizenship two title"); ?></span> 
                                <img width="25" height="25" class="icon" src="<?= asset("/img/dolar-2-icon.svg"); ?>" alt="damasturk"/>
<!--                                <svg width="30" height="30" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 256.4 282.4" style="enable-background:new 0 0 256.4 282.4;" xml:space="preserve"><style type="text/css">.st0{fill:none;stroke:#075D5D;stroke-width:19.7044;stroke-miterlimit:133.3333;}.st1{opacity:0.5;fill:none;stroke:#075D5D;stroke-width:19.7044;stroke-linecap:round;stroke-miterlimit:133.3333;enable-background:new ;}.st2{opacity:0.5;fill:none;stroke:#075D5D;stroke-width:14.2857;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:133.3333;}</style><path class="st0" d="M19.7,253.9c15.8,19,45.1,19,103.7,19h9.5c58.7,0,88,0,103.7-19 M19.7,253.9c-15.8-19-10.4-47.8,0.5-105.5c7.7-41,11.5-61.5,26.1-73.6 M19.7,253.9C19.7,253.9,19.7,253.9,19.7,253.9z M236.7,253.9c15.8-19,10.4-47.8-0.5-105.5c-7.7-41-11.5-61.5-26.1-73.6 M236.7,253.9L236.7,253.9z M210.1,74.8c-14.6-12.1-35.4-12.1-77.2-12.1h-9.5c-41.7,0-62.6,0-77.2,12.1 M210.1,74.8L210.1,74.8z M46.3,74.8L46.3,74.8z"/><path class="st1" d="M88.8,62.4V49.3c0-21.8,17.6-39.4,39.4-39.4s39.4,17.6,39.4,39.4v13.1"/><path class="st2" d="M128.2,110.6v14.3 M128.2,210.6v14.3 M153.2,139.2c-2.4-9.5-10.7-14.3-25-14.3c-21.4,0-25,14-25,21.4c0,29.6,50,14,50,42.9c0,7.5-3.6,21.4-25,21.4c-14.3,0-22.6-4.8-25-14.3"/></svg>-->
                            </h3>
                            <p class="jazzira_font"><?= trans("front.Ways to obtain Turkish citizenship two text"); ?></p>
                        </div>

                    </div>
                </div>

                <div class="section">
                    <div class="point bg_color3"></div>
                    <div class="content">
                        <span class="number num bg_color3">3</span>

                        <div class="text_cont">
                            <h3>
                                <span><?= trans("front.Ways to obtain Turkish citizenship three title"); ?></span> 
                                <img width="25" height="25" class="icon" src="<?= asset("/img/factory-icon.svg"); ?>" alt="damasturk"/>
                            </h3>
                            <p class="jazzira_font"><?= trans("front.Ways to obtain Turkish citizenship three text"); ?></p>
                        </div>

                    </div>
                </div>



                <?php /* <!--                <div class="section">
                  <div class="point bg_color4"></div>
                  <div class="date num"> 2019 <strong>June</strong></div>
                  <div class="content">
                  <span class="number num bg_color4">4</span>

                  <div class="text_cont">
                  <h3><span><?= trans("front.New Facilities"); ?></span> <img class="icon" src="<?= asset("/img/step-icon-4.svg"); ?>" alt="damasturk"/></h3>
                  <p class="jazzira_font"><?= trans("front.latest updates law 4"); ?></p>
                  <a download href="/resources/assets/pdf/D-104.pdf" class="more_btn bg_color4 inverse">
                  <span><?= trans("front.download"); ?></span>
                  <svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 13.2 15.1" xml:space="preserve"><g> <path class="st0" d="M13.2,13.7c-1.1,0-2.2,0-3.3,0c0-0.3,0-0.5,0-0.8c0,0,0.1-0.1,0.2-0.1c0.7,0,1.4,0,2,0c0.2,0,0.2,0,0.2-0.2 c0-1.3,0-2.7,0-4c0-1.1,0-2.2,0-3.4c0-0.2,0-0.2-0.2-0.2c-1.2,0-2.3,0-3.5,0c-0.3,0-0.3,0-0.3-0.3c0-1.2,0-2.3,0-3.5 c0-0.2,0-0.2-0.3-0.2c-1.8,0-3.6,0-5.4,0c-0.2,0-0.2,0-0.2,0.2c0,0.8,0,1.6,0,2.3c0,0.2,0,0.2-0.2,0.2c-0.2,0-0.4,0-0.5,0 c-0.1,0-0.1,0-0.1-0.1c0-1.1,0-2.3,0-3.4C1.5,0,1.5,0,1.6,0c0.3,0,0.5,0,0.8,0c2.1,0,4.2,0,6.3,0C8.9,0,9,0,9.1,0.1 c1.1,1.1,2.1,2.2,3.2,3.2c0.3,0.3,0.5,0.5,0.8,0.8c0.1,0.1,0.1,0.2,0.1,0.3c0,0.9,0,1.8,0,2.7c0,0.3,0,0.7,0,1c0,1.8,0,3.6,0,5.3 C13.2,13.6,13.2,13.6,13.2,13.7z M9.2,1.6c0,0,0,0.1,0,0.1c0,0.7,0,1.4,0,2C9.2,4,9.3,4,9.4,4c0.7,0,1.3,0,2,0c0.1,0,0.1,0,0.2,0 C10.8,3.2,10,2.4,9.2,1.6z"/> <path class="st0" d="M4,7.9c-1,0-1.9,0-2.9,0c-0.2,0-0.5,0-0.7,0C0.2,7.9,0,7.7,0,7.4C0,7,0,6.6,0,6.1c0-0.5,0-1,0-1.5 C0,4.2,0.2,4,0.6,4c2.3,0,4.6,0,6.9,0c0.3,0,0.6,0.2,0.6,0.6c0,0.9,0,1.9,0,2.8c0,0.3-0.2,0.5-0.5,0.5c-1.1,0-2.2,0-3.4,0 C4.1,7.9,4.1,7.9,4,7.9C4,7.9,4,7.9,4,7.9z M3.2,6C3.2,6,3.2,6,3.2,6c0,0.3,0,0.7,0,1c0,0.1,0.1,0.2,0.1,0.2c0.4,0,0.8,0,1.2-0.1 C5,7,5.2,6.7,5.3,6.2c0.1-0.5,0-1-0.5-1.2c-0.5-0.3-1-0.2-1.5-0.2C3.2,4.9,3.2,4.9,3.2,5C3.2,5.3,3.2,5.7,3.2,6z M1.7,6.4 C2,6.3,2.2,6.3,2.5,6.2c0.3-0.1,0.4-0.4,0.4-0.8c0-0.2-0.2-0.5-0.5-0.5c-0.3,0-0.7,0-1.1-0.1c-0.1,0-0.1,0-0.1,0.2c0,0.7,0,1.4,0,2 c0,0.1,0,0.1,0,0.2c0.1,0,0.2,0,0.3,0c0.1,0,0.2,0,0.2-0.2C1.7,6.8,1.7,6.6,1.7,6.4z M7.1,6.2c0-0.2,0-0.3,0-0.4 c-0.2,0-0.3,0-0.5,0c-0.4,0-0.4,0.1-0.4-0.4c0-0.2,0-0.2,0.2-0.2c0.2,0,0.5,0,0.7,0c0-0.1,0-0.2,0-0.2c0-0.1,0-0.2-0.2-0.2 c-0.3,0-0.6,0-0.9,0c-0.1,0-0.2,0-0.4,0c0,0.8,0,1.6,0,2.4c0.1,0,0.2,0,0.3,0c0.1,0,0.2,0,0.2-0.2c0-0.2,0-0.4,0-0.6 c0-0.1,0-0.2,0.2-0.2C6.6,6.2,6.8,6.2,7.1,6.2z"/> <path class="st0" d="M8.8,11.6c0.1,0,0.2,0,0.2,0c0.3,0,0.5,0,0.8,0c0.1,0,0.2,0,0.2,0.1c0,0.1,0,0.2,0,0.3c-0.5,0.6-1,1.2-1.4,1.8 c-0.3,0.3-0.5,0.7-0.8,1c-0.3,0.3-0.5,0.3-0.7,0C6.2,13.9,5.5,13,4.7,12c-0.1-0.1-0.1-0.2-0.1-0.3c0-0.1,0.2-0.1,0.3-0.1 c0.2,0,0.5,0,0.7,0c0.2,0,0.2,0,0.2-0.2c0-0.8,0-1.6,0-2.4c0-0.3,0-0.3,0.3-0.3c0.8,0,1.6,0,2.4,0c0.2,0,0.2,0,0.2,0.2 c0,0.8,0,1.6,0,2.5C8.8,11.5,8.8,11.5,8.8,11.6z"/> <path class="st0" d="M1.5,13.7c0-0.1,0-0.1,0-0.2c0-1.7,0-3.4,0-5c0-0.2,0-0.2,0.2-0.2c0.2,0,0.3,0,0.5,0c0.1,0,0.2,0,0.2,0.2 c0,0.2,0,0.5,0,0.7c0,1.1,0,2.3,0,3.4c0,0.3,0,0.3,0.2,0.3c0.7,0,1.3,0,2,0c0.1,0,0.1,0,0.2,0c0,0.3,0,0.6,0,0.9 C3.7,13.7,2.6,13.7,1.5,13.7z"/> <path class="st0" d="M3.8,5.2c0.3-0.1,0.5,0,0.7,0.1c0.3,0.2,0.4,0.6,0.3,0.9C4.6,6.6,4.3,6.8,3.9,6.8c0,0-0.1-0.1-0.1-0.1 C3.8,6.2,3.8,5.7,3.8,5.2z"/> <path class="st0" d="M1.7,5.6C1.7,5.5,1.7,5.5,1.7,5.6c0-0.2-0.1-0.3,0.1-0.4c0.1-0.1,0.4,0,0.5,0.1c0.1,0.1,0.1,0.2,0.1,0.4 C2.3,5.9,2,6,1.8,5.9c0,0-0.1-0.1-0.1-0.1C1.7,5.7,1.7,5.6,1.7,5.6z"/> </g> </svg>
                  </a>
                  </div>

                  </div>
                  </div>--> */ ?>

                <div class="bar"></div>
            </div>






            <div class="col-md-12">


                <div class="citizenship_steps_sec">
                    <h2 class="main_title jazzira_font_bold"><?= trans("front.Steps to obtain citizenship"); ?></h2>

                    <img src="<?= asset("/img/citizenship-steps-sec-" . ($current_lang == 'pe' ? 'fa' : $current_lang) . "-2.svg"); ?>" alt="damasturk"/>

                    <div class="text">
                        <span class="left">
                            <?= trans("front.To obtain"); ?><br><strong><?= trans("front.Turkish citizenship"); ?></strong>
                        </span>

                        <img width="150" height="200" src="<?= asset("/img/passportS-2.png"); ?>" alt="damasturk"/>

                        <span class="right">
                            <strong class="num">6-3</strong><br><?= trans("front.Months"); ?>
                        </span>
                    </div>

                    <p><span>*</span><?= trans("front.Papers must be brought from the investor's country"); ?></p>

                </div>



                <div class="citizenship_steps_sec passport_strong shadow_type">

                    <img class="earth_icon" width="200" height="200" src="<?= asset("/img/earth.svg"); ?>" alt="damasturk"/>
<!--                    <img class="point_flag" src="<?= asset("/img/point-turkey-flag.svg"); ?>" alt="damasturk"/>
                    <img class="passport" src="<?= asset("/img/Passport2.png"); ?>" alt="damasturk"/>-->

                    <h2><?= trans("front.Strength of the Turkish passport title"); ?></h2>

                    <ul class="jazzira_font">
                        <li><?= trans("front.Strength of the Turkish passport text one new"); ?></li>
                        <li><?= trans("front.Strength of the Turkish passport text two new"); ?></li>
                        <li><?= trans("front.Strength of the Turkish passport text three new"); ?></li>
<!--                        <li><?= trans("front.Strength of the Turkish passport text four"); ?></li>
                        <li><?= trans("front.Strength of the Turkish passport text five"); ?></li>
                        <li><?= trans("front.Strength of the Turkish passport text six"); ?></li>
                        <li><?= trans("front.Strength of the Turkish passport text seven"); ?></li>-->
                    </ul>

<!--                    <div class="icons">
                        <h3><?= trans("front.The most prominent countries that do not need a visa"); ?></h3>
                        <div class="sub_sec">
                            <img width="131" height="150" src="<?= asset("/img/Koria-Flag.svg"); ?>" alt="<?= trans("front.South Korea"); ?>"/>
                            <h4><?= trans("front.South Korea"); ?></h4>
                        </div>
                        <div class="sub_sec">
                            <img width="131" height="150" src="<?= asset("/img/Singapore-Flag.svg"); ?>" alt="<?= trans("front.Singapore"); ?>"/>
                            <h4><?= trans("front.Singapore"); ?></h4>
                        </div>
                        <div class="sub_sec">
                            <img width="131" height="150" src="<?= asset("/img/Japan-Flag.svg"); ?>" alt="<?= trans("front.Japan"); ?>"/>
                            <h4><?= trans("front.Japan"); ?></h4>
                        </div>
                        <div class="sub_sec">
                            <img width="131" height="150" src="<?= asset("/img/Russia-Flag.svg"); ?>" alt="<?= trans("front.Russia"); ?>"/>
                            <h4><?= trans("front.Russia"); ?></h4>
                        </div>
                    </div>-->




<!--                        <img src="<?= asset("/img/passport-strong.png"); ?>" alt="damasturk"/>-->
                </div>



            </div>




            <!-- Out Link Section -->
            <!--            <div class="col-md-12">
                            <div class="row">
                                <div class="space_link legal_out_link">
                                    <div class="content">
                                        <p><?= trans("front.Legal Affairs"); ?></p>
                                        <img class="icon" src="<?= asset("/img/out-link-button1.svg"); ?>" alt="damasturk"/>
                                    </div>
                                </div>
                            </div>
                        </div> -->
            <!-- Out Link Section -->









            <!-- turkish citizenship content-->


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



            <!-- turkish citizenship content -->



            <!-- Video Section -->

            <?php
            if ($current_lang == "ar") {
                $videoId = "-3cOVNnrO4I";
                ?>
                <?php
            } elseif ($current_lang == 'en') {
                $videoId = "";
                ?>
                <?php
            } elseif ($current_lang == 'fr') {
                $videoId = "";
                ?>
                <?php
            } elseif ($current_lang == "pe") {
                $videoId = "";
                ?>
                <?php
            } else {
                $videoId = "";
                ?>
            <?php } ?>


            <?php if ($videoId != '') { ?>
                <div class="col-md-12">
                    <!--                    <div class="video_content">
                                            <iframe width="100%" height="415" src="https://www.youtube.com/embed/<?= $videoId; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>-->

                    <div class="int_content video_content">
                        <section class="youtube-video" id="section_images_videos">
                            <a data-fancybox="video" class="video_fancybox" href="https://www.youtube.com/embed/<?= $videoId; ?>">
                                <svg class="faa-ring animated" height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                                <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/<?= $videoId; ?>/maxresdefault.jpg">
                            </a>
                        </section>
                    </div>
                </div>
            <?php } ?>
            <!-- Video Section -->




            <!-- Start Projects Section -->
                 <div class="col-md-12">

                <?php
//$post_projects = $post->projects; آخر خمسة مشاريع عقارات اسطنبول
                //$arr_ids = Helper::query("Fotterproject", "all")->lists('project_id')->toArray();
                //$last_prjs = \App\Models\Project::where('published', '1')->where('sold', '!=', '100')->orderBy('id', 'desc')->limit(5)->get();
                $last_prjs = \App\Models\Project::where('published', '1')->whereIn('name_en', ['DS389','DS469','DS589','DS780','DS296'])->orderBy('id', 'desc')->limit(5)->get();
                if (count($last_prjs)) {
                    ?>
                                <!--                <h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.projects"); ?></h2>-->
                    <h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.Home Slider Text One"); ?></h2>


                    <div class="wrapper sec">

                        <div class="slider" <?php if ($current_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>

                            <div class="slider__wrap swiper-wrapper">


                                <?php $t = 0; ?>
                                @foreach($last_prjs as $prj)
                                @include("front.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
                                @endforeach


                            </div>

                            <div class="slider__controls">

                                <div class="slider__pagination"></div>

                                <div class="slider__button-next"></div>
                                <div class="slider__button-prev"></div>
                            </div>

                            <a href="{{ route('front.search', ['property-for-sale', 'turkey']) }}" class="more shadow_type" title="<?= trans("front.Property for sale in Turkey"); ?>"><?= trans("front.Property for sale in Turkey"); ?></a>

                        </div>

                    </div>
                <?php } ?>
            </div>
            <!-- End Projects Section -->




            <?php //if (Helper::get_device() == 'mob') { ?>
            <section class="form shadow_type mob_form">
                @include("front.partials.call_us_fixed")
            </section>
            <?php //} ?>



            <!-- Out Link Section -->
            <!--            <div class="col-md-12">
                            <div class="row">
                                <div class="space_link investment_out_link">
                                    <div class="content">
                                        <p><?= trans("front.InvestmentTurkey"); ?></p>
                                        <img class="icon" src="<?= asset("/img/out-link-button1.svg"); ?>" alt="damasturk"/>
                                    </div>
                                </div>
                            </div>
                        </div> -->
            <!-- Out Link Section -->




            <!-- Slider Pages links -->
            @include("front.partials.slider_pages_links")
            <!-- Slider Pages links -->





            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        @include("front.partials.statistics_most", [])
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        @include("front.partials.share_links", [])
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        @include("front.partials.subscribe_youtube", [])
                    </div>
                </div>
            </div>




            <?php
            $secv = Helper::query("Sectionvideo", "find", ["id" => 1]);
            $videos = $secv->videos()->where("lang", $current_lang)->limit(5)->orderBy('id', 'desc')->get();
            ?>


            <?php if (count($videos) > 0) { ?>
                <div class="col-md-12">
                    <div class="int_content videos_slider">

                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.Turkish nationality series"); ?></h2>


                        <div class="wrapper sec">

                            <div class="slider video_slider"  <?php if ($current_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>

                                <div class="slider__wrap swiper-wrapper">


                                    @include("front.partials.videos", ['videos'=>$videos])


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
            <?php } ?>






            <div class="int_content faqContent shadow_type">
                <img class="icon" width="140" height="120" src="<?= asset("/img/faqIcon.png"); ?>" alt="damasturk"/>

                <h2 class="jazzira_font_bold faq_title"><?= trans("front.FAQ about"); ?> <?= trans("front.TurkishCitizenship"); ?></h2>

                <section class="faq-section sec">

                    <!-- ***** FAQ Start ***** -->
                    <div class="faq sec" id="accordion">


                        <?php
                        $faqs = DB::select("select * from dms_faq where faq_post=?  order by id asc LIMIT 6", [1]);

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


                <?php /*
                  <!--                            <ul class="jazzira_font">
                  <?php
                  $faqs = DB::select("select * from dms_faq where faq_post=?  order by id asc LIMIT 4", [1]);


                  $i = 0;
                  foreach ($faqs as $r) {
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
                  </ul>-->

                  <!--                            <div class="col-md-12">
                  <a class="more green" href="<?= route("front.faq_show", ["turkish-citizenship"]) ?>"><?= trans("front.view more"); ?></a>
                  </div>-->
                 */ ?>

            </div>






            <div class="col-md-12">
                @include("front.partials.testimonials_slider", [])
            </div>









            @include("front.partials.top_visited_posts", ['cat_id'=>8])








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
    <?= Html::script("resources/assets/js/myChart.js") ?>
    <?= Html::script("resources/assets/js/bootstrap-multiselect.js") ?>
    <!--<?= Html::script("resources/assets/js/swiper.min.js"); ?>-->
    <?= Html::script("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"); ?>
<?php } else { ?>
    <?= Html::script("js/myChart.min.js") ?>
    <?= Html::script("js/bootstrap-multiselect.min.js") ?>
    <!--<?= Html::script("js/swiper.min.js"); ?>-->
    <?= Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"); ?>
    <?= Html::script("https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.min.js"); ?>
<?php } ?>



<script>

<?php
$json3 = Helper::ajax_statics('', 'top_country', 0, 0);
$json4 = Helper::ajax_statics('', 'top_city', 0, 0);
?>

    display_most_nat_data(<?= json_encode($json3) ?>);
    display_most_city_data(<?= json_encode($json4) ?>);

    $(document).ready(function () {
        var decisionPhotoH = $('.decision-photo').height() - 20;
        $(".decision-arabic").css("max-height", decisionPhotoH);
        /* Dropdown Menu Selection*/
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
        /*$(".top_animate_sec").height(windowH);*/
        $('.main_menu .links>li>a.turkish_citizenship').addClass("active");
        /*
         //        setTimeout(function () {
         //            $('.passportB').addClass("animate__fadeInUp");
         //            $('.cloud1').addClass("animate__zoomIn");
         //            $('.cloud2').addClass("animate__zoomIn");
         //            $('.cloud3').addClass("animate__zoomIn");
         //            $('.cloud4').addClass("animate__zoomIn");
         //            $('.turkey_text').addClass("animate__fadeInTopLeft");
         //        }, 500);
         //
         //        setTimeout(function () {
         //            $('.top_animate_sec .image_group h1 span:nth-child(1)').addClass("animate");
         //        }, 800);
         //        setTimeout(function () {
         //            $('.top_animate_sec .image_group h1 span:nth-child(2)').addClass("animate");
         //            $('.turk_flag').addClass("animate__fadeInLeft");
         //        }, 1000);
         //        setTimeout(function () {
         //            $('.top_animate_sec .image_group h1 span:nth-child(3)').addClass("animate");
         //        }, 1200);
         
         
         
         //        var cloud1 = $(".cloud1");
         //        var cloud2 = $(".cloud2");
         //        var cloud3 = $(".cloud3");
         //        var cloud4 = $(".cloud4");
         //        var turkeyText = $(".turkey_text");
         //        var turkFlag = $(".turk_flag");
         //        var passportB = $(".passportB");
         //        var H1 = $(".top_animate_sec .image_group h1");
         //        $("body").mousemove(function (event) {
         //            var x = event.pageX;
         //            var y = event.pageY;
         //            cloud1.css({'margin-top': y / 50, 'margin-left': x / 50}); // better use CSS
         //            cloud2.css({'margin-top': y / 40, 'margin-left': x / 40}); // better use CSS
         //            cloud3.css({'margin-top': y / 30, 'margin-left': x / 30}); // better use CSS
         //            cloud4.css({'margin-top': y / 30, 'margin-left': x / 30}); // better use CSS
         //            turkeyText.css({'margin-top': y / 60, 'margin-left': x / 60}); // better use CSS
         //            turkFlag.css({'margin-top': y / 80, 'margin-left': x / 80}); // better use CSS
         //            passportB.css({'margin-top': y / 100, 'margin-left': x / 100}); // better use CSS
         //            H1.css({'margin-top': y / 70, 'margin-left': x / 70}); // better use CSS
         //        });
         */

    });


    /*
     
     document.addEventListener('touchstart', handleTouchStart, false);
     document.addEventListener('touchmove', handleTouchMove, false);
     
     var xDown = null;
     var yDown = null;
     
     function getTouches(evt) {
     return evt.touches || // browser API
     evt.originalEvent.touches; // jQuery
     }
     
     function handleTouchStart(evt) {
     const firstTouch = getTouches(evt)[0];
     xDown = firstTouch.clientX;
     yDown = firstTouch.clientY;
     }
     ;
     
     function handleTouchMove(evt) {
     if (!xDown || !yDown) {
     return;
     }
     
     var xUp = evt.touches[0].clientX;
     var yUp = evt.touches[0].clientY;
     
     var xDiff = xDown - xUp;
     var yDiff = yDown - yUp;
     
     if (Math.abs(xDiff) > Math.abs(yDiff)) {
     if (xDiff > 0) {
     window.location.href = "/";
     } else {
     window.location.href = "/property-for-sale/turkey";
     }
     } else {
     if (yDiff > 0) {
     
     } else {
     
     }
     }
     xDown = null;
     yDown = null;
     }
     ;
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



    var owl = $('.owl-carousel');
    owl.owlCarousel({
        items: 1,
        // items change number for slider display on desktop

        loop: true,
        lazyLoad: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true
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


<?php if ($videoId != '') { ?>
    <script type="application/ld+json">{
        "@context": "http://schema.org",
        "@type": "VideoObject",
        "name": "كيفية الحصول على الجنسية التركية ومميزاتها وقوة الجواز التركي | damasturk",
        "description": "كيفية الحصول على الجنسية التركية وحلم امتلاك جواز السفر التركي، كافة التفاصيل وأكثر وبآخر تحديثات قانون التجنيس عبر التملك العقاري ستجدها هنا. https://damas.net/turkish-citizenship  للتواصل المباشر عبر الوتساب على الرابط التالي: https://damas.net/whats",
        "thumbnailUrl": "https://i.ytimg.com/vi/Yw3Qbur6rhk/default.jpg",
        "uploadDate": "2022-02-10T06:48:52Z",
        "duration": "PT32S",
        "embedUrl": "https://www.youtube.com/embed/Yw3Qbur6rhk",
        "interactionCount": "1677"
        }</script>
<?php } ?>

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
    <?php if ($page->media) { ?>
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
    {"@type":"ListItem","position":3,"name":"{{ trans('front.turkish citizenship') }}","item":"{{ route('front.turkish_citizenship') }}"}


    ]
    }
</script>
@endsection