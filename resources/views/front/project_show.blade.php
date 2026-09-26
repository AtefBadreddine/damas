<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();
$ccountry = (Helper::container_array(\Route::getCurrentRoute()->getPath(), ['oman'])?'oman':'turkey');
$hide_maps = true;

$is_mobile = Helper::get_device() != 'full' ? true : false;
/* $arr_prices = [
  "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
  ]; */
$right = ($style_lang == 'ar' ? 'right' : 'left');
$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <!--<?= Html::style("resources/assets/css/font-awesome.min.css"); ?>-->
    <?= Html::style("resources/assets/css/slick.css"); ?>
    <?= Html::style("resources/assets/css/slick-theme.css"); ?>
    <?= Html::style("resources/assets/css/bootstrap-multiselect.css"); ?>

    <?= Html::style("resources/assets/css/myChart.css"); ?>
    <?= Html::style("resources/assets/css/project.css"); ?>


    <style>
        /** Main Slider Top Page **/
        .main_slider{float:left;width:100%;display:block;margin-top:114px;padding:0 15px;overflow:hidden;position:relative;max-height:722px;border-radius:20px}.main_slider:before{content:"";position:absolute;top:0;left:0;right:0;bottom:0;background-color:#fff;background-image:url('/img/placeholder.svg');background-position:center;background-size:40%;background-repeat:no-repeat;z-index:99}.main_slider.loaded:before{opacity:0;z-index:-1;transition:all .3s}.int_page{padding-top:0}.slider-for{margin-bottom:0}.slider-for .item{width:100%;height:470px;-webkit-box-shadow:0 3px 6px 0 rgba(171,171,171,.5);-moz-box-shadow:0 3px 6px 0 rgba(171,171,171,.5);box-shadow:0 3px 6px 0 rgba(171,171,171,.5);border-radius:25px;overflow:hidden}.slider-for .item img{width:100%;height:100%;object-fit:cover}.slider-nav .item{width:100%;height:160px;border-radius:25px;overflow:hidden;cursor:pointer;transition:all .5s}.slider-nav .item img{width:100%;height:100%;object-fit:cover}.slider-nav .slick-slide{padding:25px 10px}.slick-center .item{-moz-transform:scale(1.08);-ms-transform:scale(1.08);-o-transform:scale(1.08);-webkit-transform:scale(1.08);transform:scale(1.08);box-shadow:0 0 20px rgba(0,0,0,.6)}.slick-next,.slick-prev{width:58px;height:58px;background-color:rgba(15,104,104,.8)!important;color:#fff!important;font-size:35px!important;border-radius:50%;z-index:99;text-align:center;transition:background .1s ease-in-out;font-size:0!important;display:inline-block;font:normal normal normal 14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.slick-next:before,.slick-prev:before{font:normal normal normal 14px/1 FontAwesome;font-size:25px}.slick-next:before{content:"\f054"}.slick-prev:before{content:"\f053"}.slider-for{overflow:visible}.slider.swiper-container-horizontal{overflow:hidden}.slick-list{overflow:hidden}.slick-next{right:0}.slick-prev{left:0}@media (max-width:480px){.main_slider{margin-top:120px;padding:0 0;width:calc(100% + 30px);right:15px;position:relative;max-height:457px}.slider-for .item{height:320px;border-radius:15px}.slider-nav .item{height:120px;border-radius:10px;-webkit-box-shadow:0 3px 6px 0 rgb(171 171 171 / 50%);-moz-box-shadow:0 3px 6px 0 rgba(171,171,171,.5);box-shadow:0 3px 6px 0 rgb(171 171 171 / 50%)}.slider-nav .slick-slide{padding:0 5px}.slick-next,.slick-prev{display:none!important}.slider.swiper-container-horizontal{margin-top:6px;overflow:hidden}.slider-for{padding:0 15px}}
.rightMenuModal{ position: absolute!important;}
.fancybox-content{padding:0!important}
    </style>


    <?php if($current_lang == 'en'){ ?>

    <?php } ?>


<?php } else { ?>

    <?php // echo Html::style("/css/index" . (Helper::get_device() != 'full' ? '-mob' : '') . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?>
    <style>

        <?php include(public_path() . "/css/project.min.css"); ?>
        /** Main Slider Top Page **/
        .main_slider{float:left;width:100%;display:block;margin-top:114px;padding:0 15px;overflow:hidden;position:relative;max-height:722px;border-radius:20px}.main_slider:before{content:"";position:absolute;top:0;left:0;right:0;bottom:0;background-color:#fff;background-image:url('/img/placeholder.svg');background-position:center;background-size:40%;background-repeat:no-repeat;z-index:99}.main_slider.loaded:before{opacity:0;z-index:-1;transition:all .3s}.int_page{padding-top:0}.slider-for{margin-bottom:0}.slider-for .item{width:100%;height:470px;-webkit-box-shadow:0 3px 6px 0 rgba(171,171,171,.5);-moz-box-shadow:0 3px 6px 0 rgba(171,171,171,.5);box-shadow:0 3px 6px 0 rgba(171,171,171,.5);border-radius:25px;overflow:hidden}.slider-for .item img{width:100%;height:100%;object-fit:cover}.slider-nav .item{width:100%;height:160px;border-radius:25px;overflow:hidden;cursor:pointer;transition:all .5s}.slider-nav .item img{width:100%;height:100%;object-fit:cover}.slider-nav .slick-slide{padding:25px 10px}.slick-center .item{-moz-transform:scale(1.08);-ms-transform:scale(1.08);-o-transform:scale(1.08);-webkit-transform:scale(1.08);transform:scale(1.08);box-shadow:0 0 20px rgba(0,0,0,.6)}.slick-next,.slick-prev{width:58px;height:58px;background-color:rgba(15,104,104,.8)!important;color:#fff!important;font-size:35px!important;border-radius:50%;z-index:99;text-align:center;transition:background .1s ease-in-out;font-size:0!important;display:inline-block;font:normal normal normal 14px/1 FontAwesome;font-size:inherit;text-rendering:auto;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.slick-next:before,.slick-prev:before{font:normal normal normal 14px/1 FontAwesome;font-size:25px}.slick-next:before{content:"\f054"}.slick-prev:before{content:"\f053"}.slider-for{overflow:visible}.slider.swiper-container-horizontal{overflow:hidden}.slick-list{overflow:hidden}.slick-next{right:0}.slick-prev{left:0}@media (max-width:480px){.main_slider{margin-top:120px;padding:0 0;width:calc(100% + 30px);right:15px;position:relative;max-height:457px}.slider-for .item{height:320px;border-radius:15px}.slider-nav .item{height:120px;border-radius:10px;-webkit-box-shadow:0 3px 6px 0 rgb(171 171 171 / 50%);-moz-box-shadow:0 3px 6px 0 rgba(171,171,171,.5);box-shadow:0 3px 6px 0 rgb(171 171 171 / 50%)}.slider-nav .slick-slide{padding:0 5px}.slick-next,.slick-prev{display:none!important}.slider.swiper-container-horizontal{margin-top:6px;overflow:hidden}.slider-for{padding:0 15px}}
.rightMenuModal{ position: absolute!important;}
.fancybox-content{padding:0!important}
    </style>

<?php } ?>
    <?= Html::style("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css"); ?>
<style>
.send_tour_btn img.icon{max-width: 30px}
</style>
@endsection



<?php /*
  @extends('front.layout', [
  'hide_onesignal'=>true,
  "page_description" => $infos->seo_description,
  "page_keywords" => $infos->seo_keywords,
  "amp_url"  =>  route("amp.front.index"),
  "og_image"          =>   Helper::media_mob(Helper::query("Media", "find", ["id" => $infos->index_og_pic])),
  ])
 */ ?>



@extends('front.layout', [
"page_title"        =>    $project->getSeoTitle(),
"page_description"  =>    $project->getSeoDescription(),
"og_image"          =>    Helper::media_url_full($project->cardphoto),
"amp_url"           =>    route("amp.front.project", $project->slug),
"hide_onesignal" =>	true,
"hide_main_js" =>	true,
])


@section('main_content')




<?php
$images = $project->projectPhotos;
$is_mobile = Helper::get_device() == 'mob' ? true : false;
//$p_flavors = $project->flavors;
$flavors = $project->flavors();
//$region_name_en = @$r_reg->getNameEn();
?>

<div class="col-md-10 offset-md-1">

    <!-- Start Slider -->
    <div class="main_slider">
        <div class="slider-for">




            <?php
            /*$ii = 0;
            if (Helper::is_mobile() and ! Helper::is_tablet() and @ $images[0]->path_mobile != '') { 
                ?>
                @foreach($images as $k => $img)
                <?php
                $ii++;
                $img_url = Helper::media_url($img);
                $imgslid = $img_url;
                ?>
                <div class="item">
                    <a data-fancybox="photo" href="<?= $imgslid; ?>">
                        <img class="lazy" data-lazy="<?= $imgslid; ?>" alt="<?= $img->getDescription(); ?>" title="<?= $img->getTitle(); ?>"/>
                    </a>
                </div>
                @endforeach
                <?php
            } else {//computer and tablet
                $ii = 0;
                ?>
                @foreach($images as $k => $img)
                <?php
                $ii++;
                $img_url = Helper::media_url_full($img);
                ?>
                <div class="item">
                    <a data-fancybox="photo" href="<?= $img_url; ?>">
                        <img class="lazy" data-lazy="<?= Helper::get_thumbnail_full($img, 980, 544); ?>" alt="<?= $img->getDescription(); ?>" title="<?= $img->getTitle(); ?>" />
                    </a>
                </div>
                @endforeach
            <?php }*/ ?>
	
				<?php
                $ii = 0;
                ?>
                @foreach($images as $k => $img)
                <?php
                $ii++;
				$img_url_mob = Helper::media_url($img);
                $img_url = Helper::media_url_full($img);
                ?>
                <div class="item">
                    <a data-fancybox="photo" href="<?= $img_url_mob; ?>">
                        
					<picture>
					   <source media="(min-width: 650px)" srcset="<?= $img_url ?>">
					   <source media="(max-width: 650px)" srcset="<?= $img_url_mob ?>">
					   
					   
					   <img class="lazy" loading="lazy" src="<?= $img_url ?>" 
						alt="<?= $img->getDescription(); ?>" title="<?= $img->getTitle(); ?>"/>
					</picture>
						
                    
					</a>
                </div>
                @endforeach


        </div>

        <div class="slider-nav">

<!--<div class="item"><img src="<?= asset("/img/01.jpg"); ?>" alt="damasturk"/></div>-->


            <?php
            /*$ii = 0;
            if (Helper::is_mobile() and ! Helper::is_tablet() and @ $images[0]->path_mobile != '') { 
                ?>
                @foreach($images as $k => $img)
                <?php
                $ii++;
                $img_url = Helper::media_url($img);
                $imgslid = $img_url;
                ?>
                <div class="item">
                    <img class="lazy" data-lazy="<?= $imgslid; ?>" alt="<?= $img->getDescription(); ?>" />
                </div>
                @endforeach
                <?php
            } else {//computer and tablet
                $ii = 0;
                ?>
                @foreach($images as $k => $img)
                <?php
                $ii++;
                $img_url = Helper::media_url_full($img);
                ?>
                <div class="item">
                    <img class="lazy" data-lazy="<?= Helper::get_thumbnail_full($img, 640, 450); ?>" alt="<?= $img->getDescription(); ?>" title="<?= $img->getTitle(); ?>" />
                </div>
                @endforeach
            <?php }*/ ?>

				<?php
                $ii = 0;
                ?>
                @foreach($images as $k => $img)
                <?php
                $ii++;
                $img_url = Helper::media_url($img);
                ?>
                <div class="item">
                    <img class="lazy" data-lazy="<?= $img_url ?>" alt="<?= $img->getDescription(); ?>" title="<?= $img->getTitle(); ?>" />
                </div>
                @endforeach
				
				
        </div>
    </div>
    <!-- End Slider -->

    <div class="full_sections int_page">

        <!-- Start Left Section -->
        <div class="left_sec">
<?php
				$pptype = @$project->types;
				$ppcateg = @$project->categories;
				?>
            <?php
                $breadcrumbCity = @$project->city;
                $breadcrumbRegion = @$project->region;
                $breadcrumbCountry = $breadcrumbCity && $breadcrumbCity->countryRel
                    ? $breadcrumbCity->countryRel
                    : ($breadcrumbCity ? \App\Models\Country::findByCode($breadcrumbCity->country) : null);
                $breadcrumbProjectLabel = trim((string) $project->getName());
                if ($breadcrumbProjectLabel === '') {
                    $breadcrumbProjectLabel = $project->slug;
                }
            ?>
            <div class="scp-breadcrumb">
                <ul class="breadcrumb">
                    <li><a href="{{ route('front.index') }}"><i class="fa fa-home"></i></a></li>
                    @if($breadcrumbCountry)
                    <li><a href="{{ $breadcrumbCountry->listingUrl() }}">{{ $breadcrumbCountry->getTitle() }}</a></li>
                    @endif
                    @if($breadcrumbCity && $breadcrumbCity->listingUrl())
                    <li><a href="{{ $breadcrumbCity->listingUrl() }}">{{ $breadcrumbCity->getName() }}</a></li>
                    @endif
                    @if($breadcrumbRegion && $breadcrumbRegion->listingUrl())
                    <li><a href="{{ $breadcrumbRegion->listingUrl() }}">{{ $breadcrumbRegion->getName() }}</a></li>
                    @endif
                    <li class="active num">{{ $breadcrumbProjectLabel }}</li>
                </ul>
            </div>

            <div class="int_content">
				
                @if($project->sold!='100')

                <div class="section">
                    <div class="top_sec">
                        <h1 class="project_name">
                            
                            <?php
                            if($project->has_special_h1 == 1){
                                if($current_lang == "ar"){
                                    $h1title = $project->special_h1_ar;
                                }
                                else {
                                    $h1title = $project->special_h1_en;
                                }
                            }
                            else {
                                //$pptype = @$project->types;
                                //$ppcateg = @$project->categories;
                                // $h1title = (isset($pptype[0]) ? @$pptype[0]->getName() : '') . ' ' . trans('front.for_sale') . ' ' . @$project->city->getName() . ' ' . @$project->region->getName() . ' ' . (isset($ppcateg[0]) ? @$ppcateg[0]->getName() : '');
                                
                                $h1title = @$project->title_en . ' | ' . (isset($pptype[0]) ? @$pptype[0]->getName() : '') . ' ' . ($current_lang === 'ar' ? 'للبيع' : 'for sale') . ' ' . (isset($ppcateg[0]) ? @$ppcateg[0]->getName() : '');
                            }
                            ?>

                            {{ $h1title }}
                            <!--<strong class="num" style="top: 0px !important">{{ @$project->getNameEn() }}</strong>-->
                        </h1>
                        <div class="btn_group">
                            <a class="green_btn gift" data-fancybox="gift" data-src="#gift" data-touch="false"><span class="icon"></span><span><?= trans("front.gift"); ?></span></a>
                            <a class="green_btn like likeCardItem <?= in_array($project->id, session()->get("likedprojects.ids", [])) ? 'active' : ''; ?>" data-url="<?= route("front.likeitem"); ?>" data-typ="project" data-code="<?= $project->id; ?>"><span class="icon"></span><span><?= trans("front.like"); ?></span></a>
                            <div class="dropdown share">
                                <button class="btn btn-primary dropdown-toggle green_btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="icon"></span> <?= trans("front.share"); ?>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="fa fa-twitter" href="https://twitter.com/intent/tweet?url=<?= urlencode($project->frontUrl()) ?>&amp;text=<?= urlencode(trans("front.project") . ' ' . @$project->getNameEn() . ' ' . @$project->city->getName()) ?>&amp;via=damasturk" target="_blank"></a>
                                    <a target="_blank" class="fa fa-facebook" href="https://facebook.com/sharer.php?u=<?= urlencode($project->frontUrl()) ?>"></a>
                                    <a class="fa fa-whatsapp" href="https://api.whatsapp.com/send?text=<?= urlencode($project->frontUrl()) ?>" target="_blank"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span class="line_space margin_top_35"></span>
                    <ul class="project_icons">
                        <li class="region">
                            <div class="icon"></div>
                            <p><?= @$project->city->getName(); ?></p> 
                            <span><?= @$project->region ? @$project->region->getName() : null; ?></span>
                        </li>
                        <li class="type">
                            <div class="icon"></div>
                            <p><strong><?= $project->bs ?></strong> <?= trans("front.Block"); ?></p><span><strong><?= $project->fs ?></strong> <?= trans("front.Flat"); ?></span>
                        </li>
                        <li class="target">
                            <div class="icon"></div>
                            <p><?= trans("front.City Center"); ?></p><span class="num"><strong><?= trim(str_replace('كم', '', $project->distance_center)); ?></strong> km</span>
                        </li>
                        <?php
                        list($sclass, $slab) = $project->getStatus();
                        if ($sclass == 'under-construction') {
                            ?>
                            <li class="status under-construction">
                                <div class="icon"></div>
                                <p><?= trans("front.under cons"); ?></p><span class="date num"><?= date("Y/m", strtotime($project->delivered_date)); ?></span>
                            </li>
                        <?php } else { ?>
                            <li class="date">
                                <div class="icon"></div>
                                <p><?= trans("front.Ready to move"); ?></p>
                            </li>
                        <?php } ?>

                        <?php
                        if ($project->payment_method != 'نقدي') {
                            ?>
                            <li class="payment_plan">
                                <div class="progres">
                                    <span class="pro">
                                        <div class="progress" data-percentage="<?= $project->payment_percent ?>">
                                            <span class="progress-left">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <span class="progress-right">
                                                <span class="progress-bar"></span>
                                            </span>
                                            <div class="progress-value">
                                                <strong class="num"><?= $project->payment_percent ?>%</strong>
                                            </div>
                                        </div>
                                    </span>
                                </div>
                                <p> <?= trans('front.' . $project->payment_method); ?></p>
                                <p> <strong class="num"><?= $project->payment_months ?></strong> <?= trans("front.months"); ?></p>
                            </li>
                        <?php } ?>

                    </ul>

                    <span class="line_space"></span>

                </div>	

                @endif




                <div class="section prices">
                    @if($project->sold=='100')

                    <div class="message_project_off">
                        <p class="jazzira_font_bold"><?= trans("front.message project off"); ?></p>

                        <ul class="links_list">
                            <li><a href="<?= route("front.search", ["property-for-sale", $ccountry]) ?>" class="btn btn-default"> <?= trans("front.property for sale"); ?></a></li>
                            <li><a href="<?= route("front.search", ["property-for-sale", @$project->city->getSlug()]) ?>" class="btn btn-default">
                                    <?= trans("front.projects"); ?> {{ @$project->city->getName() }}</a></li>
                            <li><a href="<?= route("front.search", ["property-for-sale", @$project->city->getSlug(), @$project->region->getSlug()]) ?>" class="btn btn-default">
                                    <?= trans("front.projects"); ?> {{ @$project->region->getName() }}</a></li>
                        </ul>
                    </div>


                    @else
                    <h2 class="sub_title jazzira_font_bold"><span style="<?= $current_lang === "en" ? 'direction:ltr;' : '' ?><?= $is_mobile === true ? 'font-size:0.9em;' : '' ?>"><?= trans("front.project table title"); ?></span></h2>
                    @include("front.partials.project_prices_landing", ["project" => $project, "style_lang" => $style_lang ])					
                    @endif
                </div>


                <!--                <div class="mar_sec sec">
                                    <p>سارع في التواصل معنا واحصل على أفضل العروض وأدق التفاصيل عن هذا المشروع</p>
                                    <div class="cta_btn">
                                        <a class="enquiry_btn" href="{{ route('front.whatsapp_share') }}">
                                            <img src="<?= asset("/img/whatsapp-btn-$current_lang.svg"); ?>"  alt="whatsapp" title="<?= trans("front.offers Inquire"); ?>"/>
                                        </a>
                                    </div>
                                </div>-->


            </div>





            <?php
            /* $link_video = $project->getLinkVideo();
              parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
              $video_code = @$array_of_vars['v']; */
            ?>


            <?php
			if($project->link_3d!=''){
			?>
			<div class="int_content">
                <div class="section video">
                    <h2 class="sub_title jazzira_font_bold"><?= trans("front.Virtual Roaming"); ?></h2>
                    <section class="youtube-video">
                        <a data-fancybox="3d" data-type="iframe" class="video_fancybox" data-src="<?= $project->link_3d ?>" href="javascript:;">
                            <svg class="faa-ring animated" width="70" height="70" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 27.6 27.6" style="enable-background:new 0 0 27.6 27.6;" xml:space="preserve"><style type="text/css">.st0{fill:#ABDEFF;}.st1{fill:#E2E5E7;}.st2{fill:#313B5A;}.st3{fill:#FFA001;}.st4{fill:#F87F02;}.st5{fill:#F4D34E;}.st6{fill:#FFA41F;}</style><g><path class="st0" d="M27.6,13.8c0,7.6-6.2,13.8-13.8,13.8S0.1,21.4,0.1,13.8S6.2,0.1,13.8,0.1S27.6,6.2,27.6,13.8L27.6,13.8z"/><path class="st1" d="M27.6,13.8c0,4.7-2.3,8.8-5.9,11.3c-2.2,1.5-4.9,2.5-7.9,2.5S8.2,26.7,6,25.1c-3.6-2.5-5.9-6.6-5.9-11.3C0.1,11.3,0.7,9,1.9,7c2.4,4.1,6.8,6.9,12,6.9s9.6-2.8,12-6.9C26.9,9,27.6,11.3,27.6,13.8L27.6,13.8z"/><path class="st2" d="M11.1,6.4c-0.1,0-0.2-0.2-0.1-0.3l1.4-1.2c0,0,0.1-0.1,0.1-0.1V3.6c0-0.1-0.1-0.2-0.2-0.2h-5c-0.1,0-0.2,0.1-0.2,0.2V5c0,0.1,0.1,0.2,0.2,0.2h1.9c0.2,0,0.2,0.2,0.1,0.3l-1,1c0,0-0.1,0.1-0.1,0.1v1c0,0.1,0.1,0.2,0.2,0.2h1.2c0.6,0,0.9,0.2,0.9,0.7S10.1,9,9.6,9C8.9,9,8.4,8.8,7.8,8.2c-0.1-0.1-0.2-0.1-0.3,0L6.8,9.7c0,0.1,0,0.2,0.1,0.2c0.7,0.5,1.8,0.9,2.9,0.9c1.8,0,3-1,3-2.4C12.8,7.3,12.1,6.6,11.1,6.4L11.1,6.4z"/><path class="st2" d="M16.9,3.4h-3.1c-0.1,0-0.2,0.1-0.2,0.2v6.9c0,0.1,0.1,0.2,0.2,0.2h3c2.5,0,4.1-1.4,4.1-3.7C20.9,4.8,19.3,3.4,16.9,3.4L16.9,3.4z M16.9,8.8h-0.7c-0.1,0-0.2-0.1-0.2-0.2V5.5c0-0.1,0.1-0.2,0.2-0.2h0.6c0.9,0,1.5,0.7,1.5,1.8C18.4,8.1,17.8,8.8,16.9,8.8L16.9,8.8z"/><g><path class="st3" d="M21,13.5v8.6l-7.3,4.2l-7.3-4.2v-8.6l7.3-4.2L21,13.5z"/><path class="st4" d="M21,13.5v8.6l-7.3,4.2V9.3L21,13.5z"/><path class="st5" d="M21,13.5l-7.3,4.2l-7.3-4.2l7.3-4.2L21,13.5z"/><path class="st6" d="M21,13.5l-7.3,4.2V9.3L21,13.5z"/></g></g></svg>
                            <img width="100%" height="500" class="cover lazy" loading="lazy" src="<?= Helper::media_url_full($project->cardphoto) ?>">
                        </a>
                    </section>
                </div>
            </div>
			<?php } ?>

            @if($video_code!='')
            <div class="int_content">
                <div class="section video">
                    <h2 class="sub_title jazzira_font_bold">{{ trans('front.Project video') }}</h2>

                    <section class="youtube-video" id="section_images_videos">
                        <a data-fancybox="video" class="video_fancybox" href="https://www.youtube.com/embed/<?= $video_code; ?>">
                            <svg class="faa-ring animated" height="48" version="1.1" viewBox="0 0 68 48" width="68"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                            <img width="100%" height="500" class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/<?= $video_code; ?>/maxresdefault.jpg">
                        </a>
                    </section>

                </div>
            </div>
            @endif



            @if($video_code2!='')
            <div class="int_content">
                <div class="section video">
                    <h2 class="sub_title jazzira_font_bold">{{ trans('front.district video title') }} <?= @$project->region ? @$project->region->getName() : null; ?></h2>

                    <section class="youtube-video" id="section_images_videos">
                        <a data-fancybox="video" class="video_fancybox" href="https://www.youtube.com/embed/<?= $video_code2; ?>">
                            <svg class="faa-ring animated" height="48" version="1.1" viewBox="0 0 68 48" width="68"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                            <img width="100%" height="500" class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/<?= $video_code2; ?>/maxresdefault.jpg">
                        </a>
                    </section>

                </div>
            </div>
            @endif



            @if($project->sold!='100')

            <div class="int_content">
                <div class="section">

                    <div class="sub_section">
                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.facilities and features"); ?></h2>
                        <ul class="explained">
                            <?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br(preg_replace("/[\r\n]+/", "\n", $project->getIntoLocation())))); ?>
                        </ul>
                    </div>

                    <ul class="features">
                        @foreach($project->features as $feature)
                        <li><span class="fa fa-check"></span> <?= $feature->getName(); ?></li>
                        @endforeach
                    </ul> <span class="line_space"></span>

                    <?php /* <div class="sub_section">
                      <h2 class="sub_title jazzira_font_bold"><?= trans("front.location and strategic importance"); ?></h2>
                      @if($project->getIntoLocation())
                      <ul class="explained">
                      <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntoLocation()))); ?></li>
                      </ul>
                      @endif
                      </div> <span class="line_space"></span> */ ?>
                    
					<?php
					
					?>
                        <?php $p_governmental = $project->getGovernmental(); ?>
                        @if($p_governmental)
					<div class="sub_section">
                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.service institutions"); ?></h2>
                        <ul class="explained">
                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_governmental))); ?></li>
                        </ul>
                    </div> <span class="line_space"></span>
                        @endif
						<?php $p_location = $project->getLocation(); ?>
                        
                    <div class="sub_section">
                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.location"); ?></h2>
                        
						@if($p_location )
                        <ul class="explained">
                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_location))); ?></li>
                        </ul>
						@endif
						<?php //if($hide_maps==false){ ?>
                        <section class="map" id="map">
                            <iframe width="100%" height="350" style="height:350px" loading="lazy" frameborder="0" class="lazy" style="border:0" src="https://maps.google.com/maps?q=<?= $project->latitude ?>,<?= $project->longitude ?>&amp;hl=es;z=14&amp;output=embed"></iframe>
							<!--<a title="انقر لعرض الخريطة" data-fancybox="location" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://www.google.com/maps/search/?api=1&amp;query=<?= $project->latitude; ?>,<?= $project->longitude; ?>&amp;z=8">
                                {!! Helper::picture(['class'=>'lazy',"width"=>"100%","height"=>"200", 'src'=> 'https://www.aqsaway.com/map.php?size=1200x200&latitude=' . $project->latitude . '&longitude=' . $project->longitude  ]) !!}
							</a>-->
                        </section>
						<?php //} ?>
                    </div> <span class="line_space"></span>
					
                        
					
                        <?php $p_transportation = $project->getTransportation(); ?>
                        @if($p_transportation)
                    <div class="sub_section">
                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.transportation"); ?></h2>
                        <ul class="explained">
                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_transportation))); ?></li>
                        </ul>
                    </div>
                    <span class="line_space"></span>
                        @endif
					
                        <?php $p_future_look = $project->getFutureLook(); ?>
                        @if($p_future_look)
                    <div class="sub_section">
                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.future look"); ?></h2>
                        <ul class="explained">
                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_future_look))); ?></li>
                        </ul>
                    </div>
                        @endif
                </div>
            </div>

