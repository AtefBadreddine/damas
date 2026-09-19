<!DOCTYPE html>
<html lang="<?= $lang; ?>" dir="<?= $lang == "ar" ? "ltr" : "ltr"; ?>">
    <?php
    $current_locale = $lang;
    $current_lang = $lang;
    $infos = Helper::get_params();
    $localecode = $lang == "en" ? "ar" : "en";
    $style_lang = in_array($current_lang, ['en', 'fr','ru']) ? 'en' : 'ar';
    $project = $landing->project;
    $is_search_p = true;
    
	$youtube_profile = '';
	if($lang == "ar")
		$youtube_profile = "nhhdq_9I5NU";
	elseif($lang == "en")
		$youtube_profile = "uL6qeYqix58";
	elseif($lang == "fr")
		$youtube_profile = "k7l1o9nWtqs";
	elseif($lang == 'pe')
		$youtube_profile = "k7l1o9nWtqs";
    
	
	?>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?= asset("img/favicon.png"); ?>" />



        <title><?= $project->getSeoTitle() != '' ? $project->getSeoTitle() : $infos->seo_title ?></title>
        <link rel="canonical" href="<?= Request::url(); ?>" />
        <meta property="og:url" content="<?= Request::url(); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= $project->getName() ?>" />
        <meta property="og:image" content="<?= Helper::media_url_full($project->cardphoto); ?>" />
        <meta property="og:image:width" content="900" />
        <meta property="og:image:height" content="500" />

        <meta property="og:description" content="<?= $project->getSeoDescription(); ?>">
        <meta name="description" content="<?= $project->getSeoDescription(); ?>">

