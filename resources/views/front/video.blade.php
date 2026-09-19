<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr','ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
/*$arr_prices = [
    "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
];*/
$right = ($style_lang == 'ar' ? 'right' : 'left');
//$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slick.css"); ?>
    <?= Html::style("resources/assets/css/slick-theme.css"); ?>
	<!--<?= Html::style("resources/assets/css/video.css"); ?>-->


<style>
    /** video css **/
     body {background-color: #f9f9f9;background-image: none;}.header.scrolling {background-color: #f9f9f9;background-image: none;}.fixed_sec.fixed {top: 131px;}.filter a{padding: 5px 15px;display:inline-block;color: #1a8b8b;background-color: rgba(23,168,169, 0.23);text-decoration:none;border-radius:9px;transition: all 0.4s;}.filter a.active, .filter a:hover{background: #1a8b8b;color: #ffffff;-webkit-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);-moz-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);transition: all 0.4s;}.filter{direction: rtl;padding: 0px;text-align:center }.sets{float: left;width: 100%;position: relative;overflow: hidden;padding: 0px;}.sets a img.video_photo{width:100%;height: auto;min-height: 170px;float:left;}.sets a{float:right;width:33.3333%;padding: 10px;transition:all 0.5s;display:block;opacity:1;}.sets a .item{float:right;width:100%;padding: 10px;background-color: #ffffff;border-radius: 15px;transition:all 0.5s;display:block;opacity:1;height:auto;}.sets .hide{width:0%;height: 0%;padding: 0px;opacity:0;transition:all 0.5s;}.pagination_sec {padding: 10px;width: calc(100% - 0px);left: 0px;margin-bottom: 15px;}.image_cont{float: left;width: 100%;border-radius: 10px;overflow: hidden;position: relative;}.image_cont:after{content: "";position: absolute;top: 0px;left: 0px;width: 100%;height: 100%;background-color: rgba(0,0,0,0.2);}.image_cont img.video_photo{width: 100%;transition: all 0.4s;}.sets a:hover .image_cont img.video_photo{transition: all 0.4s;transform: scale(1.1);}.sets a h3{float: left;width: 100%;font-size: 15px;color: #000000;text-align: center;padding: 10px 0px 0px 0px;margin: 0px 0px 10px 0px;direction: rtl;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;}.sets a span.text{float: right;width: auto;font-size: 15px;color: #666666;}.sets a span.text svg{float: right;width: 20px;margin-left: 5px;position: relative;top: 7px;}.sets a span.text svg path{fill: #666666;}.sets a span.date{float: left;width: auto;font-size: 15px;color: #666666;}.play_button {width: 35px;position: absolute;top: 50%;left: 50%;-webkit-transform: translate(-50%, -50%);transform: translate(-50%, -50%);z-index: 9;-webkit-transition: all .1s ease;transition: all .1s ease;}.video_cont .image_cont:hover{cursor: none;}.big_video_content{height: 596px;border-radius: 10px;padding: 0px;z-index: 9999;box-shadow: none;}.big_video_cont{float: left;width: 100%;height: calc(100% - 115px);border-radius: 10px;overflow: hidden;}.big_video_cont iframe{width: 100%;height: 100%;}.small_videos_sec{float: left;width: 100%;position: relative;background-color: transparent;padding: 0px;border-radius: 15px;overflow: auto;height: auto !important;}.small_videos_sec ul{float: left;width: 100%;padding: 10px 10px 10px 10px;}.small_videos_sec ul li{float: left;width: 100%;list-style: none;margin: 0px 0px 0px 0px;padding: 10px 10px;border-radius: 10px;box-shadow: none;}.small_videos_sec ul li.active{-webkit-box-shadow: 0px 0px 10px 0px #004848;-moz-box-shadow: 0px 0px 10px 0px #004848;box-shadow: 0px 0px 10px 0px #004848;}.small_videos_sec ul li a{float: left;width: 100%;}.small_videos_sec ul li .image{float: right;width: 230px;height: 127px;border-radius: 10px;overflow: hidden;}.small_videos_sec ul li .image img{width: 100%;height: 100%;object-fit: cover;}.small_videos_sec ul li .video_info{float: right;width: calc(100% - 235px);padding-right: 10px;}.small_videos_sec ul li .video_info h2{float: right;width: 100%;font-size: 13px;color: #058687;margin: 0px 0px 10px 0px;text-align: right;overflow: hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;line-height: 20px;direction: rtl;}.small_videos_sec ul li .video_info span{float: right;width: 100%;font-size: 12px;color: #606060;text-align: right;direction: rtl;}.small_videos_sec ul li .video_info span strong{font-weight: normal;}.main_video_info{float: left;width: 100%;margin: 15px 0px;}.main_video_info h2{float: left;width: 100%;font-size: 18px;color: #058687;text-align: right;direction: rtl;min-height: 62px;}.main_video_info span{float: right;width: auto;font-size: 17px;color: #606060;text-align: right;direction: rtl;margin-left: 10px;line-height: 15px;}.main_video_info span strong{font-weight: normal;}.main_video_info span.borderLeft{border-left: 1px solid #606060;padding-left: 10px;}.like_share_cont{float: left;width: auto;position: relative;top: -3px;}.like_share_cont a{float: left;margin-right: 20px;cursor: pointer;}.like_share_cont a p{float: left;font-size: 15px;color: #909090;margin: 0px 5px 0px 0px;direction: rtl;}.like_share_cont a svg{width: 20px;}.like_share_cont a svg path{fill: #909090;}.like_share_cont a.share_btn svg{transform: scale(-1, 1);}.like_share_cont a.active svg path, .like_share_cont a:hover svg path{fill: #17A8A9;}.like_share_cont a.active p, .like_share_cont a:hover p{color: #17A8A9;}.like_share_cont a.like_btn.active svg{-webkit-animation: tada 2s linear;animation: tada 2s linear;}.top_control_sec section.form {background-color: white;border-radius: 10px;}.top_control_sec section.form form .name{float: right;width: 20%;margin-left: 5px;position: relative;}.top_control_sec section.form form .tel{float: right;width: 20%;margin-left: 5px;position: relative;}.top_control_sec section.form form .textarea{float: right;width: 40%;margin-left: 5px;position: relative;}.top_control_sec section.form form textarea.form-control {height: 42px;}.top_control_sec section.form form .options{float: right;width: calc(18% - 43px);}.top_control_sec section.form form .form-control {margin-bottom: 0px;background-color: transparent;border: 1px solid #d9d9d9;color: #808080;}.top_control_sec section.form form {padding: 5px 5px 5px 5px;}.top_control_sec section.form form .time {width: calc(100% - 0px);}.top_control_sec section.form form .form-control::-webkit-input-placeholder {color: #808080;}.top_control_sec section.form form .form-control:-ms-input-placeholder {color: #808080;}.top_control_sec section.form form .form-control::placeholder {color: #808080;}.top_control_sec small.has-form-error{position: absolute;top: -22px;right: 0px;}.right_sec h1{text-align: center;font-size: 25px;background-color: white;border-radius: 10px;padding: 0px 10px 11px 10px;}.right_sec h1 a{color: #058687;font-size: 23px;}.right_sec h1 a:hover{text-decoration: none;}.right_sec h1 svg{width: 35px;position: relative;top: 8px;}.right_sec h1 svg path{fill: #ff0000;}#shareModal .modal-header {position: relative;}#shareModal .modal-title {width: 100%;display: block;text-align: center;}#shareModal .modal-header .close {position: absolute;left: 18px;top: 32px;padding: 0px;}.share_icons{text-align: center;}.share_icons a{width: 60px;height: 60px;border-radius: 100%;margin: 0px 10px;color: #ffffff !important;display: inline-block;font-size: 29px;padding-top: 8px;cursor: pointer;transition: all 0.5s;}.share_icons a.facebook{background-color: #1877f2;}.share_icons a.twitter{background-color: #1da1f2;}.share_icons a.whatsapp{background-color: #4ced69;}.share_icons a:hover{-webkit-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);-moz-box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);box-shadow: 0px 3px 6px 0px rgba(171,171,171,0.5);transition: all 0.5s;}.full_sections {height: auto !important;}.categories_sec{float: left;width: 100%;margin: 0px 0px 0px 0px;padding: 0px 5px;position: relative;}.categories_sec a.scroll-right{position: absolute;right: -6px;top: 1px;width: 20px;height: 30px;border-radius: 100%;text-align: center;color: #058687;font-size: 17px;padding-top: 4px;cursor: pointer;}.categories_sec a.scroll-left{position: absolute;left: -6px;top: 1px;width: 20px;height: 30px;border-radius: 100%;text-align: center;color: #058687;font-size: 17px;padding-top: 4px;cursor: pointer;}.categories_sec ul{float: left;width: 100%;display: block;padding: 0px 20px 0px 20px;overflow-x: scroll;overflow-y: hidden;white-space: nowrap;direction: rtl;transition: all 0.5s;margin: 0px;}.categories_sec ul li{float: right;list-style: none;margin: 0px 2px;background-color: #ececec;border-radius: 18px;padding: 5px 10px;text-align: center;color: #058687;display: inline-block;cursor: pointer;font-size: 15px;transition: all 0.3s;border: 1px solid #e0e0e0;}.categories_sec ul li.active, .categories_sec ul li:hover{background-color: #058687;color: #ffffff;transition: all 0.3s;}.categories_sec ul::-webkit-scrollbar {width: 0px;height: 0px;}.categories_sec ul::-webkit-scrollbar-button:start:decrement, .categories_sec ul::-webkit-scrollbar-button:end:increment {height: 6px;display: block;background-color: #e9ebee;}.categories_sec ul::-webkit-scrollbar-button:horizontal:start:decrement, .categories_sec ul::-webkit-scrollbar-button:horizontal:end:increment {height: 6px;display: block;background-color: #e9ebee;}.categories_sec ul::-webkit-scrollbar-track-piece {background-color: #e9ebee;}.categories_sec ul::-webkit-scrollbar-thumb:vertical, .categories_sec ul::-webkit-scrollbar-thumb:horizontal{background-color: #cccccc;border: 1px solid #cccccc;-webkit-border-radius: 6px;}.slick-slide {float: right;}.slick-list {padding: 0px;overflow: hidden;max-height: 35px;}.slick-initialized .slick-slide {display: block;width: auto !important;margin-left: 10px;}.slick-track {display: flex;}.slick-next {top: 50%;right: 0px;}.slick-prev {top: 50%;left: 0px;}.slick-next:before {content: "\f054";display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: 15px;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #058687;}.slick-prev:before{content: "\f053";display: inline-block;font: normal normal normal 14px/1 FontAwesome;font-size: 15px;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;color: #058687;}.top_control_sec h2{display: none;}.filter_btn{float: left;width: 22px;display: none;}.filter_btn svg{width: 22px;}.filter_btn svg path{fill: #4d4d4d;}.mobile_menu{position: fixed;top: 0px;left: -100%;width: 100%;z-index: 999999;height: 100%;padding: 0px;margin: 0px;background-color: rgba(255,255,255,0.6);transition: all 0.4s;display: none;}.mobile_menu.open{left: 0%;transition: all 0.4s;}.mobile_menu .top_title{float: left;width: 100%;color: #058687;font-size: 18px;background-color: #ffffff;padding: 15px 15px 15px 15px;margin-bottom: 0px;border-bottom: 2px solid #f0f2f7;text-align: right;}.mobile_menu .top_title svg{float: right;width: 21px;margin-left: 10px;position: relative;top: 2px;}.mobile_menu .top_title svg{float: right;width: 21px;margin-left: 10px;position: relative;top: 2px;}.mobile_menu .top_title svg path{fill: #058687;}.close_filter_btn{position: absolute;top: 13px;left: 15px;opacity: 0.8;z-index: 999;}.close_filter_btn svg {width: 22px;}.close_filter_btn svg path {fill: #058687;}.left_sec {width: calc(100% - 500px);}.right_sec {width: 500px;}.categories_sec.mob{display: none;}@media (max-width: 1600px){.big_video_content {height: 540px;}}@media (max-width: 1440px){.big_video_content {height: 540px;}}@media (max-width: 1360px){.right_sec {width: 400px;}.left_sec {width: calc(100% - 400px);}.small_videos_sec ul li .image {width: 175px;height: 111px;}.small_videos_sec ul li .video_info {width: calc(100% - 175px);}}@media (max-width: 1200px){.sets a {width: 50%;}.right_sec {width: 320px;}.left_sec {width: calc(100% - 320px);}.big_video_content {height: 540px;}.big_video_cont {height: 77%;}}@media (max-width: 1100px){.big_video_cont{height: 75%;}.big_video_content {height: 540px;}}@media (max-width: 1024px){.big_video_cont{height: 75%;}.big_video_content {height: 483px;}}@media (max-width: 991px){.big_video_cont{height: 75%;}.big_video_content {height: 396px;}}@media (max-width: 812px){.sets a {width: 100%;}.main_video_info {position: relative;padding: 0px 10px;z-index: -1;transition: all 0.5s;}.left_sec.scrollMob .main_video_info {height: 0px;overflow: hidden;margin-top: -130px;transition: all 1s;}.top_control_sec {width: 100%;position: fixed;top: 110px;left: 0px;z-index: 99999 !important;margin: 0px;background-color: #e4e4e4;padding: 15px 15px 8px 15px;-webkit-box-shadow: 0px 7px 8px -5px rgb(156 156 156 / 50%);box-shadow: 0px 7px 8px -5px rgb(156 156 156 / 50%);transition: all 0.3s;}.top_control_sec .form{display: none;}.top_control_sec h2{font-size: 20px;float: right;width: auto;position: relative;top: -4px;margin: 0px;color: #058687;display: block;}.main_video_info h2 {font-size: 16px;}.like_share_cont {width: 100%;top: auto;bottom: -2px;position: absolute;}.main_video_info span {font-size: 14px;}.small_videos_sec, .full_sections {height: auto !important;}.right_sec {margin: 640px 0px 0px 0px;}.like_share_cont a {position: relative;text-align: center;}.like_share_cont a svg {width: 20px;position: absolute;top: -18px;left: 50%;margin-left: -10px;}.like_share_cont a p {font-size: 12px;}.like_share_cont a:hover svg path{fill: #909090;}.like_share_cont a:hover p{color: #909090;}.like_share_cont a.active p {color: #17A8A9;}.like_share_cont a.active svg path{fill: #17A8A9;}.small_videos_sec {margin-bottom: 15px;}.right_sec h1, .top_control_sec h1 {font-size: 25px;display: none;}.main_menu .links {box-shadow: none;}.full_sections {padding-top: 110px;}.big_video_content {height: auto;background-color: #ffffff;border-radius: 0px;padding: 0px;position: relative;left: 0px;top: 0px;}.mobile_menu .categories_sec {display: block;float: left;width: 100%;background-color: #ffffff;}.mobile_menu .categories_sec ul {float: left;width: 100%;display: block;overflow-x: hidden;overflow-y: hidden;white-space: initial;direction: rtl;transition: all 0.5s;text-align: right;margin: 0px;padding: 10px;}.mobile_menu .categories_sec ul li{float: left;width: 100%;}.filter_btn{display: block;}.mobile_menu{display: block;}.left_sec {width: calc(100% + 0px);left: auto;right: 0px;position: fixed;height: auto;border-radius: 0px;margin-left: 0px;z-index: 9999;top: 110px;margin-top: 0px;transition: all 0.5s;}.left_sec.scrollMob{top: 48px;;transition: all 0.5s;}.big_video_cont {border-radius: 0px;height: 460px;}.right_sec {width: 100%;}.small_videos_sec ul li .image {width: 50%;height: 200px;}.small_videos_sec ul li .video_info {width: 50%;}.small_videos_sec ul li .video_info h2 {font-size: 15px;}.categories_sec{display: none;}.categories_sec.mob{display: none;padding: 5px 0px 0px 0px;background-color: #e4e4e4;transition: all 0.5s;opacity: 0;}.left_sec.scrollMob .categories_sec.mob{display: block;opacity: 1;transition: all 0.5s;}.slick-next, .slick-prev{display: none !important;}.categories_sec ul{float: left;width: 100%;display: flex;padding: 0px 0px 6px 0px;direction: rtl;transition: all 0.5s;margin: 0px;overflow-x: scroll;overflow-y: hidden;white-space: nowrap;}.categories_sec ul li{float: right;list-style: none;margin: 0px 2px;background-color: #ffffff;border-radius: 18px;padding: 6px 10px 3px 10px;text-align: center;color: #058687;display: inline-block;cursor: pointer;font-size: 15px;transition: all 0.3s;border: 1px solid #c5c5c5;box-shadow: none;}}@media (max-width: 500px){.sets a {width: 100%;}.main_video_info {position: relative;padding: 5px 0px 0px 0px;margin: 0px 0px 10px 0px;}.main_video_info h2 {font-size: 13px;line-height: 23px;min-height: 40px;padding: 0px 10px;}.like_share_cont {width: 100%;top: auto;bottom: -2px;position: absolute;padding: 0px 10px;}.main_video_info span {font-size: 13px;margin: 0px 10px;}.main_video_info span.borderLeft {padding-right: 10px;}.small_videos_sec, .full_sections {height: auto !important;}.like_share_cont a {position: relative;text-align: center;}.like_share_cont a svg {width: 20px;position: absolute;top: -21px;left: 50%;margin-left: -10px;}.like_share_cont a p {font-size: 12px;}.like_share_cont a:hover svg path{fill: #909090;}.like_share_cont a:hover p{color: #909090;}.like_share_cont a.active p {color: #17A8A9;}.like_share_cont a.active svg path{fill: #17A8A9;}.small_videos_sec {margin-bottom: 15px;}.right_sec h1, .top_control_sec h1 {font-size: 25px;}.big_video_content {height: auto;background-color: #ffffff;border-radius: 0px;padding: 0px;position: relative;left: 0px;top: 0px;}.col-md-10.offset-md-1{padding: 0px !important;}.int_page, .big_video_cont, .header{transition: all 0.3s;}#shareModal .modal-dialog {width: 100%;left: 0%;margin-left: 0px !important;height: auto;top: auto;bottom: 0px;margin-top: 0px;border: 0px;margin-bottom: 0px;position: fixed;}#shareModal .modal-content {width: 100%;border: 0px;border-radius: 0px;}.share_icons a {width: 40px;height: 40px;font-size: 21px;padding-top: 5px;}.categories_sec a.scroll-left, .categories_sec a.scroll-right{display: none;}.categories_sec {margin: 0px 0px 0px 0px;padding: 0px 0px;}.small_videos_sec ul li .video_info span {float: right;width: auto;font-size: 11px;direction: rtl;margin-left: 12px;margin-top: 14px;}.small_videos_sec ul li .video_info h2 {font-size: 15px;-webkit-line-clamp: 3;margin: 5px 0px 0px 0px;}.small_videos_sec ul li .image {width: 100%;height: 222px;}.small_videos_sec ul li .video_info {width: calc(100% - 0px);}.big_video_cont {height: 240px;}.right_sec {margin: 322px 0px 0px 0px;}.categories_sec ul li {font-size: 13px;}}@media (max-width: 360px){.big_video_cont {height: 210px;}.right_sec {margin: 315px 0px 0px 0px;}}
</style>
	
	
    <?php if ($style_lang == 'en' || $current_lang == "fr" || $current_lang == "ru") { ?>
        <?= Html::style("resources/assets/css/video-en.css"); ?>
    <?php } ?>

<?php } else { ?>

    <style>
    <?php include(public_path() . "/css/video.min.css"); ?>
    </style>
    <?php if ($style_lang == 'en' || $current_lang == "fr" || $current_lang == "ru") { ?>
        <?= Html::style("css/video-en.min.css"); ?>
    <?php } ?>

<?php } ?>