<?php if($hide_maps==false){ ?>
            <div class="int_content map_sec">
                <h2 class="sub_title jazzira_font_bold"><span><?= trans("front.Services close to the project"); ?></span></h2>

                <div class="map_btn_group sec">
                    <a class="active" href="javascript:;" onclick="initializePropertyMap('school');"><?= trans("front.Services close to the project school"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('university');"><?= trans("front.Services close to the project university"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('hospital');"><?= trans("front.Services close to the project hospital"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('shopping');"><?= trans("front.Services close to the project shopping"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('park');"><?= trans("front.Services close to the project park"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('mosque');"><?= trans("front.Services close to the project mosque"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('subway_station');"><?= trans("front.Services close to the project subway_station"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('restaurant');"><?= trans("front.Services close to the project restaurant"); ?></a>
                    <a href="javascript:;" onclick="initializePropertyMap('hotel');"><?= trans("front.Services close to the project hotel"); ?></a>
                </div>
<!--                <input type="hidden" id="serviceType" value="bank" />-->
                <div id="new_map"></div>
            </div>
<?php } ?>


            @endif


            @if($project->sold!='100')

            <?php $img_plans = $project->planPhotos; ?>
            @if(count($img_plans))
            <div class="int_content green_bg">

                <div class="section">
                    <h2 class="sub_title color_white jazzira_font_bold"><?= trans("front.apartment designs"); ?></h2>
                    <div class="section">
                        <div class="owl-carousel owl-theme plan_photos">

                            @foreach($img_plans as $plan)
                            <div class="item">
                                <a data-fancybox="plans-photos" href="<?= Helper::media_dev($plan, 'mob'/*Helper::get_device()*/); ?>">
                                    <?php $img_url = Helper::media_dev($plan, 'mob'); ?>
                                    
									<!--<img class="lazyimg" src="<?= $img_url; ?>" data-srcimg="<?= $img_url; ?>" alt="<?= $plan->getName(); ?>">-->
                                    {!! Helper::picture(['class'=>'','width'=>250,'hieght'=>250,'src'=>$img_url,'alt'=>$plan->getName() ]) !!}


					<?php /*<picture>
					   <source media="(min-width: 650px)" srcset="<?= $img_url ?>">
					   <source media="(max-width: 650px)" srcset="<?= $img_url ?>">
					   <img src="<?= $img_url ?>" class="lazy" 
					   loading="lazy" alt="<?= $plan->getName() ?>">
					</picture>*/ ?>
									
                                </a>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            @endif

            @endif



			<?php
			
			$f_lang = ($current_lang=='pe'?'fa':$current_lang);
			
			if($ccountry=='turkey'){
			$arr_keys = \App\Models\Keywords2::where('display','like','%;projects;%')->where('keyword_'.$f_lang,'!=','')->get();
			
			if(count($arr_keys)>0){
			?>
            <div class="int_content keywords_paragraph_sec">
                <h2 class="sub_title jazzira_font_bold"><?= trans("front.The most important and latest real estate projects"); ?></h2>
                
                <ul class="keywords_paragraph_list">
				<?php foreach($arr_keys as $r){ ?>
                    <li><p><strong><a title="{{ $r->getKeyword() }}" href="<?= $f_lang=='ar'?$r->url:str_replace('.com/','.com/'.$f_lang.'/',$r->url) ?>">{{ $r->getKeyword() }}</a></strong></p></li>
                <?php } ?>
                </ul>


            </div>
			<?php }} ?>
			

            <!-- share page links -->
            <?php //if (Helper::get_device() == 'mob') { ?> 
                <div class="sec">
                    @include("front.partials.share_links", [])
                </div>
            <?php //} ?>



            <!-- Start Statistic -->
            <div class="sec">
                <div class="row">
                    @include("front.partials.statistics_most", [])
                </div>
            </div>
            <!-- End Statistic -->






            <div class="int_content not_bg">

                <h2 class="sub_title jazzira_font_bold">{{ trans('front.similar projects') }}</h2>

                <div class="wrapper sec">

                    <div class="slider" <?php if ($style_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>

                        <div class="slider__wrap swiper-wrapper">
                            <?php
                            /* $similars = explode(",", $project->similar_projects);
                             */

                            //if(!isset($footer_prjs)){
                            $arr_ids = Helper::query("Fotterproject", "all")->where('country',$ccountry)->lists('project_id')->toArray();
                            $footer_prjs = \App\Models\Project::whereIn('id', $arr_ids)->get();
                            //}
                            ?>
                            @foreach($footer_prjs as $prj)
                            <?php
                            //$prj = Helper::query("Project", "find", ["id" => $similar]);
                            if (!$prj->id)
                                continue;
                            ?>
                            @include("front.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
                            @endforeach


                        </div>

                        <div class="slider__controls">

                            <div class="slider__pagination"></div>

                            <div class="slider__button-next"></div>
                            <div class="slider__button-prev"></div>
                        </div>


                        <a href="{{ route('front.search', ['property-for-sale', $ccountry]) }}" class="more shadow_type"><?= trans("front.More Projects") ?></a>

                    </div>

                </div>




            </div>


            <?php
            /* if ($current_lang == 'ar')
              $similarspost = $project->posts;
              elseif ($current_lang == 'en')
              $similarspost = $project->postsEn;
              elseif ($current_lang == 'fr')
              $similarspost = $project->postsFr;
              elseif ($current_lang == 'fa')
              $similarspost = $project->postsFa;
             */
            $similarspost = [];
            
            $params = Helper::query("BlogParam", "find", ["id" => ($ccountry=='turkey'?1:3)]);
            
            if ($params->featured_post != '')
                $similarspost = explode(",", $params->featured_post);


            if (count($similarspost) > 0) {
                ?>
                <div class="int_content not_bg">
                    <div class="similar_articles sec">
                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.related articles"); ?></h2>

                        <div class="wrapper sec">

                            <div class="slider video_slider" dir="<?= $current_lang === 'ar' ? 'rtl' : 'ltr' ?>">

                                <div class="slider__wrap swiper-wrapper">
                                    <?php $t = 0; ?>
                                    @foreach($similarspost as $id)
                                    <?php
                                    $spost = Helper::query("Post", "find", ["id" => $id]);
                                    if (!$spost->id)
                                        continue;
                                    ?>
                                    @include("front.partials.post_item", ["post" => $spost, "open_blank" => false, "class" => "card-small","page"=>"index"])
                                    @endforeach
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



        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div class="fixed_sec">
                
                <a data-fancybox="tour" href="#tour-content" data-target="#tour-content" class="tour_booking jazzira_font_bold"><i class="fa fa-calendar"></i> <?= trans("front.Book a tour"); ?></a>

                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>


                <!-- About Us -->
                @include("front.partials.about_sec", [])




                <!-- share page links -->
                <?php //if (Helper::get_device() == 'mob') { ?> 
                    <div class="sec">
                        @include("front.partials.share_links", [])
                    </div>
                <?php //} ?>



<?php /*
<!--                <div class="sec keywords_sec">
<h2 class="sub_title jazzira_font_bold">{{ trans('front.keywords') }}</h2>
<?php
$keyws = $project->getSeoKeywords();
if ($keyws != '') {
$arrk = explode(',', $keyws);
?>
<ul>
<?php
foreach ($arrk as $k) {
$k = trim($k);
if ($k != '') {
?>
<li><a href="<?= route("front.searchpage") . '?s=' . $k; ?>"><?= $k ?></a></li>
<?php
}
}
?>
</ul>


<?php } ?>

</div>-->
*/ ?>



            </div>
        </div>
        <!-- End Fixed Section -->



    </div>
</div>


<?= Form::open(["url" => route("front.callus2"), "id" => "gift", "class" => "formgift", "style" => "display: none; width: 100%; max-width: 660px;"]); ?>
<strong class="h2"><?= trans("front.enter your mobile"); ?></strong>
<strong class="h3"><?= trans("front.to send you a gift"); ?></strong>
<div class="fbgift">
    <div class="bname">
        <input type="text" value="" name="name" class="" placeholder="* <?= trans("front.name and fname"); ?>">
    </div>
    <div class="bmobile">
        <input type="text" value="{{ @session()->get('call_country') }}" name="mobile" id="mobile-sm" placeholder="+90 123456789" />
    </div>
    <input type="hidden" value="gift" name="type" />
    <div class="bsubmit">
        <button type="submit"></button>
    </div>
</div>
</form>



<!-- Tour Content Form -->


<div style="display: none;" id="tour-content">
    <span class="modal_title jazzira_font_bold"><i class="fa fa-calendar"></i> <?= trans("front.Free real estate tour"); ?></span>
    
    <div class="content_form">
        <img width="200" height="200" class="lazy image" loading="lazy" src="{{ Helper::get_thumbnail($project->cardphoto, 360, 360) }}" />
        
        <span class="project_id num">{{ $project->getNameEn() }}</span>
        <br>
        <span class="project_address">{{ @$project->region->getName() }} - {{ @$project->city->getName() }}</span>
        <br>
        <br>
        <span class="price_title jazzira_font_bold"><?= trans("front.approximate prices"); ?></span>
        <br>
		<?php

		/*$flavors = $project->flavors();
		$flavors = $flavors->where('sold_out', false); //عدم عرض سعر الشقق المباعة 
		$flavor = $flavors->orderBy("price", "ASC")->first();

		if (empty($flavor)) {*/
			$flavors = $project->flavors();
			$flavor = $flavors->orderBy("price", "ASC")->first();
		//}

		$project_min_price = Helper::decimal_format(@$flavor->price, $project->is_price_usd);
		
		?>
        <span class="price num">$ <?= $project_min_price ?></span>
    </div>
    
    <div class="form_sec">
        <?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>
            
            <div class="form-group">
                <label><?= trans("front.Tour form full name"); ?></label>
                <input class="form-control" type="text" name="name" />
            </div>
            <div class="form-group">
                <label><?= trans("front.Tour form phone number"); ?></label>
                <div class="tel"><input class="form-control" type="text" name="mobile" value="{{ @session()->get('call_country') }}" id="mobile-sm" placeholder=""></div>
            </div>
            <div class="form-group">
                <label><?= trans("front.Tour type"); ?></label>
                <select name="tour_type" class="form-control">
                    <option value=""><?= trans("front.Tour type"); ?></option>
                    <option value="Direct"><?= trans("front.Field Tour"); ?></option>
                    <option value="Online"><?= trans("front.Online Tour"); ?></option>
                </select>
            </div>
			
                    <input type="hidden" name="message" value="{{ trans('front.Free real estate tour') }}">
                    <input type="hidden" name="free_tour_form" value="1">
            <div class="form-group">
                <label><?= trans("front.Tour date"); ?></label>
                <div id="datepicker" class="input-group date" data-date-format="dd-mm-yyyy">
                    <input name="arrival_date" class="form-control" type="text" readonly />
					<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                </div>
            </div>
			<button type="submit" class="send send_tour_btn"><?= trans("front.Book Now"); ?></button>
        </form>
    </div>
    
</div>


@endsection







@section('scriptjs')


<?php if (App::isLocal()){ ?>
    <?= Html::script("resources/assets/js/myChart.js") ?>
    <?= Html::script("resources/assets/js/bootstrap-multiselect.js") ?>
    <?= Html::script("resources/assets/js/slick.min.js"); ?>

    
    <!--<?= Html::script("resources/assets/js/swiper.min.js"); ?>-->
<?php } else { ?>
    <!--<?= Html::script("js/main.min.js") ?>-->

    <?= Html::script("js/main_no_fancy.min.js") ?>
    <?= Html::script("js/jquery.fancybox.min.js") ?>
	
    <?= Html::script("js/chartscripts.min.js") ?>
    <!--<?= Html::script("js/myChart.min.js") ?>
    <?= Html::script("js/bootstrap-multiselect.min.js") ?>-->
    <?= Html::script("js/slick.min.js"); ?>
    <!--<?= Html::script("js/swiper.min.js"); ?>-->
<?php } ?>
	<?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"); ?>

<?php if($hide_maps==false){ ?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCro2ODdWVQ3owh4yopDw3xI8qagCkPpKU&libraries=places" async defer></script>
<!--    <script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCro2ODdWVQ3owh4yopDw3xI8qagCkPpKU<?= $is_mobile ? '' : '&callback=initMap'; ?>"></script>-->


<!--<script src="https://maps.googleapis.com/maps/api/js?sensor=true&libraries=places"></script>-->
<?php } ?>
<script>
    document.querySelectorAll(".slider__wrap.swiper-wrapper").forEach(curr => {
        curr.scrollLeft = <?= $current_lang === "ar" ? -100 : 100 ?>;
    });


<?php
$json3 = Helper::ajax_statics('', 'top_country', 0, 0);
$json4 = Helper::ajax_statics('', 'top_city', 0, 0);
?>

                        display_most_nat_data(<?= json_encode($json3) ?>);
                        display_most_city_data(<?= json_encode($json4) ?>);

                        $(document).ready(function () {

                            setTimeout(function () {
                                $(".map_btn_group a.active").trigger("click");
                            }, 2000);


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





                        $('select.currency').change(function () {
                            $('.tprice').addClass('hidden');
                            $('.tp' + $(this).val()).removeClass('hidden').removeClass('d-none');
                        });

                        $(window).scroll(function () {
                            var scrollingPage = 0;
                            var scrollingPage2 = 0;
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


                        $(document).ready(function () {
                            $('.main_menu .links>li>a.projects_btn').addClass("active");


                        });


                        $('.slider-for').slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false,
                            fade: true,
                            asNavFor: '.slider-nav'
                        });
                        $('.slider-nav').slick({
                            slidesToShow: 5,
                            slidesToScroll: 1,
                            autoplay: true,
                            autoplaySpeed: 3000,
                            asNavFor: '.slider-for',
                            dots: false,
                            arrows: true,
                            centerMode: true,
                            focusOnSelect: true,
                            lazyload: 'ondemand',
                            responsive: [
                                {
                                    breakpoint: 1200,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1
                                    }
                                },
                                {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 1,
                                        centerMode: false
                                    }
                                }
                            ]
                        });



                        $('.like').click(function () {
                            $(this).toggleClass("active");
                        });

                        $('.video_fancybox').fancybox({
                            youtube: {
                                autoplay: 1
                            }
                        });

/*
//    $('.plan_photos').owlCarousel({
//        items: 3,
//        loop: false,
//        margin: 15,
//        nav: true,
//        dots: true,
//        arrow: false,
//        lazyLoad: true,
//        rtl: true,
//        autoplay: true,
//        autoplayTimeout: 4000,
//        responsive: {
//            0: {
//                items: 1,
//                nav: true
//            },
//            600: {
//                items: 2,
//                nav: false
//            },
//            1024: {
//                items: 2,
//                nav: true,
//                loop: false
//            },
//            1280: {
//                items: 3,
//                nav: true,
//                loop: false
//            }
//        }
//    });
*/

                        window.onload = function () {
                            $(".main_slider").addClass("loaded");
                        };




<?php if($hide_maps==false){ ?>
                        function initializePropertyMap(placeType) {


                            var latlng = new google.maps.LatLng(<?= $project->latitude . ',' . $project->longitude ?>);
                            var marker;
                            /*var i;*/

                            var myOptions = {
                                zoom: 13,
                                center: latlng,
                                scrollwheel: false,
                                styles: [
                                    {
                                        "featureType": "water",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#a0d6d1"
                                            },
                                            {
                                                "lightness": 17
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "landscape",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#ffffff"
                                            },
                                            {
                                                "lightness": 20
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.highway",
                                        "elementType": "geometry.fill",
                                        "stylers": [
                                            {
                                                "color": "#dedede"
                                            },
                                            {
                                                "lightness": 17
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.highway",
                                        "elementType": "geometry.stroke",
                                        "stylers": [
                                            {
                                                "color": "#dedede"
                                            },
                                            {
                                                "lightness": 29
                                            },
                                            {
                                                "weight": 0.2
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.arterial",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#dedede"
                                            },
                                            {
                                                "lightness": 18
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "road.local",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#ffffff"
                                            },
                                            {
                                                "lightness": 16
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "poi",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#f1f1f1"
                                            },
                                            {
                                                "lightness": 21
                                            }
                                        ]
                                    },
                                    {
                                        "elementType": "labels.text.stroke",
                                        "stylers": [
                                            {
                                                "visibility": "on"
                                            },
                                            {
                                                "color": "#ffffff"
                                            },
                                            {
                                                "lightness": 16
                                            }
                                        ]
                                    },
                                    {
                                        "elementType": "labels.text.fill",
                                        "stylers": [
                                            {
                                                "saturation": 36
                                            },
                                            {
                                                "color": "#333333"
                                            },
                                            {
                                                "lightness": 40
                                            }
                                        ]
                                    },
                                    {
                                        "elementType": "labels.icon",
                                        "stylers": [
                                            {
                                                "visibility": "off"
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "transit",
                                        "elementType": "geometry",
                                        "stylers": [
                                            {
                                                "color": "#f2f2f2"
                                            },
                                            {
                                                "lightness": 19
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "administrative",
                                        "elementType": "geometry.fill",
                                        "stylers": [
                                            {
                                                "color": "#fefefe"
                                            },
                                            {
                                                "lightness": 20
                                            }
                                        ]
                                    },
                                    {
                                        "featureType": "administrative",
                                        "elementType": "geometry.stroke",
                                        "stylers": [
                                            {
                                                "color": "#fefefe"
                                            },
                                            {
                                                "lightness": 17
                                            },
                                            {
                                                "weight": 1.2
                                            }
                                        ]
                                    }
                                ]
                            };


                            map = new google.maps.Map(document.getElementById('new_map'), myOptions);
                            infowindow = new google.maps.InfoWindow();

                            var svgMarker = {
                                path: "M8,0C3.6,0,0,3.6,0,8c0,4.7,8,13.8,8,13.8s8-8.8,8-13.8C16,3.6,12.4,0,8,0z M8,12.6c-2.7,0-4.9-2.2-4.9-4.9C3.1,5,5.3,2.7,8,2.7c2.7,0,4.9,2.2,4.9,4.9C12.9,10.4,10.7,12.6,8,12.6z",
                                fillColor: "#d52323",
                                width: 50,
                                fillOpacity: 1,
                                strokeWeight: 0,
                                rotation: 0,
                                scale: 2,
                                anchor: new google.maps.Point(15, 30),
                            };


                            marker = new google.maps.Marker({
                                position: latlng,
                                icon: svgMarker,
                                animation: google.maps.Animation.DROP,
                                map: map
                            });

                            /*If no place type is passed, use school as the default*/
                            if (placeType) {
                                var place = placeType;
                            } else {
                                var place = 'school';
                            }

                            /*Google Places*/
                            var request = {
                                location: latlng,
                                radius: 10000,
                                types: [place]
                            };
                            var service = new google.maps.places.PlacesService(map);
                            service.nearbySearch(request, callback);

                            function callback(results, status) {
                                if (status == google.maps.places.PlacesServiceStatus.OK) {

                                    for (var i = 0; i < results.length; i++) {

                                        /*Create a count for places which are present in the 'get details' Google service only, to give an accurate 'total amount' figure*/
                                        var count = 0;

                                        /*Pass each place to the 'get details' Google service (so you can get address, phone etc of each place) and then create a marker         */
                                        service.getDetails(results[i], function (place, status) {

                                            /*If the place is present in the 'get details' Google service, add it to the map*/
                                            if (status == google.maps.places.PlacesServiceStatus.OK) {


                                                var icon_marker = {
                                                    url: "/img/location-" + placeType + ".png",
                                                    size: new google.maps.Size(40, 50),
                                                    origin: new google.maps.Point(0, 0),
                                                    anchor: new google.maps.Point(15, 30)
/*
//                                                    fillColor: "#555555",
//                                                    width: 50,
//                                                    fillOpacity: 0.8,
//                                                    strokeWeight: 0,
//                                                    rotation: 0,
//                                                    scale: 2,
//                                                    anchor: new google.maps.Point(15, 30)
*/
                                                };

                                                var marker = new google.maps.Marker({
                                                    map: map,
                                                    icon: icon_marker,
                                                    position: place.geometry.location
                                                });

                                                /*On click of place marker, open the info window*/
                                                google.maps.event.addListener(marker, 'click', function () {

                                                    /*Build up tooltip content*/
                                                    var tooltipContent = '<div class="tooltip">';
                                                    tooltipContent += '<strong>' + place.name + '</strong><br />';
                                                    tooltipContent += place.formatted_address.replace(/,/g, '<br />') + '<br /><br />';

                                                    if (place.formatted_phone_number) {
                                                        tooltipContent += 'Tel: ' + place.formatted_phone_number + '<br />';
                                                    }
                                                    if (place.website) {
                                                        tooltipContent += '<a href="' + place.website + '" target="_blank">' + place.website.replace('http://', '').replace(/\/$/, '') + '</a>';
                                                    }

                                                    tooltipContent += '</div>';

                                                    infowindow.setContent(tooltipContent);
                                                    infowindow.open(map, this);
                                                });
                                                count++;
                                            }
                                        });
                                    }
                                }
                            }

                            /*Change map center on window size change*/
                            var center;

                            function calculateCenter() {
                                center = map.getCenter();
                            }
                            google.maps.event.addDomListener(map, 'idle', function () {
                                calculateCenter();
                            });
                            google.maps.event.addDomListener(window, 'resize', function () {
                                map.setCenter(center);
                            });
                        }

                        google.maps.event.addDomListener(window, 'load', initializePropertyMap());



                        $(".map_btn_group a").on("click", function () {
                            $(".map_btn_group a").removeClass("active");
                            $(this).addClass("active");
                        });

<?php } ?>



$(function () {
  $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
        startDate: new Date(),
        endDate: '+7d'
  });
});



//types: ['mosque']

//var map;
//var infowindow;
//
//function initialize() {
//    var pyrmont = new google.maps.LatLng(40.992657, 28.827093);
//
//    map = new google.maps.Map(document.getElementById('new_map'), {
//        mapTypeId: google.maps.MapTypeId.ROADMAP,
//        center: pyrmont,
//        zoom: 15
//    });
//
//    var request = {
//        location: pyrmont,
//        radius: 3000,
//        types: parseInt(document.getElementById('serviceType').value)
//                //types: ['mosque']
//    };
//    infowindow = new google.maps.InfoWindow();
//    var service = new google.maps.places.PlacesService(map);
//    service.search(request, callback);
//}
//
//function callback(results, status) {
//    if (status == google.maps.places.PlacesServiceStatus.OK) {
//        for (var i = 0; i < results.length; i++) {
//            createMarker(results[i]);
//        }
//    }
//}
//
//function createMarker(place) {
//    var placeLoc = place.geometry.location;
//    var marker = new google.maps.Marker({
//        map: map,
//        position: place.geometry.location,
//        animation: google.maps.Animation.DROP
//    });
//
//    google.maps.event.addListener(marker, 'click', function () {
//        infowindow.setContent(place.name);
//        infowindow.open(map, this);
//    });
//}
//
//google.maps.event.addDomListener(window, 'load', initialize);
//
//
//
//
//$(".map_btn_group a").on("click", function () {
//    var serviceType = $(this).attr("data-name");
//    $("#serviceType").val(serviceType);
//    setTimeout(function () {
//        initialize();
//    }, 1000);
//
//});




//
//var map;
//function initMap() {
//
//    map = new google.maps.Map(document.getElementById('new_map'));
//    var infowindow;
//    var myPlace = {lat: 25.276987, lng: 55.296249};
//    var service = new google.maps.places.PlacesService(map);
//
//    service.nearbySearch({
//        location: myPlace,
//        radius: 5500,
//        type: ['restaurant']
//    }, callback);
//
//    function callback(results, status) {
//        if (status === google.maps.places.PlacesServiceStatus.OK) {
//            for (var i = 0; i < results.length; i++) {
//                createMarker(results[i]);
//            }
//        }
//    }
//
//    function createMarker(place) {
//        var placeLoc = place.geometry.location;
//        var marker = new google.maps.Marker({
//            map: map,
//            position: place.geometry.location
//        });
//
//        google.maps.event.addListener(marker, 'click', function () {
//            infowindow.setContent(place.name);
//            infowindow.open(map, this);
//        });
//    }
//
//}


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
//                window.location.href = "/turkish-citizenship";
//            } else {
//                /* alert("right swipe"); */
//                window.location.href = "/stories";
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
    {"@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[

    {"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
    {"@type":"ListItem","position":2,"name":"{{ trans('front.property for sale') .' '. @$project->city->getName() }}","item":"{{ route("front.search", ["property-for-sale", @$project->city->getSlug()]) }}"}
	<?php if(isset($pptype[0])){ $i=3; ?>
	,{"@type":"ListItem","position":3,"name":"{{ @$pptype[0]->getName() }} {{ @$project->city->getName() }}","item":"{{ route("front.search", [@$pptype[0]->getSlug(), @$project->city->getSlug()]) }}"}
	<?php if(isset($ppcateg[0])){ $i++; ?>
	,{"@type":"ListItem","position":<?= $i ?>,"name":"{{ @$ppcateg[0]->getName() }}","item":"{{ route('front.search', [@$pptype[0]->getSlug(), @$project->city->getSlug(), @$ppcateg[0]->getSlug()]) }}"}
    <?php } $i++; ?>
	,{"@type":"ListItem","position":<?= $i ?>,"name":"{{ $project->getSeoTitle()!=''?$project->getSeoTitle():$project->name_en }}","item":"{{ Request::url() }}"}
	<?php } ?>

    ]}
</script>
<?php
if ($video_code == '')
    if ($video_code2 != '')
        $video_code = $video_code2;
if ($video_code != '') {
    $post_video = \App\Models\Video::where('link', 'like', '%' . $video_code . '%')->first();

    if (isset($post_video)) {
        if ((int) $post_video->project_id != 0)
            $vtitle = $post_video->project->getIntroCard();
        else
            $vtitle = $post_video->title;
        ?>
        <script type="application/ld+json">{
            "@context": "http://schema.org",
            "@type": "VideoObject",
            "name": "{{ htmlentities(mb_substr($vtitle, 0, 45, 'UTF-8')) }}...",
            "description": "{{ htmlentities($vtitle)  }}",
            "thumbnailUrl": "https://i.ytimg.com/vi/<?= $video_code ?>/default.jpg",
            "uploadDate": "<?= date(DATE_ISO8601, strtotime($post_video->date_published)) ?>",<?php //2021-12-23T13:02:56Z                                                  ?>
            "duration": "<?= $post_video->duration ?>",
            "embedUrl": "https://www.youtube.com/embed/<?= $video_code ?>",
            "interactionCount": "{{ $post_video->views  }}"
            }</script>
        <?php
    }
}
?>
@endsection