<?php
if (Helper::get_device() == 'tab') {
    $_GET['device'] = 'full';
}
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
/* $arr_prices = [
  "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
  ]; */
$right = ($style_lang == 'ar' ? 'right' : 'left');
//$all_project_types = Helper::query('ProjectType', 'all');
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


            <div class="scp-breadcrumb">
                <ul class="breadcrumb">
                    <li><a href="<?= route("front.index") ?>"><i class="fa fa-home"></i></a></li>
                    <li><a href="<?= route("front." . $type) ?>"><?= trans("front." . $type); ?></a></li>
                    <li>
                        <a href="<?= route("front." . $type . ".category", @$post->categories[0]->slug) ?>">
                            <?php
							if(isset($post->categories[0]))
								echo @$post->categories[0]->getName()
                            ?>
                        </a>
                    </li>
                    <li class="active"><?= $post->getTitle(); ?></li>
                </ul>
            </div>




            <div class="int_content">
                <div class="blog_info_sec shadow_type">
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
					   <source media="(min-width: 650px)" srcset="<?= Helper::media_url($post->photoCard) ?>">
					   <source media="(max-width: 650px)" srcset="<?= Helper::media_url($post->photoCard,'','',true) ?>">
					   <img src="<?= Helper::media_url($post->photoCard) ?>" class="lazy blog_photo loaded" 
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
                        @$doc->loadHTML($html);

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
                            <li><a rel="nofollow" href="https://facebook.com/sharer.php?u=<?= urlencode(route('front.' . $type . '.post', [$post->slug])) ?>"><i class="fa fa-facebook-f"></i></a></li>
                            <li><a rel="nofollow" href="https://twitter.com/intent/tweet?url=<?= urlencode(route('front.' . $type . '.post', [$post->slug])) ?>&amp;text=<?= $post->getTitle() ?>&amp;via=damasturk"><i class="fa fa-twitter"></i></a></li>
                            <li><a rel="nofollow" href="https://api.whatsapp.com/send?text=<?= (route('front.' . $type . '.post', [$post->slug])) ?>"><i class="fa fa-whatsapp"></i></a></li>
                            <li><a rel="nofollow" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(route('front.' . $type . '.post', [$post->slug])) ?>"><i class="fa fa-linkedin"></i></a></li>
                            <li><a rel="nofollow"><i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>


                </div>
            </div>




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
            $params = Helper::query("BlogParam", "find", ["id" => 1]);
            if ($params->featured_post != '') {
                $similars = explode(",", $params->featured_post);
                ?>
                <div class="int_content">
                    <div class="similar_articles sec">
                        <p class="sub_title jazzira_font_bold"><?= trans("front.related posts"); ?></p>

                        <div class="wrapper sec">

                            <div class="slider video_slider" dir="rtl">

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


                                <a href="{{ route('front.'.$type) }}" class="more shadow_type"><?= trans("front.show more"); ?></a>


                            </div>

                        </div>

                    </div>
                </div>

                <!--<div class="int_content not_bg">-->
            <?php } ?>











            <?php
//$post_projects = $post->projects;
            $arr_ids = Helper::query("Fotterproject", "all")->lists('project_id')->toArray();
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

                        <a href="{{ route('front.search', ['property-for-sale', 'turkey']) }}" class="more shadow_type"><?= trans("front.More Projects"); ?></a>

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

@endsection



@section('schemaorg')
<script data-schema="<?= $type == 'news' ? 'NewsArticle' : 'Article' ?>" type="application/ld+json">
    {
    "@context":"http://schema.org",
    "@type":"<?= $type == 'news' ? 'NewsArticle' : 'Article' ?>",
    "mainEntityOfPage":{
    "@type":"WebPage",
    "@id":"{{ route('front.'.$type.'.post', [$post->slug]) }}"
    },
    "headline":"{{ htmlentities($post->getTitle())  }}",
    "articleBody":"{{ str_replace('\\', '',htmlentities(strip_tags(html_entity_decode($post->getContent()))))  }}",
    "url":"{{ route('front.'.$type.'.post', [$post->slug]) }}",
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
        {"@type":"ListItem","position":2,"name":"{{ trans("front.".$type) }}","item":"{{ route("front.".$type) }}"},
        {"@type":"ListItem","position":3,"name":"{{ @$post->categories[0]->getName() }}","item":"{{ route("front.".$type.".category", @$post->categories[0]->slug) }}"}
    <?php } ?>

    ,{"@type":"ListItem","position":4,"name":"{{ $post->getTitle() }}","item":"{{ route('front.'.$type.'.post',$post->slug) }}"}

    ]}
</script>

@endsection