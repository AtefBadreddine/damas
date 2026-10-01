<?php
if (!isset($availables_langs))
    $availables_langs = ['ar', 'en'];


if (!isset($hide_whatsapp))
    $hide_whatsapp = false;


$ccountry = ((strpos(request()->getPathInfo(), '/oman') !== false or strpos(request()->getPathInfo(), '/muscat') !== false)?'oman':'turkey');


//n project_data /media
if(isset($is_proj_data) && isset($project) && $project->city && $project->city->countryRel){
    $ccountry = $project->city->countryRel->code;
}

$ccountryModel = Helper::currentCountry(isset($project) ? $project : (isset($locationCountry) ? $locationCountry : null));
if (!$ccountryModel && isset($post) && is_object($post) && $post->countryRel) {
    $ccountryModel = $post->countryRel;
}
if (!$ccountryModel) {
    $ccountryModel = \App\Models\Country::findBySlugOrCode($ccountry);
}
$ccountryId = $ccountryModel ? $ccountryModel->id : 0;

$whatsappContext = isset($project) ? $project : (isset($locationCountry) ? $locationCountry : null);
$whatsappTel = Helper::whatsappNumber($whatsappContext);
$whatsappCountry = Helper::currentCountry($whatsappContext);
$callmeModalUrl = route('front.callmeModalAjax') . '?ct=' . $ccountry;
if ($whatsappCountry) {
    $callmeModalUrl .= '&whatsapp_country=' . $whatsappCountry->slug;
}

$current_lang = LaravelLocalization::getCurrentLocale();

$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';

$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$emptypic = asset('img/0.png');

$citys = App\Models\City::where('id', '!=', 2)->with('countryRel')->orderBy('placement', 'asc')->get();
$tags = \App\Models\ProjectCategory::limit(14)->get();

$projectsUrl = route('front.projects');
$cityListingUrls = array();
foreach ($citys as $layoutCity) {
    if ($layoutCity->slug && $layoutCity->listingUrl()) {
        $cityListingUrls[$layoutCity->slug] = $layoutCity->listingUrl();
    }
}
?>
<!DOCTYPE html>
<html lang="<?= ($current_lang == 'pe' ? 'fa' : $current_lang); ?>" dir="<?= $style_lang == "ar" ? "ltr" : "ltr"; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <?php $infos = Helper::get_params();
        
        if($ccountry=='oman'){
            $infos->facebook = 'https://www.facebook.com/DamasGulfInvest';
            $infos->instagram = 'https://www.instagram.com/damasgulfinvest';
        }
        ?>
        <title><?= $og_title = @$page_title ? $page_title : $infos->seo_title; ?></title>
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "WebSite",
            "name": "DAMAS GLOBAL",
            "url": "https://damas.net/"
        }
        </script>
        
        
    <!--    <link rel="shortcut icon" href="<?= asset("img/favicon.ico"); ?>" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?= asset("img/favicon.png"); ?>">
        <link rel="icon" type="image/png" href="<?= asset("img/favicon.png"); ?>" sizes="32x32">-->
        
        
        
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        
        <?php if (Route::currentRouteName() == 'front.index') { ?>
        <link
            rel="preload"
            as="image"
            href="/img/sliderMobile33.jpg"
            media="(max-width: 480px)"
            fetchpriority="high"
        >
        <?php } ?>
        
        
        <meta name="application-name" content="<?= $og_title; ?>" />
		
		@if(in_array('ar',$availables_langs))
        <link rel="alternate" href="<?= seo_url("ar"); ?>" hreflang="ar" />
        @endif
		@if(in_array('en',$availables_langs))
		<link rel="alternate" href="<?= seo_url("en"); ?>" hreflang="en"/>
        @endif
		@if(in_array('fr',$availables_langs))
		<link rel="alternate" href="<?= seo_url("fr"); ?>" hreflang="fr"/>
        @endif
		@if(in_array('pe',$availables_langs))
		<link rel="alternate" href="<?= seo_url('pe'); ?>" hreflang='fa'/>
		@endif
		@if(in_array('ru',$availables_langs))
		<link rel="alternate" href="<?= seo_url('ru'); ?>" hreflang='ru'/>
		@endif
        <?php $xDefaultLang = in_array(LaravelLocalization::getDefaultLocale(), $availables_langs) ? LaravelLocalization::getDefaultLocale() : reset($availables_langs); ?>
        @if($xDefaultLang)
        <link rel="alternate" href="<?= seo_url($xDefaultLang); ?>" hreflang="x-default" />
        @endif
        
		<link rel="alternate" type="application/rss+xml" href="<?= url('rss/news') ?>" title="<?= trans('front.news') ?>"/>
        <link rel="alternate" type="application/rss+xml" href="<?= url('rss/blog') ?>" title="<?= trans('front.guides') ?>"/>
        <link rel="alternate" type="application/rss+xml" href="<?= url('rss/developers') ?>" title="<?= trans('front.developer') ?>"/>
        <link rel="alternate" type="application/rss+xml" href="<?= url('rss/reports') ?>" title="<?= trans('front.report') ?>"/>
        <link rel="alternate" type="application/rss+xml" href="<?= url('rss/projects') ?>" title="<?= trans('front.projects') ?>"/>


        <meta name="audience" content="all" />
        <meta name="rating" content="general" />
        <meta name="author" content="damasturk" />
        <meta name="revisit-after" content="5 hours" />
        
        <link rel="canonical" href="<?= seo_url(); ?>" />
        <meta property="og:url" content="<?= seo_url(); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= $og_title; ?>" />
        @if(@$amp_url)
        <?php /* <link rel="amphtml" href="<?= str_replace('/public', '', $amp_url); ?>"> */ ?>
        @endif


        @if(@$og_image)
    <!--<meta property="og:image" content="<?php // str_replace("https", "http", $og_image);                                                                                           ?>" />-->

        <meta property="og:image" content="<?= $og_image ?>" />
        <!--<meta property="og:image:type" content="image/jpeg" />-->
        <meta property="og:image:width" content="900" />
        <meta property="og:image:height" content="500" />
        @endif
        @if(@$page_description)
        <meta property="og:description" content="<?= htmlspecialchars($page_description); ?>" />
        <meta name="description" content="<?= htmlspecialchars($page_description); ?>" />
        @endif


        @if (in_array(preg_replace('#^en/#', '', \Request::path()), [
            'turkey-guide',
            'turkey-territories',
            'istanbul-districts',
            'jobs',
            'job/salesman',
            'job/sales-manager',
            'job/telesales'
        ], true))
        <meta name="robots" content="noindex, nofollow">
        @elseif((Route::currentRouteName() === 'front.search' || Route::currentRouteName() === 'front.projects' || strpos((string) Route::currentRouteName(), 'front.location.') === 0) && isset($search_noindex) && $search_noindex === true)
        <meta name="robots" content="noindex, follow">
        @elseif(isset($page_index) && ($page_index === "noindex" || $page_index === "noindex, follow"))
        <meta name="robots" content="{{ $page_index }}">
        @else
        <meta name="robots" content="index, follow">
        @endif
        <?php /* <meta name="msvalidate.01" content="CC5D396D64E6055F8BBAAB11324D7AEF" />
          <!--<meta name="google-site-verification" content="UyXUqpKPXukfj_6RN8QIcy645LW36nMuG8rImcisoeA" />
          <meta name="google-site-verification" content="JCEKvL2nf9FEJDfJEEdcqpwzD6RngZG-A0AlAn5xLw4" />-->


         */ ?>
        <meta name="facebook-domain-verification" content="h4nuhlk434dk4z3ymzwyupcaxbnvdo">
        <?php /*
          <link rel="preconnect dns-prefetch" href="//www.googleadservices.com" />
          <link rel="preconnect dns-prefetch" href="//www.google-analytics.com" />
          <link rel="preconnect dns-prefetch" href="//www.googletagmanager.com" />
          <link rel="preconnect dns-prefetch" href="//www.facebook.com" />
          <link rel="preconnect dns-prefetch" href="//connect.facebook.net" />
          <link rel="preconnect dns-prefetch" href="//static.hotjar.com" />
          <link rel="preconnect dns-prefetch" href="//script.hotjar.com" />
          <link rel="preconnect dns-prefetch" href="//googleads.g.doubleclick.net" />

          <?php if(Route::currentRouteName()=='front.index'){ ?>
          <link rel="preconnect dns-prefetch" href="//i.ytimg.com" />
          <?php } ?>

          <link rel="preconnect dns-prefetch" href="//fonts.gstatic.com" />
          <link rel="preconnect dns-prefetch" href="//fonts.googleapis.com" />

          <?php if(!isset($hide_onesignal)){ ?>
          <link rel="preconnect dns-prefetch" href="//www.onesignal.com" />
          <link rel="preconnect dns-prefetch" href="//cdn.onesignal.com" />
          <?php } ?>
         */ ?>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <?php /*        <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800,900&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,800,900&display=swap&subset=arabic" rel="stylesheet"> */ ?>



        <?php /* css and js */ ?>



        @if(isset($page) and $page=='vac')
        <?php /* <script type="text/javascript" src="//script.crazyegg.com/pages/scripts/0111/1113.js" async="async" ></script> */ ?>
        @endif
        
        <script src="https://kit.fontawesome.com/69f3b7df45.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <style>
            .all_select_sec .angle-down, #rightMenuModal > div > div > div.modal-body > div.change_all > div.btn-group.bootstrap-select.currency.dropup > button > span > div {
                border-left: 0.35em solid transparent;
                border-right: 0.35em solid transparent;
                border-top: 0.45em solid;
                margin-left: 5px;
                transition: transform 250ms ease;
                transform: rotate(0deg);
            }
            
            div.show .angle-down {
                transform: rotate(-180deg);
            }
            #page-top > header > nav > div > div > div.all_select_sec > div > div {
                right: 20px;
            }
            #rightMenuModal > div > div > div.modal-body > div.change_all > div.btn-group.bootstrap-select.currency.show > div {
                left: 9px !important;
            }
            #page-top > div.col-md-10.offset-md-1 > div.full_sections.int_page > div.left_sec > div:nth-child(2) > div.section.prices > table > tbody > tr:nth-child(1) > th.color_two > div > button {
                margin-left: 50%;
            }
            @media (max-width: 767px) {
                .shareSection.type_fixed {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body id="page-top">

        <?php if (App::isLocal()) { ?>
            <!--pluguins.min.css-->
            <?= Html::style("resources/assets/css/bootstrap.min.css"); ?>
            <!--<?= Html::style("resources/assets/css/header.css"); ?>-->
            <!--Helper::local_url-->
            <!--<?= Html::style("resources/assets/css/owl.carousel.min.css"); ?>-->
            <?= Html::style("resources/assets/css/intlTelInput.css"); ?>
            <?= Html::style("resources/assets/css/jquery.fancybox.min.css"); ?>
            <?= Html::style("resources/assets/css/font-awesome.min.css"); ?>
            <?= Html::style("resources/assets/css/bootstrap-select.min.css"); ?>
            <?= Html::style("resources/assets/css/jquery-ui-autocomplete.css"); ?>
            <?= Html::style("resources/assets/css/animate.min.css"); ?>
            <?= Html::style("resources/assets/css/font-awesome-animation.css"); ?>


            <?php // Html::style("resources/assets/css/header.css");  ?>
            <!--<?= Html::style("resources/assets/css/global.css"); ?>-->

            <?= Html::style("resources/assets/css/first_view.css"); ?>


            <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
                <style>
					.rightMenuModal .modal-body ul.links_list{text-align: left; direction: ltr;}.complaints_btn span, .complaints_btn p{text-align: left;}.complaints_btn img{left: auto; right: 5px;}.rightMenuModal .join_our_team_btn .damasturk_logo{float: left; right: auto; left: auto;}.complaints_btn p{font-size: 13px;}
					#accordionLinks .panel-title a {
					font-size: 18px;
					text-align: left;
					}
					#accordionLinks .panel-title a strong{
					font-weight: bold;
					}
					#accordionLinks .panel-title a .arrow {
					left: auto;
					right: 22px;
					}
					.rightMenuModal .modal-body ul.links_list li a {
					font-size: 15px;
					}
                </style>
            <?php } ?>





            @yield('styles')




            <?php if ($style_lang == 'en') { ?>
                <?= Html::style("resources/assets/css/style-en.css"); ?>
            <?php } ?>
            <?php if ($current_lang == 'ar') { ?>
                <style>
                    @font-face { 
					font-family: 'Al-Jazeera-Arabic-Regular';
					src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot') }}');
					src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.svg#Al-Jazeera-Arabic-Regular') }}') format('otf'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff') }}') format('woff'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff2') }}') format('woff2'); font-weight: normal; font-style: normal; } @font-face { font-family: 'Al-Jazeera-Arabic Bold'; src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot') }}'); src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.woff2') }}') format('woff2'); 
					font-weight: normal; 
					font-style: normal;
					font-display: swap;
					}
					@font-face { font-family: 'Al-Jazeera-Arabic-Bold'; 
					src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.svg#Al-Jazeera-Arabic-Bold') }}') format('otf'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.woff') }}') format('woff');
					font-weight: normal;
					font-style: normal;
					font-display: swap;
					}
                </style>
            <?php } elseif ($current_lang == 'pe') { ?>
                <?= Html::style("resources/assets/css/fa.css"); ?>
            <?php } elseif ($current_lang == 'fr') { ?>
                <?= Html::style("resources/assets/css/fr.css"); ?>
            <?php } elseif ($current_lang == 'ru') { ?>
                <?= Html::style("resources/assets/css/ru.css"); ?>
            <?php } ?>




        <?php } else { //online  ?>

            <?php // Html::style("css/main.min.css?v=05"); ?>
            
<link rel="stylesheet" type="text/css" href="{{ asset('css/main.min.css?v=05') }}">


			<style>
			#gtx-trans{display:none}
            <?php include(public_path() . "/css/first_view.min.css") ?>
			</style>



            <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
                <style>
                    .rightMenuModal .modal-body ul.links_list{text-align: left; direction: ltr;}.complaints_btn span, .complaints_btn p{text-align: left;}.complaints_btn img{left: auto; right: 5px;}.rightMenuModal .join_our_team_btn .damasturk_logo{float: left; right: auto; left: auto;}.complaints_btn p{font-size: 13px;}
                    #accordionLinks .panel-title a {
                        font-size: 18px;
                        text-align: left;
                      }
                    #accordionLinks .panel-title a strong{
                        font-weight: bold;
                      }
                      #accordionLinks .panel-title a .arrow {
                        left: auto;
                        right: 22px;
                      }
                      .rightMenuModal .modal-body ul.links_list li a {
                        font-size: 15px;
                      }
                </style>
            <?php } ?>

            @yield('styles')

            <?php if ($style_lang == 'en') { ?>
                <?= Html::style("css/style-en.min.css"); ?>
                                <!--<style><?php //include(public_path() . "/css/style-en.min.css");   ?></style>-->
            <?php } ?>
            <?php if ($current_lang == 'ar') { ?>
                <style>
                    @font-face { font-family: 'Al-Jazeera-Arabic-Regular';
					src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot') }}');
					src: url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.svg#Al-Jazeera-Arabic-Regular') }}') format('otf'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff') }}') format('woff'), url('{{ asset('fonts/ar/news/Al-Jazeera-Arabic-Regular.woff2') }}') format('woff2'); 
					font-weight: normal; 
					font-style: normal;
					font-display: swap;
					}
					font-face { font-family: 'Al-Jazeera-Arabic Bold'; src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot') }}'); src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.eot?#iefix') }}') format('embedded-opentype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic Bold.woff2') }}') format('woff2'); 
					font-weight: normal; 
					font-style: normal;
					font-display: swap;
					}
					@font-face { font-family: 'Al-Jazeera-Arabic-Bold'; src: url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.svg#Al-Jazeera-Arabic-Bold') }}') format('otf'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.ttf') }}') format('truetype'), url('{{ asset('fonts/ar/Al-Jazeera-Arabic-Bold.woff') }}') format('woff'); 
					font-weight: normal; 
					font-style: normal;
					font-display: swap;
					}
                </style>
            <?php } elseif ($current_lang == 'pe') { ?>
                <style><?php include(public_path() . "/css/fa.min.css"); ?></style>
            <?php } elseif ($current_lang == 'fr') { ?>
                <style><?php include(public_path() . "/css/fr.min.css"); ?></style>
            <?php } elseif ($current_lang == 'ru') { ?>
                <style><?php include(public_path() . "/css/ru.min.css"); ?></style>
            <?php } ?>
            <?php
        }
        ?>
        <?php if (!isset($hide_onesignal)) { ?>
            <!--Start Show  notif-->
            <div class="notifications-top animate__animated" id="subscribe-notifications-container" style="display:none;">
                <strong class="close-alert"><i class="fa fa-times" aria-hidden="true"></i></strong>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <p><?= trans("front.Subscribe to the site text"); ?></p>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 margin-top">
                    <button id="block_subscribe">Block</button>
                    <button id="subscribe-notifications">Allow</button>
                    <span><i class="fa fa-angle-double-down bounce" aria-hidden="true"></i></span>
                    <img loading="lazy" src="<?= asset("img/alert-icon.svg"); ?>" alt="damasturk"/>
                </div>
            </div>
            <!--End Show  notif-->
        <?php } ?>
        <!-- start nav -->
        <?php
        $localecode = $style_lang == "en" ? "ar" : "en";
        $is_mobile = Helper::is_mobile();
        ?>




        <?php /*
          <!--        <div class="overlay">
          <div class="overlayDoor"></div>
          <div class="overlayContent">
          <div class="loader">
          <div class="inner"></div>
          </div>
          </div>
          </div>--> */ ?>



        


        <?php if (/*Helper::get_device() == 'mob' &&*/ $hide_whatsapp == false) { ?>
            <div class="whatsapp_direct_btn">
                <a target="_blank" class="whatsappBtn " href="<?= Helper::whatsappShareUrl(8, $whatsappContext) ?>">
                    <span class="fa fa-whatsapp"></span>
                </a>
            </div>
        <?php } ?>





        <?php /*
          <!--                <div id="callme" data-toggle="modal" data-target="#callmeModal">
          <div id="callmeMain"></div>
          </div>--> */ ?>


        <?php if (/*Helper::get_device() == 'mob' &&*/ $hide_whatsapp == false) { ?>
             <div class="support_links">

            <span class="mob_icons icon type_mob">
                <a class="support_links_btn" data-fancybox data-type="iframe" data-src="<?= $callmeModalUrl ?>" href="<?= $callmeModalUrl ?>">
                    <img loading="lazy" width="40" height="40" class="icon_one faa-tada animated faa-slow" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="whatsapp-icon"/>
                    <svg width="40" height="32" class="icon_two faa-ring animated faa-slow" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 294.2 288.2" xml:space="preserve"> <g> <path d="M270.5,220.9c-0.6,3.1-1,6.3-1.9,9.3c-4.1,13.5-8.2,27.1-12.5,40.6c-4.4,14-13.8,19.6-28.2,16.8 C150,272.2,88.4,231.8,43.8,166c-9.8-14.5-18-30.1-24.9-46.5c-8.2-19.5-14.1-39.4-18.2-60c-2.4-12.4,2.2-22.1,14.1-26.2 C30.3,27.9,46,23,61.9,18.8c13.1-3.5,22.4,2.4,26.3,15.3c5.5,18,10.9,36,16.6,53.9c2.7,8.6,0.3,15.4-6.3,21 c-5.9,4.9-12.1,9.4-18,14.3c-6.5,5.3-7.3,10.9-2.5,17.9c18.7,27.4,41.8,50.4,69.1,69.2c7.2,4.9,12.7,4.1,18.2-2.7 c4.5-5.6,8.8-11.3,13.3-16.9c6.4-7.9,12.8-9.9,22.5-6.9c18,5.5,36,11,53.9,16.5C265.8,203.6,270.3,209.6,270.5,220.9z"></path> <path d="M294.2,142.3c-0.2,1.1,0,3.7-0.9,5.9c-1.1,2.8-8.6,4.7-12.6,2.6c-2.2-1.1-4.4-4.4-4.5-6.8 c-2.8-63.1-53.6-117.7-116.5-124.9c-3-0.3-6-0.7-8.9-0.9c-6.4-0.5-8.3-3.1-7.9-11.1c0.3-5.3,2.7-7.5,8.6-7.1 c32.4,1.9,61.5,12.8,86.7,33.3c32.4,26.4,50.7,60.7,55.7,102.1C294,137.3,294,139.2,294.2,142.3z"></path> <path d="M241.9,140.7c-0.3,7.9-2.3,10.5-7,10.8c-8,0.5-10.2-1.2-11.3-8.3c-5.7-40.4-33-67.5-73.5-72.7c-6.5-0.8-8.2-3.7-7.3-12 c0.5-4.6,3.2-6.6,9-6.1c42.1,3.6,78.5,34.3,88.1,77.3C240.9,133.8,241.5,138.1,241.9,140.7z"></path> </g> </svg>
                    <svg width="40" height="32" class="icon_three faa-tada animated faa-slow" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 21.3 21.9" xml:space="preserve"><g> <path class="st0" d="M10.7,2.4c3.2,0,5.8,2.6,5.8,5.8c0,1.8-0.8,3.7-2.1,5l-0.9,1l1.3,0.3c3.5,0.9,5.8,2.8,5.8,4.8 c-0.1,0.6-3.5,1.7-9.9,1.7c-6.3,0-9.7-1.1-9.9-1.7c0-1.5,1.2-2.9,3.3-3.9c1.2,1,2.6,1.8,4.1,2.2c0.5,0.8,1.5,1.3,2.5,1.3 c1.6,0,2.9-1.3,2.9-2.9c0-1.6-1.3-2.9-2.9-2.9c-0.7,0-1.4,0.2-1.9,0.7c-1.5-0.5-2.8-1.7-3.4-3.1C5,9.8,4.9,9,4.9,8.2 C4.9,5,7.5,2.4,10.7,2.4 M10.7,1.6c-3.6,0-6.6,3-6.6,6.6c0,0.9,0.2,1.8,0.5,2.7C5.4,12.7,7,14.1,9,14.7c0.4-0.5,1-0.8,1.7-0.8 c1.2,0,2.1,1,2.1,2.2c0,1.2-1,2.1-2.1,2.1c-0.8,0-1.6-0.5-1.9-1.2c-1.7-0.4-3.3-1.3-4.4-2.4C1.7,15.6,0,17.4,0,19.4 c0,1.7,5.3,2.5,10.7,2.5c5.3,0,10.7-0.8,10.7-2.5c0-2.5-2.6-4.6-6.4-5.6c1.4-1.5,2.3-3.6,2.3-5.6C17.3,4.6,14.3,1.6,10.7,1.6 L10.7,1.6z"/> <path class="st1" d="M17.6,13.7"/> <g> <path class="st0" d="M9.3,16.3c0.1,0.6,0.7,1.1,1.4,1.1c0.8,0,1.4-0.6,1.4-1.4c0-0.7-0.6-1.4-1.4-1.4c-0.6,0-1.1,0.4-1.3,0.9 c-3.6-0.6-6.3-3.8-6.1-7.6c0.1-3.8,3.1-6.9,6.9-7.1c4.2-0.3,7.8,2.9,8,7.1c0,0.2,0.2,0.4,0.4,0.4l0,0c0.2,0,0.4-0.2,0.4-0.4 C18.6,3.3,14.7-0.3,10,0C6,0.3,2.8,3.6,2.5,7.6C2.2,11.9,5.2,15.6,9.3,16.3L9.3,16.3z M9.3,16.3"/> </g> </g> </svg>
                </a>
            </span>

            <span class="type_full icon shadow_type">
                <a class="support_links_btn" data-fancybox data-type="iframe" data-src="<?= $callmeModalUrl ?>" href="<?= $callmeModalUrl ?>">
                    <svg width="44" height="32" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 21.3 21.9" xml:space="preserve"><g> <path class="st0" d="M10.7,2.4c3.2,0,5.8,2.6,5.8,5.8c0,1.8-0.8,3.7-2.1,5l-0.9,1l1.3,0.3c3.5,0.9,5.8,2.8,5.8,4.8 c-0.1,0.6-3.5,1.7-9.9,1.7c-6.3,0-9.7-1.1-9.9-1.7c0-1.5,1.2-2.9,3.3-3.9c1.2,1,2.6,1.8,4.1,2.2c0.5,0.8,1.5,1.3,2.5,1.3 c1.6,0,2.9-1.3,2.9-2.9c0-1.6-1.3-2.9-2.9-2.9c-0.7,0-1.4,0.2-1.9,0.7c-1.5-0.5-2.8-1.7-3.4-3.1C5,9.8,4.9,9,4.9,8.2 C4.9,5,7.5,2.4,10.7,2.4 M10.7,1.6c-3.6,0-6.6,3-6.6,6.6c0,0.9,0.2,1.8,0.5,2.7C5.4,12.7,7,14.1,9,14.7c0.4-0.5,1-0.8,1.7-0.8 c1.2,0,2.1,1,2.1,2.2c0,1.2-1,2.1-2.1,2.1c-0.8,0-1.6-0.5-1.9-1.2c-1.7-0.4-3.3-1.3-4.4-2.4C1.7,15.6,0,17.4,0,19.4 c0,1.7,5.3,2.5,10.7,2.5c5.3,0,10.7-0.8,10.7-2.5c0-2.5-2.6-4.6-6.4-5.6c1.4-1.5,2.3-3.6,2.3-5.6C17.3,4.6,14.3,1.6,10.7,1.6 L10.7,1.6z"/> <path class="st1" d="M17.6,13.7"/> <g> <path class="st0" d="M9.3,16.3c0.1,0.6,0.7,1.1,1.4,1.1c0.8,0,1.4-0.6,1.4-1.4c0-0.7-0.6-1.4-1.4-1.4c-0.6,0-1.1,0.4-1.3,0.9 c-3.6-0.6-6.3-3.8-6.1-7.6c0.1-3.8,3.1-6.9,6.9-7.1c4.2-0.3,7.8,2.9,8,7.1c0,0.2,0.2,0.4,0.4,0.4l0,0c0.2,0,0.4-0.2,0.4-0.4 C18.6,3.3,14.7-0.3,10,0C6,0.3,2.8,3.6,2.5,7.6C2.2,11.9,5.2,15.6,9.3,16.3L9.3,16.3z M9.3,16.3"/> </g> </g> </svg>
                </a>
            </span>

            <?php /*<ul>
                <li>
                    <span class="close_menu"><svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 58.48 58.48" xml:space="preserve"><path class="st0" d="M57.39,1.09c-1.45-1.45-3.8-1.45-5.25,0l-22.9,22.9L6.34,1.09c-1.45-1.45-3.8-1.45-5.25,0 c-1.45,1.45-1.45,3.8,0,5.25l22.9,22.9l-22.9,22.9c-1.45,1.45-1.45,3.8,0,5.25c0.73,0.73,1.68,1.09,2.63,1.09s1.9-0.36,2.63-1.09 l22.9-22.9l22.9,22.9c0.73,0.73,1.68,1.09,2.63,1.09c0.95,0,1.9-0.36,2.63-1.09c1.45-1.45,1.45-3.8,0-5.25l-22.9-22.9l22.9-22.9 C58.84,4.89,58.84,2.54,57.39,1.09z"></path> </svg></span>
                    <p class="jazzira_font_bold"><?= trans("front.contactusTitle"); ?></p>
                </li>
                <?php if ($hide_whatsapp == false) { ?>
                    <li>
                        <span class="hoverText num">Whatsapp</span>
                        <a target="_blank" class="whatsappBtn " href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000">
                            <img loading="lazy" width="65" height="65" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="whatsapp-icon"/>
                        </a>
                    </li>
                <?php } ?>
                <li>
                    <span class="hoverText num">Viber</span>
                    <a target="_blank" class="viberBtn " href="viber://chat?number=905551605000">
                        <img loading="lazy" src="<?= asset("img/viber.svg"); ?>" alt="viber-icon" width="52" height="50"/>
                    </a>
                </li>
                <li>
                    <span class="hoverText num">Telegram</span>
                    <a target="_blank" class="telegramBtn " href="https://t.me/damasturk_real_estate">

                        {!! Helper::get_pic(asset("img/telegram.png"),'','','','telegram icon', 'width="50" height="50"') !!}

                    </a>
                </li>
                <li>
                    <span class="hoverText num">Messenger</span>
                    <a target="_blank" class="massengerBtn " href="https://m.me/damasturk">

                        {!! Helper::get_pic(asset("img/messenger.png"),'','','','messenger-icon', 'width="50" height="50"') !!}
                    </a>
                </li>
                <li>
                    <span class="hoverText num">Call</span>
                    <a target="_blank" class="phoneBtn " href="tel:<?= str_replace(' ', '', $infos->tel_1) ?>">
                        <svg width="25" height="25" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 294.2 288.2" xml:space="preserve"> <g> <path d="M270.5,220.9c-0.6,3.1-1,6.3-1.9,9.3c-4.1,13.5-8.2,27.1-12.5,40.6c-4.4,14-13.8,19.6-28.2,16.8 C150,272.2,88.4,231.8,43.8,166c-9.8-14.5-18-30.1-24.9-46.5c-8.2-19.5-14.1-39.4-18.2-60c-2.4-12.4,2.2-22.1,14.1-26.2 C30.3,27.9,46,23,61.9,18.8c13.1-3.5,22.4,2.4,26.3,15.3c5.5,18,10.9,36,16.6,53.9c2.7,8.6,0.3,15.4-6.3,21 c-5.9,4.9-12.1,9.4-18,14.3c-6.5,5.3-7.3,10.9-2.5,17.9c18.7,27.4,41.8,50.4,69.1,69.2c7.2,4.9,12.7,4.1,18.2-2.7 c4.5-5.6,8.8-11.3,13.3-16.9c6.4-7.9,12.8-9.9,22.5-6.9c18,5.5,36,11,53.9,16.5C265.8,203.6,270.3,209.6,270.5,220.9z"/> <path d="M294.2,142.3c-0.2,1.1,0,3.7-0.9,5.9c-1.1,2.8-8.6,4.7-12.6,2.6c-2.2-1.1-4.4-4.4-4.5-6.8 c-2.8-63.1-53.6-117.7-116.5-124.9c-3-0.3-6-0.7-8.9-0.9c-6.4-0.5-8.3-3.1-7.9-11.1c0.3-5.3,2.7-7.5,8.6-7.1 c32.4,1.9,61.5,12.8,86.7,33.3c32.4,26.4,50.7,60.7,55.7,102.1C294,137.3,294,139.2,294.2,142.3z"/> <path d="M241.9,140.7c-0.3,7.9-2.3,10.5-7,10.8c-8,0.5-10.2-1.2-11.3-8.3c-5.7-40.4-33-67.5-73.5-72.7c-6.5-0.8-8.2-3.7-7.3-12 c0.5-4.6,3.2-6.6,9-6.1c42.1,3.6,78.5,34.3,88.1,77.3C240.9,133.8,241.5,138.1,241.9,140.7z"/> </g> </svg>
                    </a>
                </li>
                <li class="type_full">
                    <span class="hoverText num">Message</span>
                    <a data-fancybox="contact-us" class="formBtn " href="#callmeModal"  data-target="#callmeModal">
                        <svg width="44" height="32" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 237.4 238.8" xml:space="preserve"> <path d="M179,70.7c0-15.8-0.2-31.7,0.1-47.5c0.1-4.8-1.4-6.4-6.3-6.4C123,17,73.2,16.9,23.3,16.9c-6.2,0-6.4,0.2-6.4,6.5 c-0.1,33.7-0.3,67.3-0.3,101c0,30.5,0.3,61,0.2,91.5c0,4.6,1.5,6.1,6.1,6.1c50-0.1,100-0.1,150,0c4.9,0,6.3-1.7,6.2-6.4 c-0.2-20.5-0.2-41,0-61.5c0-2.4,1-5.2,2.4-7.2c4.2-6.1,8.9-12,14.4-19.2c0,6.5,0,11.6,0,16.8c0,24.3,0,48.7,0,73 c0,13.2-8.3,21.4-21.7,21.4c-50.8,0-101.7,0-152.5,0C8.3,238.8,0,230.6,0,217c0-24.3,0.3-48.6,0.3-73c0-40.5-0.2-81-0.3-121.5 C0,8,8,0,22.5,0c50.3,0,100.7,0,151,0C188,0,195.9,8,196,22.6c0,3.5,0,7,0,10.5c-0.1,5.7,1.6,12.2-0.7,16.8 c-3.8,7.7-10,14.3-15.2,21.3C179.7,71,179.4,70.9,179,70.7z"/> <path d="M202.3,54.3c8.4,6.3,16.4,12.3,25,18.7c-3.3,4.4-6.2,8.3-9.1,12.3c-21.5,28.7-43,57.5-64.6,86.2c-1.7,2.3-4.3,4.1-6.9,5.4 c-5.9,3-12,5.6-18.2,8.2c-1.5,0.6-3.9,1.2-5,0.5c-1-0.7-1.2-3.2-1.1-4.8c0.7-6.6,1.6-13.2,2.7-19.8c0.4-2.5,1.2-5.3,2.7-7.3 c24.1-32.4,48.3-64.7,72.5-97.1C200.8,56,201.3,55.5,202.3,54.3z"/> <path d="M98.1,106.1c-15.3,0-30.6,0-46,0c-6.6,0-10.3-3-10.2-8.2c0.1-4.9,3.9-7.9,10.1-7.9c30.6,0,61.3,0,91.9,0 c6.1,0,9.9,3.1,9.9,8.1c0,5-3.6,8.1-9.8,8.1C128.8,106.1,113.5,106.1,98.1,106.1z"/> <path d="M98,47.6c15.6,0,31.3-0.1,46.9,0c6.3,0,10.3,4.6,8.8,9.8c-1.3,4.7-4.8,6.4-9.5,6.4c-19-0.1-38,0-56.9,0c-11.7,0-23.3,0-35,0 c-6.5,0-10.3-3.2-10.3-8.3c0.1-5,3.7-7.9,10-7.9C67.3,47.6,82.6,47.6,98,47.6z"/> <path d="M134.1,132.6c-3.8,5.1-6.9,9.6-10.4,13.8c-1.1,1.3-3.3,2.2-5,2.2c-22.2,0.1-44.3,0.1-66.5,0.1c-6.4,0-10.1-3.1-10-7.9 c0.1-5.2,4-8.6,10.1-8.5c21.3,0.1,42.7,0.2,64,0.3C122,132.6,127.6,132.6,134.1,132.6z"/> <path d="M75.3,174.8c7.7,0,15.3-0.1,23,0c5.7,0,9.4,3.4,9.3,8.2c-0.1,4.6-3.7,7.9-9.1,7.9c-15.8,0.1-31.7,0.1-47.5,0 c-5.4,0-8.9-3.3-9-8c-0.1-4.8,3.4-8,8.8-8.1C59,174.7,67.2,174.8,75.3,174.8z"/> <path d="M231.2,67.4c-8.5-6.4-16.5-12.4-24.7-18.6c3-5.3,6.8-10.3,13.4-9.3c7.3,1.1,13.3,5.6,16.5,12.3 C239.2,57.8,235.5,62.9,231.2,67.4z"/> </svg>
                    </a>
                </li>


                <li class="form_mob">
                    <p class="jazzira_font_bold"><?= trans("front.contactusTitle2"); ?></p>
                    <section class="form">
                        @include("front.partials.call_us_fixed")
                    </section>
                </li>


            </ul>*/ ?>

        </div>
        <?php } ?>
        
        
       


