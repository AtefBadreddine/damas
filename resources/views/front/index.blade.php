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



$citys = App\Models\City::where('id', '!=', 2)->orderBy('placement', 'asc')->get();
?>




<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slick.css"); ?>
    <?= Html::style("resources/assets/css/slick-theme.css"); ?>
    <?= Html::style("resources/assets/css/bootstrap-multiselect.css"); ?>
    <?= Html::style("resources/assets/css/myChart.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/index.css"); ?>
    <?php if ($current_lang == 'en') { ?>

    <?php } ?>

<?php } else { ?>
    <?php // Html::style("css/index.min.css?v=05"); ?>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/index.min.css?v=05') }}">
    <style>
    <?php // include(public_path() . "/css/index.min.css");          ?>
    <?php //include(public_path() . "/css/index" . (Helper::get_device() != 'full' ? '-mob' : '') . ($style_lang == 'en' ? '-en' : '') . ".min.css");          ?>
    </style>
<?php } ?>


<style>
    @media (max-width: 480px){
        .left_sec .cities_section .cities_list li.small_muscat{
            width: 100%;
        }
    }
    .top_slider{
        background-image: url('/imgwebp/slider111.webp');
        background-size: cover;
        background-position: center;
        position: relative;
        height: 800px;
    }
    .top_slider .title{
        position: absolute;
        left: 50%;
        top: 41%;
        width: 635px;
        margin-left: -320px;
        color: #ffffff;
        text-align: center;
        direction: rtl;
        background-color: rgba(0,0,0,0.4);
        padding: 3px 0px 94px 0px;
        border-radius: 20px;
    }
    .top_slider .title h2{
        font-size: 30px;
        position: relative;
        top: 3px;
    }
    .top_slider .title p{
        font-size: 30px;
        margin: 25px 0px 0px 0px;
        position: relative;
        top: -4px;
        font-weight: 700; 
    }
    .explained_sec{
        position: absolute;
        top: 156px;
        <?= $current_lang == 'ar' ? 'right' : 'left' ?>: <?= $current_lang =='ar' ? '60px' : '200px' ?>;
        background-color: rgba(255,255,255,0.8);
        border-radius: 20px;
        width: 475px;
        height: auto;
        min-height: 136px;
        padding: 15px;
    }
    .explained_sec .title-flag{
        position: absolute;
        top: -15px;
        right: 10px;
        width: 170px;
        height: 75px;
        background-image: url("<?= asset("img/title-flag.svg"); ?>");
        transition: all 1s ease;
    }
    .explained_sec p{
        float: left;
        width: 100%;
        text-align: <?= $current_lang == 'ar' ? 'right' : 'left' ?>;
        padding-right: 196px;
        font-size: 17px;
        margin: 0px 0px 20px 0px;
        color: #000000;
    }
    .explained_sec h2{
        text-align: <?= $current_lang == 'ar' ? 'right' : 'left' ?>;
        font-size: <?= $current_lang == 'ar' ? '22px' : '17px' ?>;
        color: #333333;
        font-weight: bold;
        direction: rtl;
        line-height: 32px;
        margin: 0px;
        padding-right: 173px;
    }
    .explained_sec h2 span{
        margin: 0px 5px;
        font-family: 'Montserrat', sans-serif;
    }
    .explained_sec a{
        position: absolute;
        bottom: 30px;
        right: 36px;
        background-color: #616161;
        color: #ffffff;
        padding: 4px 27px 7px 27px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.5s;
    }
    .explained_sec a:hover{
        background-color: #17a8a9;
        -webkit-box-shadow: 1px 1px 3px 0px rgba(171,171,171,1);
        -moz-box-shadow: 1px 1px 3px 0px rgba(171,171,171,1);
        box-shadow: 1px 1px 3px 0px rgba(171,171,171,1);
        transition: all 0.5s;
    }

    .search_section{
        float: left;
        width: 100%;
        background-color: #ffffff;
        min-height: 178px;
        padding: 0px 0px 0px 85px;
        position: relative;
        z-index: 999;
        -webkit-box-shadow: 0px 5px 35px -5px rgb(9 4 0 / 10%);
        box-shadow: 0px 5px 35px -5px rgb(9 4 0 / 10%);
    }
    .search_section .color_bg_section{
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
        z-index: 9;
    }
    .search_section .color_bg_section:after{
        content: "";
        position: absolute;
        top: 0px;
        right: 0px;
        width: 30%;
        height: 100%;
        background-color: #17A8A9;
        background-image: url(/img/Pattern3.svg);
        background-repeat: no-repeat;
        background-size: 67%;
        background-position: bottom center;
    }
    .search_section .color_bg_section:before{
        content: "";
        position: absolute;
        top: 0px;
        left: 0px;
        width: 70%;
        height: 100%;
        background-color: #ffffff;
    }
    .search_section .right{
        float: right;
        width: 30%;
        position: relative;
        z-index: 99;
        background-color: #17A8A9;
        background-image: url(/img/Pattern4.svg);
        background-repeat: no-repeat;
        background-size: 85%;
        background-position: bottom center;
        padding: 75px 15px 15px 15px;
        text-align: center;
        min-height: 220px;
    }
    .search_section .left{
        float: left;
        width: 70%;
        position: relative;
        z-index: 99;
        padding: 60px 60px 0px 0px;
    }
    .search_section h2{
        float: left;
        width: 100%;
        text-align: center;
        color: #ffffff;
        font-size: 35px;
        margin: 0px 0px 10px 0px;
    }
    .search_section .form-group{
        float: right;
        width: 25%;
        padding: 0px 5px;
        margin-bottom: 0px;
        position: relative;
    }
    .search_section .form-group svg{
        position: absolute;
        right: 14px;
        width: 18px;
        top: 12px;
        z-index: 99;
    }
    .search_section .form-group svg path{
        fill: #808080;
    }
    .search_section .form-group.budget_group{
        width: 75%;
        clear: both;
    }
    .search_section .form-group.btn_sec{
        width: 25%;
        margin: 0px;
        padding-top: 8px;
    }
    .search_section .form-group.btn_sec .send_btn{
        width: 100%;
    }
    .search_section .form-group.btn_sec .send_btn{
        background-color: #0a8181;
        color: #ffffff;
        border: 0px;
        padding: 6px 35px;
        border-radius: 10px;
        font-size: 17px;
        transition: all 0.3s;
        cursor: pointer;
        outline: none !important;
        box-shadow: 0 0.875rem 1.8125rem -0.8125rem rgb(0 0 0 / 30%), 0 0.875rem 1.8125rem -0.8125rem rgb(23 168 169);
        background-image: linear-gradient( 
            90deg
            ,#02898a,#17a8a9);
    }
    .search_section .form-group.btn_sec .send_btn svg{
        width: 15px;
        position: relative;
        top: auto;
        right: auto;
    }
    .search_section .form-group.btn_sec .send_btn svg path{
        fill: #ffffff;
    }
    .search_section .form-group.btn_sec .send_btn:hover{
        -webkit-box-shadow: 0px 3px 29px 2px rgb(183 183 183);
        -moz-box-shadow: 0px 3px 29px 2px rgb(183 183 183);
        box-shadow: 0px 3px 29px 2px rgb(183 183 183);
        transition: all 0.3s;
    }
    .search_section .form-group .form-control{
        background-color: #ffffff;
        text-align: right;
        direction: rtl;
        margin-bottom: 10px;
        color: #808080;
        border: 1px solid #ababab;
        border-radius: 10px;
        height: 42px;
        line-height: 2;
        font-size: 13px;
    }
    .search_section .bootstrap-select .dropdown-toggle{
        background-color: transparent;
        text-align: right;
        direction: rtl;
        height: 100%;
        padding: 0px 35px 0px 10px;
        font-size: 16px;
    }
    .search_section #budgetMenu {
        height: 54px;
        padding: 0px 0px;
    }
    .search_section .bootstrap-select.btn-group .dropdown-toggle .filter-option {
        text-align: right;
        direction: rtl;
        padding-top: 5px;
        color: dimgrey;
    }
    .search_section .bootstrap-select.btn-group .dropdown-toggle .caret {
        right: auto;
        left: 8px;
        color: gray;
    }
    .search_section .range-slider{
        position: relative;
        top: -5px;
    }
    .search_section .bootstrap-select.btn-group .dropdown-menu li a span.text {
        border-left: 5px;
        padding-left: 5px;
        float: right;
    }
    .search_section .range-slider .rangeValues {
        color: dimgrey;
        margin-bottom: 7px;
    }
    .search_section .range-slider .rangeValues p{
        float: none;
        width: auto;
        margin: 0px;
        display: inline-block;
    }
    .search_section .bootstrap-select>.dropdown-toggle.bs-placeholder, 
    .search_section .bootstrap-select>.dropdown-toggle.bs-placeholder:active,
    .search_section .bootstrap-select>.dropdown-toggle.bs-placeholder:focus, 
    .search_section .bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
        color: #868686;
    }
    .search_section .bootstrap-select.btn-group .dropdown-menu {
        max-height: 160px !important;
    }
    .search_section .bootstrap-select.btn-group .dropdown-menu ul li a {
        display: block;
        padding: 3px 10px;
    }


    .citizenship_sec_mob{
        float: left;
        width: 100%;
        position: relative;
        background-color: rgba(255,255,255,0.7);
        margin-bottom: 0px;
        text-align: center;
        -webkit-box-shadow: 0px 5px 35px -5px rgb(9 4 0 / 10%);
        box-shadow: 0px 5px 35px -5px rgb(9 4 0 / 10%);
        margin-top: -210px;
    }
    .citizenship_sec_mob h2{
        float: left;
        width: 100%;
        padding: 5px;
        color: #333333;
        font-size: <?= $current_lang == 'ar' ? '25px' : '18px'; ?>;
        margin: 0px;
        text-align: center;
        margin-top: 60px;
        margin-bottom: 3px;
    }
    .citizenship_sec_mob p{
        float: left;
        width: 100%;
        padding: 0px 10px 10px 10px;
        color: #333333;
        font-size: 18px;
        text-align: center;
        margin: 0px 0px 10px 0px;
        direction: rtl;
    }
    .citizenship_sec_mob .title_flag{
        position: absolute;
        top: -16px;
        width: 180px;
        height: 80px;
        left: 50%;
        margin-left: -90px;
        transition: all 1s ease;
        background-image: url("<?= asset("img/title-flag.svg"); ?>");
    }
    .citizenship_sec_mob a{
        background-color: #616161;
        color: #ffffff;
        border-radius: 10px;
        display: inline-block;
        margin-bottom: 20px;
        font-size: 16px;
        text-decoration: none;
        padding: 8px 30px 8px 30px;
    }
    .advanced_search_sec{
        position: absolute;
        top: 53%;
        width: 600px;
        left: 50%;
        margin-left: -300px;
        background-color: rgba(255,255,255,0.7);
        padding: 10px;
        border-radius: 40px;
    }
    .advanced_search_sec .search_icon{
        position: absolute;
        width: 20px;
        top: 27px;
        right: 21px;
    }
    .advanced_search_sec .search_icon path{
        fill: #757575;
    }
    .advanced_search_sec input{
        float: right;
        width: calc(100% - 55px);
        border: 0px;
        border-radius: 30px;
        height: 50px;
        -webkit-box-shadow: 0px 3px 6px 0px rgb(171 171 171 / 50%);
        -moz-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);
        box-shadow: 0px 3px 6px 0px rgb(171 171 171 / 50%);
        text-align: right;
        direction: rtl;
        line-height: 2;
        padding: 10px 40px 14px 25px;
        outline: none;
    }
    .advanced_search_sec button{
        width: 50px;
        border: 0px;
        height: 50px;
        background-color: #17A8A9;
        border-radius: 100%;
        text-align: center;   
        padding: 4px 3px 0px 0px;
        cursor: pointer;
    }
    .advanced_search_sec button svg{
        width: 20px;
    }
    .advanced_search_sec button svg path{
        fill: #ffffff;
    }

    #turkish-citizenship{
        margin-top: 15px;
    }
    .sub_title {
        margin: 0px;
        padding: 0px 5px;
    }
    #turkish-citizenship .sub_title {
        padding: 0px 0px;
    }
    .about .right_sec p {
        line-height: 22px;
        font-size: 13px;
    }
    .citizenship_sec_mob{
        display: none;
    }

    .statistics_sec{
        float: left;
        width: calc(100% + 12px);
        left: -6px;
        position: relative;
    }
    .search_section .bootstrap-select.btn-group .dropdown-menu ul li:nth-child(1) a{
        background-color: #cccccc;
    }
    .search_section .bootstrap-select.btn-group .dropdown-menu ul li a {
        font-size: 15px;
        direction: rtl;
    }

    #turkish-citizenship .slider__controls{
        position: relative;
        top: 0px;
    }


    @media (max-width: 1024px){
        .explained_sec{
            display: none;
        }
        .citizenship_sec_mob{
            display: block;
        }

    }
    @media (max-width: 991px){
        .search_section {
            padding: 0px 0px 0px 60px;
        }
        .search_section .left {
            padding: 44px 15px 0px 0px;
        }
    }
    @media (max-width: 812px){
        .top_slider .title {
            position: absolute;
            left: 0px;
            top: 14%;
            width: 100%;
            height: 412px;
            margin-left: 0px;
            color: #ffffff;
            text-align: center;
            direction: rtl;
            padding: 206px 0px 62px 0px;
            border-radius: 0px;
            background-image: linear-gradient(to bottom, rgba(255, 255 ,255 ,0) 0,rgba(2, 57, 80, 0.6) 70%, rgba(255, 255 ,255 ,0) 100%);
            background: -moz-linear-gradient(to bottom, rgba(255, 255 ,255 ,0) 0,rgba(2, 57, 80, 0.6) 70%, rgba(255, 255 ,255 ,0) 100%);
            background: -webkit-gradient(to bottom, color-stop(0%,rgba(255, 255 ,255 ,0)), color-stop(60%,rgba(2, 57, 80, 0.6)) , color-stop(100%,rgba(255, 255 ,255 ,0)));
            background: -webkit-linear-gradient(to bottom,rgba(255, 255 ,255 ,0) 0, (2, 57, 80, 0.6) 60%, (255, 255 ,255 ,0) 100%);
            background-color: transparent;
        }
        .search_section .right {
            width: 100%;
            background-color: #17A8A9;
            padding: 10px 0px;
            min-height: 120px;
            background-size: 33%;
        }
        .search_section h2 {
            margin: 23px 0px 10px 0px;
        }
        .search_section .left {
            width: 100%;
            padding: 15px 10px 10px 10px;
        }
        .search_section .form-group {
            width: 50%;
        }
        .search_section {
            padding: 0px 0px 50px 0px;
        }
        .advanced_search_sec {
            top: 52%;
            width: 400px;
            margin-left: -200px;
        }
        #turkish-citizenship .more_btn {
            position: relative;
            top: -25px;
        }
        #right-button, #left-button {
            display: none;
        }
        .cities_section .sub_title {
            text-align: center;
        }
        .sub_title {
            text-align: center;
            width: 100%;
        }
    }
    @media (max-width: 480px){
        .search_section .color_bg_section {
            display: none;
        }
        .search_section .col-md-10.offset-md-1 {
            width: 100%;
            max-width: 100%;
            padding: 0px;
        }
        .search_section {
            padding: 0px;
        }
        .search_section .right {
            width: 100%;
            background-color: #17A8A9;
            padding: 10px 0px;
            min-height: 90px;
            background-size: 46%;
        }
        .search_section .left {
            width: 100%;
            padding: 15px 10px 10px 10px;
        }
        .search_section h2 {
            text-align: center;
        }
        .search_section .form-group {
            width: 50%;
        }
        .search_section .form-group.budget_group{
            width: 100%;
            margin-top: 5px;
        }
        .search_section .form-group.btn_sec {
            width: 100%;
            margin: 0px 0px;
            padding-top: 0px;
            position: relative;
            left: 0px;
            bottom: 0px;
            text-align: center;
        }
        .search_section .form-group.btn_sec .send_btn {
            width: 100%;
            margin-bottom: 10px;
            padding: 9px 70px; 
            border-radius: 10px;
            webkit-box-shadow: 0px 3px 6px 0px rgb(171 171 171 / 50%);
            -moz-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);
            box-shadow: 0px 3px 6px 0px rgb(171 171 171 / 50%);
        }
        .search_section h2 span {
            float: none;
            width: auto;
        }
        .search_section h2 {
            font-size: 27px;
            margin-top: 19px;
        }
        .explained_sec {
            top: 140px;
            right: 5%;
            width: 90%;
            height: auto;
            min-width: 90%;
            min-height: 150px;
            padding: 15px;
        }
        .explained_sec p {
            padding-right: 0px;
            font-size: 17px;
            margin: 34px 0px 10px 0px;
        }
        .explained_sec h2 {
            float: right;
            width: 100%;
            font-size: 20px;
            line-height: 27px;
            margin: 0px;
        }
        .explained_sec a {
            float: left;
            position: relative;
            bottom: auto;
            left: auto;
            font-size: 15px;
        }
        .explained_sec .title-flag {
            top: -12px;
            width: 140px;
        }
        .top_slider {
            background-image: url(/img/sliderMobile33.jpg) !important;
            background-position: bottom;
            margin-top: 98px;
            height: 736px;
        }
        .search_section .form-group .form-control {
            height: 37px;
        }
        .search_section .bootstrap-select.btn-group .dropdown-toggle .filter-option {
            padding-top: 5px;
        }
        .fast_search {
            display: none;
        }
        .advanced_search_sec{
            width: 90%;
            left: 5%;
            margin: 0px;
            top: 40%;
        }
        .advanced_search_sec input {
            height: 40px;
            width: calc(100% - 45px);
        }
        .advanced_search_sec button {
            width: 40px;
            height: 40px;
        }
        .advanced_search_sec .search_icon {
            position: absolute;
            width: 20px;
            top: 22px;
            right: 21px;
        }
        .top_slider .title {
            position: absolute;
            left: 0px;
            top: 14%;
            width: 100%;
            height: 300px;
            margin-left: 0px;
            color: #ffffff;
            text-align: center;
            direction: rtl;
            padding: 96px 0px 0px 0px;
            border-radius: 0px;
            background-image: linear-gradient(to bottom, rgba(255, 255 ,255 ,0) 0,rgba(2, 57, 80, 0.6) 70%, rgba(255, 255 ,255 ,0) 100%);
            background-color: transparent;
        }
        .top_slider .title p {
            font-size: 22px;
            margin: 0px;
            position: relative;
            top: 2px;
            text-shadow: 0px 0px 8px rgba(0, 0, 0, 1);
        }
        .top_slider .title h2 {
            font-size: 22px;
            position: relative;
            top: 3px;
            margin: 0px;
            text-shadow: 0px 0px 8px rgba(0, 0, 0, 1);
        }
        .left_sec {
            margin-top: 40px;
        }
    }
