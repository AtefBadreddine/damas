@section('styles')
<?php
$page_title = $project->getSeoTitle();
$page_description = $project->getSeoDescription();
$page_keywords = $project->getSeoKeywords();
$og_image = Helper::media_url_full($project->cardphoto);
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr']) ? 'en' : 'ar';
$infos = Helper::get_params();
$right = ($current_lang == 'ar' ? 'right' : 'left');
$r_reg = $project->region;
$p = $project;
$p_flavors = $p->flavors;
foreach (Helper::query("ProjectType", "all") as $typ) {
    $TType[$typ->id] = $typ->getName();
}
?>
<?php if (App::isLocal()) { ?>

    <?= Html::style("https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"); ?>
    <?= Html::style("resources/assets/css/slick.css"); ?>
    <?= Html::style("resources/assets/css/slick-theme.css"); ?>
    <?= Html::style("resources/assets/css/circle.css"); ?>
    <?= Html::style("resources/assets/css/flaticon.css"); ?>

    <!-- <link rel="alternate" type="application/json+oembed" href="https://my.matterport.com/api/v1/models/oembed/?url=https%3A//my.matterport.com/show/%3Fm%3DWFqnBmixivn" title="Ebruli Ispartakule 2+1">
    -->

    <?= Html::style("resources/assets/css/project.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>


    <?php if (Helper::get_device() == 'mob') { ?>
        <?= Html::style("resources/assets/css/project-data-mob.css"); ?>
        <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
            <?= Html::style("resources/assets/css/project-data-mob-en.css"); ?>
        <?php } ?>
    <?php } else { ?>
        <?= Html::style("resources/assets/css/project-data-mob.css"); ?>
        <?= Html::style("resources/assets/css/project-data-full.css"); ?>

    <?php }
    ?>







<?php } else { //online ?>
    <?= Html::style("https://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/themes/blitzer/jquery-ui.css"); ?>
    <?= Html::style("css/slick.min.css"); ?>
    <?= Html::style("css/slick-theme.min.css"); ?>
    <?= Html::style("css/circle.min.css"); ?>
    <?= Html::style("css/flaticon.min.css"); ?>
    <?= Html::style("css/project.min.css"); ?>
    <?= Html::style("css/slider-project-card.min.css"); ?>

    <!-- <link rel="alternate" type="application/json+oembed" href="https://my.matterport.com/api/v1/models/oembed/?url=https%3A//my.matterport.com/show/%3Fm%3DWFqnBmixivn" title="Ebruli Ispartakule 2+1">
    -->
    <?php if (Helper::get_device() == 'mob') { ?>
        <?= Html::style("css/project-data-mob.min.css"); ?>
        <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
            <?= Html::style("css/project-data-mob-en.css"); ?>
        <?php } ?>
    <?php } else { ?>
        <?= Html::style("css/project-data-mob.min.css"); ?>
        <?= Html::style("css/project-data-full.min.css"); ?>

    <?php }
    ?>


    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("css/project-data-en.min.css"); ?>
    <?php } ?>



    <style>
        .videos img,.floor-plan img,.project-photo img{max-width:100%}
    </style>
<?php } ?>
<style>
    .videos img,.floor-plan img,.project-photo img{max-width:100%;max-height: 277px;}
    .arabic-pdf{
        position: absolute;
        width: 100%;
        height: 51px;
        left: 0px;
        top: 0px;
    }
    .Main__Inner-sc-1ue84g4-1>a{
        display: none !important;
    }
    .eapps-widget-toolbar {
        display: none !important;
    }
    .testimonials-sec{
        margin-bottom: 0px;
    }

    .int_content.testimonials {
        margin: 0px 0px 20px 0px;
    }
    .sub_title {
        text-align: center;
    }

</style>

@endsection


@extends('front.layout', [
"page_title"        =>    $page_title ? $page_title : $project->getName(),
"page_description"  =>    $page_description ? $page_description : null,
"page_keywords"     =>    $page_keywords ? $page_keywords : null,
"og_image"          =>    $og_image,
"page_index" => $current_lang=='en'?'':''
])
@section('main_content')

<?php
if (isset($_GET['display']))
    $arrdisp = explode(',', $_GET['display']);
else
    $arrdisp = ['videos', 'price', 'infographic', 'pdf', 'plans', '3d', 'pics', 'offer'];
?>




<?php
$project_name_en = $p->name_en;
preg_match_all('!\d+!', $project_name_en, $matches);
$id_num = $matches[0][0];
$id_text = str_replace($id_num, '', $project_name_en);
?>


<!-- Start Mobil Section -->
<a id="ytsubscribe" href="https://www.youtube.com/channel/UCmDiqtmwRlVeple5-D9SbwQ?sub_confirmation=1">
    <img class="subscribe_btn" src="<?= asset('/img/subscribe-icon.png') ?>"/>
    <img class="bell_icon faa-ring animated" src="<?= asset('/img/bell-icon.svg') ?>"/>
    <p class="num">Subscribe</p>
</a>

