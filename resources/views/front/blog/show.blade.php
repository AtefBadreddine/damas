<?php
if (Helper::get_device() == 'tab') {
    $_GET['device'] = 'full';
}
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';

$ccountry = (Helper::container_array(\Route::getCurrentRoute()->getPath(), ['oman'])?'oman':'turkey');
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
/* $arr_prices = [
  "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
  ]; */
$right = ($style_lang == 'ar' ? 'right' : 'left');
$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
//$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/faq.css"); ?>
    <?= Html::style("resources/assets/css/blog.css"); ?>
    <?= Html::style("resources/assets/css/article.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?php if ($current_lang == 'en') { ?>

    <?php } ?>





<?php } else { ?>

    <?= Html::style("css/blog.min.css"); ?>
    <?= Html::style("css/article.min.css"); ?>
    <?= Html::style("css/slider-project-card.min.css"); ?>

<?php } ?>


@endsection



<?php /*
  @extends('front.layout', [
  'hide_onesignal'=>true,
  "page_description" => $infos->seo_description,
  "page_keywords" => $infos->seo_keywords,
  "amp_url"  =>  route("amp.front.index"),
  "og_image"          =>   Helper::media_url_full($post->photoCard),
  ]) */ ?>
@extends('front.layout', [
"page_title" => $post->getSeoTitle(),
"page_description" => $post->getSeoDescription(),
"page_keywords" => $post->getSeoKeywords(),
"og_image"  =>  Helper::media_url_full($post->photoCard),
"amp_url"    =>   route("amp.front.blog.post", $post->slug),
"viewed_post"    =>    $post->id,
"page_index" => ($post->prevent_archiving_in_blog==true?'noindex':'')
])


@section('main_content')

<style>
    .trees li.uli_h2:before{ width: 16px; }
    .trees li.uli_h3:before{ width: 32px; }
    .trees li.uli_h4:before{ width: 48px; }
    .trees li.uli_h5:before{ width: 64px; }

    .trees li.uli_h2{ padding-<?= $style_lang == 'ar' ? 'right' : 'left' ?>: 16px; }
    .trees li.uli_h3{ padding-<?= $style_lang == 'ar' ? 'right' : 'left' ?>: 30px; }
    .trees li.uli_h4{ padding-<?= $style_lang == 'ar' ? 'right' : 'left' ?>: 46px; }
    .trees li.uli_h5{ padding-<?= $style_lang == 'ar' ? 'right' : 'left' ?>: 62px; }

    .blog_info_sec{
        float: left;
        width: 100%;
        position: relative;
        background-color: #ffffff;
        border-radius: 20px;
        padding: 15px;
        margin-bottom: 20px;
        margin-top: 0px;
    }
    .blogTitle{
        text-align: right;
        direction: rtl;
        font-size: 25px;
        line-height: 36px;
        color: #058687;
        margin: 10px 0px 15px 0px;
    }
    .lazy.blog_photo{
        height: 528px;
    }
    .lazy.blog_photo.loaded{
        float: left;
        width: 100%;
        height: auto;
        display: block;
        border-radius: 10px;
        margin: 15px 0px 0px 0px
    }
    .category_blog{
        float: right;
        width: auto;
        margin-left: 15px;
    }
    .category_blog svg{
        width: 21px;
        position: relative;
        top: 3px;
    }
    .category_blog strong {
        font-size: 16px;
    }
    .category_blog.date{
        border-left: 1px solid #cccccc;
        padding-left: 10px;
    }
    .category_blog.date svg{
        width: 15px;
    }
    .category_blog.view_num{
        float: left;
        margin: 0px;
    }
    .category_blog.view_num svg{
        width: 15px;
        position: relative;
        top: 5px;
    }
    .article_titles h2{
        text-align: right;
        direction: rtl;
        font-size: 20px;
        line-height: 36px;
        color: #058687;
        margin: 10px 0px 0px 0px;
    }
    /*Tree*/

    .trees {
        margin: 0px 0px 10px 0px;
    }

    .trees li {
        border-right: solid 1px #e3e3e3;
        padding: 1px 20px 0px 20px;
        position: relative;
        text-align: right;
        list-style: none;
    }

    .trees li > label {
        position: relative;
        left: auto;
        right: 1px;
        top: -5px;
        margin: 0px;
        font-size: 15px;
        line-height: 28px;
        direction: rtl;
    }
    .trees li > label a{
        font-size: 17px;
        color: #17a8a9;
    }
    .trees li > label a.active,
    .trees li > label a:hover{
        color: #058687;
    }

    .trees li:before {
        content: "";
        width: 16px;
        height: 1px;
        border-bottom: solid 1px #e3e3e3;
        position: absolute;
        top: 10px;
        left: auto;
        right: 0px;
    }

    .trees li:last-child:after {
        content: "";
        position: absolute;
        width: 2px;
        height: 18px;
        background: #fff;
        left: auto;
        right: -1px;
        bottom: 0px;
    }

    .trees li input {
        margin-right: 5px;
        margin-left: 5px
    }

    .trees li.has-child > ul {
        display: none
    }

    .trees li.has-child > input {
        opacity: 0;
        position: absolute;
        left: auto;
        right: -14px;
        z-index: 9999;
        width: 22px;
        height: 22px;
        top: -5px;
        cursor: pointer;
    }

    .trees li.has-child > input + .tree-control {
        position: absolute;
        left: auto;
        right: -4px;
        top: 6px;
        width: 8px;
        height: 8px;
        line-height: 8px;
        z-index: 2;
        display: inline-block;
        color: #fff;
        border-radius: 3px;
    }

    .trees li.has-child > input + .tree-control:after {
        font-family: 'FontAwesome';
        content: "";
        font-size: 13px;
        color: #6a6a6a;
        position: absolute;
        left: auto;
        right: 1px;
    }

    .trees li.has-child > input:checked + .tree-control:after {
        font-family: 'FontAwesome';
        content: "";
        font-size: 13px;
        color: #17a8a9;
        position: absolute;
        left: auto;
        right: 1px;
    }

    .trees li.has-child > input:checked ~ ul {
        display: block
    }

    .trees ul li.has-child:last-child {
        border-right: none;
    }

    .trees ul li.has-child:nth-last-child(2):after {
        content: "";
        width: 1px;
        height: 5px;
        border-right: solid 1px #e3e3e3;
        position: absolute;
        bottom: -5px;
        left: auto;
        right: -1px;
    }

    .tree-alt li {
        padding: 4px 0
    }

    @media (max-width: 500px){
        .lazy.blog_photo {
            height: 350px;
        }
        .blogTitle {
            font-size: 20px;
            line-height: 29px;
            margin: 0px 0px 15px 0px;
        }

    }

    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        .blogTitle {
            text-align: left;
            direction: ltr;
        }
        .category_blog {
            float: left;
            width: auto;
            margin-left: 15px;
        }
        .category_blog.date {
            border-left: 0px;
            padding-left: 0px;
            margin-left: 0px;
        }
        .category_blog.view_num {
            float: right;
        }
        .article_titles h2 {
            text-align: left;
            direction: ltr;
        }
        .trees li {
            border-right: 0px;
            border-left: solid 1px #e3e3e3;
            text-align: left;
        }
        .trees li::before {
            left: 0px;
            right: auto;
        }
    <?php } ?>
    .blog-content table {
        width: 100%;
    }
    .blog-content table tbody {
        display: table-row-group !important;
    }
    .blog-content table th,
    .blog-content table td {
        padding-inline-end: 30px;
    }
</style>

