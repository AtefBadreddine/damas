<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr']) ? 'en' : 'ar';

$infos = Helper::get_params();

$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
?>

@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("/resources/assets/css/resale-details.css"); ?>




    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("/resources/assets/css/resale-details-en.css"); ?>
    <?php } ?>

<?php } else { ?>
    <?= Html::style("/css/resale-details.min.css?v=1"); ?>

    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
<?= Html::style("/css/resale-details-en.min.css?v=1"); ?>
    <?php } ?>
<?php } ?>



@endsection

<?php
$page_title = $row->getSeoTitle();
$media = $row->media;
$cardphoto = $r->cardphoto;
?>
@extends('front.layout', [
"page_title" => ($r->getTitle()!=''?$r->getTitle():($page_title ? $page_title : $row->getTitle())),
"page_description"  =>    ($r->getDescription()!=''?$r->getDescription():$row->getSeoDescription()),
"page_keywords"     =>    '',
"og_image"          =>    (!empty($cardphoto)?Helper::media_mob($cardphoto):Helper::media_mob($media))
])
@section('main_content')



<div class="full_sections int_page">
    <div class="container">




        <div class="resale_details_sec sec">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="big_photo">
                        <img class="lazy" width="100%" height="400" loading="lazy" src="<?= (!empty($cardphoto)?Helper::media_mob($cardphoto):'/img/default-bg.jpg') ?>" alt="damasturk resale"/>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">

                    <div class="int_content margin_30">
                        <div class="top_control_sec">
                            <h1 class="jazzira_font_bold num">{{ Helper::curr_format($r->currency) . $r->price }}</h1>

                            <div class="id_sec num">
                                <span class="applicant_id" id="applicantId">{{ $r->code }}</span>
                            </div>

                        </div>

                        <div class="detsils_sec sec">
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/location.svg" width="30" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"><?= trans("front.resale-details location"); ?></span>
                                <span class="num">
								{{ @$_cities[0]->CityName }} - {{ @$_regions[0]->TownName }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/Apartments-2.svg" width="30" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"><?= trans("front.resale-details type"); ?></span>
                                <!-- type_id >> and >> building_type -->
                                <!-- يمكنك وضع المتغيرات بعد كلمة( resellprojects ) -->
                                <span><?= $_type->getName(); ?> <?php if($r->building_type!=''){ ?>- <strong><?= trans("front.resellprojects ". $r->building_type); ?></strong><?php } ?></span>
                            </div>
                            <div class="item sec">
                                <div class="icon space">
                                    <img src="/img/svg/bed-4.svg" width="27" height="20">
                                </div>
                                <span class="lable jazzira_font_bold"><?= trans("front.resale-details pattern"); ?></span>
                                <span class="num">{{ $r->room }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon space">
                                    <img src="/img/svg/space.svg" width="20" height="20">
                                </div>
                                <span class="lable jazzira_font_bold"><?= trans("front.resale-details space"); ?></span>
                                <span class="num">{{ $r->m2 }} <small>m2</small></span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/elevator-2.svg" width="25" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"><?= trans("front.resale-details floor"); ?></span>
                                <span class="num">{{ $r->floor }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/bathroom-2.svg" width="25" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"> <?= trans("front.resale-details bathroom"); ?></span>
                                <span class="num">{{ $r->bathroom }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/kitchen.svg" width="25" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"> <?= trans("front.resale-details kitchen"); ?></span>
                                <span>{{ trans("front." . $r->kitchen) }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/balcony.svg" width="25" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"> <?= trans("front.resale-details balcony"); ?></span>
                                <span>{{ $r->balkon }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/telescope2.svg" width="25" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"> <?= trans("front.resale-details view"); ?></span>
                                <span>{{ trans("front.resale form title view " . $r->view) }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/id-card.svg" width="27" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"><?= trans("front.resale-details Residence Permit"); ?></span>
                                <span>{{ trans('front.' . $r->residence_permit) }}</span>
                            </div>
                            <div class="item sec">
                                <div class="icon">
                                    <img src="/img/svg/passport.svg" width="25" height="30">
                                </div>
                                <span class="lable jazzira_font_bold"> <?= trans("front.resale-details Citizenship"); ?></span>
                                <span>{{ trans('front.' . $r->citizenship) }}</span>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>




    </div>
</div>







@endsection



@section('scriptjs')



<script>
    $(document).ready(function () {

    });

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


</script>



@endsection