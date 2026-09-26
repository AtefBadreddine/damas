<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
$arr_prices = [
    "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
];
$right = ($style_lang == 'ar' ? 'right' : 'left');
$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
//$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>


    <!-- demo styles -->
    <?= Html::style("resources/assets/css/style-zuck.css"); ?>

    <!-- lib styles -->
    <?= Html::style("resources/assets/css/zuck.min.css"); ?>

    <!-- lib skins -->
    <?= Html::style("resources/assets/css/snapgram.css"); ?>
    <?= Html::style("resources/assets/css/vemdezap.css"); ?>
    <?= Html::style("resources/assets/css/facesnap.css"); ?>
    <?= Html::style("resources/assets/css/snapssenger.css"); ?>


    <?= Html::style("resources/assets/css/stories.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    

<?php } else { ?>

    <?php // echo Html::style("/css/index" . (Helper::get_device() != 'full' ? '-mob' : '') . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?>
    <style>
    <?php include(public_path() . "/css/stories.min.css"); ?>
    </style>

<?php } ?>


@endsection



@extends('front.layout', [
"page_title"        =>    'Stories',
'hide_onesignal'=>true,
"page_description" => $infos->seo_description,
"page_keywords" => $infos->seo_keywords,
"og_image"          =>   Helper::media_mob(Helper::query("Media", "find", ["id" => $infos->index_og_pic]))
])




@section('main_content')

<style>

</style>

<div id="whatsapp_story">
<a class="jazzira_font_bold" href="#">
	
        <img src="<?= asset("/img/whatsapp-btn-$current_lang.svg"); ?>"  alt="whatsapp" title="<?= trans("front.offers Inquire"); ?>"/>
	</a>
</div>

<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">
                <h1 class="jazzira_font_bold"><?= trans("front.offers"); ?> </h1>

            </div>


            <div class="int_content">

                <div class="offers_sec sec">



<div id="stories" class="storiesWrapper">

    
	
	
    
        </div>
        </div>
        </div>
        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div id="fixed_sec" class="fixed_sec">




                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>


                <!-- About Us -->
                @include("front.partials.about_sec", [])


            </div>
        </div>
        <!-- End Fixed Section -->



    </div>
</div>





@endsection



@section('scriptjs')

<?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/js/bootstrap.min.js"); ?>

<?php if (App::isLocal()) { ?>
<?= Html::script("resources/assets/js/zuck.min.js"); ?>
<?= Html::script("resources/assets/js/script-zuck.js"); ?>
<?php }else{ ?>
<?= Html::script("js/zuck.min.js"); ?>
<?= Html::script("js/script-zuck.min.js"); ?>
<?php } ?>



