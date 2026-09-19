<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr','ru']) ? 'en' : 'ar';
?>
<?php
$infos = Helper::get_params();
?>

@extends('front.layout', [
"page_title"        =>    ($tag->getSeoTitle() ? $tag->getSeoTitle() : $tag->getTitle()),
"page_description"  =>    $tag->getSeoDescription()
])
@section('main_content')

@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/searchpage.css"); ?>
    <?php if ($style_lang == "en") { ?>
        <?= Html::style("resources/assets/css/searchpage-en.css"); ?>
    <?php } ?>
<?php } else { ?>
        <?= Html::style("css/searchpage.min.css"); ?>
    <?php if ($style_lang == "en") { ?>
        <?= Html::style("css/searchpage-en.min.css"); ?>
    <?php } ?>
	<?php /*<style><?php include(public_path() . "/css/search-global" . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?></style>*/ ?>
<?php } ?>
@endsection



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">



        <!-- Start Fixed Section -->
        <div class="right_sec">


            <div class="fixed_sec">

                <section class="form fast_search search_filter shadow_type">
                    <h3 class="top_title jazzira_font_bold"><?= trans("front.Look for information"); ?></h3>

                    <form action="<?= route("front.searchpage"); ?>">
                        <div class="form-group">
                            <input class="form-control" name="s" placeholder="<?= trans("front.search"); ?>" value="{{ Input::get('s') }}" />
                            <button class="search_btn"><i class="fa fa-search"></i></button>
                        </div>
                    </form>

                </section>


                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>

            </div>
        </div>
        <!-- End Fixed Section -->



        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">
                <h1><?= $tag->getTitle(); ?> 
                    <div class="results_title">
                        <span class="jazzira_font"><?= trans("front.posts"); ?><strong class="num"><?= count($posts) ?></strong></span>
                    </div>
                </h1>




            </div>


            <div class="int_content">

                <div class="content_results sec">

@if(count($posts)==0)
	
<ul class="links_list">
	<li><a href="<?= route("front.index"); ?>" class="btn btn-default"> <?= trans("front.home"); ?></a></li>
	<li><a href="<?= route("front.turkish_citizenship"); ?>" class="btn btn-default"> <?= trans("front.TurkishCitizenship"); ?></a></li>
	<li><a href="<?= route("front.search", ["property-for-sale", "turkey"]) ?>" class="btn btn-default"> <?= trans("front.projects"); ?></a></li>
</ul>
@endif



					@foreach($posts as $p)
                    <?php
                    
                        $cardphoto = @$p->photoCard;
                        ?>
                        <div class="media sec">
                            <div class="media-left">
                                <a href="<?= route('front.blog.post', $p->slug); ?>" target="_blank">
                                    <img class="media-object" src="<?= Helper::get_thumbnail($cardphoto, 75, 75); ?>" alt="<?= $p->getTitle(); ?>">
                                </a>
                            </div>
                            <div class="search-info">
                                <h4 class="jazzira_font_bold"><a href="<?= route('front.blog.post', $p->slug); ?>" target="_blank"><?= $p->getTitle(); ?></a></h4>
                                <a class="num" href="<?= route('front.blog.post', $p->slug); ?>" target="_blank"><?= route('front.blog.post', $p->slug); ?></a>
                                <p class="jazzira_font"><?= Helper::str_limit($p->getContent(), 300); ?></p>
                            </div>
                        </div>
                    
                    @endforeach


                    <?php

                    //$cur_page = (Input::get("page") == null ? '1' : Input::get("page"));
                    ?>


                </div>

            </div>


<?php /*
            <div class="pagination_sec sec shadow_type">
                <span class="page_number"><?= $cnt_posts ?></span>

                <nav class="pagination_list" aria-label="Page navigation example">
                    <ul class="pagination justify-content-end num">
                        
						<?php if($cur_page > 1){ ?>
						<li class="page-item">
                            <a class="page-link" href="<?= '?s=' . Input::get('s') . '&page=' . ($cur_page - 1)  ?>"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M.279 4.33l4.1-4.054a.96.96 0 011.347 0 .942.942 0 010 1.338L3.319 3.992h7.677a1.027 1.027 0 011.015 1.016 1 1 0 01-1 1H3.324l2.4 2.375a.94.94 0 010 1.337.956.956 0 01-1.347 0l-4.1-4.054A.942.942 0 01.279 4.33z"></path></svg></a>
                        </li>
						<?php } ?>
						
						<?php
						
						for ($i = 1; $i <= $nbre_page; $i++) {
							
						$link_limit = 7;
						$half_total_links = floor($link_limit / 2);
						$from = $cur_page - $half_total_links;
						$to = $cur_page + $half_total_links;
						if ($cur_page < $half_total_links) {
						   $to += $half_total_links - $cur_page;
						}
						if ($nbre_page - $cur_page < $half_total_links) {
							$from -= $half_total_links - ($nbre_page - $cur_page) - 1;
						}
						if ($from < $i && $i < $to){
						?>
                        <li class="page-item <?= $cur_page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?s={{ Input::get('s') }}&page=<?= $i ?>"><?= $i ?></a>
                        </li>
						<?php } 
						} ?>

						<?php if($cur_page < $nbre_page){ ?>
                        <li class="page-item">
                            <a class="page-link" href="<?= '?s=' . Input::get('s') . '&page=' . ($cur_page + 1) ?>" ><svg xmlns="http://www.w3.org/2000/svg" width="12" height="10" viewBox="0 0 12 10"><path data-name="Forma 1 copy 5" fill-rule="evenodd" d="M11.721 5.67l-4.1 4.054a.96.96 0 01-1.347 0 .942.942 0 010-1.338l2.407-2.378H1.004A1.027 1.027 0 01-.007 5a1 1 0 011-1H8.68l-2.4-2.375a.94.94 0 010-1.337.956.956 0 011.347 0l4.1 4.054a.942.942 0 01-.006 1.328z"></path></svg></a>
                        </li>
						<?php } ?>
                    </ul>
                </nav>
            </div>
*/ ?>

        </div>
        <!-- End Left Section -->






    </div>
</div>




@endsection


@section('scriptjs')
<input type="hidden" value="0" id="scrollv"/>
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
</script>

@endsection