<?php
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
$right = ($style_lang == 'ar' ? 'right' : 'left');

/*$js_select_picker_refresh = '';
if($is_mobile)*/
$js_select_picker_refresh = '$(".selectpicker").selectpicker("refresh");';

$all_project_types = Helper::query('ProjectType', 'all');
$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
$citys = Helper::query("City", "orderByPlacement");
$regions = $inputs["regions_options"];
$ProjectTypes = Helper::query("ProjectType", "all");
$tags = Helper::query("ProjectCategory", "where", ["field" => "hide_search_page", "value" => false])->get();
$arr_rooms = [
    "1_0" => "1 + 0",
    "1_1" => "1 + 1",
    "1_2" => "1 + 2",
    "1_3" => "1 + 3",
    "1_4" => "1 + 4",
    "1_5" => "1 + 5",
    "2_3" => "2 + 3",
    "2_4" => "2 + 4",
    "2_5" => "2 + 5",
    "2_6" => "2 + 6"
];
?>

@include('front.partials.search_layout_styles')


<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/search.css"); ?>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("resources/assets/css/search-en.css"); ?>
    <?php } ?>



<?php } else { ?>

    <?php // Html::style("/css/search.min.css"); ?>
	<!--<link rel="Asynchronously load stylesheet" type="text/css" href="{{ asset('css/search.min.css?v=05') }}">-->
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
	 <!--<link rel="Asynchronously load stylesheet" type="text/css" href="{{ asset('css/search-en.min.css?v=05') }}">-->
        <?php // Html::style("css/search-en.min.css"); ?>
    <?php } ?>

<?php } ?>





@endsection


@extends('front.layout', [
'hide_main_js'=>true,
'hide_onesignal'=>true,
"is_page_search" => '1',
"page_title" => @$inputs["seo_title"],
"page_description" => @$inputs["seo_description"],
"page_keywords" => @$inputs["seo_keywords"],
"og_image" => @$inputs["og_image"],
"amp_url"    =>    $current_lang=='ar'?str_replace("damas.net", "damas.net/amp", Request::url()):str_replace("damas.net/$current_lang", "damas.net/$current_lang/amp", Request::url())
])


@section('main_content')


<?php
//dd($inputs);

$city_row = $inputs["city_row"];
$is_mobile = Helper::is_mobile();
//$select_size = $is_mobile ? '' : 10;


if (isset($inputs["seo_title"])) {
    $t0 = explode('|', $inputs["seo_title"]);
    $min_seo_title = $t0[0];
}
?>
<div class="col-md-10 offset-md-1">
    <div class="full_sections int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <?php
            /* echo '<pre>';
              print_r($arr_rooms);
              echo '</pre>';


              echo '<pre>';
              //print_r($inputs['regions_options']);
              print_r($inputs['project_types_options']);
              echo '</pre>';
              exit; */
            /* echo '<pre>';
              print_r($inputs["project_citys_options"]);
              echo '</pre>';
              if(in_array(13,json_decode($inputs["project_regions_options"]))){
              echo 'TYYYYYYYYYYYYYYYYYYYYYYTT<br>';
              }
              echo '<pre>';
              print_r($inputs["project_regions_options"]);
              echo '</pre>';
              echo '<pre>';
              print_r($inputs["project_types_options"]);
              echo '</pre>';
              echo '<pre>';
              print_r($inputs["prices_options"]);
              echo '</pre>';
              echo '<pre>';
              print_r($inputs["rooms_options"]);
              echo '</pre>';
              exit;
              echo '<pre>';
              print_r($inputs["project_tags_options"]);
              echo '</pre>'; */
            ?>
            <div class="top_control_sec search_page">

                <?php //if (Helper::get_device() == 'full') { ?>
                    <div class="type_full sec">
                        <?php
						if(count($allprojects)==0){
							$rh1 = ($current_lang=='ar'?'لا يوجد نتائج':'No Results Found');
							$trh1[1] = '';
						}else{
						
                        $rh1 = explode('</h1>', $inputs["about"]);
                        $rh1 = trim(strip_tags(@$rh1[0]));
                        $rh1 = ($rh1 == '' ? (isset($min_seo_title) ? $min_seo_title : trans("front.Properties")) : $rh1);
                        }
						?>
                        <h1 class="jazzira_font_bold"><?= $rh1 ?></h1>
                        <strong class="num pr_count">(<?= count($allprojects); ?>)</strong>
						<!--<p><span><?= trans("front.search results"); ?></span> <strong class="num"><?= count($allprojects); ?></strong></p>-->
                    </div>





                <?php //} ?>
