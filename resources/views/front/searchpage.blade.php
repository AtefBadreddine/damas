<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr','ru']) ? 'en' : 'ar';
?>
<?php
$infos = Helper::get_params();
?>

@extends('front.layout', [
"page_title" => trans("front.search results")
,"page_index"    =>    "noindex, follow"
])
@section('main_content')

@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/searchpage.css"); ?>
    <?php if ($current_lang == "en" || $current_lang == "fr" || $current_lang == "ru") { ?>
        <?= Html::style("resources/assets/css/searchpage-en.css"); ?>
    <?php } ?>
<?php } else { ?>
        <?= Html::style("css/searchpage.min.css"); ?>
    <?php if ($current_lang == "en" || $current_lang == "fr" || $current_lang == "ru") { ?>
        <?= Html::style("css/searchpage-en.min.css"); ?>
    <?php } ?>
	<?php /*<style><?php include(public_path() . "/css/search-global" . ($style_lang == 'en' ? '-en' : '') . ".min.css"); ?></style>*/ ?>
<?php } ?>
@endsection



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">



        <!-- Start Fixed Section -->
        <div class="right_sec">
<!--            <a class="close_filter_btn">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 211.4 218.9" xml:space="preserve"><g> <path class="st0" d="M628.8-7.9c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8c-22.4-27.7-45-55.3-67.6-82.9c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7c1.4-6.3,7.1-10.8,14.4-10.8 C565.2-7.9,597-7.9,628.8-7.9z M714.5,21c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3c21.2,26.1,42.5,52.2,63.9,78.2 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C674.2,70,694.2,45.9,714.5,21z M609.7,110.9 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C633.2,110.9,621.6,110.9,609.7,110.9z M628.8-0.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C690.5-0.2,659.7-0.2,628.8-0.2z"/> </g> <path class="st0" d="M7.6,128.7L87.9,209c10.2,10.2,26.7,10.2,36.9,0c10.2-10.2,10.2-26.8,0-37l-31.3-31.4l86.3,0 c16.3,0,29.5-11.5,29.5-27.9c0-16.3-13.2-27.9-29.5-27.9l-90.9,0l35.9-37.5c10.2-10.2,10.2-27.5,0-37.7C114.7-0.5,98.1-0.9,87.9,9.3 L7.6,89.4C2.2,94.8-0.3,101.9,0,109C-0.3,116.1,2.2,123.2,7.6,128.7z"/> </svg>
            </a>-->

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
                <h1><?= trans("front.search results"); ?> 
                    <div class="results_title">
                        <?php if ($cnt_projects > 0) { ?>
                            <span class="jazzira_font"><?= trans("front.projects"); ?><strong class="num"><?= $cnt_projects ?></strong></span>
                        <?php } ?>
                        <span class="jazzira_font"><?= trans("front.posts"); ?><strong class="num"><?= $cnt_posts ?></strong></span>
                    </div>
                </h1>




            </div>


            <div class="int_content">

                <div class="content_results sec">

@if(count($data)==0)
	
<ul class="links_list">
	<li><a href="<?= route("front.index"); ?>" class="btn btn-default"> <?= trans("front.home"); ?></a></li>
	<li><a href="<?= route("front.turkish_citizenship"); ?>" class="btn btn-default"> <?= trans("front.TurkishCitizenship"); ?></a></li>
	<li><a href="<?= route("front.search", ["property-for-sale", "turkey"]) ?>" class="btn btn-default"> <?= trans("front.projects"); ?></a></li>
</ul>



@endif
                    @foreach($data as $p)
                    <?php
                    if ($p->datattype == 'project') {
                        $cardphoto = @$p->cardphoto;
                        ?>
                        <div class="media sec">
                            <div class="media-left">
                                <a href="<?= $p->frontUrl(); ?>" target="_blank">
                                    <img class="media-object" src="<?= Helper::get_thumbnail($cardphoto, 75, 75); ?>" alt="<?= $p->getName(); ?>">
                                </a>
                            </div>
                            <div class="search-info">
                                <h4 class="jazzira_font_bold">
                                    <a href="<?= $p->frontUrl(); ?>" target="_blank"><?php
                                        //if(strlen($p->getName())>11)
                                        //echo $p->getName();
                                        ?>

                                        <?= trans('front.residance') ?> <?= @$p->getNameEn(); ?> <?= trans("front.in"); ?> <?= @$p->city->getName(); ?>

                                    </a>
                                </h4>
                                <a class="num" href="<?= $p->frontUrl(); ?>" target="_blank"><?= $p->frontUrl(); ?></a>
                                <p class="jazzira_font"><?= $p->getIntroCard(); ?></p>
                            </div>
                        </div>
                        <?php
                    }elseif ($p->datattype == 'post') { //post
                        $cardphoto = @$p->photoCard;
						$type = $p->type;
                        ?>
                        <div class="media sec">
                            <div class="media-left">
                                <a href="<?= $p->frontUrl(); ?>" target="_blank">
                                    <img class="media-object" src="<?= Helper::get_thumbnail($cardphoto, 75, 75); ?>" alt="<?= $p->getTitle(); ?>">
                                </a>
                            </div>
                            <div class="search-info">
                                <h4 class="jazzira_font_bold"><a href="<?= $p->frontUrl(); ?>" target="_blank"><?= $p->getTitle(); ?></a></h4>
                                <a class="num" href="<?= $p->frontUrl(); ?>" target="_blank"><?= $p->frontUrl(); ?></a>
                                <p class="jazzira_font"><?= Helper::str_limit($p->getContent(), 300); ?></p>
                            </div>
                        </div>
                        <?php
                    } else {//page
                        $cardphoto = @$p->media;
                        ?>
                        <div class="media sec">
                            <div class="media-left">
                                <a href="<?= $p->frontUrl(); ?>" target="_blank">
                                    <img class="media-object" src="<?= Helper::get_thumbnail($cardphoto, 75, 75); ?>" alt="<?= $p->getTitle(); ?>">
                                </a>
                            </div>
                            <div class="search-info">
                                <h4 class="jazzira_font_bold"><a href="<?= $p->frontUrl(); ?>" target="_blank"><?= $p->getTitle(); ?></a></h4>
                                <a class="num" href="<?= $p->frontUrl(); ?>" target="_blank"><?= $p->frontUrl(); ?></a>
                                <p class="jazzira_font"><?= Helper::str_limit($p->getContent(), 300); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    @endforeach


                    <?php
//$total = $cnt_posts + $cnt_projects;
                    $cur_page = (Input::get("page") == null ? '1' : Input::get("page"));
                    ?>


                </div>

            </div>



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