<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr']) ? 'en' : 'ar';

//$photoCard = $post->photoCard;
$infos = Helper::get_params();
$branchs = Helper::query("Branch", "orderBy", ["filed" => "id", "value" => "ASC"])->get();
$is_mobile = Helper::is_mobile();
$arr_prices = [
    "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
];
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
?>

@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("/resources/assets/css/aos.css"); ?>
    <?= Html::style("/resources/assets/css/about.css"); ?>


    <style>
        body {background-color: #c5cfd6;background-image: url(/img/pattern-body-aboutPage.svg);}.header.scrolling {background-color: #c5cfd6;background-image: url(/img/pattern-body-aboutPage.svg);}.full_sections {display: block;}.int_content {min-height: 140px;}.top_title{text-align: center;margin: 30px 0px;font-size: 30px;color: #058687;opacity: 0;min-height: 36px;}.top_title.animate__zoomIn{opacity: 1;}.images_content{width: 100%;height: 700px;position: relative;padding-top: 110px;overflow: hidden;}.images_content .about_bg{width: 100%;height: 450px;position: absolute;top: 110px;left: 0px;}.images_content .about_bg img{width: 100%;height: 100%;object-fit: cover;opacity: 0;}.images_content .about_bg img.show{opacity: 1;transition: all 1.5s;}.images_content .container{height: 100%;position: relative;}.images_content .image_parts{width: 100%;height: 100%;position: relative;}.images_content .image_parts .part{float: right;width: 25%;padding: 3px;position: relative;}.images_content .image_parts .part:nth-child(1), .images_content .image_parts .part:nth-child(3){top: -630px;opacity: 0;}.images_content .image_parts .part.show:nth-child(1), .images_content .image_parts .part.show:nth-child(3){top: -30px;opacity: 1;transition: all 1s;}.images_content .image_parts .part:nth-child(2), .images_content .image_parts .part:nth-child(4){top: 400px;opacity: 0;}.images_content .image_parts .part.show:nth-child(2), .images_content .image_parts .part.show:nth-child(4){top: -86px;opacity: 1;transition: all 1s;}.images_content .image_parts .part img{float: right;width: 100%;-webkit-box-shadow: 5px 5px 16px -4px rgba(0,0,0,0.49);box-shadow: 5px 5px 16px -4px rgba(0,0,0,0.49);border-radius: 16px;}
    </style>

    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("/resources/assets/css/about-en.css"); ?>
    <?php } ?>

<?php } else { ?>

    <style>
        body {background-color: #c5cfd6;background-image: url(/img/pattern-body-aboutPage.svg);}.header.scrolling {background-color: #c5cfd6;background-image: url(/img/pattern-body-aboutPage.svg);}.full_sections {display: block;}.int_content {min-height: 140px;}.top_title{text-align: center;margin: 30px 0px;font-size: 30px;color: #058687;opacity: 0;min-height: 36px;}.top_title.animate__zoomIn{opacity: 1;}.images_content{width: 100%;height: 700px;position: relative;padding-top: 110px;overflow: hidden;}.images_content .about_bg{width: 100%;height: 450px;position: absolute;top: 110px;left: 0px;}.images_content .about_bg img{width: 100%;height: 100%;object-fit: cover;opacity: 0;}.images_content .about_bg img.show{opacity: 1;transition: all 1.5s;}.images_content .container{height: 100%;position: relative;}.images_content .image_parts{width: 100%;height: 100%;position: relative;}.images_content .image_parts .part{float: right;width: 25%;padding: 3px;position: relative;}.images_content .image_parts .part:nth-child(1), .images_content .image_parts .part:nth-child(3){top: -630px;opacity: 0;}.images_content .image_parts .part.show:nth-child(1), .images_content .image_parts .part.show:nth-child(3){top: -30px;opacity: 1;transition: all 1s;}.images_content .image_parts .part:nth-child(2), .images_content .image_parts .part:nth-child(4){top: 400px;opacity: 0;}.images_content .image_parts .part.show:nth-child(2), .images_content .image_parts .part.show:nth-child(4){top: -86px;opacity: 1;transition: all 1s;}.images_content .image_parts .part img{float: right;width: 100%;-webkit-box-shadow: 5px 5px 16px -4px rgba(0,0,0,0.49);box-shadow: 5px 5px 16px -4px rgba(0,0,0,0.49);border-radius: 16px;}.email svg{margin-top:4px}
    </style>

    <style><?php include(public_path() . "/css/about.min.css"); ?></style>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("css/about-en.min.css"); ?>
    <?php } ?>
<?php } ?>



@endsection

<?php
$page_title = $row->getSeoTitle();
$media = $row->media;
?>
@extends('front.layout', [
"page_title" => $page_title ? $page_title : $row->getTitle(),
"page_description"  =>    $row->getSeoDescription(),
"page_keywords"     =>    $row->getSeoKeywords(),
"og_image"          =>    Helper::media_mob($media),
"amp_url"  =>  route("amp.front.about")
])
@section('main_content')




<div class="full_sections int_page">
    <h1 class="top_title animate__animated jazzira_font_bold"><?= $row->getTitle(); ?></h1>

    <div class="images_content">

        <div class="container">

                <div class="image_parts">
                    <div class="part one"><img src="<?= asset("/img/about__1.png"); ?>" alt="damasturk"/></div>
                    <div class="part two"><img src="<?= asset("/img/about__2.png"); ?>" alt="damasturk"/></div>
                    <div class="part three"><img src="<?= asset("/img/about__3.png"); ?>" alt="damasturk"/></div>
                    <div class="part four"><img src="<?= asset("/img/about__4.png"); ?>" alt="damasturk"/></div>
                </div>



        </div>
    </div>
</div>


<div class="col-md-10 offset-md-1">
    <div class="full_sections content_section_about">

        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div class="fixed_sec">


                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>


                <section class="form fast_search search_filter shadow_type">
                    <p class="top_title jazzira_font_bold"><?= trans("front.Look for information"); ?></p>

                    <form action="<?= route("front.searchpage"); ?>">
                        <div class="form-group">
                            <input class="form-control" name="s" placeholder="<?= trans("front.whatAreYouLookingFor"); ?>" value="<?= Input::get("s"); ?>" />
                            <button class="search_btn"><i class="fa fa-search"></i></button>
                        </div>
                    </form>

                </section>

            </div>
        </div>
        <!-- End Fixed Section -->



        <!-- Start Left Section -->
        <div class="left_sec"> 


            <div class="int_content bg-w shadow_type text_sec" data-aos="fade-up">