</style>
@endsection




@extends('front.layout', [
'hide_onesignal'=>true,
"page_description" => $infos->seo_description,
"page_keywords" => $infos->seo_keywords,
"amp_url"  =>  route("amp.front.index"),
"og_image"          =>   Helper::media_mob(Helper::query("Media", "find", ["id" => $infos->index_og_pic])),
])


@section('main_content')




<div class="full_content sec">
    <h1 class="hidden"><?= trans("front.company name") ?></h1>
<div class="top_slider sec" >
<?php /* style="background-image: url('<?php
if(Helper::get_device()=='mob'){
//echo strpos( @$_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ?'/imgwebp/sliderMobile33.webp':'/img/sliderMobile33.jpg';
echo '/img/sliderMobile33.jpg';
}else{
echo strpos( @$_SERVER['HTTP_ACCEPT'], 'image/webp' ) !== false ?'/imgwebp/slider111.webp':'/img/slider111.jpg';
}
?>');"*/ ?>


        <?php //@if (Helper::get_device() != 'mob') ?>
        <!--<div class="explained_sec">-->
        <!--    <img width="170" height="75" class="title-flag" src="<?= asset("img/title-flag.svg"); ?>" alt="damasturk"/>-->
        <!--    <h2 class="jazzira_font_bold"><?= trans("front.Home Slider Title full") ?></h2>-->
        <!--    <a href="{{ route('front.turkish_citizenship') }}"><?= trans("front.details") ?></a>-->
        <!--</div>-->
        <div class="explained_sec">
            <div class="title-flag" id="desktop-changing-flag"></div>
            <h2 class="jazzira_font_bold" id="desktop-flag-h2"><?= trans("front.Home Slider Title full") ?></h2>
            <a href="{{ route('front.turkish_citizenship') }}" id="desktop-flag-btn"><?= trans("front.details") ?></a>
        </div>
        <script>
            (() => {
                const flagPhoto = document.getElementById("desktop-changing-flag");
                const flagBtn = document.getElementById("desktop-flag-btn");
                const flagH2 = document.getElementById("desktop-flag-h2");
                let isOman = false;
                setInterval(() => {
                    isOman = !isOman;
                    flagPhoto.style.backgroundImage = isOman ? "url('<?= asset("img/title-flag-oman.svg"); ?>')" : "url('<?= asset("img/title-flag.svg"); ?>')";
                    flagBtn.href = isOman ? "{{ route('front.blog.post.show', ['country' => 'oman', 'post' => 'property-residency']) }}" : "{{ route('front.turkish_citizenship') }}";
                    flagH2.innerHTML = isOman ? "<?= trans("front.Home Slider Title Full Oman"); ?>" : "<?= trans("front.Home Slider Title full") ?>";
                }, 5000);
            })();
        </script>
        <?php //@endif ?>



        <div class="title">
            <p><?= trans("front.search title one"); ?></p>
        </div>

        <div class="advanced_search_sec">
            <form action="<?= route("front.searchpage"); ?>">
                <button class="srhbtn">
                    <svg width='20' height='20' version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 19.59 18.63" style="enable-background:new 0 0 19.59 18.63;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><g> <path class="st0" d="M2.1,9.28C2.78,9.25,3.45,9.2,4.13,9.17c3.12-0.17,6.25-0.35,9.37-0.52c0.99-0.06,1.98-0.11,2.97-0.16 c0.28-0.01,0.3-0.14,0.41-0.9c0.3-2.19,1.04-4.3,2.19-6.19c0.49-0.8,0.65-0.98,0.4-1.15c-0.44-0.31-0.92-0.31-1.39-0.11 c-1.56,0.67-3.13,1.34-4.68,2.03C9.97,3.69,6.54,5.22,3.24,7C2.35,7.47,1.51,8.03,0.66,8.57c-0.2,0.12-0.36,0.3-0.52,0.47 c-0.18,0.18-0.18,0.38-0.01,0.55c0.18,0.18,0.35,0.38,0.56,0.5c1.16,0.7,2.31,1.43,3.51,2.04c4.52,2.33,9.18,4.35,13.85,6.35 c0.47,0.2,0.94,0.21,1.39-0.08c0.13-0.09,0.18-0.17,0.12-0.34c-0.96-2.63-1.92-5.27-2.88-7.91c-2.6-0.14-5.2-0.28-7.8-0.43 c-2.2-0.12-4.41-0.24-6.61-0.37c-0.06,0-0.11-0.02-0.17-0.02C2.1,9.32,2.1,9.3,2.1,9.28z"/> </g> </svg>
                </button>
                <input type="text" name="s" required  autocomplete="off" placeholder="<?= trans("front.search title two"); ?>" style="<?= (($current_lang==='en')&&($is_mobile == true))?'padding:10px 20px 11px 40px;font-size:0.75em':'' ?>" />
                <svg width='20' height='20' class="search_icon" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 26.15 22.4" xml:space="preserve"><path class="st0" d="M24.72,20.5l-6.2-6c1.2-1.5,1.9-3.4,1.9-5.5c0-4.9-4.1-9-9.2-9s-9.2,4-9.2,9c0,4.9,4.1,9,9.2,9 c2.1,0,4.1-0.7,5.6-1.9l6.2,6c0.2,0.2,0.5,0.3,0.8,0.3s0.6-0.1,0.8-0.3C25.22,21.6,25.22,20.9,24.72,20.5z M4.42,8.9 c0-3.7,3.1-6.7,6.9-6.7s6.9,3,6.9,6.7c0,1.8-0.8,3.5-2,4.7l0,0l0,0c-1.2,1.2-3,2-4.8,2C7.52,15.7,4.42,12.7,4.42,8.9z"/> </svg>
            </form>
        </div>

    </div>




    <div class="citizenship_sec_mob">
        <div class="title_flag" alt="damasturk" id="changing-flag"></div>
        <h2 class="jazzira_font_bold" id="flag-h2"><?= trans("front.Home Slider Title full"); ?></h2>

        <a href="{{ route('front.turkish_citizenship') }}" id="flag-btn"><?= trans("front.details") ?></a>
    </div>
    <script>
        const flagPhoto = document.getElementById("changing-flag");
        const flagBtn = document.getElementById("flag-btn");
        const flagH2 = document.getElementById("flag-h2");
        let isOman = false;
        setInterval(() => {
            isOman = !isOman;
            flagPhoto.style.backgroundImage = isOman ? "url('<?= asset("img/title-flag-oman.svg"); ?>')" : "url('<?= asset("img/title-flag.svg"); ?>')";
            flagBtn.href = isOman ? "{{ route('front.blog.post.show', ['country' => 'oman', 'post' => 'property-residency']) }}" : "{{ route('front.turkish_citizenship') }}";
            flagH2.innerHTML = !isOman ? "<?= trans("front.Home Slider Title full"); ?>" : "<?= trans("front.Home Slider Title Full Oman"); ?>";
        }, 5000);
    </script>



    <div class="search_section">
        <!--        <div class="color_bg_section"></div>-->

        <div class="right">
            <h2>
                <?= trans("front.Discover your dream home") ?>