<!--<p><span>نتائج البحث</span> <strong>360</strong></p>-->




                <?php //if (Helper::get_device() != 'full') { ?>
                    <div class="categories_sec mob">
                        <ul>
                            <li class="filter"><a class="filter_btn"> <svg width="20" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 220.6 239.5" xml:space="preserve"><g> <path class="st0" d="M110.2,0.5c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8C58.5,86.3,36,58.7,13.4,31.1c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7C1.8,5,7.5,0.5,14.8,0.5 C46.6,0.4,78.4,0.5,110.2,0.5z M195.9,29.4c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3C44.4,56.8,65.6,82.9,87,108.9 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C155.6,78.3,175.6,54.3,195.9,29.4z M91.1,119.2 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C114.6,119.2,103,119.2,91.1,119.2z M110.2,8.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C171.9,8.2,141.1,8.2,110.2,8.2z"></path> </g> </svg> </a></li>
                            <?php
							//if(count($allprojects)>0)
								echo $inputs["__links"];
                            /* $pfilters = App\Models\Projectfilter::all();
                              foreach($pfilters as $p){ ?>
                              <li><a href="<?= ($current_lang=='ar'?$p->link:str_replace('.com','.com/'.$current_lang ,$p->link)) ?>"><?= $p->getTitle() ?></a></li>
                              <?php } */
                            ?>

                        </ul>
                    </div>
                <?php //} ?>



            </div>




            <div class="tab-content sec">

                <div class="int_content project_card">
                    <div class="loading_sec"><div class="loading"></div></div>
					<?php
						$trh1 = explode('</h1>', $inputs["about"]);
					?>
                    <?php //if (Helper::get_device() != 'full') { ?>
                        <div class="type_mob">
                            <?php
							if(count($allprojects)==0){
							$rh1 = ($current_lang=='ar'?'لا يوجد نتائج':'No Results Found');
							$trh1[1] = '';
							}else{
                            $rh1 = trim(strip_tags(@$trh1[0]));
                            $rh1 = ($rh1 == '' ? (isset($min_seo_title) ? $min_seo_title : trans("front.Properties")) : $rh1);
                            //$rh1 = ($rh1 == '' ? trans("front.Properties") : $rh1);
                            }
							?>
                            <h1 class="jazzira_font_bold page_title_mob"><?= $rh1 ?></h1>
                            <strong class="num pr_count">(<?= count($allprojects); ?>)</strong>
                        </div>
                    <?php //} ?>


                    <?php //if  { ?>
                        <div class="content_section" style="<?= (trim(strip_tags(@$trh1[1]))!=''?'':'display:none') ?>">
                            <div  id="about-content" class="cont">
                                <?php
								
								$html = @$trh1[1];
								
								if($html!=''){
								
$doc = new \DOMDocument();

                        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
                        @$doc->loadHTML($html);

                        //if (Helper::get_device() == 'mob') {
                            $itags = $doc->getElementsByTagName('img');
							$i=0;
							$list_imgs = [];
                            foreach ($itags as $tag) {
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
											$list_imgs[$i]['mob'] = '/uploads/' .$mob_url;
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

								}



								$html = str_replace('</strong><strong>','',$html);
								$html = str_replace(' style="text-align: justify;"','',$html);
								$html = preg_replace('/<span[^>]+\>/i', '', $html);

								echo html_entity_decode($html);//html_entity_decode
								?>
                            </div>

                            <div class="action_content">
                                <span class="show_more_btn"><?= trans("front.read more"); ?></span>
                                <span class="show_less_btn"><?= trans("front.read less"); ?></span>
                            </div>
                        </div>
                    <?php //} ?>



                    <div class="control_icons">
                        <a class="filter_btn">
                            <svg width="20" height="20" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 220.6 239.5" xml:space="preserve"><g> <path class="st0" d="M110.2,0.5c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8C58.5,86.3,36,58.7,13.4,31.1c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7C1.8,5,7.5,0.5,14.8,0.5 C46.6,0.4,78.4,0.5,110.2,0.5z M195.9,29.4c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3C44.4,56.8,65.6,82.9,87,108.9 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C155.6,78.3,175.6,54.3,195.9,29.4z M91.1,119.2 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C114.6,119.2,103,119.2,91.1,119.2z M110.2,8.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C171.9,8.2,141.1,8.2,110.2,8.2z"/> </g> </svg>
                        </a>

                    </div>


                    


                    <!-- Type Block Projects Card -->
                    <div class="wrapper block_sec sec show">
                        <?php
						//display 3 random projects
						if(count($allprojects)==0){ ?>
                          @foreach($projects as $project)
                          @include("front.partials.project_item", [ "project" => $project,'card_class'=>'item card_item' ])
                          @endforeach
                          <?php } ?>
                    </div>


                </div>

				
				
				
				@include('front.partials.pagination-projects',['projects'=>$projects,'first_page'=>true,'cnt_projs'=>count($allprojects)])
                <?php /*<div class="pagination_sec sec shadow_type">
                    <span class="page_number"><?= $projects->currentPage() ?> of {{ $projects->lastPage() }}</span>
                    <nav class="pagination_list" aria-label="Page navigation example">
                        <ul class="pagination justify-content-end num">
                            @include('front.partials.pagination-projects',['projects'=>$projects])
                        </ul>
                    </nav>
                </div>*/ ?>

            </div>






        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">
            <a class="close_filter_btn">
                <svg version="1.1" width="20" height="20" id="Layer_1"  x="0px" y="0px" viewBox="0 0 211.4 218.9" xml:space="preserve"><g> <path class="st0" d="M628.8-7.9c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8c-22.4-27.7-45-55.3-67.6-82.9c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7c1.4-6.3,7.1-10.8,14.4-10.8 C565.2-7.9,597-7.9,628.8-7.9z M714.5,21c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3c21.2,26.1,42.5,52.2,63.9,78.2 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C674.2,70,694.2,45.9,714.5,21z M609.7,110.9 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C633.2,110.9,621.6,110.9,609.7,110.9z M628.8-0.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C690.5-0.2,659.7-0.2,628.8-0.2z"/> </g> <path class="st0" d="M7.6,128.7L87.9,209c10.2,10.2,26.7,10.2,36.9,0c10.2-10.2,10.2-26.8,0-37l-31.3-31.4l86.3,0 c16.3,0,29.5-11.5,29.5-27.9c0-16.3-13.2-27.9-29.5-27.9l-90.9,0l35.9-37.5c10.2-10.2,10.2-27.5,0-37.7C114.7-0.5,98.1-0.9,87.9,9.3 L7.6,89.4C2.2,94.8-0.3,101.9,0,109C-0.3,116.1,2.2,123.2,7.6,128.7z"/> </svg>
            </a>
            <a id="outMenu" class="out_filter_btn"></a>

            <div class="fixed_sec">

                <section class="form fast_search shadow_type">
                    @include("front.partials.projects_filter")
                </section>

                <?php /*<section class="form mob_form shadow_type">
                    @include("front.partials.call_us_fixed")
                </section>*/ ?>

            </div>
        </div>
        <!-- End Fixed Section -->


		<?php /*
        <section class="form mob_form not_full shadow_type">
            @include("front.partials.call_us_fixed")
        </section>*/ ?>


        <!-- share page links -->
        <?php //if (Helper::get_device() == 'mob') { ?> 
            <div class="sec share_links_sec">
                @include("front.partials.share_links", [])
            </div>
        <?php //} ?>






    </div>
</div>


<input type="hidden" id="ss_p_city"/>
<input type="hidden" id="ss_p_regions"/>
<input type="hidden" id="ss_p_type"/>
<input type="hidden" id="ss_price"/>
<input type="hidden" id="ss_room"/>
<input type="hidden" id="ss_p_tags"/>
<input type="hidden" id="current_curr" value="<?= session()->get("currency") == '' ? 'TRY' : session()->get("currency") ?>"/>
<input type="hidden" id="price_fields" value="0"/>
<input type="hidden" id="changed_elem"/>


@endsection



@section('scriptjs')

<script type="text/javascript" src="{{ asset('js/main_search.min.js') }}?v=10"></script>
<script type="text/javascript" src="{{ asset('js/jquery.fancybox.min.js') }}?v=09" defer=""></script>



<script>
function getVals() {
    let parent = this.parentNode;
    let slides = parent.getElementsByTagName("input");
    let slide1 = parseFloat(slides[0].value);
    let slide2 = parseFloat(slides[1].value);
    if (slide1 > slide2) {
        let tmp = slide2;
        slide2 = slide1;
        slide1 = tmp;
    }

    let displayElement = parent.getElementsByClassName("rangeValues")[0];
    displayElement.innerHTML = "$" + slide1 + " - $" + slide2;
    $(".budget .dropdown .dropdown-toggle .number").text("$" + slide1 + " - $" + slide2);
}
window.onload = function () {
    let sliderSections = document.getElementsByClassName("range-slider");
    for (let x = 0; x < sliderSections.length; x++) {
        let sliders = sliderSections[x].getElementsByTagName("input");
        for (let y = 0; y < sliders.length; y++) {
            if (sliders[y].type === "range") {
                sliders[y].oninput = getVals;
                sliders[y].oninput();
            }
        }
    }
}

/*function waitForScriptsLoaded2(){
console.log("waitForScriptsLoaded2");
 if (window.jQuery) {
console.log("waitForScriptsLoaded2 window.jQuery true");*/
$(document).ready(function () {

<?php if (@$inputs["city"] != 'turkey' && @$inputs["city"] != 'emirates') { ?>
    $('.cleared_filter').show();
<?php } ?>
$('#tabs li a').click(function () {
    id = $(this).attr('href');
    $('div#projects').removeClass('in').removeClass('active');
    $('div#overview').removeClass('in').removeClass('active');
    $(id).addClass('in').addClass('active');
});



$(window).load(function () {
    $(".loader_sec").fadeOut();
});

    $('.main_menu .links>li>a.projects_btn').addClass("active");
    /*$(document).on("click", ".map_btn", function () {
        $('html, body').animate({
            scrollTop: $(".map_sec").offset().top - 200
        }, 2000);
    });*/

var startScroll = 150;
var supportLinks = $(".support_links");
var oldsctop = $(window).scrollTop();
$(window).scroll(function () {

    if (($(this).scrollTop()) > oldsctop) {
        $(".top_control_sec").addClass("scrollMob");
    } else {
        $(".top_control_sec").removeClass("scrollMob");
    }
    oldsctop = $(this).scrollTop();
});


    var page = 1;
    var glat = 0;
    var glong = 0;
    var glocations = [];
    var changed_elem = "";
    var refresh_project_city = 0;
    var refresh_regions = 0;
    var refresh_project_type = 0;
    var refresh_price = 0;
    var refresh_project_rooms = 0;
    var refresh_project_tags = 0;
    var projects_citys = Array();
    var projects_regions = Array();
    var projects_types = Array();
    var projects_prices = Array();
    var projects_rooms = Array();
    var projects_tags = Array();
    var arr_prices_usd = Array();
<?php /* foreach ($arr_prices_usd as $k => $v) { ?>
  var arr = Array();
  arr['k']='<?= $k ?>';
  arr['v']='<?= $v ?>';
  arr_prices_usd.push(arr);
  <?php } ?>
  var arr_prices_try = Array();
  <?php foreach ($arr_prices_try as $k => $v) { ?>
  var arr = Array();
  arr['k']='<?= $k ?>';
  arr['v']='<?= $v ?>';
  arr_prices_try.push(arr);
  <?php } ?>
  var arr_prices_eur = Array();
  <?php foreach ($arr_prices_eur as $k => $v) { ?>
  var arr = Array();
  arr['k']='<?= $k ?>';
  arr['v']='<?= $v ?>';
  arr_prices_eur.push(arr);
  <?php } ?>
  var arr_prices_sar = Array();
  <?php foreach ($arr_prices_sar as $k => $v) { ?>
  var arr = Array();
  arr['k']='<?= $k ?>';
  arr['v']='<?= $v ?>';
  arr_prices_sar.push(arr);
  <?php } */ ?>


<?php foreach ($citys as $type) { ?>
        var arr = Array();
        arr['id'] = '<?= $type->id ?>';
        arr['slug'] = '<?= $type->slug ?>';
        arr['name'] = "<?= $type->getName() ?>";
        projects_citys.push(arr);
<?php } ?>

<?php
$all_regions = Helper::query("Region", "orderByPlacement");
foreach ($all_regions as $type) {
    ?>
        var arr = Array();
        arr['id'] = '<?= $type->id ?>';
        arr['slug'] = '<?= $type->slug ?>';
        arr['name'] = "<?= htmlentities($type->getName()) ?>";
        projects_regions.push(arr);
<?php } ?>

<?php foreach ($ProjectTypes as $type) { ?>
        var arr = Array();
        arr['id'] = '<?= $type->id ?>';
        arr['slug'] = '<?= $type->slug ?>';
        arr['name'] = "<?= htmlentities($type->getName()) ?>";
        projects_types.push(arr);
<?php } ?>

<?php foreach ($tags as $tag) { ?>
        var arr = Array();
        arr['id'] = '<?= $tag->id ?>';
        arr['slug'] = '<?= $tag->slug ?>';
        arr['name'] = "<?= htmlentities($tag->getName()) ?>";
        projects_tags.push(arr);
<?php } ?>

<?php /* foreach ($arr_prices as $k => $v) { ?>
  projects_prices['<?= $k ?>']='<?= $v ?>';
  <?php } */ ?>

<?php foreach ($arr_rooms as $k => $v) { ?>
        projects_rooms['<?= $k ?>'] = '<?= $v ?>';
<?php } ?>
var old_href = '';
var href = '';
    /*filter full browser*/
    $(document).on("change", ".input_seacrh", function (e) {
		old_href = '';
        changed_elem = $(this).attr('name');
        $('#changed_elem').val(changed_elem);
        if (changed_elem === undefined) {
            var prmin = parseInt($('#prmin').val());
            var prmax = parseInt($('#prmax').val());
            if (e.target.id == 'prmax') {
                $('#price_fields').val(1);
                /*$("#form-search").submit();*/
            }
            if (e.target.id == 'prmin') {
                $('#price_fields').val(1);
                /*if (prmax > prmin)
                 $("#form-search").submit();*/
            }

            /*return false;*/
        }
        /*$('.leftcol4').removeClass('col-md-4').addClass('col-md-3');
         $('.rightcol8').removeClass('col-md-12').addClass('col-md-12');*/
        $('.cleared_filter').show();
        /*if ( $(this).attr('name') == "city" ) {*/

        if (changed_elem == 'city') {
            $('#selectregions').children('option').not(':first').remove();
        }

        if (changed_elem != 'city' /*|| (changed_elem=='city' && refresh_test_exc('city')==true)*/) {
            refresh_project_city = 1;
            $('#ss_p_city').val($('select[name=city]').val());
        }

        if (changed_elem != 'project_type' /*|| (changed_elem=='project_type' && refresh_test_exc('project_type')==true)*/) {
            refresh_project_type = 1;
            $('#ss_p_type').val($('select[name=project_type]').val());
        }

        if (changed_elem != 'price') {

            refresh_price = 1;
            $('#ss_price').val($('select[name=price]').val());
        }
        if (changed_elem == 'price') {
            $('#price_fields').val(0);
        }
        if (changed_elem != 'rooms' /*|| (changed_elem=='rooms' && refresh_test_exc('rooms')==true)*/) {
            refresh_project_rooms = 1;
            $('#ss_room').val($('select[name=rooms]').val());
        }
        if (changed_elem == 'rooms') {
            /*alert('changed_elem rooms');*/
            $('#selectdevice option[value="<?= route('front.filter_rooms', ['']); ?>/' + ($(this).val() != '' ? $(this).val() : 'all') + '"]').attr('selected', 'selected');
        }

        if (changed_elem != 'regions[]' /*|| (changed_elem=='regions[]' && refresh_test_exc('regions')==true)*/) {
            var ss_p_regions = [];
            $.each($("#selectregions option:selected"), function () {
                ss_p_regions.push($(this).val());
            });
            refresh_regions = 1;
            $('#ss_p_regions').val(JSON.stringify(ss_p_regions));
        }
        if (changed_elem != 'project_categories[]' /*|| (changed_elem=='project_categories[]' && refresh_test_exc('project_categories')==true)*/) {
            var ss_p_tags = [];
            $.each($("#project_categories option:selected"), function () {
                ss_p_tags.push($(this).val());
            });
            refresh_project_tags = 1;
            $('#ss_p_tags').val(JSON.stringify(ss_p_tags));
        }

        /*changed_elem == 'city' so load all filters*/
        /*if (changed_elem == 'city'){
         refresh_price = 1;
         refresh_project_rooms = 1;
         refresh_regions = 1;
         refresh_project_tags = 1;
         }*/


        $("#form-search").submit();
        return false;
    });
    /*function refresh_dropdown(dropdownclass, select_option){
     if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
     $(dropdownclass).html('');
     $(select_option).each(function(i){
     
     var selected = $(this).is(':selected')?'fa_check':'';
     var valu = $(this).val();
     var text = $(this).text();
     if (valu != '' && valu != 'property-for-sale')
     $(dropdownclass).append('<li data-value="' + valu + '" class="' + selected + '"> ' + text + '</li>');
     });
     }*/
    /*if(dropdownclass=='.dropdown-price'){
     refresh_dropdown();
     alert('refs');
     }*/
    /*}*/
    $("#form-search").on("submit", function (e) {
        submit_form();
        return false;
    });
    function submit_form(g = false, showmap = '') {
	
		if($('#searchcss').length==0){
            $('body').append('<link rel="stylesheet" id="searchcss" type="text/css" href="{{ asset('css/search.min.css?v=06') }}">');
			<?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
				$('body').append('<link rel="stylesheet" type="text/css" href="{{ asset('css/search-en.min.css?v=05') }}">');
			<?php } ?>
		
		}

        var frm = $('#form-search');
        var infos = frm.serialize();
        var price_fields = $('#price_fields').val();
        var prmin = $('#prmin').val() == '' ? 0 : parseInt($('#prmin').val());
        var prmax = $('#prmax').val() == '' ? 0 : parseInt($('#prmax').val());
        var current_curr = 'USD'; /*$('#current_curr').val();*/
        var act = frm.attr('action');
        if (showmap == 'only')
            infos = infos + '&ajax=1';
        else
            infos = infos + '&ajax=1&curr=' + current_curr + '&price_fields=' + price_fields + (price_fields == 1 ? '&price2=' + prmin + '-' + prmax : '') + ($('select[name=sorting]').length ? '&sorting=' + $('select[name=sorting]').val() : '');

        if ($('#changed_elem').val() == 'city') {
            infos = infos.replace('project_categories', 'removeit') + '&project_type=&rooms=&price_fields=0';/*&project_categories[]=*/
        }


        if (g == true) {
            infos = 'g=1&ajax=true'; /*?g=1*/
            /*$('#ss_p_city').val(-1);
             $('#ss_p_regions').val(-1);
             $('#ss_p_type').val(-1);
             $('#ss_price').val(-1);
             $('#ss_room').val(-1);
             $('#ss_p_tags').val(-1);*/
        }

        $('.loading_sec').show();
        $.get(act, infos, function (resp) {
            $('h1').html('<?= trans("front.Properties") ?>');
            $('.loading_sec').hide();
            $('.type_full strong.num').html(resp.inputs.count);
            $('.type_mob strong.num').html(resp.inputs.count);
            if (showmap != 'only') {/*load map only dont reload menu or project list*/
				$("html, body").animate({ scrollTop: 0 }, "slow");

				/*alert('showmap != only');*/
				
                window.history.pushState("", "", resp.url);
                display_projects(resp.content);
                $('span.page_number').html(resp.page_number);
                $('.categories_sec.mob ul li').not('li:first, li:eq(1)').remove();
                $('.categories_sec.mob ul').append(resp.__links);
                $('ul.pagination').html(resp.pagin_block);
                
				
				
				var h1title = resp.inputs.about.split('</h1>')[0] + '</h1>';
				var icontent = resp.inputs.about.split('</h1>')[1];
				if(icontent.length>100)
					$('.content_section').show();
				else
					$('.content_section').hide();
				$('#about-content').html(icontent
<?php /* if (Helper::get_device() != 'full') { ?>
  + ' <div class="btncenter"><button class="" id="show_more">{{ trans("front.show more")}}</button></div>'
  <?php } */ ?>
                );
                if (h1title != '') {
                    /*var h1num = $('h1:first .num').html();*/
                    $('h1:first').html($(h1title).text());
                    /*$('#about-content h1').remove();*/
                }

                $(".sectionblank a").attr("target", "_blank");
                if ($('#changed_elem').val() != 'regions[]' || ($('#changed_elem').val() == 'regions[]' && $('#selectregions :selected').length == 0)) {


                    var s_project_regions = JSON.parse(resp.inputs.project_regions_options);
                    $('#selectregions').children('option').not(':first').remove(); /*:nth-child(n+3)*/

                    if (s_project_regions.length == 0) {

                    } else {
                        for (var i = 0; i < s_project_regions.length; i++) {
                            for (var j = 0; j < projects_regions.length; j++) {
                                if (s_project_regions[i] == projects_regions[j].id) {
                                    var selected = "";
                                    if ($('#ss_p_regions').val() != '' && jQuery.inArray(projects_regions[j].slug, JSON.parse($('#ss_p_regions').val())) !== -1) {
                                        if (g == false)
                                            selected = " selected='selected' ";
                                    }
                                    $('#selectregions').append('<option value="' + projects_regions[j].slug + '" ' + selected + '>' + projects_regions[j].name + '</option>');
                                }
                            }
                        }
                    }

                    <?= $js_select_picker_refresh ?>
                }


                if ($('#changed_elem').val() != 'city' && $('#changed_elem').val() != 'regions[]') {

                    var s_project_citys = JSON.parse(resp.inputs.project_citys_options);
                    /*if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
                     $('select[name=city]').children('option:nth-child(n+2)').remove();
                     else*/
                    $('select[name=city]').children('option:nth-child(n+3)').remove();
                    if (s_project_citys.length == 0) {
                        /*for(var j=0;j<projects_citys.length;j++){
                         $('select[name=project_city]').append('<option value="'+projects_citys[j].slug+'">'+projects_citys[j].name+'</option>');
                         }*/
                    } else {
                        /*$('select[name=project_city] option').each(function(i){if($(this).val()!='0')$(this).remove();});*/
                        for (var i = 0; i < s_project_citys.length; i++) {
                            for (var j = 0; j < projects_citys.length; j++) {
                                if (s_project_citys[i] == projects_citys[j].id)
                                    $('select[name=city]').append('<option value="' + projects_citys[j].slug + '">' + projects_citys[j].name + '</option>');
                            }
                        }
                    }
                    if (g == false)
                        $('select[name=city] option[value="' + $('#ss_p_city').val() + '"]').prop('selected', true);
                    /*refresh_dropdown('.dropdown-city', 'select[name=city] option');*/
                    <?= $js_select_picker_refresh ?>
                } else if ($('#changed_elem').val() == 'city' && $('select[name=city]').val() == 'turkey') {
                    /*if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
                     $('select[name=city]').children('option:nth-child(n+1)').remove();
                     else*/
                    $('select[name=city]').children('option:nth-child(n+2)').remove();
                    for (var j = 0; j < projects_citys.length; j++) {
                        $('select[name=city]').append('<option value="' + projects_citys[j].slug + '">' + projects_citys[j].name + '</option>');
                    }
                    /*refresh_dropdown('.dropdown-city', 'select[name=city] option');*/
                    <?= $js_select_picker_refresh ?>
                }

                if ($('#changed_elem').val() != 'project_type') {

                    var s_project_types = JSON.parse(resp.inputs.project_types_options);
                    /*if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
                     $('select[name=project_type]').children('option:nth-child(n+2)').remove();
                     else*/
                    $('select[name=project_type]').children('option:nth-child(n+3)').remove();
                    if (s_project_types.length == 0) {
                        for(var j=0;j<projects_types.length;j++){
                         $('select[name=project_type]').append('<option value="'+projects_types[j].slug+'">'+projects_types[j].name+'</option>');
                         }
                    } else {
                        /*$('select[name=project_type] option').each(function(i){if($(this).val()!='0')$(this).remove();});*/
                        for (var i = 0; i < s_project_types.length; i++) {
                            for (var j = 0; j < projects_types.length; j++) {
                                if (s_project_types[i] == projects_types[j].id)
                                    $('select[name=project_type]').append('<option value="' + projects_types[j].slug + '">' + projects_types[j].name + '</option>');
                            }
                        }
                    }
                    if (g == false)
                        $('select[name=project_type] option[value="' + $('#ss_p_type').val() + '"]').prop('selected', true);
                    /*refresh_dropdown('.dropdown-project_type', 'select[name=project_type] option');*/
                    <?= $js_select_picker_refresh ?>
                }


                if ($('#changed_elem').val() != 'price') {

                    var s_prices_options = JSON.parse(resp.inputs.prices_options);
                    /*if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
                     $('select[name=price]').children('option:nth-child(n+2)').remove();
                     else*/
                    $('select[name=price]').children('option:nth-child(n+3)').remove();
                    if (s_prices_options.length == 0) {
                    } else {
                        for (var i = 0; i < s_prices_options.length; i++) {
                            for (var k in projects_prices) {
                                if (s_prices_options[i] == k)
                                    $('select[name=price]').append('<option value="' + k + '">' + projects_prices[k] + '</option>');
                            }
                        }
                    }
                    /*$('select[name=price] option[value="' + ss_price + '"]').prop('selected', true);*/
                    if (g == false)
                        $('select[name=price] option[value="' + $('#ss_price').val() + '"]').prop('selected', true);
                    /*refresh_dropdown('.dropdown-price', 'select[name=price] option');*/
                    <?= $js_select_picker_refresh ?>
                }

                if ($('#changed_elem').val() == 'rooms') {
                    var listItems = $("ul.dropdown-rooms li");
                    listItems.each(function (idx, li) {
                        if ($(li).hasClass('fa_check')) {
                            $('#selectdevice option[value="<?= route('front.filter_rooms', ['']); ?>/' + ($(li).data('value') != '' ? $(li).data('value') : 'all') + '"]').attr('selected', 'selected');
                        }
                    });
                }

                if ($('#changed_elem').val() != 'rooms') {
                    var s_rooms_options = JSON.parse(resp.inputs.rooms_options);
                    /*if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
                     $('select[name=rooms]').children('option:nth-child(n+2)').remove();
                     else*/
                    $('select[name=rooms]').children('option:nth-child(n+3)').remove();
                    if (s_rooms_options.length == 0) {
                        for (var k in projects_rooms) {
                            $('select[name=rooms]').append('<option value="' + k + '">' + projects_rooms[k] + '</option>');
                        }
                    } else {
                        for (var i = 0; i < s_rooms_options.length; i++) {
                            for (var k in projects_rooms) {
                                if (s_rooms_options[i] == k)
                                    $('select[name=rooms]').append('<option value="' + k + '">' + projects_rooms[k] + '</option>');
                            }
                        }
                    }
                    /*$('select[name=rooms] option[value="' + ss_room + '"]').prop('selected', true);*/
                    if (g == false)
                        $('select[name=rooms] option[value="' + $('#ss_room').val() + '"]').prop('selected', true);
                    /*refresh_dropdown('.dropdown-rooms', 'select[name=rooms] option');*/
                    <?= $js_select_picker_refresh ?>
                }



                if ($('#changed_elem').val() != 'project_categories[]') {
                    if ('ismobil' == 'isfull') {
                        /*$(".dropdown-regions").html(resp.regions_listing);*/
                        var x = '1';
                    } else {
                        var s_project_tags = JSON.parse(resp.inputs.project_tags_options);
                        $('#project_categories').children('option').remove(); /*:nth-child(n+3)*/

                        if (s_project_tags.length == 0) {
                            /*for(var j=0;j<projects_tags.length;j++){
                             $('#project_categories').append('<option value="'+projects_tags[j].slug+'">'+projects_tags[j].name+'</option>');
                             }*/
                        } else {
                            /*$('select[name=project_tag] option').each(function(i){if($(this).val()!='0')$(this).remove();});*/
                            for (var i = 0; i < s_project_tags.length; i++) {
                                for (var j = 0; j < projects_tags.length; j++) {
                                    if (s_project_tags[i] == projects_tags[j].id) {
                                        var selected = "";
                                        if ($('#ss_p_tags').val() != '' && jQuery.inArray(projects_tags[j].slug, JSON.parse($('#ss_p_tags').val())) !== -1) {
                                            if (g == false)
                                                selected = " selected='selected' ";
                                        }
                                        $('#project_categories').append('<option value="' + projects_tags[j].slug + '" ' + selected + '>' + projects_tags[j].name + '</option>');
                                    }
                                }
                            }
                        }



                        /*refresh_dropdown('.dropdown-project_categories', '#project_categories option');*/
                        <?= $js_select_picker_refresh ?>
                    }
                }
                if ($('#changed_elem').val() == 'city') {

                    $('select[name="rooms"] option:selected').prop("selected", false);
                    $('select[name="project_categories[]"] option:selected').prop("selected", false);
                    $('select[name="project_type"] option:selected').prop("selected", false);

                    <?= $js_select_picker_refresh ?>
                }


                $('.input_seacrh_price .btn').removeClass('active');
                $('#' + $('#current_curr').val()).addClass('active');
                $('.input_seacrh_price .input-group-text').html(format_curr($('#current_curr').val()));
                /*if (price_fields == '1'){
                 $('select[name=price]').children('option:nth-child(n+3)').remove();
                 var arrprice = Array();
                 if ($('#current_curr').val() == 'TRY')
                 arrprice = arr_prices_try;
                 else if ($('#current_curr').val() == 'USD')
                 arrprice = arr_prices_usd;
                 else if ($('#current_curr').val() == 'SAR')
                 arrprice = arr_prices_sar;
                 else if ($('#current_curr').val() == 'EUR')
                 arrprice = arr_prices_eur;
                 
                 for (var i = 0; i < arrprice.length; i++){
                 $('select[name=price]').append('<option value="' + arrprice[i]['k'] + '">' + arrprice[i]['v'] + '</option>');
                 }
                 $("select[name=price]").selectpicker("refresh");
                 $('.input_seacrh_price .btn').removeClass('active');
                 $('#' + $('#current_curr').val()).addClass('active');
                 $('.input_seacrh_price .input-group-text').html(format_curr($('#current_curr').val()));
                 $('#prmin').val(prmin);
                 $('#prmax').val(prmax);
                 $('.input_seacrh_price span.filter-option').text(prmin + '-' + prmax + format_curr($('#current_curr').val()));
                 }*/

                /*update selecteds count on regions and tags*/
                var len_selects = $('select[name="project_categories[]"] option:selected').length;
                if (len_selects == 0)
                    $('select[name="project_categories[]"]').parent(".dropdown").children("button").text('<?= trans("front.special advantages") ?>');
                else
                    $('select[name="project_categories[]"]').parent(".dropdown").children("button").text(len_selects + ' <?= trans("front.selecteds"); ?>');
                var len_selects_r = $('select[name="regions[]"] option:selected').length;
                if (len_selects_r == 0)
                    $('select[name="regions[]"]').parent(".dropdown").children("button").text('<?= trans("front.all regions") ?>');
                else
                    $('select[name="regions[]"]').parent(".dropdown").children("button").text(len_selects_r + ' <?= trans("front.selecteds"); ?>');
                /*حذف زر حذف الفلاتر*/
                if ($('#form-search button.dropdown-toggle:eq(0)').text().trim() == '<?= trans("front.budget") ?>' &&
                        $('#form-search button.dropdown-toggle:eq(1)').text().trim() == '<?= trans("front.city") ?>' &&
                        $('#form-search button.dropdown-toggle:eq(2)').text().trim() == '<?= trans("front.all regions") ?>' &&
                        $('#form-search button.dropdown-toggle:eq(3)').text().trim() == '<?= trans("front.property type") ?>' &&
                        $('#form-search button.dropdown-toggle:eq(4)').text().trim() == '<?= trans("front.number of rooms") ?>' &&
                        $('#form-search button.dropdown-toggle:eq(5)').text().trim() == '<?= trans("front.special advantages") ?>') {
                    $('.delete-filter-type').removeClass('delete-filter-type');
                }
                /*update selecteds count on regions and tags*/
            }/* End load map only*/

            /*initMap(JSON.parse(resp.map_projects), resp.latitude, resp.longitude);*/
            page = 1;
        });
        return false;
    }

    /*change sort*/
    $(document).on("click", ".btn_sort_change", function () {
        /*console.log('sub3');*/
        var ipt = $(this).find("input");
        if (ipt.val() == 'asc') {
            ipt.val("");
            var cls = "fa-sort-amount-desc";
        } else {
            ipt.val("asc");
            var cls = "fa-sort-amount-asc";
        }
        $(this).find(".fa").removeClass("fa-sort-amount-desc fa-sort-amount-asc").addClass(cls);
        $("#form-search").submit();
        return false;
    });
    /* mbl listing*/
    $(document).on("click", ".search-options .dropdown .dropdown-menu li", function () {
        /*console.log('sub1');*/
        var $this = $(this);
        var vl = $(this).attr("data-value");
        var thisText = $(this).text();
        var thisName = $this.parent("ul").parent(".dropdown").children("button");
        var drp = $this.closest(".dropdown");
        var select = drp.find("select");
        changed_elem = select.attr("name");
        var icon = $this;
        if (drp.hasClass("dropdown-multiple")) {/*multi check*/
            if (!icon.hasClass("fa_check")) {
                icon.addClass("fa_check");
                select.append('<option value="' + vl + '" selected>' + vl + '</option>');
                /*select.find("option[value='" + vl + "']").prop('selected', true);*/
                $(thisName).text(thisText);
            } else {
                icon.removeClass("fa_check");
                select.find("option[value='" + vl + "']").remove();
                /*select.find("option[value='" + vl + "']").prop('selected', false);*/

                if (changed_elem == 'regions[]')
                    thisName.text('<?= trans("front.all regions"); ?>');
                else if (changed_elem == 'project_categories[]') {
                    thisName.text('<?= trans("front.special advantages"); ?>');
                }
            }
            var length_selects = $('select[name="' + changed_elem + '"] option:selected').length;
            if (length_selects > 0)
                thisName.text(length_selects + ' <?= trans("front.selecteds"); ?>');
<?php /* 	<?php
  //if(changed_elem=='regions[]')
  //	thisName.text(length_selects + ' <?= trans("front.regions"); ?>');
  //else if(changed_elem=='project_categories[]')
  //	thisName.text(length_selects + ' <?= trans("front.tags"); ?>');
  //}
 */ ?>
            /*console.log('Selected: '+$('select[name="'+changed_elem+'"] option:selected').length);*/

        } else {/* uni select*/

            if (!icon.hasClass("fa_check")) {
                /*select.html('<option value="'+vl+'" selected>'+vl+'</option>');*/
                $(thisName).text(thisText);
                $('select[name=' + changed_elem + '] option[value="' + vl + '"]').prop('selected', true);
            } else {
                console.log(changed_elem + '-----' + thisName);
                $('select[name=' + changed_elem + '] option:selected').prop("selected", false).trigger('change');
                icon.removeClass("fa_check"); /*.trigger('change');*/
                if (changed_elem == 'city')
                    thisName.text('<?= trans("front.city"); ?>');
                else if (changed_elem == 'price') {
                    thisName.text('<?= trans("front.budget"); ?>');
                    /*refresh_dropdown('.dropdown-price', 'select[name=price] option');*/
                    <?= $js_select_picker_refresh ?>
                } else if (changed_elem == 'project_type') {
                    thisName.text('<?= trans("front.property type"); ?>');
                    /*refresh_dropdown('.dropdown-project_type', 'select[name=project_type] option');*/
                    <?= $js_select_picker_refresh ?>
                } else if (changed_elem == 'rooms') {
                    thisName.text('<?= trans("front.number of rooms"); ?>');
                    /*refresh_dropdown('.dropdown-rooms', 'select[name=rooms] option');*/
                    <?= $js_select_picker_refresh ?>
                }
            }
            $this.addClass("fa_check").siblings().removeClass("fa_check");
            /*$this.children('i').addClass("fa_check").parent().siblings().removeClass("fa_check");*/
        }
<?php
/* refresh_regions = 0;
  if ( select.attr("name") == "city" ) {
  $('select.selectregions').html("<option></option>");
  refresh_regions = 1;
  } */


/* $(thisName).empty();
  $(thisName).append(thisText); */
?>
        $('#changed_elem').val(changed_elem);
        if (changed_elem == 'city') {
            $('#selectregions').children('option').not(':first').remove();
            $('select[name="regions[]"]').parent('.dropdown').children('button').text('<?= trans("front.all regions"); ?>');

            /*
             $('select[name="rooms"] option:selected').prop("selected", false);
             $('select[name="project_categories[]"] option:selected').prop("selected", false);
             $('select[name="project_type"] option:selected').prop("selected", false);
             
             <?= $js_select_picker_refresh ?>*/
        }

        if (changed_elem != 'city') {
            refresh_project_city = 1;
            $('#ss_p_city').val($('select[name=city]').val());
        }

        if (changed_elem != 'project_type') {
            refresh_project_type = 1;
            $('#ss_p_type').val($('select[name=project_type]').val());
        }

        if (changed_elem != 'price') {
            refresh_price = 1;
            $('#ss_price').val($('select[name=price]').val());
        }

        if (changed_elem != 'rooms') {
            refresh_project_rooms = 1;
            $('#ss_room').val($('select[name=rooms]').val());
        }

        if (changed_elem != 'regions[]') {
            var ss_p_regions = [];
            $.each($("#selectregions option:selected"), function () {
                ss_p_regions.push($(this).val());
            });
            refresh_regions = 1;
            $('#ss_p_regions').val(JSON.stringify(ss_p_regions));
        }
        if (changed_elem != 'project_categories[]') {
            var ss_p_tags = [];
            $.each($("#project_categories option:selected"), function () {
                ss_p_tags.push($(this).val());
            });
            refresh_project_tags = 1;
            $('#ss_p_tags').val(JSON.stringify(ss_p_tags));
        }





        $("#form-search").submit();
        $(".filter-icon").addClass("delete-filter-type");
    });
    $(".search-options .dropdown .btn").on("click", function () {
        $(this).siblings().slideToggle(300).parent().siblings().children(".dropdown-menu").slideUp(300);
    });
    $('.search-options .dropdown').on('show.bs.dropdown', function () {
        return false;
    });
    
	
	var height_plus = 200;
		if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
			height_plus = 650;
		}else{
			/*$('.load_more').click();
			pagination_click(old_href);*/
		}
	if($('#about-content .clearfix').text().length>200){
		
	}else{
		pagination_click();
	}
	
	$(window).scroll(function() {
    if($(window).scrollTop() >= $(document).height() - $(window).height()- ($('footer').height()+height_plus)) {
        
           pagination_click();
		   /*$('.load_more').click();*/
    }
	});
	/*$(document).on('click','.load_more',function(e){
		e.preventDefault();
        var href = $(this).attr('href');
        
		if(old_href!=href){
			old_href = href;
			
			
			url = href+ "&ajax=1";
			$.ajax({
			 url : url,
			 }).done(function (resp) {
				 window.history.pushState("", "", href);
				$('.block_sec #pagin_block').remove();
				$('.block_sec').append(resp);
			 }).fail(function () {
				
			 });
		 }
	});*/

    /* paginate ajax*/
    $(document).on("click", ".pagination_list .pagination a", function (e) {
		/*alert('click .pagination a');*/
        e.preventDefault();
		pagination_click();
        return false;
    });
	function pagination_click(){
		if($('#searchcss').length==0){
            $('body').append('<link rel="stylesheet" id="searchcss" type="text/css" href="{{ asset('css/search.min.css?v=06') }}">');
			<?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
				$('body').append('<link rel="stylesheet" type="text/css" href="{{ asset('css/search-en.min.css?v=05') }}">');
			<?php } ?>
		
		}
        var href = $(".pagination_list .pagination a").attr('href');
        
		/*console.log("OLD->NEW: "  + old_href + '!=' + href);*/
		if($(".pagination_list .pagination a").length>0)
		if(old_href!=href){
			old_href = href;
			
			
			var act = $("#form-search").serialize();
			var price_fields = $('#price_fields').val();
			var prmin = $('#prmin').val() == '' ? 0 : parseInt($('#prmin').val());
			var prmax = $('#prmax').val() == '' ? 0 : parseInt($('#prmax').val());
			var current_curr = $('#current_curr').val();
			url = href + "&" + act /*+ "&page=" + page*/ + '&ajax=1&map=none&curr=' + current_curr + '&price_fields=' + price_fields + (price_fields == 1 ? '&price2=' + prmin + '-' + prmax : '');
			/*$('.loading_sec').show();*/
			
			$.ajax({
				url: url,
				type: "get",
			}).done(function (resp) {
				$('.loading_sec').hide();
				$('.type_full strong.num').html(resp.inputs.count);
				$('.type_mob strong.num').html(resp.inputs.count);
				/*$("#projects-paginate").remove();*/
				display_projects(resp.content,true);
				$('span.page_number').html(resp.page_number);
				$('ul.pagination').html(resp.pagin_block);
				/*window.history.pushState("", "", resp.url); //pagination url*/
				/*initMap(JSON.parse(resp.map_projects), resp.latitude, resp.longitude);*/
			}).fail(function (jqXHR, ajaxOptions, thrownError) {
				console.log('server not responding...');
			});
		}
	}
    $(window).on("popstate", function () {
        location.reload();
    });
    function format_curr(curr) {
        if (curr == 'TRY')
            return '₺';
        if (curr == 'USD')
            return '$';
        if (curr == 'SAR')
            return 'SR';
        if (curr == 'EUR')
            return '€';
    }
    /* change price selectprice*/
    $(document).on("change", ".input_minprice, .input_maxprice", function (ev) {
        var minprice = $(".input_minprice").val();
        var maxprice = $(".input_maxprice").val();
        var vl = ("(" + minprice + " - " + maxprice + ")");
        if (minprice <= 0 && maxprice <= 0) {
            vl = "<?= trans("front.price"); ?>";
        }
        $("#optionprice").attr("title", vl);
        $(this).closest(".bootstrap-select").find("button").attr("title", vl);
        $(this).closest(".bootstrap-select").find(".filter-option").text(vl);
        return false;
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



        /*$('.main_menu .links>li>a.projects_btn').addClass("active");*/
        /*$("body").on("click", ".control_icons .change_display", function () {
            $(".control_icons a.change_display").removeClass("active");
            $(this).addClass("active");
        });*/
        /*$("body").on("click", "a.map_btn", function () {
            if (!$('.map_btn').hasClass('active'))
                submit_form(false, 'only');
            $(this).toggleClass("active");
            $(".map_sec").toggleClass("hidden");
        });*/
        
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
        if ($(window).width() <= 812) {
            outMenu = document.getElementById('outMenu');
            var fixeSecdHeight = $(".fixed_sec .fast_search").height();
            setTimeout(function () {
                outMenu.setAttribute("style", "height: calc(100% -  291px)");
                $("#outMenu").css("top", "291px");
            }, 1000);
            $("#outMenu").on("click", function () {
                $(".close_filter_btn").trigger("click");
            });
        }



   
    

    function display_projects(projects,append=false) {
		
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


    /*$(document).ready(function () {
        var projects = jsonprojects;
        display_projects(projects);
    });*/



    /*
     $('.support_links a').click(function(e){
     e.preventDefault();
     $('#callmeModal').modal('show');
     });*/

    var counter = 1;

    $(".show_less_btn").hide();
    $(document).on("click", ".show_more_btn", function () {

        if (counter == 1) {
            $('.content_section .cont').animate({'max-height': '400px'}, 200);
            $('html, body').animate({
                scrollTop: $('.content_section').offset().top - 100
            }, 'slow');
            $(".show_less_btn").show();
            counter++;
            return true;

        } else if (counter == 2) {
            $('.content_section .cont').animate({'max-height': '800px'}, 200);
            $('html, body').animate({
                scrollTop: $('.content_section').offset().top - 50
            }, 'slow');
            $(".show_less_btn").show();
            counter++;
            return true;

        } else if (counter == 3) {
            var height_div = $('.content_section .cont').css({'max-height': 'initial'}).height();
            $('.content_section .cont').animate({'max-height': height_div}, 200);
            $('html, body').animate({
                scrollTop: $('.content_section').offset().top + 250
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
        $('.content_section .cont').animate({'max-height': '86px'}, 300);
        $('html, body').animate({
            scrollTop: $('.content_section').offset().top - 100
        }, 'slow');
        counter = 1;
        $(".action_content").removeClass("type_less");
        setTimeout(function () {
            $(".show_less_btn").hide();
            $(".show_more_btn").show();
        }, 300);
    });

/*
	}else{
        setTimeout(waitForScriptsLoaded2, 250);
    }
}
waitForScriptsLoaded2();*/

});




<?php if(isset($inputs["cat_id"])){ ?>

/*add keywords blocks*/
		<?php
			$f_lang = ($current_lang=='pe'?'fa':$current_lang);
			$cat_id = $inputs["cat_id"];
			
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
		
		
	var cnt_sec = $( "#about-content .clearfix" ).children().length/(arr_keywords.length +1);
	if(cnt_sec<2)
	cnt_sec = cnt_sec+2;

	var j=0;
	for(var i=0;i<arr_keywords.length;i++){
	j++;
	if(i!=0)
	var icnt_sec = Math.ceil(i*cnt_sec);
	else
	var icnt_sec = Math.ceil(cnt_sec-3);

	if(icnt_sec+j < $( "#about-content .clearfix" ).children().length-2 )
	$( "#about-content .clearfix" ).children().eq(icnt_sec+j).after(html_keyword.replace('%url%',arr_keywords[i].url).replace('%keyword%',arr_keywords[i].keyword).replace('%keyword%',arr_keywords[i].keyword));
	}
	}
}




			<?php } ?>

<?php } ?>

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
                <a class="project_name jazzira_font" href="#url">%title%</a>
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



@endsection




@section('schemaorg')


<?php


foreach($projects as $project){
	if($project->getSeoTitle()!='' and isset($project->flavors[0])){
	$flavor = $project->flavors[0]->first();
	/*if (empty($flavor)) {
        $flavors = $project->flavors();
        $flavor = $flavors->orderBy("price", "ASC")->first();
    }*/
	
	$project_min_price = Helper::decimal_format(@$flavor->price, $project->is_price_usd);
	$cardphoto = @$project->cardphoto;
	?>
<script type="application/ld+json">
  {
  "@context": "http://www.schema.org",
  "@type": "Product",
  "aggregateRating": {
  "@type": "AggregateRating",
  "ratingValue": "4.<?=rand(1,9) ?>",
  "reviewCount": "<?= $project->likes+10 ?>"
  },
  "name": "<?= htmlentities($project->getSeoTitle()); ?>",
  "offers" : {
  "@type": "Offer",
  "url": "<?= $project->frontUrl(); ?>",
  "price": "<?= strip_tags(str_replace('.','',$project_min_price)); ?>",
  "priceCurrency": "TRY",
  "priceValidUntil": "2025-11-05",
  "itemCondition": "https://schema.org/UsedCondition",
  "availability": "https://schema.org/InStock",
  "seller": {
  "@type": "Organization",
  "name": "DamasTurk"
  }
  },
  "image": "<?= Helper::media_url($cardphoto); ?>"
  ,
  "description": "<?= htmlentities($project->getIntroCard()); ?>",
  "brand": {
  "@type": "Thing",
  "name": "Damasturk"
  },
  "review": {
  "@type": "Review",
  "reviewRating": {
  "@type": "Rating",
  "ratingValue": "<?= (rand(4,5)==4)?'4.'.rand(1,9):5 ?>",
  "bestRating": "5"
  },
  "author": {
  "@type": "Person",
  "name": "abdo"
  }}
  }
  </script>
<?php }} ?>

<?php
$sum_likes = $allprojects->sum("likes");
if ($sum_likes > 0 and @$inputs['seo_title']!='') {
    ?>
    <script data-schema="Product" type="application/ld+json">
        {
        "@context":"http://schema.org",
        "@type":"RealEstateAgent",

        <?php
        $sum_likes = round($sum_likes / 8) + 2;
        if ($sum_likes > 0) {
            ?>
            "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "<?php
            $rat = (rand(4, 5) == 4) ? '4.' . rand(7, 9) : 5;
            echo $rat;
            ?>",
            "reviewCount": "<?= $sum_likes; ?>"
            },
        <?php } ?>




        "name":"{{ str_replace('"','',@$inputs['seo_title']) }}",
        "description":"{{ str_replace('"','',@$inputs['seo_description']) }}",
        "priceRange": "$50000 - $2000000",
        <?php
        $img = 'https://www.damas.net/uploads/2b29ff140b63733bbe209a1cb13baba1a.jpg';
        if (count($projects) > 0) {
            if ($projects[0]->cardphoto)
                $img = Helper::get_thumbnail($projects[0]->cardphoto);
        }
        ?>
        "image":"{{ $img }}",
        "telePhone":"<?= $infos->tel_1; ?>",
        "address":{
        "@type":"PostalAddress",
        "streetAddress":"{{ Helper::TrToEng($infos->address) }}",
        "addressLocality": "Istanbul",
        "postalCode": "34200",
        "addressCountry": "Turkey"
        }
        <?php /* ?>
          ,



          "email":"<?= $infos->email; ?>",
          "geo":{
          "@type":"GeoCoordinates",
          "latitude":"<?= $infos->latitude; ?>",
          "longitude":"<?= $infos->longitude; ?>"
          },
          "openingHours":"Mo-Sa 09:00-19:30",
          "url":"<?= url("/"); ?>",
          "sameAs":["<?= $infos->facebook ?>","<?= $infos->twitter ?>",
          "<?= $infos->gplus ?>",
          "<?= $infos->linkedin ?>","<?= $infos->instagram ?>","<?= $infos->youtube ?>"],
          "contactPoint": [
          {   "@type": "ContactPoint",
          "telephone": "<?= $infos->tel_1; ?>",
          "contactType": "customer service",
          "areaServed": "Turkey",
          "availableLanguage": "Arabic,English,Turkish,French,farsi",
          "contactOption": "HearingImpairedSupported"
          }
          ]
          <?php */ ?>
        }
    </script>
<?php } ?>