<!--
        <meta name="google-site-verification" content="PmYCX7XymrFMhPwuJbsruVgqsZcWxsWlNHFZufj-wd8" />
		-->
		
		
            <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700&display=swap&subset=arabic" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&display=swap" rel="stylesheet">
			
        <?php if (App::isLocal()) { ?>



            <!--pluguins.min.css-->
            <?= Html::style("resources/assets/css/bootstrap.min.css"); ?>
            <!--Helper::local_url-->
            <?= Html::style("resources/assets/css/owl.carousel.min.css"); ?>
            <?= Html::style("resources/assets/css/intlTelInput.css"); ?>
            <?= Html::style("resources/assets/css/jquery.fancybox.min.css"); ?>
            <?= Html::style("resources/assets/css/font-awesome.min.css"); ?>
            <?= Html::style("resources/assets/css/bootstrap-select.min.css"); ?>
            <?= Html::style("resources/assets/css/jquery-ui-autocomplete.css"); ?>
            <?= Html::style("resources/assets/css/animate.min.css"); ?>
            <?= Html::style("resources/assets/css/font-awesome-animation.css"); ?>

            @yield('styles')



            <?= Html::style("resources/assets/css/bootstrap-multiselect.css"); ?>

            <?= Html::style("resources/assets/css/myChart.css"); ?>
            <?= Html::style("resources/assets/css/slider-project-card.css"); ?>


            <?= Html::style("resources/assets/css/newHeader.css"); ?>
            <?= Html::style("resources/assets/css/landing.css"); ?>

            @if($lang == 'en' || $lang == 'fr')
            <?= Html::style("resources/assets/css/landing-en.css"); ?>
            @endif





        <?php } else { //online  ?>

            
			
			
			
			
			<!--pluguins.min.css-->
            <?= Html::style("css/bootstrap.min.css"); ?>
            <!--Helper::local_url-->
            <?= Html::style("css/owl.carousel.min.css"); ?>
            <?= Html::style("css/intlTelInput.css"); ?>
            <?= Html::style("css/jquery.fancybox.min.css"); ?>
            <?= Html::style("css/font-awesome.min.css"); ?>
            <?= Html::style("css/bootstrap-select.min.css"); ?>
            <?= Html::style("css/jquery-ui-autocomplete.css"); ?>
            <?= Html::style("css/animate.min.css"); ?>
            <?= Html::style("css/font-awesome-animation.css"); ?>

            @yield('styles')



            <?= Html::style("css/bootstrap-multiselect.css"); ?>

            <?= Html::style("css/myChart.css"); ?>
            <?= Html::style("css/slider-project-card.css"); ?>


            <?= Html::style("css/newHeader.css"); ?>
            <?= Html::style("css/landing.css"); ?>

            @if($lang == 'en' || $lang == 'fr')
            <?= Html::style("css/landing-en.css"); ?>
            @endif
			
			
			
			
			
			
			
			
			<style><?php //include(public_path() . "/css/landing.min.css"); ?></style>
            @if($lang == 'en' || $lang == 'fr')
            <?php // Html::style("css/landing-en.min.css"); ?>
            @endif
            <?php
        }
        ?>

        <style>
            .hidden{display:none}
        </style>
        <?php if ($current_lang == 'ar' || $current_lang == 'pe') { ?>
            <style>
                @font-face {
                    font-family: 'Al-Jazeera-Arabic Regular';
                    src: url('../fonts/ar/Al-Jazeera-Arabic Regular.eot');
                    src: url('../fonts/ar/Al-Jazeera-Arabic Regular.eot?#iefix') format('embedded-opentype'),
                        url('../fonts/ar/Al-Jazeera-Arabic Regular.woff2') format('woff2');
                    font-weight: normal;
                    font-style: normal;
                }

                @font-face {
                    font-family: 'Al-Jazeera-Arabic-Regular';
                    src: url('../fonts/ar/Al-Jazeera-Arabic-Regular.svg#Al-Jazeera-Arabic-Regular') format('svg'),
                        url('../fonts/ar/Al-Jazeera-Arabic-Regular.ttf') format('truetype'),
                        url('../fonts/ar/Al-Jazeera-Arabic-Regular.woff') format('woff');
                    font-weight: normal;
                    font-style: normal;
                }

                @font-face {
                    font-family: 'Al-Jazeera-Arabic Bold';
                    src: url('../fonts/ar/Al-Jazeera-Arabic Bold.eot');
                    src: url('../fonts/ar/Al-Jazeera-Arabic Bold.eot?#iefix') format('embedded-opentype'),
                        url('../fonts/ar/Al-Jazeera-Arabic Bold.woff2') format('woff2');
                    font-weight: normal;
                    font-style: normal;
                }

                @font-face {
                    font-family: 'Al-Jazeera-Arabic-Bold';
                    src: url('../fonts/ar/Al-Jazeera-Arabic-Bold.svg#Al-Jazeera-Arabic-Bold') format('svg'),
                        url('../fonts/ar/Al-Jazeera-Arabic-Bold.ttf') format('truetype'),
                        url('../fonts/ar/Al-Jazeera-Arabic-Bold.woff') format('woff');
                    font-weight: normal;
                    font-style: normal;
                }

            </style>

        <?php } ?>
        <!--[if lt IE 9]>
        <script src="<?= asset("js/html5shiv.min.js"); ?>"></script>
        <script src="<?= asset("js/respond.min.js"); ?>"></script>
        <![endif]-->

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



        <style>
            .youtube-video img,.about_video img{width:100%}
            .about_video{display: block;clear: both;
                         position:relative;}
            .youtube-video a{display:block}
            .youtube-video{text-align:center;cursor:pointer;clear: both;
                           position: relative;}
            .about_video:before,.youtube-video a:before {
                content: "";
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 999;
                background-image: url(/img/play-icon.svg);
                background-repeat: no-repeat;
                background-size: 50px;
                background-position: center;
            }
        </style>
    </head>

    <body>

        <?php if (!App::isLocal()) { ?>
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQMR57V"
                              height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                              <?php /* <!-- End Google Tag Manager (noscript) -->

                                <!--------**** Start Show  notifications ****-------->
                                <div class="notifications-top animated" id="subscribe-notifications-container" style="display:none;">
                                <strong class="close-alert"><i class="fa fa-times" aria-hidden="true"></i></strong>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                <p>إضغط على زر «Allow» ليصلك أحدث العروض<br><strong>وتخفيضات العقارات في تركيا</strong></p>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 margin-top">
                                <button id="block_subscribe">Block</button>
                                <button id="subscribe-notifications">Allow</button>
                                <span><i class="fa fa-angle-double-down bounce" aria-hidden="true"></i></span>
                                <img src="<?= asset("img/alert-icon.svg"); ?>" alt="Damas"/>
                                <!--                <img class="arrow-gif" src="<?= asset("img/Arrow.gif"); ?>" alt="Damas"/>-->
                                </div>
                                </div>
                                <!--------**** End Show  notifications ****--------> */ ?>
                          <?php } ?>

        <div class="big_sec">

            <!-- Start Header -->
            <header class="header animated">
                <nav class="navbar navbar-expand-sm">

                    <div class="sub">
                        <a class="navbar-brand mob" href="javascript:;">
                            <img src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
                        </a>
                        <!--
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-2" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>-->
                        <div class=" navbar-collapse">

                            <div class="all_select_sec">

                                <select class="selectpicker currency" onchange="window.location = this.options[this.selectedIndex].value">
                                    <?php $selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;   ?>
                                    <?php
                                    $ex = unserialize($infos->exchange);
                                    if ($ex)
                                        foreach ($ex as $k => $v) {
                                            if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND'))) {
                                                ?>
                                                <option data-icon="flag_icon <?= $k ?>" class="<?= $k ?>" <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= route('front.currency', [$k]); ?>"><?= $k ?></option>
                                                <?php
                                            }
                                        }
                                    ?>

                                </select>

                            </div>


                            <div class="sosial_media_links">
                                <a  target="_blank" href="{{ route('front.whatsapp_share') }}?icon=7&tel=905551605000" class="whatsapp"><div class="button icon" role="button"></div> <span>+90 555 160 50 00</span></a>
                            </div>


                        </div>
                    </div>
                </nav>

                <div class="main_menu">
                    <a class="navbar-brand full" href="javascript:;">
                        <img src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
                    </a>
                    <ul class="links">
                        <li><a href="#photos" class="active"><div class="icon photos"></div></a></li>
                        <li><a href="#information"><div class="icon information"></div></a></li>
                        <li><a href="#plan"><div class="icon location"></div></a></li>
                        <li><a href="#project-video"><div class="icon video"></div></a></li>
                        <li><a href="#prices"><div class="icon prices"></div></a></li>
                        <li><a href="#contact" class="contact_link"><div class="icon contact"></div></a></li>
                    </ul>
                </div>


            </header>
            <!-- End Header -->




            <!-- Start Mob -->
            <?php //if (Helper::get_device() == 'mob') { ?>


                <div class="all_contents d-block d-sm-none">


                    <!-- start slider -->
                    <section id="section_home" class="land_mobile land_<?= $current_lang ?>_mobile">
                        <div class="full-container main-container">
                            <?php
                            $slider = $landing->background;

                            $images = $project->projectPhotos;
                            ?>
                            {!! Helper::get_pic(Helper::media_url($slider),'img-fluid top_big_photo','','',$slider->getTitle()) !!}
                        </div>

                        <div id="photos" class="targetHref"></div>

                        <div class="owl-carousel owl-theme owl-landing">

                            <?php if (@$images[0]->path_mobile != '') { /**/ ?>

                                <?php $i = 0; ?>
                                @foreach($images as $k => $img)
                                <?php
                                $img_url = Helper::get_thumbnail($img, 220, 220, true);
                                $imgslid = $img_url;
                                $i++;
                                $lazy = ($i < 4 || $i == count($images) ? '' : 'lazy');
                                //
                                ?>
                                <div class="item">
                                    <a data-fancybox="gallery" href="<?= Helper::get_thumbnail($img, null, null, true); ?>" class="<?= $k == 0 ? "first" : ""; ?>" style="">
                                        {!! Helper::get_pic($imgslid,'image-responsive '.$lazy,'','',$img->getDescription()) !!}                    
                                    </a>
                                </div>
                                @endforeach

                            <?php } else {//computer   ?>
                                @foreach($images as $k => $img)
                                <?php
                                $img_url = Helper::media_url($img);
                                ?>
                                <div class="item">
                                    <a data-fancybox="gallery" href="<?= $img_url; ?>" class="<?= $k == 0 ? "first" : ""; ?>">
                                        {!! Helper::get_pic(Helper::get_thumbnail($img, 330,191),'image-responsive lazy','','',$img->getDescription()) !!}   
                                    </a>
                                </div>

                                @endforeach
                            <?php } ?>
                        </div>
                        <!-- /.container -->
                    </section>
                    <!-- end slider -->


                    <!-- Start Form -->
                    <div class="col-md-12">
                        <section class="form shadow_type">
                            @include("front.partials.call_us_fixed")
                        </section>
                    </div>
                    <!-- end Form -->



                    <!-- Start Left Section -->
                    <div class="left_sec">


                        <div class="padding_mob">
                            <div class="int_content">

                                <div id="information" class="targetHref"></div>

                                <div class="section information_mob">
                                    <div class="top_sec">

                                        <h1 class="project_name"><strong class="number"><?= @$project->getNameEn(); ?></strong> <?= trans("front.project"); ?></h1>

                                        <div class="btn_group">
                                            <a class="green_btn gift" data-fancybox="gift" data-src="#gift" data-touch="false"><span class="icon"></span><span><?= trans("front.gift"); ?></span></a>
                                            <a class="green_btn like likeCardItem <?= in_array($project->id, session()->get("likedprojects.ids", [])) ? 'active' : ''; ?>" data-url="<?= route("front.likeitem"); ?>" data-typ="project" data-code="<?= $project->id; ?>"><span class="icon"></span><span><?= trans("front.like"); ?></span></a>

                                            <div class="dropdown share">
                                                <button class="btn btn-primary dropdown-toggle green_btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="icon"></span> <?= trans("front.share"); ?>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="fa fa-twitter" href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fdamas.net%2Flanding%2F<?= $project->name_en ?>&amp;text=<?= urlencode(trans("front.project") . ' ' . @$project->getNameEn() . ' ' . @$project->city->getName()) ?>&amp;via=damasturk" target="_blank"></a>
                                                    <a target="_blank" class="fa fa-facebook" href="https://facebook.com/sharer.php?u=https%3A%2F%2Fdamas.net%2Flanding%2F<?= $project->name_en ?>"></a>
                                                    <a class="fa fa-whatsapp" href="https://api.whatsapp.com/send?text=https%3A%2F%2Fdamas.net%2Flanding%2F<?= $project->name_en ?>" target="_blank"></a>
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
                                            <p><?= trans("front.City Center"); ?></p><span><strong class="num"><?= trim(str_replace('كم', '', $project->distance_center)); ?></strong> km</span>
                                        </li>
                                        <?php
                                        list($sclass, $slab) = $project->getStatus();
                                        if ($sclass == 'under-construction') {
                                            ?>
                                            <li class="status under-construction">
                                                <div class="icon"></div>
                                                <p><?= trans("front.under cons"); ?></p><span><?= date("Y/m", strtotime($project->delivered_date)); ?></span>
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
                                                <p> <strong class="num"><?= $project->payment_months ?></strong> <?= trans("front.months"); ?></p>
                                            </li>
                                        <?php } ?>

                                    </ul>

									<?php /*
                                    <!--                                    <ul class="project_icons">
                                                                            <li class="region">
                                                                                <div class="icon"></div>
                                                                                <p><?= @$project->city->getName(); ?></p>
                                                                                <span><?= @$project->region ? @$project->region->getName() : null; ?></span>
                                                                            </li>
                                    
                                    <?php
                                    $typesarr = $project->types()->lists("name_" . ($current_lang=='pe'?'fa':$current_lang) )->toArray();
                                    ?>
                                                                            <li class="type">
                                                                                <div class="icon"></div>
                                    <?php
                                    if (count($typesarr) > 1)
                                        echo '<p>' . implode('، ', $typesarr) . '</p>';
                                    else
                                        echo '<p>' . implode('، ', $typesarr) . '</p>';
                                    ?>
                                                                            </li>
                                                                            <li class="date">
                                                                                <div class="icon"></div>
                                                                                <p class="number"><?= date("Y/m", strtotime($project->delivered_date)); ?></p>
                                                                            </li>
                                    
                                    <?php list($sclass, $slab) = $project->getStatus(); ?>
                                                                            <li class="status <?= $sclass ?>"> ready / resell 
                                                                                <div class="icon"></div>
                                                                                <p><?= $slab ?></p>
                                                                            </li>
                                                                            <li class="target">
                                    
                                                                                <div class="icon"></div>
                                                                                <p><?= trim(str_replace('', 'كم', $project->distance_center)); ?></p>
                                                                            </li>
                                                                        </ul>-->*/ ?>


                                    <span class="line_space"></span>


                                    <div class="padding_mob prices_table">
                                        <div id="prices" class="targetHref"></div>

                                        <div class="section prices">
                                            <h2 class="sub_title margin_bottom_20"><span><?= trans("front.approximate prices"); ?></span><span class="payment_method_types"><?= trans('front.' . $project->payment_method); ?></span></h2>

                                            @include("front.partials.project_prices_landing", ["project" => $project, "style_lang" => $style_lang ])

                                        </div>
                                    </div>





                                </div>
                            </div>
                        </div>




                        <?php
                        $link_video = $project->getLinkVideo();
                        parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
                        $video_code = @$array_of_vars['v'];
                        ?>
                        @if($video_code)
                        <div class="padding_mob">
                            <div class="int_content">

                                <div id="project-video" class="targetHref"></div>

                                <div class="section">
                                    <h2 class="sub_title">{{ trans('front.videos') }}</h2>

                                    <section class="youtube-video" id="section_images_videos">
                                        <a data-fancybox="project-video" href="https://www.youtube.com/embed/<?= $video_code; ?>">
                                            <img class="cover lazy" src="https://i.ytimg.com/vi/<?= $video_code; ?>/hqdefault.jpg">
                                                                                    <!--<iframe  src="https://www.youtube.com/embed/<?= $video_code; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen  data-hj-allow-iframe=""></iframe>-->
                                        </a>
                                    </section>

                                </div>
                            </div>
                        </div>
                        @endif




                        <div class="padding_mob">
                            <div class="int_content">

                                <div class="sub_section">
                                    <h2 class="sub_title"><?= trans("front.facilities and features"); ?></h2>
                                    <ul class="explained"> <?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntroFeatures()))); ?> </ul>
                                </div>


                                <ul class="features">
                                    @foreach($project->features as $feature)
                                    <li><span class="fa fa-check"></span> <?= $feature->getName(); ?></li>
                                    @endforeach
                                </ul>





                                @if($project->getIntoLocation())
                                <span class="line_space"></span>
                                <div class="sub_section">
                                    <h2 class="sub_title"><?= trans("front.location and strategic importance"); ?></h2>

                                    <ul class="explained">
                                        <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntoLocation()))); ?></li>
                                    </ul>

                                </div>
                                @endif



                                <?php $p_governmental = $project->getGovernmental(); ?>
                                @if($p_governmental)
                                <span class="line_space"></span>
                                <div class="sub_section">
                                    <h2 class="sub_title"><?= trans("front.service institutions"); ?></h2>

                                    <ul class="explained">
                                        <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_governmental))); ?></li>
                                    </ul>
                                </div>
                                @endif

                                <span class="line_space"></span>

                                <div class="sub_section">
                                    <h2 class="sub_title"><?= trans("front.location"); ?></h2>
                                    <?php $p_location = $project->getLocation(); ?>
                                    @if($p_location)
                                    <ul class="explained">
                                        <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_location))); ?></li>
                                    </ul>
                                    @endif



                                    <section class="map" id="map">
                                        <?php /*<a title="انقر لعرض الخريطة" data-fancybox="map" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://www.google.com/maps/search/?api=1&amp;query=<?= $project->latitude; ?>,<?= $project->longitude; ?>&amp;z=8">
                                             https://maps.googleapis.com/maps/api/staticmap?center=<?= $project->latitude; ?>,<?= $project->longitude; ?>&zoom=8&scale=1&size=389x389&markers=label:|<?= $project->latitude; ?>,<?= $project->longitude; ?>&maptype=roadmap&format=png&visual_refresh=true&key=AIzaSyBS1R9vx3GKUt4_6nXZgE178tJte4tzqoE 
                                            <!--<img data-src="https://www.aqsaway.com/map.php?size=389x389&latitude=<?= $project->latitude; ?>&longitude=<?= $project->longitude; ?>" class="lazy"/>-->
                                            {!! Helper::picture(['class'=>'lazy' , 'src'=> 'https://www.aqsaway.com/map.php?size=1200x200&latitude=' . $project->latitude . '&longitude=' . $project->longitude  ]) !!}*/ ?>
											<iframe width="100%" height="350" style="height:350px" loading="lazy" frameborder="0" class="lazy" style="border:0" src="https://maps.google.com/maps?q=<?= $project->latitude ?>,<?= $project->longitude ?>&amp;hl=es;z=14&amp;output=embed"></iframe>
                                        <!--</a>-->
                                    </section>



                                </div>

                                <span class="line_space"></span>

                                <div class="sub_section">
                                    <h2 class="sub_title"><?= trans("front.transportation"); ?></h2>
                                    <?php $p_transportation = $project->getTransportation(); ?>
                                    @if($p_transportation)
                                    <ul class="explained">
                                        <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_transportation))); ?></li>
                                    </ul>
                                    @endif
                                </div>

                                <span class="line_space"></span>

                                <div class="sub_section">
                                    <h2 class="sub_title"><?= trans("front.future look"); ?></h2>
                                    <?php $p_future_look = $project->getFutureLook(); ?>
                                    @if($p_future_look)
                                    <ul class="explained">
                                        <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_future_look))); ?></li>
                                    </ul>
                                    @endif
                                </div>

                            </div>
                        </div>




                        <?php $img_plans = $project->planPhotos; ?>
                        @if(count($img_plans))
                        <div class="int_content green_bg">

                            <div id="plan" class="targetHref"></div>

                            <div class="section">
                                <h2 class="sub_title color_white"><?= trans("front.apartment designs"); ?></h2>
                                <div class="section">
                                    <div class="owl-carousel owl-theme plan_photos">

                                        @foreach($img_plans as $plan)
                                        <div class="item">
                                            <a data-fancybox="plan-photo" 
                                               href="<?= Helper::media_dev($plan, 'mob'); ?>">
                                                   <?php $img_url = Helper::media_dev($plan, 'mob'); ?>
                                                <!--<img class="lazy" src="<?= $img_url; ?>" data-srcimg="<?= $img_url; ?>" alt="<?= $plan->getName(); ?>">-->
                                                {!! Helper::picture(['class'=>'lazy','src'=>$img_url,'alt'=>$plan->getName() ]) !!}
                                            </a>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="padding_mob statistics_sec_mob">
                            <div class="int_content">
                                <div id="location" class="section">
                                    <h2 class="sub_title"><?= trans("front.Region Report"); ?></h2>

                                    <!-- Start Statistics Section -->
                                    <?php
                                    $r_reg = $project->region;
                                    $region_name = @$r_reg->getName();
                                    $region_name_en = @$r_reg->getNameEn();
                                    $statics_results = DB::select('select * from stat_region where name = ?', [$region_name_en]);

                                    if (count($statics_results) > 0) {
                                        $reg = $statics_results[0];
                                        $data_demog = Helper::parse_statistcics($reg, 'demographique');
                                        ?>
                                        @include("front.partials.statistics_most", [])
                                        <!-- end Statistics Section -->
                                    <?php } ?>

                                </div>
                            </div>
                        </div>



                        <div class="int_content turkish_citizenship_mob">
                            <div id="turkish-citizenship" class="section">
                                <div class="sub_section">
                                    <h2 class="sub_title"><?= trans("front.Stages of obtaining Turkish citizenship"); ?></h2>

                                    <ul class="steps scrollbar">
                                        <li class="step_one">
                                            <div class="sub">
                                                <div class="icon"></div>
                                                <h4><?= trans("front.Find your property"); ?></h4>
                                                <p>
                                                    <?= trans("front.Find your property text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">01</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </li>

                                        <li class="step_two">
                                            <div class="sub">
                                                <div class="icon"></div>
                                                <h4><?= trans("front.Real estate appraisal"); ?></h4>
                                                <p>
                                                    <?= trans("front.Real estate appraisal text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">02</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </li>

                                        <li class="step_three">
                                            <div class="sub">
                                                <div class="icon"></div>
                                                <h4><?= trans("front.Investor residence"); ?></h4>
                                                <p>
                                                    <?= trans("front.Investor residence text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">03</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </li>

                                        <li class="step_four">
                                            <div class="sub">
                                                <div class="icon"></div>
                                                <h4><?= trans("front.Apply for citizenship"); ?></h4>
                                                <p>
                                                    <?= trans("front.Apply for citizenship text"); ?>
                                                </p>
                                            </div>
                                            <span class="number">04</span>
                                            <span class="shadow"></span>
                                            <span class="mirror"></span>
                                        </li>

                                    </ul>


                                    <a href="/turkish-citizenship" class="more_btn shadow_type"><?= trans("front.more details"); ?></a>

                                </div>
                            </div>
                        </div>



                        <div class="padding_mob">
                            <div class="int_content">
                                <div class="section">

                                    <!-- Testimonials -->
                                    @include("front.partials.testimonials_slider", [])


                                </div>
                            </div>
                        </div>




                        <div class="padding_mob">
                            <div class="int_content">
                                <div id="about" class="section about">
                                    <h2 class="sub_title"><?= trans("front.About damasturk"); ?></h2>

                                    <a class="about_video" data-fancybox href="https://www.youtube.com/embed/{{ $youtube_profile }}">

								<!--<img class="cover lazy" src="https://i.ytimg.com/vi/{{ $youtube_profile }}/maxresdefault.jpg">-->

                                        <picture>
                                            <source data-srcset="https://i.ytimg.com/vi_webp/{{ $youtube_profile }}/maxresdefault.webp" type="image/webp">
                                            <source data-srcset="https://i.ytimg.com/vi/{{ $youtube_profile }}/maxresdefault.jpg" type="image/jpeg">
                                            <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/{{ $youtube_profile }}/maxresdefault.jpg" />
                                        </picture>


                                    </a>
                                    <!--<iframe class="about_video" width="100%" height="480" src="https://www.youtube.com/embed/{{ $youtube_profile }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->


                                    <div class="right_sec">
                                        <div class="damas" onclick="location.replace('<?= route('front.aboutus'); ?>')">
                                            <img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/damasturk.svg') }}" alt="damas">
                                        </div>
                                        <p>{!! trans('front.about us Shortcut text') !!}</p>
                                        <a href="<?= route('front.aboutus'); ?>" class="more_btn shadow_type"><?= trans("front.read more"); ?></a>
                                    </div>

                                    <div class="left_sec">
                                        <ul class="brands">
                                            <li class="title"><h3><?= trans("front.Our partners"); ?></h3></li>
                                            <li>
                                                <a href="/blog/emlak-konut" target="_blank"><img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="" title="logo"></a>
                                            </li>
                                            <li>
                                                <a href="/blog/sinbas"><img class=" sinpas <?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/sinpas-logo.png') }}" title="logo"></a>
                                            </li>
                                            <li>
                                                <a class="agaoglu" href="/blog/aga-oglu" target="_blank"><img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/agaoglu-logo.svg') }}" title="logo"></a>
                                            </li>
                                            <li>
                                                <a href="/blog/kelesoglu"><img class=" kalesh <?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/kelesoglu-logo.png') }}" title="logo"></a>
                                            </li>
                                            <li>
                                                <a href="/blog/avrupa-konutlari" target="_blank"><img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/avrupakonutlari-logo.svg') }}" title="logo"></a>
                                            </li>
                                            <li>
                                                <a href="/blog/nef" target="_blank"><img class=" nef <?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/nef-logo.png') }}" title="logo"></a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>



                    </div>
                    <!-- End Left Section -->



                    <!-- Start Form -->

                    <div class="col-md-12">


                        <section class="form shadow_type">

                            <div id="contact" class="targetHref"></div>

                            @include("front.partials.call_us_fixed")
                        </section>

                    </div>
                    <!-- end Form -->



                </div>



                <!-- Start Full -->
            <?php //} else { ?>

                <div class="content d-none d-sm-block">
                    <div class="col-md-10 offset-md-1">

                        <!-- start slider -->
                        <section id="section_home" class="land_full land_<?= $current_lang ?>">
                            <div  id="photos">
                                <div class="full-container main-container">
                                    <?php
                                    $slider = $landing->background;

                                    $images = $project->projectPhotos;
                                    ?>
                                    {!! Helper::get_pic(Helper::media_url($slider),'img-fluid top_big_photo','','',$slider->getTitle()) !!}
                                </div>


                                <div class="owl-carousel owl-theme owl-landing">
                                    
                                        @foreach($images as $k => $img)
                                        <?php
                                        $img_url = Helper::media_url($img);
                                        ?>
                                        <div class="item">
                                            <a data-fancybox="gallery" href="<?= $img_url; ?>" class="<?= $k == 0 ? "first" : ""; ?>">
                                                {!! Helper::get_pic(Helper::get_thumbnail($img, 330,191),'image-responsive ','','',$img->getDescription()) !!}   
                                            </a>
                                        </div>

                                        @endforeach
                                </div>
                            </div>
                            <!-- /.container -->
                        </section>
                        <!-- end slider -->




                        <div class="full_sections">

                            <!-- Start Fixed Section -->
                            <div class="right_sec">
                                <div class="fixed_sec shadow_type">

                                    <section class="form">
                                        @include("front.partials.call_us_fixed")
                                    </section>

                                </div>
                            </div>
                            <!-- End Fixed Section -->


                            <!-- Start Left Section -->
                            <div class="left_sec">


                                <div class="int_content">

                                    <div id="information" class="targetHref"></div>


                                    <div class="section">

                                        <div class="top_sec">
                                            <h1 class="project_name"> <?= trans("front.project"); ?> <strong class="number"><?= @$project->getNameEn(); ?></strong></h1>


                                            <div class="btn_group">
                                                <a class="green_btn gift" data-fancybox="gift" data-src="#gift" data-touch="false"><span class="icon"></span><span><?= trans("front.gift"); ?></span></a>
                                                <a class="green_btn like likeCardItem <?= in_array($project->id, session()->get("likedprojects.ids", [])) ? 'active' : ''; ?>" data-url="<?= route("front.likeitem"); ?>" data-typ="project" data-code="<?= $project->id; ?>"><span class="icon"></span><span><?= trans("front.like"); ?></span></a>

                                                <div class="dropdown share">
                                                    <button class="btn btn-primary dropdown-toggle green_btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="icon"></span> <?= trans("front.share"); ?>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="fa fa-twitter" href="https://twitter.com/intent/tweet?url=https%3A%2F%2Fdamas.net%2Flanding%2F<?= $project->name_en ?>&amp;text=<?= urlencode(trans("front.project") . ' ' . @$project->getNameEn() . ' ' . @$project->city->getName()) ?>&amp;via=damasturk" target="_blank"></a>
                                                        <a target="_blank" class="fa fa-facebook" href="https://facebook.com/sharer.php?u=https%3A%2F%2Fdamas.net%2Flanding%2F<?= $project->name_en ?>"></a>
                                                        <a class="fa fa-whatsapp" href="https://api.whatsapp.com/send?text=https%3A%2F%2Fdamas.net%2Flanding%2F<?= $project->name_en ?>" target="_blank"></a>
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
                                                <p><?= trans("front.City Center"); ?></p><span><strong class="num"><?= trim(str_replace('كم', '', $project->distance_center)); ?></strong> كم</span>
                                            </li>
                                            <?php
                                            list($sclass, $slab) = $project->getStatus();
                                            if ($sclass == 'under-construction') {
                                                ?>
                                                <li class="status under-construction">
                                                    <div class="icon"></div>
                                                    <p><?= trans("front.under cons"); ?></p><span><?= date("Y/m", strtotime($project->delivered_date)); ?></span>
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
                                                    <p> <strong class="num"><?= $project->payment_months ?></strong> <?= trans("front.months"); ?></p>
                                                </li>
                                            <?php } ?>

                                        </ul>


                                        <span class="line_space"></span>



                                        <div class="padding_mob">
                                            <div id="prices" class="targetHref"></div>

                                            <div class="section prices">
                                                <h2 class="sub_title margin_bottom_20"><span><?= trans("front.approximate prices"); ?></span><span class="payment_method_types"><?= trans('front.' . $project->payment_method); ?></span></h2>

                                                @include("front.partials.project_prices_landing", ["project" => $project, "style_lang" => $style_lang ])

                                            </div>
                                        </div>

                                    </div>


                                </div>




                                <?php
                                $link_video = $project->getLinkVideo();
                                parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
                                $video_code = @$array_of_vars['v'];
                                ?>
                                @if($video_code)
                                <div class="int_content">

                                    <div id="project-video" class="targetHref"></div>

                                    <div class="section video">
                                        <h2 class="sub_title">{{ trans('front.videos') }}</h2>

                                        <section class="youtube-video" id="section_images_videos">
                                            <a data-fancybox="project-video" href="https://www.youtube.com/embed/<?= $video_code; ?>">
                                                <img class="cover lazy" src="https://i.ytimg.com/vi/<?= $video_code; ?>/hqdefault.jpg">
                                            </a>
                                        </section>

                                    </div>
                                </div>
                                @endif




                                <div class="int_content">
                                    <div class="sub_section">
                                        <h2 class="sub_title"><?= trans("front.facilities and features"); ?></h2>
                                        <ul class="explained"> <?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntroFeatures()))); ?> </ul>
                                    </div>


                                    <ul class="features">
                                        @foreach($project->features as $feature)
                                        <li><span class="fa fa-check"></span> <?= $feature->getName(); ?></li>
                                        @endforeach
                                    </ul>


                                    <span class="line_space"></span>

                                    <div class="sub_section">
                                        <h2 class="sub_title"><?= trans("front.location and strategic importance"); ?></h2>
                                        @if($project->getIntoLocation())
                                        <ul class="explained">
                                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntoLocation()))); ?></li>
                                        </ul>
                                        @endif
                                    </div>

                                    <span class="line_space"></span>

                                    <div class="sub_section">
                                        <h2 class="sub_title"><?= trans("front.service institutions"); ?></h2>
                                        <?php $p_governmental = $project->getGovernmental(); ?>
                                        @if($p_governmental)
                                        <ul class="explained">
                                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_governmental))); ?></li>
                                        </ul>
                                        @endif
                                    </div>

                                    <span class="line_space"></span>

                                    <div class="sub_section">
                                        <h2 class="sub_title"><?= trans("front.location"); ?></h2>
                                        <?php $p_location = $project->getLocation(); ?>
                                        @if($p_location)
                                        <ul class="explained">
                                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_location))); ?></li>
                                        </ul>
                                        @endif


										<?php /*
                                        <section class="map" id="map">
                                            <a title="انقر لعرض الخريطة" data-fancybox="map" data-options="{&quot;iframe&quot; : {&quot;css&quot; : {&quot;width&quot; : &quot;80%&quot;, &quot;height&quot; : &quot;80%&quot;}}}" href="https://www.google.com/maps/search/?api=1&amp;query=<?= $project->latitude; ?>,<?= $project->longitude; ?>&amp;z=8">
                                                {!! Helper::picture(['class'=>'lazy' , 'src'=> 'https://www.aqsaway.com/map.php?size=1200x200&latitude=' . $project->latitude . '&longitude=' . $project->longitude  ]) !!}
                                            </a>
                                        </section>*/ ?>



                                    </div>

                                    <span class="line_space"></span>

                                    <div class="sub_section">
                                        <h2 class="sub_title"><?= trans("front.transportation"); ?></h2>
                                        <?php $p_transportation = $project->getTransportation(); ?>
                                        @if($p_transportation)
                                        <ul class="explained">
                                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_transportation))); ?></li>
                                        </ul>
                                        @endif
                                    </div>

                                    <span class="line_space"></span>

                                    <div class="sub_section">
                                        <h2 class="sub_title"><?= trans("front.future look"); ?></h2>
                                        <?php $p_future_look = $project->getFutureLook(); ?>
                                        @if($p_future_look)
                                        <ul class="explained">
                                            <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_future_look))); ?></li>
                                        </ul>
                                        @endif
                                    </div>
                                </div>






                                <?php $img_plans = $project->planPhotos; ?>
                                @if(count($img_plans))
                                <div class="int_content green_bg">

                                    <div id="plan" class="targetHref"></div>

                                    <div class="section">
                                        <h2 class="sub_title color_white"><?= trans("front.apartment designs"); ?></h2>
                                        <div class="section">
                                            <div class="owl-carousel owl-theme plan_photos">

                                                @foreach($img_plans as $plan)
                                                <div class="item">
                                                    <a data-fancybox="plan-photo" 
                                                       href="<?= Helper::media_dev($plan, 'full'); ?>">
                                                           <?php $img_url = Helper::media_dev($plan, 'mob'); ?>
                                                        <!--<img class="lazy" src="<?= $img_url; ?>" data-srcimg="<?= $img_url; ?>" alt="<?= $plan->getName(); ?>">-->
                                                        {!! Helper::picture(['class'=>'lazy','src'=>Helper::get_thumbnail($plan, 310,310),'alt'=>$plan->getName() ]) !!}
                                                    </a>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif









                                <div class="int_content">
                                    <div id="location" class="section">
                                        <h2 class="sub_title"><?= trans("front.Region Report"); ?></h2>

                                        <!-- Start Statistics Section -->
                                        <?php
                                        $r_reg = $project->region;
                                        $region_name = @$r_reg->getName();
                                        $region_name_en = @$r_reg->getNameEn();
                                        $statics_results = DB::select('select * from stat_region where name = ?', [$region_name_en]);

                                        if (count($statics_results) > 0) {
                                            $reg = $statics_results[0];
                                            $data_demog = Helper::parse_statistcics($reg, 'demographique');
                                            ?>
                                            @include("front.partials.statistics_most", [])

                                            <!-- end Statistics Section -->
                                        <?php } ?>

                                    </div>
                                </div>


                                <div class="int_content">
                                    <div id="turkish-citizenship" class="section">
                                        <div class="sub_section">
                                            <h2 class="sub_title"><?= trans("front.Stages of obtaining Turkish citizenship"); ?></h2>

                                            <ul class="steps scrollbar">
                                                <li class="step_one">
                                                    <div class="sub">
                                                        <div class="icon"></div>
                                                        <h4><?= trans("front.Find your property"); ?></h4>
                                                        <p>
                                                            <?= trans("front.Find your property text"); ?>
                                                        </p>
                                                    </div>
                                                    <span class="number">01</span>
                                                    <span class="shadow"></span>
                                                    <span class="mirror"></span>
                                                </li>

                                                <li class="step_two">
                                                    <div class="sub">
                                                        <div class="icon"></div>
                                                        <h4><?= trans("front.Real estate appraisal"); ?></h4>
                                                        <p>
                                                            <?= trans("front.Real estate appraisal text"); ?>
                                                        </p>
                                                    </div>
                                                    <span class="number">02</span>
                                                    <span class="shadow"></span>
                                                    <span class="mirror"></span>
                                                </li>

                                                <li class="step_three">
                                                    <div class="sub">
                                                        <div class="icon"></div>
                                                        <h4><?= trans("front.Investor residence"); ?></h4>
                                                        <p>
                                                            <?= trans("front.Investor residence text"); ?>
                                                        </p>
                                                    </div>
                                                    <span class="number">03</span>
                                                    <span class="shadow"></span>
                                                    <span class="mirror"></span>
                                                </li>

                                                <li class="step_four">
                                                    <div class="sub">
                                                        <div class="icon"></div>
                                                        <h4><?= trans("front.Apply for citizenship"); ?></h4>
                                                        <p>
                                                            <?= trans("front.Apply for citizenship text"); ?>
                                                        </p>
                                                    </div>
                                                    <span class="number">04</span>
                                                    <span class="shadow"></span>
                                                    <span class="mirror"></span>
                                                </li>

                                            </ul>


                                            <a href="/turkish-citizenship" class="more_btn shadow_type"><?= trans("front.more details"); ?></a>

                                        </div>
                                    </div>
                                </div>



                                <div class="int_content">
                                    <div class="section">

                                        <!-- Testimonials -->
                                        @include("front.partials.testimonials_slider", [])


                                    </div>
                                </div>






                                <div class="int_content">

                                    <div id="about" class="targetHref"></div>
                                    <h2 class="sub_title"><?= trans("front.About damasturk"); ?></h2>


                                    <a class="about_video" data-fancybox="video" href="https://www.youtube.com/embed/{{ $youtube_profile }}">
                                    <!--<img class="cover lazy" src="https://i.ytimg.com/vi/{{ $youtube_profile }}/maxresdefault.jpg">-->

                                        <picture>
                                            <source data-srcset="https://i.ytimg.com/vi_webp/{{ $youtube_profile }}/maxresdefault.webp" type="image/webp">
                                            <source data-srcset="https://i.ytimg.com/vi/{{ $youtube_profile }}/maxresdefault.jpg" type="image/jpg">
                                            <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/{{ $youtube_profile }}/maxresdefault.jpg" />
                                        </picture>
                                    </a>

                                                                                                                    <!--<iframe class="about_video" width="100%" height="480" src="https://www.youtube.com/embed/{{ $youtube_profile }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->


                                    <div class="section about">

                                        <div class="right_sec">
                                            <div class="damas" onclick="location.replace('<?= route('front.aboutus'); ?>')">
                                                <img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/damasturk.svg') }}" alt="damas">
                                            </div>
                                            <p>{!! trans('front.about us Shortcut text') !!}</p>
                                            <a href="<?= route('front.aboutus'); ?>" class="more_btn shadow_type"><?= trans("front.read more"); ?></a>
                                        </div>

                                        <div class="left_sec">
                                            <ul class="brands">
                                                <li class="title"><h3><?= trans("front.Our partners"); ?></h3></li>
                                                <li>
                                                    <a href="/blog/emlak-konut" target="_blank"><img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="here" title="logo"></a>
                                                </li>
                                                <li>
                                                    <a href="/blog/sinbas"><img class=" sinpas <?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/sinpas-logo.png') }}" title="logo"></a>
                                                </li>
                                                <li>
                                                    <a class="agaoglu" href="/blog/aga-oglu" target="_blank"><img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/agaoglu-logo.svg') }}" title="logo"></a>
                                                </li>
                                                <li>
                                                    <a href="/blog/kelesoglu"><img class=" kalesh <?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/kelesoglu-logo.png') }}" title="logo"></a>
                                                </li>
                                                <li>
                                                    <a href="/blog/avrupa-konutlari" target="_blank"><img class="<?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/avrupakonutlari-logo.svg') }}" title="logo"></a>
                                                </li>
                                                <li>
                                                    <a href="/blog/nef" target="_blank"><img class=" nef <?= isset($is_search_p) ? 'lazy' : '' ?>" loading="lazy" src="{{ asset('img/nef-logo.png') }}" title="logo"></a>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>



                            </div>
                            <!-- End Left Section -->

                        </div>
                        <!-- End Full Section -->








                    </div><!-- End col-md-10 offset-md-1 -->

                </div><!-- End content -->

            <?php //} ?>



        </div>



        <!-- Gift Modal -->

        <?= Form::open(["url" => route("front.callus2"), "id" => "gift", "class" => "formgift", "style" => "display: none; width: 100%; max-width: 660px;"]); ?>
        <strong class="h2"><?= trans("front.enter your mobile"); ?></strong>
        <strong class="h3"><?= trans("front.to send you a gift"); ?></strong>
        <div class="fbgift">
            <div class="bname">
                <input type="text" value="" name="name" class="" placeholder="* <?= trans("front.name and fname"); ?>">
            </div>
            <div class="bmobile">
                <input type="text"  value="{{ @session()->get('call_country') }}" name="mobile" id="mobile-sm" placeholder="+90 123456789" />
            </div>
            <input type="hidden" value="gift" name="type" />
            <div class="bsubmit">
                <button type="submit"></button>
            </div>
        </div>
    </form>

    <!-- Gift Modal -->

    <footer>

        <img class="logo lazy" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>

        <div class="copyright"><p> &copy; <?= trans("front.copyright"); ?> <?= trans("front.company name"); ?> <?= date('Y'); ?></p></div>

    </footer>


    <link rel="stylesheet" href="<?= asset("fonts/" . ($current_locale == 'fr' ? 'en' : $current_locale) . ".css"); ?>" type="text/css" />
    <!--------- javascript files ---------->


    <?php if (App::isLocal()) { ?>


        <?= Html::script("/resources/assets/js/jquery-2.2.4.min.js"); ?>
        <?= Html::script("/resources/assets/js/popper.min.js"); ?>

        <?= Html::script("/resources/assets/js/bootstrap.min.js"); ?>
        <!-- <?= Html::script("resources/assets/js/jquery-3.2.1.slim.min.js"); ?>-->

        <?= Html::script("/resources/assets/js/owl.carousel.js"); ?>
        <?= Html::script('/resources/assets/js/bootstrap-select.js'); ?>

        <?= Html::script("/resources/assets/js/intlTelInput.js"); ?>
        <?= Html::script("/resources/assets/js/coolshare.js"); ?>
        <--<?= Html::script("resources/assets/js/jquery.lazy.min.js"); ?>-->
        <?= Html::script("/resources/assets/js/jquery.fancybox.min.js"); ?>
        <!--<?= Html::script("/resources/assets/js/jquery-ui-autocomplete.js"); ?>-->
        <?= Html::script("resources/assets/js/main.js"); ?>


        <!--plugins.min.js-->
        <?= Html::script('/resources/assets/js/bootstrap-select.js'); ?>


    <?php } else { ?>

        <?php // Html::script("js/landing.min.js"); ?>

        <?= Html::script("js/landing.min.js"); ?>



        <!--plugins.min.js
        <?php /* Html::script("js/bootstrap.min.js"); ?>
          <?= Html::script("js/owl.carousel.min.js"); ?>
          <?= Html::script("js/intlTelInput.js"); ?>
          <?= Html::script("js/lazyload.min.js"); ?>
          <?= Html::script("js/jquery.fancybox.min.js"); ?>
          <?= Html::script('js/bootstrap-select.js'); */ ?>-->


    <?php } ?>



    <?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js") ?>
    <?= Html::script("js/myChart.min.js") ?>
    <?= Html::script("js/bootstrap-multiselect.js") ?>
    <?= Html::script("js/swiper.min.js"); ?>
	
    <script>

        /* Dropdown Menu Selection*/
        $(document).ready(function () {


				<?php
				$get = '';
				foreach($_GET as $k=>$v){
					if($get=='')
						$get = $k . '=' . $v;
					else
						$get = $get .'&'. $k . '=' . $v;
				}
				if(isset($_GET['sHTTP_REFERER']) && isset($_GET['sREQUEST_URI'])){
					$js_gets = "";
				}else{
					$js_gets = "'&sHTTP_REFERER=' + encodeURIComponent(document.referrer) + '&sREQUEST_URI=' + '/' + encodeURIComponent(window.location.pathname.substr(1))";
				}
				?>
				$.getJSON( "/ajax/call_country?<?= $get ?>" + <?= $js_gets ?> , function(data){
					var call_ctry = data.call_country;
					$('input[name=mobile]').val(call_ctry);
					$('input[name=phone]').val(call_ctry);
					
					
					
					call_ctry = call_ctry.replace('+','');
					var country_abr = $('input[name=mobile]:eq(0)').parent('div').find('.country-list').find('li[data-dial-code="'+call_ctry+'"]').data('country-code');
					$('input[name=mobile]').parent('div').find('.selected-flag').find('.flag').attr('class','flag '+country_abr);
					$('input[name=phone]').parent('div').find('.selected-flag').find('.flag').attr('class','flag '+country_abr);
					
					
				});





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
        $('.brooms_type .dropdown-menu a').click(function () {
            var slected_val = $(this).attr('data-val');
            /*$('.currency-symbol').html($(this).attr('data-val'));*/
            var blk_price = $(this).parent('li').parent('ul').parent('.brooms_type').parent('.icon-bed').parent('.blk_to_price');
            blk_price.children('.icon-bed').children('.brooms_type').children('.btn').children('span:first-child').text($(this).text());
            blk_price.children('.ppprice').addClass('d-none');
            blk_price.children('.tpp' + slected_val).removeClass('d-none');
        });
        function open_tab(url) {
            var win = window.open(url, '_blank');
            win.focus();
        }





        //new LazyLoad({elements_selector: ".lazy", load_delay: 300});

        $(document).ready(function () {
            $('.selectpicker').selectpicker();

            $(".owl-next").html("<i class='fa fa-chevron-left'></i>");
            $(".owl-prev").html("<i class='fa fa-chevron-right'></i>");
            $(".owl-landing .owl-dots").hide();
        });


        $('.selectpicker').change(function () {
            var selected = $(this).val();

        });

        $('.like').click(function () {
            $(this).toggleClass("active");
        });




        $('.land_full .owl-landing').owlCarousel({
            loop: false,
            margin: 15,
            nav: true,
            lazyLoad: true,
            rtl: true,
            autoplay: true,
            autoplayTimeout: 4000,
            responsive: {
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });
        $('.land_mobile .owl-landing').owlCarousel({
            loop: true,
            margin: 8,
            nav: false,
            lazyLoad: true,
            rtl: true,
            center: true,
            items: 3,
            autoplay: true,
            autoplayTimeout: 3000
        });




        $('.plan_photos').owlCarousel({
            items: 3,
            loop: false,
            margin: 15,
            nav: true,
            dots: true,
            lazyLoad: true,
            rtl: true,
            autoplay: true,
            autoplayTimeout: 4000,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: false
                },
                1024: {
                    items: 2,
                    nav: true,
                    loop: false
                },
                1280: {
                    items: 3,
                    nav: true,
                    loop: false
                }
            }
        });





        $(document).ready(function () {


            $("body").on("submit", "#form-callus, #form-callus-lg, #form-callus-floating, #form-callus-landing, #form-callus-chat", function (e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find("button[type=submit]");
                var btn2 = form.find("input[type=submit]");
                var act = form.attr("action");
                var infos = form.serialize() + '&budget=' + form.find('input[class=min_budj]').val() + '$ - ' + form.find('input[class=max_budj]').val() + '$';
                btn.html('<i style="color:#fff" class="fa fa-spinner fa-spin"></i>');
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

                    btn.removeAttr("disabled");
                    btn2.removeAttr("disabled");
                });
                return false;
            });



            $("#gift").on("submit", function (e) {
                e.preventDefault();
                var form = $(this);
                var btn = form.find("button[type=submit]");
                var act = form.attr("action");
                var infos = form.serialize();
                /*btn.find(".fa").removeClass("fa-send").addClass("fa-spinner fa-spin");*/
                btn.html("<i class='fa fa-spinner fa-spin' style='color: #0d8dd3;'></i>");
                btn.attr("disabled", true);
                $.post(act, infos, function (resp) {
                    form.find(".has-form-error").remove();
                    if (resp.input) {
                        form.find('*[name=' + resp.input + ']').removeClass("animated flash").addClass("animated flash").focus();
                        form.find('*[name=' + resp.input + ']').after("<small class='has-form-error error-" + resp.input + " text-danger'>" + resp.message + "</small>");
                    } else {
                        if (resp.url) {
                            window.location.href = resp.url;
                        } else {
                            alert(resp.message);
                        }
                        form.find("input").val("");
                    }
                    btn.html('');
                    btn.removeAttr("disabled");
                });
                return false;
            });

            $('.currency').change(function () {

                if ($(this).val() != '') {
                    $('.tprice').addClass('hidden');
                    $('.tp' + $(this).val()).removeClass('d-none').removeClass('hidden');
                }
            });

            /* like project */
            $("body").on("click", ".likeCardItem", function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr("data-url");
                var id = $this.attr("data-code");
                var typ = $this.attr("data-typ");
                var csrf = $('input[name=_token]').val();
                if ($this.children().length > 0) {
                    $this.find("i").removeClass("fa-heart-o").addClass("fa-heart");
                } else {
                    $this.removeClass("fa-heart-o").addClass("fa-heart");
                }
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        _token: csrf,
                        id: id,
                        typ: typ,
                    }
                }).done(function (resp) {
                    /*$this.find("i").removeClass("fa-heart-o").addClass("fa-heart");*/
                });
                return false;
            });

