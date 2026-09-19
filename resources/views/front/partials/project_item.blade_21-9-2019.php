<?php
//Helper::get_project_flavors(1);
	$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
$current_lang = LaravelLocalization::getCurrentLocale();
$is_mobile = Helper::is_mobile() || Helper::is_tablet();
$infos = Helper::get_params();
$flavor=array();
if(/*Route::currentRouteName()!='front.search' and*/ session()->get("filter_rooms")!=''){
	list($salon,$room) = explode('_',session()->get("filter_rooms"));
	
	
    $flavors = $project->flavors;
	
	foreach($flavors as $f){
		if($f->room==$room and $f->salon==$salon and $f->observation!='مباع'){
			$flavor = $f;
			break;
		}
	}

	
	if(empty($flavor)){
	$arr_rooms = array('1_0','1_1','1_2','1_3','1_4','1_5','2_3','2_4','2_5','2_6');
	$arr_s_r = array();
	foreach($arr_rooms as $r){
		if($r==session()->get("filter_rooms"))
			break;
		$arr_s_r[] = $r;
	}
	
	$arr_s_r = array_reverse($arr_s_r);
	
		foreach($flavors as $f){
			if($f->observation!='مباع'){
				foreach($arr_s_r as $r_s_r){
					if($f->salon.'_'.$f->room == $r_s_r){
						$flavor = $f;
						break;
					}
				}
			}
		}
	}

}

if(empty($flavor)){
    $flavors = $project->flavors();
    $flavors = $flavors->where('observation','!=','مباع');//عدم عرض سعر الشقق المباعة 
    $flavor = $flavors->orderBy("price", "ASC")->first();

	if(empty($flavor)){
	$flavors = $project->flavors();
    $flavor = $flavors->orderBy("price", "ASC")->first();
	}
	
	}
    $open_blank = @$open_blank ? true : false;
    $cardphoto = @$project->cardphoto;
    //$is_mobile = @$is_mobile;
    $project_min_price = Helper::decimal_format(@$flavor->price,$project->is_price_usd);
?>







		<div class="project-card <?=isset($class)?$class:''?>"  <?=isset($proj_shema)?' property="itemListElement" typeof="ListItem"':''?>>
		<?= isset($proj_shema)?'<span class="hidden" property="position">'.$pos.'</span>':''?>
		<div class="share project-social">
			<i class="flaticon-share cshare"></i>

			<a href="#" class="likeCardItem" data-url="<?= route("front.likeitem"); ?>" 
			data-typ="project" data-code="<?= $project->id; ?>">
			<i class="fa fa-heart-o"></i><!--<i class="fa fa-heart"></i>--></a>

            <span class="pull-right social shareBtnsFloating" data-url="<?= route('front.project', $project->slug); ?>" data-text="<?= $project->getName(); ?>">
                <a href="#" class="btnshare" data-network="facebook"><i class="fa fa-facebook"></i></a>
                <a href="#" class="btnshare" data-network="whatsapp"><i class="fa fa-whatsapp"></i></a>
            </span>

			<div class="d105"  <?=isset($proj_shema)?' property="name"':''?>><?= $project->name_en; ?></div>
			</div>
			<div class="contain" id="container" <?php if($is_mobile){ ?> data-url="<?= route('front.project', $project->slug); ?>"<?php } ?>>
                            <div class="image-project">
<a href="<?= route('front.project', $project->slug); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?> <?=isset($proj_shema)?' property="url"':''?>>