<!--                <span>مـنـزل</span>
                <span>أحـلامك</span>-->
            </h2>
        </div>
        <div class="left">
            @include("front.partials.index_filter")
        </div>
    </div>




    <div class="col-md-10 offset-md-1">
        <div class="full_sections">

            <!-- Start Left Section -->
            <div class="left_sec">

                <div class="int_content">




                    <?php
                    $sec_device = $is_mobile ? "mobile" : "desktop";
                    //$sections = Helper::query("Section", "orderByPlacement", ["device" => ["all", $sec_device],
                    $sections = \App\Models\Section::with('type')->with('position')->orderBy('placement')->whereIn("device", ["all", $sec_device])->get();
                    //with("projects")

                    /* $ProjectCategorys=Helper::query('ProjectCategory', 'all'); */
                    $ProjectCategorys = array();
                    ?>

                    @foreach($sections as $section)
                    <?php
                    $section_type = @$section->type->slug;
                    $i = 0;
                    ?>
                    @if($section_type == "projects")
                    <?php
                    $section_position = @$section->position->slug;
                    //$section_link = $section->section_link ?: route("front.search", ["property-for-sale", "istanbul"]);
                    ?>



                    <?php
                    $cat_slug = '';
                    if ($section_position == "featured_projects") {
                        if ($section->project_category) {
                            $category_row = Helper::query("ProjectCategory", "find", ["id" => ($section->project_category)]);
                            $cat_slug = $category_row->slug;
                            $projects = $category_row->projects()->with('cardphoto')->with('flavors')->where("published", 1)->limit($section->number_items)->orderBy("id", "DESC")->get();
                        } elseif ($section->latestproject == true) {
                            $projects = \App\Models\Project::where("published", 1)->orderBy('created_at', 'DESC')->with('cardphoto')->with('flavors')->limit($section->number_items)->get();
                        } else {
                            $projects = $section->projects()->where("published", 1)->with('cardphoto')->with('flavors')->limit($section->number_items)->get();
                        }
                    } else {
                        //$projects = Helper::query("Project", "latest", ["limit" => $section->number_items]);
                        $projects = \App\Models\Project::where("published", 1)->orderBy('created_at', 'DESC')->with('cardphoto')->with('flavors')->limit($section->number_items)->get();
                    }
                    ?>

                    <h2 class="sub_title jazzira_font_bold"><?= $section->getTitle(); ?><?php // trans("front.latest real estate complexes");                                           ?></h2>

                    <div class="wrapper sec">
                        <div class="slider" <?php if ($current_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>
                            <div class="slider__wrap swiper-wrapper scrollToLeft">
                                @foreach($projects as $project)
                                @include("front.partials.project_item", ["class" => "","page"=>"index",'open_blank'=>false])
                                @endforeach
                                <?php /* <div class="item swiper-slide project_card">
                                  <div class="content sec shadow_type">
                                  <div class="view_cont">

                                  <!-- image Project -->
                                  <div class="int_cont image show">
                                  <a href="<?= route('front.project.show', array('country' => 'turkiye', 'city' => 'istanbul', 'region' => 'mahmutbey', 'project' => 'apartments-for-sale-istanbul-mahmutbey-near-merto-2')) ?>"><img class="lazy" data-src="<?= asset("/img/01.jpg"); ?>" alt="damasturk"/></a>
                                  </div>

                                  <!-- map Project -->
                                  <div class="int_cont map">
                                  <iframe width="100%" height="200" frameborder="0" style="border:0" src="https://maps.google.com/maps?q=41.047033520949654,28.80995915175822&amp;hl=es;z=14&amp;output=embed"></iframe>
                                  </div>

                                  <!-- video Project -->
                                  <div class="int_cont video">
                                  <iframe class="player" width="100%" height="180" src="https://www.youtube.com/embed/nhhdq_9I5NU" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                  </div>
                                  </div>


                                  <div class="control_sec">

                                  <!-- Price Project -->
                                  <div class="num">  <strong>₺</strong> <span>1.800</span>.000 </div>

                                  <!-- image btn -->
                                  <div class="btn_style type_image active" rel="typeImage">
                                  <svg viewBox="0 0 16 16" id="941b7c6df16f1639c19993afa498088e" xmlns="http://www.w3.org/2000/svg"><path data-name="Image Icon copy 3" fill-rule="evenodd" d="M14 16H2a2 2 0 01-2-2V2a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2zm0-14H2v12h1.974l6.136-6.647a1.09 1.09 0 011.528-.086L14 9.373V2zm0 10.048l-3.023-2.7L6.687 14H14v-1.952zM6 8a2 2 0 112-2 2 2 0 01-2 2z"></path></svg>
                                  </div>
                                  <!-- video btn -->
                                  <div class="btn_style type_video" rel="typeVideo">
                                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 29.4 25" xml:space="preserve"><g> <path class="st0" d="M27.9,0H4.1H1.5C0.7,0,0,0.7,0,1.5v18.1c0,0.8,0.7,1.5,1.5,1.5h2.6H11V23H5c-0.3,0-0.5,0.2-0.5,0.5v1 C4.5,24.8,4.7,25,5,25h2.6h14.8c2.3,0,2.5-0.2,2.5-0.5v-1c0-0.3-0.2-0.5-0.5-0.5h-6v-1.9h9.5c0.8,0,1.5-0.7,1.5-1.5V1.5 C29.4,0.7,28.7,0,27.9,0z M27.5,18.9c0,0.2-0.2,0.4-0.4,0.4H2.2c-0.2,0-0.4-0.2-0.4-0.4V2.2C1.8,2,2,1.8,2.2,1.8h25 c0.2,0,0.4,0.2,0.4,0.4v16.7H27.5z"/> <path class="st0" d="M18.4,9.7L12,5.8c-0.7-0.4-1.5,0.1-1.5,0.9v7.8c0,0.8,0.9,1.3,1.5,0.9l6.4-3.9C19,11,19,10.1,18.4,9.7 L18.4,9.7z"/> </g> </svg>
                                  </div>
                                  <!-- map btn -->
                                  <div class="btn_style type_map" rel="typeMap">
                                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.5 20.4" xml:space="preserve"><g> <path class="st0" d="M7.7,0C3.5,0,0,3.5,0,7.7c0,1.8,1.2,4.3,3.6,7.6c1.7,2.4,3.4,4.3,3.5,4.4l0.6,0.7l0.6-0.7 c0.1-0.1,1.8-2,3.5-4.4c2.4-3.3,3.6-5.9,3.6-7.6C15.5,3.5,12,0,7.7,0L7.7,0z M7.7,17.9c-2.1-2.5-6-7.6-6-10.2c0-3.3,2.7-6,6-6 s6,2.7,6,6C13.8,10.3,9.9,15.4,7.7,17.9L7.7,17.9z M7.7,17.9"/> <path class="st0" d="M10.5,7.7c0,1.5-1.3,2.8-2.8,2.8S4.9,9.3,4.9,7.7s1.3-2.8,2.8-2.8S10.5,6.2,10.5,7.7L10.5,7.7z M10.5,7.7"/> </g> </svg>
                                  </div>

                                  <!-- Share Project -->
                                  <div class="dropdown share_sec">
                                  <div class="btn_style share" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 18.2 18.2" xml:space="preserve"><path class="st0" d="M14.6,10.9c-1.3,0-2.4,0.7-3,1.6L7.2,10c0.2-0.6,0.2-1.3,0-1.9l4.4-2.5c0.7,1,1.8,1.6,3,1.6 c2,0,3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6c-2,0-3.6,1.6-3.6,3.6c0,0.2,0,0.3,0,0.5L6.4,6.7C5.1,5.2,2.8,5,1.3,6.3 c-1.5,1.3-1.7,3.6-0.4,5.1C2.2,13,4.5,13.2,6,11.9c0.2-0.1,0.3-0.3,0.4-0.4l4.6,2.6c0,0.2,0,0.3,0,0.5c0,2,1.6,3.6,3.6,3.6 c2,0,3.6-1.6,3.6-3.6C18.2,12.5,16.6,10.9,14.6,10.9z M14.6,1.6c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S13.5,1.6,14.6,1.6z M3.7,11.1c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S4.8,11.1,3.7,11.1z M14.6,16.5c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2 S15.7,16.5,14.6,16.5z"/> </svg>
                                  </div>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButtons">
                                  <a href="https://facebook.com/sharer.php?u=http://demo.damas.net/projects/ds269" class="btnshare bluring" data-network="facebook" target="_blank"><i class="fa fa-facebook"></i></a>
                                  <a href="https://api.whatsapp.com/send?text=http://demo.damas.net/projects/ds269  مجمع DS269 في اسطنبول" class="btnshare bluring" data-network="whatsapp" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg></a>
                                  </div>
                                  </div>

                                  </div>

                                  <div class="features_sec">
                                  <h2 class="project_name">مجمع بنظام الشقق الذكية وبإطلالة بحرية رائعة</h2>
                                  <ul>
                                  <li>

                                  <!-- اذا كان المشروع قيد الإنشاء-->
                                  <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.07 15.42" xml:space="preserve"><g> <g> <path class="st0" d="M15.07,14.11v-1c0-0.68-0.4-1.08-1.08-1.08H7.23c-0.91,0-1.38,0.43-1.38,1.08v1.3c0,0.67,0.45,1.01,1.38,1.01 h6.76C14.67,15.42,15.07,14.97,15.07,14.11L15.07,14.11z M13.84,14.19H7.07v-0.92h6.77V14.19z M13.84,14.19"/> <path class="st0" d="M9.84,4.96v2.94l0.39,1.05H9.57L3.14,0L1.72,0.85l0.43,0.75v3.97H1.7L2,7.73h0.15v0.65 C1.88,8.51,1.57,8.78,1.57,9.26c0,0.33,0.13,0.56,0.31,0.72l-1.67,1.44h0.47l1.48-1.27c0.13,0.05,0.28,0.08,0.42,0.08 c0.14,0,0.28-0.04,0.41-0.11l1.6,1.3h0.48l0,0L3.23,9.92c0.12-0.15,0.21-0.35,0.21-0.61c0-0.17-0.14-0.31-0.31-0.31 c-0.17,0-0.31,0.14-0.31,0.31c0,0.11-0.03,0.18-0.07,0.22L2.67,9.47c-0.06-0.05-0.14-0.05-0.2,0l-0.11,0.1 c-0.1-0.05-0.18-0.14-0.18-0.31c0-0.28,0.28-0.35,0.33-0.36c0.15-0.03,0.26-0.15,0.26-0.3V7.73h0.34l0.43-2.15H3.08V3.35l3.69,7.1 v0.36H8v0.61h4.61v-0.61h1.85V4.96H9.84z M7.18,6.56L7.18,6.56L5.93,7.39l0.65-1.66L7.18,6.56z M2.77,5.58H2.46V2.19l0.31,0.58 V5.58z M3.03,2.44L2.5,1.44l0.83-0.54L3.03,2.44z M3.76,1.52l0.59,1.02L3.39,3.16L3.76,1.52z M3.85,3.74l0.9-0.58L4.4,4.76 L3.85,3.74z M5.12,3.68l0.66,0.97L4.79,5.29L5.12,3.68z M5.02,6.02l1.11-0.76L5.5,6.95L5.02,6.02z M6.67,8.94L6.13,8l1.33-0.95 L6.67,8.94z M7.09,9.62L8,7.65l0.74,1.01L7.09,9.62z M13.22,8.04h-2.15V6.2h2.15V8.04z M13.22,8.04"/> <path class="st0" d="M0.31,13.27H0v0.62h4.92v-0.62H4.3v-0.92h0.62v-0.62H0v0.62h0.62v0.92H0.31z M0.31,13.27"/> </g> </g> </svg>
                                  <p class="num">04/2021</p>

                                  <?php /* <!-- إذا كان المشروع جاهز -->
                                  <!--                                                    <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.37 15.36" xml:space="preserve"><g> <g> <path class="st0" d="M3.31,14.16h10.46c-0.25,0.7-0.91,1.2-1.7,1.2H3.31c-0.99,0-1.8-0.81-1.8-1.8v-6.3L0.81,7.9L0,7.01L7.69,0 l6.28,5.73h-1.78l-4.5-4.11L2.71,6.17v7.4C2.71,13.89,2.98,14.16,3.31,14.16L3.31,14.16z M15.37,9.96c0,1.65-1.35,3-3,3 c-0.95,0-1.84-0.45-2.4-1.2h-4.5l-1.56-1.48v-0.6l1.56-1.52h4.51c0.56-0.75,1.45-1.2,2.4-1.2C14.02,6.96,15.37,8.31,15.37,9.96 L15.37,9.96z M14.17,9.96c0-0.99-0.81-1.8-1.8-1.8c-0.64,0-1.24,0.35-1.56,0.9l-0.17,0.3H5.95L5.33,9.97l0.62,0.59h0.86l0.78-0.83 l0.87,0.83h2.18l0.17,0.3c0.32,0.56,0.92,0.9,1.56,0.9C13.36,11.76,14.17,10.96,14.17,9.96L14.17,9.96z M12.97,9.36 c-0.33,0-0.6,0.27-0.6,0.6c0,0.33,0.27,0.6,0.6,0.6c0.33,0,0.6-0.27,0.6-0.6C13.57,9.63,13.3,9.36,12.97,9.36L12.97,9.36z M12.97,9.36"/> </g> </g> </svg>-->
                                  </li>
                                  <li>تقسيط</li>
                                  </ul>
                                  </div>


                                  </div>
                                  </div> */ ?>



                            </div>
                            <div class="slider__controls">

                                <div class="slider__pagination"></div>

                                <div class="slider__button-next"></div>
                                <div class="slider__button-prev"></div>
                            </div>


                            <a href="{{ route('front.search', ['property-for-sale', 'oman',$cat_slug]) }}" class="more shadow_type"><?= trans("front.More Projects"); ?></a>


                        </div>

                    </div>

                    @endif

                    <?php //$j++  ?>
                    @endforeach



                </div>


                <!-- share page links -->
                <?php //if (Helper::get_device() == 'mob') { ?> 
                    <div class="sec">
                        @include("front.partials.share_links", [])
                    </div>
                <?php //} ?>


                <div class="int_content">

                    <h2 class="sub_title jazzira_font_bold"><?= trans("front.Latest Videos"); ?></h2>


                    <div class="wrapper sec">

                        <div class="slider video_slider"  <?php if ($current_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>

                            <div class="slider__wrap swiper-wrapper">
                                <?php
                                //$videos = \App\Models\Video::where("lang", $current_lang)->limit(5)->orderBy('id', 'desc')->get();
                                $videos = DB::select("SELECT `dms_videos`.*
FROM `dms_videos` ,`dms_sectionvideo_video`
WHERE `dms_videos`.`id`= `dms_sectionvideo_video`.`video_id`and `dms_videos`.lang=?
group by `dms_videos`.id
order by id desc
limit 5", [($current_lang == 'pe' ? 'fa' : $current_lang)]);

                                if (count($videos) < 2) {
                                    $videos = DB::select("SELECT `dms_videos`.*
FROM `dms_videos` ,`dms_sectionvideo_video`
WHERE `dms_videos`.`id`= `dms_sectionvideo_video`.`video_id`and `dms_videos`.lang like ?
group by `dms_videos`.id
order by id desc
limit 5", ['%' . $current_lang . '%']);
                                }
                                ?>
                                @include("front.partials.videos", ['videos'=>$videos])

                            </div>

                            <div class="slider__controls">

                                <div class="slider__pagination"></div>

                                <div class="slider__button-next"></div>
                                <div class="slider__button-prev"></div>
                            </div>

                            <?php if (@session()->get("iso_country") != 'TR') { ?>
                                <a href="{{ route('front.video') }}" class="more shadow_type"><?= trans("front.more videos"); ?></a>
                            <?php } ?>
                        </div>

                    </div>




                </div>



                <!-- Turkish Citizenship -->
                <div class="int_content">
                    <div id="turkish-citizenship" class="section">
                        <div class="sub_section">
                            <h2 class="sub_title jazzira_font_bold"><?= trans("front.Stages of obtaining Turkish citizenship"); ?></h2>


                            <div class="wrapper sec">
                                <div id="steps" class="steps scrollbar slider">

                                    <div class="slider__wrap swiper-wrapper">
                                        <section class="step_one item swiper-slide">
                                            <div class="sub">
                                                <svg class="card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" style="width: 2.8em;fill: #888;"><path d="M320 128C241 128 175.3 185.3 162.3 260.7C171.6 257.7 181.6 256 192 256L208 256C234.5 256 256 277.5 256 304L256 400C256 426.5 234.5 448 208 448L192 448C139 448 96 405 96 352L96 288C96 164.3 196.3 64 320 64C443.7 64 544 164.3 544 288L544 456.1C544 522.4 490.2 576.1 423.9 576.1L336 576L304 576C277.5 576 256 554.5 256 528C256 501.5 277.5 480 304 480L336 480C362.5 480 384 501.5 384 528L384 528L424 528C463.8 528 496 495.8 496 456L496 435.1C481.9 443.3 465.5 447.9 448 447.9L432 447.9C405.5 447.9 384 426.4 384 399.9L384 303.9C384 277.4 405.5 255.9 432 255.9L448 255.9C458.4 255.9 468.3 257.5 477.7 260.6C464.7 185.3 399.1 127.9 320 127.9z"/>
                                                </svg>
                                                <h3><?= trans("front.Find your property"); ?></h3>
                                                <p>
                                                    <?= trans("front.Find your property text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">01</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </section>

                                        <section class="step_two item swiper-slide">
                                            <div class="sub">
                                                <div class="icon" style="background-position: -5px -548px;"></div>
                                                <h3><?= trans("front.Real estate appraisal"); ?></h3>
                                                <p>
                                                    <?= trans("front.Real estate appraisal text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">02</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </section>

                                        <section class="step_three item swiper-slide">
                                            <div class="sub">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="card-icon" style="width: 2.8em;fill: #888;">
                                                <path d="M300.9 149.2L184.3 278.8C179.7 283.9 179.9 291.8 184.8 296.7C215.3 327.2 264.8 327.2 295.3 296.7L327.1 264.9C331.3 260.7 336.6 258.4 342 258C348.8 257.4 355.8 259.7 361 264.9L537.6 440L608 384L608 96L496 160L472.2 144.1C456.4 133.6 437.9 128 418.9 128L348.5 128C347.4 128 346.2 128 345.1 128.1C328.2 129 312.3 136.6 300.9 149.2zM148.6 246.7L255.4 128L215.8 128C190.3 128 165.9 138.1 147.9 156.1L144 160L32 96L32 384L188.4 514.3C211.4 533.5 240.4 544 270.3 544L286 544L279 537C269.6 527.6 269.6 512.4 279 503.1C288.4 493.8 303.6 493.7 312.9 503.1L353.9 544.1L362.9 544.1C382 544.1 400.7 539.8 417.7 531.8L391 505C381.6 495.6 381.6 480.4 391 471.1C400.4 461.8 415.6 461.7 424.9 471.1L456.9 503.1L474.4 485.6C483.3 476.7 485.9 463.8 482 452.5L344.1 315.7L329.2 330.6C279.9 379.9 200.1 379.9 150.8 330.6C127.8 307.6 126.9 270.7 148.6 246.6z"></path>
                                            </svg>
                                            <h3><?= trans("front.Investor residence"); ?></h3>
                                                <p>
                                                    <?= trans("front.Investor residence text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">03</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </section>

                                        <section class="step_four item swiper-slide">
                                            <div class="sub">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="card-icon" style="width: 2.8em;fill: #888;"><path d="M32 160C32 124.7 60.7 96 96 96L544 96C579.3 96 608 124.7 608 160L32 160zM32 208L608 208L608 480C608 515.3 579.3 544 544 544L96 544C60.7 544 32 515.3 32 480L32 208zM279.3 480C299.5 480 314.6 460.6 301.7 445C287 427.3 264.8 416 240 416L176 416C151.2 416 129 427.3 114.3 445C101.4 460.6 116.5 480 136.7 480L279.2 480zM208 376C238.9 376 264 350.9 264 320C264 289.1 238.9 264 208 264C177.1 264 152 289.1 152 320C152 350.9 177.1 376 208 376zM392 272C378.7 272 368 282.7 368 296C368 309.3 378.7 320 392 320L504 320C517.3 320 528 309.3 528 296C528 282.7 517.3 272 504 272L392 272zM392 368C378.7 368 368 378.7 368 392C368 405.3 378.7 416 392 416L504 416C517.3 416 528 405.3 528 392C528 378.7 517.3 368 504 368L392 368z"/></svg>
                                                <h3><?= trans("front.Apply for citizenship"); ?></h3>
                                                <p>
                                                    <?= trans("front.Apply for citizenship text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">04</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </section>
                                    </div>

                                    <div class="slider__controls">

                                        <div class="slider__pagination"></div>

                                        <div class="slider__button-next"></div>
                                        <div class="slider__button-prev"></div>
                                    </div>

                                </div>
                            </div>


                            <a href="{{ route('front.turkish_citizenship') }}" class="more_btn shadow_type"><?= trans("front.more details"); ?></a>

                        </div>
                    </div>
                </div>




                <!-- Testimonials -->
                @include("front.partials.testimonials_slider", [])





                <div class="statistics_sec">
                    @include("front.partials.statistics_most", [])
                </div>


                <!-- share page links -->
                <?php //if (Helper::get_device() == 'mob') { ?> 
                    <div class="sec">
                        @include("front.partials.share_links", [])
                    </div>
                <?php //} ?>


                <div class="int_content cities_section shadow_type">

                    <h2 class="sub_title jazzira_font_bold"><?= trans("front.Featured cities"); ?></h2>

                    <ul class="cities_list">
                        <?php
                        ?>
                        <li class="big">
                            <a class="shadow_type" href="{{ route('front.search', ['property-for-sale', $projects_count[0]->slug]) }}">
                                <div class="image_cont">
                                    <div class="image">
                                        <img class="lazy" src="https://damas.net/uploads/istanbul-front.jpeg" alt="damasturk" />
                                    </div> 
                                </div>
                                <div class="title">
                                    <h3 class="jazzira_font_bold">{{ Helper::getCityName($projects_count,0) }}</h3>
                                    <p><span><?= trans("front.project"); ?></span><span class="num">{{ $projects_count[0]->cnt }}</span></p>
                                </div>
                            </a>
                        </li>

                        <li class="small_muscat">
                            <a class="shadow_type" href="{{ route('front.search', ['property-for-sale', $projects_count[4]->slug]) }}">
                                <div class="image_cont">
                                    <div class="image">
                                        <?php /* <img class="lazy" data-src="<?= Helper::media_url_full(Helper::query("Media", "find", ["id" => $projects_count[4]->media_index])) ?>" alt="damasturk" /> */ ?>
                                        <!--{!! Helper::get_pic(Helper::media_url_full(Helper::query("Media", "find", ["id" => $projects_count[4]->media_index])),'lazy','','','damasturk', '') !!}-->
                                            <img class="lazy" src="https://damas.net/img/oman-photo.jpg" alt="damasturk" />
                                    </div> 
                                </div>

                                <div class="title">
                                    <h3 class="jazzira_font_bold">{{ Helper::getCityName($projects_count,4) }}</h3>
                                    <p><span><?= trans("front.project"); ?></span><span class="num">{{ $projects_count[4]->cnt }}</span></p>
                                </div>
                            </a>
                        </li>

                    </ul>

                </div>




            </div>
            <!-- End Left Section -->


            <!-- Start Fixed Section -->
            <div class="right_sec">
                <div class="fixed_sec ">

                    <section class="form shadow_type">
                        @include("front.partials.call_us_fixed")
                    </section>

                    <!-- About Us -->
                    @include("front.partials.about_sec", [])

                </div>
            </div>
            <!-- End Fixed Section -->


        </div>
    </div>




</div>




@endsection




@section('scriptjs')
<?php if (App::isLocal()) { ?>
    <?= Html::script("resources/assets/js/myChart.js") ?>
    <?= Html::script("resources/assets/js/bootstrap-multiselect.js") ?>
    <!--<?= Html::script("resources/assets/js/swiper.min.js"); ?>-->
    <!--<?= Html::script("resources/assets/js/slick.min.js"); ?>-->
<?php } else { ?>
    <?php /* <!--<?= Html::script("js/main.min.js") ?>--> */ ?>

    <?php // Html::script("js/chartscripts.min.js") ?>
	<script type="text/javascript" src="{{ asset('js/chartscripts.min.js') }}?v=07" <?php //defer ?>></script>
    <?php /* <!--<?= Html::script("js/myChart.min.js") ?>
      <?= Html::script("js/bootstrap-multiselect.min.js") ?>
      <?= Html::script("js/swiper.min.js"); ?>
      <?= Html::script("js/slick.min.js"); ?>--> */ ?>
<?php } ?>

<?php //if (Helper::get_device() != 'mob') { ?>
    <script >
        document.querySelectorAll(".swiper-wrapper").forEach( element => {
            <?php if ($current_lang == 'ar') { ?>
                element.scrollLeft = -50; 
            <?php } else { ?>
                element.scrollLeft = 50; 
            <?php } ?>
        });
                            
<?php /*
function waitForScriptsLoaded2(){
if (window.jQuery) { */ ?>

$(document).ready(function () {
        
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
			
		}else{
			$(window).scroll(function () {
				var scrollingPage = $(window).height() * 0.8;
				var scrollingPage2 = $(window).height() - 90;
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
		}


<?php
$json3 = Helper::ajax_statics('', 'top_country', 0, 0);
$json4 = Helper::ajax_statics('', 'top_city', 0, 0);
?>

    display_most_nat_data(<?= json_encode($json3) ?>);
    display_most_city_data(<?= json_encode($json4) ?>);

    
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







    function getVals() {
        let parent = this.parentNode;
        let slides = parent.getElementsByTagName("input");
        let slide1 = parseFloat(slides[0].value);
        let slide2 = parseFloat(slides[1].value);
        if (slide1 > slide2) {
            let tmp = slide2;
            slide2 = slide1;
            slide1 = tmp;
        }

        let displayElement = parent.getElementsByClassName("rangeValues")[0];
        displayElement.innerHTML = "$" + slide1 + " - $" + slide2;
        $(".budget .dropdown .dropdown-toggle .number").text("$" + slide1 + " - $" + slide2);
    }

    window.onload = function () {
        let sliderSections = document.getElementsByClassName("range-slider");
        for (let x = 0; x < sliderSections.length; x++) {
            let sliders = sliderSections[x].getElementsByTagName("input");
            for (let y = 0; y < sliders.length; y++) {
                if (sliders[y].type === "range") {
                    sliders[y].oninput = getVals;
                    sliders[y].oninput();
                }
            }
        }
    };


    $(document).ready(function () {
        $('.main_menu .links>li>a.home_page').addClass("active");

        var homeFilter = window.homeFilterData;
        var PRICE_MIN = 50000, PRICE_MAX = 2000000;

        function findBySlug(list, slug) {
            for (var i = 0; i < list.length; i++) {
                if (list[i].slug === slug) {
                    return list[i];
                }
            }
            return null;
        }

        function fillSelect($select, placeholder, items) {
            $select.empty().append($('<option value=""></option>').text(placeholder));
            $.each(items, function (i, item) {
                $select.append($('<option></option>').val(item.slug).text(item.name));
            });
            $select.val('');
            $select.selectpicker('refresh');
        }

        $('body').on('change', '#form-search select[name=country]', function () {
            var frm = $(this).closest('form');
            var countryId = parseInt($(this).val(), 10);
            fillSelect(frm.find('select[name=city]'), homeFilter.cityLabel, $.grep(homeFilter.cities, function (c) {
                return c.country === countryId;
            }));
        });

        function homeFilterHasBudget(frm) {
            var min = parseInt(frm.find(".min_budj").val(), 10), max = parseInt(frm.find(".max_budj").val(), 10);
            if (min > max) { var t = min; min = max; max = t; }
            return min > PRICE_MIN || max < PRICE_MAX;
        }

        function homeFilterIsEmpty(frm) {
            return !frm.find("select[name=country]").val() &&
                !frm.find("select[name=city]").val() &&
                !frm.find("select[name=project_type]").val() &&
                !frm.find("select[name=rooms]").val() &&
                !homeFilterHasBudget(frm);
        }

        $('body').on("click", ".send_btn_index", function (e) {
            var frm = $(this).closest("form");

            if (homeFilterIsEmpty(frm)) {
                window.location.href = homeFilter.projectsUrl;
                return false;
            }

            var city = findBySlug(homeFilter.cities, frm.find("select[name=city]").val());
            var countryId = frm.find("select[name=country]").val();
            var url = city ? city.url : (countryId ? homeFilter.countryUrls[countryId] : homeFilter.projectsUrl);

            var params = [];
            var type = frm.find("select[name=project_type]").val();
            if (type) {
                params.push('type=' + encodeURIComponent(type));
            }
            var rooms = frm.find("select[name=rooms]").val();
            if (rooms) {
                params.push('rooms=' + encodeURIComponent(rooms));
            }
            if (homeFilterHasBudget(frm)) {
                var min = parseInt(frm.find(".min_budj").val(), 10), max = parseInt(frm.find(".max_budj").val(), 10);
                if (min > max) { var t = min; min = max; max = t; }
                params.push('price=' + encodeURIComponent(min + '-' + (max >= PRICE_MAX ? '+' : max)));
            }

            window.location.href = url + (params.length ? '?' + params.join('&') : '');
            return false;
        });
    });
		
		
<?php /*	
	}else{
        setTimeout(waitForScriptsLoaded2, 250);
    }
} */ ?>
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

@endsection