<!--                <h2 class="sub_title jazzira_font_bold"><?= trans("front.about damas"); ?></h2>-->
                <div class="text_cont sec jazzira_font">
                    <?= html_entity_decode($row->getContent()); ?>
                </div>
            </div>
            <div class="int_content text_sec contact_sec branches_sec" data-aos="fade-up" style="margin-bottom: 15px;">

                @foreach($branchs as $branch)
                <div class="branch">
                    <div class="contact_links num bg-w shadow_type">
                        <h3 class="jazzira_font_bold"><?= trans("front.office1"); ?></h3>
                        <?php
                        $phone = str_replace(' ', '', $branch->mobile);
                        $phone_href = str_replace([' ', '+'], ['', '00'], $branch->mobile);
                        ?>

                        <a class="telephone mobile" href="tel:<?= $phone_href; ?>">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.8 24.8">
                                <path class="st0" d="M3.4,24.8H12c1.7,0,3-1.4,3-3V3.5c0-1.7-1.4-3-3-3H3.4c-1.7,0-3,1.4-3,3v18.3C0.4,23.4,1.7,24.8,3.4,24.8z M7.7,22.8c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4s1.4,0.6,1.4,1.4C9.1,22.2,8.5,22.8,7.7,22.8z M1.7,4.5h11.9v14.1H1.7V4.5z "/>
                            </svg>

                            <?= $phone; ?>
                        </a>

                        <a class="email" href="mailto:<?= ($branch->email ? $branch->email : $infos->emails); ?>">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 18.9" xml:space="preserve"><g> <path class="st0" d="M21.9,18.9c0.5,0,1-0.2,1.4-0.5l-6.8-6.8c-0.2,0.1-0.3,0.2-0.5,0.3c-0.5,0.4-0.9,0.7-1.2,0.9 c-0.3,0.2-0.7,0.4-1.3,0.6c-0.5,0.2-1,0.3-1.5,0.3h0c-0.5,0-0.9-0.1-1.5-0.3c-0.5-0.2-1-0.4-1.3-0.6c-0.3-0.2-0.7-0.5-1.2-0.9 c-0.1-0.1-0.3-0.2-0.5-0.3l-6.8,6.8c0.4,0.4,0.9,0.5,1.4,0.5H21.9z M21.9,18.9"/> <path class="st0" d="M1.4,7.3C0.8,6.9,0.4,6.5,0,6.1v10.4l6-6C4.8,9.6,3.3,8.5,1.4,7.3L1.4,7.3z M1.4,7.3"/> <path class="st0" d="M22.7,7.3c-1.8,1.2-3.4,2.3-4.7,3.2l6,6V6.1C23.7,6.5,23.2,6.9,22.7,7.3L22.7,7.3z M22.7,7.3"/> <path class="st0" d="M21.9,0H2.1C1.5,0,0.9,0.2,0.6,0.7C0.2,1.2,0,1.7,0,2.4C0,3,0.2,3.6,0.7,4.3c0.5,0.7,1,1.2,1.6,1.5 C2.6,6,3.5,6.7,5.1,7.7c0.8,0.6,1.5,1.1,2.2,1.5c0.5,0.4,1,0.7,1.4,0.9c0,0,0.1,0.1,0.2,0.1c0.1,0.1,0.2,0.2,0.4,0.3 c0.3,0.2,0.5,0.4,0.7,0.5c0.2,0.1,0.4,0.3,0.7,0.4c0.3,0.2,0.5,0.3,0.8,0.4C11.6,12,11.8,12,12,12h0c0.2,0,0.4,0,0.7-0.1 c0.2-0.1,0.5-0.2,0.8-0.4c0.3-0.2,0.5-0.3,0.7-0.4c0.2-0.1,0.4-0.3,0.7-0.5c0.1-0.1,0.3-0.2,0.4-0.3c0.1-0.1,0.2-0.1,0.2-0.1 c0.3-0.2,0.7-0.5,1.4-0.9c1.1-0.8,2.7-1.9,4.9-3.4c0.7-0.5,1.2-1,1.6-1.6c0.4-0.6,0.7-1.3,0.7-2c0-0.6-0.2-1.1-0.6-1.5 C23,0.2,22.5,0,21.9,0L21.9,0z M21.9,0"/> </g> </svg>                        
                            <?= nl2br($branch->email ? $branch->email : $infos->emails); ?>
                        </a>
                        

                        <a class="location" href="https://goo.gl/maps/W4B2D3ii3utMFsUk7" target="_blank">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 27.2 27.1" style="enable-background:new 0 0 27.2 27.1;" xml:space="preserve"><style type="text/css">.st0{fill:#4D4D4D}</style><g> <path class="st0" d="M5.5,9.1C5.5,9.1,5.5,9.1,5.5,9.1c0,0.1,0.1,0.3,0.1,0.4c0,0.2,0.1,0.3,0.1,0.5c0.1,0.2,0.1,0.4,0.2,0.6 c0.1,0.2,0.1,0.3,0.2,0.5c0,0.1,0.1,0.2,0.1,0.3c0,0.1,0.1,0.2,0.1,0.3c0.1,0.1,0.1,0.3,0.2,0.4c0.1,0.2,0.2,0.3,0.2,0.5 C6.9,12.8,7,13,7.1,13.2c0.2,0.3,0.4,0.7,0.5,1c0.1,0.2,0.3,0.5,0.4,0.7c0.2,0.4,0.4,0.8,0.7,1.1c0.3,0.4,0.5,0.9,0.8,1.3 c0.3,0.4,0.5,0.8,0.8,1.2c0.3,0.5,0.6,0.9,0.9,1.4c0.2,0.3,0.5,0.7,0.7,1c0.3,0.4,0.6,0.8,0.9,1.2c0.3,0.3,0.5,0.7,0.8,1 c0.1,0.1,0.1,0.1,0.1,0c0.2-0.3,0.5-0.7,0.7-1c0.3-0.4,0.6-0.8,0.9-1.3c0.3-0.4,0.6-0.8,0.8-1.2c0.3-0.5,0.6-0.9,0.9-1.4 c0.2-0.4,0.5-0.7,0.7-1.1c0.2-0.3,0.4-0.7,0.6-1c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.2-0.4,0.3-0.6 c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.2-0.3,0.3-0.5c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.1,0.1-0.3,0.2-0.4 c0.1-0.2,0.1-0.3,0.2-0.5c0-0.1,0.1-0.2,0.1-0.4c0.1-0.2,0.1-0.3,0.2-0.5c0-0.1,0-0.1,0.1-0.2c0-0.2,0.1-0.3,0.1-0.5 c0-0.2,0.1-0.3,0.1-0.5c0-0.2,0-0.5,0.1-0.7c0-0.1,0-0.1,0-0.2c0-0.2,0-0.4,0-0.5c0-0.1,0-0.1,0-0.2c0-0.2-0.1-0.4-0.1-0.6 c0-0.1,0-0.2-0.1-0.4c0-0.1-0.1-0.2-0.1-0.4c0-0.1,0-0.2-0.1-0.3c0-0.1-0.1-0.2-0.1-0.4c0-0.1-0.1-0.2-0.1-0.3 C21.1,4.9,21,4.7,21,4.6c-0.1-0.2-0.2-0.4-0.3-0.6c-0.1-0.2-0.3-0.4-0.4-0.6c-0.2-0.3-0.4-0.5-0.6-0.8c-0.3-0.3-0.6-0.6-1-0.9 c-0.3-0.2-0.5-0.4-0.8-0.5c-0.2-0.1-0.4-0.2-0.7-0.4c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2-0.1-0.3-0.1 c-0.2-0.1-0.3-0.1-0.5-0.1c-0.1,0-0.2-0.1-0.4-0.1c-0.2-0.1-0.5-0.1-0.7-0.1c-0.1,0-0.2,0-0.3,0c0,0,0,0-0.1,0c-0.4,0-0.9,0-1.3,0 c0,0,0,0-0.1,0c-0.2,0-0.4,0-0.6,0.1c-0.1,0-0.3,0-0.4,0.1c-0.1,0-0.2,0-0.3,0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.1,0-0.1,0-0.2,0.1 c-0.1,0-0.2,0.1-0.4,0.1c-0.2,0.1-0.3,0.1-0.5,0.2C10.1,0.8,9.9,0.9,9.7,1C9.6,1.1,9.4,1.2,9.2,1.3C8.9,1.5,8.6,1.7,8.3,2 C7.9,2.4,7.4,2.8,7.1,3.3C6.8,3.6,6.6,4,6.4,4.4C6.2,4.7,6.1,4.9,6,5.1C6,5.2,6,5.3,6,5.3c0,0.1-0.1,0.2-0.1,0.4 c0,0.2-0.1,0.3-0.1,0.5c0,0.2-0.1,0.4-0.1,0.5c0,0.2-0.1,0.4-0.1,0.6c0,0.2,0,0.4,0,0.7c0,0.1,0,0.2,0,0.3C5.5,8.5,5.5,8.8,5.5,9.1 z M13.6,5.5c1.5,0,2.7,1.2,2.7,2.7c0,1.5-1.2,2.7-2.7,2.7c-1.5,0-2.7-1.2-2.7-2.7C10.9,6.7,12.1,5.5,13.6,5.5z"/> <path class="st0" d="M27.2,19.9C27.2,19.9,27.2,19.9,27.2,19.9c0-0.2-0.1-0.3-0.1-0.4c-0.1-0.2-0.1-0.4-0.2-0.6 c-0.1-0.2-0.1-0.3-0.2-0.5c-0.2-0.3-0.4-0.6-0.6-0.8c-0.4-0.5-0.9-0.9-1.4-1.2c-0.2-0.1-0.4-0.3-0.6-0.4c-0.2-0.1-0.4-0.2-0.5-0.3 c-0.1-0.1-0.2-0.1-0.3-0.1c-0.2-0.1-0.4-0.2-0.6-0.2c-0.1-0.1-0.3-0.1-0.4-0.2c0,0-0.1,0.1-0.1,0.1c-0.1,0.2-0.2,0.3-0.2,0.5 c-0.1,0.2-0.2,0.3-0.3,0.5c-0.1,0.2-0.3,0.5-0.4,0.7c-0.1,0.2-0.2,0.4-0.4,0.6c0,0.1,0,0.1,0,0.1c0.1,0.1,0.3,0.1,0.4,0.2 c0.1,0,0.2,0.1,0.3,0.1c0.1,0.1,0.3,0.1,0.4,0.2c0.2,0.1,0.3,0.1,0.5,0.2c0.2,0.1,0.4,0.2,0.6,0.4c0.3,0.2,0.6,0.5,0.9,0.8 c0.2,0.2,0.4,0.5,0.4,0.8c0,0.2,0,0.3,0,0.5c-0.1,0.2-0.2,0.4-0.3,0.5c-0.2,0.2-0.4,0.5-0.6,0.6c-0.3,0.2-0.5,0.4-0.8,0.6 c-0.2,0.1-0.3,0.2-0.5,0.3c-0.2,0.1-0.3,0.2-0.5,0.2c-0.2,0.1-0.4,0.2-0.6,0.2c-0.2,0.1-0.3,0.1-0.5,0.2c-0.1,0-0.3,0.1-0.4,0.1 c-0.1,0-0.3,0.1-0.4,0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.1,0-0.2,0-0.3,0.1c-0.2,0-0.4,0.1-0.6,0.1c-0.2,0-0.4,0.1-0.6,0.1 c-0.1,0-0.1,0-0.2,0c-0.1,0-0.2,0-0.3,0.1c-0.2,0-0.4,0.1-0.6,0.1c-0.2,0-0.5,0.1-0.7,0.1c0,0-0.1,0-0.1,0c-0.1,0-0.2,0-0.3,0 c-0.1,0-0.2,0-0.3,0c-0.4,0-0.9,0.1-1.3,0.1c-0.5,0-1,0-1.5,0c-0.3,0-0.7,0-1-0.1c-0.3,0-0.7-0.1-1-0.1c-0.2,0-0.5-0.1-0.7-0.1 c-0.2,0-0.3-0.1-0.5-0.1c0,0,0,0,0,0c-0.2,0-0.3-0.1-0.5-0.1c0,0,0,0-0.1,0c-0.2,0-0.4-0.1-0.6-0.1c-0.1,0-0.2,0-0.3-0.1 c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2,0-0.3-0.1c-0.2-0.1-0.4-0.1-0.6-0.2c-0.2-0.1-0.3-0.1-0.5-0.2c-0.2-0.1-0.4-0.1-0.5-0.2 C5.5,23,5.2,22.8,5,22.7c-0.3-0.2-0.6-0.3-0.9-0.5c-0.4-0.2-0.7-0.5-1-0.9c-0.2-0.2-0.3-0.4-0.3-0.7c0-0.2,0-0.4,0-0.5 c0-0.2,0.1-0.3,0.2-0.4c0.3-0.4,0.6-0.7,1-0.9c0.2-0.2,0.5-0.3,0.7-0.5C4.9,18.2,5,18.1,5.2,18c0.2-0.1,0.3-0.2,0.5-0.2 c0.1-0.1,0.3-0.1,0.4-0.2c0.1,0,0.2-0.1,0.2-0.1c0,0,0-0.1,0-0.1c0,0-0.1-0.1-0.1-0.1c-0.2-0.3-0.4-0.7-0.6-1 c-0.1-0.2-0.2-0.4-0.3-0.6c-0.1-0.1-0.1-0.2-0.2-0.3c0-0.1-0.1-0.2-0.1-0.2C5,15,5,15,4.9,15c-0.1,0-0.1,0.1-0.2,0.1 c-0.2,0.1-0.3,0.2-0.5,0.2c-0.2,0.1-0.4,0.2-0.6,0.3c-0.3,0.1-0.5,0.3-0.8,0.5c-0.2,0.2-0.5,0.3-0.7,0.5c-0.4,0.3-0.7,0.6-1.1,1 c-0.3,0.3-0.5,0.6-0.7,1c-0.1,0.2-0.2,0.4-0.3,0.6c-0.1,0.2-0.1,0.4-0.2,0.6c0,0.4,0,0.7,0,1.1c0,0.1,0,0.3,0.1,0.4 c0.1,0.2,0.1,0.4,0.2,0.5c0.1,0.2,0.2,0.3,0.2,0.5c0.1,0.2,0.2,0.4,0.4,0.5c0.3,0.4,0.6,0.7,1,1c0.3,0.2,0.5,0.4,0.8,0.6 c0.2,0.2,0.5,0.3,0.8,0.5c0.2,0.1,0.4,0.2,0.6,0.3c0.1,0.1,0.2,0.1,0.3,0.2c0.2,0.1,0.4,0.2,0.6,0.2c0.3,0.1,0.5,0.2,0.8,0.3 c0.2,0.1,0.3,0.1,0.5,0.2c0,0,0.1,0,0.1,0c0.1,0,0.3,0.1,0.4,0.1c0.2,0.1,0.4,0.1,0.6,0.2c0.1,0,0.2,0,0.3,0.1 c0.2,0,0.4,0.1,0.6,0.1c0.1,0,0.3,0.1,0.4,0.1c0.2,0,0.3,0.1,0.5,0.1c0.2,0,0.4,0.1,0.6,0.1c0.2,0,0.3,0.1,0.5,0.1 c0.3,0,0.6,0.1,0.9,0.1c0,0,0,0,0.1,0c1.5,0,3,0,4.4,0c0,0,0.1,0,0.1,0c0.2,0,0.5,0,0.7-0.1c0.2,0,0.4,0,0.6-0.1 c0.2,0,0.4-0.1,0.6-0.1c0,0,0,0,0.1,0c0.2,0,0.4-0.1,0.5-0.1c0.2,0,0.4-0.1,0.6-0.1c0.2,0,0.4-0.1,0.5-0.1c0.2,0,0.4-0.1,0.5-0.1 c0.1,0,0.2-0.1,0.3-0.1c0.1,0,0.2-0.1,0.3-0.1c0.2,0,0.3-0.1,0.5-0.1c0.2-0.1,0.4-0.1,0.5-0.2c0.1,0,0.3-0.1,0.4-0.1 c0.2-0.1,0.3-0.1,0.5-0.2c0.2-0.1,0.4-0.2,0.6-0.3c0.2-0.1,0.4-0.2,0.5-0.3c0.3-0.2,0.6-0.3,0.9-0.5c0.3-0.2,0.6-0.4,0.9-0.7 c0.3-0.3,0.6-0.5,0.9-0.9c0.2-0.3,0.4-0.5,0.5-0.8c0.1-0.2,0.2-0.4,0.2-0.6c0-0.1,0.1-0.2,0.1-0.3c0-0.1,0-0.3,0.1-0.4 c0,0,0,0,0-0.1V19.9z"/> </g> </svg> 
                            <span class="adr">
                                <span class="street-address">Yeşilköy Mah. Atatürk Cad. (Istanbul World Trade Center) NO: 12/1 Bakırköy / İstanbul</span><br>
                            </span>
                        </a>

                    </div>
                </div>
                @endforeach


                <div class="branch">
                    <div class="contact_links num bg-w shadow_type">
                        <h3 class="jazzira_font_bold"><?= trans("front.office2"); ?></h3>
                        <a class="telephone mobile" href="tel:0096898272585">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.8 24.8" xml:space="preserve"><path class="st0" d="M3.4,24.8H12c1.7,0,3-1.4,3-3V3.5c0-1.7-1.4-3-3-3H3.4c-1.7,0-3,1.4-3,3v18.3C0.4,23.4,1.7,24.8,3.4,24.8z M7.7,22.8c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4s1.4,0.6,1.4,1.4C9.1,22.2,8.5,22.8,7.7,22.8z M1.7,4.5h11.9v14.1H1.7V4.5z "/> </svg>
                            +96898272585
                        </a>

                        <a class="email" href="mailto:oman@damas.net">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 18.9" xml:space="preserve"><g> <path class="st0" d="M21.9,18.9c0.5,0,1-0.2,1.4-0.5l-6.8-6.8c-0.2,0.1-0.3,0.2-0.5,0.3c-0.5,0.4-0.9,0.7-1.2,0.9 c-0.3,0.2-0.7,0.4-1.3,0.6c-0.5,0.2-1,0.3-1.5,0.3h0c-0.5,0-0.9-0.1-1.5-0.3c-0.5-0.2-1-0.4-1.3-0.6c-0.3-0.2-0.7-0.5-1.2-0.9 c-0.1-0.1-0.3-0.2-0.5-0.3l-6.8,6.8c0.4,0.4,0.9,0.5,1.4,0.5H21.9z M21.9,18.9"/> <path class="st0" d="M1.4,7.3C0.8,6.9,0.4,6.5,0,6.1v10.4l6-6C4.8,9.6,3.3,8.5,1.4,7.3L1.4,7.3z M1.4,7.3"/> <path class="st0" d="M22.7,7.3c-1.8,1.2-3.4,2.3-4.7,3.2l6,6V6.1C23.7,6.5,23.2,6.9,22.7,7.3L22.7,7.3z M22.7,7.3"/> <path class="st0" d="M21.9,0H2.1C1.5,0,0.9,0.2,0.6,0.7C0.2,1.2,0,1.7,0,2.4C0,3,0.2,3.6,0.7,4.3c0.5,0.7,1,1.2,1.6,1.5 C2.6,6,3.5,6.7,5.1,7.7c0.8,0.6,1.5,1.1,2.2,1.5c0.5,0.4,1,0.7,1.4,0.9c0,0,0.1,0.1,0.2,0.1c0.1,0.1,0.2,0.2,0.4,0.3 c0.3,0.2,0.5,0.4,0.7,0.5c0.2,0.1,0.4,0.3,0.7,0.4c0.3,0.2,0.5,0.3,0.8,0.4C11.6,12,11.8,12,12,12h0c0.2,0,0.4,0,0.7-0.1 c0.2-0.1,0.5-0.2,0.8-0.4c0.3-0.2,0.5-0.3,0.7-0.4c0.2-0.1,0.4-0.3,0.7-0.5c0.1-0.1,0.3-0.2,0.4-0.3c0.1-0.1,0.2-0.1,0.2-0.1 c0.3-0.2,0.7-0.5,1.4-0.9c1.1-0.8,2.7-1.9,4.9-3.4c0.7-0.5,1.2-1,1.6-1.6c0.4-0.6,0.7-1.3,0.7-2c0-0.6-0.2-1.1-0.6-1.5 C23,0.2,22.5,0,21.9,0L21.9,0z M21.9,0"/> </g> </svg>                        
                            <?= nl2br('oman@damas.net'); ?>
                        </a>

                        <a class="location" href="https://share.google/vgXXBKhThaMXTWU2v" target="_blank">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 27.2 27.1" style="enable-background:new 0 0 27.2 27.1;" xml:space="preserve"><style type="text/css">.st0{fill:#4D4D4D}</style><g> <path class="st0" d="M5.5,9.1C5.5,9.1,5.5,9.1,5.5,9.1c0,0.1,0.1,0.3,0.1,0.4c0,0.2,0.1,0.3,0.1,0.5c0.1,0.2,0.1,0.4,0.2,0.6 c0.1,0.2,0.1,0.3,0.2,0.5c0,0.1,0.1,0.2,0.1,0.3c0,0.1,0.1,0.2,0.1,0.3c0.1,0.1,0.1,0.3,0.2,0.4c0.1,0.2,0.2,0.3,0.2,0.5 C6.9,12.8,7,13,7.1,13.2c0.2,0.3,0.4,0.7,0.5,1c0.1,0.2,0.3,0.5,0.4,0.7c0.2,0.4,0.4,0.8,0.7,1.1c0.3,0.4,0.5,0.9,0.8,1.3 c0.3,0.4,0.5,0.8,0.8,1.2c0.3,0.5,0.6,0.9,0.9,1.4c0.2,0.3,0.5,0.7,0.7,1c0.3,0.4,0.6,0.8,0.9,1.2c0.3,0.3,0.5,0.7,0.8,1 c0.1,0.1,0.1,0.1,0.1,0c0.2-0.3,0.5-0.7,0.7-1c0.3-0.4,0.6-0.8,0.9-1.3c0.3-0.4,0.6-0.8,0.8-1.2c0.3-0.5,0.6-0.9,0.9-1.4 c0.2-0.4,0.5-0.7,0.7-1.1c0.2-0.3,0.4-0.7,0.6-1c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.2-0.4,0.3-0.6 c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.2-0.3,0.3-0.5c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.1,0.1-0.3,0.2-0.4 c0.1-0.2,0.1-0.3,0.2-0.5c0-0.1,0.1-0.2,0.1-0.4c0.1-0.2,0.1-0.3,0.2-0.5c0-0.1,0-0.1,0.1-0.2c0-0.2,0.1-0.3,0.1-0.5 c0-0.2,0.1-0.3,0.1-0.5c0-0.2,0-0.5,0.1-0.7c0-0.1,0-0.1,0-0.2c0-0.2,0-0.4,0-0.5c0-0.1,0-0.1,0-0.2c0-0.2-0.1-0.4-0.1-0.6 c0-0.1,0-0.2-0.1-0.4c0-0.1-0.1-0.2-0.1-0.4c0-0.1,0-0.2-0.1-0.3c0-0.1-0.1-0.2-0.1-0.4c0-0.1-0.1-0.2-0.1-0.3 C21.1,4.9,21,4.7,21,4.6c-0.1-0.2-0.2-0.4-0.3-0.6c-0.1-0.2-0.3-0.4-0.4-0.6c-0.2-0.3-0.4-0.5-0.6-0.8c-0.3-0.3-0.6-0.6-1-0.9 c-0.3-0.2-0.5-0.4-0.8-0.5c-0.2-0.1-0.4-0.2-0.7-0.4c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2-0.1-0.3-0.1 c-0.2-0.1-0.3-0.1-0.5-0.1c-0.1,0-0.2-0.1-0.4-0.1c-0.2-0.1-0.5-0.1-0.7-0.1c-0.1,0-0.2,0-0.3,0c0,0,0,0-0.1,0c-0.4,0-0.9,0-1.3,0 c0,0,0,0-0.1,0c-0.2,0-0.4,0-0.6,0.1c-0.1,0-0.3,0-0.4,0.1c-0.1,0-0.2,0-0.3,0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.1,0-0.1,0-0.2,0.1 c-0.1,0-0.2,0.1-0.4,0.1c-0.2,0.1-0.3,0.1-0.5,0.2C10.1,0.8,9.9,0.9,9.7,1C9.6,1.1,9.4,1.2,9.2,1.3C8.9,1.5,8.6,1.7,8.3,2 C7.9,2.4,7.4,2.8,7.1,3.3C6.8,3.6,6.6,4,6.4,4.4C6.2,4.7,6.1,4.9,6,5.1C6,5.2,6,5.3,6,5.3c0,0.1-0.1,0.2-0.1,0.4 c0,0.2-0.1,0.3-0.1,0.5c0,0.2-0.1,0.4-0.1,0.5c0,0.2-0.1,0.4-0.1,0.6c0,0.2,0,0.4,0,0.7c0,0.1,0,0.2,0,0.3C5.5,8.5,5.5,8.8,5.5,9.1 z M13.6,5.5c1.5,0,2.7,1.2,2.7,2.7c0,1.5-1.2,2.7-2.7,2.7c-1.5,0-2.7-1.2-2.7-2.7C10.9,6.7,12.1,5.5,13.6,5.5z"/> <path class="st0" d="M27.2,19.9C27.2,19.9,27.2,19.9,27.2,19.9c0-0.2-0.1-0.3-0.1-0.4c-0.1-0.2-0.1-0.4-0.2-0.6 c-0.1-0.2-0.1-0.3-0.2-0.5c-0.2-0.3-0.4-0.6-0.6-0.8c-0.4-0.5-0.9-0.9-1.4-1.2c-0.2-0.1-0.4-0.3-0.6-0.4c-0.2-0.1-0.4-0.2-0.5-0.3 c-0.1-0.1-0.2-0.1-0.3-0.1c-0.2-0.1-0.4-0.2-0.6-0.2c-0.1-0.1-0.3-0.1-0.4-0.2c0,0-0.1,0.1-0.1,0.1c-0.1,0.2-0.2,0.3-0.2,0.5 c-0.1,0.2-0.2,0.3-0.3,0.5c-0.1,0.2-0.3,0.5-0.4,0.7c-0.1,0.2-0.2,0.4-0.4,0.6c0,0.1,0,0.1,0,0.1c0.1,0.1,0.3,0.1,0.4,0.2 c0.1,0,0.2,0.1,0.3,0.1c0.1,0.1,0.3,0.1,0.4,0.2c0.2,0.1,0.3,0.1,0.5,0.2c0.2,0.1,0.4,0.2,0.6,0.4c0.3,0.2,0.6,0.5,0.9,0.8 c0.2,0.2,0.4,0.5,0.4,0.8c0,0.2,0,0.3,0,0.5c-0.1,0.2-0.2,0.4-0.3,0.5c-0.2,0.2-0.4,0.5-0.6,0.6c-0.3,0.2-0.5,0.4-0.8,0.6 c-0.2,0.1-0.3,0.2-0.5,0.3c-0.2,0.1-0.3,0.2-0.5,0.2c-0.2,0.1-0.4,0.2-0.6,0.2c-0.2,0.1-0.3,0.1-0.5,0.2c-0.1,0-0.3,0.1-0.4,0.1 c-0.1,0-0.3,0.1-0.4,0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.1,0-0.2,0-0.3,0.1c-0.2,0-0.4,0.1-0.6,0.1c-0.2,0-0.4,0.1-0.6,0.1 c-0.1,0-0.1,0-0.2,0c-0.1,0-0.2,0-0.3,0.1c-0.2,0-0.4,0.1-0.6,0.1c-0.2,0-0.5,0.1-0.7,0.1c0,0-0.1,0-0.1,0c-0.1,0-0.2,0-0.3,0 c-0.1,0-0.2,0-0.3,0c-0.4,0-0.9,0.1-1.3,0.1c-0.5,0-1,0-1.5,0c-0.3,0-0.7,0-1-0.1c-0.3,0-0.7-0.1-1-0.1c-0.2,0-0.5-0.1-0.7-0.1 c-0.2,0-0.3-0.1-0.5-0.1c0,0,0,0,0,0c-0.2,0-0.3-0.1-0.5-0.1c0,0,0,0-0.1,0c-0.2,0-0.4-0.1-0.6-0.1c-0.1,0-0.2,0-0.3-0.1 c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2,0-0.3-0.1c-0.2-0.1-0.4-0.1-0.6-0.2c-0.2-0.1-0.3-0.1-0.5-0.2c-0.2-0.1-0.4-0.1-0.5-0.2 C5.5,23,5.2,22.8,5,22.7c-0.3-0.2-0.6-0.3-0.9-0.5c-0.4-0.2-0.7-0.5-1-0.9c-0.2-0.2-0.3-0.4-0.3-0.7c0-0.2,0-0.4,0-0.5 c0-0.2,0.1-0.3,0.2-0.4c0.3-0.4,0.6-0.7,1-0.9c0.2-0.2,0.5-0.3,0.7-0.5C4.9,18.2,5,18.1,5.2,18c0.2-0.1,0.3-0.2,0.5-0.2 c0.1-0.1,0.3-0.1,0.4-0.2c0.1,0,0.2-0.1,0.2-0.1c0,0,0-0.1,0-0.1c0,0-0.1-0.1-0.1-0.1c-0.2-0.3-0.4-0.7-0.6-1 c-0.1-0.2-0.2-0.4-0.3-0.6c-0.1-0.1-0.1-0.2-0.2-0.3c0-0.1-0.1-0.2-0.1-0.2C5,15,5,15,4.9,15c-0.1,0-0.1,0.1-0.2,0.1 c-0.2,0.1-0.3,0.2-0.5,0.2c-0.2,0.1-0.4,0.2-0.6,0.3c-0.3,0.1-0.5,0.3-0.8,0.5c-0.2,0.2-0.5,0.3-0.7,0.5c-0.4,0.3-0.7,0.6-1.1,1 c-0.3,0.3-0.5,0.6-0.7,1c-0.1,0.2-0.2,0.4-0.3,0.6c-0.1,0.2-0.1,0.4-0.2,0.6c0,0.4,0,0.7,0,1.1c0,0.1,0,0.3,0.1,0.4 c0.1,0.2,0.1,0.4,0.2,0.5c0.1,0.2,0.2,0.3,0.2,0.5c0.1,0.2,0.2,0.4,0.4,0.5c0.3,0.4,0.6,0.7,1,1c0.3,0.2,0.5,0.4,0.8,0.6 c0.2,0.2,0.5,0.3,0.8,0.5c0.2,0.1,0.4,0.2,0.6,0.3c0.1,0.1,0.2,0.1,0.3,0.2c0.2,0.1,0.4,0.2,0.6,0.2c0.3,0.1,0.5,0.2,0.8,0.3 c0.2,0.1,0.3,0.1,0.5,0.2c0,0,0.1,0,0.1,0c0.1,0,0.3,0.1,0.4,0.1c0.2,0.1,0.4,0.1,0.6,0.2c0.1,0,0.2,0,0.3,0.1 c0.2,0,0.4,0.1,0.6,0.1c0.1,0,0.3,0.1,0.4,0.1c0.2,0,0.3,0.1,0.5,0.1c0.2,0,0.4,0.1,0.6,0.1c0.2,0,0.3,0.1,0.5,0.1 c0.3,0,0.6,0.1,0.9,0.1c0,0,0,0,0.1,0c1.5,0,3,0,4.4,0c0,0,0.1,0,0.1,0c0.2,0,0.5,0,0.7-0.1c0.2,0,0.4,0,0.6-0.1 c0.2,0,0.4-0.1,0.6-0.1c0,0,0,0,0.1,0c0.2,0,0.4-0.1,0.5-0.1c0.2,0,0.4-0.1,0.6-0.1c0.2,0,0.4-0.1,0.5-0.1c0.2,0,0.4-0.1,0.5-0.1 c0.1,0,0.2-0.1,0.3-0.1c0.1,0,0.2-0.1,0.3-0.1c0.2,0,0.3-0.1,0.5-0.1c0.2-0.1,0.4-0.1,0.5-0.2c0.1,0,0.3-0.1,0.4-0.1 c0.2-0.1,0.3-0.1,0.5-0.2c0.2-0.1,0.4-0.2,0.6-0.3c0.2-0.1,0.4-0.2,0.5-0.3c0.3-0.2,0.6-0.3,0.9-0.5c0.3-0.2,0.6-0.4,0.9-0.7 c0.3-0.3,0.6-0.5,0.9-0.9c0.2-0.3,0.4-0.5,0.5-0.8c0.1-0.2,0.2-0.4,0.2-0.6c0-0.1,0.1-0.2,0.1-0.3c0-0.1,0-0.3,0.1-0.4 c0,0,0,0,0-0.1V19.9z"/> </g> </svg> 
                            <span class="adr">
                                <span class="street-address">Al Khawd, Mazoon St. NO: 218/26</span><br>
                                <span class="locality">Seeb / </span>
                                <span class="region">Muscat</span>
                            </span>
                        </a>

                    </div>
                </div>

                <div class="branch">
                    <div class="contact_links num bg-w shadow_type">
                        <h3 class="jazzira_font_bold"><?= trans("front.office3"); ?></h3><?php
                        $phone = str_replace(' ', '', $branch->mobile);
                        $phone_href = str_replace([' ', '+'], ['', '00'], $branch->mobile);
                        ?>
                        <a class="telephone mobile" href="tel:00905523213829"  target="_blank">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.8 24.8" xml:space="preserve"><path class="st0" d="M3.4,24.8H12c1.7,0,3-1.4,3-3V3.5c0-1.7-1.4-3-3-3H3.4c-1.7,0-3,1.4-3,3v18.3C0.4,23.4,1.7,24.8,3.4,24.8z M7.7,22.8c-0.8,0-1.4-0.6-1.4-1.4c0-0.8,0.6-1.4,1.4-1.4s1.4,0.6,1.4,1.4C9.1,22.2,8.5,22.8,7.7,22.8z M1.7,4.5h11.9v14.1H1.7V4.5z "/> </svg>
                            +971562187615
                        </a>

                        <a class="email" href="mailto:dubai@damas.net" target="_blank">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 18.9" xml:space="preserve"><g> <path class="st0" d="M21.9,18.9c0.5,0,1-0.2,1.4-0.5l-6.8-6.8c-0.2,0.1-0.3,0.2-0.5,0.3c-0.5,0.4-0.9,0.7-1.2,0.9 c-0.3,0.2-0.7,0.4-1.3,0.6c-0.5,0.2-1,0.3-1.5,0.3h0c-0.5,0-0.9-0.1-1.5-0.3c-0.5-0.2-1-0.4-1.3-0.6c-0.3-0.2-0.7-0.5-1.2-0.9 c-0.1-0.1-0.3-0.2-0.5-0.3l-6.8,6.8c0.4,0.4,0.9,0.5,1.4,0.5H21.9z M21.9,18.9"/> <path class="st0" d="M1.4,7.3C0.8,6.9,0.4,6.5,0,6.1v10.4l6-6C4.8,9.6,3.3,8.5,1.4,7.3L1.4,7.3z M1.4,7.3"/> <path class="st0" d="M22.7,7.3c-1.8,1.2-3.4,2.3-4.7,3.2l6,6V6.1C23.7,6.5,23.2,6.9,22.7,7.3L22.7,7.3z M22.7,7.3"/> <path class="st0" d="M21.9,0H2.1C1.5,0,0.9,0.2,0.6,0.7C0.2,1.2,0,1.7,0,2.4C0,3,0.2,3.6,0.7,4.3c0.5,0.7,1,1.2,1.6,1.5 C2.6,6,3.5,6.7,5.1,7.7c0.8,0.6,1.5,1.1,2.2,1.5c0.5,0.4,1,0.7,1.4,0.9c0,0,0.1,0.1,0.2,0.1c0.1,0.1,0.2,0.2,0.4,0.3 c0.3,0.2,0.5,0.4,0.7,0.5c0.2,0.1,0.4,0.3,0.7,0.4c0.3,0.2,0.5,0.3,0.8,0.4C11.6,12,11.8,12,12,12h0c0.2,0,0.4,0,0.7-0.1 c0.2-0.1,0.5-0.2,0.8-0.4c0.3-0.2,0.5-0.3,0.7-0.4c0.2-0.1,0.4-0.3,0.7-0.5c0.1-0.1,0.3-0.2,0.4-0.3c0.1-0.1,0.2-0.1,0.2-0.1 c0.3-0.2,0.7-0.5,1.4-0.9c1.1-0.8,2.7-1.9,4.9-3.4c0.7-0.5,1.2-1,1.6-1.6c0.4-0.6,0.7-1.3,0.7-2c0-0.6-0.2-1.1-0.6-1.5 C23,0.2,22.5,0,21.9,0L21.9,0z M21.9,0"/> </g> </svg>                        
                            <?= nl2br('dubai@damas.net'); ?>
                        </a>

                        <a class="location" href="https://maps.app.goo.gl/mzX3w87JtEvFcArS6" target="_blank">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 27.2 27.1" style="enable-background:new 0 0 27.2 27.1;" xml:space="preserve"><style type="text/css">.st0{fill:#4D4D4D}</style><g> <path class="st0" d="M5.5,9.1C5.5,9.1,5.5,9.1,5.5,9.1c0,0.1,0.1,0.3,0.1,0.4c0,0.2,0.1,0.3,0.1,0.5c0.1,0.2,0.1,0.4,0.2,0.6 c0.1,0.2,0.1,0.3,0.2,0.5c0,0.1,0.1,0.2,0.1,0.3c0,0.1,0.1,0.2,0.1,0.3c0.1,0.1,0.1,0.3,0.2,0.4c0.1,0.2,0.2,0.3,0.2,0.5 C6.9,12.8,7,13,7.1,13.2c0.2,0.3,0.4,0.7,0.5,1c0.1,0.2,0.3,0.5,0.4,0.7c0.2,0.4,0.4,0.8,0.7,1.1c0.3,0.4,0.5,0.9,0.8,1.3 c0.3,0.4,0.5,0.8,0.8,1.2c0.3,0.5,0.6,0.9,0.9,1.4c0.2,0.3,0.5,0.7,0.7,1c0.3,0.4,0.6,0.8,0.9,1.2c0.3,0.3,0.5,0.7,0.8,1 c0.1,0.1,0.1,0.1,0.1,0c0.2-0.3,0.5-0.7,0.7-1c0.3-0.4,0.6-0.8,0.9-1.3c0.3-0.4,0.6-0.8,0.8-1.2c0.3-0.5,0.6-0.9,0.9-1.4 c0.2-0.4,0.5-0.7,0.7-1.1c0.2-0.3,0.4-0.7,0.6-1c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.2-0.4,0.3-0.6 c0.1-0.2,0.3-0.5,0.4-0.7c0.1-0.2,0.2-0.3,0.3-0.5c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.2,0.2-0.4,0.3-0.6c0.1-0.1,0.1-0.3,0.2-0.4 c0.1-0.2,0.1-0.3,0.2-0.5c0-0.1,0.1-0.2,0.1-0.4c0.1-0.2,0.1-0.3,0.2-0.5c0-0.1,0-0.1,0.1-0.2c0-0.2,0.1-0.3,0.1-0.5 c0-0.2,0.1-0.3,0.1-0.5c0-0.2,0-0.5,0.1-0.7c0-0.1,0-0.1,0-0.2c0-0.2,0-0.4,0-0.5c0-0.1,0-0.1,0-0.2c0-0.2-0.1-0.4-0.1-0.6 c0-0.1,0-0.2-0.1-0.4c0-0.1-0.1-0.2-0.1-0.4c0-0.1,0-0.2-0.1-0.3c0-0.1-0.1-0.2-0.1-0.4c0-0.1-0.1-0.2-0.1-0.3 C21.1,4.9,21,4.7,21,4.6c-0.1-0.2-0.2-0.4-0.3-0.6c-0.1-0.2-0.3-0.4-0.4-0.6c-0.2-0.3-0.4-0.5-0.6-0.8c-0.3-0.3-0.6-0.6-1-0.9 c-0.3-0.2-0.5-0.4-0.8-0.5c-0.2-0.1-0.4-0.2-0.7-0.4c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2-0.1-0.3-0.1 c-0.2-0.1-0.3-0.1-0.5-0.1c-0.1,0-0.2-0.1-0.4-0.1c-0.2-0.1-0.5-0.1-0.7-0.1c-0.1,0-0.2,0-0.3,0c0,0,0,0-0.1,0c-0.4,0-0.9,0-1.3,0 c0,0,0,0-0.1,0c-0.2,0-0.4,0-0.6,0.1c-0.1,0-0.3,0-0.4,0.1c-0.1,0-0.2,0-0.3,0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.1,0-0.1,0-0.2,0.1 c-0.1,0-0.2,0.1-0.4,0.1c-0.2,0.1-0.3,0.1-0.5,0.2C10.1,0.8,9.9,0.9,9.7,1C9.6,1.1,9.4,1.2,9.2,1.3C8.9,1.5,8.6,1.7,8.3,2 C7.9,2.4,7.4,2.8,7.1,3.3C6.8,3.6,6.6,4,6.4,4.4C6.2,4.7,6.1,4.9,6,5.1C6,5.2,6,5.3,6,5.3c0,0.1-0.1,0.2-0.1,0.4 c0,0.2-0.1,0.3-0.1,0.5c0,0.2-0.1,0.4-0.1,0.5c0,0.2-0.1,0.4-0.1,0.6c0,0.2,0,0.4,0,0.7c0,0.1,0,0.2,0,0.3C5.5,8.5,5.5,8.8,5.5,9.1 z M13.6,5.5c1.5,0,2.7,1.2,2.7,2.7c0,1.5-1.2,2.7-2.7,2.7c-1.5,0-2.7-1.2-2.7-2.7C10.9,6.7,12.1,5.5,13.6,5.5z"/> <path class="st0" d="M27.2,19.9C27.2,19.9,27.2,19.9,27.2,19.9c0-0.2-0.1-0.3-0.1-0.4c-0.1-0.2-0.1-0.4-0.2-0.6 c-0.1-0.2-0.1-0.3-0.2-0.5c-0.2-0.3-0.4-0.6-0.6-0.8c-0.4-0.5-0.9-0.9-1.4-1.2c-0.2-0.1-0.4-0.3-0.6-0.4c-0.2-0.1-0.4-0.2-0.5-0.3 c-0.1-0.1-0.2-0.1-0.3-0.1c-0.2-0.1-0.4-0.2-0.6-0.2c-0.1-0.1-0.3-0.1-0.4-0.2c0,0-0.1,0.1-0.1,0.1c-0.1,0.2-0.2,0.3-0.2,0.5 c-0.1,0.2-0.2,0.3-0.3,0.5c-0.1,0.2-0.3,0.5-0.4,0.7c-0.1,0.2-0.2,0.4-0.4,0.6c0,0.1,0,0.1,0,0.1c0.1,0.1,0.3,0.1,0.4,0.2 c0.1,0,0.2,0.1,0.3,0.1c0.1,0.1,0.3,0.1,0.4,0.2c0.2,0.1,0.3,0.1,0.5,0.2c0.2,0.1,0.4,0.2,0.6,0.4c0.3,0.2,0.6,0.5,0.9,0.8 c0.2,0.2,0.4,0.5,0.4,0.8c0,0.2,0,0.3,0,0.5c-0.1,0.2-0.2,0.4-0.3,0.5c-0.2,0.2-0.4,0.5-0.6,0.6c-0.3,0.2-0.5,0.4-0.8,0.6 c-0.2,0.1-0.3,0.2-0.5,0.3c-0.2,0.1-0.3,0.2-0.5,0.2c-0.2,0.1-0.4,0.2-0.6,0.2c-0.2,0.1-0.3,0.1-0.5,0.2c-0.1,0-0.3,0.1-0.4,0.1 c-0.1,0-0.3,0.1-0.4,0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.1,0-0.2,0-0.3,0.1c-0.2,0-0.4,0.1-0.6,0.1c-0.2,0-0.4,0.1-0.6,0.1 c-0.1,0-0.1,0-0.2,0c-0.1,0-0.2,0-0.3,0.1c-0.2,0-0.4,0.1-0.6,0.1c-0.2,0-0.5,0.1-0.7,0.1c0,0-0.1,0-0.1,0c-0.1,0-0.2,0-0.3,0 c-0.1,0-0.2,0-0.3,0c-0.4,0-0.9,0.1-1.3,0.1c-0.5,0-1,0-1.5,0c-0.3,0-0.7,0-1-0.1c-0.3,0-0.7-0.1-1-0.1c-0.2,0-0.5-0.1-0.7-0.1 c-0.2,0-0.3-0.1-0.5-0.1c0,0,0,0,0,0c-0.2,0-0.3-0.1-0.5-0.1c0,0,0,0-0.1,0c-0.2,0-0.4-0.1-0.6-0.1c-0.1,0-0.2,0-0.3-0.1 c-0.1,0-0.2-0.1-0.3-0.1c-0.1,0-0.2,0-0.3-0.1c-0.2-0.1-0.4-0.1-0.6-0.2c-0.2-0.1-0.3-0.1-0.5-0.2c-0.2-0.1-0.4-0.1-0.5-0.2 C5.5,23,5.2,22.8,5,22.7c-0.3-0.2-0.6-0.3-0.9-0.5c-0.4-0.2-0.7-0.5-1-0.9c-0.2-0.2-0.3-0.4-0.3-0.7c0-0.2,0-0.4,0-0.5 c0-0.2,0.1-0.3,0.2-0.4c0.3-0.4,0.6-0.7,1-0.9c0.2-0.2,0.5-0.3,0.7-0.5C4.9,18.2,5,18.1,5.2,18c0.2-0.1,0.3-0.2,0.5-0.2 c0.1-0.1,0.3-0.1,0.4-0.2c0.1,0,0.2-0.1,0.2-0.1c0,0,0-0.1,0-0.1c0,0-0.1-0.1-0.1-0.1c-0.2-0.3-0.4-0.7-0.6-1 c-0.1-0.2-0.2-0.4-0.3-0.6c-0.1-0.1-0.1-0.2-0.2-0.3c0-0.1-0.1-0.2-0.1-0.2C5,15,5,15,4.9,15c-0.1,0-0.1,0.1-0.2,0.1 c-0.2,0.1-0.3,0.2-0.5,0.2c-0.2,0.1-0.4,0.2-0.6,0.3c-0.3,0.1-0.5,0.3-0.8,0.5c-0.2,0.2-0.5,0.3-0.7,0.5c-0.4,0.3-0.7,0.6-1.1,1 c-0.3,0.3-0.5,0.6-0.7,1c-0.1,0.2-0.2,0.4-0.3,0.6c-0.1,0.2-0.1,0.4-0.2,0.6c0,0.4,0,0.7,0,1.1c0,0.1,0,0.3,0.1,0.4 c0.1,0.2,0.1,0.4,0.2,0.5c0.1,0.2,0.2,0.3,0.2,0.5c0.1,0.2,0.2,0.4,0.4,0.5c0.3,0.4,0.6,0.7,1,1c0.3,0.2,0.5,0.4,0.8,0.6 c0.2,0.2,0.5,0.3,0.8,0.5c0.2,0.1,0.4,0.2,0.6,0.3c0.1,0.1,0.2,0.1,0.3,0.2c0.2,0.1,0.4,0.2,0.6,0.2c0.3,0.1,0.5,0.2,0.8,0.3 c0.2,0.1,0.3,0.1,0.5,0.2c0,0,0.1,0,0.1,0c0.1,0,0.3,0.1,0.4,0.1c0.2,0.1,0.4,0.1,0.6,0.2c0.1,0,0.2,0,0.3,0.1 c0.2,0,0.4,0.1,0.6,0.1c0.1,0,0.3,0.1,0.4,0.1c0.2,0,0.3,0.1,0.5,0.1c0.2,0,0.4,0.1,0.6,0.1c0.2,0,0.3,0.1,0.5,0.1 c0.3,0,0.6,0.1,0.9,0.1c0,0,0,0,0.1,0c1.5,0,3,0,4.4,0c0,0,0.1,0,0.1,0c0.2,0,0.5,0,0.7-0.1c0.2,0,0.4,0,0.6-0.1 c0.2,0,0.4-0.1,0.6-0.1c0,0,0,0,0.1,0c0.2,0,0.4-0.1,0.5-0.1c0.2,0,0.4-0.1,0.6-0.1c0.2,0,0.4-0.1,0.5-0.1c0.2,0,0.4-0.1,0.5-0.1 c0.1,0,0.2-0.1,0.3-0.1c0.1,0,0.2-0.1,0.3-0.1c0.2,0,0.3-0.1,0.5-0.1c0.2-0.1,0.4-0.1,0.5-0.2c0.1,0,0.3-0.1,0.4-0.1 c0.2-0.1,0.3-0.1,0.5-0.2c0.2-0.1,0.4-0.2,0.6-0.3c0.2-0.1,0.4-0.2,0.5-0.3c0.3-0.2,0.6-0.3,0.9-0.5c0.3-0.2,0.6-0.4,0.9-0.7 c0.3-0.3,0.6-0.5,0.9-0.9c0.2-0.3,0.4-0.5,0.5-0.8c0.1-0.2,0.2-0.4,0.2-0.6c0-0.1,0.1-0.2,0.1-0.3c0-0.1,0-0.3,0.1-0.4 c0,0,0,0,0-0.1V19.9z"/> </g> </svg> 
                            <span class="adr">
                                <span class="street-address">Meydan Grandstand, 6th floor, Meydan Road, Nad Al Sheba, Dubai, U.A.E.</span><br>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
            
            <div class="int_content bg-w shadow_type text_sec" data-aos="fade-up">
                <h2 class="sub_title jazzira_font_bold"><?= trans("front.introductory video about damasturk title"); ?></h2> 

                <?php
                if ($current_lang == "ar") {
                    $videoId = "-3cOVNnrO4I";
                    ?>
                    <?php
                } elseif ($current_lang == 'pe') {
                    $videoId = "k7l1o9nWtqs";
                    ?>
                    <?php
                } elseif ($current_lang == "fr") {
                    $videoId = "uL6qeYqix58";
                    ?>
                    <?php
                } else {
                    $videoId = "pUkewNbtGEI";
                    ?>
                <?php } ?>

                <iframe width="100%" height="480" src="https://www.youtube.com/embed/<?= $videoId ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>



            <div class="int_content our_services">