<?php /*
        <!-- Modal role="document" -->
        <div class="modal fade callmeModal" id="callmeModal" tabindex="-1" role="dialog" aria-labelledby="callmeModalLabel" aria-hidden="true">
            <div class="modal_sec">

                <div class="image_cont">
                    <img loading="lazy" alt="damasturk" title="damasturk" src="https://damas.net/img/form-photo.jpg">
                </div>

                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title jazzira_font_bold" id="callmeModalLabel"><?= trans("front.keep in touch"); ?></span>

                    </div>
                    <div class="modal-body">

                        <ul class="social_media_icons">
                            <?php if ($hide_whatsapp == false) { ?>
                                <li>
                                    <a target="_blank" class="whatsappBtn faa-tada animated" href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000">
                                        <img loading="lazy" width="65" height="65" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="whatsapp-icon"/>
                                    </a>
                                </li>
                            <?php } ?>
                            <!--<li>
                                <a target="_blank" class="imoBtn faa-wrench animated" href="https://imo.im/">
                                    <img src="<?= asset("img/imo.svg"); ?>" alt="imo-icon"/>
                                </a>
                            </li>-->
                            <li>
                                <a target="_blank" class="viberBtn faa-horizontal animated" href="viber://chat?number=905551605000">
                                    <img loading="lazy" width="52" height="50" src="<?= asset("img/viber-w.svg"); ?>" alt="viber-icon"/>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" class="telegramBtn animated" href="https://t.me/damasturk_real_estate">
                                    {!! Helper::get_pic(asset("img/telegram.png"),'','','','telegram-icon', 'width="50" height="50"') !!}
                                </a>
                            </li>
                            <li>
                                <a target="_blank" class="massengerBtn faa-shake animated" href="https://www.facebook.com/messages/t/397022914228112">
                                    {!! Helper::get_pic(asset("img/messenger.png"),'','','','messenger-icon', 'width="50" height="50"') !!}
                                </a>
                            </li>
                            <li>
                                <a target="_blank" class="phoneBtn faa-ring animated" href="tel:<?= str_replace(' ', '', $infos->tel_1) ?>">
                                    <svg width="25" height="25" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 294.2 288.2" xml:space="preserve"> <g> <path d="M270.5,220.9c-0.6,3.1-1,6.3-1.9,9.3c-4.1,13.5-8.2,27.1-12.5,40.6c-4.4,14-13.8,19.6-28.2,16.8 C150,272.2,88.4,231.8,43.8,166c-9.8-14.5-18-30.1-24.9-46.5c-8.2-19.5-14.1-39.4-18.2-60c-2.4-12.4,2.2-22.1,14.1-26.2 C30.3,27.9,46,23,61.9,18.8c13.1-3.5,22.4,2.4,26.3,15.3c5.5,18,10.9,36,16.6,53.9c2.7,8.6,0.3,15.4-6.3,21 c-5.9,4.9-12.1,9.4-18,14.3c-6.5,5.3-7.3,10.9-2.5,17.9c18.7,27.4,41.8,50.4,69.1,69.2c7.2,4.9,12.7,4.1,18.2-2.7 c4.5-5.6,8.8-11.3,13.3-16.9c6.4-7.9,12.8-9.9,22.5-6.9c18,5.5,36,11,53.9,16.5C265.8,203.6,270.3,209.6,270.5,220.9z"/> <path d="M294.2,142.3c-0.2,1.1,0,3.7-0.9,5.9c-1.1,2.8-8.6,4.7-12.6,2.6c-2.2-1.1-4.4-4.4-4.5-6.8 c-2.8-63.1-53.6-117.7-116.5-124.9c-3-0.3-6-0.7-8.9-0.9c-6.4-0.5-8.3-3.1-7.9-11.1c0.3-5.3,2.7-7.5,8.6-7.1 c32.4,1.9,61.5,12.8,86.7,33.3c32.4,26.4,50.7,60.7,55.7,102.1C294,137.3,294,139.2,294.2,142.3z"/> <path d="M241.9,140.7c-0.3,7.9-2.3,10.5-7,10.8c-8,0.5-10.2-1.2-11.3-8.3c-5.7-40.4-33-67.5-73.5-72.7c-6.5-0.8-8.2-3.7-7.3-12 c0.5-4.6,3.2-6.6,9-6.1c42.1,3.6,78.5,34.3,88.1,77.3C240.9,133.8,241.5,138.1,241.9,140.7z"/> </g> </svg>
                                </a>
                            </li>
                        </ul>


                        <section class="form form_sec">
                            @include("front.partials.call_us_fixed")
                        </section>
                    </div>

                    <img loading="lazy" class="logo" src="<?= asset("/img/form-logo.png"); ?>" alt="damasturk"/>
                    <svg class="logo" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 139.9 20.6" style="enable-background:new 0 0 139.9 20.6;" xml:space="preserve"><style type="text/css">.st0{fill:url(#SVGID_1_);}</style><linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="69.9741" y1="20.5996" x2="69.9741" y2="-9.094947e-13"><stop offset="4.475343e-07" style="stop-color:#D0D0D0"/><stop offset="7.444685e-02" style="stop-color:#D6D6D6"/><stop offset="0.4946" style="stop-color:#F4F4F4"/><stop offset="0.7328" style="stop-color:#FFFFFF"/></linearGradient><path class="st0" d="M12.1,0l-1,5.6c-0.9-0.2-1.7-0.3-2.5-0.3c-4.5,0-7.3,2.6-8.2,7.7c-0.5,2.6-0.3,4.5,0.6,5.8c0.9,1.3,2.6,1.9,5,1.9c1,0,2.1-0.1,3.1-0.3s1.8-0.4,2.2-0.5c0.4-0.1,0.7-0.2,0.9-0.3L15.7,0H12.1z M8.8,17.3c-0.7,0.2-1.5,0.3-2.4,0.3c-1.3,0-2.1-0.4-2.4-1.2c-0.3-0.8-0.4-2-0.1-3.5c0.3-1.5,0.8-2.7,1.4-3.5C6,8.6,7,8.2,8.2,8.2c0.8,0,1.6,0.1,2.2,0.3L8.8,17.3z M24,5.2c-2.1,0-3.9,0.4-5.6,1.1L18.6,9l0.5-0.2c0.4-0.1,0.9-0.3,1.6-0.4c0.7-0.1,1.4-0.2,2.1-0.2c2.1,0,3,0.8,2.7,2.4l-0.3,1.6c-0.7-0.1-1.6-0.2-2.5-0.2c-4.1,0-6.4,1.4-6.9,4.3c-0.5,2.9,1.2,4.3,5.3,4.3c1.2,0,2.3-0.1,3.4-0.3c1.1-0.2,1.9-0.4,2.2-0.5c0.4-0.1,0.6-0.2,0.8-0.3l1.6-8.7c0.4-1.9,0.1-3.3-0.8-4.2C27.4,5.6,26,5.2,24,5.2z M24.2,17.9l-0.3,0.1c-0.2,0.1-0.5,0.1-0.9,0.2c-0.4,0.1-0.8,0.1-1.2,0.1c-0.8,0-1.4-0.1-1.8-0.4c-0.4-0.3-0.5-0.8-0.4-1.5c0.1-0.7,0.5-1.2,1-1.5c0.5-0.3,1.2-0.4,2.2-0.4c0.5,0,1.3,0.1,2.2,0.2L24.2,17.9z M53.9,6.6c0.9,1,1.1,2.5,0.7,4.7l-1.7,8.9h-3.7L51,11c0.2-1.1,0.1-1.9-0.4-2.3c-0.5-0.4-1.1-0.6-1.9-0.6c-1,0-2.1,0.2-3.1,0.7c0.1,0.7,0,1.6-0.2,2.5l-1.7,8.9h-3.7l1.8-9.3c0.2-1.1,0.1-1.9-0.3-2.2c-0.4-0.4-1.1-0.6-2-0.6c-0.5,0-0.9,0-1.4,0.1c-0.4,0.1-0.8,0.1-1,0.2l-0.3,0.1l-2.2,11.7H31l2.6-13.8c0.2-0.1,0.5-0.2,0.9-0.3c0.4-0.1,1.2-0.3,2.4-0.5c1.2-0.2,2.3-0.3,3.5-0.3c1.9,0,3.3,0.3,4.1,1c1.7-0.7,3.5-1,5.2-1C51.6,5.2,53.1,5.7,53.9,6.6z M64.8,5.2c-2.1,0-3.9,0.4-5.6,1.1L59.4,9L60,8.8c0.4-0.1,0.9-0.3,1.6-0.4c0.7-0.1,1.4-0.2,2.1-0.2c2.1,0,3,0.8,2.7,2.4l-0.3,1.6c-0.7-0.1-1.6-0.2-2.5-0.2c-4.1,0-6.4,1.4-6.9,4.3c-0.5,2.9,1.2,4.3,5.3,4.3c1.2,0,2.3-0.1,3.4-0.3c1.1-0.2,1.9-0.4,2.2-0.5c0.4-0.1,0.6-0.2,0.8-0.3l1.6-8.7c0.4-1.9,0.1-3.3-0.8-4.2C68.2,5.6,66.8,5.2,64.8,5.2z M65,17.9l-0.3,0.1c-0.2,0.1-0.5,0.1-0.9,0.2c-0.4,0.1-0.8,0.1-1.2,0.1c-0.8,0-1.4-0.1-1.8-0.4c-0.4-0.3-0.5-0.8-0.4-1.5c0.1-0.7,0.5-1.2,1-1.5c0.5-0.3,1.2-0.4,2.2-0.4c0.5,0,1.3,0.1,2.2,0.2L65,17.9z M82.9,5.4c0.9,0.1,1.4,0.3,1.7,0.4l-1.1,2.8c-1-0.3-2.2-0.5-3.6-0.5c-2,0-3,0.4-3.2,1.3c0,0.2,0,0.5,0.1,0.7c0.1,0.2,0.3,0.4,0.6,0.5c0.3,0.1,0.6,0.3,0.8,0.3c0.3,0.1,0.6,0.2,1.2,0.3c0.7,0.2,1.2,0.4,1.7,0.6c0.5,0.2,0.9,0.5,1.3,0.9c0.4,0.4,0.7,0.8,0.8,1.4c0.1,0.6,0.1,1.2,0,1.9c-0.3,1.6-1.1,2.7-2.3,3.5c-1.3,0.7-2.9,1.1-4.8,1.1c-0.8,0-1.6-0.1-2.4-0.2c-0.7-0.1-1.3-0.2-1.6-0.4l-0.5-0.2l1-2.8c1.1,0.4,2.4,0.6,4,0.6c1.9,0,2.9-0.5,3.1-1.4c0.1-0.5-0.1-0.9-0.5-1.1c-0.4-0.2-1.1-0.5-2.1-0.8c-0.6-0.2-1.2-0.4-1.6-0.6c-0.5-0.2-0.9-0.5-1.4-0.9c-0.5-0.4-0.8-0.8-0.9-1.4c-0.2-0.6-0.2-1.2,0-2c0.3-1.6,1.1-2.7,2.4-3.4c1.3-0.7,2.8-1,4.7-1C81.2,5.2,82.1,5.3,82.9,5.4z M92.9,5.5h3.9l-0.6,2.9h-3.9l-1.2,6.5c-0.3,1.8,0.2,2.7,1.7,2.7c0.3,0,0.6,0,1-0.1c0.3-0.1,0.6-0.1,0.8-0.2l0.3-0.1L94.8,20c-0.9,0.4-2,0.6-3.3,0.6c-3.3,0-4.7-1.9-3.9-5.7l1.2-6.5h-1.8l0.6-2.9h1.8L90,1.8l3.8-0.5L92.9,5.5z M109.4,5.5h3.7l-2.6,13.8c-0.2,0.1-0.5,0.2-0.9,0.3c-0.4,0.1-1.2,0.3-2.3,0.5c-1.2,0.2-2.3,0.3-3.4,0.3c-2.2,0-3.7-0.5-4.6-1.4c-0.9-0.9-1.1-2.5-0.7-4.8l1.7-8.9h3.7l-1.8,9.3c-0.2,1.1-0.1,1.9,0.4,2.2c0.5,0.4,1.2,0.6,2.1,0.6c0.4,0,0.9,0,1.3-0.1c0.4-0.1,0.8-0.1,1-0.2l0.3-0.1L109.4,5.5z M124.3,5.4l-0.8,3c-0.2,0-0.5,0-0.9,0c-0.9,0-1.7,0.1-2.7,0.4l-2.2,11.5H114l2.6-13.8c1.7-0.8,3.6-1.2,5.9-1.2C123.2,5.3,123.8,5.3,124.3,5.4z M137,17.5l0.7-0.1l-0.5,2.7c-0.5,0.2-1.1,0.3-1.8,0.3c-1.5,0-2.7-0.8-3.7-2.4l-2.6-4.2l-1.2,6.4h-3.7L128.1,0h3.7l-2.3,12.2l6.4-6.7h4.1l-6.9,7.2l2.2,3.5C135.8,17.1,136.4,17.5,137,17.5z"/></svg>

                    
                </div>
            </div>
        </div>
*/ ?>

        <!-- Right Menu Modal -->
        <div class="modal fade rightMenuModal" id="rightMenuModal" tabindex="-1" role="dialog" aria-labelledby="rightMenuModalLabel" aria-hidden="true">
            <div class="modal_sec">

                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title jazzira_font_bold" id="rightMenuModalLabel"><?= trans("front.Fast Links"); ?></span>

                    </div>
                    <div class="modal-body">
                        
                        <div class="panel-group" id="accordionLinks" role="tablist" aria-multiselectable="true">
                        
						<?php
                        /* display only on full */
                        echo Helper::new_menu_tree_front(0, 0, Helper::query("Menu", "orderByPlacement", ["lang" => ["all", $current_lang]])->toArray());
                        ?>
						
                        </div>
                        
                        
                        
                        
                        
                        

                       <?php /* <ul class="links_list">
                            <li>
                                <a class="btn_360_menu" href="{{ route('front.view_360') }}" title="360">
                                    <svg width='80' height='50' version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 30.6 19.5" style="enable-background:new 0 0 30.6 19.5;" xml:space="preserve"><style type="text/css">.st0{fill:#058687;}</style><g><path class="st0" d="M10.4,9.9c0-1.4-1-2.3-2.2-2.5l0,0C9.4,7,10,6.1,10,5.1c0-1.2-0.9-2.3-2.8-2.3c-1,0-2,0.4-2.5,0.7l0.3,1c0.5-0.3,1.2-0.6,2-0.6c1.2,0,1.7,0.7,1.7,1.5C8.7,6.5,7.5,7,6.6,7H5.8v1h0.7C7.8,8,9,8.5,9.1,9.9c0,0.8-0.5,1.9-2.2,1.9c-0.9,0-1.8-0.4-2.1-0.6l-0.4,1c0.5,0.3,1.4,0.7,2.5,0.7C9.2,12.8,10.4,11.5,10.4,9.9z"/><path class="st0" d="M15.3,12.8c2,0,3.2-1.6,3.2-3.4c0-1.9-1.2-3.1-2.9-3.1c-1.1,0-1.9,0.5-2.3,1.1l0,0c0.2-1.6,1.3-3.1,3.4-3.4c0.4-0.1,0.7-0.1,1-0.1V2.8c-0.2,0-0.6,0-1,0.1c-1.2,0.1-2.3,0.6-3.1,1.4c-1,1-1.6,2.5-1.6,4.4C11.9,11.2,13.2,12.8,15.3,12.8z M13.3,8.5c0.4-0.7,1.1-1.2,1.9-1.2c1.2,0,2,0.8,2,2.2s-0.8,2.3-1.9,2.3c-1.4,0-2.1-1.2-2.1-2.8C13.2,8.8,13.2,8.6,13.3,8.5z"/><path class="st0" d="M22.8,12.8c2.1,0,3.4-1.8,3.4-5.1c0-3.1-1.2-4.9-3.2-4.9s-3.4,1.8-3.4,5C19.6,11.1,20.9,12.8,22.8,12.8z M22.9,3.8c1.4,0,2,1.6,2,3.9c0,2.5-0.6,4-2,4c-1.2,0-2-1.4-2-3.9C20.9,5.2,21.7,3.8,22.9,3.8z"/><path class="st0" d="M27.5,3.2c0.9,0,1.6-0.7,1.6-1.6S28.4,0,27.5,0C26.7,0,26,0.7,26,1.6S26.7,3.2,27.5,3.2z M27.5,0.6c0.5,0,1,0.4,1,1c0,0.5-0.4,1-1,1c-0.5,0-1-0.4-1-1C26.6,1.1,27,0.6,27.5,0.6z"/><path class="st0" d="M30.6,12.9L30.6,12.9c0-0.1,0-0.1,0-0.1v-0.1v-0.1c0-0.1,0-0.1-0.1-0.2c0-0.1-0.1-0.3-0.2-0.4c-0.1-0.1-0.2-0.2-0.2-0.3l0,0l0,0L30,11.5l-0.1-0.1c-0.2-0.2-0.4-0.3-0.6-0.4c-0.4-0.2-0.8-0.4-1.2-0.6c-0.2-0.1-0.4-0.1-0.6-0.2c-0.1,0-0.1,0-0.2,0s-0.1,0-0.2,0s-0.2,0-0.3-0.1c0.1,0.1,0.2,0.1,0.3,0.2l0.1,0.1l0.1,0.1c0.2,0.1,0.4,0.2,0.5,0.4c0.3,0.2,0.7,0.5,1,0.8c0.1,0.1,0.3,0.3,0.4,0.4c0,0,0,0.1,0.1,0.1v0.1l0,0l0,0c0,0.1,0.1,0.2,0.1,0.2c0,0.1,0,0.1,0,0.2v0.1l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0v0.1l0,0l0,0c-0.1,0.1-0.2,0.2-0.3,0.3c-0.1,0.1-0.3,0.2-0.4,0.3c-0.2,0.1-0.3,0.2-0.5,0.3S27.9,14,27.7,14c-0.2,0.1-0.4,0.1-0.6,0.2H27h-0.1h-0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.2,0.1-0.4,0.1-0.6,0.2c-0.1,0-0.2,0-0.3,0.1h-0.1h-0.1c-0.4,0.1-0.8,0.2-1.2,0.2l-0.3,0.1h-0.2h-0.2c-0.2,0-0.4,0.1-0.6,0.1c-0.4,0.1-0.8,0.1-1.2,0.2c-0.2,0-0.4,0-0.6,0.1c-0.2,0-0.4,0-0.6,0.1c-1.5,0.1-2.5,0.2-4,0.2l2,1.3l-2.1,1.4c1.7,0,2.7-0.1,4.4-0.4c0.2,0,0.4-0.1,0.7-0.1c0.2,0,0.4-0.1,0.7-0.1c0.4-0.1,0.9-0.2,1.3-0.3c0.9-0.2,1.7-0.4,2.6-0.7c0.4-0.2,0.9-0.3,1.3-0.5c0.1,0,0.2-0.1,0.3-0.1l0.2-0.1H28h0.1c0.2-0.1,0.4-0.2,0.6-0.3c0.1-0.1,0.2-0.1,0.3-0.2l0.1-0.1l0.1-0.1c0.2-0.1,0.4-0.3,0.6-0.5s0.4-0.4,0.5-0.6c0.2-0.2,0.3-0.5,0.4-0.7v-0.1v-0.1c0-0.1,0-0.2,0-0.2L30.6,12.9L30.6,12.9L30.6,12.9L30.6,12.9C30.6,13,30.6,12.9,30.6,12.9z"/><path class="st0" d="M14.5,15.9l-0.3-0.2L13,14.9v1c-0.1,0-0.2,0-0.2,0c-0.8,0-1.7-0.1-2.5-0.2c-0.4,0-0.8-0.1-1.2-0.1s-0.8-0.1-1.2-0.2H7.6c-0.1,0-0.2,0-0.3,0H7.1H6.9l-0.3-0.1c-0.4-0.1-0.8-0.2-1.2-0.2C5,15,4.6,14.9,4.2,14.8c-0.1,0-0.2-0.1-0.3-0.1H3.8H3.7H3.6c-0.2-0.1-0.4-0.1-0.6-0.2c-0.2-0.1-0.4-0.2-0.5-0.2C2.3,14.2,2.2,14.1,2,14c-0.3-0.2-0.6-0.4-0.7-0.6l0,0l0,0v-0.1l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0v-0.1c0-0.1,0-0.1,0-0.2c0-0.1,0.1-0.1,0.1-0.2l0,0l0,0v-0.1c0,0,0-0.1,0.1-0.1c0.1-0.2,0.2-0.3,0.4-0.4c0.3-0.3,0.6-0.5,1-0.8c0.2-0.1,0.4-0.2,0.5-0.4l0.1-0.1l0.1-0.1c0.1-0.1,0.2-0.1,0.3-0.2c-0.1,0-0.2,0-0.3,0.1c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0-0.2,0c-0.2,0.1-0.4,0.1-0.6,0.2c-0.4,0.1-0.8,0.3-1.2,0.6C1.2,11,1,11.2,0.8,11.3l-0.1,0.1c0,0,0,0-0.1,0.1l0,0l0,0c-0.1,0.1-0.2,0.2-0.2,0.3c-0.1,0.1-0.1,0.3-0.2,0.4c0,0.1,0,0.1-0.1,0.2v0.1v0.1c0,0,0,0,0,0.1v0.1v0.1V13l0,0l0,0v0.1c0,0.1,0,0.2,0,0.2v0.1v0.1c0.1,0.3,0.3,0.5,0.4,0.7c0.2,0.2,0.3,0.4,0.5,0.6c0.2,0.2,0.4,0.3,0.6,0.5l0.1,0.1L2,15.7c0.1,0.1,0.2,0.1,0.3,0.2c0.2,0.1,0.4,0.2,0.6,0.3H3h0.1l0.2,0.1c0.1,0,0.2,0.1,0.3,0.1c0.4,0.2,0.8,0.4,1.3,0.5c0.9,0.3,1.7,0.5,2.6,0.7C7.8,17.9,8.3,18,8.7,18c0.4,0.1,0.9,0.2,1.3,0.2c1,0.1,2,0.2,3,0.3v1l1.2-0.8l0.2-0.1l2.1-1.4L14.5,15.9z"/></g></svg>
                                </a>
                            </li>
                        </ul>*/ ?>

                        <?php /*
                        <div class="complaints_btn" title="complaints">
                            <p class="jazzira_font_bold"><?= trans("front.quick menu link 18"); ?></p>
                            <a title="HOTLINE CALL" href="tel:00905451605000">
                                <span class="num">+90 545 160 5000</span>
                            </a>
                            <?php if ($hide_whatsapp == false) { ?>
                                <a title="Complaints Whatsapp" href="https://api.whatsapp.com/send?phone=905451605000&text=">
                                    <img loading="lazy" width="60" height="60" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="complaints-icon"/>
                                </a>
                            <?php } ?>
                        </div>*/ ?>


                        <div class="socialicon sec">
                            <a class="youtube" href="<?= $infos->youtube; ?>" rel="noopener nofollow" target="_blank" title="damasturk youtube"><i class="fa fa-youtube-play"></i></a>
                            <a class="instagram" href="<?= $infos->instagram; ?>" rel="noopener nofollow" target="_blank" title="damasturk instagram"><i class="fa fa-instagram"></i></a>

                            <a class="twitter" href="<?= $infos->twitter; ?>" rel="noopener nofollow" target="_blank" title="damasturk twitter">
                               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#5090a5" width="29px" 
                                height="31px" style="margin-bottom:-6px">
                                <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                                </svg>
                            </a>
                            
                            <a class="facebook" href="<?= $infos->facebook; ?>" rel="noopener nofollow" target="_blank" title="damasturk facebook"><i class="fa fa-facebook-f"></i></a>
                           
                        </div>
                        <div class="change_all">
                            <div class="change_lang_modal" style="margin-bottom:2%">
                                <?php if($current_lang == 'ar'){ ?>
                                    <a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('en')); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" style="fill: currentColor;position:relative;top:6px;width:1.3em"><path d="M415.9 344L225 344C227.9 408.5 242.2 467.9 262.5 511.4C273.9 535.9 286.2 553.2 297.6 563.8C308.8 574.3 316.5 576 320.5 576C324.5 576 332.2 574.3 343.4 563.8C354.8 553.2 367.1 535.8 378.5 511.4C398.8 467.9 413.1 408.5 416 344zM224.9 296L415.8 296C413 231.5 398.7 172.1 378.4 128.6C367 104.2 354.7 86.8 343.3 76.2C332.1 65.7 324.4 64 320.4 64C316.4 64 308.7 65.7 297.5 76.2C286.1 86.8 273.8 104.2 262.4 128.6C242.1 172.1 227.8 231.5 224.9 296zM176.9 296C180.4 210.4 202.5 130.9 234.8 78.7C142.7 111.3 74.9 195.2 65.5 296L176.9 296zM65.5 344C74.9 444.8 142.7 528.7 234.8 561.3C202.5 509.1 180.4 429.6 176.9 344L65.5 344zM463.9 344C460.4 429.6 438.3 509.1 406 561.3C498.1 528.6 565.9 444.8 575.3 344L463.9 344zM575.3 296C565.9 195.2 498.1 111.3 406 78.7C438.3 130.9 460.4 210.4 463.9 296L575.3 296z"/></svg>
                                        <span>EN</span>
                                    </a>
                                <?php }
                                elseif($current_lang == 'en'){ ?>
                                    <a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('ar')); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" style="fill: currentColor;position:relative;top:6px;width:1.3em"><path d="M415.9 344L225 344C227.9 408.5 242.2 467.9 262.5 511.4C273.9 535.9 286.2 553.2 297.6 563.8C308.8 574.3 316.5 576 320.5 576C324.5 576 332.2 574.3 343.4 563.8C354.8 553.2 367.1 535.8 378.5 511.4C398.8 467.9 413.1 408.5 416 344zM224.9 296L415.8 296C413 231.5 398.7 172.1 378.4 128.6C367 104.2 354.7 86.8 343.3 76.2C332.1 65.7 324.4 64 320.4 64C316.4 64 308.7 65.7 297.5 76.2C286.1 86.8 273.8 104.2 262.4 128.6C242.1 172.1 227.8 231.5 224.9 296zM176.9 296C180.4 210.4 202.5 130.9 234.8 78.7C142.7 111.3 74.9 195.2 65.5 296L176.9 296zM65.5 344C74.9 444.8 142.7 528.7 234.8 561.3C202.5 509.1 180.4 429.6 176.9 344L65.5 344zM463.9 344C460.4 429.6 438.3 509.1 406 561.3C498.1 528.6 565.9 444.8 575.3 344L463.9 344zM575.3 296C565.9 195.2 498.1 111.3 406 78.7C438.3 130.9 460.4 210.4 463.9 296L575.3 296z"/></svg>
                                        <span>AR</span>
                                    </a>
                                <?php } ?>
                            </div>
                            <select class="selectpicker currency" onchange="window.location = this.options[this.selectedIndex].value">
                                <?php $selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;     ?>
                                <?php
                                $ex = unserialize($infos->exchange);
                                if ($ex)
                                    foreach ($ex as $k => $v) {
                                        if(!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND'))){ ?>
                                            <option data-icon="flag_icon <?= $k ?>" class="<?= $k ?>" <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= route('front.currency', [$k]); ?>"><?= $k ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <?php /*<!-- cookies Message -->
        <div class="cookies_sec animate__animated">
            <button id="close_cookies_sec" class="close"><svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 58.48 58.48" xml:space="preserve"><style type="text/css">.st0{fill:#E94A44}</style><path class="st0" d="M57.39,1.09c-1.45-1.45-3.8-1.45-5.25,0l-22.9,22.9L6.34,1.09c-1.45-1.45-3.8-1.45-5.25,0 c-1.45,1.45-1.45,3.8,0,5.25l22.9,22.9l-22.9,22.9c-1.45,1.45-1.45,3.8,0,5.25c0.73,0.73,1.68,1.09,2.63,1.09s1.9-0.36,2.63-1.09 l22.9-22.9l22.9,22.9c0.73,0.73,1.68,1.09,2.63,1.09c0.95,0,1.9-0.36,2.63-1.09c1.45-1.45,1.45-3.8,0-5.25l-22.9-22.9l22.9-22.9 C58.84,4.89,58.84,2.54,57.39,1.09z"/> </svg></button>
            <p>
                <?= trans("front.Privacy Policy Message"); ?> <a href="{{ route('front.terms') }}"><?= trans("front.terms of use"); ?></a> .
            </p>
        </div>*/ ?>




        <!-- share buttons -->


        <?php if (Helper::get_device() == 'full') { ?>
            <div class="shareSection type_fixed hide">
                <div class="shareBtnsFloating sharepost">
                    <a href="#" target="_blank" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i><span class="hoverText"><?= trans("front.Share on Facebook"); ?></span></a>
                    <a href="#" target="_blank" class="btnshare" data-network="twitter">
                        <i>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#5090a5"
                            width="27px" height="36px">
                            <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>
                        </svg>
                        </i>
                        <span class="hoverText"><?= trans("front.Share on Twitter"); ?></span>
                    </a>
                    <a href="#" target="_blank" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i><span class="hoverText"><?= trans("front.Share on WhatsApp"); ?></span></a>
                </div>
            </div>
        <?php } ?>






        <!-- Start Header  -->
        <header class="header">
            <nav class="navbar navbar-expand-sm">

                <div class="sub">
                    <a class="navbar-brand mob" href="{{ route('front.index') }}">
                        
                       <?php /*
                        @if($ccountry=='oman')
                        
                        <img width="110" height="19" src="https://damas.net/img/Damas.png" style="margin-top: 18px;" alt="damasgulf">
                        
                        @else
                        
                        @if (Route::currentRouteName() === 'front.index' or Route::currentRouteName() === 'front.aboutus')
                        <img width="90" height="19" src="https://damas.net/img/damas.png" style="margin-top: 19px;width: 90px;" alt="damas">
                        @else
                        <img width="155" height="53" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>
                        @endif
                        
                        @endif
                        */ ?>
                        
                        <img width="90" height="19" src="https://damas.net/img/damas.png" style="margin-top: 19px;width: 90px;" alt="damas">
                        
                        
                        
                        
                    </a>

                    <?php //if (Helper::get_device() == 'full') { ?> 
                        <div class="navbar-collapse">
                        
                            <div class="all_select_sec">

                                <select class="selectpicker currency" onchange="window.location = this.options[this.selectedIndex].value">
                                    <?php $selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;     ?>
                                    <?php
                                    $ex = unserialize($infos->exchange);
                                    if ($ex)
                                        foreach ($ex as $k => $v) {
                                            if(!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND'))){ ?>
                                                <option data-icon="flag_icon <?= $k ?>" class="<?= $k ?>" <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= route('front.currency', [$k]); ?>"><?= $k ?></option>
                                                <?php
                                            }
                                        }
                                    ?>

                                </select>

                            </div>
                            

                            <div class="sosial_media_links">
                                <a  target="_blank" href="https://www.youtube.com/damasturk" class="youtube"><div class="button icon" role="button"></div></a>
<!--                                <a  target="_blank" href="https://twitter.com/damasturk/" class="twitter"><div class="button icon" role="button"></div></a>-->
                                <a  target="_blank" href="<?= $ccountry=='oman'?'https://www.instagram.com/damasgulfinvest/':'https://www.instagram.com/damasturk/' ?>" class="instagram"><div class="button icon" role="button"><i class="fa fa-instagram"></i></div></a>
                                <a  target="_blank" href="<?= $ccountry=='oman'?'https://www.facebook.com/DamasGulfInvest':'https://www.facebook.com/damasturk/' ?>" class="facebook"><div class="button icon" role="button"></div></a>
                                <?php if ($hide_whatsapp == false) { ?>
                                    <a  target="_blank" href="<?= Helper::whatsappShareUrl(7, $whatsappContext) ?>" class="whatsapp"><div class="button icon" role="button"></div></a>
                                    <!--<span class="num">+<?= $ccountry=='oman'?'968 98 27 25 85':'90 555 160 50 00' ?></span>-->
                                <?php } ?>
                            </div>



                        </div>
                    <?php //} ?>
                </div>
            </nav>

            <div class="main_menu">
                <!--<a href="{{ route('front.turkish_citizenship') }}"> <img loading="lazy" width="160" height="123" class="flag_header" src="<?= asset("img/Flag-Header.svg"); ?>" alt="damasturk"/></a>-->
                <a class="navbar-brand full" href="{{ route('front.index') }}">
                    
                    <?php /*
                    @if($ccountry=='oman')
                        <img width="110" height="19" src="https://damas.net/img/Damas.png" style="margin-top: 29px;" alt="damasgulf">
                    @else
                        @if (Route::currentRouteName() === 'front.index' or Route::currentRouteName() === 'front.aboutus')
                            <img width="90" height="19" src="https://damas.net/img/damas.png" style="margin-top: 30px;width:90px" alt="damas">
                        @else
                        <img loading="lazy" width="210" height="76" src="<?= asset("img/damas-turk-logo.svg"); ?>" alt="damasturk"/>    
                        @endif
                    @endif
                    */ ?>
                    
                    <img width="90" height="19" src="https://damas.net/img/damas.png" style="margin-top: 30px;width:90px" alt="damas">
                    
                    
                </a>
                <ul class="links">
                    <li class="toolt"><span class="tooltiptext"><?= trans("front.Fast Links"); ?></span>
                        <a class="right_menu_btn" data-fancybox="quick-menu" href="#rightMenuModal" data-target="#rightMenuModal">
                            <svg width="30" height="30" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 385 264.7" xml:space="preserve"><g><g id="Menu"><path d="M12,24.1h360.9c6.6,0,12-5.4,12-12c0-6.6-5.4-12-12-12H12C5.4,0,0,5.4,0,12S5.4,24.1,12,24.1z"/><path d="M372.9,120.3H12c-6.6,0-12,5.4-12,12c0,6.6,5.4,12,12,12h360.9c6.6,0,12-5.4,12-12C385,125.7,379.6,120.3,372.9,120.3z"/><path d="M372.9,240.6H12c-6.6,0-12,5.4-12,12c0,6.6,5.4,12,12,12h360.9c6.6,0,12-5.4,12-12C385,246,379.6,240.6,372.9,240.6z"/></g></g></svg>
                        </a>
                    </li>
                    <li class="toolt home_page_sec_link"><span class="tooltiptext"><?= trans("front.home"); ?></span>
                        <a class="home_page" href="{{ route('front.index') }}">
                            <svg width="30" height="26" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 29.3 26.2" xml:space="preserve"><path class="st0" d="M11.5,25.6v-8.2c0-0.3,0.2-0.5,0.5-0.5h5.1c0.3,0,0.5,0.2,0.5,0.5v8.2c0,0.3,0.2,0.5,0.5,0.5h6.7 c0.3,0,0.5-0.2,0.5-0.5V14.3c0-0.3,0.2-0.5,0.5-0.5h2.7c0.5,0,0.7-0.6,0.4-0.9L15,0.1c-0.2-0.2-0.5-0.2-0.7,0L0.2,12.8 c-0.4,0.3-0.1,0.9,0.4,0.9h2.7c0.3,0,0.5,0.2,0.5,0.5v11.3c0,0.3,0.2,0.5,0.5,0.5H11C11.3,26.2,11.5,25.9,11.5,25.6z"/> </svg>
                        </a>
                    </li>
                    <li class="toolt"><span class="tooltiptext"><?= trans("front.TurkishCitizenship"); ?></span>
                        <a class="turkish_citizenship" href="https://damas.net/ar/turkiye/guides/citizenship-property-investment">
                            <?php /* <img class="passport" src="<?= asset("img/passportS.png"); ?>" alt="damasturk"/>  */ ?>

                            {!! Helper::get_pic(asset("img/passportS2-SM-2.png"),'passport','','','damasturk', 'width="51" height="37"') !!}

                        </a>
                    </li>
                    <li class="toolt"><span class="tooltiptext"><?= trans("front.projects"); ?></span>
                        <a class="projects_btn" href="<?= $projectsUrl ?>">
                            <svg width="30" height="31" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 25 26" xml:space="preserve"><g> <path class="st0" d="M4.6,5.2l6.6,2l0.3-1.1L4.5,4L1.4,5.8l0.6,1L4.6,5.2z M4.6,5.2"/> <path class="st0" d="M4.6,7.2l6.6,2l0.3-1.1L4.5,6L1.4,7.8l0.6,1L4.6,7.2z M4.6,7.2"/> <path class="st0" d="M4.6,9.2l6.6,2l0.3-1.1L4.5,8L1.4,9.8l0.6,1L4.6,9.2z M4.6,9.2"/> <path class="st0" d="M4.6,11.2l6.6,2l0.3-1.1L4.5,9.9l-3.1,1.8l0.6,1L4.6,11.2z M4.6,11.2"/> <path class="st0" d="M4.6,13.2l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,13.2z M4.6,13.2"/> <path class="st0" d="M4.6,15.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,15.1z M4.6,15.1"/> <path class="st0" d="M4.6,17.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,17.1z M4.6,17.1"/> <path class="st0" d="M4.6,19.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L4.6,19.1z M4.6,19.1"/> <path class="st0" d="M15.4,5.2l6.6,2l0.3-1.1L15.3,4l-3.1,1.8l0.6,1L15.4,5.2z M15.4,5.2"/> <path class="st0" d="M15.4,3.2l6.6,2l0.3-1.1L15.3,2l-3.1,1.8l0.6,1L15.4,3.2z M15.4,3.2"/> <path class="st0" d="M15.4,1.2l6.6,2l0.3-1.1L15.3,0l-3.1,1.8l0.6,1L15.4,1.2z M15.4,1.2"/> <path class="st0" d="M15.4,7.2l6.6,2l0.3-1.1L15.3,6l-3.1,1.8l0.6,1L15.4,7.2z M15.4,7.2"/> <path class="st0" d="M15.4,9.2l6.6,2l0.3-1.1L15.3,8l-3.1,1.8l0.6,1L15.4,9.2z M15.4,9.2"/> <path class="st0" d="M15.4,11.2l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,11.2z M15.4,11.2"/> <path class="st0" d="M15.4,13.2l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,13.2z M15.4,13.2"/> <path class="st0" d="M15.4,15.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,15.1z M15.4,15.1"/> <path class="st0" d="M15.4,17.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,17.1z M15.4,17.1"/> <path class="st0" d="M15.4,19.1l6.6,2l0.3-1.1l-7.1-2.1l-3.1,1.8l0.6,1L15.4,19.1z M15.4,19.1"/> <path class="st0" d="M22,24.9v-1.9l0.3-1l-7.1-2.1l-3.1,1.8l0.3,0.5v2.7h-1.2v-1.9l0.3-1l-7.1-2.1l-3.1,1.8l0.3,0.5v2.7H0V26h25 v-1.1H22z M6.1,24.9v-2.3l3.5,0.8v1.5H6.1z M16.9,24.9v-2.3l3.5,0.8v1.5H16.9z M16.9,24.9"/> </g> </svg>
                        </a>
                    </li>
                    <?php /* if (strtolower(@session()->get("iso_country")) != 'tr') { ?>
                      <!--                        <li class="toolt"><span class="tooltiptext"><?= trans("front.offers"); ?></span>
                      <a class="offers_btn" href="{{ route('front.stories') }}">
                      <svg width='27' height='33' id="Layer_1" viewBox="0 0 80 80" width="80" height="80"><path fill="currentColor" d="M30.566 78.982c-.222 0-.447-.028-.672-.087C12.587 74.324.5 58.588.5 40.631c0-3.509.459-6.989 1.363-10.343a2.625 2.625 0 0 1 5.068 1.366 34.505 34.505 0 0 0-1.182 8.977c0 15.578 10.48 29.226 25.485 33.188a2.625 2.625 0 0 1-.668 5.163zm19.355-.107C67.336 74.364 79.5 58.611 79.5 40.563c0-3.477-.452-6.933-1.345-10.27a2.624 2.624 0 1 0-5.071 1.356 34.578 34.578 0 0 1 1.166 8.914c0 15.655-10.545 29.319-25.646 33.23a2.625 2.625 0 0 0 1.317 5.082zM15.482 16.5C21.968 9.901 30.628 6.267 39.867 6.267c9.143 0 17.738 3.569 24.202 10.05a2.625 2.625 0 0 0 3.717-3.708C60.329 5.135 50.413 1.018 39.867 1.018c-10.658 0-20.648 4.191-28.128 11.802a2.624 2.624 0 1 0 3.743 3.68z"></path></svg>
                      </a>
                      </li>-->

                      <?php } else { */ ?>


<!--<li class="toolt"><span class="tooltiptext"><?= trans("front.offers"); ?></span>
<a class="offers_btn" href="{{ route('front.offers') }}">
<svg width="30" height="40" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 180 310.4" xml:space="preserve"><style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;fill:#FFFFFF;}</style><g><path class="st0" d="M95.4,49.5l-0.5-0.9c-9.1-15.3-20.5-29-31-37.7C52.5,1.5,41.4-2.4,33.4,1.5C25.7,5.1,22.9,14,24.1,25.1c1.7,15.5,10,33.1,19.4,48L0,98.3v121.4l14.7-8.5V106.7l37.2-21.5L65,100.4c-10,12.7-8.9,30.8,2.5,42.1c20.1,20.1,54.3,5.6,54.3-22.5c0-23.3-24.3-38.6-45.2-28.8L64.7,77.9L90,63.3l75.3,43.5v104.5l14.7,8.5V98.3L95.4,49.5z M102.1,108c6.7,6.7,6.7,17.4,0,24.2c-10.4,10.6-29.2,3.3-29.2-12.1C72.9,104.8,91.4,97.3,102.1,108z M56.2,65.9c-8-12.6-16.1-29.3-17.5-42.3c-0.5-4.8-0.3-8.1,0.9-8.8l0,0c2.5-1.2,8,1.8,14.9,7.5c8.2,6.8,17.3,17.3,25.3,30L56.2,65.9z"/><g><g><rect x="92.3" y="241.3" class="st0" width="15.7" height="15.7"/><rect x="72.1" y="241.3" class="st0" width="15.7" height="15.7"/><rect x="92.3" y="221.1" class="st0" width="15.7" height="15.7"/><rect x="72.1" y="221.1" class="st0" width="15.7" height="15.7"/></g></g><path class="st0" d="M165.3,211.2L90,167.7l-75.3,43.5L0,219.7v90.7h180v-90.7L165.3,211.2z M165.3,295.7H14.7v-67.5L90,184.6l75.3,43.5V295.7z"/></g></svg>
</a>
</li>-->
                    <li class="toolt"><span class="tooltiptext"><?= trans("front.videos"); ?></span>
                        <a class="videos_btn" href="<?= route("front.video") ?>">
                            <svg width='30' height='26' version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 25.8 21.9" xml:space="preserve"><g> <path class="st0" d="M24.5,0H3.6H1.3C0.6,0,0,0.6,0,1.3v15.9c0,0.7,0.6,1.3,1.3,1.3h2.3h6v1.7H4.4c-0.2,0-0.4,0.2-0.4,0.4v0.9 c0,0.2,0.2,0.4,0.4,0.4h2.3h13c2,0,2.2-0.2,2.2-0.4v-0.9c0-0.2-0.2-0.4-0.4-0.4h-5.3v-1.7h8.3c0.7,0,1.3-0.6,1.3-1.3V1.3 C25.8,0.6,25.2,0,24.5,0z M24.2,16.6c0,0.2-0.1,0.3-0.3,0.3H2c-0.2,0-0.3-0.1-0.3-0.3V2c0-0.2,0.1-0.3,0.3-0.3h21.9 c0.2,0,0.3,0.1,0.3,0.3V16.6z"/> <path class="st0" d="M16.2,8.5l-5.6-3.4C10,4.7,9.2,5.2,9.2,5.8v6.9c0,0.7,0.8,1.1,1.3,0.8l5.6-3.4C16.7,9.7,16.7,8.9,16.2,8.5 L16.2,8.5z M16.2,8.5"/> </g> </svg>
                        </a>
                    </li>

                    <!-- add الأسئلة الشائعة -->
                    <?php /* <li class="toolt"><span class="tooltiptext"><?= trans("front.faq"); ?></span>
                      <a class="faq_btn" title="<?= trans("front.faq"); ?>" href="{{ route('front.faq') }}">
                      <svg width='48' height='25' version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 26.3 13.4" style="enable-background:new 0 0 26.3 13.4;" xml:space="preserve"><style type="text/css">.st0{fill:#4D4D4D}</style><rect x="69.6" y="-30.7" class="st0" width="80.9" height="60.4"/> <g> <path d="M2.7,3.1v2.6h4.1V7H2.7v3.2H1.1V1.8h6.1v1.3H2.7z"/> <path d="M13.9,8.3H9.7l-0.8,1.9H7.2L11,1.8h1.5l3.8,8.4h-1.6L13.9,8.3z M13.3,7l-1.6-3.7L10.2,7H13.3z"/> <path d="M26.1,11c-0.6,0.6-1.3,1-2.2,1c-1.1,0-2-0.4-3.2-1.7c-2.4-0.2-4-2-4-4.3c0-2.5,1.9-4.3,4.5-4.3s4.5,1.8,4.5,4.3 c0,2-1.3,3.6-3.1,4.1c0.5,0.5,0.9,0.7,1.4,0.7c0.6,0,1-0.2,1.4-0.7L26.1,11z M21.2,9c1.7,0,3-1.2,3-3c0-1.7-1.3-3-3-3 c-1.7,0-3,1.2-3,3C18.3,7.7,19.5,9,21.2,9z"/> </g> </svg>
                      </a>
                      </li> */ ?>

                    <li class="toolt aboutLink"><span class="tooltiptext"><?= trans("front.about us"); ?></span>
                        <a class="about_btn" href="{{ route('front.aboutus') }}">
                            <svg width='35' height='29' version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 35 28.7" xml:space="preserve"><g> <path class="st0" d="M17.5,18.8c-3,0-6,0-9,0c0,0-0.1,0-0.1,0c-0.3,0-0.5-0.2-0.5-0.5c0-0.2,0-0.4,0-0.5c0-0.3,0-0.6,0.1-0.9 c0-0.1,0-0.3,0.1-0.4c0-0.1,0-0.2,0-0.3c0.1-0.8,0.5-1.4,1.3-1.7c0.5-0.2,1.1-0.3,1.6-0.6c0.6-0.2,1.1-0.6,1.6-0.9 c0.3-0.2,0.6-0.5,0.9-0.7c0.4-0.3,0.6-0.3,0.9,0c0.5,0.4,1,0.7,1.6,0.9c0.5,0.2,1,0.3,1.5,0.2c0.4,0,0.8,0,1.1-0.2 c0.6-0.1,1.1-0.4,1.6-0.7c0.1-0.1,0.3-0.2,0.4-0.3c0.2-0.1,0.3-0.1,0.5,0c0.2,0.1,0.4,0.3,0.6,0.5c0.5,0.4,1,0.7,1.6,1 c0.4,0.2,0.8,0.4,1.3,0.6c0.2,0.1,0.4,0.1,0.6,0.1c0.3,0.1,0.6,0.2,0.8,0.3c0.4,0.2,0.5,0.6,0.7,0.9c0.2,0.5,0.2,1.1,0.2,1.6 c0,0.3,0.1,0.6,0.1,1c0.1,0.3-0.2,0.6-0.6,0.6c-1.5,0-2.9,0-4.4,0C20.5,18.8,19,18.8,17.5,18.8C17.5,18.8,17.5,18.8,17.5,18.8z"/> <path class="st0" d="M17.5,12.1c-0.7,0-1.2-0.2-1.8-0.5c-0.4-0.3-0.8-0.6-1.2-0.9c-0.5-0.6-0.9-1.3-1.2-2c-0.1-0.3-0.2-0.7-0.3-1 c-0.1-0.3-0.1-0.6-0.2-0.9c0-0.1,0-0.1,0-0.2c0-0.5,0-1,0-1.5c0-0.1,0-0.2,0-0.3c0-0.1,0-0.2,0.1-0.4c0-0.1,0-0.2,0.1-0.3 c0-0.2,0.1-0.4,0.2-0.6c0.2-0.6,0.5-1.2,0.9-1.7c0.4-0.6,1-1,1.7-1.3c0.4-0.2,0.7-0.2,1.2-0.3c0.5-0.1,1,0,1.5,0 c0.4,0,0.8,0.2,1.2,0.4c1,0.5,1.6,1.3,2,2.3c0.1,0.3,0.3,0.6,0.3,0.9C22,3.9,22,4.2,22.1,4.5c0,0.1,0,0.2,0,0.2 c0.1,0.5,0.1,1.1,0,1.6c0,0.1,0,0.3,0,0.4c0,0.1,0,0.2-0.1,0.4c0,0.1,0,0.1,0,0.2c0,0.5-0.2,0.9-0.4,1.4c-0.2,0.5-0.4,1-0.7,1.4 c-0.3,0.4-0.6,0.7-1,1.1c-0.4,0.3-0.8,0.6-1.3,0.8C18.2,12.1,17.8,12.2,17.5,12.1z"/> <path class="st0" d="M26.3,12.7c-0.5,0.1-1-0.2-1.5-0.4c-0.5-0.3-1-0.7-1.3-1.1c-0.4-0.5-0.7-1-0.9-1.5c-0.1-0.1,0-0.2,0-0.3 c0.2-0.4,0.3-0.8,0.4-1.3c0.1-0.3,0.1-0.6,0.2-0.9c0.1-0.3,0.1-0.6,0.1-0.9c0-0.6,0-1.2,0-1.8c0-0.1,0-0.2-0.1-0.4 c0-0.1,0-0.2-0.1-0.3c0-0.1,0-0.2,0-0.2C23,3.5,23,3.3,23.1,3.2c0.4-0.5,0.9-0.8,1.4-1.1c0.6-0.3,1.3-0.4,2-0.4 c0.3,0,0.6,0.1,1,0.2c0.3,0.1,0.6,0.2,0.9,0.4c0.2,0.1,0.4,0.3,0.6,0.5c0.6,0.5,1,1.2,1.2,2c0.1,0.2,0.1,0.4,0.2,0.7c0,0,0,0,0,0.1 c0.1,0.7,0.3,1.5,0,2.2c0,0,0,0.1,0,0.1c0,0.4-0.1,0.7-0.2,1.1c-0.1,0.4-0.3,0.8-0.5,1.2c-0.3,0.7-0.8,1.3-1.4,1.8 c-0.4,0.3-0.8,0.5-1.2,0.7C26.8,12.7,26.5,12.7,26.3,12.7z"/> <path class="st0" d="M8.8,12.7c-0.7,0.1-1.2-0.2-1.7-0.5c-0.5-0.3-0.9-0.7-1.2-1.1c-0.3-0.3-0.5-0.7-0.7-1.1C4.9,9.5,4.8,9,4.7,8.5 C4.6,7.9,4.5,7.3,4.5,6.7c0-0.2,0-0.4,0.1-0.6c0-0.2,0-0.4,0.1-0.5c0-0.2,0.1-0.4,0.1-0.7c0.2-0.5,0.3-1,0.7-1.4 C5.9,2.8,6.5,2.3,7.2,2C7.5,1.9,7.7,1.8,8,1.8c0.3-0.1,0.6-0.1,0.9-0.1c0.3,0,0.7,0.1,1,0.2c0.5,0.1,0.9,0.4,1.3,0.7 c0.3,0.2,0.5,0.4,0.7,0.7c0.1,0.1,0,0.2,0,0.3c-0.1,0.4-0.2,0.7-0.2,1.1c0,0.6,0,1.3,0,1.9c0,0.2,0,0.3,0.1,0.5c0,0.1,0,0.1,0,0.2 c0,0.3,0.1,0.6,0.2,0.9c0.1,0.3,0.2,0.5,0.3,0.8c0,0,0,0.1,0,0.1c0.2,0.3,0.1,0.5,0,0.8c-0.3,0.7-0.8,1.4-1.4,1.9 c-0.4,0.3-0.9,0.6-1.4,0.8c-0.1,0-0.2,0.1-0.3,0.1C9.1,12.7,8.9,12.7,8.8,12.7z"/> <path class="st0" d="M27,13.9c0.4-0.1,0.7-0.2,1-0.4c0.4-0.2,0.8-0.4,1.1-0.7c0.2-0.1,0.4-0.1,0.6,0c0.4,0.3,0.8,0.6,1.2,0.9 c0.5,0.3,1,0.6,1.5,0.8c0.3,0.1,0.6,0.3,0.9,0.3c0.2,0,0.4,0.1,0.6,0.2c0.3,0.1,0.5,0.3,0.6,0.6c0.2,0.5,0.3,0.9,0.3,1.4 c0,0.3,0.1,0.6,0.1,0.8c0,0.1,0,0.3,0,0.4c0,0.2-0.2,0.4-0.4,0.5c-0.1,0-0.1,0-0.2,0c-2,0-3.9,0-5.9,0c0,0-0.1,0-0.1,0 c-0.2,0-0.2,0-0.2-0.3c0-0.5,0-0.9,0-1.4c0-0.1,0-0.3-0.1-0.4c0-0.2,0-0.3-0.1-0.5c0-0.1,0-0.2-0.1-0.4c-0.1-0.2-0.1-0.4-0.2-0.6 c-0.1-0.4-0.3-0.7-0.5-1C27.2,14.2,27.1,14,27,13.9z"/> <path class="st0" d="M8,13.8C8,13.9,7.9,14,7.9,14c-0.1,0.2-0.3,0.3-0.4,0.5c-0.4,0.6-0.6,1.2-0.6,1.9c0,0.1,0,0.1,0,0.2 c-0.2,0.6-0.1,1.2-0.1,1.8c0,0.3,0,0.3-0.3,0.3c-2,0-4,0-6,0c-0.3,0-0.5-0.2-0.5-0.5c0.1-0.7,0.2-1.4,0.2-2.1 c0-0.2,0.1-0.3,0.2-0.5c0.2-0.5,0.6-0.7,1-0.9c0.8-0.2,1.5-0.5,2.2-0.9c0.2-0.1,0.3-0.2,0.5-0.3c0.3-0.2,0.5-0.4,0.8-0.6 C5,13,5.1,12.9,5.3,12.8c0.2-0.1,0.4-0.1,0.5,0c0.4,0.3,0.8,0.6,1.3,0.7c0.3,0.1,0.5,0.1,0.8,0.2C7.9,13.8,7.9,13.8,8,13.8z"/> <path class="st0" d="M8.6,24c0.2,0.2,0.3,0.3,0.5,0.5c0.2,0.3,0.4,0.6,0.4,1c0,0.5,0,0.9,0,1.4c0,0.7-0.3,1.2-0.8,1.5 c-0.2,0.1-0.4,0.2-0.6,0.2c-0.8,0.2-1.6,0.1-2.4,0.1c-0.3,0-0.3,0-0.3-0.3c0-2.7,0-5.3,0-8c0-0.3,0-0.3,0.3-0.3c0.6,0,1.1,0,1.7,0 c0.5,0,0.9,0,1.3,0.3c0.3,0.2,0.5,0.5,0.6,0.8c0.2,0.6,0.1,1.1,0.1,1.7C9.3,23.3,9.1,23.8,8.6,24z M6.8,24.8 C6.7,24.8,6.7,24.9,6.8,24.8c-0.1,0.9-0.1,1.6-0.1,2.4c0,0.1,0.1,0.2,0.2,0.2c0.2,0,0.5,0,0.7,0c0.2,0,0.4-0.1,0.5-0.4 c0.1-0.2,0.1-0.3,0.1-0.5c0-0.4,0-0.8-0.1-1.2c0-0.2-0.3-0.5-0.5-0.5C7.3,24.8,7,24.8,6.8,24.8z M6.7,23.5c0.3,0,0.5,0,0.8,0 C7.7,23.5,8,23.2,8,23c0-0.4,0-0.8,0-1.2c0-0.2-0.1-0.3-0.3-0.4c-0.3-0.2-0.6-0.1-0.9-0.1c-0.1,0-0.1,0.1-0.1,0.2 C6.7,22.1,6.7,22.8,6.7,23.5z"/> <path class="st0" d="M10.2,24.3c0-0.9,0-1.7,0-2.6c0-0.7,0.4-1.4,1.1-1.7c0.4-0.1,0.7-0.2,1.1-0.1c0.2,0,0.4,0,0.7,0.1 c0.5,0.2,0.8,0.6,1,1.1c0.1,0.3,0.2,0.5,0.2,0.8c0,1.6,0,3.2,0,4.8c0,0.9-0.4,1.6-1.3,1.9c-0.2,0.1-0.4,0.1-0.6,0.1 c-0.5,0-0.9-0.1-1.3-0.3c-0.4-0.2-0.5-0.6-0.7-0.9c-0.1-0.3-0.1-0.5-0.1-0.8C10.2,25.9,10.2,25.1,10.2,24.3z M11.6,24.3 c0,0.8,0,1.7,0,2.5c0,0.1,0,0.2,0,0.2c0.2,0.3,0.4,0.5,0.7,0.4c0.3-0.1,0.6-0.3,0.6-0.7c0-0.2,0-0.3,0-0.5c0-1.5,0-3,0-4.5 c0-0.4-0.3-0.6-0.6-0.6c-0.3,0-0.6,0.3-0.6,0.6C11.6,22.7,11.6,23.5,11.6,24.3z"/> <path class="st0" d="M27.6,23.6c0,1.1,0,2.1,0,3.2c0,0.3,0.1,0.5,0.4,0.6c0.3,0.2,0.5,0.1,0.7-0.1c0.1-0.1,0.2-0.2,0.2-0.3 c0-0.1,0-0.3,0-0.4c0-2,0-4,0-5.9c0-0.1,0-0.2,0-0.4c0-0.2,0.1-0.2,0.2-0.2c0.3,0,0.6,0,0.9,0c0.1,0,0.2,0.1,0.2,0.2 c0,0.1,0,0.2,0,0.3c0,2,0,3.9,0,5.9c0,0.4-0.1,0.9-0.2,1.3c-0.2,0.5-0.6,0.9-1.1,1c-0.3,0.1-0.7,0.1-1.1,0.1 c-0.3-0.1-0.5-0.1-0.7-0.2c-0.5-0.3-0.7-0.7-0.8-1.2c-0.1-0.3-0.1-0.6-0.1-0.9c0-2,0-4,0-6c0-0.1,0-0.1,0-0.2 c0-0.1,0.1-0.2,0.2-0.2c0.3,0,0.7,0,1,0c0.1,0,0.2,0.1,0.2,0.2c0,0.1,0,0.2,0,0.3C27.6,21.5,27.6,22.5,27.6,23.6z"/> <path class="st0" d="M1.6,27.1c-0.1,0.5-0.2,1-0.3,1.5c-0.1,0-0.1,0-0.1,0c-0.3,0-0.6,0-0.9,0c-0.2,0-0.3-0.1-0.2-0.3 c0,0,0-0.1,0-0.1c0-0.3,0.1-0.7,0.1-1c0,0,0,0,0-0.1c0.1-0.3,0.1-0.6,0.2-0.9c0-0.2,0.1-0.3,0.1-0.5c0-0.1,0-0.2,0.1-0.3 c0,0,0-0.1,0-0.1c0-0.3,0.1-0.7,0.1-1c0.1-0.4,0.1-0.7,0.2-1.1c0-0.1,0-0.2,0-0.3C1,22.7,1,22.6,1,22.4c0,0,0,0,0-0.1 c0-0.4,0.1-0.7,0.1-1.1c0.1-0.4,0.1-0.7,0.2-1.1c0-0.1,0-0.1,0.1-0.2c0.3,0,0.5,0,0.8,0c0.3,0,0.6,0,1,0c0.1,0,0.2,0,0.2,0.2 c0,0.3,0.1,0.5,0.1,0.8c0.1,0.4,0.1,0.7,0.2,1.1c0,0.1,0,0.2,0,0.3c0,0.1,0,0.2,0.1,0.3c0,0.1,0,0.3,0.1,0.4c0,0.1,0,0.2,0,0.3 c0,0.2,0.1,0.3,0.1,0.5c0.1,0.4,0.1,0.7,0.2,1.1c0,0.1,0,0.2,0,0.3c0,0.1,0,0.3,0.1,0.4c0,0,0,0.1,0,0.1c0,0.3,0.1,0.7,0.1,1 c0,0,0,0,0,0.1c0.1,0.3,0.1,0.7,0.2,1c0,0.2,0.1,0.4,0.1,0.7c0,0.1-0.1,0.2-0.2,0.2c-0.3,0-0.7,0-1,0c-0.1,0-0.1-0.1-0.2-0.1 c0-0.1-0.1-0.1-0.1-0.2c-0.1-0.3-0.1-0.7-0.1-1c0-0.2,0-0.2-0.2-0.2C2.5,27.1,2,27.1,1.6,27.1z M2.9,25.8c0-0.1,0-0.2,0-0.3 c-0.1-0.2-0.1-0.5-0.1-0.7c-0.1-0.3-0.1-0.6-0.1-0.9c0,0,0-0.1,0-0.1c0-0.2-0.1-0.3-0.1-0.5c0-0.1,0-0.2,0-0.2 c0-0.2-0.1-0.3-0.1-0.5c0-0.2-0.1-0.4-0.2-0.6c0,0.4-0.1,0.7-0.1,1.1C2,23.4,2,23.8,2,24.2c0,0,0,0.1,0,0.1c0,0.2-0.1,0.3-0.1,0.5 c0,0.1,0,0.2,0,0.3c-0.1,0.3-0.1,0.5-0.1,0.8C2.1,25.8,2.5,25.8,2.9,25.8z"/> <path class="st0" d="M17.8,20c0.4,0,0.8,0,1.1,0c0.1,0,0.1,0.1,0.1,0.2c0,0.2,0,0.3,0,0.5c0,2,0,4,0,6c0,0.5-0.2,1-0.5,1.4 c-0.1,0.2-0.4,0.3-0.6,0.4c-0.4,0.2-0.9,0.2-1.3,0.2c-0.2,0-0.3-0.1-0.5-0.1c-0.3-0.1-0.6-0.3-0.8-0.6c-0.2-0.2-0.3-0.5-0.3-0.9 c0-2.2,0-4.5,0-6.7c0-0.4-0.1-0.4,0.4-0.4c0.2,0,0.5,0,0.7,0c0.2,0,0.2,0,0.2,0.2c0,0,0,0.1,0,0.1c0,2,0,3.9,0,5.9 c0,0.3,0,0.5,0.1,0.8c0.1,0.3,0.5,0.5,0.8,0.4c0.4-0.1,0.5-0.3,0.5-0.8c0-0.7,0-1.5,0-2.3c0-1.4,0-2.7,0-4.1 C17.8,20.2,17.8,20.2,17.8,20z"/> <path class="st0" d="M34.3,22.4c-0.1,0-0.3,0-0.4,0c-0.2,0-0.2,0-0.2-0.2c0-0.2,0-0.4-0.1-0.6c-0.1-0.3-0.5-0.5-0.8-0.4 c-0.4,0.1-0.5,0.5-0.4,1c0.1,0.6,0.5,1.1,0.9,1.5c0.1,0.1,0.2,0.2,0.3,0.3c0.6,0.5,1,1,1.2,1.7c0.2,0.5,0.2,1,0.1,1.5 c-0.1,0.3-0.2,0.7-0.4,0.9c-0.3,0.4-0.7,0.6-1.2,0.6c-0.3,0-0.6,0-1,0c-0.1,0-0.1,0-0.2,0c-0.6-0.2-1-0.6-1.2-1.2 c-0.1-0.4-0.2-0.8-0.1-1.3c0-0.1,0.1-0.2,0.2-0.2c0.3,0,0.6,0,0.8,0c0.2,0,0.3,0.1,0.3,0.3c0,0.2,0,0.5,0,0.7 c0,0.3,0.3,0.6,0.7,0.5c0.4-0.1,0.6-0.3,0.6-0.7c0-0.6-0.2-1-0.6-1.4c-0.4-0.5-0.9-0.9-1.3-1.4c-0.3-0.3-0.4-0.6-0.5-1 c-0.2-0.5-0.2-1.1-0.1-1.6c0.1-0.6,0.4-1.1,1-1.3c0.3-0.1,0.7-0.2,1.1-0.1c0.2,0,0.4,0,0.7,0.1c0.4,0.2,0.7,0.5,0.9,0.8 c0.2,0.4,0.3,0.8,0.3,1.2c0,0.2-0.1,0.2-0.2,0.2C34.6,22.4,34.4,22.4,34.3,22.4C34.3,22.4,34.3,22.4,34.3,22.4z"/> <path class="st0" d="M21,21.3c-0.5,0-0.9,0-1.4,0c0-0.4,0-0.7,0-1.1c0-0.1,0.1-0.2,0.2-0.2c0.1,0,0.1,0,0.2,0c1.2,0,2.4,0,3.5,0 c0.2,0,0.3,0,0.3,0.3c0,0.3,0,0.6,0,1c-0.5,0-0.9,0-1.4,0c0,0.1,0,0.2,0,0.3c0,2.2,0,4.4,0,6.6c0,0.5,0,0.5-0.5,0.5 c-0.2,0-0.4,0-0.6,0c-0.3,0-0.4,0-0.4-0.3c0-1.2,0-2.4,0-3.6c0-1,0-2.1,0-3.1C21,21.5,21,21.4,21,21.3z"/> </g> </svg>
                        </a>
                    </li> 

                    <?php //} ?>

                    <li class="toolt"><span class="tooltiptext"><?= trans("front.blog"); ?></span>
                        <a class="blog_btn" href="<?= route("front.blog.index") ?>">
                            <svg width='30' height='32' version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 24.3 26.5" xml:space="preserve"><g> <path class="st0" d="M12.1,21.8c-0.7,0-1.5,0-2.2,0c-0.7,0-1.1-0.4-1.1-1c0-0.2,0-0.4,0-0.6c0.1-1-0.3-1.8-0.9-2.6 c-0.4-0.4-0.7-0.9-1.1-1.3c-0.7-0.8-1.2-1.6-1.4-2.6c-1.1-3.9,1.4-7.8,5.5-8.5c3.9-0.7,7.5,1.7,8.3,5.4c0.2,0.9,0.1,1.8,0,2.7 c-0.2,1.2-0.9,2.3-1.7,3.2C16.9,17,16.5,17.5,16,18c-0.4,0.6-0.6,1.2-0.6,1.9c0,0.3,0,0.6,0,0.8c0,0.6-0.4,1-1.1,1 C13.6,21.8,12.9,21.8,12.1,21.8z M13.4,19.9c0-0.2,0-0.3,0-0.4c0-0.7,0.2-1.3,0.6-1.9c0.5-0.8,1.2-1.5,1.7-2.2 c0.4-0.5,0.7-0.9,1-1.4c0.4-0.8,0.5-1.7,0.4-2.6C16.9,8.9,14.8,7,12.4,7c-2.2-0.1-4,1-4.9,2.9c-0.9,1.9-0.5,3.7,0.9,5.3 c0.4,0.5,0.8,0.9,1.2,1.4c0.7,0.9,1.3,2,1.2,3.2c0,0,0,0.1,0,0.1C11.7,19.9,12.5,19.9,13.4,19.9z"/> <path class="st0" d="M12.2,23.8c0.7,0,1.4,0,2.1,0c0.4,0,0.7,0.2,0.7,0.6c0,0.3-0.3,0.6-0.7,0.6c-1.4,0-2.8,0-4.3,0 c-0.4,0-0.7-0.2-0.7-0.6c0-0.3,0.3-0.6,0.7-0.6C10.7,23.8,11.4,23.8,12.2,23.8z"/> <path class="st0" d="M12.1,23.4c-0.7,0-1.4,0-2.1,0c-0.4,0-0.7-0.2-0.7-0.6c0-0.4,0.3-0.6,0.7-0.6c1.4,0,2.8,0,4.2,0 c0.4,0,0.7,0.2,0.7,0.6c0,0.4-0.3,0.6-0.7,0.6C13.5,23.4,12.8,23.4,12.1,23.4z"/> <path class="st0" d="M12.8,1.9c0,0.4,0,0.8,0,1.1c0,0.4-0.3,0.7-0.7,0.7c-0.4,0-0.7-0.3-0.7-0.7c0-0.8,0-1.5,0-2.3 c0-0.4,0.3-0.7,0.7-0.7c0.4,0,0.7,0.3,0.7,0.7c0,0,0,0,0,0C12.8,1.1,12.8,1.5,12.8,1.9z"/> <path class="st0" d="M18.4,6.2c-0.4,0-0.6-0.1-0.7-0.4c-0.1-0.3-0.1-0.5,0.1-0.7c0.6-0.6,1.2-1.2,1.8-1.7c0.3-0.3,0.7-0.2,1,0 c0.3,0.3,0.3,0.7,0,0.9C20,4.9,19.4,5.4,18.8,6C18.7,6.1,18.5,6.1,18.4,6.2z"/> <path class="st0" d="M5.8,6.2C5.7,6.1,5.5,6.1,5.4,6C4.8,5.4,4.3,4.9,3.7,4.3c-0.3-0.3-0.3-0.7,0-1c0.3-0.3,0.7-0.3,1,0 C5.3,3.9,5.9,4.5,6.4,5c0.2,0.2,0.3,0.5,0.2,0.8C6.4,6,6.2,6.2,5.8,6.2z"/> <path class="st0" d="M21.5,19.6c0,0.3-0.1,0.6-0.4,0.7c-0.3,0.1-0.5,0.1-0.8-0.1c-0.6-0.6-1.2-1.2-1.8-1.8 c-0.2-0.2-0.2-0.7,0.1-0.9c0.3-0.2,0.7-0.3,0.9,0c0.6,0.6,1.3,1.2,1.9,1.8C21.4,19.4,21.4,19.5,21.5,19.6z"/> <path class="st0" d="M22.3,12.3c-0.4,0-0.8,0-1.2,0c-0.4,0-0.7-0.3-0.7-0.6c0-0.4,0.3-0.7,0.6-0.7c0.9,0,1.7,0,2.6,0 c0.4,0,0.6,0.3,0.6,0.7c0,0.4-0.3,0.7-0.7,0.7C23.2,12.3,22.8,12.3,22.3,12.3z"/> <path class="st0" d="M1.5,12.3c-0.3,0-0.5,0-0.8,0c-0.4,0-0.7-0.2-0.8-0.6C0,11.3,0.3,11,0.7,11c0.2,0,0.4,0,0.6,0 c0.6,0,1.2,0,1.8,0c0.5,0,0.8,0.3,0.8,0.7c0,0.4-0.3,0.7-0.8,0.7C2.6,12.3,2,12.3,1.5,12.3C1.5,12.3,1.5,12.3,1.5,12.3z"/> <path class="st0" d="M3.6,20.1c-0.4,0-0.6-0.1-0.7-0.4C2.8,19.5,2.8,19.2,3,19c0.6-0.6,1.2-1.2,1.9-1.8C5.1,17,5.6,17,5.8,17.3 c0.2,0.2,0.3,0.6,0.1,0.9c-0.6,0.6-1.2,1.2-1.9,1.8C3.9,20,3.7,20.1,3.6,20.1z"/> <path class="st0" d="M12.1,25.4c0.3,0,0.5,0,0.8,0c0.4,0,0.6,0.3,0.6,0.6c0,0.3-0.3,0.6-0.6,0.6c-0.5,0-1,0-1.5,0 c-0.4,0-0.6-0.3-0.6-0.6c0-0.3,0.3-0.6,0.6-0.6C11.6,25.4,11.9,25.4,12.1,25.4z"/> </g> </svg>
                        </a>
                    </li>

                    <!--<li class="toolt news_header_link"><span class="tooltiptext"><?= trans("front.news"); ?></span>-->
                    <!--    <a class="news_btn" href="<?= route("front.news") ?>">-->
                    <!--        <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 371.9" xml:space="preserve"><g><g><g><path d="M62,199.4h107.8c10.4,0,18.9-8.5,18.9-18.9V72.8c0-10.4-8.5-18.9-18.9-18.9H62c-10.4,0-18.9,8.5-18.9,18.9v107.8C43.1,190.9,51.6,199.4,62,199.4z M59.3,72.8c0-1.5,1.2-2.7,2.7-2.7h107.8c1.5,0,2.7,1.2,2.7,2.7v107.8c0,1.5-1.2,2.7-2.7,2.7H62c-1.5,0-2.7-1.2-2.7-2.7V72.8z"/><path d="M296.4,277.6c0-4.5-3.6-8.1-8.1-8.1H51.2c-4.5,0-8.1,3.6-8.1,8.1s3.6,8.1,8.1,8.1h237.1C292.8,285.6,296.4,282,296.4,277.6z"/><path d="M506.1,119.8c-5.6-7.6-14.3-12-23.8-12h-43.1c-4.5,0-8.1,3.6-8.1,8.1s3.6,8.1,8.1,8.1h43.1c4.3,0,8.3,2,10.8,5.5s3.3,7.8,2.1,11.9l-62.3,204.8c-1.7,5.7-6.9,9.5-12.9,9.5h-5v-159c0-4.5-3.6-8.1-8.1-8.1c-4.5,0-8.1,3.6-8.1,8.1v159H29.6c-7.4,0-13.5-6-13.5-13.5V29.6c0-7.4,6-13.5,13.5-13.5h355.7c7.4,0,13.5,6,13.5,13.5v134.7c0,4.5,3.6,8.1,8.1,8.1s8.1-3.6,8.1-8.1V29.6C415,13.3,401.7,0,385.3,0H29.6C13.3,0,0,13.3,0,29.6v312.6c0,16.3,13.3,29.6,29.6,29.6H420c13.1,0,24.5-8.4,28.4-21l62.3-204.8C513.5,137,511.8,127.4,506.1,119.8z"/><path d="M137.4,328.8h226.4c4.5,0,8.1-3.6,8.1-8.1s-3.6-8.1-8.1-8.1H137.4c-4.5,0-8.1,3.6-8.1,8.1C129.3,325.1,133,328.8,137.4,328.8z"/><path d="M51.2,312.6c-4.5,0-8.1,3.6-8.1,8.1s3.6,8.1,8.1,8.1h53.9c4.5,0,8.1-3.6,8.1-8.1c0-4.5-3.6-8.1-8.1-8.1L51.2,312.6L51.2,312.6z"/><path d="M51.2,242.5H159c4.5,0,8.1-3.6,8.1-8.1c0-4.5-3.6-8.1-8.1-8.1H51.2c-4.5,0-8.1,3.6-8.1,8.1C43.1,238.9,46.7,242.5,51.2,242.5z"/><path d="M363.8,140.1H223.7c-4.5,0-8.1,3.6-8.1,8.1c0,4.5,3.6,8.1,8.1,8.1h140.1c4.5,0,8.1-3.6,8.1-8.1C371.9,143.7,368.2,140.1,363.8,140.1z"/><path d="M363.8,97H223.7c-4.5,0-8.1,3.6-8.1,8.1s3.6,8.1,8.1,8.1h140.1c4.5,0,8.1-3.6,8.1-8.1S368.2,97,363.8,97z"/><path d="M363.8,53.9H223.7c-4.5,0-8.1,3.6-8.1,8.1c0,4.5,3.6,8.1,8.1,8.1h140.1c4.5,0,8.1-3.6,8.1-8.1S368.2,53.9,363.8,53.9z"/><path d="M363.8,183.2H223.7c-4.5,0-8.1,3.6-8.1,8.1c0,4.5,3.6,8.1,8.1,8.1h140.1c4.5,0,8.1-3.6,8.1-8.1C371.9,186.9,368.2,183.2,363.8,183.2z"/><path d="M363.8,269.5h-43.1c-4.5,0-8.1,3.6-8.1,8.1s3.6,8.1,8.1,8.1h43.1c4.5,0,8.1-3.6,8.1-8.1C371.9,273.1,368.2,269.5,363.8,269.5z"/><path d="M363.8,226.4H191.3c-4.5,0-8.1,3.6-8.1,8.1s3.6,8.1,8.1,8.1h172.5c4.5,0,8.1-3.6,8.1-8.1C371.9,230,368.2,226.4,363.8,226.4z"/></g></g></g></svg>-->
                    <!--    </a>-->
                    <!--</li>-->

                    <?php /*<li class="toolt header_link_360"><span class="tooltiptext"><?= trans("front.virtualRoaming"); ?></span>
                        <a class="btn_360" href="<?= route("front.view_360") ?>">
                            <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 30.6 19.5" style="enable-background:new 0 0 30.6 19.5;" xml:space="preserve"><style type="text/css">.st0{fill:#FFFFFF;}</style><g><path class="st0" d="M10.4,9.9c0-1.4-1-2.3-2.2-2.5l0,0C9.4,7,10,6.1,10,5.1c0-1.2-0.9-2.3-2.8-2.3c-1,0-2,0.4-2.5,0.7l0.3,1c0.5-0.3,1.2-0.6,2-0.6c1.2,0,1.7,0.7,1.7,1.5C8.7,6.5,7.5,7,6.6,7H5.8v1h0.7C7.8,8,9,8.5,9.1,9.9c0,0.8-0.5,1.9-2.2,1.9c-0.9,0-1.8-0.4-2.1-0.6l-0.4,1c0.5,0.3,1.4,0.7,2.5,0.7C9.2,12.8,10.4,11.5,10.4,9.9z"/><path class="st0" d="M15.3,12.8c2,0,3.2-1.6,3.2-3.4c0-1.9-1.2-3.1-2.9-3.1c-1.1,0-1.9,0.5-2.3,1.1l0,0c0.2-1.6,1.3-3.1,3.4-3.4c0.4-0.1,0.7-0.1,1-0.1V2.8c-0.2,0-0.6,0-1,0.1c-1.2,0.1-2.3,0.6-3.1,1.4c-1,1-1.6,2.5-1.6,4.4C11.9,11.2,13.2,12.8,15.3,12.8z M13.3,8.5c0.4-0.7,1.1-1.2,1.9-1.2c1.2,0,2,0.8,2,2.2s-0.8,2.3-1.9,2.3c-1.4,0-2.1-1.2-2.1-2.8C13.2,8.8,13.2,8.6,13.3,8.5z"/><path class="st0" d="M22.8,12.8c2.1,0,3.4-1.8,3.4-5.1c0-3.1-1.2-4.9-3.2-4.9s-3.4,1.8-3.4,5C19.6,11.1,20.9,12.8,22.8,12.8z M22.9,3.8c1.4,0,2,1.6,2,3.9c0,2.5-0.6,4-2,4c-1.2,0-2-1.4-2-3.9C20.9,5.2,21.7,3.8,22.9,3.8z"/><path class="st0" d="M27.5,3.2c0.9,0,1.6-0.7,1.6-1.6S28.4,0,27.5,0C26.7,0,26,0.7,26,1.6S26.7,3.2,27.5,3.2z M27.5,0.6c0.5,0,1,0.4,1,1c0,0.5-0.4,1-1,1c-0.5,0-1-0.4-1-1C26.6,1.1,27,0.6,27.5,0.6z"/><path class="st0" d="M30.6,12.9L30.6,12.9c0-0.1,0-0.1,0-0.1v-0.1v-0.1c0-0.1,0-0.1-0.1-0.2c0-0.1-0.1-0.3-0.2-0.4c-0.1-0.1-0.2-0.2-0.2-0.3l0,0l0,0L30,11.5l-0.1-0.1c-0.2-0.2-0.4-0.3-0.6-0.4c-0.4-0.2-0.8-0.4-1.2-0.6c-0.2-0.1-0.4-0.1-0.6-0.2c-0.1,0-0.1,0-0.2,0s-0.1,0-0.2,0s-0.2,0-0.3-0.1c0.1,0.1,0.2,0.1,0.3,0.2l0.1,0.1l0.1,0.1c0.2,0.1,0.4,0.2,0.5,0.4c0.3,0.2,0.7,0.5,1,0.8c0.1,0.1,0.3,0.3,0.4,0.4c0,0,0,0.1,0.1,0.1v0.1l0,0l0,0c0,0.1,0.1,0.2,0.1,0.2c0,0.1,0,0.1,0,0.2v0.1l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0v0.1l0,0l0,0c-0.1,0.1-0.2,0.2-0.3,0.3c-0.1,0.1-0.3,0.2-0.4,0.3c-0.2,0.1-0.3,0.2-0.5,0.3S27.9,14,27.7,14c-0.2,0.1-0.4,0.1-0.6,0.2H27h-0.1h-0.1c-0.1,0-0.2,0.1-0.3,0.1c-0.2,0.1-0.4,0.1-0.6,0.2c-0.1,0-0.2,0-0.3,0.1h-0.1h-0.1c-0.4,0.1-0.8,0.2-1.2,0.2l-0.3,0.1h-0.2h-0.2c-0.2,0-0.4,0.1-0.6,0.1c-0.4,0.1-0.8,0.1-1.2,0.2c-0.2,0-0.4,0-0.6,0.1c-0.2,0-0.4,0-0.6,0.1c-1.5,0.1-2.5,0.2-4,0.2l2,1.3l-2.1,1.4c1.7,0,2.7-0.1,4.4-0.4c0.2,0,0.4-0.1,0.7-0.1c0.2,0,0.4-0.1,0.7-0.1c0.4-0.1,0.9-0.2,1.3-0.3c0.9-0.2,1.7-0.4,2.6-0.7c0.4-0.2,0.9-0.3,1.3-0.5c0.1,0,0.2-0.1,0.3-0.1l0.2-0.1H28h0.1c0.2-0.1,0.4-0.2,0.6-0.3c0.1-0.1,0.2-0.1,0.3-0.2l0.1-0.1l0.1-0.1c0.2-0.1,0.4-0.3,0.6-0.5s0.4-0.4,0.5-0.6c0.2-0.2,0.3-0.5,0.4-0.7v-0.1v-0.1c0-0.1,0-0.2,0-0.2L30.6,12.9L30.6,12.9L30.6,12.9L30.6,12.9C30.6,13,30.6,12.9,30.6,12.9z"/><path class="st0" d="M14.5,15.9l-0.3-0.2L13,14.9v1c-0.1,0-0.2,0-0.2,0c-0.8,0-1.7-0.1-2.5-0.2c-0.4,0-0.8-0.1-1.2-0.1s-0.8-0.1-1.2-0.2H7.6c-0.1,0-0.2,0-0.3,0H7.1H6.9l-0.3-0.1c-0.4-0.1-0.8-0.2-1.2-0.2C5,15,4.6,14.9,4.2,14.8c-0.1,0-0.2-0.1-0.3-0.1H3.8H3.7H3.6c-0.2-0.1-0.4-0.1-0.6-0.2c-0.2-0.1-0.4-0.2-0.5-0.2C2.3,14.2,2.2,14.1,2,14c-0.3-0.2-0.6-0.4-0.7-0.6l0,0l0,0v-0.1l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0l0,0v-0.1c0-0.1,0-0.1,0-0.2c0-0.1,0.1-0.1,0.1-0.2l0,0l0,0v-0.1c0,0,0-0.1,0.1-0.1c0.1-0.2,0.2-0.3,0.4-0.4c0.3-0.3,0.6-0.5,1-0.8c0.2-0.1,0.4-0.2,0.5-0.4l0.1-0.1l0.1-0.1c0.1-0.1,0.2-0.1,0.3-0.2c-0.1,0-0.2,0-0.3,0.1c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0-0.2,0c-0.2,0.1-0.4,0.1-0.6,0.2c-0.4,0.1-0.8,0.3-1.2,0.6C1.2,11,1,11.2,0.8,11.3l-0.1,0.1c0,0,0,0-0.1,0.1l0,0l0,0c-0.1,0.1-0.2,0.2-0.2,0.3c-0.1,0.1-0.1,0.3-0.2,0.4c0,0.1,0,0.1-0.1,0.2v0.1v0.1c0,0,0,0,0,0.1v0.1v0.1V13l0,0l0,0v0.1c0,0.1,0,0.2,0,0.2v0.1v0.1c0.1,0.3,0.3,0.5,0.4,0.7c0.2,0.2,0.3,0.4,0.5,0.6c0.2,0.2,0.4,0.3,0.6,0.5l0.1,0.1L2,15.7c0.1,0.1,0.2,0.1,0.3,0.2c0.2,0.1,0.4,0.2,0.6,0.3H3h0.1l0.2,0.1c0.1,0,0.2,0.1,0.3,0.1c0.4,0.2,0.8,0.4,1.3,0.5c0.9,0.3,1.7,0.5,2.6,0.7C7.8,17.9,8.3,18,8.7,18c0.4,0.1,0.9,0.2,1.3,0.2c1,0.1,2,0.2,3,0.3v1l1.2-0.8l0.2-0.1l2.1-1.4L14.5,15.9z"/></g></svg>
                        </a>
                    </li>*/ ?>



                    <li class="dropdown search_sec <?php if ($hide_whatsapp != false) { echo 'hide_whatsapp'; } ?>">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg width='25' height='25' version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 19 18.6" xml:space="preserve"><path class="st0" d="M18.7,17l-5.1-5c1-1.3,1.6-2.8,1.6-4.6c0-4.1-3.4-7.4-7.6-7.4C3.4,0,0,3.3,0,7.4c0,4.1,3.4,7.4,7.6,7.4 c1.8,0,3.4-0.6,4.7-1.6l5.1,5c0.2,0.2,0.4,0.3,0.7,0.3c0.2,0,0.5-0.1,0.7-0.3C19.1,17.9,19.1,17.3,18.7,17z M1.9,7.4 c0-3.1,2.6-5.6,5.7-5.6c3.1,0,5.7,2.5,5.7,5.6c0,1.5-0.6,2.9-1.7,3.9c0,0,0,0,0,0c0,0,0,0,0,0c-1,1-2.5,1.6-4,1.6 C4.5,13,1.9,10.5,1.9,7.4z"/> </svg>
                        </button>
                        <div class="dropdown-menu search_menu" aria-labelledby="dropdownMenuButton">

                            <span class="close_search_menu"><svg width="30" height="30" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 58.48 58.48" xml:space="preserve"><path class="st0" d="M57.39,1.09c-1.45-1.45-3.8-1.45-5.25,0l-22.9,22.9L6.34,1.09c-1.45-1.45-3.8-1.45-5.25,0 c-1.45,1.45-1.45,3.8,0,5.25l22.9,22.9l-22.9,22.9c-1.45,1.45-1.45,3.8,0,5.25c0.73,0.73,1.68,1.09,2.63,1.09s1.9-0.36,2.63-1.09 l22.9-22.9l22.9,22.9c0.73,0.73,1.68,1.09,2.63,1.09c0.95,0,1.9-0.36,2.63-1.09c1.45-1.45,1.45-3.8,0-5.25l-22.9-22.9l22.9-22.9 C58.84,4.89,58.84,2.54,57.39,1.09z"></path> </svg></span>

                            <div class="content_search">
                                <div class="title jazzira_font">
                                    <p class="jazzira_font_bold"><?= trans("front.search title one"); ?></p>
                                </div>

                                <div class="search_form">
                                    <form action="<?= route("front.searchpage"); ?>">
                                        <svg class="search_icon" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 26.15 22.4" xml:space="preserve"><path class="st0" d="M24.72,20.5l-6.2-6c1.2-1.5,1.9-3.4,1.9-5.5c0-4.9-4.1-9-9.2-9s-9.2,4-9.2,9c0,4.9,4.1,9,9.2,9 c2.1,0,4.1-0.7,5.6-1.9l6.2,6c0.2,0.2,0.5,0.3,0.8,0.3s0.6-0.1,0.8-0.3C25.22,21.6,25.22,20.9,24.72,20.5z M4.42,8.9 c0-3.7,3.1-6.7,6.9-6.7s6.9,3,6.9,6.7c0,1.8-0.8,3.5-2,4.7l0,0l0,0c-1.2,1.2-3,2-4.8,2C7.52,15.7,4.42,12.7,4.42,8.9z"></path> </svg>
                                        <input id="inputSearch" class="bluring" type="text" name="s" required  autocomplete="off" placeholder="<?= trans("front.search title two"); ?>" />
                                        <button class="srhbtn">
                                            <svg width="20" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 19.59 18.63" style="enable-background:new 0 0 19.59 18.63;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><g> <path class="st0" d="M2.1,9.28C2.78,9.25,3.45,9.2,4.13,9.17c3.12-0.17,6.25-0.35,9.37-0.52c0.99-0.06,1.98-0.11,2.97-0.16 c0.28-0.01,0.3-0.14,0.41-0.9c0.3-2.19,1.04-4.3,2.19-6.19c0.49-0.8,0.65-0.98,0.4-1.15c-0.44-0.31-0.92-0.31-1.39-0.11 c-1.56,0.67-3.13,1.34-4.68,2.03C9.97,3.69,6.54,5.22,3.24,7C2.35,7.47,1.51,8.03,0.66,8.57c-0.2,0.12-0.36,0.3-0.52,0.47 c-0.18,0.18-0.18,0.38-0.01,0.55c0.18,0.18,0.35,0.38,0.56,0.5c1.16,0.7,2.31,1.43,3.51,2.04c4.52,2.33,9.18,4.35,13.85,6.35 c0.47,0.2,0.94,0.21,1.39-0.08c0.13-0.09,0.18-0.17,0.12-0.34c-0.96-2.63-1.92-5.27-2.88-7.91c-2.6-0.14-5.2-0.28-7.8-0.43 c-2.2-0.12-4.41-0.24-6.61-0.37c-0.06,0-0.11-0.02-0.17-0.02C2.1,9.32,2.1,9.3,2.1,9.28z"></path> </g> </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <?php /* <!--
                              <!--                            <div class="sub_content cities_sec">
                              <h5><?= trans("front.Featured cities"); ?></h5>
                              <ul>
                              <?php foreach ($citys as $c) { ?>
                              <li><svg viewBox="0 0 16 16" id="716c97c892960f70e563c5c120c381e3" ><path fill-rule="evenodd" data-name="location pin copy 5" d="M12.537 11.325h.009l-4.59 4.67-4.82-4.91a6.263 6.263 0 01-1.7-4.755A6.811 6.811 0 018.092.003c3.764.013 6.339 3.707 6.337 6.377a6.842 6.842 0 01-1.892 4.945zm-1.63-1.646l-2.97 3.022-3.113-3.17a4.044 4.044 0 01-1.1-3.072 4.414 4.414 0 014.307-4.095 4.36 4.36 0 014.092 4.118 4.432 4.432 0 01-1.216 3.197zM9.059 8.015L8.004 9.183l-1.112-1.23a1.651 1.651 0 01-.393-1.19 1.5 1.5 0 112.992.015 1.788 1.788 0 01-.432 1.241z"></path></svg><a href="<?= route("front.search") . "/property-for-sale/" . $c->getSlug() ?>"><?= $c->getName() ?></a></li>
                              <?php } ?>
                              </ul>
                              </div>
                              <div class="sub_content features_sec">
                              <h5><?= trans("front.Special features"); ?></h5>
                              <ul class="features">
                              <?php
                              foreach ($tags as $t) {
                              ?>
                              <li><a href="<?= route("front.search") . "/property-for-sale/turkey/" . $t->getSlug() ?>">{{ $t->getName() }}</a></li>
                              <?php } ?>
                              </ul>
                              </div>--> */ ?>
                        </div>
                    </li>









                </ul>
            </div>



        </header>
        <!-- End Header -->


        @yield('main_content')





        <!-- Start Footer -->

        <footer id="footer">
            <ul class="list">
                <li class="animate__animated">
                    <p class="jazzira_font_bold footer_title"><?= trans("front.keep in touch"); ?></p>
                    <!--<div class="int_sec">-->
                        <!--<strong><?= trans("front.address"); ?></strong>-->
                    <!--    <a class="englishFont" target="_blank" rel="noopener nofollow" href="https://goo.gl/maps/W4B2D3ii3utMFsUk7">-->
                    <!--        <span class="fn">-->
                    <!--            damasturk Real Estate-->
                    <!--        </span>-->
                    <!--        <span class="adr">-->
                    <!--            <span class="street-address">Yeşilköy Mah. Atatürk Cad. (Istanbul World Trade Center) NO: A2/205 </span>-->
                    <!--            <span class="locality">Bakırköy/</span>-->
                    <!--            <span class="region">Istanbul</span>-->
                    <!--        </span>-->
                    <!--    </a>-->
                    <!--</div>-->
                    <!--<div class="int_sec">-->
                    <!--    <strong><?= trans("front.phone"); ?>:</strong>-->
                    <!--    <span class="telephone"><a class="num" href="tel:<?= str_replace(' ', '', $infos->tel_1) ?>"><?= $infos->tel_1 ?></a></span>-->
                    <!--</div>-->
                    <!--<div class="int_sec">-->
                    <!--    <strong><?= trans("front.email"); ?>:</strong>-->
                    <!--    <span class="email"><a class="email num" href="mailto:leads@damas.net">leads@damas.net</a></span>-->
                    <!--</div>-->



                    <?php /*<div class="complaints_btn" title="complaints">
                        <p class="jazzira_font_bold"><?= trans("front.quick menu link 18"); ?></p>
                        <a title="Hotline Call" href="tel:00905451605000">
                            <span class="num">+90 545 160 5000</span>
                        </a>
                        <?php if ($hide_whatsapp == false) { ?>
                            <a title="Complaints Whatsapp" href="https://api.whatsapp.com/send?phone=905451605000&text=">
                                <img loading="lazy" width="60" height="60" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="complaints-icon"/>
                            </a>
                        <?php } ?>
                    </div>*/ ?>

                    <div class="socialicon animate__animated">
                        <a class="youtube" href="<?= $infos->youtube; ?>" rel="noopener nofollow" target="_blank"><i class="fa fa-youtube-play"></i></a>
                        <a class="instagram" href="<?= $infos->instagram; ?>" rel="noopener nofollow" target="_blank"><i class="fa fa-instagram"></i></a>
                        


                        <a class="twitter" href="<?= $infos->twitter; ?>" rel="noopener nofollow" target="_blank" title="damasturk twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" 
                            fill="#fff"
                            width="29px"
                            height="29px"
                            style="margin-bottom:-6px">
                            <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z">
                            </path></svg>
                        </a>

                        
                        <a class="facebook" href="<?= $infos->facebook; ?>" rel="noopener nofollow" target="_blank"><i class="fa fa-facebook-f"></i></a>
                        
                        
                    </div>
                    <div class="change_lang_footer">
                        <?php if($current_lang == 'ar'){ ?>
                            <a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('en')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" style="fill: currentColor;padding:0;position:relative;top:9px;left:8px;width:1.5em"><path d="M415.9 344L225 344C227.9 408.5 242.2 467.9 262.5 511.4C273.9 535.9 286.2 553.2 297.6 563.8C308.8 574.3 316.5 576 320.5 576C324.5 576 332.2 574.3 343.4 563.8C354.8 553.2 367.1 535.8 378.5 511.4C398.8 467.9 413.1 408.5 416 344zM224.9 296L415.8 296C413 231.5 398.7 172.1 378.4 128.6C367 104.2 354.7 86.8 343.3 76.2C332.1 65.7 324.4 64 320.4 64C316.4 64 308.7 65.7 297.5 76.2C286.1 86.8 273.8 104.2 262.4 128.6C242.1 172.1 227.8 231.5 224.9 296zM176.9 296C180.4 210.4 202.5 130.9 234.8 78.7C142.7 111.3 74.9 195.2 65.5 296L176.9 296zM65.5 344C74.9 444.8 142.7 528.7 234.8 561.3C202.5 509.1 180.4 429.6 176.9 344L65.5 344zM463.9 344C460.4 429.6 438.3 509.1 406 561.3C498.1 528.6 565.9 444.8 575.3 344L463.9 344zM575.3 296C565.9 195.2 498.1 111.3 406 78.7C438.3 130.9 460.4 210.4 463.9 296L575.3 296z"/></svg>
                                <span>EN</span>
                            </a>
                        <?php }
                        elseif($current_lang == 'en'){ ?>
                            <a href="<?= ((isset($link_lang) && $link_lang != '') ? $link_lang : localized_url('ar')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" style="fill: currentColor;padding:0;position:relative;top:9px;left:8px;width:1.5em"><path d="M415.9 344L225 344C227.9 408.5 242.2 467.9 262.5 511.4C273.9 535.9 286.2 553.2 297.6 563.8C308.8 574.3 316.5 576 320.5 576C324.5 576 332.2 574.3 343.4 563.8C354.8 553.2 367.1 535.8 378.5 511.4C398.8 467.9 413.1 408.5 416 344zM224.9 296L415.8 296C413 231.5 398.7 172.1 378.4 128.6C367 104.2 354.7 86.8 343.3 76.2C332.1 65.7 324.4 64 320.4 64C316.4 64 308.7 65.7 297.5 76.2C286.1 86.8 273.8 104.2 262.4 128.6C242.1 172.1 227.8 231.5 224.9 296zM176.9 296C180.4 210.4 202.5 130.9 234.8 78.7C142.7 111.3 74.9 195.2 65.5 296L176.9 296zM65.5 344C74.9 444.8 142.7 528.7 234.8 561.3C202.5 509.1 180.4 429.6 176.9 344L65.5 344zM463.9 344C460.4 429.6 438.3 509.1 406 561.3C498.1 528.6 565.9 444.8 575.3 344L463.9 344zM575.3 296C565.9 195.2 498.1 111.3 406 78.7C438.3 130.9 460.4 210.4 463.9 296L575.3 296z"/></svg>
                                <span>AR</span>
                            </a>
                        <?php } ?>
                    </div>

                    <div class="subscribe animate__animated">
                        <span class="newsletter-title"><?= trans("front.signup to our newsletter"); ?></span>
                        <?= Form::open(["url" => route("front.callus2"), "id" => "form-newsletter"]); ?>
                        <input type="hidden" value="newsletter" name="form_type">
                        <input class="form-control" type="text" name="mobile" value="{{ @session()->get('call_country') }}" id="mobile-sm" placeholder="" required>
                        <button><svg width="22" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 17 16.3" xml:space="preserve"><g> <path class="st0" d="M1.8,8.2C2.4,8.1,3,8.1,3.6,8.1C6.3,7.9,9,7.8,11.7,7.6c0.9,0,1.7-0.1,2.6-0.1c0.2,0,0.3-0.1,0.4-0.8 C15,4.8,15.6,3,16.6,1.3c0.4-0.7,0.6-0.8,0.3-1C16.5,0,16.1,0,15.7,0.2C14.3,0.8,13,1.4,11.6,2c-3,1.3-6,2.7-8.8,4.2 C2,6.6,1.3,7.1,0.6,7.5C0.4,7.7,0.3,7.8,0.1,8C0,8.1,0,8.3,0.1,8.4c0.2,0.2,0.3,0.3,0.5,0.4c1,0.6,2,1.2,3.1,1.8 c3.9,2,8,3.8,12,5.5c0.4,0.2,0.8,0.2,1.2-0.1c0.1-0.1,0.2-0.1,0.1-0.3c-0.8-2.3-1.7-4.6-2.5-6.9c-2.3,0-4.5-0.1-6.8-0.2 C5.8,8.5,3.9,8.3,2,8.2C1.9,8.2,1.9,8.2,1.8,8.2L1.8,8.2z"/> </g> </svg></button>
                        <?= Form::close(); ?>
                    </div>

                        
                    


                    <?php /* <div class="complaints_btn" title="complaints">
                      <p class="jazzira_font_bold"><?= trans("front.quick menu link 18"); ?></p>
                      <a title="Hotline Call" href="tel:00905451605000">
                      <span class="num">+90 545 160 5000</span>
                      </a>
                      <a title="Complaints Whatsapp" href="https://api.whatsapp.com/send?phone=905451605000&text=">
                      <img width="60" height="60" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="complaints-icon"/>
                      </a>
                      </div> */ ?>


                </li>


                <li class="animate__animated">
                    <p class="jazzira_font_bold footer_title"><?= trans("front.about damas"); ?></p>

                    <div class="int_sec post">
                        <a title="<?= trans("front.about us"); ?>" href="{{ route('front.aboutus') }}" class="about_link">
                            <svg width="39" height="32" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 24.9 20.5" xml:space="preserve"><g> <path class="st0" d="M12.4,13.4c-2.1,0-4.2,0-6.4,0c0,0-0.1,0-0.1,0c-0.2,0-0.4-0.1-0.3-0.4c0-0.1,0-0.3,0-0.4c0-0.2,0-0.4,0-0.6 c0-0.1,0-0.2,0-0.3c0-0.1,0-0.1,0-0.2c0.1-0.6,0.3-1,0.9-1.2c0.4-0.1,0.8-0.2,1.1-0.4c0.4-0.2,0.8-0.4,1.2-0.7 c0.2-0.2,0.4-0.3,0.7-0.5c0.3-0.2,0.4-0.2,0.7,0C10.6,9,11,9.2,11.4,9.4c0.3,0.1,0.7,0.2,1.1,0.2c0.3,0,0.6,0,0.8-0.1 c0.4-0.1,0.8-0.3,1.2-0.5c0.1-0.1,0.2-0.1,0.3-0.2c0.1-0.1,0.2-0.1,0.4,0c0.2,0.1,0.3,0.2,0.4,0.3c0.3,0.3,0.7,0.5,1.1,0.7 c0.3,0.1,0.6,0.3,0.9,0.4c0.1,0.1,0.3,0.1,0.4,0.1c0.2,0.1,0.4,0.1,0.6,0.2c0.3,0.2,0.4,0.4,0.5,0.7c0.1,0.4,0.2,0.8,0.2,1.2 c0,0.2,0,0.5,0.1,0.7c0,0.2-0.1,0.4-0.4,0.4c-1,0-2.1,0-3.1,0C14.6,13.4,13.5,13.4,12.4,13.4C12.4,13.4,12.4,13.4,12.4,13.4z"/> <path class="st0" d="M12.5,8.6c-0.5,0-0.9-0.2-1.3-0.4c-0.3-0.2-0.6-0.4-0.8-0.7C10,7.1,9.7,6.7,9.5,6.1C9.4,5.9,9.3,5.7,9.3,5.4 C9.2,5.2,9.2,5,9.1,4.7c0-0.1,0-0.1,0-0.2c0-0.4,0-0.7,0-1.1c0-0.1,0-0.1,0-0.2c0-0.1,0-0.2,0-0.3c0-0.1,0-0.2,0.1-0.2 c0-0.1,0.1-0.3,0.1-0.4C9.5,2,9.7,1.6,10,1.2c0.3-0.4,0.7-0.7,1.2-1C11.4,0.1,11.7,0.1,12,0c0.4,0,0.7,0,1.1,0 c0.3,0,0.6,0.1,0.8,0.3c0.7,0.4,1.1,0.9,1.4,1.6c0.1,0.2,0.2,0.4,0.2,0.7c0.1,0.2,0.1,0.4,0.1,0.6c0,0.1,0,0.1,0,0.2 c0.1,0.4,0.1,0.8,0,1.1c0,0.1,0,0.2,0,0.3c0,0.1,0,0.2,0,0.3c0,0,0,0.1,0,0.1c0,0.3-0.2,0.7-0.3,1c-0.1,0.3-0.3,0.7-0.5,1 c-0.2,0.3-0.4,0.5-0.7,0.7c-0.3,0.2-0.6,0.4-0.9,0.6C13,8.6,12.7,8.7,12.5,8.6z"/> <path class="st0" d="M18.7,9.1c-0.4,0-0.7-0.1-1.1-0.3C17.3,8.6,17,8.3,16.7,8c-0.3-0.3-0.5-0.7-0.7-1.1c0-0.1,0-0.2,0-0.2 c0.1-0.3,0.2-0.6,0.3-0.9c0.1-0.2,0.1-0.4,0.1-0.6c0.1-0.2,0.1-0.4,0.1-0.6c0-0.4,0-0.9,0-1.3c0-0.1,0-0.2,0-0.3c0-0.1,0-0.2,0-0.2 c0-0.1,0-0.1,0-0.2c-0.1-0.1,0-0.2,0-0.3c0.3-0.4,0.6-0.6,1-0.8c0.4-0.2,0.9-0.3,1.4-0.3c0.2,0,0.5,0.1,0.7,0.1 c0.2,0.1,0.5,0.2,0.6,0.3c0.2,0.1,0.3,0.2,0.4,0.4c0.4,0.4,0.7,0.8,0.8,1.4c0,0.2,0.1,0.3,0.1,0.5c0,0,0,0,0,0c0,0.5,0.2,1.1,0,1.6 c0,0,0,0.1,0,0.1c0,0.3-0.1,0.5-0.2,0.8c-0.1,0.3-0.2,0.6-0.3,0.9c-0.2,0.5-0.6,0.9-1,1.3c-0.3,0.2-0.5,0.3-0.9,0.5 C19.1,9.1,18.9,9.1,18.7,9.1z"/> <path class="st0" d="M6.2,9.1C5.8,9.1,5.4,8.9,5,8.7C4.7,8.5,4.4,8.2,4.2,7.9C4,7.7,3.8,7.4,3.7,7.1C3.5,6.8,3.4,6.4,3.3,6 C3.3,5.6,3.2,5.2,3.2,4.8c0-0.1,0-0.3,0-0.4c0-0.1,0-0.3,0-0.4c0-0.2,0.1-0.3,0.1-0.5c0.1-0.4,0.2-0.7,0.5-1C4.2,2,4.6,1.6,5.2,1.4 c0.2-0.1,0.4-0.1,0.5-0.1c0.2-0.1,0.4-0.1,0.7-0.1c0.2,0,0.5,0.1,0.7,0.1C7.4,1.4,7.7,1.6,8,1.8C8.2,2,8.3,2.1,8.5,2.3 c0,0.1,0,0.1,0,0.2C8.4,2.8,8.4,3.1,8.4,3.3c0,0.5,0,0.9,0,1.4c0,0.1,0,0.2,0.1,0.4c0,0.1,0,0.1,0,0.2c0,0.2,0.1,0.4,0.1,0.7 c0.1,0.2,0.1,0.4,0.2,0.6c0,0,0,0.1,0,0.1c0.1,0.2,0.1,0.3,0,0.5c-0.2,0.5-0.6,1-1,1.4C7.5,8.7,7.2,8.9,6.8,9C6.7,9,6.6,9,6.6,9.1 C6.5,9.1,6.3,9.1,6.2,9.1z"/> <path class="st0" d="M19.2,9.9c0.3-0.1,0.5-0.2,0.7-0.3c0.3-0.1,0.5-0.3,0.8-0.5C20.9,9,21,9,21.2,9.1c0.3,0.2,0.6,0.4,0.9,0.6 c0.3,0.2,0.7,0.4,1.1,0.6c0.2,0.1,0.4,0.2,0.7,0.2c0.2,0,0.3,0.1,0.4,0.2c0.2,0.1,0.3,0.2,0.4,0.4c0.1,0.3,0.2,0.7,0.2,1 c0,0.2,0,0.4,0.1,0.6c0,0.1,0,0.2,0,0.3c0,0.2-0.1,0.3-0.3,0.3c0,0-0.1,0-0.1,0c-1.4,0-2.8,0-4.2,0c0,0-0.1,0-0.1,0 c-0.2,0-0.2,0-0.2-0.2c0-0.3,0-0.7,0-1c0-0.1,0-0.2,0-0.3c0-0.1,0-0.2,0-0.4c0-0.1,0-0.2,0-0.3c0-0.1-0.1-0.3-0.1-0.4 c-0.1-0.3-0.2-0.5-0.4-0.7C19.4,10.1,19.3,10,19.2,9.9z"/> <path class="st0" d="M5.7,9.8c0,0.1-0.1,0.1-0.1,0.2c-0.1,0.1-0.2,0.2-0.3,0.3c-0.3,0.4-0.4,0.9-0.4,1.4c0,0,0,0.1,0,0.1 c-0.1,0.4,0,0.9-0.1,1.3c0,0.2,0,0.2-0.2,0.2c-1.4,0-2.8,0-4.2,0C0.1,13.4,0,13.2,0,13c0-0.5,0.1-1,0.2-1.5c0-0.1,0.1-0.2,0.1-0.4 c0.1-0.3,0.4-0.5,0.7-0.6c0.5-0.2,1.1-0.4,1.6-0.6c0.1-0.1,0.2-0.2,0.3-0.2c0.2-0.1,0.4-0.3,0.6-0.4c0.1-0.1,0.2-0.1,0.2-0.2 C3.9,9,4,9,4.1,9.1C4.4,9.4,4.7,9.5,5,9.7c0.2,0.1,0.4,0.1,0.6,0.1C5.6,9.8,5.7,9.8,5.7,9.8z"/> <path class="st0" d="M6.1,17.1c0.1,0.1,0.2,0.2,0.3,0.3c0.2,0.2,0.3,0.4,0.3,0.7c0,0.3,0,0.7,0,1c0,0.5-0.2,0.8-0.6,1.1 c-0.1,0.1-0.3,0.1-0.4,0.1c-0.6,0.1-1.2,0-1.7,0.1c-0.2,0-0.2,0-0.2-0.2c0-1.9,0-3.8,0-5.7c0-0.2,0-0.2,0.2-0.2c0.4,0,0.8,0,1.2,0 c0.3,0,0.7,0,1,0.2c0.2,0.1,0.4,0.3,0.4,0.6c0.1,0.4,0.1,0.8,0.1,1.2C6.6,16.6,6.5,16.9,6.1,17.1z M4.8,17.7 C4.8,17.7,4.8,17.7,4.8,17.7c0,0.6,0,1.2,0,1.7c0,0.1,0.1,0.1,0.1,0.1c0.2,0,0.3,0,0.5,0c0.2,0,0.3-0.1,0.4-0.3 c0-0.1,0.1-0.2,0.1-0.4c0-0.3,0-0.6,0-0.9c0-0.2-0.2-0.3-0.4-0.4C5.2,17.6,5,17.7,4.8,17.7z M4.8,16.7c0.2,0,0.4,0,0.6,0 c0.2,0,0.4-0.2,0.4-0.4c0-0.3,0-0.6,0-0.8c0-0.1-0.1-0.2-0.2-0.3c-0.2-0.1-0.4-0.1-0.6-0.1c-0.1,0-0.1,0.1-0.1,0.1 C4.8,15.8,4.8,16.2,4.8,16.7z"/> <path class="st0" d="M7.3,17.3c0-0.6,0-1.2,0-1.8c0-0.5,0.3-1,0.8-1.2c0.3-0.1,0.5-0.1,0.8-0.1c0.2,0,0.3,0,0.5,0.1 c0.4,0.1,0.6,0.4,0.7,0.8c0.1,0.2,0.1,0.4,0.1,0.6c0,1.1,0,2.3,0,3.4c0,0.6-0.3,1.1-1,1.3c-0.1,0-0.3,0-0.5,0c-0.3,0-0.6,0-0.9-0.2 c-0.3-0.2-0.4-0.4-0.5-0.7c-0.1-0.2-0.1-0.4-0.1-0.6C7.3,18.4,7.3,17.9,7.3,17.3z M8.3,17.3c0,0.6,0,1.2,0,1.8c0,0.1,0,0.1,0,0.2 c0.1,0.2,0.3,0.3,0.5,0.3c0.2,0,0.4-0.2,0.4-0.5c0-0.1,0-0.2,0-0.4c0-1.1,0-2.1,0-3.2c0-0.3-0.2-0.5-0.5-0.5 c-0.2,0-0.5,0.2-0.5,0.5C8.3,16.1,8.3,16.7,8.3,17.3z"/> <path class="st0" d="M19.6,16.8c0,0.8,0,1.5,0,2.3c0,0.2,0.1,0.3,0.3,0.4c0.2,0.1,0.4,0.1,0.5-0.1c0.1-0.1,0.1-0.1,0.1-0.2 c0-0.1,0-0.2,0-0.3c0-1.4,0-2.8,0-4.2c0-0.1,0-0.2,0-0.3c0-0.1,0-0.2,0.2-0.2c0.2,0,0.4,0,0.7,0c0.1,0,0.1,0.1,0.2,0.2 c0,0.1,0,0.1,0,0.2c0,1.4,0,2.8,0,4.2c0,0.3,0,0.6-0.2,0.9c-0.1,0.4-0.4,0.6-0.8,0.7c-0.2,0.1-0.5,0.1-0.8,0 c-0.2,0-0.4-0.1-0.5-0.2c-0.3-0.2-0.5-0.5-0.6-0.9c-0.1-0.2-0.1-0.4-0.1-0.7c0-1.4,0-2.8,0-4.3c0,0,0-0.1,0-0.1 c0-0.1,0-0.1,0.1-0.1c0.2,0,0.5,0,0.7,0c0.1,0,0.1,0,0.1,0.1c0,0.1,0,0.1,0,0.2C19.6,15.3,19.6,16,19.6,16.8z"/> <path class="st0" d="M1.1,19.3C1,19.7,1,20,0.9,20.4c0,0-0.1,0-0.1,0c-0.2,0-0.4,0-0.6,0C0,20.4,0,20.3,0,20.2c0,0,0,0,0-0.1 c0-0.2,0.1-0.5,0.1-0.7c0,0,0,0,0,0c0-0.2,0.1-0.4,0.1-0.7c0-0.1,0-0.2,0.1-0.4c0-0.1,0-0.1,0-0.2c0,0,0-0.1,0-0.1 c0-0.2,0.1-0.5,0.1-0.7c0-0.3,0.1-0.5,0.1-0.8c0-0.1,0-0.1,0-0.2c0-0.1,0-0.2,0.1-0.3c0,0,0,0,0,0c0-0.2,0.1-0.5,0.1-0.7 c0-0.3,0.1-0.5,0.2-0.8c0,0,0-0.1,0-0.1c0.2,0,0.4,0,0.5,0c0.2,0,0.5,0,0.7,0c0.1,0,0.2,0,0.2,0.1c0,0.2,0.1,0.4,0.1,0.6 c0,0.3,0.1,0.5,0.2,0.8c0,0.1,0,0.1,0,0.2c0,0.1,0,0.2,0,0.2c0,0.1,0,0.2,0,0.3c0,0.1,0,0.1,0,0.2c0,0.1,0,0.2,0.1,0.4 c0,0.3,0.1,0.5,0.1,0.8c0,0.1,0,0.1,0,0.2c0,0.1,0,0.2,0.1,0.3c0,0,0,0,0,0.1c0,0.2,0.1,0.5,0.1,0.7c0,0,0,0,0,0 c0,0.2,0.1,0.5,0.1,0.7c0,0.2,0,0.3,0.1,0.5c0,0.1,0,0.1-0.1,0.1c-0.2,0-0.5,0-0.7,0c0,0-0.1,0-0.1-0.1c0,0,0-0.1-0.1-0.1 c0-0.2-0.1-0.5-0.1-0.7c0-0.2,0-0.2-0.2-0.2C1.8,19.3,1.4,19.3,1.1,19.3z M2.1,18.4c0-0.1,0-0.2,0-0.2C2,18,2,17.8,2,17.7 c0-0.2-0.1-0.4-0.1-0.6c0,0,0,0,0-0.1c0-0.1,0-0.2-0.1-0.4c0-0.1,0-0.1,0-0.2c0-0.1,0-0.2-0.1-0.4c0-0.2,0-0.3-0.1-0.4 c0,0.3-0.1,0.5-0.1,0.8c0,0.3-0.1,0.5-0.1,0.8c0,0,0,0,0,0.1c0,0.1,0,0.2-0.1,0.4c0,0.1,0,0.1,0,0.2c-0.1,0.2,0,0.4-0.1,0.6 C1.5,18.4,1.8,18.4,2.1,18.4z"/> <path class="st0" d="M12.7,14.3c0.3,0,0.5,0,0.8,0c0.1,0,0.1,0.1,0.1,0.1c0,0.1,0,0.2,0,0.3c0,1.4,0,2.8,0,4.3c0,0.4-0.1,0.7-0.3,1 c-0.1,0.2-0.3,0.2-0.4,0.3c-0.3,0.1-0.6,0.2-0.9,0.1c-0.1,0-0.2,0-0.3-0.1c-0.2-0.1-0.4-0.2-0.6-0.4c-0.1-0.2-0.2-0.4-0.2-0.6 c0-1.6,0-3.2,0-4.8c0-0.3,0-0.3,0.3-0.3c0.2,0,0.3,0,0.5,0c0.1,0,0.2,0,0.2,0.1c0,0,0,0.1,0,0.1c0,1.4,0,2.8,0,4.2 c0,0.2,0,0.4,0.1,0.6c0.1,0.2,0.3,0.4,0.6,0.3c0.3-0.1,0.4-0.2,0.4-0.6c0-0.5,0-1.1,0-1.6c0-1,0-2,0-2.9 C12.7,14.4,12.7,14.4,12.7,14.3z"/> <path class="st0" d="M24.4,15.9c-0.1,0-0.2,0-0.3,0c-0.1,0-0.1,0-0.2-0.1c0-0.1,0-0.3-0.1-0.4c-0.1-0.2-0.3-0.4-0.6-0.3 c-0.3,0.1-0.4,0.4-0.3,0.7c0.1,0.4,0.3,0.8,0.6,1c0.1,0.1,0.2,0.1,0.2,0.2c0.4,0.3,0.7,0.7,0.9,1.2c0.1,0.3,0.2,0.7,0.1,1.1 c-0.1,0.2-0.1,0.5-0.3,0.7c-0.2,0.3-0.5,0.4-0.8,0.4c-0.2,0-0.5,0-0.7,0c0,0-0.1,0-0.1,0c-0.4-0.2-0.7-0.4-0.8-0.8 C22,19.3,22,19,22,18.6c0-0.1,0.1-0.1,0.2-0.1c0.2,0,0.4,0,0.6,0c0.1,0,0.2,0,0.2,0.2c0,0.2,0,0.3,0,0.5c0,0.2,0.2,0.4,0.5,0.4 c0.3,0,0.4-0.2,0.5-0.5c0-0.4-0.2-0.7-0.4-1c-0.3-0.3-0.6-0.6-1-1c-0.2-0.2-0.3-0.4-0.4-0.7C22,16,22,15.6,22.1,15.3 c0.1-0.4,0.3-0.8,0.7-0.9c0.2-0.1,0.5-0.1,0.8-0.1c0.2,0,0.3,0,0.5,0.1c0.3,0.1,0.5,0.3,0.6,0.6c0.1,0.3,0.2,0.6,0.2,0.9 c0,0.1,0,0.2-0.2,0.2C24.6,16,24.5,16,24.4,15.9C24.4,16,24.4,16,24.4,15.9z"/> <path class="st0" d="M14.9,15.2c-0.3,0-0.7,0-1,0c0-0.3,0-0.5,0-0.8c0-0.1,0-0.1,0.1-0.1c0.1,0,0.1,0,0.2,0c0.8,0,1.7,0,2.5,0 c0.2,0,0.2,0,0.2,0.2c0,0.2,0,0.5,0,0.7c-0.3,0-0.7,0-1,0c0,0.1,0,0.1,0,0.2c0,1.6,0,3.1,0,4.7c0,0.3,0,0.3-0.3,0.3 c-0.1,0-0.3,0-0.4,0c-0.2,0-0.3,0-0.3-0.2c0-0.9,0-1.7,0-2.6c0-0.7,0-1.5,0-2.2C15,15.3,14.9,15.2,14.9,15.2z"/> </g> </svg>

                            <p class="jazzira_font_bold"><?= trans("front.about damas text"); ?></p>
                        </a>
                    </div>
                    <div class="int_sec post">
                        <a title="<?= trans("front.career"); ?>" href="{{ route('front.land_vacancies') }}" class="about_link">
                            <svg width="39" height="39" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 22.7 22.7" style="enable-background:new 0 0 22.7 22.7;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><g> <path class="st0" d="M22.1,19l-2.5-2.5c-0.7-0.7-1.7-0.8-2.5-0.4l-1.5-1.5c1.3-1.6,2.1-3.6,2.1-5.8c0-4.9-4-8.9-8.9-8.9 C4,0,0,4,0,8.9c0,4.9,4,8.9,8.9,8.9c2.2,0,4.2-0.8,5.8-2.1l1.5,1.5c-0.4,0.8-0.3,1.8,0.4,2.5l2.5,2.5c0.4,0.4,1,0.6,1.5,0.6 c0.6,0,1.1-0.2,1.5-0.6c0,0,0,0,0,0c0.4-0.4,0.6-1,0.6-1.5C22.7,20,22.5,19.4,22.1,19L22.1,19z M8.9,16.4c-4.2,0-7.5-3.4-7.5-7.5 c0-4.2,3.4-7.5,7.5-7.5c4.2,0,7.5,3.4,7.5,7.5C16.4,13,13,16.4,8.9,16.4L8.9,16.4z M21.1,21.1C21.1,21.1,21.1,21.1,21.1,21.1 C21.1,21.1,21.1,21.1,21.1,21.1c-0.3,0.3-0.9,0.3-1.2,0l-2.5-2.5c-0.3-0.3-0.3-0.9,0-1.2c0.3-0.3,0.9-0.3,1.2,0l2.5,2.5 C21.5,20.3,21.5,20.8,21.1,21.1L21.1,21.1z M21.1,21.1"/> <path class="st0" d="M5.3,6.1H3.9c-0.4,0-0.7,0.3-0.7,0.7c0,0.4,0.3,0.7,0.7,0.7h0.8v2.5c0,0.2-0.2,0.4-0.4,0.4 c-0.2,0-0.4-0.2-0.4-0.4c0-0.4-0.3-0.7-0.7-0.7c-0.4,0-0.7,0.3-0.7,0.7c0,1,0.8,1.7,1.7,1.7c1,0,1.7-0.8,1.7-1.7V6.7 C6,6.4,5.7,6.1,5.3,6.1L5.3,6.1z M5.3,6.1"/> <path class="st0" d="M8.7,6.1C7.6,6.1,6.8,6.9,6.8,8v1.8c0,1.1,0.9,1.9,1.9,1.9c1.1,0,1.9-0.9,1.9-1.9V8C10.6,6.9,9.7,6.1,8.7,6.1 L8.7,6.1z M9.3,9.8c0,0.3-0.3,0.6-0.6,0.6c-0.3,0-0.6-0.3-0.6-0.6V8c0-0.3,0.3-0.6,0.6-0.6C9,7.4,9.3,7.6,9.3,8V9.8z M9.3,9.8"/> <path class="st0" d="M15.2,7.8c0-1-0.8-1.7-1.7-1.7h-1.4c-0.4,0-0.7,0.3-0.7,0.7V11c0,0.4,0.3,0.7,0.7,0.7h1.4c1,0,1.7-0.8,1.7-1.7 c0-0.4-0.1-0.8-0.4-1.1C15.1,8.6,15.2,8.2,15.2,7.8L15.2,7.8z M13.9,7.8c0,0.2-0.2,0.4-0.4,0.4h-0.8V7.4h0.8 C13.7,7.4,13.9,7.6,13.9,7.8L13.9,7.8z M13.5,10.3h-0.8V9.5h0.8c0.2,0,0.4,0.2,0.4,0.4C13.9,10.2,13.7,10.3,13.5,10.3L13.5,10.3z M13.5,10.3"/> </g> </svg>
<!--                            <img class="lazy loaded title_icon" title="<?= trans("front.career"); ?>" src="http://newdemo.damas.net/img/JobIcon-footer-<?= $current_lang; ?>.svg">-->

                            <p class="jazzira_font_bold"><?= trans("front.job text"); ?></p>
                        </a>
                    </div>
                    <div class="int_sec post">
                        <a title="<?= trans("front.faq"); ?>" href="{{ route('front.faq') }}" class="about_link">
                            <svg width="39" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 26.3 13.4" style="enable-background:new 0 0 26.3 13.4;" xml:space="preserve"><style type="text/css">.st0{fill:#FFF}</style><rect x="69.6" y="-30.7" class="st0" width="80.9" height="60.4"/> <g> <path d="M2.7,3.1v2.6h4.1V7H2.7v3.2H1.1V1.8h6.1v1.3H2.7z"/> <path d="M13.9,8.3H9.7l-0.8,1.9H7.2L11,1.8h1.5l3.8,8.4h-1.6L13.9,8.3z M13.3,7l-1.6-3.7L10.2,7H13.3z"/> <path d="M26.1,11c-0.6,0.6-1.3,1-2.2,1c-1.1,0-2-0.4-3.2-1.7c-2.4-0.2-4-2-4-4.3c0-2.5,1.9-4.3,4.5-4.3s4.5,1.8,4.5,4.3 c0,2-1.3,3.6-3.1,4.1c0.5,0.5,0.9,0.7,1.4,0.7c0.6,0,1-0.2,1.4-0.7L26.1,11z M21.2,9c1.7,0,3-1.2,3-3c0-1.7-1.3-3-3-3 c-1.7,0-3,1.2-3,3C18.3,7.7,19.5,9,21.2,9z"/> </g> </svg>
                            <p class="jazzira_font_bold"><?= trans("front.faq"); ?></p>
                        </a>
                    </div>




                    
                </li>

                <li class="animate__animated">
                    <p class="jazzira_font_bold footer_title"><?= trans("front.Featured Projects"); ?></p>

                    <?php
                    $footerUsefulCountry = null;
                    $footerHomeRoutes = array('front.index', 'amp.front.index');
                    $footerCurrentRoute = \Route::currentRouteName();
                    if (!in_array($footerCurrentRoute, $footerHomeRoutes, true)) {
                        $footerUsefulCountry = Helper::currentCountry(
                            isset($project) ? $project : (isset($locationCountry) ? $locationCountry : null)
                        );
                        if (!$footerUsefulCountry && isset($post) && is_object($post) && $post->countryRel) {
                            $footerUsefulCountry = $post->countryRel;
                        }
                    }
                    if (!isset($footer_prjs)) {
                        $arr_ids = \App\Models\Fotterproject::projectIdsForCountry($footerUsefulCountry);
                        $footer_prjs = \App\Models\Project::whereIn('id', $arr_ids)->get();
                    }
                    foreach ($footer_prjs as $p) {
                        ?>
                        <div class="int_sec post">
                            <a href="{{ $p->frontUrl() }}">
                                <div class="imageCont"><img class="media-object lazy" loading="lazy" src="{{ Helper::get_thumbnail($p->cardphoto, 100, 56) }}"  alt="damasturk"></div>
                                <p><?= $p->getIntroCard() ?></p>
                            </a>
                        </div>
                    <?php } ?>
                    <?php /* <!-- <div class="int_sec post">
                      <a href="{{ route('front.investment') }}">
                      <div class="imageCont"><img class="media-object lazy" data-src="/img/investment-icon.jpg"  alt="<?= trans("front.What is a successful investment in Turkey"); ?>" title="<?= trans("front.What is a successful investment in Turkey"); ?>"></div>
                      <p class="jazzira_font_bold"><?= trans("front.What is a successful investment in Turkey"); ?></p>
                      </a>
                      </div>
                      <div class="int_sec post">
                      <a href="{{ route('front.living_turkey') }}">
                      <div class="imageCont"><img class="media-object lazy" data-src="/img/living-icon.jpg"  alt="<?= trans("front.What are the costs of living in Turkey"); ?>" title="<?= trans("front.What are the costs of living in Turkey"); ?>"></div>
                      <p class="jazzira_font_bold"><?= trans("front.What are the costs of living in Turkey"); ?></p>
                      </a>
                      </div>
                      <div class="int_sec post">
                      <a href="{{ route('front.legal') }}">
                      <div class="imageCont"><img class="media-object lazy" data-src="/img/legal-icon.jpg"  alt="<?= trans("front.How do I get residency in Turkey"); ?>" title="<?= trans("front.How do I get residency in Turkey"); ?>"></div>
                      <p class="jazzira_font_bold"><?= trans("front.How do I get residency in Turkey"); ?></p>
                      </a>
                      </div>
                      <div class="int_sec post">
                      <a href="{{ route('front.districts',['istanbul']) }}">
                      <div class="imageCont"><img class="media-object lazy" data-src="/img/districts-icon.jpg"  alt="<?= trans("front.What are the best areas of Istanbul"); ?>" title="<?= trans("front.What are the best areas of Istanbul"); ?>"></div>
                      <p class="jazzira_font_bold"><?= trans("front.What are the best areas of Istanbul"); ?></p>
                      </a>
                      </div> */ ?>
                </li>



                <li class="animate__animated">
                    <p class="jazzira_font_bold footer_title"><?= trans("front.keywords footer"); ?></p>

                    <?php
                    $footerLinkLang = ($current_lang == 'pe' ? 'fa' : $current_lang);
                    $uLinksQuery = \App\Models\FooterLink::orderBy('placement', 'ASC')
                        ->whereIn('lang', array('all', $footerLinkLang));
                    if ($footerUsefulCountry) {
                        $uLinksQuery->where('country_id', $footerUsefulCountry->id);
                    } else {
                        $uLinksQuery->whereNull('country_id');
                    }
                    $u_links = $uLinksQuery->get()->toArray();
                    ?>
                    @foreach($u_links as $u_link)
                    @if($u_link['footer_section'] == "useful")
                    <?php $title = "title_" . ($current_lang == 'pe' ? 'fa' : $current_lang); ?>
                    <div class="int_sec post project_type">
                        <a title="<?= $u_link[$title]; ?>" href="<?= ($current_lang == 'ar' ? $u_link["link"] : str_replace('https://damas.net/', '/' . $current_lang . '/', $u_link["link"])); ?>">
                            <p><?php echo $u_link[$title]; ?></p>
                        </a>
                    </div>

                    @endif
                    @endforeach
                </li>


            </ul>



            <div class="sub_footer">
                <div class="logo_sec">
                    
                    <img width="90" height="19" src="<?= asset("img/damas.png"); ?>" alt="damasturk">
                    
                </div>
                <div class="copyright animate__animated">
                    <a href="<?= route("front.terms"); ?>" id="use">
                        <?= trans("front.View the intellectual property rights of damasturk"); ?>
                    </a>
                    &copy; <span class="num"><?= date('Y'); ?></span>
                    <br> 
                    <span class="num">(Fikri Mülkiyet Hakları)</span>
                </div>


                <div class="privacy animate__animated">
                    <a href="<?= route("front.privacy"); ?>" id="privacy">
                        <?= trans("front.privacy policy"); ?>
                    </a>
                    <a href="<?= route("front.terms"); ?>" id="use">
                        <?= trans("front.terms of use"); ?>
                    </a>
                </div>
            </div>
        </footer>

        <!-- End Footer -->
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        








        <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
        <?php if ($style_lang == 'en') { ?>
            <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800,900&display=swap" rel="stylesheet">
        <?php } ?>
        <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,800,900&display=swap&subset=arabic" rel="stylesheet">
        <?php /* <!--<style>
          include(public_path() . "/fonts/" . $style_lang . ".css")
          </style>
          <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,800,900&display=swap" rel="stylesheet">
          <link href="https://fonts.googleapis.com/css?family=Cairo:300,400,600,700,800,900&display=swap&subset=arabic" rel="stylesheet">--> */ ?>

        <?php if (App::isLocal()) { ?>

            <?php /* Html::script("https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"); ?>
              <?= Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"); */ ?>

            <?= Html::script("resources/assets/js/jquery1.12.4.min.js"); ?>
            <?= Html::script("resources/assets/js/popper.min.js"); ?>
            <?= Html::script("resources/assets/js/bootstrap.min.js"); ?>

            <!--<?php // Html::script("resources/assets/js/jquery-2.2.4.min.js");                                                                                                  ?>-->

            <!-- <?php // Html::script("resources/assets/js/bootstrap.min.js");                                                                                                   ?>-->
            <!-- <?php // Html::script("resources/assets/js/jquery-3.2.1.slim.min.js");                                                                                                   ?>-->

            <!--<?= Html::script("resources/assets/js/owl.carousel.js"); ?>-->
            <?= Html::script('resources/assets/js/bootstrap-select.js'); ?>

            <?= Html::script("resources/assets/js/intlTelInput.js"); ?>
            <?= Html::script("resources/assets/js/coolshare.js"); ?>
            <?= Html::script("resources/assets/js/jquery.lazy.min.js"); ?>
            <?= Html::script("resources/assets/js/jquery.fancybox.min.js"); ?>
            <?= Html::script("resources/assets/js/bootstrap.min.js"); ?>
            <?= Html::script("resources/assets/js/jquery-ui-autocomplete.js"); ?>
            <?= Html::script("resources/assets/js/main.js"); ?>




        <?php } else { ?>
            <!--<?php // Html::script("resources/assets/js/myChart.js")                                                                                                 ?>-->


            <?php if (!isset($hide_main_js)) { ?>
			
				<!--<script type="text/javascript" src="{{ asset('js/main.min.js') }}?v=07"></script>-->
				<script type="text/javascript" src="{{ asset('js/main_no_fancy.min.js') }}?v=12"></script>
                <script type="text/javascript" src="{{ asset('js/jquery.fancybox.min.js') }}?v=09" defer=""></script>
				<?php // Html::script("js/main.min.js") ?>
            <?php } ?>

        <?php } ?>
		
		@yield('scriptjs')
		
<script>
    
    function setCookie(name, value, daysToLive) {
        let cookieString = `${encodeURIComponent(name)}=${encodeURIComponent(value)}; path=/`;
        
        if (daysToLive) {
            const date = new Date();
            date.setTime(date.getTime() + (daysToLive * 24 * 60 * 60 * 1000));
            cookieString += `; expires=${date.toUTCString()}`;
        }
        
        document.cookie = cookieString;
    }
    function getCookie(name) {
        const nameEQ = encodeURIComponent(name) + "=";
        const cookieArray = document.cookie.split(';');
        
        for (let i = 0; i < cookieArray.length; i++) {
            let cookie = cookieArray[i].trim();
            
            if (cookie.indexOf(nameEQ) === 0) {
                return decodeURIComponent(cookie.substring(nameEQ.length, cookie.length));
            }
        }
        return null;
    }

    
    
/*
function waitForScriptsLoaded(){
	console.log("waitForScriptsLoaded");
 if (window.jQuery) {
console.log("waitForScriptsLoaded window.jQuery true");*/
			 function check_is_mobile(){
				 if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
					 return true;
				 return false;
			 }
            function createCookie(name, value, days) {
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    var expires = "; expires=" + date.toGMTString();
                } else
                    var expires = "";
                document.cookie = name + "=" + value + expires + "; path=/";
            }

            function readCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) == ' ')
                        c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0)
                        return c.substring(nameEQ.length, c.length);
                }
                return null;
            }