<script>
<?php
/*$mp4 = [
'http://www.papytane.com/mp4/accrobra.mp4',
'http://www.papytane.com/mp4/montgolf.mp4',
'http://www.papytane.com/mp4/sapins.mp4',
'http://www.papytane.com/mp4/boiteame.mp4',
'http://www.papytane.com/mp4/paris.mp4',
'http://www.papytane.com/mp4/edelweis.mp4',
'http://www.papytane.com/mp4/thefroze.mp4',
'http://www.papytane.com/mp4/barbizon.mp4',
'http://www.papytane.com/mp4/untraine.mp4',
'http://www.papytane.com/mp4/noel2012.mp4',
'http://www.papytane.com/mp4/silentni.mp4',
'http://www.papytane.com/mp4/lesavent.mp4',
'http://www.papytane.com/mp4/sapins.mp4',
'http://www.papytane.com/mp4/starwars.mp4',
];
$j=0;*/

 
?>
function add_whatsapp(storyId){
	$('#whatsapp_story').show();
	$('#whatsapp_story a').attr('href',"https://api.whatsapp.com/send?phone=905551605000&text="+ encodeURI("{{ route('front.stories',['islug']) }}".replace('islug',storyId).replace("/story/story","/story")));

window.history.pushState("", "", "{{ route('front.stories',['islug']) }}".replace('islug',storyId).replace("/story/story","/story"));
}
    var currentSkin = getCurrentSkin();
    let stories = new Zuck('stories', {
        backNative: false,
        previousTap: true,
        skin: currentSkin['name'],
        autoFullScreen: currentSkin['params']['autoFullScreen'],
        avatars: currentSkin['params']['avatars'],
        paginationArrows: false,
        list: currentSkin['params']['list'],
        cubeEffect: false,
        localStorage: true,
		/*rtl:{{ $style_lang=='ar'?'true':'false' }},*/
		
		
        stories: [
		<?php
			foreach($stories as $s){
				$files = [];
				if($s->file1!='' && in_array($s->lang1,[$current_lang,'all']))
					$files[] = $s->file1;
				if($s->file2!='' && in_array($s->lang2,[$current_lang,'all']))
					$files[] = $s->file2;
				if($s->file3!='' && in_array($s->lang3,[$current_lang,'all']))
					$files[] = $s->file3;
				if($s->file4!='' && in_array($s->lang4,[$current_lang,'all']))
					$files[] = $s->file4;
				if($s->file5!='' && in_array($s->lang5,[$current_lang,'all']))
					$files[] = $s->file5;
					
					if(empty($files))
					continue;
	
				if (strpos($files[0], '.mp4') !== false) {
					$cardphoto = asset(Helper::get_thumbnail(@$s->project->cardphoto, 327, 370));
				}else{
					$cardphoto = "https://damas.net/stories/".$files[0];
				}
				?>
            Zuck.buildTimelineItem(
                    "story/{{ $s->id }}",
                    "<?= $cardphoto ?>",
                    "{{ $s->getTitle() }}",
                    "story/{{ $s->id }}",
                    '{{ strtotime($s->updated_at) }}',/*e{{ $s->updated_at }}*/
                    [
                        <?php
						$i=0;
						foreach($files as $f){ 
						if (strpos($f, '.mp4') !== false) { ?>
							["ramon-{{ $i }}", "video", {{ $i }}, 
							"https://damas.net/stories/{{ $f }}",
							"<?= $cardphoto ?>", '', false, false, {{ strtotime($s->updated_at) }}],
						<?php $i++; }else{ ?>
							["ramon-{{ $i }}", "photo", {{ $i }}, 
							"https://damas.net/stories/{{ $f }}",
							"https://damas.net/stories/{{ $f }}", '', false, false, {{ strtotime($s->updated_at) }}],
						<?php }} ?>
                    ]
					
					
					
					
					
                    ),
					
		<?php } ?>
            
        ],
	callbacks: {
		/**/onOpen (storyId, callback) {
			
			add_whatsapp(storyId);
			callback();
		},
		onView (storyId) {
			/*alert("{{ route('front.stories',['islug']) }}".replace('?islug', '/' + slug).replace('islug', storyId));*/
			add_whatsapp(storyId);
			/*window.history.pushState("", "", "{{ route('front.stories',['islug']) }}".replace('?islug', '/' + slug).replace('islug', storyId));*/
		},
		onNavigateItem (storyId, nextStoryId, callback) {
			add_whatsapp(storyId);
			callback();  
		},
		onClose (storyId, callback) {
			$('#whatsapp_story').hide();
			callback();
		}
    }
	
	
	
	
					
				/*	,


  language: { // if you need to translate :)
    unmute: 'Touch to unmute',
    keyboardTip: 'Press space to see next',
    visitLink: 'Visit link',
    time: {
      ago:'ago', 
      hour:'hour', 
      hours:'hours', 
      minute:'minute', 
      minutes:'minutes', 
      fromnow: 'from now', 
      seconds:'seconds', 
      yesterday: 'yesterday', 
      tomorrow: 'tomorrow', 
      days:'days'
    }
  }*/
  
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

<?php if (isset($slug) && $slug != '') { ?>
            $('body').find("[href='story/<?= $slug ?>']").click();
<?php } ?>

        $('.content.shadow_type').click(function () {
            slug = $(this).data('slug');
            window.history.pushState("", "", "{{ route('front.stories',['islug']) }}".replace('?islug', '/' + slug).replace('islug', slug));
        });


        $('.main_menu .links>li>a.offers_btn').addClass("active");




        /**-- Open Filter Menu --**/
        $("body").on("click", ".filter_btn", function () {
            $(".right_sec").addClass("show");
            $("body").css("overflow-y", "hidden");
        });

        /**-- Close Filter Menu --**/
        $("body").on("click", ".close_filter_btn", function () {
            $(".right_sec").removeClass("show");
            $("body").css("overflow-y", "auto");
        });
    });





    $('.collapse').on('show.bs.collapse', function () {
        var cardHeader = $(this).closest(".card").find(".card-header");
        $(".card-header").removeClass("active");
        $(cardHeader).addClass("active");
    });

    $('.collapse').on('hide.bs.collapse', function () {
        var cardHeader = $(this).closest(".card").find(".card-header");
        $(cardHeader).removeClass("active");
    });

    $(document).on("click", ".offers_cont", function () {
        var thisSlider = $(this).find(".offer_slider");
        $(thisSlider).addClass("open");
    });

    $(document).on("click", ".close_slider", function () {
        var thisSlider = $(this).closest(".offer_slider");
        setTimeout(function () {
            $(thisSlider).removeClass("open");
        }, 100);
        window.history.pushState("", "", "{{ route('front.stories',['']) }}");
    });



    $('.carousel').carousel({
        interval: 6000,
        pause: "false"
    });
    
    




//
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
//                window.location.href = "/property-for-sale/turkey";
//            } else {
//                /* alert("right swipe"); */
//                window.location.href = "/video";
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

@endsection