<!--                <h2 data-aos="zoom-in" class="sub_title jazzira_font_bold"><?= trans("front.our services"); ?></h2>-->

                <!--
                                <img data-aos="fade-left" class="content_image" src="<?= asset("/img/A.svg"); ?>" alt="damasturk"/>
                                <img data-aos="fade-right" class="content_image" src="<?= asset("/img/B.svg"); ?>" alt="damasturk"/>
                                <img data-aos="fade-left" class="content_image" src="<?= asset("/img/C.svg"); ?>" alt="damasturk"/>
                -->





                <div class="managment_title">
                    <img src="<?= asset("/img/services-title2.svg"); ?>" alt="damasturk"/>
                    <p><?= trans("front.our services"); ?></p>
                </div>


                <div class="int_content time_line_cont"> 


                    <div class="section right"> 
                        <div class="card" data-aos="zoom-out-left"> 
                            <img class="icon" src="<?= asset("/img/services-icon-1.svg"); ?>" alt="damasturk"/>
                            <h3 class="jazzira_font_bold"><?= trans("front.our services title 1"); ?></h3>
                            <p class="jazzira_font"><?= trans("front.our services text 1"); ?></p>
                            <span class="point"></span>
                        </div>
                    </div>
                    <div class="section left"> 
                        <div class="card" data-aos="zoom-out-right"> 
                            <img class="icon" src="<?= asset("/img/services-icon-2.svg"); ?>" alt="damasturk"/>
                            <h3 class="jazzira_font_bold"><?= trans("front.our services title 2"); ?></h3>
                            <p class="jazzira_font"><?= trans("front.our services text 2"); ?></p>
                            <span class="point"></span>
                        </div>
                    </div>
                    <div class="section right"> 
                        <div class="card" data-aos="zoom-out-left"> 
                            <img class="icon" src="<?= asset("/img/services-icon-3.svg"); ?>" alt="damasturk"/>
                            <h3 class="jazzira_font_bold"><?= trans("front.our services title 3"); ?></h3>
                            <p class="jazzira_font"><?= trans("front.our services text 3"); ?></p>
                            <span class="point"></span>
                        </div>
                    </div>
                    <div class="section left"> 
                        <div class="card" data-aos="zoom-out-right"> 
                            <img class="icon" src="<?= asset("/img/services-icon-4.svg"); ?>" alt="damasturk"/>
                            <h3 class="jazzira_font_bold"><?= trans("front.our services title 4"); ?></h3>
                            <p class="jazzira_font"><?= trans("front.our services text 4"); ?></p>
                            <span class="point"></span>
                        </div>
                    </div>
                    <div class="section right"> 
                        <div class="card" data-aos="zoom-out-left"> 
                            <img class="icon" src="<?= asset("/img/services-icon-5.svg"); ?>" alt="damasturk"/>
                            <h3 class="jazzira_font_bold"><?= trans("front.our services title 5"); ?></h3>
                            <p class="jazzira_font"><?= trans("front.our services text 5"); ?></p>
                            <span class="point"></span>
                        </div>
                    </div>
                </div>





            </div>



            <div class="int_content clouds_sec" data-aos="fade-up"> 

                <h2 class="sub_title jazzira_font_bold"><?= trans("front.Our real estate projects are guaranteed"); ?></h2>


                <img class="cloud cloud1" src="<?= asset("/img/cloud1.png"); ?>" alt="damasturk"/>
                <img class="cloud cloud2" src="<?= asset("/img/cloud2.png"); ?>" alt="damasturk"/>
                <img class="cloud cloud3" src="<?= asset("/img/cloud3.png"); ?>" alt="damasturk"/>
                <img class="about_land" src="<?= asset("/img/about-land1.png"); ?>" alt="damasturk"/>

            </div>


            <div class="int_content bg-w shadow_type text_sec projects_text" data-aos="fade-up">
                <div class="text_cont sec jazzira_font"><?= html_entity_decode($row->about()); ?></div>
            </div>






            <!-- Testimonials -->
            <div class="int_content testimonials">

                <h2 class="sub_title jazzira_font_bold" style="margin-bottom:15px;"><?= trans("front.testimonials"); ?></h2>


                <div class="int_content bg-w shadow_type text_sec" data-aos="fade-up">
                    <div class="text_cont sec jazzira_font"><?= html_entity_decode($row->niche()); ?></div>
                </div>



                @include("front.partials.testimonials_slider", [])
            </div>




