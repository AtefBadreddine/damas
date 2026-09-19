@foreach($projects as $project)
	<div class="item col-sm-6">
		@include("front.partials.project_item", ["class" => "card-small","ajax" => "true"])
	</div>
@endforeach


<div class="more-option" onclick="location.href='{{route("front.search", ["property-for-sale", "turkey",$slug])}}'">
	<div class="logo"><img src="<?= asset('img/damas-logo2.png'); ?>"/></div>
	<span><?=trans("front.More options")?></span>
	<i class="flaticon-copy-files"></i>
</div>