<?php
$arr_prices = [
"50000-100000"=>Helper::usd_to_format("50K $")."-".Helper::usd_to_format("100K $"),"100000-150000"=>Helper::usd_to_format("100K $")."-".Helper::usd_to_format("150K $"),"150000-250000"=>Helper::usd_to_format("150K $")."-".Helper::usd_to_format("250K $"),"250000-400000"=>Helper::usd_to_format("250K $")."-".Helper::usd_to_format("400K $"),"400000-600000"=>Helper::usd_to_format("400K $")."-".Helper::usd_to_format("600K $"),"600000-1000000"=>Helper::usd_to_format("600K $")."-".Helper::usd_to_format("1M $"),"1000000-2000000"=>Helper::usd_to_format("1M $")."-".Helper::usd_to_format("2M $"),"2000000-+"=>'+'.Helper::usd_to_format("2M $")
];
?>
<div class="blk_searh <?= isset($mob)?'':'desktop-screen'?>">
<div class="discover-mobile">
	<div class="title"><h3><?= $infos->form_title; ?></h3>
	</div>
	<div class="search-box">
		<?= Form::open(["id" => "form-search"]); ?>
		
		<div class="estate">
			<select name="project_type">
				<option value=""><?= trans("front.all real estate"); ?></option>
				@foreach(Helper::query('ProjectType', 'all') as $typ)
					<option value="<?= $typ->slug; ?>"><?= $typ->getName(); ?></option>
				@endforeach
			</select>
		</div>
		<div class="budget">
			<select name="price">
				<option value="" selected><?= trans("front.price"); ?></option>
			<?php
				foreach($arr_prices as $kprice => $vprice): ?>
				<option value="<?= $kprice; ?>" <?= @$inputs["price"] == $kprice ? 'selected' : ''; ?>><?= $vprice; ?></option>
			<?php endforeach; ?>
			</select>
		</div>
		<div class="extra">
			<select name="project_category">
				<option value=""><?= trans("front.special advantages"); ?></option>
				<?php $proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get(); ?>
				@foreach($proj_cats as $cat)
					<option value="<?= $cat->slug; ?>"><?= $cat->getName(); ?></option>
				@endforeach
			</select>
		</div>
		<div class="search">
			<button class="btnFilter">
			<span><?= trans("front.startbtn"); ?></span> 
			</button>
		</div>
		<?= Form::close(); ?>
	</div>
</div>
</div>
<!-- End blk_searh -->