<!--
            <div class="col-md-12">
                <div class="row">

                    <div class="managment_title">
                        <img src="<?= asset("/img/managment-title.svg"); ?>" alt="damasturk"/>
                        <p><?= trans("front.Administration"); ?></p>
                    </div>


                    <div class="int_content time_line_cont managment_sec"> 





                        <div class="section right"> 
                            <div data-aos="zoom-out-right"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont marketing"></div>
                                    <img class="photo" src="<?= asset("/img/muaz3.png"); ?>" alt="damasturk"/>
                                    <h4 class="num">Muaz Alhaj</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 1"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 1"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>
                        <div class="section left"> 
                            <div data-aos="zoom-out-left"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont consulting"></div>
                                    <img class="photo" src="<?= asset("/img/default-with-logo-100.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Department Director</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 2"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 2"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>
                        <div class="section right"> 
                            <div data-aos="zoom-out-left"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont sales"></div>
                                    <img class="photo" src="<?= asset("/img/managment-sec-photo-3.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Samer Najjar</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 3"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 3"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>
                        <div class="section left"> 
                            <div data-aos="zoom-out-right"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont quality_control"></div>
                                    <img class="photo" src="<?= asset("/img/managment-sec-photo-2.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Sherif Abdelaal</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 20"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 20"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>

                        <div class="section right"> 
                            <div data-aos="zoom-out-right"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont after_sales"></div>
                                    <img class="photo" src="<?= asset("/img/managment-sec-photo-9.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Sait Hikmetoğlu</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 4"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 4"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>

