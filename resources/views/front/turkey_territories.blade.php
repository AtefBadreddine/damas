<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr']) ? 'en' : 'ar';

//$photoCard = $post->photoCard;
$infos = Helper::get_params();
$branchs = Helper::query("Branch", "orderBy", ["filed" => "id", "value" => "ASC"])->get();
$is_mobile = Helper::is_mobile();

$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
?>

@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("/resources/assets/css/resale.css"); ?>




    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>

    <?php } ?>

<?php } else { ?>


	<style><?php include(public_path() . "/css/resale.min.css"); ?></style>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>

    <?php } ?>
<?php } ?>



@endsection

<?php
$page_title = $row->getSeoTitle();
$media = $row->media;
?>
@extends('front.layout', [
"page_title" => $page_title ? $page_title : $row->getTitle(),
"page_description"  =>    $row->getSeoDescription(),
"page_keywords"     =>    $row->getSeoKeywords(),
"og_image"          =>    Helper::media_mob($media),
"amp_url"  =>  route("amp.front.about")
])
@section('main_content')



<div class="full_sections int_page">
    <div class="container">

        <div class="top_control_sec">
            <h1 class="jazzira_font_bold"><?= $row->getTitle(); ?></h1>
        </div>

        <img width="100%" height="400" class="big_photo" src="<?= @Helper::media_url($media); ?>" alt="damasturk resale"/>

        <div class="int_content">
            {!! html_entity_decode($row->getContent()) !!}
        </div>


        <section class="form shadow_type">

            <div class="info">
                <div class="tel">
                    <a title="Call" class="telephone faa-ring animated faa-slow" href="tel:<?= str_replace(' ', '', $infos->tel_1) ?>">
                        <svg width="20" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 294.2 288.2" xml:space="preserve"> <g> <path d="M270.5,220.9c-0.6,3.1-1,6.3-1.9,9.3c-4.1,13.5-8.2,27.1-12.5,40.6c-4.4,14-13.8,19.6-28.2,16.8 C150,272.2,88.4,231.8,43.8,166c-9.8-14.5-18-30.1-24.9-46.5c-8.2-19.5-14.1-39.4-18.2-60c-2.4-12.4,2.2-22.1,14.1-26.2 C30.3,27.9,46,23,61.9,18.8c13.1-3.5,22.4,2.4,26.3,15.3c5.5,18,10.9,36,16.6,53.9c2.7,8.6,0.3,15.4-6.3,21 c-5.9,4.9-12.1,9.4-18,14.3c-6.5,5.3-7.3,10.9-2.5,17.9c18.7,27.4,41.8,50.4,69.1,69.2c7.2,4.9,12.7,4.1,18.2-2.7 c4.5-5.6,8.8-11.3,13.3-16.9c6.4-7.9,12.8-9.9,22.5-6.9c18,5.5,36,11,53.9,16.5C265.8,203.6,270.3,209.6,270.5,220.9z"></path> <path d="M294.2,142.3c-0.2,1.1,0,3.7-0.9,5.9c-1.1,2.8-8.6,4.7-12.6,2.6c-2.2-1.1-4.4-4.4-4.5-6.8 c-2.8-63.1-53.6-117.7-116.5-124.9c-3-0.3-6-0.7-8.9-0.9c-6.4-0.5-8.3-3.1-7.9-11.1c0.3-5.3,2.7-7.5,8.6-7.1 c32.4,1.9,61.5,12.8,86.7,33.3c32.4,26.4,50.7,60.7,55.7,102.1C294,137.3,294,139.2,294.2,142.3z"></path> <path d="M241.9,140.7c-0.3,7.9-2.3,10.5-7,10.8c-8,0.5-10.2-1.2-11.3-8.3c-5.7-40.4-33-67.5-73.5-72.7c-6.5-0.8-8.2-3.7-7.3-12 c0.5-4.6,3.2-6.6,9-6.1c42.1,3.6,78.5,34.3,88.1,77.3C240.9,133.8,241.5,138.1,241.9,140.7z"></path> </g> </svg>
                    </a>
                    <p class="jazzira_font_bold"><?= trans("front.AskAdvice"); ?></p>
                    <a title="Call" class="num" href="tel:<?= $infos->tel_1 ?>"><?= $infos->tel_1 ?></a>
                </div>
                <a title="whatsapp" href="{{ route('front.whatsapp_share') }}?icon=8&tel=905551605000" class="whatsapp" target="_blank">
                    <img width="55" height="55" class="icon faa-tada animated faa-slow" src="<?= asset("img/whatsapp-icon.svg"); ?>" alt="whatsapp-icon"/>
                </a>
            </div>
            <div style="clear: both"></div>
            <?= Form::open(["url" => route("front.callus"), "id" => "form-callus-lg"]); ?>
            <div class="name"><input class="form-control"  type="text" name="name" placeholder="* <?= trans("front.name and fame"); ?>"></div>

            <div style="clear: both"></div>
            <div class="tel"><input class="form-control" type="text" name="mobile" value="{{ @session()->get('call_country') }}" id="mobile-sm" placeholder=""></div>
            <div class="textarea"><textarea class="form-control" name="message" rows="2" cols="20" placeholder=" <?= trans("front.How can we help you"); ?>..."></textarea></div>
            <div style="clear: both"></div>

            <button type="submit" class="send">
                <img class="icon" src="<?= asset("img/sendIconW.svg"); ?>" alt="Send Icon" width="21" height="20"/>
            </button>

            </form>

        </section>



    </div>
</div>







@endsection



@section('scriptjs')



<script>


    $(window).scroll(function () {
        var scrollingPage = 0;
        var scrollingPage2 = 500;
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


    });


</script>



@endsection