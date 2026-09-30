<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();

if ($type == 'news')
    $params = Helper::query("BlogParam", "find", ["id" => 2]);
else
    $params = \App\Models\BlogParam::forCountry(isset($countryModel) ? $countryModel : (isset($countryCode) ? $countryCode : 'turkey'));
$is_mobile = Helper::get_device() != 'full' ? true : false;
/* $arr_prices = [
  "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
  ]; */
$right = ($style_lang == 'ar' ? 'right' : 'left');
$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
//$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/blog.css"); ?>
    <?php if ($current_lang == 'en') { ?>

    <?php } ?>


    <style>

    </style>

<?php } else { ?>

    <?php // echo Html::style("/css/index" . (Helper::get_device() != 'full' ? '-mob' : '') . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?>
    <?= Html::style("css/slider-project-card.min.css"); ?>
    <?= Html::style("css/blog.min.css"); ?>

<?php } ?>



@endsection



@extends('front.layout', [
"page_title" => ($is_category_page==false?$params->getSeoTitle():($category->getSeoTitle() ?  $category->getSeoTitle() : $category->getName())),
"page_description" => ($is_category_page==false?$params->getSeoDescription():$category->getSeoDescription()),
"page_keywords" => ($is_category_page==false?$params->getSeoKeywords():$category->getSeoKeywords()),
"amp_url"    =>   route("amp.front.blog")
])




@section('main_content')

<style>
    .top_control_sec h1 span.blog-title-span {
        font-size: inherit;
        color: inherit;
        margin: 0;
        display: inline;
        font-weight: 700;
    }
</style>