<?php /*
                        <div class="section left"> 
                            <div data-aos="zoom-out-left"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont accounting"></div>
                                    <img class="photo" src="<?= asset("/img/managment-sec-photo-10.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">BERAT MEHMET OĞLU</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 7"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 7"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>*/ ?>
                        <div class="section left"> 
                            <div data-aos="zoom-out-left"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont lawyer"></div>
                                    <img class="photo" src="<?= asset("/img/managment-sec-photo-6.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Necmettin Barman</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 6"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 6"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>
                        <div class="section right"> 
                            <div data-aos="zoom-out-right"> 
                                <div class="card shadow_type"> 
                                    <div class="image_cont HR"></div>
                                    <img class="photo" src="<?= asset("/img/managment-sec-photo-21.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Mohammed Adel</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 5"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.about Company departments text 5"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="sec job_btn_sec">
                <a href="{{ route('front.land_vacancies') }}" class="more_btn shadow_type"><?= trans("front.Join Our Team"); ?></a>
            </div>-->

            <!-- Contact -->
            <div class="int_content bg-w shadow_type text_sec contact_sec" data-aos="fade-up">
                <div class="section">
                    <h2 class="sub_title jazzira_font_bold"><?= trans("front.How to reach us"); ?></h2>


                    <!-- The video -->
                    <video  muted loop id="myVideo">
                        <source src="{{ asset('about_video/damasturk-map1.mp4') }}" type="video/mp4">
                    </video>


                    <div class="text-box">
                        <a href="https://goo.gl/maps/W4B2D3ii3utMFsUk7" class="btn btn-animate">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="directions" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-directions fa-w-16 fa-2x"><path fill="currentColor" d="M502.61 233.32L278.68 9.39c-12.52-12.52-32.83-12.52-45.36 0L9.39 233.32c-12.52 12.53-12.52 32.83 0 45.36l223.93 223.93c12.52 12.53 32.83 12.53 45.36 0l223.93-223.93c12.52-12.53 12.52-32.83 0-45.36zm-100.98 12.56l-84.21 77.73c-5.12 4.73-13.43 1.1-13.43-5.88V264h-96v64c0 4.42-3.58 8-8 8h-32c-4.42 0-8-3.58-8-8v-80c0-17.67 14.33-32 32-32h112v-53.73c0-6.97 8.3-10.61 13.43-5.88l84.21 77.73c3.43 3.17 3.43 8.59 0 11.76z" class=""></path></svg>
                            <p><?= trans("front.Directions"); ?></p> 
                        </a>
                    </div>


                    <div class="sosial_media_icons">
                        <ul> 
                            <li class="whatsapp-link faa-tada animated-hover"> <a href="{{ route('front.whatsapp_share') }}?icon=6" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-whatsapp"></i> </a> </li> 
                            <li class="facebook-link faa-tada animated-hover"> <a href="<?= $infos->facebook; ?>" target="_blank" aria-label="Link to AMP HTML Facebook"> <i class="fa fa-facebook"></i> </a> </li>
                            <li class="twitter-link faa-tada animated-hover">
                                <a href="<?= $infos->twitter; ?>" target="_blank" aria-label="Link to AMP HTML Twitter">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#5090a5" width="29px" height="29px"> <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path> </svg>
                                </a>
                            </li> 
                            <li class="instagram-link faa-tada animated-hover"> <a href="<?= $infos->instagram; ?>" target="_blank" aria-label="Link to AMP HTML Instagram"> <i class="fa fa-instagram"></i> </a> </li>
                            <li class="youtube-link faa-tada animated-hover"> <a href="<?= $infos->youtube; ?>" target="_blank" aria-label="Link to AMP HTML pin trest"> <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon"><g class="style-scope yt-icon"><path fill-rule="nonzero" d="M21.78 8s-.2-1.37-.8-1.97c-.75-.8-1.6-.8-2-.85C16.2 4.98 12 5 12 5s-4.18-.02-6.97.18c-.4.05-1.24.05-2 .85-.6.6-.8 1.97-.8 1.97s-.2 1.63-.23 3.23v1.7c.03 1.6.23 3.2.23 3.2s.2 1.4.8 2c.76.8 1.75.76 2.2.85 1.57.15 6.6.18 6.77.18 0 0 4.2 0 7-.2.38-.04 1.23-.04 2-.84.6-.6.8-1.98.8-1.98s.2-1.6.2-3.22v-1.7c-.02-1.6-.22-3.22-.22-3.22zm-11.8 7V9.16l5.35 3.03L9.97 15z" class="style-scope yt-icon"></path></g></svg> </a> </li> 
                            <li class="linkedin-link faa-tada animated-hover"> <a href="<?= $infos->linkedin; ?>" target="_blank" aria-label="Link to AMP HTML pin trest"> <i class="fa fa-linkedin"></i> </a> </li>
                        </ul>

                    </div>




                </div>

            </div>

        </div>
        <!-- End Left Section -->


    </div>