@endsection




@extends('front.layout', [
'hide_onesignal'=>true,
"page_description" => $infos->seo_description,
"page_keywords" => $infos->seo_keywords,
"amp_url"  =>  route("amp.front.index"),
"og_image"          =>   Helper::media_mob(Helper::query("Media", "find", ["id" => $infos->index_og_pic])),
])



@section('main_content')



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">

        <!-- Start Left Section -->
        <div class="left_sec">


            <div class="big_video_content sec shadow_type">
                <div class="big_video_cont">
                    <?php
                    if (!empty($video)) {

                        parse_str(parse_url($video->getLinkVideo(), PHP_URL_QUERY), $array_of_vars);
                        ?>
                        <iframe id="mainVideo" width="100%" height="100%" src="https://www.youtube.com/embed/<?= @$array_of_vars['v'] ?>?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <?php } ?>
                </div>


                <div class="main_video_info jazzira_font_bold">
                    <h2><?php if(!empty($video)) { 
					//if(count(explode(',',$video->lang))>1)
					if((int)$video->project_id != 0)
						echo $video->project->getIntroCard();
					else
						echo $video->title;
					} ?></h2>
                    <span class="borderLeft"><?= !empty($video) ? $video->views : '' ?> <strong> {{ trans('front.views') }}</strong></span>
                    <span class="borddate"><?= !empty($video) ? $video->date : '' ?></span>

                    <div class="like_share_cont">
                        <a class="share_btn" data-toggle="modal" data-target="#shareModal">
                            <p><?= trans("front.share"); ?></p>
                            <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon"><g mirror-in-rtl="" class="style-scope yt-icon"><path d="M14 9V3L22 12L14 21V15C8.44 15 4.78 17.03 2 21C3.11 15.33 6.22 10.13 14 9Z" class="style-scope yt-icon"></path></g></svg>
                        </a>
                        <a class="like_btn" data-cid="<?= !empty($video) ? $video->id : '' ?>">
                            <p><strong><?= !empty($video) ? $video->getLikes() : '' ?></strong></p>
                            <svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon"><g class="style-scope yt-icon"><path d="M1 21h4V9H1v12zm22-11c0-1.1-.9-2-2-2h-6.31l.95-4.57.03-.32c0-.41-.17-.79-.44-1.06L14.17 1 7.59 7.59C7.22 7.95 7 8.45 7 9v10c0 1.1.9 2 2 2h9c.83 0 1.54-.5 1.84-1.22l3.02-7.05c.09-.23.14-.47.14-.73v-1.91l-.01-.01L23 10z" class="style-scope yt-icon"></path></g></svg>
                        </a>
                    </div>
                </div>
            </div>
            <input type="hidden" value="<?= $class != '' ? $class : 'section' ?>" id="v_class" />



            <div class="categories_sec mob">
                <ul>
                                <!--<li><?= $class . '..' . $curr_sec_id ?></li>-->
                    <li class="<?= ($class == '' && $curr_sec_id == '') ? 'active' : '' ?>" data-id="all" data-type="all" >{{ trans('front.All') }}</li>
                    @foreach($sections as $sec)
					<?php if(in_array($sec->id,$used_secs)){ ?>
                    <li class="<?= ($class == 'section' && $curr_sec_id == $sec->id) ? 'active' : '' ?>" data-id="{{ $sec->id }}" data-type="sec">{{ $sec->getTitle() }}</li>
                    <?php } ?>
					@endforeach
                    <?php /* ?>
                      @foreach($cities as $c)
                      <li class="<?= ($class == 'project' && $curr_sec_id == $c->id) ? 'active' : '' ?>" data-id="{{ $c->id }}" data-type="city">{{ $c->getAboutTitle() }}</li>
                      @endforeach
                      <?php */ ?>
                </ul>
            </div>


<?php /*
            <!--            <div class="int_content">
            
                            <div class="pagination_sec sec shadow_type">
                                <div class="filter">
                                    <a href="#all" class="active">الكل</a>
                                    <a href="#turkish_citizenship">الجنسية التركية</a>
                                    <a href="#luxury_apartments">شقق فاخرة</a>
                                    <a href="#luxury_villas">فلل فاخرة</a>
                                </div> 
                            </div>
            
            
                            <div class="sets">
            
                                <a data-fancybox="video" href="https://www.youtube.com/embed/Lz8rv2yFnAY" class="turkish_citizenship video_cont">
                                    <div class="item shadow_type">
                                        <div class="image_cont">
                                            <img class="lazy video_photo" data-src="<?= asset("/img/video-cover.jpg"); ?>" alt="تملك بإطلالات ساحرة وتشطيبات فاخرة في اسطنبول"/>
                                            <img class="play_button" src="https://user-images.githubusercontent.com/16266381/60864229-d403b780-a244-11e9-909a-a8a01b6e1d50.png" alt="play-button">
                                        </div>
                                        <h3> مجمع فلل فاخرة جاهز للسكن مباشرة بالتقسيط و بإطلالات بحرية </h3>
                                        <span class="text">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 15.92 7.96" xml:space="preserve"><g> <g> <path class="st0" d="M0,4.03C2.09,1.58,4.61,0,7.92,0c1.16,0,2.26,0.27,3.33,0.72c1.79,0.75,3.28,1.91,4.67,3.28 c-0.1,0.11-0.18,0.22-0.28,0.32c-1.77,1.81-3.85,3.07-6.37,3.52c-2.12,0.37-4.1-0.05-5.96-1.1C2.07,6.03,1,5.11,0,4.03z M10.76,3.8c-0.02-1.59-1.3-2.83-2.91-2.81C6.32,1.01,5.07,2.3,5.08,3.85c0.01,1.58,1.29,2.83,2.86,2.82 C9.5,6.67,10.78,5.36,10.76,3.8z M1.35,4c1.1,1.07,2.32,1.94,3.78,2.49C3.86,4.93,3.77,3.32,4.78,1.6C3.46,2.16,2.34,2.97,1.35,4z M10.79,6.39c1.42-0.56,2.63-1.35,3.73-2.36c-1.02-0.92-2.1-1.7-3.36-2.28C12.04,3.39,11.92,4.91,10.79,6.39z"></path> <path class="st0" d="M8.44,2.43c-0.6,0.25-0.8,0.53-0.67,0.94c0.11,0.36,0.46,0.57,0.84,0.5C9.03,3.81,9.23,3.5,9.2,2.95 c0.47,0.39,0.53,1.34,0.12,1.93c-0.5,0.72-1.48,0.94-2.25,0.51C6.33,4.97,6.03,4.07,6.38,3.31C6.73,2.54,7.65,2.15,8.44,2.43z"></path></g></g></svg>
                                            <strong class="num">7207</strong>
                                        </span>
                                        <span class="date num">4/2020</span>
                                    </div>
                                </a>
                            </div>
                        </div>-->*/ ?>



        </div>
        <!-- End Left Section -->




        <!-- Start Fixed Section -->
        <div class="right_sec">


            <div class="categories_sec">
                <ul>
                                        <!--<li><?= $class . '..' . $curr_sec_id ?></li>-->
                    <li class="<?= ($class == '' && $curr_sec_id == '') ? 'active' : '' ?>" data-id="all" data-type="all" >{{ trans('front.All') }}</li>
                    @foreach($sections as $sec)
					<?php if(in_array($sec->id,$used_secs)){ ?>
                    <li class="<?= ($class == 'section' && $curr_sec_id == $sec->id) ? 'active' : '' ?>" data-id="{{ $sec->id }}" data-type="sec">{{ $sec->getTitle() }}</li>
                    <?php } ?>
					@endforeach
                    <?php /* ?>
                      @foreach($cities as $c)
                      <li class="<?= ($class == 'project' && $curr_sec_id == $c->id) ? 'active' : '' ?>" data-id="{{ $c->id }}" data-type="city">{{ $c->getAboutTitle() }}</li>
                      @endforeach
                      <?php */ ?>
                </ul>
            </div>


            <div class="fixed_sec">
                <div class="small_videos_sec scrollbar">
                    <ul>
                        <?php /*<!--<li class="shadow_type">
                            <a data-name="مكاتب استثمارية مغرية فوق محطة المترو مباشرة| damasturk" data-id="T5YTTNd2PvI" href="#" title="مكاتب استثمارية مغرية فوق محطة المترو مباشرة | damasturk">
                                <div class="image">
                                    <img class="lazy" data-src="<?= asset("/img/video-cover.jpg"); ?>" alt="تملك بإطلالات ساحرة وتشطيبات فاخرة في اسطنبول"/>
                                </div>

                                <div class="video_info jazzira_font_bold">
                                    <h2>مكاتب استثمارية مغرية فوق محطة المترو مباشرة | damasturk</h2>
                                    <span>15 ألف <strong>مشاهدة</strong></span><span>قبل 5 سنوات</span>
                                </div>
                            </a>
                        </li>-->*/ ?>
                    </ul>
                </div>




                <section class="form mob_form not_full shadow_type">
                    @include("front.partials.call_us_fixed")
                </section>



            </div>
        </div>
        <!-- End Fixed Section -->




    </div>
</div>





<!-- Modal Share -->
<div class="modal animate__animated animate__fadeInUp" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel"><?= trans("front.SharePageTitle"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="share_icons">
                    <a class="whatsapp" href=""><i class="fa fa-whatsapp"></i></a>
                    <a class="twitter" href=""><i class="fa fa-twitter"></i></a>
                    <a class="facebook" href=""><i class="fa fa-facebook-f"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection



@section('scriptjs')

<?= Html::script("js/slick.min.js"); ?>

<script id="video_card" type="text/html">
    <li class="shadow_type %active%">
        <a data-name="%title%" data-id="%id%" data-cid="%cid%" data-likes="%likes%" data-slug="%slug%" data-class="%class%" href="#" title="%title%">
            <div class="image">
                <img class="" src="%image%" alt="%title%"/>
            </div>

            <div class="video_info jazzira_font_bold">
                <h2>%title%</h2>
                <span>%views% <strong>{{ trans('front.views') }}</strong></span><span>%date%</span>
            </div>
        </a>
    </li>
</script>

<?php //if (Helper::get_device() != 'mob') { ?>
    <script>

if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){

}else{
		$(window).scroll(function () {
            var scrollingPage2 = 0;
            var scroll = $(window).scrollTop();
            if (scroll >= scrollingPage2) {
                $(".fixed_sec").addClass("fixed");
            } else {
                $(".fixed_sec").removeClass("fixed");
            }
        });
}

    </script>