<?php /*
//$(document).on("scroll", onScroll);

//            $('.main_menu .links li a[href^="#"]').on('click', function (e) {
//                e.preventDefault();
//                //$(document).off("scroll");
//
//                $('.main_menu .links li a').each(function () {
//                    $(this).removeClass('active');
//                });
//                $(this).addClass('active');
//                var target = this.hash,
//                        menu = target;
//                $target = $(target);
//                $('html, body').stop().animate({
//                    'scrollTop': $target.offset().top
//                }, 1000, 'swing', function () {
//                    window.location.hash = target;
//                    //$(document).off("scroll", onScroll);
//                });
//            });
*/ ?>

  $(".main_menu .links li a").click(function(e) {
	e.preventDefault();
	
	var position = $($(this).attr("href")).offset().top;

	$("body, html").animate({
		scrollTop: position
	} /* speed */ );
});

/*
//            $("input[name=mobile]").keydown((function (e) {
//                if (e.keyCode != 8 && e.keyCode != 107 && e.keyCode != 37 && e.keyCode != 39)
//                    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 || e.keyCode == 32))
//                        e.preventDefault();
//            }));
*/
            $("input[name=mobile]").keydown((function (e) {
                if (e.keyCode != 8 && e.keyCode != 107 && e.keyCode != 37 && e.keyCode != 39)
                    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105 || e.keyCode == 32))
                        e.preventDefault();
            }));
        });


