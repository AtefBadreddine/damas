@extends('admin.layouts.form', ["app_title" => "Video Category", "app_desc" => "Section Information"])
@section('main_form')

<fieldset>
<!--    <legend>Video Section</legend>-->

    <div class="form-group col-md-4">
        <label>Title AR<span class="red">(*)</span></label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    
    <div class="form-group col-md-4">
        <label>Title EN<span class="red">(*)</span></label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control"]); ?>
    </div>
    
    <div class="form-group col-md-4">
        <label>Title FR<span class="red">(*)</span></label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control"]); ?>
    </div>
    
    <div class="form-group col-md-4">
        <label>Title FA<span class="red">(*)</span></label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title Ru<span class="red">(*)</span></label>
        <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control"]); ?>
    </div>

<!--    <div class="form-group  col-md-4">
        <label>Lang<span class="red">(*)</span></label>
        <?php // Form::select("lang", ["ar" => "Arabic", "en" => "English", "fr" => "Frensh", "fa" => "Persian"], $row->lang, ["class" => "form-control select2me"]); ?>
    </div>-->

    <div class="form-group  col-md-4">
        <label>Placement</label>
        <?= Form::text("placement", ($row->placement), ["class" => "form-control"]); ?>
    </div>
	<?php
		/*
		$arr_pjcts = $row->videos()->lists('video_id')->toArray();
		//$projects = Helper::query("Project", "where", ["field" => "featured", "value" => 1])->get();
		$videos = Helper::query("Video", "all");
	?>
	<div class="form-group col-md-9">
		<label>Videos</label>
		<select name="videos[]" class="form-control select2me" multiple>
			<option value=""></option>
			@foreach($videos as $prj)
				<option value="<?= $prj->id; ?>" <?= in_array($prj->id, $arr_pjcts) ? 'selected' : ''; ?>><?= $prj->title; ?></option>
			@endforeach
		</select>
	</div>*/ ?>

</fieldset>
@endsection