<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">

                <div class="type_full">
                    <?php //if (Helper::get_device() == 'full') { ?>
                        <h1 class="jazzira_font_bold">
                            <?= trans("front.".$type); ?> <span class="num blog-title-span" display:"inline !important">({{ $posts->total() }})</span> 
                        </h1>
                        <!--<p><span><?= trans("front.search results"); ?></span> </p>-->
                    <?php //} ?>

                </div>
                <?php /*
                  <!--                <section class="form fast_search sort_filter">
                  <div class="form-group">
                  <select class="selectpicker form-control" name="sort" title="<?= trans("front.Sort by"); ?>"  onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                  <option value="?sort=recent" <?= (isset($_GET['sort']) && $_GET['sort'] == 'recent') ? 'selected' : '' ?>><?= trans("front.Sort by"); ?></option>
                  <option value="?sort=recent" <?= (isset($_GET['sort']) && $_GET['sort'] == 'recent') ? 'selected' : '' ?>><?= trans("front.recent"); ?></option>
                  <option value="?sort=oldest" <?= (isset($_GET['sort']) && $_GET['sort'] == 'oldest') ? 'selected' : '' ?>><?= trans("front.oldest"); ?></option>
                  <option value="?sort=az" <?= (isset($_GET['sort']) && $_GET['sort'] == 'az') ? 'selected="selected"' : '' ?>><?= trans("front.a to z"); ?></option>
                  <option value="?sort=za" <?= (isset($_GET['sort']) && $_GET['sort'] == 'za') ? 'selected' : '' ?>><?= trans("front.z to a"); ?></option>
                  </select>
                  </div>
                  </section>--> */ ?>



                <div class="categories_sec mob">
                    <ul>
                        <?php
                        foreach ($categories as $cat) {
                            if (isset($slug) and $slug == $cat->slug) {
                                ?>
                                <li class="active">
                                    <a href="<?= $cat->listingUrl() ?>"><?= $cat->getName() ?></a>
                                </li>
                                <?php
                            }
                        }
                        ?>

                        <?php
                        foreach ($categories as $cat) {
                            if (isset($slug) and $slug == $cat->slug) {
                                
                            } else {
                                ?>
                                <li>
                                    <a href="<?= $cat->listingUrl() ?>"><?= $cat->getName() ?></a>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </div>


            </div>


            <div class="int_content">

                <?php //if (Helper::get_device() != 'full') { ?>
                <!--    <h1 class="jazzira_font_bold page_title_mob d-block d-md-none d-lg-none">-->
                <!--        <?php if ($is_category_page == false) { ?>-->
                <!--            <?= $type == 'news' ? trans("front.news") : trans("front.blog"); ?> -->
                <!--        <?php } else { ?>-->
                <!--            <?= $category->getName() ?>-->
                <!--        <?php } ?>-->
                <!--        <strong class="num">({{ $posts->total() }})</strong>-->
                <!--    </h1>-->
                <!-- THIS IS WHERE THE OLD H1 WAS -->
                <?php //} ?>
                
                
                <?php //if (Helper::get_device() != 'full') { ?>
                    <h1 class="jazzira_font_bold page_title_mob d-block d-md-none d-lg-none" style="font-size: 1.5em">
                        أدلة التملك <b class="num" display:"inline !important">({{ $posts->total() }})</b> 
                    </h1>
                    <!--<p><span><?= trans("front.search results"); ?></span> </p>-->
                <?php //} ?>
                


                <ul class="blog_catd_sec">
                    @include("front.blog.partials.list_posts",['posts'=>$posts,'type'=>$type])
                </ul>



            </div>

            <?php /* ?>
              @if ($posts->lastPage() > 1)
              <div class="pagination_sec sec shadow_type">
              <span class="page_number"><?= $posts->currentPage() ?> of {{ $posts->lastPage() }}</span>

              <nav class="pagination_list" aria-label="Page navigation example">

              <ul class="pagination justify-content-end num">
              <li class="page-item {{ ($posts->currentPage() == 1) ? ' disabled' : '' }}">
              <a class="page-link" href="{{ $posts->url(1) }}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M.279 4.33l4.1-4.054a.96.96 0 011.347 0 .942.942 0 010 1.338L3.319 3.992h7.677a1.027 1.027 0 011.015 1.016 1 1 0 01-1 1H3.324l2.4 2.375a.94.94 0 010 1.337.956.956 0 01-1.347 0l-4.1-4.054A.942.942 0 01.279 4.33z"></path></svg></a>
              </li>
              @for ($i = 1; $i <= $posts->lastPage(); $i++)
              <?php
              $link_limit = 7;
              $half_total_links = floor($link_limit / 2);
              $from = $posts->currentPage() - $half_total_links;
              $to = $posts->currentPage() + $half_total_links;
              if ($posts->currentPage() < $half_total_links) {
              $to += $half_total_links - $posts->currentPage();
              }
              if ($posts->lastPage() - $posts->currentPage() < $half_total_links) {
              $from -= $half_total_links - ($posts->lastPage() - $posts->currentPage()) - 1;
              }
              ?>
              @if ($from < $i && $i < $to)
              <li class="page-item {{ ($posts->currentPage() == $i) ? ' active' : '' }}">
              <a class="page-link" href="{{ $posts->url($i) }}">{{ $i }}</a>
              </li>
              @endif
              @endfor
              <li class="page-item {{ ($posts->currentPage() == $posts->lastPage()) ? ' disabled' : '' }}">
              <a class="page-link" href="{{ $posts->url($posts->currentPage()+1) }}" ><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M11.721 5.67l-4.1 4.054a.96.96 0 01-1.347 0 .942.942 0 010-1.338l2.407-2.378H1.004A1.027 1.027 0 01-.007 5a1 1 0 011-1H8.68l-2.4-2.375a.94.94 0 010-1.337.956.956 0 011.347 0l4.1 4.054a.942.942 0 01-.006 1.328z"></path></svg></a>
              </li>
              </ul>


              </nav>
              </div>
              @endif
              <?php */ ?>
        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div id="fixed_sec" class="fixed_sec">

<!--<section class="form fast_search search_filter shadow_type">-->

                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed",['type'=>$type, 'hide_whatsapp'=>$hide_whatsapp])
                </section>

                @include("front.partials.blog_filter",['type'=>$type])
                <!--</section>-->


            </div>
        </div>
        <!-- End Fixed Section -->



    </div>
</div>





@endsection



@section('scriptjs')





<script>
    $(document).ready(function () {

        var old_href = '';
        $(window).scroll(function () {
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - ($('footer').height() + 200)) {

                $('.load_more').click();
            }
        });
        $(document).on('click', '.load_more', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');

            if (old_href != href) {
                old_href = href;
                url = href + "&ajax=1";
                $.ajax({
                    url: url,
                }).done(function (resp) {
                    if ($.trim(resp).indexOf("image_cont") !== -1) {
                    window.history.pushState("", "", href);
                    
                    $('ul.blog_catd_sec li:last-child').remove();
                    $('ul.blog_catd_sec').append(resp);
                    }
                }).fail(function () {

                });
            }
        });
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
<?php if ($type == 'news') { ?>
            $('.main_menu .links>li>a.news_btn').addClass("active");
<?php } else { ?>
            $('.main_menu .links>li>a.blog_btn').addClass("active");
<?php } ?>

    });

    var startScroll = 150;
    var supportLinks = $(".support_links");
    var oldsctop = $(window).scrollTop();
    $(window).scroll(function () {

        /*console.log('old' + oldsctop + ' ----new: '+ $(this).scrollTop());*/
        if (($(this).scrollTop()) > oldsctop) {
            $(".top_control_sec").addClass("scrollMob");
        } else {
            $(".top_control_sec").removeClass("scrollMob");
        }
        oldsctop = $(this).scrollTop();
    });




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
//                window.location.href = "/video";
//            } else {
//                /* alert("right swipe"); */
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
@if($is_category_page==false)
<script type="application/ld+json">
    {"@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[

    {"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
    {"@type":"ListItem","position":2,"name":"{{ trans("front.".$type) }}","item":"{{ isset($listingUrl) ? $listingUrl : route($type == 'news' ? 'front.news' : ($type == 'developer' ? 'front.developer.index' : ($type == 'report' ? 'front.report.index' : 'front.blog.index'))) }}"}

    ]}
