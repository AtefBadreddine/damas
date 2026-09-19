@extends('admin.layouts.form', ["app_title" => "Features", "app_desc" => "Features Information"])
@section('main_form')

<fieldset>
    <legend>Features</legend>
    <div class="form-group col-md-3">
        <label>Features Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Features Name English<span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Features Name French<span class="red">(*)</span></label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Features Name Persian<span class="red">(*)</span></label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Features Name Russian<span class="red">(*)</span></label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
        </div>
    </div>
    <div class="form-group col-md-5">
        <label>SVG code <span class="red">(*)</span></label>
        <div class="">
            <?= Form::text("svg", $row->svg, ["class" => "form-control"]); ?>
        </div>
    </div>
	<div class="form-group col-md-12">
        <label><input type="checkbox" name="hide_search_page" <?= $row->hide_search_page == 1 ? 'checked' : ''; ?>> Hide from the list of features in the search page</label>
    </div>
</fieldset>

<fieldset>
    <legend>About  Features</legend>
	<div class="form-group col-md-6">
        <label>Content</label>
        <select name="post_id" class="form-control select2me" >
			<option value="0"></option>
			<?php
			$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
			?>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
    </div>
	<?php /*
    <div class="form-group col-md-12 hiddenz">
        <label>Title Arabic</label>
        <?= Form::text("about_title_ar", $row->about_title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About Arabic</label>
        <?= Form::textarea("about_ar", $row->about_ar, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>Title English</label>
        <?= Form::text("about_title_en", $row->about_title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About English</label>
        <?= Form::textarea("about_en", $row->about_en, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>Title French</label>
        <?= Form::text("about_title_fr", $row->about_title_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About French</label>
        <?= Form::textarea("about_fr", $row->about_fr, ["class" => "form-control tinyeditor"]); ?>
    </div>

	<div class="form-group col-md-12 hiddenz">
        <label>Title Persian</label>
        <?= Form::text("about_title_fa", $row->about_title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About Persian</label>
        <?= Form::textarea("about_fa", $row->about_fa, ["class" => "form-control tinyeditor"]); ?>
    </div>
	*/ ?>
</fieldset>

@include("admin.layouts.seo")

@include("admin.layouts.tinymce_js")

@endsection