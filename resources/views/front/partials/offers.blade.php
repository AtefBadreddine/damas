<?php

$offer_end_dates = [];

$ptypes = \App\Models\ProjectType::where('id','>',0)->get();
$arr_types = [];
foreach($ptypes as $pt)
	$arr_types[$pt->id] = $pt->getName();

if (isset($landing2_resell_offers)){// resale & offer
	$offers = $landing2_resell_offers;
}
$index = 0;
$cnt_offers = count($offers);
foreach ($offers as $offer) {

	$button_title = trans("front.offers Inquire");
	if(isset($landing2_resell_offers)){
		$current_lang = LaravelLocalization::getCurrentLocale();
		if($current_lang=='ar')
			$button_title = $offer->title;
		elseif($current_lang=='en')
			$button_title = $offer->title_en;
		elseif($current_lang=='fr')
			$button_title = $offer->title_fr;
		elseif($current_lang=='fa' or $current_lang=='pe')
			$button_title = $offer->title_pe;
		elseif($current_lang=='ru')
			$button_title = $offer->title_ru;
		
		
		if($offer->type_project=='resale'){
			$offer = \App\Models\Resellproject::where('id',$offer->resale_id)->where('offer_end_date','>=',DB::raw('date(NOW())'))->first();
			if($offer==false){
				//$cnt_offers-=1;
				continue;
				}
			/*dd($offer);
			exit;*/
			$otype = 'resale';
			$city_name = $offer->city->getName(); 
			
			$region_name = '';
			$region = $offer->region;
			if($region)
			$region_name = $region->getName(); 
			$area = $offer->m2;
			
			$tabu = $offer->tabu;
			$citizenship = $offer->citizenship;
			$price = $offer->price;
			$offertype = $offer->type->getName();
			$room = $offer->room;
		}else{
			$offer = \App\Models\Land2offer::where('id',$offer->offer_id)->where('offer_end_date','>=',DB::raw('date(NOW())'))->first();
			if($offer==false){
				//$cnt_offers-=1;
				continue;
				}
			$otype = 'offer';
			$project = $offer->project;
			$city_name = $project->city->getName();
			$region = $project->region;
			$region_name = $region->getName();
			$area = $offer->area;
			
			$tabu = $project->tabu;
			$citizenship = $offer->citizenship;
			$price = $offer->cash;
			$offertype = $offer->offertype->getName();
			$room = $offer->pattern;
		}
	}else{ //only offers
		
		$otype = 'offer';
		$project = $offer->project;
		$city_name = $project->city->getName();
		$region = $project->region;
		$region_name = $region->getName();
		$area = $offer->area;
		
		$tabu = $project->tabu;
		$citizenship = $offer->citizenship;
		$price = $offer->cash;
		$offertype = $offer->offertype->getName();
		$room = $offer->pattern;
	}
	$offer_end_dates[] = $offer->offer_end_date;
    $index++;
    ?>
    <div class="offer_item <?= $index % 2 == 0 ? 'even' : '' ?>">

        <div class="content_sec">

<!--            <div class="off_sec num">
                <span class="number"><?= substr('0' . $index, -2) ?></span>
            </div>-->
            <?php //Helper::get_thumbnail($cardphoto, $iw, $ih)  ?>
            <div class="image">
                <!--<img class="lazy project_photo" data-src="/img/offer-photo-2.jpg" alt="Offer Name"/>-->
                {!! Helper::get_pic(Helper::media_url($offer->cardphoto),'lazy project_photo','','',(isset($cardphoto)?$cardphoto->getTitle():'')) !!}
                <div class="ready_sec">
                    <span><?= trans("front.Offer"); ?> <strong class="indexnum"><?= $index ?> / {{ $cnt_offers }}</strong> {{ $offer->getTitle() }} </span>
                </div>

                <div class="offer_address">
                    <span>{{ $city_name }}</span>
                    <span>{{ $region_name }}</span>
                </div>

                <?php
                $currency = '';
                if ($offer->currency == 'TRY') {
                    $currency = '₺';
                } elseif ($offer->currency == 'EUR') {
                    $currency = '€';
                } elseif ($offer->currency == 'USD') {
                    $currency = '$';
                }
                ?>
                <div class="price_sec">
                    @if($tabu==true)
                    <img width="45" height="67"class="title_deed" src="/img/title-deed-offer.jpg"/>
                    @endif
					<?php if($price!=''){ ?>
                    <img width="200" height="110" class="price_banner" src="/img/offer-price-banner2.svg"/>
                    <?php } ?>
					@if($citizenship==true)
                    <img width="68" height="75" class="pass_offer" src="/img/pass-offer.png"/>
                    @endif
					
					<?php
					if($otype!='resale')
					if($offer->price_list!=''){ ?>
                    <div class="num old_price"> <strong>{{ $currency }}</strong>
                        <span><?= Helper::str_replace_first('.', '</span>.', number_format($offer->price_list, 0, ',', '.')) ?>
                    </div>
					<?php } ?>
					<?php if($price!=''){ ?>
                    <div class="num price"> <strong>{{ $currency }}</strong>
                        <span class="first_num"><?= Helper::str_replace_first('.', '</span>.', number_format($price, 0, ',', '.')) ?>
                        <!--<span class="first_num">3</span>.250.000  -->
                    </div>
					<?php } ?>
                </div>


                <?php if ($offer->youtube_video!='') { ?>
                    <div class="icon_video">
                        <a data-fancybox="<?= $otype.$offer->id ?>-video" href="<?= $offer->youtube_video ?>"> 
                            <div class="circle pulse"></div>
                            <div class="circle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
                                    <polygon points="40,30 65,50 40,70"></polygon>
                                </svg>
                            </div>
                        </a>
                    </div>
                <?php } ?>



            </div>


            <div class="details_sec">

                <table class="offer_details">
                    <thead>
                        <tr>
                            <th>
                                <span class="icon_offer project_type"></span>
                            </th>
                            <th>
                                <span class="icon_offer project_pattern"></span>
                            </th>
                            <th>
                                <span class="icon_offer project_area"></span>
                            </th>
                            <th>
                                <span class="icon_offer project_features"></span>
                            </th>
                            <th>
                                <?php
                                $arr_medias = explode(',', $offer->paln_photos);

                                $medias = \App\Models\Media::whereIn('id', $arr_medias)->get();

                                $i = 0;
                                foreach ($medias as $m) {
                                    $i++;
                                    if ($i == 1) {
                                        ?>
                                        <a class="plan_btn" data-fancybox="<?= $otype.$offer->id ?>-plan" href="{{ Helper::media_url($m) }}"> 
                                            <svg width="40" height="40" version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve"><style type="text/css">.st0{fill:#FCD577;}.st1{fill:#FF6F52;}.st2{fill:#CFDCE5;}.st3{fill:#415E72;}</style><rect x="20.4" y="47" class="st0" width="17.7" height="325.2"/><rect x="139.8" y="473.9" class="st1" width="325.2" height="17.7"/><g><polygon class="st0" points="58.6,55.9 29.3,8.9 0,55.9 "/><polygon class="st0" points="0,363.3 29.3,410.4 58.6,363.3 "/></g><g><polygon class="st1" points="456.1,512 503.1,482.7 456.1,453.4 "/><polygon class="st1" points="148.7,512 101.6,482.7 148.7,453.4 "/></g><polyline class="st2" points="503.1,36.8 503.1,8.9 101.6,8.9 101.6,410.4 503.1,410.4 503.1,66.4 "/><path class="st3" d="M92.8,0v419.2H512V0H92.8z M494.3,236.1v165.4H240.8v-51.8H223v51.8H110.5V17.7H223v200.6v17.7v67.4h17.7v-67.4h166.8v-17.7H240.8V17.7h253.5v200.6h-44.1v17.7H494.3z"/></svg>
                                        </a>
                                    <?php } else { ?>
                                        <a class="d-none" data-fancybox="<?= $otype.$offer->id ?>-plan" href="{{ Helper::media_url($m) }}"></a>
                                        <?php
                                    }
                                }
                                ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        
						<?php /*<tr>
                            <td>{{ $offertype }}</td>
                            <td class="num">{{ $room=='+'?'-':$room }}</td>
                            <td class="num">{{ $area }}<span class="m2">m2</span></td>
                            <td>{{ trans('front.'. $offer->view ) }}</td>
                            <td>
                                <?php
                                $arr_medias = explode(',', $offer->paln_photos);

                                $medias = \App\Models\Media::whereIn('id', $arr_medias)->get();

                                $i = 0;
                                foreach ($medias as $m) {
                                    $i++;
                                    if ($i == 1) {
                                        ?>
                                        <a class="plan_btn" data-fancybox="<?= $otype.$offer->id ?>-plan" href="{{ Helper::media_url($m) }}"> 
                                            <?= trans("front.plan"); ?>
                                        </a>
                                    <?php } else { ?>
                                        <a class="d-none" data-fancybox="<?= $otype.$offer->id ?>-plan" href="{{ Helper::media_url($m) }}">

                                        </a>
                                        <?php
                                    }
                                }
                                ?>

                            </td> 
                        </tr> */ ?>


					<?php
					$patterns = [];
					$pt = new stdClass();
					$pt->type = $offertype;
					$pt->pattern = $room;
					$pt->area = $area;
					$pt->view = $offer->view;
					$patterns[] =  $pt;
					
					if($offer->patterns)
					foreach($offer->patterns as $pat){
						$pat->type = @$arr_types[$pat->type];
						$patterns[] = $pat;
					}
					
					$patterns2 = $patterns;
					
					$arr = [];
					foreach($patterns as $pat){
						$r = $pat->type . $pat->pattern . $pat->area . $pat->view;
						if(in_array($r,$arr))
							continue;
						$icnt = 0;
						foreach($patterns2 as $pat2){
							if($r == $pat2->type . $pat2->pattern . $pat2->area . $pat2->view)
								$icnt++;
						}
						?>
						<tr>
                            <td><?= $pat->type ?><?= $icnt>1?' (x'.$icnt.')':'' ?></td>
                            <td class="num"><?= $pat->pattern=='+'?'-':$pat->pattern ?></td>
                            <td class="num"><?= $pat->area ?><span class="m2">m2</span></td>
                            <td>{{ trans('front.'. $pat->view ) }}</td>
                            <td>
							<?php
                                $arr_medias = explode(',', $offer->paln_photos);

                                $medias = \App\Models\Media::whereIn('id', $arr_medias)->get();

                                $i = 0;
                                foreach ($medias as $m) {
                                    $i++;
                                    if ($i == 1) {
                                        ?>
                                        <a class="plan_btn" data-fancybox="<?= $otype.$offer->id ?>-plan" href="{{ Helper::media_url($m) }}"> 
                                            <?= trans("front.plan"); ?>
                                        </a>
                                    <?php } else { ?>
                                        <a class="d-none" data-fancybox="<?= $otype.$offer->id ?>-plan" href="{{ Helper::media_url($m) }}">

                                        </a>
                                        <?php
                                    }
                                }
                                ?>
							</td> 
                        </tr>
					<?php $arr[] = $r; } ?>

                    </tbody>
                </table>

                <div class="text_sec">
                    <?php
                    $arrdetails = $offer->getDeatails();
                    foreach ($arrdetails as $d) {
                        if (trim($d) != '') {
                            ?>
                            <span>{{ $d }}</span>
                            <?php
                        }
                    }
                    ?>
                </div>

				<?php
				$region_link_ytb = '';
				if($region)
				$region_link_ytb = $region->getLinkvideo();
				if($region_link_ytb!=''){
				?>
                <div class="media_sec">
                    <div class="list_icon">
                        <a class="video_district_btn" <?= 'data-fancybox="'. $otype.$offer->id .'-video-district"' ?> href="<?= $region_link_ytb ?>">
							<!--<span class="icon_offer video"></span>-->
                            <img height="40" width="80" src="/img/district-offer-icon.png"/>
                            <p><?= trans("front.area video"); ?></p>
<!--                            <p><?= trans("front.district video title"); ?> {{ $region->getName() }}</p>-->
                        </a>
                        <?php
						if(trim($offer->youtube_video) != ''){ ?>
                        <a class="video_district_btn" <?= 'data-fancybox="'. $otype.$offer->id .'-video-district"' ?> href="<?= $offer->youtube_video ?>">
							<!--<span class="icon_offer video"></span>-->
                            <img height="40" width="80" src="/img/district-offer-icon.png"/>
                            <p><?= trans("front.project video"); ?></p>
                        </a>
						<?php } ?>
                    </div>
                </div>
				<?php } ?>


				<?php if($offer->offer_end_date!=''){ ?>
                <div class="sec">
                    <div id="timer" class="num">
                        <div id="days<?= $index-1 ?>"></div>
                        <div id="hours<?= $index-1 ?>"></div>
                        <div id="minutes<?= $index-1 ?>"></div>
                        <div id="seconds<?= $index-1 ?>"></div>
                    </div>
                </div>
				<?php } ?>

                <!--<?= $offer->offer_end_date ?>-->
                <a class="enquiry_btn" href="{{ route('front.whatsapp_share') }}?icon=<?= $icon ?>&txt=<?= ($otype=='resale'?'R':'O') . $offer->name . ''.$offer->id ?>">
                    <div class="cta_btn_new">
                        <div class="image_w"><img height="60" width="60" src="/img/whatsapp-icon.svg" alt="damasturk whatsapp"/></div>
                        <span><?= $button_title; ?></span>

                    </div>
<!--                    <div class="cta_btn">
                        <svg class="arrow_btn right" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 33.2 23.3" xml:space="preserve"><style type="text/css">.st0{fill:#167A75;}</style><g><g><g><path class="st0" d="M11.6,0c0.8,0,1.7,0.3,2.3,0.9c1.3,1.3,1.3,3.3,0,4.6l-6.1,6.1l6.1,6.1c1.3,1.3,1.3,3.3,0,4.6c-1.3,1.3-3.3,1.3-4.6,0l-8.4-8.4C0.3,13.3,0,12.5,0,11.6s0.3-1.7,0.9-2.3l8.4-8.4C9.9,0.3,10.8,0,11.6,0z"/></g></g><g><g><path class="st0" d="M29.9,0c0.8,0,1.7,0.3,2.3,0.9c1.3,1.3,1.3,3.3,0,4.6l-6.1,6.1l6.1,6.1c1.3,1.3,1.3,3.3,0,4.6c-1.3,1.3-3.3,1.3-4.6,0l-8.4-8.4c-0.6-0.6-0.9-1.4-0.9-2.3s0.3-1.7,0.9-2.3l8.4-8.4C28.2,0.3,29.1,0,29.9,0z"/></g></g></g></svg>

                        <?= $button_title; ?>

                        <svg class="arrow_btn left" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 33.2 23.3" xml:space="preserve"><style type="text/css">.st0{fill:#167A75;}</style><g><g><g><path class="st0" d="M21.6,23.3c-0.8,0-1.7-0.3-2.3-0.9c-1.3-1.3-1.3-3.3,0-4.6l6.1-6.1l-6.1-6.1C18,4.3,18,2.3,19.3,1c1.3-1.3,3.3-1.3,4.6,0l8.4,8.4c0.6,0.6,0.9,1.4,0.9,2.3c0,0.9-0.3,1.7-0.9,2.3l-8.4,8.4C23.3,23,22.4,23.3,21.6,23.3z"/></g></g><g><g><path class="st0" d="M3.3,23.3c-0.8,0-1.7-0.3-2.3-0.9c-1.3-1.3-1.3-3.3,0-4.6l6.1-6.1L1,5.6C-0.3,4.3-0.3,2.3,1,1c1.3-1.3,3.3-1.3,4.6,0L14,9.4c0.6,0.6,0.9,1.4,0.9,2.3c0,0.9-0.3,1.7-0.9,2.3l-8.4,8.4C5,23,4.1,23.3,3.3,23.3z"/></g></g></g></svg>
                    </div>-->
                </a>
            </div>


        </div>
    </div>
    <!-- End Item -->

<?php } ?>

<?php
if (isset($landing2_resell_offers)){
?>
<script>

	setInterval(function () {
		<?php
		for($i=0;$i<count($offer_end_dates);$i++){
			if($offer_end_dates[$i]!=''){
		?>
        makeTimer(<?= $i ?>,'<?= $offer_end_dates[$i] ?>');
		<?php
			}
		}
		?>
		
    }, 1000);

</script>
<?php } ?>