</div>





@endsection



@section('scriptjs')


<?= Html::script("js/aos.min.js"); ?> 
<?= Html::script("js/swiper.min.js"); ?>


<script>


    $(window).scroll(function () {
        var scrollingPage = 0;
        var scrollingPage2 = 500;
        ;
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



    AOS.init();

    $(document).ready(function () {

        $('.main_menu .links>li>a.about_btn').addClass("active");

        setTimeout(function () {
            $(".images_content .image_parts .part").addClass("show");
            $(".images_content .about_bg img").addClass("show");
        }, 500);
        setTimeout(function () {
            $(".top_title").addClass("animate__zoomIn");
        }, 1300);
    });



    var partImageOne = $(".images_content .image_parts .part.one");
    var partImageTwo = $(".images_content .image_parts .part.two");
    var partImageThree = $(".images_content .image_parts .part.three");
    var partImageFour = $(".images_content .image_parts .part.four");
    $(window).scroll(function () {
        var aboutLand = $('.about_land').offset().top - 600;
        var videoSec = $('.contact_sec').offset().top - 500;
        var st = $(this).scrollTop();
        var scrollingPage = 10;
        var scroll = $(window).scrollTop();
        if (scroll >= scrollingPage) {
            $(".header").addClass("scrolling");
        } else {
            $(".header").removeClass("scrolling");
        }

        if (st >= aboutLand) {
            $(".ribbon_flag1").addClass("show");
            $(".ribbon_flag2").addClass("show");
        } else {
            $(".ribbon_flag1").removeClass("show");
            $(".ribbon_flag2").removeClass("show");
        }

        if (scroll >= videoSec) {
            $("#myVideo")[0].play();
        } else {
            $("#myVideo")[0].pause();
        }


        partImageOne.css({'margin-top': '-' + st / 15 + 'px'}); // better use CSS
        partImageTwo.css({'margin-top': st / 15 + 'px'}); // better use CSS
        partImageThree.css({'margin-top': '-' + st / 15 + 'px'}); // better use CSS
        partImageFour.css({'margin-top': st / 15 + 'px'}); // better use CSS
    });



    var cloud1 = $(".cloud1");
    var cloud2 = $(".cloud2");
    var cloud3 = $(".cloud3");
    $("body").on("mousemove", function (e) {
        var ax = -($(window).innerWidth() / 2 - e.pageX) / 120;
        var ay = ($(window).innerHeight() / 2 - e.pageY) / 120;
        //landImage.attr("style", "transform: rotateY(" + ax + "deg) rotateX(" + ay + "deg);-webkit-transform: rotateY(" + ax + "deg) rotateX(" + ay + "deg);-moz-transform: rotateY(" + ax + "deg) rotateX(" + ay + "deg)");
        cloud1.css({'margin-top': ay, 'margin-left': ax}); // better use CSS
        cloud2.css({'margin-top': ay, 'margin-left': ax}); // better use CSS
        cloud3.css({'margin-top': ay, 'margin-left': ax}); // better use CSS

    });










</script>



@endsection