<?php if (1 == 1) {//!App::isLocal()                                                                                           ?>
    <?php if (!isset($hide_onesignal)) { ?>
        <?php //<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script> ?>

                    setTimeout(function () {
                        $.getScript('https://cdn.onesignal.com/sdks/OneSignalSDK.js', function () {
                            var OneSignal = window.OneSignal || [];
                            OneSignal.push(function () {
                                OneSignal.init({
                                    appId: "2f1084c2-51c8-4e36-9d43-f55965d8e722",<?php //d117bb52-8f62-4275-8b60-58bf8d16e878//001fe1dd-342f-4613-a349-ab7156bb48c4                                                                                         ?>
                                    safari_web_id: "web.onesignal.auto.13d8bf97-93cf-4a09-b799-2a50baaf1ebd",
                                    notifyButton: {
                                        enable: false,
                                    },
                                });
                            });
        <?php /* Close Notification */ ?>


                            $('#block_subscribe , .close-alert').on('click', function () {
                                $(".notifications-top").addClass("bounceOut");
                                setTimeout(function () {
                                    $(".notifications-top").addClass("close");

                                    createCookie('tblock_notif', '1', 1);

                                }, 2000);
                            });
        <?php /* </script>
          <script data-cfasync="false"> */ ?>


                            window.OneSignal = window.OneSignal || [];
                            window.OneSignal.push(function () {
                                window.OneSignal.isPushNotificationsEnabled(function (isPushEnabled) {
                                    if (isPushEnabled) {
        <?php /* Don't show the subscription container if this visitor is already subscribed to web push 
          console.log('Don t show the subscription container if this visitor is already subscribed to web push'); */ ?>
                                        return;
                                    } else {
        <?php /* console.log('Prompt for permission when the button is clicked');
          Prompt for permission when the button is clicked */ ?>
                                        var subscribeButton = document.querySelector("#subscribe-notifications");

                                        if (subscribeButton) {
        <?php /* console.log('onSubscribeNotificationsButtonClicked'); */ ?>
                                            subscribeButton.addEventListener("click", onSubscribeNotificationsButtonClicked);
                                        }

        <?php /* Get the subscription container */ ?>
                                        var subscriptionContainer = document.querySelector("#subscribe-notifications-container");

        <?php /* Show the container */ ?>
                                        if (subscriptionContainer) {
        <?php /* console.log('Show the container'); */ ?>
                                            if (readCookie('tblock_notif') == null) {
                                                subscriptionContainer.style = "";
                                            }
                                        }
                                    }
                                });
                            });


                            function onSubscribeNotificationsButtonClicked() {
                                window.OneSignal.registerForPushNotifications();
                                $("#subscribe-notifications-container").hide();
                            }

                            $('#checkbox').change(function () {
                                if ($(this).is(':checked')) {
                                    window.OneSignal.registerForPushNotifications();
                                }
                            });

                        });
                    }, <?= Route::currentRouteName() == 'front.legal' ? '3000' : '35000' ?>);

    <?php } ?>
<?php } ?>




         

            $(document).ready(function () {
				
				if(check_is_mobile()){
				  $('.shareSection.type_fixed').removeClass('show').addClass('hide');
				}else{
				  $('.type_full.shadow_type').addClass('faa-tada').addClass('animated').addClass('faa-slow');
				  $('.shareSection.type_fixed').removeClass('hide').addClass('show');
				}
				
				
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
				
                $('body').on("click", ".send_btn_fast", function (e) {
                    var frm = $(this).closest("form");
                    var city = frm.find("select[name=city]").val();
                    var type = frm.find("select[name=project_type]").val();
                    var rooms = (frm.find("select[name=rooms]").length > 0) ? frm.find("select[name=rooms]").val() : '';
                    var price = frm.find(".min_budj").val() + '-' + frm.find(".max_budj").val();

                    var str = "";
                    if (rooms != '' && price != '') {
                        str = '?price=' + price + '&rooms=' + rooms;
                    } else if (rooms == '' && price != '') {
                        str = '?price=' + price;
                    } else if (rooms != '' && price == '') {
                        str = '?rooms=' + rooms;
                    }
                    if (!city)
                        city = "istanbul";
                    if (!type)
                        type = "property-for-sale";

                    var cityListingUrls = <?= json_encode($cityListingUrls); ?>;
                    var dest = cityListingUrls[city];
                    if (dest) {
                        var extra = [];
                        if (type && type !== 'property-for-sale') {
                            extra.push('type=' + encodeURIComponent(type));
                        }
                        if (str) {
                            dest += (dest.indexOf('?') >= 0 ? '&' : '?') + str.replace(/^\?/, '');
                        }
                        if (extra.length) {
                            dest += (dest.indexOf('?') >= 0 ? '&' : '?') + extra.join('&');
                        }
                        window.location.href = dest;
                    } else {
                        window.location.href = "{{ route('front.index') }}/" + type + "/" + city + str;
                    }
                    return false;
                });




                /*top-button*/
                var startScroll = 150;
                var top = $(".top-icon");
                var shareButons = $(".shareSection.type_fixed");
                var supportLinks = $(".support_links");
                var oldsctop = $(window).scrollTop();
                $(window).scroll(function () {

                    if (oldsctop >= startScroll) {
                        $(top).addClass("show");
                        $(shareButons).addClass("show");
                        $(supportLinks).addClass("show");
                    } else {
                        $(top).removeClass("show");
                        $(shareButons).removeClass("show");
                        $(supportLinks).removeClass("show");
                    }

                    /*console.log('old' + oldsctop + ' ----new: '+ $(this).scrollTop());*/
                    if (($(this).scrollTop()) > oldsctop) {
                        top.removeClass('fa-angle-down').addClass('fa-angle-up');
                        $(".header").addClass("scrollMob");
                        $(".support_links").addClass("scrollMob");
                    } else {
                        top.removeClass('fa-angle-up').addClass('fa-angle-down');
                        $(".header").removeClass("scrollMob");
                        $(".support_links").removeClass("scrollMob");
                    }
                    oldsctop = $(this).scrollTop();
                });
                top.click(function () {
                    $("html,body").animate({
                        scrollTop: $(this).hasClass('fa-angle-up') ? 0 : $(document).height()
                    }, 1000);
                });



                $(".nav-icon").on("click", function () {
                    $(this).toggleClass("closed");
                    $(".mobile_menu_sec").toggleClass("show");
                    $("body").toggleClass("show_menu");
                });

                $(".out_box").on("click", function () {
                    $(".nav-icon").trigger("click");
                });
                $(".close_search_menu").on("click", function () {
                    $(".search_menu").removeClass("show");
                    $("body").css("overflow", "visible");
                    $(".support_links").removeClass("hide");
                });
                $(".support_links ul li .close_menu").on("click", function () {
                    $(".support_links ul").removeClass("show");
                    $("body").css("overflow", "visible");
                });

                $('.search_sec').on('show.bs.dropdown', function (e) {
                    /****$(".search_menu").addClass("show");****/
                    $("body").css("overflow", "hidden");
                    setTimeout(function () {
                        document.querySelector('#inputSearch').focus();
                        $(".support_links").addClass("hide");
                    }, 100);
                });

                $('.search_sec').on('hide.bs.dropdown', function (e) {
                    $(".search_menu").removeClass("show");
                    $("body").css("overflow", "visible");
                    $(".support_links").removeClass("hide");
                });

                /*$(document).on('click', '.support_links_btn', function () {
                    $.fancybox.open({
                        src: '#callmeModal',
                        type: 'inline'
                    });
                });*/







                $('.selectpicker').selectpicker();



                $('.search_menu').bind('click', function (e) {
                    e.stopPropagation();
                });


                /*Remove from main.js $("body").on("click",'.dropdown-menu a', function(e){...  */
                $("body").on("change", '.pattern_select', function (e) {
                    if ($(this).val() != '') {
                        var drp = $(this).closest('.control_sec');
                        drp.find('.num').addClass('hidden');
                        drp.find('.tpp' + $(this).val()).removeClass('hidden');
                        /*$(this).parent('li').parent('ul').parent('.bed').children('span').html($(this).html());*/
                    }
                });


                /* panel-collapse header links */
                $("body").on("click", '#accordionLinks .panel-title>a', function (e) {
                    var thisLinks = $(this).parents("panel").find(".panel-collapse");
                    $(".panel-title a").removeClass("active");
                    $(".panel-collapse").removeClass("show");
                    $(thisLinks).addClass("show");
                    $(this).addClass("active");
                    
                });




            });


            $('.selectpicker').change(function () {
                var selected = $(this).val();

            });

            if (readCookie('close_cookies_sec') == null) {
                $('div.cookies_sec').removeClass('hidden');
            }else{
				$('div.cookies_sec').addClass('hidden');
			}
            $("#close_cookies_sec").on("click", function () {
                createCookie('close_cookies_sec', '1', 1);
                $(".cookies_sec").addClass("animate__zoomOutDown");
            });

            $(document).ready(function () {

                var count = 1;

                function transition() {

                    if (count == 1) {
                        $(".mob_icons .icon_one").fadeOut();
                        $(".mob_icons .icon_three").fadeOut();
                        $(".mob_icons .icon_two").fadeIn();
                        count = 2;

                    } else if (count == 2) {
                        $(".mob_icons .icon_one").fadeOut();
                        $(".mob_icons .icon_two").fadeOut();
                        $(".mob_icons .icon_three").fadeIn();
                        count = 3;

                    } else if (count == 3) {
                        $(".mob_icons .icon_three").fadeOut();
                        $(".mob_icons .icon_two").fadeOut();
                        $(".mob_icons .icon_one").fadeIn();
                        count = 1;
                    }

                }
                setInterval(transition, 5000);



            });

            $("input[name=mobile]").keydown((function (e) {
                if (e.keyCode != 8 && e.keyCode != 107 && e.keyCode != 37 && e.keyCode != 39)
                    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105))
                        e.preventDefault();
            }));





