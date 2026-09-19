@extends('admin.layouts.form', ["app_title" => "Project research", "app_desc" => ""])
@section('main_form')
<style>
.bootstrap-tagsinput{width:100%}
</style>
<?php

function find_keywords_by_class_slug($row,$class='',$slug='',$n1,$n2){
	$keys = '';
	foreach($row as $r){
		if($r->class==$class and $r->slug==$slug)
			$keys = $r->keywords;
	}
	
	if($keys==''){
		$keys = $n1.','.$n2;
	}
	return $keys;
}


?>
<fieldset>
    <legend>General Search </legend>
    <div class="form-group col-md-12">
        <!--<label></label>-->
		<?= Form::text("words[global][all]", find_keywords_by_class_slug($row,'global','all','',''), [ "class" => "form-control", "data-role"=>"tagsinput" ]);?>
    </div>
</fieldset>

<fieldset>
    <legend>Property Type</legend>
    
	@foreach($types as $type)
	<div class="form-group col-md-3">
        <label class="col-md-12">{{ $type->getNameEn() }}</label>
        <?= Form::text("words[type][$type->slug]", find_keywords_by_class_slug($row,'type',$type->slug,$type->getNameAr(),$type->getNameEn()), [ "class" => "form-control", "data-role"=>"tagsinput" ]); ?>
    </div>
	@endforeach
</fieldset>

<fieldset>
    <legend>Special advantages</legend>
    
	@foreach($tags as $tag)
	<div class="form-group col-md-3">
        <label class="col-md-12">{{ $tag->getNameEn() }}</label>
        <?= Form::text("words[tag][$tag->slug]", find_keywords_by_class_slug($row,'tag',$tag->slug,$tag->getNameAr(),$tag->getNameEn()), [ "class" => "form-control", "data-role"=>"tagsinput" ]); ?>
    </div>
	@endforeach
</fieldset>



<fieldset>
    <legend>City</legend>
    
	@foreach($citys as $city)
	<div class="form-group col-md-3">
        <label class="col-md-12">{{ $city->getNameEn() }}</label>
        <?= Form::text("words[city][$city->slug]", find_keywords_by_class_slug($row,'city',$city->slug,$city->getNameAr(),$city->getNameEn()), [ "class" => "form-control", "data-role"=>"tagsinput" ]); ?>
    </div>
	@endforeach
</fieldset>

<fieldset>
    <legend>Region</legend>
    
	@foreach($regions as $region)
	<div class="form-group col-md-3">
        <label class="col-md-12">{{ $region->getNameEn() }}</label>
        <?= Form::text("words[region][$region->slug]", find_keywords_by_class_slug($row,'region',$region->slug,$region->getNameAr(),$region->getNameEn()), [ "class" => "form-control", "data-role"=>"tagsinput" ]); ?>
    </div>
	@endforeach
</fieldset>






<link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
@endsection