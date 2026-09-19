<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr','ru']) ? 'en' : 'ar';
?>
<?php
$infos = Helper::get_params();
?>

<?php
$page_title = $row->getSeoTitle();
$media = $row->media;
?>
@extends('front.layout', [
"page_title" => $page_title ? $page_title : $row->getTitle(),
"page_description"  =>    $row->getSeoDescription(),
"page_keywords"     =>    $row->getSeoKeywords(),
"og_image"          =>    Helper::media_mob($media),
"amp_url"  =>  route('amp.'.Route::currentRouteName())
])




@section('main_content')

@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/terms.css"); ?>

<?php } else { ?>
    <style><?php include(public_path() . "/css/terms.min.css"); ?></style>
<?php } ?>
@endsection



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec <?= $row->slug=='privacy'?'col-md-12':'' ?>">

            <div class="top_control_sec">
                <h1 class="jazzira_font_bold"><?= $row->getTitle(); ?></h1>
            </div>


            <div class="int_content">
                @if($media)
                <img src="<?= Helper::media_url($media); ?>" class="img-responsive big_photo" alt="<?= $page_title; ?>">
                @endif



                <div class="cont">
                    <?= html_entity_decode($row->getContent()); ?>
                </div>




            </div>


        </div>
        <!-- End Left Section -->


        <?php
        if($row->slug != 'privacy'){ ?>
        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div class="fixed_sec">

                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>


                <section class="form fast_search search_filter shadow_type">
                    <h3 class="top_title jazzira_font_bold"><?= trans("front.Look for information"); ?></h3>

                    <form action="<?= route("front.searchpage"); ?>">
                        <div class="form-group">
                            <input class="form-control" name="s" placeholder="<?= trans("front.search"); ?>" value="<?= Input::get("s"); ?>" />
                            <button class="search_btn"><i class="fa fa-search"></i></button>
                        </div>
                    </form>

                </section>


            </div>
        </div>
        <!-- End Fixed Section -->
        <?php } ?>



    </div>
</div>




@endsection


@section('scriptjs')
<input type="hidden" value="0" id="scrollv" />
<script>
    

    $(window).scroll(function () {
        var scrollingPage = 0;
        var scrollingPage2 = 0;

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