</script>

@else

<script type="application/ld+json">
    {"@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[

    {"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
    <?php if (in_array($category->id, [1, 7])) {//investment; economic affaire  ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.turkey investment') }}","item":"{{ route('front.investment') }}"},
        {"@type":"ListItem","position":4,"name":"{{ @$category->getName() }}","item":"{{ $category->listingUrl() }}"}
    <?php } elseif (in_array($category->id, [4])) {//Daily living in Turkey  ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.living turkey') }}","item":"{{ route('front.living_turkey') }}"},
        {"@type":"ListItem","position":4,"name":"{{ @$category->getName() }}","item":"{{ $category->listingUrl() }}"}
    <?php } elseif (in_array($category->id, [6, 3])) {//turksih district ; monument tourism turkey   ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.istanbul districts') }}","item":"{{ route('front.districts','istanbul') }}"},
        {"@type":"ListItem","position":4,"name":"{{ @$category->getName() }}","item":"{{ $category->listingUrl() }}"}
    <?php } elseif (in_array($category->id, [8])) {//turkish citizenship  ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.turkish citizenship') }}","item":"{{ route('front.turkish_citizenship') }}"},
        {"@type":"ListItem","position":4,"name":"{{ @$category->getName() }}","item":"{{ $category->listingUrl() }}"}
    <?php } elseif (in_array($category->id, [12])) {//taxes  ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.legal affairs turkey') }}","item":"{{ route('front.legal') }}"},
        {"@type":"ListItem","position":4,"name":"{{ @$category->getName() }}","item":"{{ $category->listingUrl() }}"}
    <?php } else { ?>
        {"@type":"ListItem","position":2,"name":"{{ trans("front.".$type) }}","item":"{{ isset($listingUrl) ? $listingUrl : route($type == 'news' ? 'front.news' : ($type == 'developer' ? 'front.developer.index' : ($type == 'report' ? 'front.report.index' : 'front.blog.index'))) }}"},
        {"@type":"ListItem","position":3,"name":"{{ @$category->getName() }}","item":"{{ $category->listingUrl() }}"}
    <?php } ?>
    ]}
</script>
@endif

@endsection