<script data-schema="Article" type="application/ld+json">
		{
		"@context":"http://schema.org",
		"@type":"Article",
		"mainEntityOfPage":{
			"@type":"WebPage",
			"@id":"<?= str_replace('/public/', '/', Request::url()); ?>"
			},
			"headline":"{{ htmlentities(@$inputs['seo_title'])  }}",
			"articleBody":"{{ htmlentities(strip_tags(html_entity_decode(@$inputs['about'])))  }}",
			"url":"<?= str_replace('/public/', '/', Request::url()); ?>",
			<?php if(@$inputs['og_image']!=''){ ?>
			"image":{
				"@type":"ImageObject",
				"url":"{{ @$inputs['og_image'] }}",
				"width":1200,
				"height":640
				},
			<?php } ?>
			"articleSection":"{{ 'realestate' }}",
			"datePublished":"<?= date(DATE_ISO8601, strtotime(isset($inputs["createdAt"])?$inputs["createdAt"]:date('Y-01-01'))) ?>",
			"dateModified":"<?= date(DATE_ISO8601, strtotime(date('Y-m-d'))-2000) ?>",
			"author":{"@type":"Organization","name":"DamasTurk","url":"https://damas.net"},
			"publisher":{
				"@type":"Organization","name":"DamasTurk"
				}
		}
    </script>
	
	<script type="application/ld+json">
	
    {"@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[

<?php
if(!function_exists('getNameTypeBySlug')){
    function getNameTypeBySlug($slug,$ProjectTypes){
    	foreach ($ProjectTypes as $type) {
    		if($type->slug==$slug)
    			return $type->getName() .' '. trans('front.for sale');
    	}
    	return trans('front.property for sale');
    }
}
if(!function_exists('getNameCityBySlug')){
    function getNameCityBySlug($slug,$citys){
    	foreach ($citys as $c) {
    		if($c->slug==$slug)
    			return $c->getName();
    	}
    	return '';
    }
}
//echo $__type.",".$__city.",".$__var1.",".$__var2;
$j=1; ?>
    {"@type":"ListItem","position":<?= $j ?>,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
    <?php $j++; ?>
	{"@type":"ListItem","position":<?= $j ?>,"name":"{{ trans('front.property for sale') .' '. getNameCityBySlug($__city,$citys) }}","item":"{{ route("front.search", ["property-for-sale", $__city]) }}"}
    
	<?php if($__type != 'property-for-sale'){ $j++; ?>
	,{"@type":"ListItem","position":<?= $j ?>,"name":"{{ getNameTypeBySlug($__type,$ProjectTypes)  .' '. getNameCityBySlug($__city,$citys) }}","item":"{{ route("front.search", [$__type, $__city]) }}"}
    <?php } $j++; ?>
	
	<?php if($__var1!=null && isset($q_tags) && count($q_tags)>0){
			//echo $q_tags[0]->getName();
			//exit;
	?>
	,{"@type":"ListItem","position":<?= $j ?>,"name":"{{ getNameTypeBySlug($__type,$ProjectTypes) .' '. getNameCityBySlug($__city,$citys) }} {{ $q_tags[0]->getName() }}","item":"{{ route('front.search', [$__type, $__city, @$q_tags[0]->getSlug()]) }}"}
	<?php
	}
	?>

    ]}
</script>
@endsection