<?php //} ?>


<script>

    function display_videos(videos) {
<?php if ($slug == '') { ?>
            if (videos[0]) {
                p = videos[0];
                $(".main_video_info h2").html(p.title);
                $(".main_video_info img").attr('src', p.image);
                $(".main_video_info .borderLeft").html(p.views);
                $(".main_video_info .borddate").html(p.date);

                $(".like_share_cont .like_btn").attr('data-cid', p._id);
                $(".like_share_cont .like_btn p").html('<strong>' + p.likes + '</strong>');
                $('.big_video_cont').html('<iframe id="mainVideo" width="100%" height="100%" src="https://www.youtube.com/embed/' + p.id + '?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
            }
<?php } ?>

        $('.small_videos_sec ul').html('');
        videos.map(function (p, i) {
            html = $('#video_card').html();
            html = html.replace('%views%', p.views);
            html = html.replace('%date%', p.date);
            html = html.replace('%likes%', p.likes);
            html = html.replace('%image%', p.image);
            html = html.replace('%id%', p.id);
            html = html.replace('%cid%', p._id);
            html = html.replace('%slug%', p.slug);

            if ('<?= $slug ?>' == p.slug)
                html = html.replace('%active%', 'active');
            else
                html = html.replace('%active%', '');


            html = html.replace('%class%', p.class);
            html = html.replace('%title%', p.title).replace('%title%', p.title).replace('%title%', p.title).replace('%title%', p.title);

            $('.small_videos_sec ul').append(html);
        });
    }

    $(document).ready(function () {

        var videos = <?= $allvideos ?>;
        display_videos(videos);



        $("body").on("click", ".like_btn.active", function (e) {
            e.preventDefault();
            var $this = $(this);
            var id = $this.attr('data-cid');
            var typ = $('#v_class').val();
            var csrf = $('input[name=_token]').val();
            if ($this.children().length > 0) {
                $this.find("i").removeClass("fa-heart-o").addClass("fa-heart");
            } else {
                $this.removeClass("fa-heart-o").addClass("fa-heart");
                /*$this.children('i').addClass("ifffcolor");*/
            }

            $.ajax({
                type: "POST",
                url: "<?= route('front.like_video') ?>",
                data: {
                    _token: csrf,
                    id: id,
                    typ: typ,
                }
            }).done(function (resp) {
                if (resp.success == '1') {
                    /*$this.removeClass('active');*/
                    var numlikes = $this.children('p').children('strong').text();
                    $this.children('p').html('<strong>' + (parseInt(numlikes) + 1) + '</strong>');
                }
                /*$this.find("i").removeClass("fa-heart-o").addClass("fa-heart");*/
            });
            return false;
        });

    });


    $("body").on("swipeleft", function () {
        alert("Left");
    });
    $("body").on("swiperight", function () {
        alert("Right");
    });

    $(document).ready(function () {
        var windowH = $(window).height();
        var windowH2 = $(window).height() - 220;

        $(".full_sections").height(windowH);
        $(".small_videos_sec").height(windowH2);
    });

    $(window).resize(function () {
        var windowH = $(window).height();
        var windowH2 = $(window).height() - 170;

        $(".full_sections").height(windowH);
        $(".small_videos_sec").height(windowH2);
    });

    $(window).scroll(function () {
        var scrollingPage = 10;
        var scroll = $(window).scrollTop();
        if (scroll >= scrollingPage) {
            $(".header").addClass("scrolling");
        } else {
            $(".header").removeClass("scrolling");
        }


    });



    var startScroll = 150;
    var supportLinks = $(".support_links");
    var oldsctop = $(window).scrollTop();
    $(window).scroll(function () {

        /*console.log('old' + oldsctop + ' ----new: '+ $(this).scrollTop());*/
        if (($(this).scrollTop()) > oldsctop) {
            $(".left_sec").addClass("scrollMob");
        } else {
            $(".left_sec").removeClass("scrollMob");
        }
        oldsctop = $(this).scrollTop();
    });



    $(document).ready(function () {
        $('.main_menu .links>li>a.videos_btn').addClass("active");


        $('.filter a').click(function (e) {
            $(".filter a").removeClass("active");
            $(this).addClass("active");
            e.preventDefault();
            var a = $(this).attr('href');
            a = a.substr(1);
            $('.sets a').each(function () {
                if (!$(this).hasClass(a) && a != 'all')
                    $(this).addClass('hide');
                else
                    $(this).removeClass('hide');
            });

        });


        $('.share_btn').click(function (e) {
            var url = encodeURI(window.location.href);
            $(".share_icons .twitter").attr('href', 'https://twitter.com/intent/tweet?url=' + url + '&via=damasturk');
            $(".share_icons .facebook").attr('href', 'https://facebook.com/sharer.php?u=' + url);
            $(".share_icons .whatsapp").attr('href', 'https://api.whatsapp.com/send?text=' + url);

        });

        /*
         //        $('.video_cont .image_cont').mousemove(function (e) {
         //            var playBtn = $(this).find(".play_button");
         //            var parentOffset = $(this).offset();
         //            var relX = e.pageX - parentOffset.left;
         //            var relY = e.pageY - parentOffset.top;
         //            $(playBtn).css({left: relX, top: relY});
         //        });
         //        $('.video_cont .image_cont').mouseout(function () {
         //            $(".play_button").css({left: '50%', top: '50%'});
         //        });
         
         
         // assign captions and title from alt-attributes of images:
         //        $(".video_cont").each(function () {
         //            $(this).attr("data-caption", $(this).find("img").attr("alt"));
         //            $(this).attr("title", $(this).find("img").attr("alt"));
         //        });
         
         //        $('[data-fancybox]').fancybox({
         //            youtube: {
         //                autoplay: 1
         //            }
         //        });
         */
    });



    $('.small_videos_sec').on('click', 'ul li', function () {

        $(".small_videos_sec ul li").removeClass("active");
        $(this).addClass("active");
    });



    $('.small_videos_sec').on('click', 'ul li a', function () {

        $('#v_class').val($(this).attr("data-class"));
        var videoId = $(this).attr("data-id");
        var cid = $(this).attr("data-cid");
        var slug = $(this).attr("data-slug");
        window.history.pushState("", "", "<?= route('front.video', ['slug' => ':slug']) ?>".replace(':slug', slug));
        var videoName = $(this).attr("data-name");

        $(".main_video_info h2").html(videoName);
        $(".main_video_info img").attr('src', $(this).find('img').attr('src'));
        $(".main_video_info .borderLeft").html($(this).find("span:eq(0)").html());
        $(".main_video_info .borddate").html($(this).find("span:eq(1)").html());
        $(".like_share_cont .like_btn p").html('<strong>' + $(this).attr("data-likes") + '</strong>');
        $(".like_share_cont .like_btn").attr('data-cid', cid);

        $('.big_video_cont').html('<iframe id="mainVideo" width="100%" height="100%" src="https://www.youtube.com/embed/' + videoId + '?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        /*$("#mainVideo")[0].src += "?autoplay=1";*/
    });


    $('a.like_btn').click(function () {
        $(this).toggleClass("active");
    });


    /**-- Categories --**/
    $(document).on("click", ".categories_sec ul li", function () {
        $(".categories_sec ul li").removeClass("active");
        $(this).addClass("active");


        var type = $(this).data('type');
        var id = $(this).data('id');
        $('.small_videos_sec ul').html('');

        $.ajax({
            url: "<?= route('front.video') ?>?id=" + id + "&type=" + type,
            type: "get"
        }).done(function (resp) {
            display_videos(JSON.parse(resp.videos));
        }).fail(function (jqXHR, ajaxOptions, thrownError) {
            console.log('server not responding...');
        });

    });




</script>


<?php if (Helper::get_device() == 'full') { ?>
    <?php if ($current_lang == 'ar' || $current_lang == 'pe') { ?>
        <script>
            $('.categories_sec ul').slick({
                dots: false,
                arrow: true,
                infinite: false,
                speed: 300,
                slidesToShow: 2,
                slidesToScroll: 3,
                rows: 1,
                swipeToSlide: true,
                rtl: true,
                responsive: [
                    {
                        breakpoint: 812,
                        settings: {
                            arrow: false
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            arrow: false
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        </script>
    <?php } else { ?>
        <script>
            $('.categories_sec ul').slick({
                dots: false,
                arrow: true,
                infinite: false,
                speed: 300,
                slidesToShow: 2,
                slidesToScroll: 3,
                rows: 1,
                swipeToSlide: true,
                ltr: true,
                responsive: [
                    {
                        breakpoint: 812,
                        settings: {
                            arrow: false
                        }
                    },
                    {
                        breakpoint: 500,
                        settings: {
                            arrow: false
                        }
                    }
                ]
            });
        </script>
    <?php } ?>
<?php } ?>



<script>

//
//    document.addEventListener('touchstart', handleTouchStart, false);
//    document.addEventListener('touchmove', handleTouchMove, false);
//
//    var xDown = null;
//    var yDown = null;
//
//    function getTouches(evt) {
//        return evt.touches || // browser API
//                evt.originalEvent.touches; // jQuery
//    }
//
//    function handleTouchStart(evt) {
//        const firstTouch = getTouches(evt)[0];
//        xDown = firstTouch.clientX;
//        yDown = firstTouch.clientY;
//    }
//    ;
//
//    function handleTouchMove(evt) {
//        if (!xDown || !yDown) {
//            return;
//        }
//
//        var xUp = evt.touches[0].clientX;
//        var yUp = evt.touches[0].clientY;
//
//        var xDiff = xDown - xUp;
//        var yDiff = yDown - yUp;
//
//        if (Math.abs(xDiff) > Math.abs(yDiff)) {/*most significant*/
//            if (xDiff > 0) {
//                /* alert("left swipe"); */
//                window.location.href = "/stories";
//            } else {
//                /* alert("right swipe"); */
//                window.location.href = "/blog";
//            }
//        } else {
//            if (yDiff > 0) {
//                /* up swipe */
//            } else {
//                /* down swipe */
//            }
//        }
//        /* reset values */
//        xDown = null;
//        yDown = null;
//    }
//    ;

</script>





@endsection



@section('schemaorg')
<?php
if(!empty($video)){
if((int)$video->project_id != 0)
	$vtitle = $video->project->getIntroCard();
else
	$vtitle = $video->title;
?>
<script type="application/ld+json">{
  "@context": "http://schema.org",
  "@type": "VideoObject",
  "name": "{{ htmlentities(mb_substr($vtitle, 0, 45, 'UTF-8')) }}...",
  "description": "{{ htmlentities($vtitle)  }}",
  "thumbnailUrl": "https://i.ytimg.com/vi/<?=  $array_of_vars['v'] ?>/default.jpg",
  "uploadDate": "<?= @date(DATE_ISO8601, strtotime($video->date)) ?>",<?php //2021-12-23T13:02:56Z ?>
  "duration": "<?= $video->duration ?>",
  "embedUrl": "https://www.youtube.com/embed/<?=  $array_of_vars['v'] ?>",
  "interactionCount": "{{ $video->views  }}"
}</script><?php } ?>
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