<div class="section-mob">


    <?php if ($p->sold == '100') { ?>
        <div class="message_off_sec">
            <div class="cont_sec">
                <p><?= trans("front.message project off") ?></p>
                <a href="{{ route('front.whatsapp_share') }}?icon=6">
                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg>
                    <span><?= $infos->tel_1; ?></span>
                </a>

            </div>
        </div>
        <?php
    } else {
        ?>


        <div class="int_content">
            <div class="section">
                <div class="top_sec">
                    <h1 class="project_name"> <?= trans("front.project"); ?> <strong class="num"><?= @$project->getNameEn(); ?></strong></h1>
                    <div class="btn_group">
    <!--                        <a class="green_btn gift" data-fancybox="gift" data-src="#gift" data-touch="false"><span class="icon"></span><span><?= trans("front.gift"); ?></span></a>-->
                        <a class="green_btn like likeCardItem <?= in_array($project->id, session()->get("likedprojects.ids", [])) ? 'active' : ''; ?>" data-url="<?= route("front.likeitem"); ?>" data-typ="project" data-code="<?= $project->id; ?>"><span class="icon"></span><span><?= trans("front.like"); ?></span></a>
                        <div class="dropdown share">
                            <button class="btn btn-primary dropdown-toggle green_btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="icon"></span> <?= trans("front.share"); ?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="fa fa-twitter" href="https://twitter.com/intent/tweet?url=<?= urlencode(route('front.project', [$project->slug])) ?>&amp;text=<?= urlencode(trans("front.project") . ' ' . @$project->getNameEn() . ' ' . @$project->city->getName()) ?>&amp;via=damasturk" target="_blank"></a>
                                <a target="_blank" class="fa fa-facebook" href="https://facebook.com/sharer.php?u=<?= urlencode(route('front.project', [$project->slug])) ?>"></a>
                                <a class="fa fa-whatsapp" href="https://api.whatsapp.com/send?text=<?= urlencode(route('front.project', [$project->slug])) ?>" target="_blank"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="line_space margin_top_35"></span>
                <ul class="project_icons">
                    <li class="region">
                        <div class="icon"></div>
                        <p><?= @$project->city->getName(); ?></p> 
                        <span><?= @$project->region ? @$project->region->getName() : null; ?></span>
                    </li>
                    <li class="type">
                        <div class="icon"></div>
                        <p><strong><?= $project->bs ?></strong> <?= trans("front.Block"); ?></p><span><strong><?= $project->fs ?></strong> <?= trans("front.Flat"); ?></span>
                    </li>
                    <li class="target">
                        <div class="icon"></div>
                        <p><?= trans("front.City Center"); ?></p><span class="num"><strong><?= trim(str_replace('كم', '', $project->distance_center)); ?></strong> km</span>
                    </li>
                    <?php
                    list($sclass, $slab) = $project->getStatus();
                    if ($sclass == 'under-construction') {
                        ?>
                        <li class="status under-construction">
                            <div class="icon"></div>
                            <p><?= trans("front.under cons"); ?></p><span class="date num"><?= date("Y/m", strtotime($project->delivered_date)); ?></span>
                        </li>
                    <?php } else { ?>
                        <li class="date">
                            <div class="icon"></div>
                            <p><?= trans("front.Ready to move"); ?></p>
                        </li>
                    <?php } ?>

                    <?php
                    if ($project->payment_method != 'نقدي') {
                        ?>
                        <li class="payment_plan">
                            <div class="progres">
                                <span class="pro">
                                    <div class="progress" data-percentage="<?= $project->payment_percent ?>">
                                        <span class="progress-left">
                                            <span class="progress-bar"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar"></span>
                                        </span>
                                        <div class="progress-value">
                                            <strong class="num"><?= $project->payment_percent ?>%</strong>
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <p> <?= trans('front.' . $project->payment_method); ?></p>
                            <p> <strong class="num"><?= $project->payment_months ?></strong> <?= trans("front.months"); ?></p>
                        </li>
                    <?php } ?>

                </ul>
                <span class="line_space"></span>
            </div>

            <?php if (in_array('price', $arrdisp)) { ?>
                <div class="section prices">
                    <h2 class="sub_title jazzira_font_bold"><span><?= trans("front.approximate prices"); ?></span></h2>
                    @include("front.partials.project_prices_landing", ["project" => $project, "style_lang" => $style_lang ])
                </div>
            <?php } ?>
            <div class="dateOfUpdate">
                <p class="jazzira_font_bold"><?= trans("front.dateOfUpdate"); ?></p><span class="num"><?= str_replace('-', ' / ', $p->edit_date) ?></span>
            </div>

        </div>



        <div class="int_content features_sec">
            <h2 class="sub_title jazzira_font_bold"><?= trans("front.Special features"); ?></h2> 


            <ul>
                <?php
                $tags = Helper::query("ProjectCategory", "where", ["field" => "hide_search_page", "value" => false])->get();
                ?>
                @foreach($tags as $tag)
                @if(in_array($tag->id, $project->categories()->lists('project_category_id')->toArray()))
                <li>
                    <a>
                        <span class="icon {{ str_replace(['(',')','&',' ','2','/','7','4'],'',strtolower($tag->name_en)) }}"></span>
                        <span class="feature_title jazzira_font_bold">{{ $tag->getName() }}</span>
                    </a>
                </li>
                @endif
                @endforeach
                <?php /*
                  <li>
                  <a>
                  <span class="icon proximitytotram"></span>
                  <span class="feature_title jazzira_font_bold">قرب الترام</span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon seaview"></span>
                  <span class="feature_title jazzira_font_bold">إطلالة بحرية</span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon governmentguarantee"></span>
                  <span class="feature_title jazzira_font_bold">بضمان الحكومة</span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon proximitytobasinexpress"></span>
                  <span class="feature_title jazzira_font_bold">على طريق الباسن اكسبرس	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon overlookingthebosphorus"></span>
                  <span class="feature_title jazzira_font_bold">بإطلالة على البوسفور	</span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon atattractiveprices"></span>
                  <span class="feature_title jazzira_font_bold"> بأسعار مغرية	</span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon withhotelservices"></span>
                  <span class="feature_title jazzira_font_bold">بخدمات فندقية	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon withgreenviews"></span>
                  <span class="feature_title jazzira_font_bold">بإطلالات خضراء	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon proximitytoe80highway"></span>
                  <span class="feature_title jazzira_font_bold">قرب الأوتوستراد E80 </span>
                  </a>
                  </li>

                  <li>
                  <a>
                  <span class="icon neartheshoppingmalls"></span>
                  <span class="feature_title jazzira_font_bold">قرب المولات التجارية	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon nearbytheistanbulcanal"></span>
                  <span class="feature_title jazzira_font_bold">قرب قناة إسطنبول	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon investment"></span>
                  <span class="feature_title jazzira_font_bold">استثماري </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon closetothemarina"></span>
                  <span class="feature_title jazzira_font_bold">قرب المارينا البحرية	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon withspaciousareas"></span>
                  <span class="feature_title jazzira_font_bold">بمساحات واسعة	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon withpanoramicviews"></span>
                  <span class="feature_title jazzira_font_bold">بإطلالة بانورامية	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon closetoahighway"></span>
                  <span class="feature_title jazzira_font_bold">قرب الطريق السريع	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon luxuriousfinishes"></span>
                  <span class="feature_title jazzira_font_bold">بتشطيبات فاخرة	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon smarthomesystem"></span>
                  <span class="feature_title jazzira_font_bold">بنظام التحكم الذكي	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon proximitytocitycenter"></span>
                  <span class="feature_title jazzira_font_bold">قرب مركز المدينة	 </span>
                  </a>
                  </li>
                  <li>
                  <a>
                  <span class="icon proximitytometrobuse5"></span>
                  <span class="feature_title jazzira_font_bold">قرب المتروبوس (E5) </span>
                  </a>
                  </li>
                 */ ?>
            </ul>

        </div>



        




        <?php
        //if (($project->offer_type != '' && ($project->offer_duration == '' || strtotime($project->offer_duration) > time()) or ( $p->file_offer != '' and $p->enable_offer == true))) {
        if (in_array('offer', $arrdisp))
            if ($project->offer_type != '' && $project->offer_type != 'not_offer' && ($project->offer_duration == '' || strtotime($project->offer_duration) > time())) {
                ?>			
                <?php /* if (in_array('offer', $arrdisp)) { ?>
                  <?php if ($p->file_offer != '' and $p->enable_offer == true) { */ ?>
                <!-- Start Offer Section -->
                <div class="container-section">
                    <h2><?= trans("front.offers"); ?></h2>




                    <!-- Start Offers types section -->

                    <?php if ($project->offer_type != '' && ($project->offer_duration == '' || strtotime($project->offer_duration) > time())) { ?>
                        <div class="type_offer">
                            <div class="all_sec">
                                <?php if ($project->offer_type == 'Cash One') { ?>
                                    <!-- Cash One / Offer -->
                                    <div class="item cash_one">
                                        <img class="bg_photo" src="<?= asset('/img/offer-bg-all.jpg') ?>"/>
                                        <div class="content">
                                            <img class="logo" src="<?= asset('/img/full-logo.png') ?>"/>
                                            <img class="offer_title" src="<?= asset('/img/offer-title.svg') ?>"/>
                                            <img class="cash_title" src="<?= asset('/img/cash-title.svg') ?>"/>
                                            <?php
                                            $i = 0;
                                            foreach ($p_flavors as $flavor) {
                                                ?>
                                                <?php
                                                $i++;

                                                //if ($flavor->checked) {
                                                if ($flavor->sold_out == false) {
                                                    ?>




                                                    <div class="prices_section">
                                                        <div class="small_title">
                                                            <?php if ($p->is_price_usd) { ?>
                                                            <?php } else { ?>
                                                                <img src="<?= asset('/img/turkLira-icon-yellow.svg') ?>"/>
                                                            <?php } ?>
                                                            <p>Prices</p>
                                                        </div>
                                                        <span class="old_price"><?= $flavor->sold_out == true ? 'Sold' : strip_tags(Helper::decimal_format(@$flavor->price, $p->is_price_usd)) ?></span>
                                                        <strong class="new_price"><?= $flavor->sold_out == true ? 'Sold' : strip_tags(Helper::decimal_format(@$flavor->offer, $p->is_price_usd)) ?></strong>
                                                    </div>

                                                    <div class="area">
                                                        <div class="small_title">
                                                            <img src="<?= asset('/img/area-icon-yellow.svg') ?>"/>
                                                            <p><strong><?= $flavor->area; ?></strong> m2</p>
                                                        </div>
                                                    </div>

                                                    <div class="rooms">
                                                        <div class="small_title">
                                                            <img src="<?= asset('/img/bedRoom-icon-yellow.svg') ?>"/>
                                                            <strong><?php
                                                                if (!in_array($flavor->type, [5, 6])) {
                                                                    echo ($flavor->room == 0 and $flavor->salon == 0) ? '0' : ($flavor->room . ' + ' . $flavor->salon);
                                                                } else {
                                                                    echo @$TType[$flavor->type];
                                                                }
                                                                ?></strong>
                                                        </div>
                                                    </div>			
                                                    <?php
                                                    break;
                                                }
                                            }
                                            ?>


                                            <p class="explained"> <?= trans("front.Dont Miss this Offer"); ?></p>

                                            <!----><div id="countdown" class="countdown"></div>

                                        </div>
                                    </div>


                                <?php } elseif ($project->offer_type == 'Cash Cetizenship') { ?>
                                    <!-- Cash Citizenship -->
                                    <div class="item cash_citizenship">
                                        <img class="bg_photo" src="<?= asset('/img/offer-bg-all-citizenship.jpg') ?>"/>
                                        <div class="content">
                                            <img class="logo" src="<?= asset('/img/full-logo.png') ?>"/>
                                            <img class="offer_title" src="<?= asset('/img/offer-title.svg') ?>"/>

                                            <img class="flag_left" src="<?= asset('/img/flag-left.svg') ?>"/>
                                            <img class="passport" src="<?= asset('/img/passport-new3.png') ?>"/>


                                            <div class="price-table">
                                                <ul> 
                                                    <li>
                                                        <div class="cont"> 
                                                            <span class="title"><img class="icon" src="<?= asset('/img/bedRoom-icon-yellow.svg') ?>" alt="Damas"><b>Rooms</b></span> 
                                                        </div>
                                                        <div class="cont"> 
                                                            <span class="title"><img class="icon area-icon" src="<?= asset('/img/area-icon-yellow.svg') ?>" alt="Damas"><b>(m2)</b></span>
                                                        </div> 
                                                    </li> 


                                                    <div class="prices_sec">
                                                        <?php
                                                        $i = 0;
                                                        foreach ($p_flavors as $flavor) {
                                                            if ($flavor->cntx != '' && $flavor->cntx != 0)
                                                                if ($flavor->sold_out == false) {
                                                                    ?>
                                                                    <?php $i++; ?>

                                                                    <li class="<?= $i % 2 != 0 ? 'odd' : '' ?>">
                                                                        <div class="cont number"><p>  <?php
                                                                                if (!in_array($flavor->type, [5, 6])) {
                                                                                    echo ($flavor->room == 0 and $flavor->salon == 0) ? '0' : ($flavor->room . '+' . $flavor->salon);
                                                                                } else {
                                                                                    echo @$TType[$flavor->type];
                                                                                }
                                                                                ?>
                                                                                <?= ($flavor->cntx != 0 /* && $flavor->cntx!=1 */) ? '<span>X</span><strong>' . $flavor->cntx . '</strong>' : '' ?></p></div>
                                                                        <div class="cont number center"><p><?= $flavor->offer; ?></p></div>
                                                                    </li>

                                                                    <?php
                                                                }
                                                        }
                                                        ?>

                                                        <div class="new_price_sec">
                                                            <img src="<?= asset('/img/riboon-red.png') ?>" alt="riboon"/>
                                                            <h4 class="title">Price</h4>
                                                            <strong><?= str_replace('.000', '<p>k</p>', strip_tags(Helper::decimal_format($project->cash_cetizenship_price))) ?></strong>
                                                            <span>$</span>
                                                        </div>       

                                                    </div>
                                                </ul> 
                                            </div>


                                            <p class="explained"><?= trans("front.Buy many Apartments and"); ?><br><?= trans("front.Obtain Turkish Citizenship"); ?><br><span><?= trans("front.Dont Miss this Offer"); ?></span></p>


                                                        <!-- Countdown Timer -->
                                                        <div id="countdown" class="countdown"></div>

                                                        </div>
                                                        </div>



                                                    <?php } elseif ($project->offer_type == 'Cash All') { ?>
                                                        <!-- Cash All -->
                                                        <div class="item cash_all">
                                                            <img class="bg_photo" src="<?= asset('/img/offer-bg-all.jpg') ?>"/>
                                                            <div class="content">
                                                                <img class="logo" src="<?= asset('/img/full-logo.png') ?>"/>
                                                                <img class="offer_title" src="<?= asset('/img/offer-title.svg') ?>"/>

                                                                <div class="cash_off_title">
                                                                    <img src="<?= asset('/img/cash-off-title.svg') ?>"/>
                                                                    <p><?= $p->offer_cache_discount ?>%</p>
                                                                </div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <!--<p class="explained">Cash Payment<br>Discount</p>-->
                                                                <p class="explained2"><?= trans("front.Dont Miss this Offer"); ?></p>

                                                                <!-- Countdown Timer -->
                                                                <div id="countdown" class="countdown"></div>

                                                            </div>
                                                        </div>


                                                    <?php } elseif ($project->offer_type == 'Installment offer') { ?>
                                                        <!-- Installment Offer -->
                                                        <div class="item installment_offer">
                                                            <img class="bg_photo" src="<?= asset('/img/offer-bg-all.jpg') ?>"/>
                                                            <div class="content">
                                                                <img class="logo" src="<?= asset('/img/full-logo.png') ?>"/>
                                                                <img class="offer_title" src="<?= asset('/img/offer-title.svg') ?>"/>




                                                                <div class="plan_payment">

                                                                    <div class="installment_number_sec">
                                                                        <img src="<?= asset('/img/paner-plan-payment3.png') ?>"/>
                                                                        <span class="down">Months</span>
                                                                        <strong class="num"><?= $p->offer_installment_months ?></strong>
                                                                        <span class="payment"><?= $p->payment_method == 'تقسيط' ? 'Installment' : 'Cash' ?></span>
                                                                    </div>

                                                                    <div class="progress" data-percentage="<?= $p->offer_installment_discount ?>">
                                                                        <span class="progress-left">
                                                                            <span class="progress-bar"></span>
                                                                        </span>
                                                                        <span class="progress-right">
                                                                            <span class="progress-bar"></span>
                                                                        </span>
                                                                        <div class="progress-value">
                                                                            <span class="down">Down</span>
                                                                            <strong><?= $p->offer_installment_discount ?>%</strong>
                                                                            <span class="payment">Payment</span>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <p class="explained"><?= trans("front.Offer On All Apartments"); ?></p>

                                                                <!-- Countdown Timer -->
                                                                <div id="countdown" class="countdown"></div>

                                                            </div>
                                                        </div>


                                                    <?php } ?>


                                                    </div>

                                                    </div>
                                                <?php } ?>
                                                <!-- End Offers types section -->


                                                <?php /* if ($p->file_offer != '' and $p->enable_offer == true) { ?>
                                                  <div class="tabs offer-tabs">
                                                  <div class="tab-button-outer">
                                                  <ul id="tab-button">
                                                  <li class="is-active"><a href="#tab01"><img src="<?= asset("/img/flag-ar.svg"); ?>" alt="Damas"/></a></li>
                                                  <?php if ($p->file_offer_en != '') { ?>
                                                  <li><a href="#tab02"><img src="<?= asset("/img/flag-en.svg"); ?>" alt="Damas"/></a></li>
                                                  <?php } ?>
                                                  <?php if ($p->file_offer_fr != '') { ?>
                                                  <li><a href="#tab03"><img src="<?= asset("/img/flag-fr.svg"); ?>" alt="Damas"/></a></li>
                                                  <?php } ?>
                                                  </ul>
                                                  </div>

                                                  <div class="tab-group">
                                                  <div class="border-section">
                                                  <div id="tab01" class="tab-contents">
                                                  <p><img src="<?= asset($p->file_offer); ?>" alt="Damas"/></p>
                                                  </div>
                                                  <?php if ($p->file_offer_en != '') { ?>
                                                  <div id="tab02" class="tab-contents">
                                                  <p><img src="<?= asset($p->file_offer_en); ?>" alt="Damas"/></p>
                                                  </div>
                                                  <?php } ?>
                                                  <?php if ($p->file_offer_fr != '') { ?>
                                                  <div id="tab03" class="tab-contents">
                                                  <p><img src="<?= asset($p->file_offer_fr); ?>" alt="Damas"/></p>
                                                  </div>
                                                  <?php } ?>
                                                  </div>
                                                  </div>
                                                  </div>
                                                  <?php } */ ?>
                                                </div>
                                                <!-- End Offer Section -->
                                            <?php } ?>


                                        <!-- Links Section -->
                                        <div class="container-section padded-left-right section-links">
                                            <?php /* if (in_array('pdf', $arrdisp)) { ?>
                                              <?php if ($p->file_pdf != '') { ?>
                                              <div class="sub pdf">

                                              <div class="showPdf cont">
                                              <img class="title" src="<?= asset("img/pdf-title-icon.svg"); ?>" alt="Damas"/>
                                              <img class="point" src="<?= asset("img/pdf-point.svg"); ?>" alt="Damas"/>
                                              <a class="arabic-pdf" href="<?= asset($p->file_pdf) ?>?lang=ar" target="_blank"><span>Catalog PDF</span></a>
                                              <ul class="links-Pdf">
                                              <?php if ($p->file_pdf != '') { ?><li><a href="<?= asset($p->file_pdf) ?>?lang=ar" target="_blank"><img src="<?= asset("img/flag-bg-ar.svg"); ?>" alt="Damas" title="AR"/></a></li><?php } ?>
                                              <?php if ($p->file_pdf_en != '') { ?><li><a href="<?= asset($p->file_pdf_en) ?>" target="_blank"><img src="<?= asset("img/flag-bg-en.svg"); ?>" alt="Damas" title="EN"/></a></li><?php } ?>
                                              <?php if ($p->file_pdf_fr != '') { ?><li><a href="<?= asset($p->file_pdf_fr) ?>" target="_blank"><img src="<?= asset("img/flag-bg-fr.svg"); ?>" alt="Damas" title="FR"/></a></li><?php } ?>
                                              </ul>
                                              <!--                        <ul class="links-Pdf">
                                              <li><a data-fancybox="" data-type="iframe" href="<?= route('front.preview_pdf', [$p->id]) ?>?lang=ar"><img src="<?= asset("img/flag-bg-ar.svg"); ?>" alt="Damas" title="AR"/></a></li>
                                              <li><a data-fancybox="" data-type="iframe" href="<?= route('front.preview_pdf', [$p->id]), '?lang=en' ?>"><img src="<?= asset("img/flag-bg-en.svg"); ?>" alt="Damas" title="EN"/></a></li>
                                              <li><a data-fancybox="" data-type="iframe" href="<?= route('front.preview_pdf', [$p->id]), '?lang=fr' ?>"><img src="<?= asset("img/flag-bg-fr.svg"); ?>" alt="Damas" title="FR"/></a></li>
                                              </ul>-->
                                              </div>



                                              </div>
                                              <?php
                                              }
                                              } */
                                            ?>

                                            <?php /* if (in_array('infographic', $arrdisp)) { ?>
                                              <?php if ($p->file_infographic != '') { ?>
                                              <div class="sub infographic">
                                              <!--                    <div class="cont" href="<?= asset($p->file_infographic); ?>">
                                              <img src="<?= asset("img/infographic-icon.svg"); ?>" alt="Damas"/>
                                              <span>Infographic</span>
                                              </div>-->
                                              <div class="infographic cont">
                                              <img class="title" src="<?= asset("img/info-title-icon.svg"); ?>" alt="Damas"/>
                                              <img class="point" src="<?= asset("img/info-point.svg"); ?>" alt="Damas"/>
                                              <a class="arabic-pdf" data-fancybox="infog" href="<?= asset($p->file_infographic); ?>"><span>Infographic</span></a>
                                              <ul class="links-info">
                                              <?php if ($p->file_infographic != '') { ?><li><a data-fancybox="infog" href="<?= asset($p->file_infographic); ?>"><img src="<?= asset("img/flag-bg-ar.svg"); ?>" alt="Damas" title="AR"/></a></li><?php } ?>
                                              <?php if ($p->file_infographic_en != '') { ?><li><a data-fancybox="infog" href="<?= asset($p->file_infographic_en); ?>"><img src="<?= asset("img/flag-bg-en.svg"); ?>" alt="Damas" title="EN"/></a></li><?php } ?>
                                              <?php if ($p->file_infographic_fr != '') { ?><li><a data-fancybox="infog" href="<?= asset($p->file_infographic_fr); ?>"><img src="<?= asset("img/flag-bg-fr.svg"); ?>" alt="Damas" title="FR"/></a></li><?php } ?>
                                              </ul>
                                              </div>


                                              </div>
                                              <?php
                                              }
                                              } */
                                            ?>

                                            <?php if (in_array('3d', $arrdisp)) { ?>
                                                <?php if ($p->link_3d != '') { ?>
                                                    <div class="sub virtualRoaming">
                                                        <h2> <?= trans("front.Virtual Roaming"); ?> <img src="<?= asset("img/3d-icon2.svg"); ?>" alt="Damas"/></h2>
            <!--                                                    <a class="sanaltur_opener" data-fancybox="" data-type="iframe" href="<?= $p->link_3d ?>"></a>-->
                                                        <iframe width='100%' height='350' src='<?= $p->link_3d ?>' frameborder='0' allowfullscreen allow='xr-spatial-tracking'></iframe>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </div>

                                        <?php $images = $project->projectPhotos; ?>

                                        <?php 
                                        
                                        
                                        
                                        
                                        $Yt_videos = DB::select("SELECT dms_project_video.`project_id`, dms_project_video.`video_id`,dms_videos.link, dms_videos.lang,updated_at
													FROM `dms_project_video`
													left JOIN dms_videos on dms_videos.id=dms_project_video.video_id
													WHERE dms_project_video.`project_id`=? and dms_videos.lang like ?
													order by updated_at desc
													limit 5", [$project->id, '%' . $current_lang . '%']);

                                        if (in_array('videos', $arrdisp) and (count($Yt_videos)!=0 or count($project->crmvideos)!=0)) { ?>
                                            @include("front.partials.share_links", [])
                                            <!-- Videos Section -->
                                            <div class="container-section">
                                                <h2><?= trans("front.Latest Videos"); ?></h2>
                                                <div class="videos sliders">
                                                    <?php
                                                    

                                                    if (count($Yt_videos) == 0) {

                                                        function video_picture($video, $images, $default) {
                                                            $arr_pic = [];
                                                            foreach ($video as $v) {
                                                                $pic = false;
                                                                foreach ($images as $img) {
                                                                    if ($v->rooms == 'Outside') {
                                                                        if (strpos($img->getName(), 'xterior') !== false)
                                                                            if (!in_array($img, $arr_pic)) {
                                                                                $arr_pic[] = $img;
                                                                                $pic = true;
                                                                            }
                                                                    } else {
                                                                        if (strpos($img->getName(), 'xterior') === false)
                                                                            if (!in_array($img, $arr_pic)) {
                                                                                $arr_pic[] = $img;
                                                                                $pic = true;
                                                                            }
                                                                    }
                                                                    if ($pic == true)
                                                                        break;
                                                                }
                                                                if ($pic == false) {
                                                                    $arr_pic[] = $default;
                                                                }
                                                            }
                                                            return $arr_pic;
                                                        }

                                                        $videos = $project->crmvideos;
                                                        $arr_img = video_picture($videos, $images, ($project->cardphoto));
                                                        $i = 0;
                                                        ?>
                                                        @foreach($videos as $v)
                                                        <div class="item">
                                                            <a data-fancybox href="<?= asset($v->video); ?>">
                                                                <?php if (@$arr_img[$i]->path_mobile) { ?>
                                                                    <img loading="lazy" src="<?= asset($arr_img[$i]->path_mobile) ?>"  class="lazy" loading="lazy" src="<?= asset('/img/show-loader.gif') ?>"/>
                                                                <?php } else { ?>
                                                                    <img loading="lazy" src="<?= Helper::media_url($arr_img[$i]); ?>"  class="lazy" loading="lazy" src="<?= asset('/img/show-loader.gif') ?>"/>
                                                                <?php } ?>
                                                            </a>
                                                            <?php if (@$v->video_title) { ?><span class="video-title"><?= $v->video_title ?></span><?php } ?>
                                                        </div>
                                                        <?php $i++; ?>
                                                        @endforeach
                                                    <?php } ?>



                                                    @foreach($Yt_videos as $v)
                                                    <?php
                                                    $link_video = $v->link;
                                                    parse_str(parse_url($link_video, PHP_URL_QUERY), $array_of_vars);
                                                    $video_code = @$array_of_vars['v'];
                                                    ?>
                                                    <div class="item">
                                                        <a data-fancybox href="https://www.youtube.com/embed/<?= $video_code; ?>">
                                                            <img loading="lazy" src="https://i.ytimg.com/vi/<?= $video_code; ?>/hqdefault.jpg" class="lazy" loading="lazy" src="<?= asset('/img/show-loader.gif') ?>"/>
                                                        </a>
                                                        <?php if (@$v->title) { ?><span class="video-title"><?= $v->title ?></span><?php } ?>
                                                    </div>
                                                    @endforeach


                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if (in_array('pics', $arrdisp)) { ?>
                                            <!-- Project Photos Section -->
                                            <div class="container-section">
                                                <h2> <?= trans("front.project photos"); ?></h2>
                                                <div class="project-photo">
                                                    @foreach($images as $k => $img)
                                                    <?php
                                                    $img_url = Helper::media_url($img);
                                                    if (@$img->path_mobile)
                                                        $img_sml = asset($img->path_mobile);
                                                    else
                                                        $img_sml = Helper::get_thumbnail($img, 421, 243, false);
                                                    ?>
                                                    <div class="item">
                                                        <a href="<?= $img_url; ?>">
                                                            <img loading="lazy" src="<?= $img_sml; ?>"  class="lazy" data-src="<?= asset('/img/show-loader.gif') ?>"/>
                                                        </a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <?php if (in_array('plans', $arrdisp) and count($project->planPhotos)>0) { ?>
                                            <!-- Floor Plan Photos Section -->
                                            <div class="container-section">
                                                <h2><?= trans("front.project plans"); ?></h2>
                                                <div class="floor-plan gallery">
                                                    <?php $img_plans = $project->planPhotos; ?>
                                                    @foreach($img_plans as $plan)
                                                    <div class="item">
                                                        <a href="<?= Helper::media_dev($plan, Helper::get_device()); ?>">
                                                            <img loading="lazy" src="<?= Helper::media_dev($plan, 'mob'); ?>" class="lazy" loading="lazy" src="<?= asset('/img/show-loader.gif') ?>"/></a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        <?php } ?>


                                        @include("front.partials.share_links", [])








                                        <!-- Start Overview Section -->
                                        <div class="container-section overview-section">
                                            <h2><?= trans("front.overview"); ?></h2>
                                            <div class="tabs overview-tabs">
                                                <!--<div class="tab-button-outer">
                                                    <ul id="tab-button">
                                                        <li class="is-active"><a href="#OverviewTab01"><img src="<?= asset("/img/flag-ar.svg"); ?>" alt="Damas"/></a></li>

                                                        <li><a href="#OverviewTab02"><img src="<?= asset("/img/flag-en.svg"); ?>" alt="Damas"/></a></li>

                                                        <li><a href="#OverviewTab03"><img src="<?= asset("/img/flag-fr.svg"); ?>" alt="Damas"/></a></li>

                                                    </ul>
                                                </div>-->

                                                <div class="tab-group">
                                                    <div class="border-section">

                                                        <div id="OverviewTab01" class="tab-contents scroll-bar-style">
                                                            <section class="about_project ar-type">
                                                                <h3><?= trans("front.facilities and features"); ?></h3>
                                                                <div class="clearfix"></div>
                                                                <ul>
                                                                    <?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br(preg_replace("/[\r\n]+/", "\n", $project->getIntoLocation())))); ?>
                                                                </ul>

                                                                <div class="services">
                                                                    <ul class="clearfix">
                                                                        @foreach($project->features as $feature)
                                                                        <li class="col-md-3 col-sm-6 col-6">
                                                                            <span class="fa fa-check"></span> <?= $feature->getName(); ?>
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>



                                                                <div class="location-importance">
                                                                    <?php /* @if($project->getIntoLocation())
                                                                      <ul>
                                                                      <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntoLocation()))); ?></li>
                                                                      </ul>
                                                                      @endif
                                                                     */ ?>
                                                                    <div class="line1">


                                                                        <?php $p_governmental = $project->getGovernmental(); ?>
                                                                        @if($p_governmental)
                                                                        <div class="institutions">
                                                                            <div class="title">
                                                                                <i class="fa fa-institution"></i>
                                                                                <span><?= trans("front.service institutions"); ?></span>
                                                                            </div>
                                                                            <ul>
                                                                                <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_governmental))); ?></li>
                                                                            </ul>
                                                                        </div>
                                                                        @endif

                                                                        <?php $p_location = $project->getLocation(); ?>
                                                                        @if($p_location)
                                                                        <div class="location">
                                                                            <div class="title">
                                                                                <i class="fa fa-map-marker"></i>
                                                                                <span><?= trans("front.location"); ?></span>
                                                                            </div>
                                                                            <ul>
                                                                                <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_location))); ?></li>
                                                                            </ul>
                                                                        </div>
                                                                        @endif
                                                                    </div>

                                                                    <div class="line2">

                                                                        <?php $p_transportation = $project->getTransportation(); ?>
                                                                        @if($p_transportation)
                                                                        <div class="transport">
                                                                            <div class="title">
                                                                                <i class="fa fa-car"></i>
                                                                                <span><?= trans("front.transportation"); ?></span>
                                                                            </div>
                                                                            <ul>
                                                                                <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_transportation))); ?></li>
                                                                            </ul>
                                                                        </div>
                                                                        @endif

                                                                        <?php $p_future_look = $project->getFutureLook(); ?>
                                                                        @if($p_future_look)
                                                                        <div class="look">
                                                                            <div class="title">
                                                                                <i class="fa fa-eye"></i>
                                                                                <span><?= trans("front.future look"); ?></span>
                                                                            </div>
                                                                            <ul>
                                                                                <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_future_look))); ?></li>
                                                                            </ul>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>



                                                            </section>
                                                        </div>
                                                        <?php /* ?>
                                                          <div id="OverviewTab02" class="tab-contents scroll-bar-style">
                                                          <section class="about_project">
                                                          <h3 class="en-type">Overview ... Facilities and Services</h3>
                                                          <div class="clearfix"></div>
                                                          <ul class="en-type">
                                                          <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntroFeaturesEn()))); ?></li>
                                                          </ul>

                                                          <div class="services">
                                                          <ul class="clearfix en-type">
                                                          @foreach($project->features as $feature)
                                                          <li class="col-md-3 col-sm-6 col-6 en-type">
                                                          <span class="fa fa-check"></span> <?= $feature->getNameEn(); ?>
                                                          </li>
                                                          @endforeach
                                                          </ul>
                                                          </div>


                                                          <div class="location-importance">
                                                          @if($project->getIntoLocation('en'))
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntoLocation('en')))); ?></li>
                                                          </ul>
                                                          @endif
                                                          <div class="line1">


                                                          <?php $p_governmental = $project->getGovernmental('en'); ?>
                                                          @if($p_governmental)
                                                          <div class="institutions">
                                                          <div class="title en-type">
                                                          <i class="fa fa-institution"></i>
                                                          <span><?= trans("front.service institutions"); ?></span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_governmental))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif

                                                          <?php $p_location = $project->getLocation('en'); ?>
                                                          @if($p_location)
                                                          <div class="location">
                                                          <div class="title en-type">
                                                          <i class="fa fa-map-marker"></i>
                                                          <span><?= trans("front.location"); ?></span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_location))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif
                                                          </div>

                                                          <div class="line2">

                                                          <?php $p_transportation = $project->getTransportation('en'); ?>
                                                          @if($p_transportation)
                                                          <div class="transport">
                                                          <div class="title en-type">
                                                          <i class="fa fa-car"></i>
                                                          <span><?= trans("front.transportation"); ?></span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_transportation))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif

                                                          <?php $p_future_look = $project->getFutureLook('en'); ?>
                                                          @if($p_future_look)
                                                          <div class="look">
                                                          <div class="title en-type">
                                                          <i class="fa fa-eye"></i>
                                                          <span><?= trans("front.future look"); ?></span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_future_look))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif
                                                          </div>
                                                          </div>



                                                          </section>
                                                          </div>


                                                          <div id="OverviewTab03" class="tab-contents scroll-bar-style">
                                                          <section class="about_project">
                                                          <h3 class="en-type">Vue générale... Installations et services</h3>
                                                          <div class="clearfix"></div>
                                                          <ul class="en-type">
                                                          <li><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntroFeaturesFr()))); ?></li>
                                                          </ul>

                                                          <div class="services">
                                                          <ul class="clearfix en-type">
                                                          @foreach($project->features as $feature)
                                                          <li class="col-md-3 col-sm-6 col-6 en-type">
                                                          <span class="fa fa-check"></span> <?= $feature->getNameFr(); ?>
                                                          </li>
                                                          @endforeach
                                                          </ul>
                                                          </div>


                                                          <div class="location-importance">
                                                          @if($project->getIntoLocation('fr'))
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($project->getIntoLocation('fr')))); ?></li>
                                                          </ul>
                                                          @endif
                                                          <div class="line1">


                                                          <?php $p_governmental = $project->getGovernmental('fr'); ?>
                                                          @if($p_governmental)
                                                          <div class="institutions">
                                                          <div class="title en-type">
                                                          <i class="fa fa-institution"></i>
                                                          <span>Institutions de services</span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_governmental))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif

                                                          <?php $p_location = $project->getLocation('fr'); ?>
                                                          @if($p_location)
                                                          <div class="location">
                                                          <div class="title en-type">
                                                          <i class="fa fa-map-marker"></i>
                                                          <span>Localité</span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_location))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif
                                                          </div>

                                                          <div class="line2">

                                                          <?php $p_transportation = $project->getTransportation('fr'); ?>
                                                          @if($p_transportation)
                                                          <div class="transport">
                                                          <div class="title en-type">
                                                          <i class="fa fa-car"></i>
                                                          <span>Transport</span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_transportation))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif

                                                          <?php $p_future_look = $project->getFutureLook('fr'); ?>
                                                          @if($p_future_look)
                                                          <div class="look">
                                                          <div class="title en-type">
                                                          <i class="fa fa-eye"></i>
                                                          <span>Un regard vers l’avenir</span>
                                                          </div>
                                                          <ul class="en-type">
                                                          <li class="en-type"><?= str_replace('•', '', str_replace('<br />', '</li><li>', nl2br($p_future_look))); ?></li>
                                                          </ul>
                                                          </div>
                                                          @endif
                                                          </div>
                                                          </div>



                                                          </section>
                                                          </div>
                                                          <?php */ ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Overview Section -->









                                        <!-- Google Reviews -->
                                        <!--                                        <div class="container-section testimonials-sec">
                                                                                    <h2><?= trans("front.testimonials"); ?></h2>
                                                                                </div>-->


                                        <!--                                        <div class="container-section num">
                                        
                                                                                        <div id="google-reviews"></div>
                                        
                                                                                    <script src="https://apps.elfsight.com/p/platform.js" defer></script>
                                                                                    <div class="elfsight-app-66a87652-ec88-4216-9abc-a78b2aaf36f7"></div>
                                        
                                        
                                                                                </div>-->


                                        <!-- Testimonials -->

                                        @include("front.partials.testimonials_slider", [])


                                    <?php } ?>


                                    <div class="int_content video_about">
                                        <h2 class="sub_title jazzira_font_bold"><?= trans("front.introductory video about damasturk title"); ?></h2> 
                            
                                        <?php
                                        if ($current_lang == "ar") {
                                            $videoId = "nhhdq_9I5NU";
                                            ?>
                                            <?php
                                        } elseif ($current_lang == 'pe') {
                                            $videoId = "k7l1o9nWtqs";
                                            ?>
                                            <?php
                                        } elseif ($current_lang == "fr") {
                                            $videoId = "uL6qeYqix58";
                                            ?>
                                            <?php
                                        } else {
                                            $videoId = "pUkewNbtGEI";
                                            ?>
                                        <?php } ?>
                            
                                        <iframe width="100%" height="480" src="https://www.youtube.com/embed/<?= $videoId ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>

                                    </div>





                                    @endsection

                                    @section('scriptjs')


                                    <?php if (App::isLocal()) { ?>
                                        <?= Html::script("js/slick.min.js"); ?>
                                        <?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.js"); ?>
                                    <?php } else { ?>
                                        <?= Html::script("js/slick.min.js"); ?>
                                        <?= Html::script("https://cdnjs.cloudflare.com/ajax/libs/flipclock/0.7.8/flipclock.js"); ?>
                                    <?php } ?>
                                    <script>
                                        /*
                                         jQuery(document).ready(function ($) {
                                         $("#google-reviews").googlePlaces({
                                         placeId: 'ChIJKUJszA2jyhQRCg7Srl6-SmE' //Find placeID @: https://developers.google.com/places/place-id
                                         , render: ['reviews']
                                         , min_rating: 4
                                         , max_rows: 4
                                         });
                                         });*/






                                        $(document).ready(function () {

                                            $('.like').click(function () {
                                                $(this).toggleClass("active");
                                            });


                                            $('.project-photo').slick({
                                                centerMode: true, lazyLoad: 'ondemand',
                                                centerPadding: '60px',
                                                slidesToShow: 1,
                                                responsive: [
                                                    {
                                                        breakpoint: 768,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    },
                                                    {
                                                        breakpoint: 480,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    }
                                                ]
                                            });



                                            $('.floor-plan').slick({
                                                lazyLoad: 'ondemand',
                                                centerMode: true,
                                                centerPadding: '60px',
                                                slidesToShow: 1,
                                                responsive: [
                                                    {
                                                        breakpoint: 768,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    },
                                                    {
                                                        breakpoint: 480,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    }
                                                ]
                                            });


                                            $('.videos.sliders').slick({
                                                centerMode: true, lazyLoad: 'ondemand',
                                                centerPadding: '60px',
                                                slidesToShow: 1,
                                                responsive: [
                                                    {
                                                        breakpoint: 768,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    },
                                                    {
                                                        breakpoint: 480,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    }
                                                ]
                                            });





                                            $('.project-video').slick({
                                                centerMode: true, lazyLoad: 'ondemand',
                                                centerPadding: '60px',
                                                slidesToShow: 1,
                                                responsive: [
                                                    {
                                                        breakpoint: 768,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    },
                                                    {
                                                        breakpoint: 480,
                                                        settings: {
                                                            arrows: false,
                                                            centerMode: true,
                                                            centerPadding: '40px',
                                                            slidesToShow: 1
                                                        }
                                                    }
                                                ]
                                            });

                                            /*
                                             $('.type_offer').slick({
                                             centerMode: true, lazyLoad: 'ondemand',
                                             centerPadding: '20px',
                                             slidesToShow: 1,
                                             responsive: [
                                             {
                                             breakpoint: 768,
                                             settings: {
                                             arrows: false,
                                             centerMode: true,
                                             centerPadding: '20px',
                                             slidesToShow: 1
                                             }
                                             },
                                             {
                                             breakpoint: 480,
                                             settings: {
                                             arrows: false,
                                             centerMode: true,
                                             centerPadding: '20px',
                                             slidesToShow: 1
                                             }
                                             }
                                             ]
                                             });
                                             */



                                            /* add all to same about video*/
                                            $(".videos.about a").attr("data-fancybox", "about");
                                            /* assign captions and title from alt-attributes of images:*/
                                            $(".videos.about a").each(function () {
                                                $(this).attr("data-caption", $(this).find("img").attr("alt"));
                                                $(this).attr("title", $(this).find("img").attr("alt"));
                                            });



                                            /* add all to same project video*/
                                            $(".videos.sliders a").attr("data-fancybox", "videos-slider");
                                            /* assign captions and title from alt-attributes of images:*/
                                            $(".videos.sliders a").each(function () {
                                                $(this).attr("data-caption", $(this).find("img").attr("alt"));
                                                $(this).attr("title", $(this).find("img").attr("alt"));
                                            });




                                            /* add all to same project-photo*/
                                            $(".project-photo a").attr("data-fancybox", "project-photo");
                                            /* assign captions and title from alt-attributes of images:*/
                                            $(".project-photo a").each(function () {
                                                $(this).attr("data-caption", $(this).find("img").attr("alt"));
                                                $(this).attr("title", $(this).find("img").attr("alt"));
                                            });
                                            /* start fancybox:*/
                                            $(".project-photo a").fancybox();



                                            /* add all to same floor-plan*/
                                            $(".floor-plan a").attr("data-fancybox", "floor-plan");
                                            $(".floor-plan a").each(function () {
                                                $(this).attr("data-caption", $(this).find("img").attr("alt"));
                                                $(this).attr("title", $(this).find("img").attr("alt"));
                                            });

                                            $(".floor-plan a").fancybox();

                                            /*
                                             // add all to same videos
                                             //        $(".videos a").attr("data-fancybox", "videos");
                                             //        // assign captions and title from alt-attributes of images:
                                             //        $(".videos a").each(function () {
                                             //            $(this).attr("data-caption", $(this).find("img").attr("alt"));
                                             //            $(this).attr("title", $(this).find("img").attr("alt"));
                                             //        });
                                             //        // start fancybox:
                                             //        $(".videos a").fancybox();
                                             
                                             
                                             // add all to same PDF
                                             //        $(".links-Pdf a").attr("data-fancybox", "pdf");
                                             //        // assign captions and title from alt-attributes of images:
                                             //        $(".links-Pdf a").each(function () {
                                             //            $(this).attr("data-caption", $(this).find("img").attr("alt"));
                                             //            $(this).attr("title", $(this).find("img").attr("alt"));
                                             //        });
                                             //        // start fancybox:
                                             //        $(".links-Pdf a").fancybox();
                                             */


                                            /* add all to same Info*/
                                            /*$(".links-info a").attr("data-fancybox", "infographic");*/

                                            $(".links-info a").each(function () {
                                                $(this).attr("data-caption", $(this).find("img").attr("alt"));
                                                $(this).attr("title", $(this).find("img").attr("alt"));
                                            });

                                            $(".links-info a").fancybox();


                                        });




                                        /*$(".showPdf").on("click", function () {
                                         $(this).toggleClass("open");
                                         $(".section-pdf").toggleClass("open");
                                         });*/




                                        /* Tab Script Offer Tabs*/
                                        $(function () {
                                            var $tabButtonItem = $('.offer-tabs #tab-button li'),
                                                    $tabSelect = $('#tab-select'),
                                                    $tabContents = $('.offer-tabs .tab-contents'),
                                                    activeClass = 'is-active';
                                            $tabButtonItem.first().addClass(activeClass);
                                            $tabContents.not(':first').hide();
                                            $tabButtonItem.find('a').on('click', function (e) {
                                                var target = $(this).attr('href');
                                                $tabButtonItem.removeClass(activeClass);
                                                $(this).parent().addClass(activeClass);
                                                $tabSelect.val(target);
                                                $tabContents.hide();
                                                $(target).show();
                                                e.preventDefault();
                                            });
                                            $tabSelect.on('change', function () {
                                                var target = $(this).val(),
                                                        targetSelectNum = $(this).prop('selectedIndex');
                                                $tabButtonItem.removeClass(activeClass);
                                                $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
                                                $tabContents.hide();
                                                $(target).show();
                                            });
                                        });

                                        /* Tab Script Overview Tabs*/
                                        $(function () {
                                            var $tabButtonItem = $('.overview-tabs #tab-button li'),
                                                    $tabSelect = $('#tab-select'),
                                                    $tabContents = $('.overview-tabs .tab-contents'),
                                                    activeClass = 'is-active';
                                            $tabButtonItem.first().addClass(activeClass);
                                            $tabContents.not(':first').hide();
                                            $tabButtonItem.find('a').on('click', function (e) {
                                                var target = $(this).attr('href');
                                                $tabButtonItem.removeClass(activeClass);
                                                $(this).parent().addClass(activeClass);
                                                $tabSelect.val(target);
                                                $tabContents.hide();
                                                $(target).show();
                                                e.preventDefault();
                                            });
                                            $tabSelect.on('change', function () {
                                                var target = $(this).val(),
                                                        targetSelectNum = $(this).prop('selectedIndex');
                                                $tabButtonItem.removeClass(activeClass);
                                                $tabButtonItem.eq(targetSelectNum).addClass(activeClass);
                                                $tabContents.hide();
                                                $(target).show();
                                            });
                                        });






                                        /*- Countdown Timer -*/

                                        /*set start point anywhere you want*/
                                        var start = new Date(<?= date('Y') ?>,<?= date('m') ?>,<?= date('d') ?>,<?= date('H') ?>,<?= date('i') ?>);
                                        /*new Date(year, month - 1, day, hours, minutes, seconds, milliseconds);*/

<?php
if ($project->offer_duration != '') {
    $dateTime = strtotime($project->offer_duration);
    ?>
                                            var end = new Date(<?= date('Y', $dateTime) ?>, <?= date('m', $dateTime) ?>, <?= date('d', $dateTime) ?>, 0, 0, 0, 0);

                                            var duration = end - start;
                                            duration = duration / 1000;



                                            $(function () {
                                                $("#countdown").FlipClock(duration, {
                                                    clockFace: 'DailyCounter',
                                                    countdown: true
                                                });
                                            });

<?php } ?>




<?php //if (Helper::get_device() == 'mob') { ?>
if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
	$(window).scroll(function () {
		var footerTop = $('#footer').offset().top - 800;
		var wS = $(this).scrollTop();
		if (wS >= footerTop) {
			$("#ytsubscribe").fadeOut();
		} else {
			$("#ytsubscribe").fadeIn();
		}
	});
}
<?php //} ?>

                                        $('select.currency').change(function () {
                                            $('.tprice').addClass('hidden');
                                            $('.tp' + $(this).val()).removeClass('hidden').removeClass('d-none');
                                        });

                                    </script>




                                    @endsection