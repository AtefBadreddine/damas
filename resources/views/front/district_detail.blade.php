<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
/* $arr_prices = [
  "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
  ]; */
$right = ($style_lang == 'ar' ? 'right' : 'left');
$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>

<style>

    .top_animate_sec{
        float: left;
        width: 100%;
        height: 970px;
        overflow: hidden;
        /*    background-image: url('/img/Background.jpg');
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-position: top;*/
        background: rgb(0,25,45);
        background: linear-gradient( 
            180deg
            , #79b6b5 14%, #dcfffd 64%, #b1dedc 67%, #d5fffe 77%, #d0f7f6 100%);
    }
    .top_animate_sec .image_group,
    .top_animate_sec .container{
        height: 100%;
        position: relative;
    }
    .top_animate_sec .image_group h1{
        position: absolute;
        top: 16%;
        color: #003837;
        font-size: 23px;
        left: 0px;
        width: 100%;
        text-align: center;
        line-height: 38px;
        margin: 0px;
    }
    .top_animate_sec .image_group h1 span{
        float: left;
        width: 100%;
        direction: rtl;
        opacity: 0;
        position: relative;
        left: -500%;
    }
    .top_animate_sec .image_group h1 span:nth-child(1){
        font-size: 40px;
        margin-bottom: 5px;
    }
    .top_animate_sec .image_group h1 span.animate{
        opacity: 1;
        left: 0%;
        transition: all 1s;
    }
    .top_animate_sec .image_group h1 span strong{
        direction: rtl;
        display: inline-block;
        position: relative;
        top: 3px;
        letter-spacing: 1px;
    }
    .cloud1{
        width: 45%;
        left: 10%;
        position: absolute;
        top: 48%;
        z-index: 99;
    }
    .cloud1.playing{
        -webkit-animation: cloud1 8s ease-in infinite alternate;
        -moz-animation: cloud1 8s ease-in infinite alternate;
        animation: cloud1 8s ease-in infinite alternate;
    }
    .cloud2{
        width: 40%;
        left: 40%;
        position: absolute;
        top: 30%;
        z-index: 9;
    }
    .cloud2.playing{
        -webkit-animation: cloud2 12s ease-in infinite alternate;
        -moz-animation: cloud2 12s ease-in infinite alternate;
        animation: cloud2 12s ease-in infinite alternate;
    }
    .cloud3{
        width: 40%;
        left: 60%;
        position: absolute;
        top: 35%;
        z-index: 99;
    }
    .cloud3.playing{
        -webkit-animation: cloud3 14s ease-in infinite alternate;
        -moz-animation: cloud3 14s ease-in infinite alternate;
        animation: cloud3 14s ease-in infinite alternate;
    }
    .top_animate_sec .image_group img{
        opacity: 0;
        height: auto;
    }
    .top_animate_sec .image_group img.passportB{
        height: 0px;
    }
    .top_animate_sec .image_group img.passportB.animate__fadeInUp{
        height: auto;
    }
    .top_animate_sec .image_group img.animate__fadeInUp,
    .top_animate_sec .image_group img.animate__fadeInRight,
    .top_animate_sec .image_group img.animate__fadeInTopLeft,
    .top_animate_sec .image_group img.animate__zoomIn{
        opacity: 1;
    }

    @-moz-keyframes cloud1 {
        from {
            left: 10%;
        }
        to {
            left: 20%;
        }
    }
    @-webkit-keyframes cloud1 {
        from {
            left: 10%;
        }
        to {
            left: 20%;
        }
    }
    @-o-keyframes cloud1 {
        from {
            left: 10%;
        }
        to {
            left: 20%;
        }
    }
    @keyframes cloud1 {
        from {
            left: 10%;
        }
        to {
            left: 20%;
        }
    }



    @-moz-keyframes cloud2 {
        from {
            left: 40%;
        }
        to {
            left: 10%;
        }
    }
    @-webkit-keyframes cloud2 {
        from {
            left: 40%;
        }
        to {
            left: 10%;
        }
    }
    @-o-keyframes cloud2 {
        from {
            left: 40%;
        }
        to {
            left: 40%;
        }
    }
    @keyframes cloud2 {
        from {
            left: 40%;
        }
        to {
            left: 10%;
        }
    }


    @-moz-keyframes cloud3 {
        from {
            left: 60%;
        }
        to {
            left: 20%;
        }
    }
    @-webkit-keyframes cloud3 {
        from {
            left: 60%;
        }
        to {
            left: 20%;
        }
    }
    @-o-keyframes cloud3 {
        from {
            left: 60%;
        }
        to {
            left: 20%;
        }
    }
    @keyframes cloud3 {
        from {
            left: 60%;
        }
        to {
            left: 20%;
        }
    }

    .istanbul_map{
        width: 100%;
        border-radius: 20px;
        margin-bottom: 50px;
        height: auto;
    }
    .int_content.faqContent {
        margin-top: 0px;
    }
    @media (max-width: 500px){
        .top_animate_sec {
            height: 500px;
            margin-top: 110px;
        }
        .top_animate_sec .image_group h1 {
            position: absolute;
            top: 12%;
            width: 100%;
            font-size: 22px;
            left: 0px;
            margin: 0px;
            text-align: center;
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
            font-size: 28px;
        }
        .top_animate_sec .image_group h1 span:nth-child(2) {
            top: -1px;
        }


    }
    .collapse.in{display:block}
</style>



<?php if (App::isLocal()) { ?>

    <?= Html::style("resources/assets/css/owl.carousel.min.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/faq.css"); ?>
    <?= Html::style("resources/assets/css/istanbul-districts.css"); ?>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("resources/assets/css/istanbul-districts-en.css"); ?>
    <?php } ?>




<?php } else { ?>

    <?= Html::style("css/istanbul-districts.min.css"); ?>
    <?= Html::style("css/owl.carousel.min.css"); ?>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("css/istanbul-districts-en.min.css"); ?>
    <?php } ?>