$('#accordionLinks .panel-heading a').click(function(){


    ths = $(this);
    if($(this).hasClass('active')){
        setTimeout(function() {
        ths.removeClass('active');
        ths.closest('.panel').find('.panel-collapse').removeClass('show');
            }, 200);
    }else{
        setTimeout(function() {
        ths.addClass('active');
        ths.closest('.panel').find('.panel-collapse').addClass('show');
        }, 200);
    }

});


/*
	}else{
        setTimeout(waitForScriptsLoaded, 250);
    } 
}

waitForScriptsLoaded();*/

        </script>



        <?php $input_targetamp = Input::get("targetamp"); ?>

        <?php if (Route::currentRouteName() != 'front.search') { ?>
            <script type="application/ld+json">
                {
                "@context":"http://schema.org",
                "@type":"RealEstateAgent",
                "name":"{{$infos->name}}",
                "address":{
                "@type":"PostalAddress",
                "streetAddress":"{{$infos->address}}"
                },
                "image":"<?= asset('img/logo.png'); ?>",
                "email":"<?= $infos->email; ?>",
                "telePhone":"<?= $infos->tel_1; ?>",
                "geo":{
                "@type":"GeoCoordinates",
                "latitude":"<?= $infos->latitude; ?>",
                "longitude":"<?= $infos->longitude; ?>"
                },
                "priceRange": "$50000 - $2000000",



                "openingHours":"Mo-Sa 09:00-19:30",
                "url":"<?= url("/"); ?>","sameAs":["<?= $infos->facebook ?>","<?= $infos->twitter ?>","<?= $infos->gplus ?>","<?= $infos->linkedin ?>","<?= $infos->instagram ?>","<?= $infos->youtube ?>"],
                "contactPoint": [
                {   "@type": "ContactPoint",
                "telephone": "<?= $infos->tel_1; ?>",
                "contactType": "customer service",
                "areaServed": "Turkey",
                "availableLanguage": "Arabic,English,Turkish,French,farsi",
                "contactOption": "HearingImpairedSupported"
                }
                ]
                }
            </script>
        <?php } ?>
        @yield('schemaorg')
        <?php if (!App::isLocal()) { ?>
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
                }, 12000);
            </script>
        <?php } ?>
    </body>
</html>