<?php
$iw=360;
$ih=280;
if(!$is_mobile){
if(isset($page) and $page=='index'){
$iw=360;
$ih=196;
}else{
$iw=384;
$ih=171;
}
}else{
if(isset($page) and $page=='index'){
$iw=360;
$ih=282;
}else{
$iw=363;
$ih=258;
}	
}
/*
?>
<img class="" <?= isset($ajax)?'':'src="'.$emptypic.'" data-' ?>src="<?= Helper::get_thumbnail($cardphoto, $iw, $ih); ?>" alt="$cardphoto->getDescription(); ">
<?php */ ?>
{!! Helper::get_pic(Helper::get_thumbnail($cardphoto, $iw, $ih),(isset($ajax) and $ajax==true)?'img-responsive':'lazyimg img-responsive','','',$cardphoto->getTitle(), isset($proj_shema)?' property="image"':'') !!}
</a>
                            </div>
							
							
							
					@if($current_lang=='ar')
                            <div class="title-project">
                                
								<div class="start">
								{{ trans("front.start") }}</div>
								
								
								
								@if($flavor->salon==0 and $flavor->room==0)
								@else
                                <button class="bed">
							<img src="<?= asset("img/bed.svg"); ?>" alt="Damas">
<!--                <i class="flaticon-bed3"></i>-->
							<span><?= $flavor->salon."+".$flavor->room; ?></span>
								
								<ul class="dropdown-menu hidden">
									<?php
									foreach($project->flavors as $f){
										//if($f->observation!='مباع' and $f->salon.'_'.$f->room != $flavor->salon."_".$flavor->room){ ?>
										<li><a data-val="<?=$f->salon.'_'.$f->room?>" href="javascript:;"><?=$f->salon.'+'.$f->room?></a></li>
									<?php } //}  ?>
								</ul>  
								</button>
								@endif
								
								
								<div class="start">
								{{ trans("front.from") }}</div>
                                
								
								@if(strlen($project_min_price)>8)
								<div class="price smlprice">
								{!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
								</div>
								@else
								<div class="price">
								{!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
								</div>
								@endif

								<?php
								//price to show when change beds select
								//Helper::decimal_format(@$flavor->price,$project->is_price_usd)
								foreach($project->flavors as $f){ ?>
									<div class="price smlprice tpp<?=$f->salon.'_'.$f->room?> hidden">
									{!! " <strong>". Helper::curr_format() ."</strong> " . Helper::decimal_format($f->price,$project->is_price_usd) !!}
									</div>
								<?php } ?>
								
							
								
                            </div>
					@else
						<div class="title-project">
                                
								<div class="start">{{ trans("front.start") }}</div>
								
								
								<?php
								//price to show when change beds select
								//Helper::decimal_format(@$flavor->price,$project->is_price_usd)
								/*foreach($project->flavors as $f){ ?>
									<div class="price ppprice tpp<?=$f->salon.'_'.$f->room?> hidden">
									{{ Helper::decimal_format($f->price,$project->is_price_usd)." ".Helper::curr_format() }}
									</div>
								<?php }*/ ?>
								
							
								
								@if($flavor->salon==0 and $flavor->room==0)
								@else
                                <button class="bed"><i class="flaticon-bed3"></i><span><?= $flavor->salon."+".$flavor->room; ?></span>
								<!--<img src="<?= asset("img/bed.svg"); ?>" alt="Damas">-->
<!--                <i class="flaticon-bed3"></i>-->
							<span><?= $flavor->salon."+".$flavor->room; ?></span>
								
								<ul class="dropdown-menu hidden">
									<?php
									foreach($project->flavors as $f){
										//if($f->observation!='مباع' and $f->salon.'_'.$f->room != $flavor->salon."_".$flavor->room){ ?>
										<li><a data-val="<?=$f->salon.'_'.$f->room?>" href="javascript:;"><?=$f->salon.'+'.$f->room?></a></li>
									<?php } //}  ?>
								</ul>  
								</button>
								@endif
								
								
								<div class="start">
								{{ trans("front.from") }}</div>
								
                                @if(strlen($project_min_price)>8)
								<div class="price smlprice">
								{!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
								</div>
								@else
								<div class="price">
								{!! ' <strong>'. Helper::curr_format() .'</strong> '. $project_min_price  !!}
								</div>
								@endif

								<?php
								//price to show when change beds select
								//Helper::decimal_format(@$flavor->price,$project->is_price_usd)
								foreach($project->flavors as $f){ ?>
									<div class="price smlprice tpp<?=$f->salon.'_'.$f->room?> hidden">
									{!! " <strong>". Helper::curr_format() ."</strong> " . Helper::decimal_format($f->price,$project->is_price_usd) !!}
									</div>
								<?php } ?>
								
                            </div>
					@endif
                            <div style="clear:both"></div>
                            <div class="about-project new-style">
                            <?= $project->getIntroCard(); ?>
                            </div>
                            <div style="clear:both"></div>



<?php

if($current_lang != 'en'){
?>
<div class="info-project">
	<div class="size">
		<div>
			<i class="flaticon-size-square"></i>
			<div id="num"><?= @$flavors->max('area')."-".@$flavors->min('area'); ?><?= trans("front.m"); ?></div>
		</div>
	</div>
	<div class="key">
		<div >
			<i class="flaticon-room-key2"></i>
		<?php
		$ret = $project->delivered_date ? $project->delivered_date: trans('front.'.$project->project_etat);
		if($ret=='جاهز' or $ret=='قيد الإنشاء')
			echo '<span class="ffdinn">'.$ret.'</span>';
		else
			echo '<span>'.$ret.'</span>';
		?>	
		</div>

	</div>
	<div class="coin">
		<div>
			<i class="flaticon-coin2"></i>
			<span><?= trans('front.'.$project->payment_method); ?></span>
		</div>
		
	</div>
</div>
<?php }else{
if(isset($class) and $class=="card-small"){ ?>
<div class="info-project">
	<div class="size">
		<div>
			<i class="flaticon-size-square"></i>
			<div id="num"><?= @$flavors->max('area')."-".@$flavors->min('area'); ?> <?= trans("front.m"); ?></div>
		</div>
	</div>
	<div class="key">
		<div>
			<i class="flaticon-room-key2"></i>
		<span><?php
		$ret = $project->delivered_date ? $project->delivered_date: trans('front.'.$project->project_etat);
		if($ret=='جاهز' or $ret=='قيد الإنشاء')
			echo trans('front.'.$ret);
		else
			echo $ret;
		
		?></span>
		</div>
	</div>
	<div class="coin">
		<div>
			<i class="flaticon-coin2"></i>
			<span><?= trans('front.'.$project->payment_method); ?></span>
		</div>
	</div>
</div>
<?php }else{ ?>
<div class="info-project">
	<div class="size">
		<i class="flaticon-size-square"></i>
		<span><?= @$flavors->max('area')."-".@$flavors->min('area'); ?><?= trans("front.m"); ?></span>
	</div>
	<div class="key">
		<i class="flaticon-room-key2"></i>
		<?php
		$ret = $project->delivered_date ? $project->delivered_date: trans('front.'.$project->project_etat);
		if($ret=='جاهز' or $ret=='قيد الإنشاء')
			echo '<span style="font-family:dinnextlight">'.$ret.'</span>';
		else
			echo '<span>'.$ret.'</span>';
		?>
		
	</div>
	<div class="coin">
		<i class="flaticon-coin2"></i>
		<span><?= trans('front.'.$project->payment_method); ?></span>
	</div>
</div>
<?php }} ?>
<?php if(!$is_mobile){ ?>
<div class="details"><a href="<?= route('front.project', $project->slug); ?>" <?= $open_blank == true ? 'target="_blank"' : ''; ?>  class="button"><?=trans('front.details')?></a></div>
<?php } ?>
	</div>
	</div>


<?php /* ?>
<!-- schema -->
<script type="application/ld+json">
{
    "@context": "http://www.schema.org",
    "@type": "Product",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.<?=rand(1,9) ?>",
    "reviewCount": "<?= $project->likes+10 ?>"
  },
    "name": "<?= $project->getName(); ?>",
    "offers" : {
        "@type": "Offer",
		"url": "<?=URL::current();?>",
        "price": "<?= str_replace('.','',$project_min_price); ?>",
        "priceCurrency": "TRY",
    "priceValidUntil": "2029-11-05",
    "itemCondition": "https://schema.org/UsedCondition", 
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "DamasTurk"
    }
    },
    "image": "<?= Helper::media_url($cardphoto); ?>"
	,
  "description": "<?= $project->getIntroCard(); ?>",
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
<?php */ ?>