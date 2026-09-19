<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr','ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;

$right = ($style_lang == 'ar' ? 'right' : 'left');
//$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
//$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/blog.css"); ?>
    <?= Html::style("resources/assets/css/faq.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?php if ($current_lang == 'en') { ?>

    <?php } ?>


    <style>

    </style>

<?php } else { ?>

  <?= Html::style("css/faq.min.css"); ?>

<?php } ?>


@endsection





@extends('front.layout', [
"page_title"        =>    ($page->getSeoTitle() ? $page->getSeoTitle() : $page->name),
"page_description"  =>    $page->getSeoDescription(),
"page_keywords"     =>    $page->getSeoKeywords(),
"og_image"          =>    ($page->media?Helper::media_url_full($page->media):null),
"page_index" => "noindex, follow"
/*"amp_url"           =>    route("amp.front.faq")*/
])


@section('main_content')



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">

                <div class="type_full">
                    <h1 class="jazzira_font_bold"><?= trans("front.faq title"); ?></h1>
                    <p><span><?= trans("front.search results"); ?></span> <strong class="num">{{ $posts->total() }}</strong></p>
                </div>


                <?php //if (Helper::get_device() != 'full') { ?>
                    <div class="categories_sec mob">
                        <ul>
                            <?php
                            $faqposts = App\Models\Faqpost::orderBy('placement', 'asc')->get();
                            foreach ($faqposts as $f) {
                                ?>
                                <li>
                                    <a href="{{ route('front.faq_show',$f->slug) }}"><?= $f->getTitle() ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php //} ?>



            </div>


            <div class="int_content">

                <section class="faq-section shadow_type">

                    <div class="row">
                        <!-- ***** FAQ Start ***** -->

                        <div class="col-md-12">
                            <div class="faq" id="accordion">
                                <?php
                                //$rows = DB::select("select * from dms_faq order by id asc");

                                /* print_r($rows);
                                  echo $rows[0]->q_ar;
                                  exit; */
                                $i = ($posts->currentPage() - 1) * 10;
                                foreach ($posts as $rx) {
                                    $i++;
                                    $q = 'q_' . ($current_lang=='pe'?'fa':$current_lang);
                                    $res = 'r_' . ($current_lang=='pe'?'fa':$current_lang);
									
                                    if (trim($rx->$q) != '') {
                                        ?>
                                        <div class="card">
                                            <div class="card-header" id="faqHeading-<?= $i ?>">
                                                <div class="mb-0">
                                                    <h5 class="faq-title jazzira_font_bold" data-toggle="collapse" data-target="#faqCollapse-<?= $i ?>" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
                                                        <i class="arrow"></i>
                                                        <span class="num"><?= $i ?></span>
                                                        <?= $rx->$q ?>
                                                    </h5>
                                                </div>
                                            </div>
                                            <div id="faqCollapse-<?= $i ?>" class="collapse" aria-labelledby="faqHeading-<?= $i ?>" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p>
                                                        <?= $rx->$res ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>







                        </div>
                    </div>

                </section>

            </div>
            <div class="pagination_sec sec shadow_type">
                <span class="page_number"><?= $posts->currentPage() ?> of {{ $posts->lastPage() }}</span>

                <nav class="pagination_list" aria-label="Page navigation example">


                    <?php
                    ?>

                    @if ($posts->lastPage() > 1)
                    <ul class="pagination justify-content-end num">
                        <li class="page-item {{ ($posts->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $posts->url(1) }}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M.279 4.33l4.1-4.054a.96.96 0 011.347 0 .942.942 0 010 1.338L3.319 3.992h7.677a1.027 1.027 0 011.015 1.016 1 1 0 01-1 1H3.324l2.4 2.375a.94.94 0 010 1.337.956.956 0 01-1.347 0l-4.1-4.054A.942.942 0 01.279 4.33z"></path></svg></a>
                        </li>
                        @for ($i = 1; $i <= $posts->lastPage(); $i++)
                        <?php
                        $link_limit = 6;
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
                    @endif


                </nav>
            </div>

        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">

            <a class="close_filter_btn">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 211.4 218.9" xml:space="preserve"><g> <path class="st0" d="M628.8-7.9c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8c-22.4-27.7-45-55.3-67.6-82.9c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7c1.4-6.3,7.1-10.8,14.4-10.8 C565.2-7.9,597-7.9,628.8-7.9z M714.5,21c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3c21.2,26.1,42.5,52.2,63.9,78.2 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C674.2,70,694.2,45.9,714.5,21z M609.7,110.9 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C633.2,110.9,621.6,110.9,609.7,110.9z M628.8-0.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C690.5-0.2,659.7-0.2,628.8-0.2z"/> </g> <path class="st0" d="M7.6,128.7L87.9,209c10.2,10.2,26.7,10.2,36.9,0c10.2-10.2,10.2-26.8,0-37l-31.3-31.4l86.3,0 c16.3,0,29.5-11.5,29.5-27.9c0-16.3-13.2-27.9-29.5-27.9l-90.9,0l35.9-37.5c10.2-10.2,10.2-27.5,0-37.7C114.7-0.5,98.1-0.9,87.9,9.3 L7.6,89.4C2.2,94.8-0.3,101.9,0,109C-0.3,116.1,2.2,123.2,7.6,128.7z"/> </svg>
            </a>
            <a id="outMenu" class="out_filter_btn"></a>

            <div id="fixed_sec" class="fixed_sec">




                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>



                @include("front.partials.faq_categories")



            </div>
        </div>
        <!-- End Fixed Section -->



    </div>
</div>





@endsection



@section('scriptjs')
<?= Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"); ?>




<script>
$(document).ready(function () {
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



        $('.main_menu .links>li>a.faq_btn').addClass("active");

        if ($(window).width() <= 812) {
            outMenu = document.getElementById('outMenu');
            var fixeSecdHeight = $(".fixed_sec").height();
            setTimeout(function () {
                outMenu.setAttribute("style", "height: calc(100% - " + fixeSecdHeight + "px)");
                $("#outMenu").css("top", fixeSecdHeight);
            }, 1000);

            $("#outMenu").on("click", function () {
                $(".close_filter_btn").trigger("click");
            });
        }




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
    





    $('.faq .collapse').on('show.bs.collapse', function () {
        var card = $(this).closest(".card");
        var cardHeader = $(this).closest(".card").find(".card-header");
        $(".card-header").removeClass("active");
        $(".faq .card").removeClass("active");
        $(cardHeader).addClass("active");
        $(card).addClass("active");

        $('html,body').animate({
            scrollTop: card.offset().top - 100
        }, 500);


    });

    $('.faq .collapse').on('hide.bs.collapse', function () {
        var card = $(this).closest(".card");
        var cardHeader = $(this).closest(".card").find(".card-header");
        $(cardHeader).removeClass("active");
        $(card).removeClass("active");
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
<script type="application/ld+json">
	{
	"@context": "https://schema.org",
	"@type": "FAQPage",
	"mainEntity": [
	<?php
		$curent_lang = ($current_lang=='pe'?'fa':$current_lang);
		$qs = 'q_' . $curent_lang;
		$rs = 'r_' . $curent_lang;
		$nat_posts = \App\Models\Faq::where($qs,'!=','')->where($rs,'!=','')->where('faq_post','1')->orderBy($qs,"asc")->limit(6)->get();
	$i = 0;
	foreach ($nat_posts as $r) {
		$i++;
		$q = 'q_' . ($current_lang=='pe'?'fa':$current_lang);
		$res = 'r_' . ($current_lang=='pe'?'fa':$current_lang);
		if (trim($r->$q) != '') {
	if($i>1)
	echo ',';
	?>
	
	{"@type": "Question",
	"name": " <?= htmlentities($r->$q) ?>",
	"acceptedAnswer": {"@type": "Answer","text": "<?= htmlentities($r->$res) ?>"}}
	<?php }} ?>
]}
</script>
@endsection