if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
	
}else{

            $(window).scroll(function () {
                var fullSectionsH = $(".full_sections").offset().top - 100;
                var scroll = $(window).scrollTop();
                if (scroll >= fullSectionsH) {
                    $(".fixed_sec").addClass("fixed");
                } else {
                    $(".fixed_sec").removeClass("fixed");
                }
            });


            $(window).scroll(function () {
                var scrollingPage = 50;
                var scroll = $(window).scrollTop();
                if (scroll >= scrollingPage) {
                    $(".header").addClass("scrolling");
                } else {
                    $(".header").removeClass("scrolling");
                }
            });
}





        $(".contact_link").on("click", function () {
            setTimeout(function () {
                $(".name input").focus();
            }, 2000);

        });





        $("#mobile-sm, #mobile-lg, #InputMobile, #inputMobileChat").intlTelInput({
            preferredCountries: ["undif", "sa", "tr", "qa", "sy", "iq", "kw", "bh", "ae", "ye", "jo", "dz", "ly", "eg", "sd", "om"]
        });



        $('#budgetMenu').bind('click', function (e) {
            e.stopPropagation();
        });







<?php if (count($statics_results) > 0) { ?>

            $(document).ready(function () {
    <?php
    /*if ($r_reg->transport + $r_reg->health + $r_reg->social + $r_reg->shopping + $r_reg->schools > 0) {
        ?>
                    
                    var ctx = document.getElementById('radarChart').getContext('2d');
                    var labels = ['', '', '', '', ''];
                    var radarChart = new Chart(ctx, {
                        responsive: true,
                        type: 'radar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: '',
                                    data: [<?= $r_reg->transport ?>, <?= $r_reg->health ?>, <?= $r_reg->social ?>, <?= $r_reg->shopping ?>, <?= $r_reg->schools ?>],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                        'rgba(255, 206, 86, 0.2)',
                                        'rgba(75, 192, 192, 0.2)',
                                        'rgba(153, 102, 255, 0.2)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                        'rgba(255, 206, 86, 1)',
                                        'rgba(75, 192, 192, 1)',
                                        'rgba(153, 102, 255, 1)'
                                    ]
                                }, {
                                    label: '',
                                    data: [0, 0, 0, 0, 0]
                                }]
                        },
                        options: {
                            responsive: true,
                            scale: {
                                ticks: {
                                    display: true,
                                    maxTicksLimit: 8
                                },
                                legend: {
                                    labels: {
                                        fontColor: "white"
                                    }
                                }
                                ,
                                scales: {
                                    yAxes: [{
                                            display: false,
                                            beginAtZero: true
                                        }],
                                    xAxes: [{
                                            ticks: {
                                                fontColor: "white",
                                                fontSize: 14,
                                                display: false,
                                                beginAtZero: false
                                            }

                                        }
                                    ]}
                            }
                        }
                    });
                   
    <?php }*/ ?>



    <?php
    /*$json1 = Helper::ajax_statics($region_name_en, 'region_sale', 0, 0, 'apartments_villas', 'price_m');
    $json2 = Helper::ajax_statics($region_name_en, 'region_rent', 0, 0, 'apartments_villas', 'price_m');*/
    $json3 = Helper::ajax_statics('', 'top_country', 0, 0);
    $json4 = Helper::ajax_statics('', 'top_city', 0, 0);
    ?>
                <?php /*Sold_Chart(<?= json_encode($json1) ?>, 'propertiesSold', 'rgba(13, 204, 211, 0.8)', 'rgba(13, 204, 211, 1)');
                Sold_Chart(<?= json_encode($json2) ?>, 'rentalProperties', 'rgba(231, 104, 0, 0.8)', 'rgba(231, 104, 0, 0.8)');*/ ?>
                display_most_nat_data(<?= json_encode($json3) ?>);
                display_most_city_data(<?= json_encode($json4) ?>);
<?php } ?>




        });




    </script>




</body>
</html>