<?php } ?>






@endsection




@extends('front.layout', [
"page_title"        =>    $region->getH1(),
"page_description"  =>    $region->getSeoDescription(),
"page_keywords"     =>    $region->getSeoKeywords(),
"og_image"          =>    ($region->media?Helper::media_url_full($region->media):null),
/*"amp_url"           =>    route("amp.front.investment")*/
])


@section('main_content')


<div class="top_animate_sec">
    <div class="container">
        <div class="image_group">


            <h1 class="jazzira_font investment_page">
                <span><?= $region->getH1() ?></span>
            </h1>

            <img width="500" height="250" class="passportB animate__animated" src="<?= Helper::media_url($region->primaryphoto); ?>" alt="damasturk"/>
			
            
			<img width="200" height="100" class="cloud1 animate__animated" src="<?= asset("/img/cloud1.png"); ?>" alt="damasturk"/>
            <img width="200" height="100" class="cloud2 animate__animated" src="<?= asset("/img/cloud2.png"); ?>" alt="damasturk"/>
            <img width="200" height="100" class="cloud3 animate__animated" src="<?= asset("/img/cloud3.png"); ?>" alt="damasturk"/>
        </div>
    </div>
</div>




<div class="col-md-10 offset-md-1">
    <div class="full_sections">


        <div class="left_sec">


            <?php //if ($current_lang == 'ar') { ?>
                <div class="col-md-12">
			<img width="500" height="250" class="istanbul_map" src="{{ Helper::media_url($region->mapphoto) }}" alt="{{ $region->getName() }} Map" />
                </div>
            <?php //} ?>

            <?php /*if ($current_lang == 'en') { ?>
                <div class="col-md-12">
                    <img width="500" height="250" class="istanbul_map" src="{{ asset('img/istanbul-map-en.jpg') }}" alt="Istanbul Map - damasturk Real Estate" />
                </div>
            <?php } ?>


            <?php if ($current_lang == 'ru') { ?>
                <div class="col-md-12">
                    <img width="500" height="250" class="istanbul_map" src="{{ asset('img/istanbul-map-ru.jpg') }}" alt="Карта Стамбула - damasturk Недвижимость" />
                </div>
            <?php }*/ ?>


            <!-- Slider Pages links -->
            @include("front.partials.slider_pages_links")
            <!-- Slider Pages links -->



            <?php
            if ($region->getPost1) {
                $tpost = $region->getPost1->getCustomPost(true);
                $tpost_schema = $tpost;
                ?>

                <div class="col-md-12">
                    <h2 class="sub_title jazzira_font_bold text_sec_title"><?= $tpost['title'] ?></h2>
                    <div class="content_section">
                        <div  id="about-content">
                            <?= $tpost['content'] ?>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <?php
//$post_projects = $post->projects; آخر خمسة مشاريع عقارات المنطقة
            //$arr_ids = Helper::query("Fotterproject", "all")->lists('project_id')->toArray();
            $last_prjs = \App\Models\Project::where('published', '1')->where('sold', '!=', '100')->where('region_id', $region->id)->orderBy('id', 'desc')->limit(5)->get();
            if (count($last_prjs)>0) {
                ?>
                            <!--                <h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.projects"); ?></h2>-->
                <h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.The latest real estate projects in") .' '. $region->getName(); ?></h2>


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

                        <a href="{{ route('front.search', ['property-for-sale', $region->city->slug,$region->slug]) }}" class="more shadow_type" title="<?= trans("front.districts title one property for sale in") .' '. $region->getName(); ?>"><?= trans("front.districts title one property for sale in") .' '. $region->getName() ?></a>

                    </div>

                </div>
            <?php } ?>


            <?php
            if ($region->getPost2) {
                $tpost = $region->getPost2->getCustomPost(true);
                ?>
                <div class="col-md-12">
                    <h2 class="sub_title jazzira_font_bold text_sec_title"><?= $tpost['title'] ?></h2>
                    <div class="content_section">
                        <div  id="about-content" class="cont">
                            <?= $tpost['content'] ?>
                        </div>
                        <div class="action_content">
                            <span class="show_more_btn"><?= trans("front.read more"); ?></span>
                            <span class="show_less_btn"><?= trans("front.read less"); ?></span>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <?php
//$post_projects = $post->projects; آخر خمسة مشاريع شقق في المنطقة
            $last_prjs = \App\Models\Project::where('published', '1')->where('sold', '!=', '100')->where('region_id', $region->id)
                            ->whereIn("projects.id", function($q_typ) {
                                $q_typ->select("project_id")->from("project_type")->where("project_type_id", '3');
                            })->orderBy('id', "desc")->limit(5)->get();
            if (count($last_prjs)>0) {
                ?>
                <!--<h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.projects"); ?></h2>-->
                <h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.The latest apartment projects in") .' '. $region->getName() ?></h2>


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

                        <a href="{{ route('front.search', ['apartments-for-sale',$region->city->slug,$region->slug]) }}" class="more shadow_type" title="<?= trans("front.districts title two apartments for sale in") . ' '. $region->getName(); ?>"><?= trans("front.districts title two apartments for sale in") . ' '. $region->getName(); ?></a>

                    </div>

                </div>
            <?php } ?>



            <?php //if (Helper::get_device() == 'mob') { ?>
            <section class="form shadow_type mob_form">
                @include("front.partials.call_us_fixed")
            </section>
            <?php //} ?>




            <?php
            if (isset($region)) {
                $reg = $region;
                ?>
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-12 district_photos">
                            <h2 class="sub_title jazzira_font_bold"><?= trans("front.photos"); ?> <?= $reg->getTitlePg() ?></h2>

                            <div class="owl-carousel">
                                <?php foreach ($reg->regionphotos as $img) { ?>
                                    <div><a data-fancybox="<?= $reg->slug ?>" href="<?= Helper::media_url($img) ?>"><img src="<?= Helper::get_thumbnail_full($img, 301, 226); ?>" alt="<?= $img->getTitle() ?>"></a></div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>

            <?php } ?>





            <!-- Slider Other district in same city -->
            @include("front.partials.slider_other_districts")
            <!-- Slider Other district in same city -->






            <?php
            if (isset($regions[1])) {
                $reg = $regions[1];
                ?>
                <!--                <div class="col-md-12">
                                    <div class="row">
                
                                        <div class="col-md-12">
                
                                            <div class="offer_sec two">
                
                                                <h2 class="jazzira_font_bold"><?= $reg->getTitlePg() ?></h2>
                
                                                {!! Helper::get_pic(Helper::get_thumbnail($reg->primaryphoto, 727, 528),'lazy img-responsive','','',(isset($cardphoto)?$cardphoto->getTitle():'')) !!}
                
                
                <?= $reg->getDescriptionPg() ?>
                
                                                <a class="more" href="<?= route("front.search", ["property-for-sale", $city->slug, $reg->slug]) ?>"><?= trans("front.District projects"); ?>
                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 25 26" xml:space="preserve"><g> <path class="st0" d="M4.6,5.2l6.6,2l0.3-1.1L4.5,4L1.4,5.8l0.6,1L4.6,5.2z M4.6,5.2"></path> <path class="st0" d="M4.6,7.2l6.6,2l0.3-1.1L4.5,6L1.4,7.8l0.6,1L4.6,7.2z M4.6,7.2"></path> <path class="st0" d="M4.6,9.2l6.6,2l0.3-1.1L4.5,8L1.4,9.8l0.6,1L4.6,9.2z M4.6,9.2"></path> <path class="st0" d="M4.6,11.2l6.6,2l0.3-1.1L4.5,9.9l-3.1,1.8l0.6,1L4.6,11.2z M4.6,11.2"></path> <path class="st0" d="M4.6,13.2l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,13.2z M4.6,13.2"></path> <path class="st0" d="M4.6,15.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,15.1z M4.6,15.1"></path> <path class="st0" d="M4.6,17.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,17.1z M4.6,17.1"></path> <path class="st0" d="M4.6,19.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,19.1z M4.6,19.1"></path> <path class="st0" d="M15.4,5.2l6.6,2l0.3-1.1L15.3,4l-3.1,1.8l0.6,1L15.4,5.2z M15.4,5.2"></path> <path class="st0" d="M15.4,3.2l6.6,2l0.3-1.1L15.3,2l-3.1,1.8l0.6,1L15.4,3.2z M15.4,3.2"></path> <path class="st0" d="M15.4,1.2l6.6,2l0.3-1.1L15.3,0l-3.1,1.8l0.6,1L15.4,1.2z M15.4,1.2"></path> <path class="st0" d="M15.4,7.2l6.6,2l0.3-1.1L15.3,6l-3.1,1.8l0.6,1L15.4,7.2z M15.4,7.2"></path> <path class="st0" d="M15.4,9.2l6.6,2l0.3-1.1L15.3,8l-3.1,1.8l0.6,1L15.4,9.2z M15.4,9.2"></path> <path class="st0" d="M15.4,11.2l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,11.2z M15.4,11.2"></path> <path class="st0" d="M15.4,13.2l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,13.2z M15.4,13.2"></path> <path class="st0" d="M15.4,15.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,15.1z M15.4,15.1"></path> <path class="st0" d="M15.4,17.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,17.1z M15.4,17.1"></path> <path class="st0" d="M15.4,19.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,19.1z M15.4,19.1"></path> <path class="st0" d="M22,24.9v-1.9l0.3-1l-7.1-2.1l-3.1,1.8l0.3,0.5v2.7h-1.2v-1.9l0.3-1l-7.1-2.1l-3.1,1.8l0.3,0.5v2.7H0V26h25 v-1.1H22z M6.1,24.9v-2.3l3.5,0.8v1.5H6.1z M16.9,24.9v-2.3l3.5,0.8v1.5H16.9z M16.9,24.9"></path> </g> </svg>
                                                </a>
                
                                            </div>
                
                                        </div>
                
                
                
                
                                        <div class="col-md-12 district_photos">
                                            <h2 class="sub_title jazzira_font_bold"><?= trans("front.photos"); ?> <?= $reg->getTitlePg() ?></h2>
                
                
                                            <div class="owl-carousel">
                <?php foreach ($reg->regionphotos as $img) { ?>
                                                                        <div><a data-fancybox="<?= $reg->slug ?>" href="<?= Helper::media_url($img) ?>"><img src="<?= Helper::get_thumbnail_full($img, 301, 226); ?>" alt="<?= $img->getTitle() ?>"></a></div>
                <?php } ?>
                                            </div>
                
                
                                        </div>
                
                                    </div>
                                </div>-->
            <?php } ?>


            <!-- Out Link Section -->
            <!--            <div class="col-md-12">
                            <div class="row">
                                <div class="space_link living_out_link">
                                    <div class="content">
                                        <p><?= trans("front.LivingTurkey"); ?></p>
                                        <img class="icon" src="<?= asset("/img/out-link-button1.svg"); ?>" alt="damasturk"/>
                                    </div>
                                </div>
                            </div>
                        </div> -->
            <!-- Out Link Section -->







            <?php //if (Helper::get_device() == 'mob') { ?>
            <section class="form shadow_type mob_form">
                @include("front.partials.call_us_fixed")
            </section>
            <?php //} ?>


            <?php /*
              <!--            <div class="col-md-12 inverse">

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

              </div>-->
             */ ?>

            <!--            <div class="col-md-12">
                            <div class="row">
                                @include("front.partials.share_links", [])
                            </div>
                        </div>
            
                        <div class="col-md-12">
                            <div class="row">
                                @include("front.partials.subscribe_youtube", [])
                            </div>
                        </div>-->

            <div class="col-md-12 faq_sec margin_bottom_20">
                <div class="row">
                    <div class="col-md-12">
                        <div class="int_content shadow_type faqContent">

                            <img class="icon" src="<?= asset("/img/faqIcon.png"); ?>" alt="damasturk"/>


                            <h2 class="jazzira_font_bold faq_title"><?= trans("front.FAQ about"); ?> <?= trans("front.DistrictsIstanbul") .' '. $region->getName(); ?></h2>



                            <section class="faq-section sec">

                                <!-- ***** FAQ Start    هنا الاسئلة الشائعة عن المنطقة ***** -->
                                <div class="faq sec" id="accordion">


                                    <?php
                                    $faqs = DB::select("select * from dms_faq where faq_post=?  order by id asc LIMIT 10", [$region->faq_category_id]);

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
                              $faqs = DB::select("select * from dms_faq where faq_post=?  order by id asc LIMIT 3", [7]);

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
                              </ul>


                              <div class="col-md-12">
                              <a class="more green" href="<?= route("front.faq_show", ["districts-istanbul"]) ?>"><?= trans("front.view more"); ?></a>
                              </div>-->
                             */ ?>

                        </div>
                    </div>

                </div>
            </div>


            <?php /*
              <!--            <div class="col-md-12">
              @include("front.partials.testimonials_slider", [])
              </div>-->
             */ ?>
            @include("front.partials.top_visited_posts", ['cat_id'=>6])


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
<!--<script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0112/6578.js" async="async" ></script>-->
<!--<?= Html::script("js/swiper.min.js"); ?>-->
<?= Html::script("js/owl.carousel.min.js"); ?>



<script>


    $(document).ready(function () {
        var decisionPhotoH = $('.decision-photo').height() - 20;
        $(".decision-arabic").css("max-height", decisionPhotoH);
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
            cloud1.css({'margin-top': y / 50, 'margin-left': x / 50});
            cloud2.css({'margin-top': y / 40, 'margin-left': x / 40});
            cloud3.css({'margin-top': y / 30, 'margin-left': x / 30});
            turkeyText.css({'margin-top': y / 60, 'margin-left': x / 60});
            turkFlag.css({'margin-top': y / 80, 'margin-left': x / 80});
            passportB.css({'margin-top': y / 100, 'margin-left': x / 100});
            H1.css({'margin-top': y / 70, 'margin-left': x / 70});
        });


    });



    var $owl = $('.owl-carousel');

    $owl.children().each(function (index) {
        $(this).attr('data-position', index); // NB: .attr() instead of .data()
    });

    $owl.owlCarousel({
        center: true,
        loop: true,
        items: 5,
        autoplay: true,
        autoplayTimeout: 5000,
        responsive: {
            0: {
                items: 3
            },

            600: {
                items: 3
            },

            1024: {
                items: 3
            },

            1366: {
                items: 3
            }
        }
    });





    /*
     
     
     //    $(document).on('click', '.owl-item>div', function () {
     //        // see https://owlcarousel2.github.io/OwlCarousel2/docs/api-events.html#to-owl-carousel
     //        var $speed = 300;  // in ms
     //        $owl.trigger('to.owl.carousel', [$(this).data('position'), $speed]);
     //    });
     */




    var counter = 1;

    $(".show_less_btn").hide();
    $(document).on("click", ".show_more_btn", function () {
        var thisSec = $(this).parents(".content_section");
        var thisContent = $(this).parents(".content_section").find(".cont");
        var thisActionContent = $(this).parents(".action_content");
        var lessBtn = $(this).parents(".action_content").find(".show_less_btn");
        if (counter == 1) {
            $(thisContent).animate({'max-height': '400px'}, 200);
            $('html, body').animate({
                scrollTop: $(thisSec).offset().top - 100
            }, 'slow');
            $(lessBtn).show();
            counter++;
            return true;

        } else if (counter == 2) {
            $(thisContent).animate({'max-height': '800px'}, 200);
            $('html, body').animate({
                scrollTop: $(thisSec).offset().top - 50
            }, 'slow');
            $(lessBtn).show();
            counter++;
            return true;

        } else if (counter == 3) {
            var height_div = $(thisContent).css({'max-height': 'initial'}).height();
            $(thisContent).animate({'max-height': height_div}, 200);
            $('html, body').animate({
                scrollTop: $(thisSec).offset().top + 250
            }, 'slow');
            $(this).hide();
            $(lessBtn).show();
            $(thisActionContent).addClass("type_less");
            return false;

        } else {
            counter = 1;
            return false;
        }


    });


    $(document).on("click", ".show_less_btn", function () {
        var thisSec = $(this).parents(".content_section");
        var thisContent = $(this).parents(".content_section").find(".cont");
        ;
        var thisActionContent = $(this).parents(".action_content");
        var moreBtn = $(this).parents(".action_content").find(".show_more_btn");
        $(thisContent).animate({'max-height': '230px'}, 300);
        $('html, body').animate({
            scrollTop: $(thisSec).offset().top - 100
        }, 'slow');
        counter = 1;
        $(thisActionContent).removeClass("type_less");
        setTimeout(function () {
            $(this).hide();
            $(moreBtn).show();
        }, 300);
    });


</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



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

<?php if (isset($tpost_schema)) { ?>
    <script data-schema="Article" type="application/ld+json">
        {
        "@context":"http://schema.org",
        "@type":"Article",
        "mainEntityOfPage":{
        "@type":"WebPage",
        "@id":"<?= str_replace('/public/', '/', Request::url()); ?>"
        },
        "headline":"{{ htmlentities($tpost_schema['title']) }}",
        "articleBody":"{{ htmlentities(strip_tags(html_entity_decode(@$tpost_schema['content']))) }}",
        "url":"<?= str_replace('/public/', '/', Request::url()); ?>",
        "image":{
        "@type":"ImageObject",
        "url":"{{ Helper::media_url($region->mapphoto) }}",
        "width":1200,
        "height":640
        },
        "articleSection":"{{ trans('front.DistrictsIstanbul') }}",
        "datePublished":"<?= date(DATE_ISO8601, strtotime($tpost_schema["createdAt"])) ?>",
        "dateModified":"<?= date(DATE_ISO8601, strtotime($tpost_schema["updatedAt"])) ?>",
        "author":{"@type":"Organization","name":"DamasTurk"},
        "publisher":{
        "@type":"Organization","name":"DamasTurk"
        }
        }
    </script>
<?php } ?>
<script type="application/ld+json">
    {
    "@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[

    {"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
    {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
    {"@type":"ListItem","position":3,"name":"{{ trans('front.istanbul districts') }}","item":"{{ route('front.districts','istanbul') }}"}


    ]
    }
</script>
@endsection