<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">

        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec article">
                <a class="filter_btn back_btn" onclick="goBack()">
                    <svg width='10' height='18' version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 281.1 520.5" xml:space="preserve"> <g> <g> <path d="M8.1,274.3l236.8,236.2c7.8,7.7,20.3,7.7,28.1,0c7.7-7.8,7.7-20.3,0-28.1L50.3,260.3L273,38.1c7.8-7.7,7.8-20.3,0-28.1 c-3.9-3.9-9-5.8-14.1-5.8c-5.1,0-10.1,1.9-14,5.8L8.1,246.2c-3.7,3.7-5.8,8.8-5.8,14S4.4,270.6,8.1,274.3z"/> </g> </g> </svg>
                </a>


                <!--                <a class="titles_btn">
                                    <div class="list_title"><?= trans("front.article titles"); ?></div>
                                    <div class="menu-icon">
                                        <input class="menu-icon__cheeckbox" type="checkbox" />
                                        <div>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                </a>-->



            </div>


            <?php
                $breadcrumbCountry = $post->countryRel ?: \App\Models\Country::findByCode($post->country);
                $breadcrumbCountrySlug = $post->getCountrySlug();
                $breadcrumbPostLabel = trim((string) $post->getTitle());
                if ($breadcrumbPostLabel === '') {
                    $breadcrumbPostLabel = $post->slug;
                }
            ?>
            <div class="scp-breadcrumb">
                <ul class="breadcrumb">
                    <li><a href="{{ route('front.index') }}"><i class="fa fa-home"></i></a></li>
                    @if($breadcrumbCountry && $breadcrumbCountrySlug)
                    <li><a href="{{ $breadcrumbCountry->listingUrl() }}">{{ $breadcrumbCountry->getTitle() }}</a></li>
                    @endif
                    @if($breadcrumbCountrySlug)
                    <li><a href="{{ $listingUrl }}">{{ trans('front.' . $type) }}</a></li>
                    @endif
                    <li class="active">{{ $breadcrumbPostLabel }}</li>
                </ul>
            </div>




            <div class="int_content">
                <div style="display:none">{{ \Route::getCurrentRoute()->getPath() }}</div>
                <div class="blog_info_sec shadow_type  <?php if ($post->with_projects_blog==true) { ?> blog_content_sec <?php } ?>">
                    <h1 class="blogTitle jazzira_font_bold"><?= $post->getTitle(); ?></h1>

                    <span class="category_blog date"> <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="calendar-alt" role="img" viewBox="0 0 448 512" class="svg-inline--fa fa-calendar-alt fa-w-14 fa-3x"><g class="fa-group"><path fill="currentColor" d="M0 192v272a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48V192zm128 244a12 12 0 0 1-12 12H76a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h40a12 12 0 0 1 12 12zm0-128a12 12 0 0 1-12 12H76a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h40a12 12 0 0 1 12 12zm128 128a12 12 0 0 1-12 12h-40a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h40a12 12 0 0 1 12 12zm0-128a12 12 0 0 1-12 12h-40a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h40a12 12 0 0 1 12 12zm128 128a12 12 0 0 1-12 12h-40a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h40a12 12 0 0 1 12 12zm0-128a12 12 0 0 1-12 12h-40a12 12 0 0 1-12-12v-40a12 12 0 0 1 12-12h40a12 12 0 0 1 12 12zm-80-180h32a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16h-32a16 16 0 0 0-16 16v96a16 16 0 0 0 16 16zm-192 0h32a16 16 0 0 0 16-16V16a16 16 0 0 0-16-16h-32a16 16 0 0 0-16 16v96a16 16 0 0 0 16 16z" class="fa-secondary"></path><path fill="currentColor" d="M448 112v80H0v-80a48 48 0 0 1 48-48h48v48a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V64h128v48a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V64h48a48 48 0 0 1 48 48z" class="fa-primary"></path></g></svg>
                        <strong><?= date_format(new DateTime($post->update_date), "d/m/Y"); ?></strong>
                    </span>

                    <span class="category_blog"> <svg version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 328.4 254.4" xml:space="preserve"><g> <path class="st0" d="M164.7,69.8c50.2,0,100.3,0,150.5,0c10.5,0,13.8,3.6,13,14c-4,52.8-8.1,105.7-12.2,158.5 c-0.6,7.8-5.4,12.1-13.6,12.1c-22.7,0-45.3,0-68,0c-68.8,0-137.7,0-206.5,0c-11.1,0-14.9-3.6-15.7-14.7 c-4-52.2-8.1-104.3-12.1-156.5c-0.7-9.6,2.8-13.4,12.6-13.4C63.4,69.8,114.1,69.8,164.7,69.8z"></path> <path class="st0" d="M314.3,64.4c-5.2,0-9.6,0-14.4,0c-0.1-1.7-0.2-3.1-0.4-4.6c-0.6-5.7-4.6-9.9-10.2-10.7 c-1.8-0.2-3.7-0.3-5.5-0.3c-79.8,0-159.7,0-239.5,0c-4.6,0-9.5-0.1-12.2,4.1c-2.1,3.1-3,7.1-4.6,11.3c-3.5,0-7.9,0-13,0 c-0.1-1.5-0.3-3.1-0.3-4.7c0-15.7,0-31.3,0-47c0-8.9,3.4-12.4,12.4-12.5c29.5-0.1,59-0.1,88.5,0c8.4,0,14.7,3.9,18.3,11.6 c0.6,1.2,1.2,2.4,1.8,3.6c4.4,9,11.6,13.4,21.6,13.3c48,0,96,0,144,0c10.6,0,13.6,3,13.6,13.7C314.3,49.5,314.3,56.6,314.3,64.4z"></path> </g> </svg> 
                        <strong>
                            <?php
                            $post_cat = '';
                            foreach ($post->categories()->lists('name_' . ($current_lang == 'pe' ? 'fa' : $current_lang)) as $cat) {
                                echo $cat;
                                break;
                            }
                            ?>
                        </strong> 
                    </span>

                    <span class="category_blog view_num"> 
                        <svg viewBox="0 0 16 12" id="02603270c0086ab7fbbc4949900ab8f7"><path fill-rule="evenodd" d="M15.929 5.629C15.837 5.399 13.61 0 7.992 0S.148 5.4.056 5.629a1 1 0 000 .742C.148 6.602 2.374 12 7.992 12s7.845-5.4 7.937-5.629a1 1 0 000-.742zM7.992 10c-3.552 0-5.362-2.933-5.9-4 .542-1.055 2.373-4 5.9-4 3.552 0 5.363 2.934 5.9 4-.538 1.052-2.369 4-5.9 4zm0-6a2 2 0 102 2 2 2 0 00-2-2z"></path></svg>
                        <strong class="num"><?= $post->views ?></strong> 
                    </span>

					<?php /*
                    <img width="100%" height="528" class="lazy blog_photo" 
					data-src="<?= Helper::media_url($post->photoCard) ?>" alt="<?= $post->getTitle(); ?>"/>
					*/ ?>
					
					<picture>
					   <source media="(min-width: 650px)" srcset="<?= Helper::media_url($post->photoCard,'','',true) ?>">
					   <source media="(max-width: 650px)" srcset="<?= Helper::media_url($post->photoCard,'','',true) ?>">
					   <img src="<?= Helper::media_url($post->photoCard,'','',true) ?>" class="lazy blog_photo loaded" 
					   loading="lazy" alt="<?= $post->getTitle(); ?>" width="100%" height="528">
					</picture>
					

                    <!--                    @if($post->photoCard)
                    
                                        {!! Helper::get_pic(Helper::media_url($post->photoCard),'lazy blog_photo','','',$post->getTitle(), '') !!}
                    
                                        @endif-->


                    <div class="sec">
                        <section class=" article_titles">
                            <h2 class="jazzira_font_bold"><?= trans("front.article titles"); ?></h2>



                            <div class="tree-box box-border">
                                <ul class="trees">

                                </ul>
                                
                            </div>

                        </section>
                    </div>


                    <div class="sec">
                        <section class="faq-section">

                            <div class="row">
                                <!-- ***** FAQ Start ***** -->

                                <div class="col-md-12">
                                    <div class="faq" id="accordion">
                                        <?php
										$arr_que = [];
										$arr_res = [];
                                        $i = 0;
                                        foreach ($faqs as $faq) {
                                            $i++;
                                            $q = 'q_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
                                            $res = 'r_' . ($current_lang == 'pe' ? 'fa' : $current_lang);

                                            if (trim($faq->$q) != '') {
												$arr_que[] = $faq->$q;
												$arr_res[] = $faq->$res;
                                                ?>
                                                <div class="card">
                                                    <div class="card-header" id="faqHeading-<?= $i ?>">
                                                        <div class="mb-0">
                                                            <h2 class="faq-title jazzira_font_bold" data-toggle="collapse" data-target="#faqCollapse-<?= $i ?>" data-aria-expanded="true" data-aria-controls="faqCollapse-1">
                                                                <i class="arrow"></i>
                                                                <span class="num"><?= $i ?></span>
                                                                <?= $faq->$q ?>
                                                            </h2>
                                                        </div>
                                                    </div>
                                                    <div id="faqCollapse-<?= $i ?>" class="collapse" aria-labelledby="faqHeading-<?= $i ?>" data-parent="#accordion">
                                                        <div class="card-body">
                                                            <p>
                                                                <?= $faq->$res ?>
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


                    <div class="blog_content sec">
                        <?php
                        $html = html_entity_decode($post->getContent());
                        $html = str_replace('damas.net/jX7', 'damas.net/whatsapp_share?icon=10&tel=905551605000', $html);
                        $yt = explode('youtube.com/embed/', $html);

                        if (isset($yt[1])) {
                            $ytbvid = explode('"', $yt[1])[0];

                            $ytbvid = explode('&', $ytbvid)[0];

                            $post_video = \App\Models\Video::where('link', 'like', '%' . $ytbvid . '%')->first();
                        }



//$html = str_replace(["https://www.youtube.com/embed/","//www.youtube.com/embed/"],"",$html);
                        /* if(preg_match_all('~(http://www\.youtube\.com/watch\?v=[%&=#\w-]*)~',$input,$m)){

                          }
                         */




                        //$html = html_entity_decode($html);
                        $doc = new \DOMDocument();

                        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
                        @$doc->loadHTML(trim((string) $html) !== '' ? $html : '<div></div>');

                        //if (Helper::get_device() == 'mob') {
                            $tags = $doc->getElementsByTagName('img');
							$i=0;
							$list_imgs = [];
                            foreach ($tags as $tag) {
								$i++;
								//echo '<h1>'.$tag->getAttribute('src').'</h1>';
								$mob_url = $tag->getAttribute('src');
								$list_imgs[$i]['mob'] = $mob_url;
								$full_url = $tag->getAttribute('src');
								$list_imgs[$i]['full'] = $full_url;
                                $t = explode('uploads/', $tag->getAttribute('src'));
                                if (isset($t[1])) //isset uploads/ in url
                                    if (file_exists('uploads/' . str_replace('.jpg', '_mobile.jpg', $t[1]))) {
										//$mx = str_replace('.jpg', '_mobile.jpg', $full_url);
                                        $mob_url = str_replace('.jpg', '_mobile.jpg', $full_url);
                                        $list_imgs[$i]['mob'] = $mob_url;
										//$html = str_replace($t[1], $mx, $html);
                                    } else {
                                        $tt = DB::table("medias")->select("filename_mobile")->where('filename', $t[1])->limit(1)->get();
                                        if (count($tt) > 0 and file_exists('uploads/' . $tt[0]->filename_mobile)) {
                                            $mob_url = $tt[0]->filename_mobile;
											//$html = str_replace($t[1], $tt[0]->filename_mobile, $html);
											$list_imgs[$i]['mob'] = '/uploads/' . $mob_url;
                                        }
                                    }



								$clone = $tag->cloneNode();
								$fancyHref = $doc->createElement('picture'.$i);
								$fancyHref->appendChild( $clone );
								$tag->parentNode->replaceChild( $fancyHref, $tag );
								
                            }
                        //}
					$html = $doc->saveHTML();
					
					
					foreach($list_imgs as $k=>$v){
						$html = str_replace('<picture'.$k.'>','<picture>
					   <source media="(min-width: 650px)" srcset="'.$list_imgs[$k]['full'].'">
					   <source media="(max-width: 650px)" srcset="'.$list_imgs[$k]['mob'].'">',$html);
						$html = str_replace('</picture'.$k.'>','</picture>',$html);
					}
					$html = str_replace('<img ','<img loading="lazy" ',$html);
					/*<picture>
					   <source media="(min-width: 650px)" srcset="$full_url">
					   <source media="(max-width: 650px)" srcset="$mob_url">
					   <img src="#full#" loading="lazy">
					</picture>*/

                        /* $arr_h2 = [];
                          $h2s = $doc->getElementsByTagName('h2');
                          foreach ($h2s as $h2) {
                          $arr_h2[] = ($h2);
                          }

                          function str_replace_first($from, $to, $content) {
                          $from = '/' . preg_quote($from, '/') . '/';
                          return preg_replace($from, $to, $content, 1);
                          }

                          $html = str_replace('<h2 id="mcetoc', '<h2 style-id="', $html);
                          $html = str_replace('<h2>', '<h2 style-id="">', $html);

                          $i = 0;
                          foreach ($arr_h2 as $h2) {
                          $i++;

                          $html = str_replace_first('<h2 style', '<h2 id="title_' . $i . '" style', $html);
                          } */

                        //$html = str_replace('الجنسية التركية', '<a href="' . route("front.turkish_citizenship") . '" target="_blank">الجنسية التركية</a>', $html);
                        //$html = Helper::add_links_html(html_entity_decode($html),$current_lang);



						$html = str_replace('</strong><strong>','',$html);
						$html = str_replace(' style="text-align: justify;"','',$html);
						$html = preg_replace('/<span[^>]+\>/i', '', $html);
                        echo html_entity_decode($html);
                        ?>

                        @if($video_code!='')
                        <section class="youtube-video" id="section_images_videos">
                            <a data-fancybox="video" class="video_fancybox" href="https://www.youtube.com/embed/<?= $video_code; ?>">
                                <svg class="faa-ring animated" height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>
                                <img class="cover lazy" loading="lazy" src="https://i.ytimg.com/vi/<?= $video_code; ?>/hqdefault.jpg">
                            </a>
                        </section>
                        @endif
                        <?php
                        if ($video_code != '')
                            $post_video2 = \App\Models\Video::where('link', 'like', '%' . $video_code . '%')->first();
                        ?>
                    </div>


                    <div class="share_content sec">
                        <p><?= trans("front.share"); ?>:</p>
                        <ul>
                            <li><a rel="nofollow" href="https://facebook.com/sharer.php?u=<?= urlencode($post->frontUrl()) ?>"><i class="fa fa-facebook-f"></i></a></li>
                            <li><a rel="nofollow" href="https://twitter.com/intent/tweet?url=<?= urlencode($post->frontUrl()) ?>&amp;text=<?= $post->getTitle() ?>&amp;via=damasturk"><i class="fa fa-twitter"></i></a></li>
                            <li><a rel="nofollow" href="https://api.whatsapp.com/send?text=<?= ($post->frontUrl()) ?>"><i class="fa fa-whatsapp"></i></a></li>
                            <li><a rel="nofollow" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($post->frontUrl()) ?>"><i class="fa fa-linkedin"></i></a></li>
                            <li><a rel="nofollow"><i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>


                    
                    <?php if ($post->with_projects_blog==true) { ?> 
                            <div class="action_content">
                                <span class="show_more_btn"><?= trans("front.read more"); ?></span>
                                <span class="show_less_btn"><?= trans("front.read less"); ?></span>
                            </div>
                    <?php } ?>
                    
                    
                </div>
            </div>

			<?php
            if ($post->with_projects_blog==true) { ?>
                <div class="int_content">
                    <div class="shadow_type">
                        <div class="int_content project_card">
                            <div class="wrapper block_sec sec show">
								
                            </div>
                        </div>
						<?php
						
						$t = explode('.com/',$post->projects_url);
						$projects_url = \LaravelLocalization::localizeUrl(@$t[1]);
						
						?>
						<div style="
							text-align: center;
							margin: 0px 0 34px 0;
						"><a href="{{ $projects_url }}" class="more shadow_type" style="float:none">
						<?= trans("front.show more"); ?>
						</a></div>

						<?php /*<nav class="pagination_list" aria-label="Page navigation example"> 
						<ul class="pagination justify-content-end num" style=" width: 100%;text-align:center;min-height: auto;">
						<nav class="pagination_list" aria-label="Page navigation example"> 
						<ul class="pagination justify-content-end num" style=" width: 100%;text-align:center;min-height: auto;"> 
						<li>
						<a class="btn load_more" href="<?= $post->projects_url ?>?page=2">
						<i class="fa fa-spinner fa-spin"></i></a>
						</li>
						</ul>
						</nav>
						</ul>
						</nav>*/ ?>
						
						
                    </div>
					
				

				
				</div>
            <?php } ?>


            <?php /*
              $keyws = $post->getSeoKeywords();
              if ($keyws != '') {
              $arrk = explode(',', $keyws);
              ?>
              <!--<div class="int_content keywords_sec">
              <div class="blog_info_sec shadow_type">

              <h2 class="sub_title jazzira_font_bold">{{ trans('front.keywords') }}</h2>
              <?php
              foreach ($arrk as $k) {
              $k = trim($k);
              if ($k != '') {
              ?>
              <a href="<?= route("front.searchpage") . '?s=' . $k; ?>"><?= $k ?></a>
              <?php
              }
              }
              ?>
              </div>
              </div>-->
              <?php } */ ?>

            <?php
            $lang_t = (\LaravelLocalization::getCurrentLocale() == 'pe' ? 'fa' : \LaravelLocalization::getCurrentLocale());
            $keyws = $post->tags()->where('title_' . $lang_t, '!=', '')->get();
            if (count($keyws) > 0) {
                ?>
                <div class="int_content keywords_sec">
                    <div class="blog_info_sec shadow_type">

                        <h2 class="sub_title jazzira_font_bold">{{ trans('front.keywords') }}</h2>
                        <?php foreach ($keyws as $k) { ?>
                            <a href="<?= route("front.tag", [$k->slug]) ?>"><?= $k->getTitle() ?></a>
                            <?php
                        }
                        ?>

                    </div>
                </div>
            <?php } ?>




            <?php
            $similars = explode(",", $post->similar_posts);
            
            //if($post->similar_posts==''){
                
                $params = Helper::query("BlogParam", "find", ["id" => ($ccountry=='turkey'?1:3)]);
                if ($params->featured_post != '')
                    $similars = explode(",", $params->featured_post);
            //}
            
            if(count($similars)>0){
                
                ?>
                <div class="int_content">
                    <div class="similar_articles sec">
                        <p class="sub_title jazzira_font_bold"><?= trans("front.related posts"); ?></p>

                        <div class="wrapper sec">

                            <div class="slider video_slider" dir="<?= $current_lang === 'ar' ? 'rtl' : 'ltr' ?>">

                                <div class="slider__wrap swiper-wrapper">


                                    @foreach($similars as $id)
                                    <?php
                                    $spost = Helper::query("Post", "find", ["id" => $id]);
                                    if (!$spost->id)
                                        continue;
                                    ?>
                                    @include("front.partials.post_item", ["post" => $spost, "open_blank" => false, "class" => "card-small","page"=>"index"])
                                    @endforeach



                                </div>

                                <div class="slider__controls">

                                    <div class="slider__pagination"></div>

                                    <div class="slider__button-next"></div>
                                    <div class="slider__button-prev"></div>
                                </div>


                                <a href="{{ $listingUrl }}" class="more shadow_type"><?= trans("front.show more"); ?></a>


                            </div>

                        </div>

                    </div>
                </div>

                <!--<div class="int_content not_bg">-->
            <?php } ?>











            <?php
//$post_projects = $post->projects;
            $arr_ids = Helper::query("Fotterproject", "all")->where('country',$ccountry)->lists('project_id')->toArray();
            $footer_prjs = \App\Models\Project::whereIn('id', $arr_ids)->get();
            
            if (count($footer_prjs)) {
                ?>
                <p class="sub_title jazzira_font_bold"><?= trans("front.Featured projects"); ?></p>


                <div class="wrapper sec">

                    <div class="slider" <?php if ($current_lang == 'ar') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>

                        <div class="slider__wrap swiper-wrapper">


                            <?php $t = 0; ?>
                            @foreach($footer_prjs as $prj)
								@include("front.partials.project_item", ["project" => $prj, "open_blank" => false, "class" => "card-small","page"=>"index"])
                            @endforeach


                        </div>

                        <div class="slider__controls">

                            <div class="slider__pagination"></div>

                            <div class="slider__button-next"></div>
                            <div class="slider__button-prev"></div>
                        </div>

                        <a href="{{ route('front.search', ['property-for-sale', $ccountry]) }}" class="more shadow_type"><?= trans("front.More Projects"); ?></a>

                    </div>

                </div>
            <?php } ?>



            <!--</div>-->


        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">
            <div class="fixed_sec ">


                <section class="form shadow_type">
                    @include("front.partials.call_us_fixed", [ 'hide_whatsapp' => $hide_whatsapp ])
                </section>

                @include("front.partials.blog_filter",['_pg'=>'blogshow','type'=>$type])

            </div>
        </div>
        <!-- End Fixed Section -->





    </div>
</div>







@endsection



@section('scriptjs')
<?php if (count($arr_que) > 0) { ?>
<?= Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"); ?>
<!--<?= Html::script("js/swiper.min.js"); ?>-->
<?php } ?>


<script>
    
    document.querySelectorAll(".slider__wrap.swiper-wrapper").forEach(curr => {
        curr.scrollLeft = <?= $current_lang === "ar" ? -100 : 100 ?>;
    });
    
    

    function goBack() {
        window.history.back();
    }


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
		/*$.getJSON( "{{ route('front.ajax','increment_visit') }}?post=<?= $post->id ?>", function(data){});*/
		$.ajax({
		type: 'POST',
		url: "{{ route('front.ajax','increment_visit') }}",
		data: {"post":"<?= $post->id ?>"},
		success: function(data) {  }
		});

		
				
<?php if ($type == 'news') { ?>
            $('.main_menu .links>li>a.news_btn').addClass("active");
<?php } else { ?>
            $('.main_menu .links>li>a.blog_btn').addClass("active");
<?php } ?>


        $("body").on("click", ".scrol_to", function (e) {
            e.preventDefault();
            var href = $(this).attr('href');

            $('html, body').animate({scrollTop: $(href).position().top}, 'slow');
        });

        $(".menu-icon").click(function () {
            $(".article_titles").toggleClass("open");
        });






        $('.collapse').on('show.bs.collapse', function () {
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

        $('.collapse').on('hide.bs.collapse', function () {
            var card = $(this).closest(".card");
            var cardHeader = $(this).closest(".card").find(".card-header");
            $(cardHeader).removeClass("active");
            $(card).removeClass("active");
        });


    });


    var startScroll = 150;
    var supportLinks = $(".support_links");
    var oldsctop = $(window).scrollTop();
    $(window).scroll(function () {

        /*console.log('old' + oldsctop + ' ----new: '+ $(this).scrollTop());*/
        if (($(this).scrollTop()) > oldsctop) {
            $(".top_control_sec").addClass("scrollMob");
            $(".article_titles").addClass("scrollMob");
        } else {
            $(".top_control_sec").removeClass("scrollMob");
            $(".article_titles").removeClass("scrollMob");
        }
        oldsctop = $(this).scrollTop();
    });


</script>
<script>

    $(document).ready(function () {

        var html = '';
        $('.box-border ul.trees').html('');

        $('.blog_content h2').each(function (i) {/*,.blog_content h3,.blog_content h4,.blog_content h5*/
            var tagname = this.tagName.toLowerCase();
            $(this).prop('id', tagname + i);
            html = html + '<li class="uli_' + tagname + '"><label><a class="scrol_to" href="#' + (tagname + i) + '">' + $(this).text() + '</a></label></li>';
        });


        $('.box-border ul.trees').html(html);
		
		
		
		
		/*add keywords blocks*/
		<?php
			$f_lang = ($current_lang=='pe'?'fa':$current_lang);
			$cat_id = @$post->categories[0]->id;
			
			$arr_keys = \App\Models\Keywords2::where('display','like','%;' . $cat_id . ';%')->where('keyword_'.$f_lang,'!=','')->get();
			
			if(count($arr_keys)>0){
			?>
			var html_keyword = '<p class="keywords_paragraph"><span class="jazzira_font_bold"><?= trans("front.The most important and latest real estate projects"); ?></span><strong class="jazzira_font_bold"><a title="%keyword%" href="%url%">%keyword%</a></strong></p>';
			var arr_keywords = Array();
			
				<?php foreach($arr_keys as $r){ ?>
					arr_keywords.push({'url':'<?= htmlentities($f_lang=='ar'?$r->url:str_replace('.com/','.com/'.$f_lang.'/',$r->url)) ?>','keyword':'{{ htmlentities($r->getKeyword()) }}'});
                <?php } ?>


display_keywords(arr_keywords,html_keyword);

function display_keywords(arr_keywords,html_keyword){
	if(arr_keywords.length>0){
		
		
	var cnt_sec = $( ".blog_content.sec" ).children().length/(arr_keywords.length +1);
	if(cnt_sec<2)
	cnt_sec = cnt_sec+2;

	var j=0;
	for(var i=0;i<arr_keywords.length;i++){
	j++;
	var icnt_sec = Math.ceil(i*cnt_sec);
	if(icnt_sec+j < $( ".blog_content.sec" ).children().length-2 )
	$( ".blog_content.sec" ).children().eq(icnt_sec+j).after(html_keyword.replace('%url%',arr_keywords[i].url).replace('%keyword%',arr_keywords[i].keyword).replace('%keyword%',arr_keywords[i].keyword));
	}
	}
}




			<?php } ?>
		
    });
	</script>

<?php
if ($post->with_projects_blog==true) { ?>
<script>
var first_load_project = false;
var old_href = '';
var href = '';
var height_plus = 2;

/*
	$(window).scroll(function() {
		if(first_load_project == true){
		if($(window).scrollTop() >= $(document).height() - $(window).height()- ($('footer').height()+height_plus)) {
			
			
				pagination_click();
			
		}
		}
	});
	function pagination_click(){
		
        var href = $(".pagination_list .pagination a").attr('href');
        
		if($(".pagination_list .pagination a").length>0)
		if(old_href!=href){
			old_href = href;
			
			
			url = href + '&ajax=1&map=none&curr=';
			
			$.ajax({
				url: url,
				type: "get",
			}).done(function (resp) {
				$('.loading_sec').hide();
				display_projects(resp.content,true);
				$('ul.pagination').html(resp.pagin_block);
			}).fail(function (jqXHR, ajaxOptions, thrownError) {
				console.log('server not responding...');
			});
		}
	}*/
	
function display_projects(projects,append=false) {
		first_load_project = true;
		if(projects.length==0)
			$('.pagination_list').remove();
		
        ready = $('#_status_ready').clone().html();
        
		if(append==false)
        $('.block_sec').html('');
        
		projects.map(function (p, i) {
            html = $('#block_block_sec').clone().html();
            video_iframe = $('#_video_iframe').clone().html();
            if (p.youtube != '') {
                video_iframe = video_iframe.replace('%youtube%', p.youtube);
                video_icon = $('#_video_icon').clone().html();
                
				video_icon = video_icon.replace('%video_id%', p.video_code);
            } else {
                video_iframe = '';
                video_icon = '';
            }


            unser_cons = $('#_status_under_cons').clone().html();
            unser_cons = unser_cons.replace('%delivered_date%', p.deliverd_date);
            if (p.status == 'ready')
                html = html.replace('%project_status%', ready);
            else
                html = html.replace('%project_status%', unser_cons);
            if (p.payment_method == 'نقدي') {
                payment_method = $('#_status_cash').clone().html();
                html = html.replace('%payment_method%', payment_method);
            } else {
                payment_method = $('#_status_install').clone().html();
                payment_method = payment_method.replace('%percent%', p.percent);
                payment_method = payment_method.replace('%percent%', p.percent).replace('%months%', p.months);
                html = html.replace('%payment_method%', payment_method);
            }

            var remise = '';
            if (p.cash_discount != 0) {
                remise = '<a class="project_Id" href="#url">' +
                        '<span class="num">' + p.cash_discount + '% OFF</span>' +
                        '</a>';
            }
            var link_3d = '';
            if (p.link_3d != '') {
                link_3d = '<div class="icon_3d">'+
						'<a href="#url#3d">'+
						'<img width="30" height="20" src="<?= asset("/img/3d-floor-plans-icon.svg"); ?>" alt="3D Floor Plans"/>'+
						'</a>'+
						'</div>';
            }

            html = html.replace('%remise%', remise);
            html = html.replace('%link_3d%', link_3d);
            html = html.replace('%name%', p.name);
            html = html.replace('%price%', p.price);
            html = html.replace('%city%', p.city);
            html = html.replace('%region%', p.region);
            html = html.replace('%lat%', p.lat);
            html = html.replace('%picture%', p.pic);
            html = html.replace('%long%', p.long);
            html = html.replace('%video%', video_iframe);
            html = html.replace('%video_icon%', video_icon);
            html = html.replace('%title%', p.title).replace('%title%', p.title).replace('%title%', p.title).replace('%title%', p.title);
            html = html.replace('#url', p.url).replace('#url', p.url).replace('#url', p.url).replace('#url', p.url).replace('#url', p.url).replace('#url', p.url);
            $('.block_sec').append(html);
        });
        


    }
	$.get('<?= $ajax_projects_url ?>', {}, function (resp) {
		/*$('.type_full strong.num').html(resp.inputs.count);
		$('.type_mob strong.num').html(resp.inputs.count);*/

		display_projects(resp.content);
		
		<?php if(@$_GET['x']=='1'){ ?>
			alert(resp.url);
			alert(resp.content.length);
			/*?page=2*/
		<?php } ?>
	});




 var counter = 1;

    $(".show_less_btn").hide();
    $(document).on("click", ".show_more_btn", function () {

        if (counter == 1) {
            $('.blog_content_sec').animate({'max-height': '400px'}, 200);
            $('html, body').animate({
                scrollTop: $('.blog_content_sec').offset().top - 100
            }, 'slow');
            $(".show_less_btn").show();
            counter++;
            return true;

        } else if (counter == 2) {
            $('.blog_content_sec').animate({'max-height': '800px'}, 200);
            $('html, body').animate({
                scrollTop: $('.blog_content_sec').offset().top - 50
            }, 'slow');
            $(".show_less_btn").show();
            counter++;
            return true;

        } else if (counter == 3) {
            var height_div = $('.blog_content_sec').css({'max-height': 'initial'}).height() + 130;
            $('.blog_content_sec').animate({'max-height': height_div}, 200);
            $('html, body').animate({
                scrollTop: $('.blog_content_sec').offset().top + 250
            }, 'slow');
            $(".show_more_btn").hide();
            $(".show_less_btn").show();
            $(".action_content").addClass("type_less");
            return false;

        } else {
            counter = 1;
            return false;
        }


    });


    $(document).on("click", ".show_less_btn", function () {
        $('.blog_content_sec').animate({'max-height': '170px'}, 300);
        $('html, body').animate({
            scrollTop: $('.blog_content_sec').offset().top - 100
        }, 'slow');
        counter = 1;
        $(".action_content").removeClass("type_less");
        setTimeout(function () {
            $(".show_less_btn").hide();
            $(".show_more_btn").show();
        }, 300);
    });






</script>

<script id="_status_under_cons" type="text/html">	
    <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 20.78 20.65" xml:space="preserve"><path class="st0" d="M20.2,3.05h-1.36L13.42,0.8V0.3c0-0.17-0.14-0.3-0.3-0.3c-0.17,0-0.3,0.14-0.3,0.3v0.46L1.57,3.98H1.25 c-0.11,0-0.2,0.05-0.26,0.14C-0.04,5.79,0,5.7,0,5.81c0,0.17,0.13,0.31,0.3,0.31h1.58v0.43C1.88,7,2.25,7.37,2.7,7.37h0.12v3.08 c-0.34,0.12-0.58,0.45-0.58,0.83c0,0.37,0.23,0.69,0.55,0.82v0.15c0,0.08,0.03,0.15,0.08,0.21c0.42,0.45,0.54,0.53,0.52,0.76 c-0.02,0.21-0.19,0.34-0.38,0.34H2.86c-0.05-0.1-0.15-0.16-0.27-0.16c-0.17,0-0.3,0.14-0.3,0.3v0.16c0,0.17,0.14,0.3,0.3,0.3h0.42 c0.52,0,0.95-0.39,0.99-0.9c0.05-0.52-0.26-0.77-0.6-1.13v-0.01C3.75,12,4,11.67,4,11.28c0-0.38-0.24-0.7-0.58-0.83V7.37h0.12 C4,7.37,4.36,7,4.36,6.55V6.12c0.19,0,6.79,0,6.91,0c0,0.39,0,11.12,0,11.57h-0.04c-0.34,0-0.61,0.27-0.61,0.61v1.75H9.81 c-0.17,0-0.3,0.14-0.3,0.3s0.14,0.3,0.3,0.3c0.28,0,6.35,0,6.6,0c0.17,0,0.3-0.14,0.3-0.3s-0.14-0.3-0.3-0.3H15.6V18.3 c0-0.34-0.27-0.61-0.61-0.61h-0.04c0-0.48,0-9.05,0-9.53c0-0.17-0.14-0.3-0.3-0.3c-0.17,0-0.3,0.14-0.3,0.3v0.99h-2.46 c0-0.48,0-4.04,0-4.57h2.46c0,0.25,0,1.9,0,2.16c0,0.17,0.14,0.3,0.3,0.3c0.17,0,0.3-0.14,0.3-0.3V6.12h1.83v0.35 c0,0.32,0.26,0.58,0.58,0.58h0.71c0.17,0,0.3-0.14,0.3-0.3c0-0.17-0.14-0.3-0.3-0.3h-0.68V3.66c0.29,0,2.49,0,2.78,0v2.78h-0.68 c-0.17,0-0.3,0.14-0.3,0.3c0,0.17,0.14,0.3,0.3,0.3h0.71c0.32,0,0.58-0.26,0.58-0.58V3.63C20.78,3.31,20.52,3.05,20.2,3.05 L20.2,3.05z M0.85,5.51l0.57-0.93h1.4v0.93C1.92,5.51,2.29,5.51,0.85,5.51L0.85,5.51z M3.12,11.55c-0.15,0-0.27-0.12-0.27-0.27 c0-0.15,0.12-0.27,0.27-0.27c0.15,0,0.27,0.12,0.27,0.27C3.39,11.43,3.27,11.55,3.12,11.55L3.12,11.55z M3.75,6.55 c0,0.12-0.09,0.21-0.21,0.21H2.7c-0.12,0-0.21-0.09-0.21-0.21V6.12c0.46,0,0.81,0,1.26,0V6.55z M5.64,5.51c-0.26,0-1.95,0-2.21,0 V4.58h2.21V5.51z M8.46,5.51H6.25V4.58h2.21V5.51z M11.27,5.51H9.06V4.58h2.21V5.51z M13.42,9.76h0.93v1.53h-0.93V9.76z M13.42,11.89h0.93v1.53h-0.93V11.89z M13.42,14.03h0.93v1.53h-0.93V14.03z M13.42,16.16h0.93v1.53h-0.93V16.16z M11.88,9.76h0.93 v1.53h-0.93V9.76z M11.88,11.89h0.93v1.53h-0.93V11.89z M11.88,14.03h0.93v1.53h-0.93V14.03z M11.88,16.16h0.93v1.53h-0.93V16.16z M15,18.3l0,1.75h-3.77l0-1.75C11.61,18.3,14.59,18.3,15,18.3L15,18.3z M11.38,3.98c-0.25,0-7.26,0-7.6,0l8.77-2.5L11.38,3.98z M12.06,3.98l1.06-2.26l1.06,2.26H12.06z M16.78,5.51h-1.83V4.58h1.83V5.51z M16.78,3.63v0.35h-1.94l-1.12-2.39l3.55,1.48 C17,3.1,16.78,3.34,16.78,3.63L16.78,3.63z M16.78,3.63"/> </svg>
    <p class="num">%delivered_date%</p>
</script>
<script id="_status_ready" type="text/html">
    <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 28.07 21.56" xml:space="preserve"><path class="st0" d="M27.55,7.76c-0.8-0.42-2.55-0.41-3.24,0.45c-0.26,0.33-0.51,0.65-0.77,0.98c-0.67,0.87-1.43,1.85-2.82,3.44 c-0.31,0.36-0.72,0.65-1.19,0.9c0.02-0.07,0.03-0.14,0.03-0.21c0.05-0.58-0.22-1.14-0.69-1.47c-0.56-0.38-1.32-0.39-2.07-0.02 c-0.97,0.47-2.05,0.47-3.09,0.46c-0.13,0-0.25,0-0.37,0c-0.44,0-0.9-0.19-1.43-0.42c-0.72-0.3-1.54-0.65-2.6-0.65 c-1.2,0-2.37,0.71-3.1,1.26v-0.22c0-0.24-0.2-0.44-0.44-0.44H0.44C0.2,11.81,0,12.01,0,12.26v8.86c0,0.24,0.2,0.44,0.44,0.44h5.32 c0.24,0,0.44-0.2,0.44-0.44v-0.85c1.92,0.27,3.64,0.37,5.2,0.37c3.11,0,5.54-0.43,7.45-0.87c1.84-0.42,5.28-4.03,7.2-7.56 c0.36-0.67,0.74-1.3,1.08-1.86c0.47-0.77,0.8-1.33,0.9-1.67C28.08,8.55,28.16,8.08,27.55,7.76z M5.32,20.67H0.89V12.7h4.43V20.67z M26.38,9.9c-0.34,0.57-0.73,1.21-1.1,1.89c-1.93,3.55-5.2,6.8-6.62,7.12c-2.81,0.64-6.76,1.27-12.45,0.46v-5.74 c0.42-0.38,1.79-1.52,3.1-1.52c0.89,0,1.58,0.29,2.26,0.58c0.59,0.25,1.15,0.49,1.77,0.49c0.12,0,0.24,0,0.37,0 c1.09,0.01,2.33,0.02,3.49-0.55c0.46-0.22,0.89-0.24,1.18-0.04c0.22,0.15,0.33,0.4,0.31,0.66c-0.03,0.36-0.31,0.68-0.76,0.9 c-2.29,0.62-5.18,0.63-6.85,0.63c-0.24,0-0.44,0.2-0.44,0.44c0,0.24,0.2,0.44,0.44,0.44c1.66,0,3.58-0.02,5.44-0.31 c2.35-0.37,3.95-1.06,4.88-2.12c1.41-1.61,2.18-2.61,2.86-3.48c0.26-0.33,0.5-0.64,0.76-0.97c0.17-0.22,0.61-0.37,1.12-0.38 c0.48-0.02,0.86,0.08,1.02,0.17C27.02,8.83,26.71,9.35,26.38,9.9z M17.37,3.1c0-0.41,0.33-0.74,0.74-0.74s0.74,0.33,0.74,0.74 c0,0.41-0.33,0.74-0.74,0.74S17.37,3.51,17.37,3.1z M12.26,9.81h1.67c0.24,0,0.44-0.2,0.44-0.44V8.97h0.39 c0.12,0,0.44-0.16,0.44-0.44V8.14h0.39c0.24,0,0.44-0.2,0.44-0.44V7.3h0.39c0.12,0,0.23-0.05,0.31-0.13l0.99-0.99 c0.12,0.01,0.24,0.02,0.36,0.02c0,0,0,0,0,0c0.83,0,1.61-0.32,2.19-0.91c1.21-1.21,1.21-3.18,0-4.39C19.71,0.32,18.93,0,18.1,0 c-0.83,0-1.61,0.32-2.19,0.91c-0.85,0.85-1.13,2.12-0.73,3.23l-3.24,3.24c-0.08,0.08-0.13,0.2-0.13,0.31v1.67 C11.81,9.61,12.01,9.81,12.26,9.81z M12.7,7.88l3.32-3.32c0.13-0.13,0.17-0.33,0.09-0.5c-0.4-0.85-0.23-1.86,0.43-2.52 c0.42-0.42,0.97-0.65,1.57-0.65c0.59,0,1.15,0.23,1.57,0.65c0.86,0.86,0.86,2.27,0,3.13c-0.42,0.42-0.97,0.65-1.57,0.65c0,0,0,0,0,0 c-0.15,0-0.29-0.01-0.43-0.04c-0.15-0.03-0.29,0.02-0.4,0.12l-1.02,1.02H15.6c-0.24,0-0.44,0.2-0.44,0.44v0.39h-0.39 c-0.24,0-0.44,0.2-0.44,0.44v0.39h-0.39h0c-0.23,0-0.44,0.19-0.44,0.44v0.39H12.7V7.88z M2.36,16.69c0-0.41,0.33-0.74,0.74-0.74 c0.41,0,0.74,0.33,0.74,0.74c0,0.41-0.33,0.74-0.74,0.74C2.69,17.42,2.36,17.09,2.36,16.69z"></path> </svg>
    <p>{{ trans('front.ready') }}</p>
</script>

<script id="_status_cash" type="text/html">	
    <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 27.59 23.58" style="enable-background:new 0 0 27.59 23.58;" xml:space="preserve"><style type="text/css">.st0{fill:#028787}</style><path class="st0" d="M9.13,15.58c0,2.57,2.09,4.66,4.66,4.66c2.57,0,4.66-2.09,4.66-4.66s-2.09-4.66-4.66-4.66 C11.22,10.91,9.13,13.01,9.13,15.58z M17.65,15.58c0,2.12-1.73,3.85-3.85,3.85c-2.12,0-3.85-1.73-3.85-3.85 c0-2.12,1.73-3.85,3.85-3.85C15.92,11.72,17.65,13.45,17.65,15.58z M13.39,12.42v0.29c-0.72,0.18-1.25,0.83-1.25,1.61v0.2 c0,0.73,0.55,1.34,1.25,1.44v1.61c-0.26-0.14-0.45-0.42-0.45-0.76h-0.81c0,0.8,0.54,1.44,1.25,1.62v0.29h0.81v-0.29 c0.72-0.18,1.25-0.83,1.25-1.61v-0.2c0-0.73-0.55-1.34-1.25-1.44v-1.61c0.26,0.14,0.45,0.42,0.45,0.76h0.81 c0-0.8-0.54-1.44-1.25-1.62v-0.29H13.39z M13.39,15.14c-0.26-0.08-0.45-0.33-0.45-0.61v-0.2c0-0.32,0.18-0.6,0.45-0.75V15.14z M14.64,16.62v0.2c0,0.32-0.18,0.6-0.45,0.75v-1.56C14.46,16.1,14.64,16.34,14.64,16.62z M27.59,7.57v16H5.31v-0.81h21.47V8.38H0.81 v14.39H4.5v0.81H0v-16H27.59z M3.56,21.96c0.05-0.49,0.05-0.5,0.05-0.59c0-0.88-0.71-1.59-1.59-1.59h-0.4v-8.41h0.4 c0.94,0,1.67-0.81,1.58-1.74L3.56,9.19h15.47V10H4.41c-0.1,1.09-0.92,1.97-1.98,2.15V19c1.06,0.18,1.89,1.06,1.98,2.15h18.77 c0.1-1.09,0.92-1.97,1.98-2.15v-6.86c-1.06-0.18-1.89-1.06-1.98-2.15h-3.34V9.19h4.19c-0.05,0.49-0.05,0.5-0.05,0.59 c0,0.88,0.71,1.59,1.59,1.59h0.4v8.41h-0.4c-0.94,0-1.67,0.81-1.58,1.74l0.04,0.44H3.56z M22.26,4.3l0.35-0.21l1.24,2.06l-0.69,0.42 l-0.84-1.4c-1,0.39-2.16,0.07-2.81-0.82l-3.93,2.36l-0.42-0.69l4.66-2.8l0.19,0.4C20.41,4.46,21.45,4.78,22.26,4.3z M12.44,6.71 l-0.42-0.69L22.04,0l3.69,6.15l-0.69,0.42l-3.28-5.46L12.44,6.71z"></path> </svg>
    <p>{{ trans('front.نقدي') }}</p>
</script>
<script id="_status_install" type="text/html">
    <div class="progres"> <span class="pro"> <div class="progress" data-percentage="%percent%"> <span class="progress-left"> <span class="progress-bar"></span> </span> <span class="progress-right"> <span class="progress-bar"></span> </span> <div class="progress-value"> <strong class="num">%percent%%</strong> </div> </div> </span> </div>
    <p>{{ trans('front.تقسيط') }}</p> <p> <strong class="num">%months%</strong> {{ trans('front.month') }}</p>
</script>

<script id="_video_iframe" type="text/html">
    <div class="int_cont video">
    <!--<iframe class="player" width="100%" height="180" src="%youtube%" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
    </div>
</script>
<script id="_video_icon" type="text/html">
    <div class="btn_style type_video" rel="typeVideo" data-video="%video_id%">
        <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 29.4 25" xml:space="preserve"><g> <path class="st0" d="M27.9,0H4.1H1.5C0.7,0,0,0.7,0,1.5v18.1c0,0.8,0.7,1.5,1.5,1.5h2.6H11V23H5c-0.3,0-0.5,0.2-0.5,0.5v1 C4.5,24.8,4.7,25,5,25h2.6h14.8c2.3,0,2.5-0.2,2.5-0.5v-1c0-0.3-0.2-0.5-0.5-0.5h-6v-1.9h9.5c0.8,0,1.5-0.7,1.5-1.5V1.5 C29.4,0.7,28.7,0,27.9,0z M27.5,18.9c0,0.2-0.2,0.4-0.4,0.4H2.2c-0.2,0-0.4-0.2-0.4-0.4V2.2C1.8,2,2,1.8,2.2,1.8h25 c0.2,0,0.4,0.2,0.4,0.4v16.7H27.5z"/> <path class="st0" d="M18.4,9.7L12,5.8c-0.7-0.4-1.5,0.1-1.5,0.9v7.8c0,0.8,0.9,1.3,1.5,0.9l6.4-3.9C19,11,19,10.1,18.4,9.7 L18.4,9.7z"/> </g> </svg>
    </div>
</script>

<script id="block_block_sec" type="text/html">
    <div class="item card_item">
        <div class="content sec shadow_type">
            <?php //<!--<a class="project_Id" href="#url"><img src="{{ asset('/img/projectName.png') }}"> <span class="num">%name%</span></a>--> ?>

            %remise%		
			%link_3d%

            <div class="view_cont">
                <div class="int_cont image show">
                    <a href="#url"><img class="lazy"  loading="lazy" src="%picture%" alt="%title%"/></a>
                </div>
                <div class="int_cont map">
                <!--<iframe width="100%" height="200" frameborder="0" style="border:0" src="https://maps.google.com/maps?q=%lat%,%long%&amp;hl=es;z=14&amp;output=embed"></iframe>-->
                </div>

                %video%
            </div>

            <div class="control_sec">
                <div class="num"><p class="jazzira_font"><?= trans("front.starts from"); ?></p>  %price% </div>
                <div class="btn_style type_image active" rel="typeImage">
                    <svg width="15" height="15" viewBox="0 0 16 16" id="941b7c6df16f1639c19993afa498088e" ><path data-name="Image Icon copy 3" fill-rule="evenodd" d="M14 16H2a2 2 0 01-2-2V2a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2zm0-14H2v12h1.974l6.136-6.647a1.09 1.09 0 011.528-.086L14 9.373V2zm0 10.048l-3.023-2.7L6.687 14H14v-1.952zM6 8a2 2 0 112-2 2 2 0 01-2 2z"></path></svg>
                </div>
                %video_icon%
                <div class="btn_style type_map" rel="typeMap">
                    <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 15.5 20.4" xml:space="preserve"><g> <path class="st0" d="M7.7,0C3.5,0,0,3.5,0,7.7c0,1.8,1.2,4.3,3.6,7.6c1.7,2.4,3.4,4.3,3.5,4.4l0.6,0.7l0.6-0.7 c0.1-0.1,1.8-2,3.5-4.4c2.4-3.3,3.6-5.9,3.6-7.6C15.5,3.5,12,0,7.7,0L7.7,0z M7.7,17.9c-2.1-2.5-6-7.6-6-10.2c0-3.3,2.7-6,6-6 s6,2.7,6,6C13.8,10.3,9.9,15.4,7.7,17.9L7.7,17.9z M7.7,17.9"/> <path class="st0" d="M10.5,7.7c0,1.5-1.3,2.8-2.8,2.8S4.9,9.3,4.9,7.7s1.3-2.8,2.8-2.8S10.5,6.2,10.5,7.7L10.5,7.7z M10.5,7.7"/> </g> </svg>
                </div>

                <div class="dropdown share_sec">
                    <div class="shareBtn share" id="dropdownMenuButtons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 18.2 18.2" xml:space="preserve"><path class="st0" d="M14.6,10.9c-1.3,0-2.4,0.7-3,1.6L7.2,10c0.2-0.6,0.2-1.3,0-1.9l4.4-2.5c0.7,1,1.8,1.6,3,1.6 c2,0,3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6c-2,0-3.6,1.6-3.6,3.6c0,0.2,0,0.3,0,0.5L6.4,6.7C5.1,5.2,2.8,5,1.3,6.3 c-1.5,1.3-1.7,3.6-0.4,5.1C2.2,13,4.5,13.2,6,11.9c0.2-0.1,0.3-0.3,0.4-0.4l4.6,2.6c0,0.2,0,0.3,0,0.5c0,2,1.6,3.6,3.6,3.6 c2,0,3.6-1.6,3.6-3.6C18.2,12.5,16.6,10.9,14.6,10.9z M14.6,1.6c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S13.5,1.6,14.6,1.6z M3.7,11.1c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2S4.8,11.1,3.7,11.1z M14.6,16.5c-1.1,0-2-0.9-2-2s0.9-2,2-2s2,0.9,2,2 S15.7,16.5,14.6,16.5z"/> </svg>
                    </div>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtons"> 
                        <a href="#" data-url="#url" class="btnshare bluring" data-network="facebook" target="_blank"><i class="fa fa-facebook"></i></a>
                        <a href="#" data-url="#url" class="btnshare bluring" data-network="whatsapp" target="_blank"><svg  width="39" height="39" viewBox="0 0 39 39"><path fill="#00E676" d="M10.7 32.8l.6.3c2.5 1.5 5.3 2.2 8.1 2.2 8.8 0 16-7.2 16-16 0-4.2-1.7-8.3-4.7-11.3s-7-4.7-11.3-4.7c-8.8 0-16 7.2-15.9 16.1 0 3 .9 5.9 2.4 8.4l.4.6-1.6 5.9 6-1.5z"></path><path fill="#FFF" d="M32.4 6.4C29 2.9 24.3 1 19.5 1 9.3 1 1.1 9.3 1.2 19.4c0 3.2.9 6.3 2.4 9.1L1 38l9.7-2.5c2.7 1.5 5.7 2.2 8.7 2.2 10.1 0 18.3-8.3 18.3-18.4 0-4.9-1.9-9.5-5.3-12.9zM19.5 34.6c-2.7 0-5.4-.7-7.7-2.1l-.6-.3-5.8 1.5L6.9 28l-.4-.6c-4.4-7.1-2.3-16.5 4.9-20.9s16.5-2.3 20.9 4.9 2.3 16.5-4.9 20.9c-2.3 1.5-5.1 2.3-7.9 2.3zm8.8-11.1l-1.1-.5s-1.6-.7-2.6-1.2c-.1 0-.2-.1-.3-.1-.3 0-.5.1-.7.2 0 0-.1.1-1.5 1.7-.1.2-.3.3-.5.3h-.1c-.1 0-.3-.1-.4-.2l-.5-.2c-1.1-.5-2.1-1.1-2.9-1.9-.2-.2-.5-.4-.7-.6-.7-.7-1.4-1.5-1.9-2.4l-.1-.2c-.1-.1-.1-.2-.2-.4 0-.2 0-.4.1-.5 0 0 .4-.5.7-.8.2-.2.3-.5.5-.7.2-.3.3-.7.2-1-.1-.5-1.3-3.2-1.6-3.8-.2-.3-.4-.4-.7-.5h-1.1c-.2 0-.4.1-.6.1l-.1.1c-.2.1-.4.3-.6.4-.2.2-.3.4-.5.6-.7.9-1.1 2-1.1 3.1 0 .8.2 1.6.5 2.3l.1.3c.9 1.9 2.1 3.6 3.7 5.1l.4.4c.3.3.6.5.8.8 2.1 1.8 4.5 3.1 7.2 3.8.3.1.7.1 1 .2h1c.5 0 1.1-.2 1.5-.4.3-.2.5-.2.7-.4l.2-.2c.2-.2.4-.3.6-.5s.4-.4.5-.6c.2-.4.3-.9.4-1.4v-.7s-.1-.1-.3-.2z"></path></svg></a>
                    </div>
                </div>
            </div>

            <div class="features_sec">
                <a class="project_name jazzira_font" href="#url">%title%  TEST</a>
                <ul>
                    <li> <svg width="15" height="15" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 21.17 20.61" xml:space="preserve"><path class="st0" d="M7.79,8.63c0.9,1.05,1.83,2.06,2.77,3.12c0.08-0.09,0.14-0.15,0.19-0.21c0.86-1.02,1.72-2.03,2.57-3.05 c0.51-0.61,0.99-1.24,1.35-1.95c0.42-0.82,0.6-1.67,0.46-2.59c-0.42-2.91-3.45-4.69-6.19-3.63C6.28,1.33,5.18,4.45,6.62,7 C6.95,7.58,7.36,8.12,7.79,8.63z M10.59,2.42c1.23-0.01,2.27,1.03,2.27,2.27c0,1.24-1.02,2.28-2.26,2.28 c-1.26,0-2.29-1.02-2.29-2.27C8.31,3.46,9.33,2.43,10.59,2.42z M20.83,10.23c-1.79-0.91-3.58-1.82-5.37-2.73 c-0.15-0.08-0.3-0.15-0.45-0.22c-0.14,0.22-0.27,0.43-0.41,0.65c1.82,0.93,3.63,1.85,5.47,2.78c-1.33,1.03-2.62,2.04-3.93,3.05 c-1.21-1.08-2.42-2.15-3.64-3.23c-0.09,0.11-0.17,0.2-0.26,0.31c1.17,1.04,2.33,2.07,3.51,3.12c-0.09,0.04-0.15,0.07-0.22,0.1 c-1.62,0.65-3.24,1.29-4.85,1.94c-0.2,0.08-0.3,0.05-0.44-0.12c-2.02-2.53-4.05-5.06-6.08-7.58C4.11,8.25,4.09,8.2,4.03,8.11 c0.84,0,1.63,0,2.48,0C6.35,7.85,6.22,7.66,6.12,7.46C6.06,7.35,5.98,7.3,5.85,7.3C5.07,7.32,4.29,7.33,3.51,7.35 c-0.13,0-0.27,0.05-0.37,0.12C2.17,8.13,1.21,8.78,0.25,9.44c-0.29,0.2-0.32,0.38-0.13,0.67c2.31,3.4,4.62,6.8,6.94,10.2 c0.27,0.4,0.5,0.41,0.81,0.04c0.92-1.12,1.83-2.25,2.76-3.37c0.1-0.13,0.25-0.24,0.4-0.3c1.73-0.7,3.46-1.38,5.19-2.08 c0.12-0.05,0.24-0.12,0.35-0.2c1.45-1.12,2.89-2.24,4.34-3.36C21.29,10.73,21.26,10.45,20.83,10.23z M7.49,19.58 c-2.2-3.23-4.37-6.43-6.57-9.66c0.87-0.59,1.72-1.18,2.59-1.77c2.2,2.74,4.39,5.47,6.6,8.21C9.24,17.43,8.38,18.49,7.49,19.58z"></path> </svg>
                        <p>%city%<br>%region%</p> </li>
                    <li>
                        %project_status%
                    </li>
                    <li>%payment_method%</li>
                </ul>
            </div>
        </div>
    </div>
</script>
<?php } ?>

@endsection



@section('schemaorg')
@if(isset($post->categories[0]))
<script data-schema="<?= $type == 'news' ? 'NewsArticle' : 'Article' ?>" type="application/ld+json">
    {
    "@context":"http://schema.org",
    "@type":"<?= $type == 'news' ? 'NewsArticle' : 'Article' ?>",
    "mainEntityOfPage":{
    "@type":"WebPage",
    "@id":"{{ $post->frontUrl() }}"
    },
    "headline":"{{ htmlentities($post->getTitle())  }}",
    "articleBody":"{{ str_replace('\\', '',htmlentities(strip_tags(html_entity_decode($post->getContent()))))  }}",
    "url":"{{ $post->frontUrl() }}",
    "image":{
    "@type":"ImageObject",
    "url":"{{ Helper::media_url($post->photoCard) }}",
    "width":1200,
    "height":640
    },
    "articleSection":"{{ @$post->categories[0]->getName() }}",
    "datePublished":"<?= date(DATE_ISO8601, strtotime($post->created_at)) ?>",
    "dateModified":"<?= date(DATE_ISO8601, strtotime($post->update_date)) ?>",
    "author":{"@type":"Organization","name":"DamasTurk"},
    "publisher":{
    "@type":"Organization","name":"DamasTurk"
    }
    }
</script>
@endif

<?php
if (isset($post_video)) {
    //echo '<!--'.$ytbvid.'-->';
    if ((int) $post_video->project_id != 0)
        $vtitle = $post_video->project->getIntroCard();
    else
        $vtitle = $post_video->title;
    ?>
    <script type="application/ld+json">{
        "@context": "http://schema.org",
        "@type": "VideoObject",
        "name": "{{ htmlentities(mb_substr($vtitle, 0, 45, 'UTF-8')) }}...",
        "description": "{{ htmlentities($vtitle)  }}",
        "thumbnailUrl": "https://i.ytimg.com/vi/<?= $ytbvid ?>/default.jpg",
        "uploadDate": "<?= date(DATE_ISO8601, strtotime($post_video->date_published)) ?>",<?php //2021-12-23T13:02:56Z                     ?>
        "duration": "<?= $post_video->duration ?>",
        "embedUrl": "https://www.youtube.com/embed/<?= $ytbvid ?>",
        "interactionCount": "{{ $post_video->views  }}"
        }</script>
<?php } ?>

<?php
if (isset($post_video2) && $post_video2 != false) {
    $post_video = $post_video2;

    //echo '<!--'.$ytbvid.'-->';
    if ((int) $post_video->project_id != 0)
        $vtitle = $post_video->project->getIntroCard();
    else
        $vtitle = $post_video->title;
    ?>
    <script type="application/ld+json">{
        "@context": "http://schema.org",
        "@type": "VideoObject",
        "name": "{{ htmlentities(mb_substr($vtitle, 0, 45, 'UTF-8')) }}...",
        "description": "{{ htmlentities($vtitle)  }}",
        "thumbnailUrl": "https://i.ytimg.com/vi/<?= $video_code ?>/default.jpg",
        "uploadDate": "<?= date(DATE_ISO8601, strtotime($post_video->date_published)) ?>",<?php //2021-12-23T13:02:56Z                     ?>
        "duration": "<?= $post_video->duration ?>",
        "embedUrl": "https://www.youtube.com/embed/<?= $video_code ?>",
        "interactionCount": "{{ $post_video->views  }}"
        }</script>
<?php } ?>

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
<?php if (count($arr_que) > 0) { ?>
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
        <?php
        $i = 0;
        foreach ($faqs as $r) {
            $i++;
            $q = 'q_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
            $res = 'r_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
            if (trim($r->$q) != '') {
                if ($i > 1)
                    echo ',';
                ?>

                {"@type": "Question",
                "name": " <?= htmlentities($r->$q) ?>",
                "acceptedAnswer": {"@type": "Answer","text": "<?= htmlentities($r->$res) ?>"}}
                <?php
            }
        }
        ?>
        ]}
    </script>
<?php } ?>

@if(isset($post->categories[0]))
<script type="application/ld+json">
    {"@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[

    {"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
    <?php
    $category = @$post->categories[0];
    ?>
    <?php if (in_array($category->id, [1, 7])) {//investment; economic affaire ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.turkey investment') }}","item":"{{ route('front.investment') }}"}
    <?php } elseif (in_array($category->id, [4])) {//Daily living in Turkey  ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.living turkey') }}","item":"{{ route('front.living_turkey') }}"}
    <?php } elseif (in_array($category->id, [6, 3])) {//turksih district ; monument tourism turkey   ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.istanbul districts') }}","item":"{{ route('front.districts','istanbul') }}"}
    <?php } elseif (in_array($category->id, [8])) {//turkish citizenship ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.turkish citizenship') }}","item":"{{ route('front.turkish_citizenship') }}"}
    <?php } elseif (in_array($category->id, [12])) {//taxes  ?>
        {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
        {"@type":"ListItem","position":3,"name":"{{ trans('front.legal affairs turkey') }}","item":"{{ route('front.legal') }}"}
    <?php } else { ?>
        
        {"@type":"ListItem","position":2,"name":"{{ trans("front.".$type) }}","item":"{{ $listingUrl }}"},
        {"@type":"ListItem","position":3,"name":"{{ @$post->categories[0]->getName() }}","item":"{{ $post->categories[0]->listingUrl() }}"}
        
    <?php } ?>

    ,{"@type":"ListItem","position":4,"name":"{{ $post->getTitle() }}","item":"{{ $post->frontUrl() }}"}

    ]}
</script>
@endif

@endsection