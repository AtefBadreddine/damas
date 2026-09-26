<?php
$flavors = $project->flavors();
$search_page = @$search_page ? true : false;
$current_lang = LaravelLocalization::getCurrentLocale();








    $flavor = $flavors->orderBy("price", "ASC")->first();

	if(empty($flavor)){
	$flavors = $project->flavors();
    $flavor = $flavors->orderBy("price", "ASC")->first();
	}


$project_min_price = Helper::decimal_format(@$flavor->price,$project->is_price_usd);
?>
<div class="alike-item" id="<?= $project->id ?>">
    <span class="try"><?= $project->name_en; ?></span>
    <div class="content-shear">
        <a href="<?= $project->frontUrl(); ?>"><i class="fa fa-heart-o pull-right"></i></a>
        <a href="<?= $project->frontUrl(); ?>"><i class="flaticon-share share pull-right"></i></a>
    </div>
    @if($project->card_photo_id)
    <a href="<?= $project->frontUrl(); ?>" <?= $search_page == true ? 'target="_blank"' : ''; ?>>
        <amp-img src="<?= Helper::get_thumbnail(@$project->cardphoto, 360, 280); ?>" width="360" height="280" layout="responsive"></amp-img>
    </a>
    @endif
    <aside>
	<?php list($sclass,$slab) = $project->getStatus(); ?>
	@if($sclass!='resale')
        <span class="price"><?=$current_lang=='en'?'<p>Start from</p>':''?> $ <?= $project_min_price; ?> <?=$current_lang=='ar'?'<p>تبدأ من</p>':''?></span>
	@endif
        <p><?= $project->getIntroCard(); ?></p>
        <ul>
            <li><span class="flaticon-house-key"></span> <small><?= date("Y/m", strtotime($project->delivered_date)); ?></small></li>
            <li class="text-center"><amp-img src="<?= asset("img/full-size.png"); ?>" width="19" height="19"></amp-img><br> <?= @$flavors->max('area') . " - " . @$flavors->min('area'); ?> <?= trans("front.m"); ?><sup>2</sup> </li>
            <li><span class="flaticon-payment-method"></span> <small><?= trans("front.$project->payment_method"); ?></small></li>
        </ul>    
    </aside>
</div>