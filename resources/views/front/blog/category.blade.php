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
//$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/blog.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?php if ($current_lang == 'en') { ?>

    <?php } ?>


    <style>

    </style>

<?php } else { ?>

    <?= Html::style("/css/blog.min.css"); ?>
    <?= Html::style("/css/slider-project-card.min.css"); ?>

<?php } ?>



@endsection



@extends('front.layout', [
    "page_title" =>  $category->getSeoTitle() ?  $category->getSeoTitle() : $category->getName(),
    "page_description" => $category->getSeoDescription(),
    "page_keywords" => $category->getSeoKeywords(),
])




@section('main_content')


 @include("front.blog.results")





@endsection



@section('scriptjs')



<?php if (Helper::get_device() != 'mob') { ?>
    <script>





    </script>
<?php } ?>


<script>
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
        <?php
		if($type=='news'){ ?>
		$('.main_menu .links>li>a.news_btn').addClass("active");
		<?php }else{ ?>
		$('.main_menu .links>li>a.blog_btn').addClass("active");
		<?php } ?>




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
<?php /*
<script type="application/ld+json">
{"@context":"http://schema.org",
"@type":"BreadcrumbList",
"itemListElement":[

{"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
<?php if(in_array($category->id,[1,7])){//investment; economic affaire ?>
	{"@type":"ListItem","position":2,"name":"{{ trnas('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trnas('front.turkey investment') }}","item":"{{ route('front.investment') }}"}
<?php }elseif(in_array($category->id,[4])){//Daily living in Turkey ?>
	{"@type":"ListItem","position":2,"name":"{{ trnas('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trnas('front.living turkey') }}","item":"{{ route('front.living_turkey') }}"}
<?php }elseif(in_array($category->id,[6,3])){//turksih district ; monument tourism turkey  ?>
	{"@type":"ListItem","position":2,"name":"{{ trnas('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trnas('front.istanbul districts') }}","item":"{{ route('front.districts','istanbul') }}"}
<?php }elseif(in_array($category->id,[8])){//turkish citizenship ?>
	{"@type":"ListItem","position":2,"name":"{{ trnas('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trnas('front.turkish citizenship') }}","item":"{{ route('front.turkish_citizenship') }}"}
<?php }elseif(in_array($category->id,[12])){//taxes ?>
	{"@type":"ListItem","position":2,"name":"{{ trnas('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trnas('front.legal affairs turkey') }}","item":"{{ route('front.legal') }}"}
<?php }else{ ?>
{"@type":"ListItem","position":2,"name":"{{ trans("front.".$type) }}","item":"{{ route("front.".$type) }}"},
{"@type":"ListItem","position":3,"name":"{{ @$category->getName() }}","item":"{{ route("front.".$type.".category", @$category->slug) }}"}
<?php } ?>
]}
</script>*/ ?>
@endsection