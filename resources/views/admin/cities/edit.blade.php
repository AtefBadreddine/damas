@extends('admin.layouts.form', ["app_title" => "Cities", "app_desc" => "City Information"])
@section('main_form')

<fieldset>
    <legend>City Information</legend>
	<div class="form-group col-md-3">
        <label>Country</label>
        <select name="country_id" class="form-control select2me" required>
			<option value=""></option>
			<?php foreach ($countries as $country): ?>
			<option value="<?= $country->id ?>" <?= ((int)$row->country_id === (int)$country->id || $row->country == $country->code) ? 'selected' : '' ?>><?= $country->title_en ?></option>
			<?php endforeach; ?>
		</select>
    </div>
    <div class="form-group col-md-3">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name English<span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name French<span class="red">(*)</span></label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name Persian<span class="red">(*)</span></label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name Russian<span class="red">(*)</span></label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
        </div>
    </div>
    <div class="form-group col-md-4">
        <label>Picture</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_index",
            "ids"   =>	[$row->media_index]
        ])
    </div>
    <div class="form-group col-md-4">
        <label>Share Image (Arabic)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_id",
            "ids"   =>	[$row->media_id]
        ])
    </div>
    <div class="form-group col-md-4">
        <label>Share Image(English)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_en_id",
            "ids"   =>	[$row->media_en_id]
        ])
    </div>
    <div class="form-group col-md-4">
        <label>Share Image (French)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_fr_id",
            "ids"   =>	[$row->media_fr_id]
        ])
    </div>
    <div class="form-group col-md-4">
        <label>Share Image (Persian)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_fa_id",
            "ids"   =>	[$row->media_fa_id]
        ])
    </div>
    <div class="form-group col-md-4">
        <label>Share Image (Russian) </label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_ru_id",
            "ids"   =>	[$row->media_ru_id]
        ])
    </div>
</fieldset>

<fieldset>
    <legend>About The City</legend>

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

<fieldset>
    <legend>Location and Coordinates</legend>
    <div class="form-group col-md-12">
        @include('admin.layouts.location_map')
    </div>
</fieldset>

@include('admin.layouts.seo')

@if(isset($row))
<fieldset>
    <legend>Districts Page</legend>
    <div class="form-group col-md-12">
        <div class="row">


			<div class="form-group col-md-4">
				<div class="form-group">
					<label class="enable_district_page"><input type="checkbox" value="1" name="enable_district_page" <?= $row->enable_district_page == 1 ? 'checked' : ''; ?>> Enable districts page </label>
				</div>
			</div>
			
		
			
	<div class="form-group col-md-4">
        <label>H1 Arabic<span class="red">(*)</span></label>
        <?= Form::text("h1_ar", $row->h1_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 English<span class="red">(*)</span></label>
        <?= Form::text("h1_en", $row->h1_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 French<span class="red">(*)</span></label>
        <?= Form::text("h1_fr", $row->h1_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 Persian<span class="red">(*)</span></label>
        <?= Form::text("h1_fa", $row->h1_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 Russian<span class="red">(*)</span></label>
        <?= Form::text("h1_ru", $row->h1_ru, ["class" => "form-control ltr"]); ?>
    </div>

	<div class="col-md-4">
		<div class="form-group">
			<label>Primary Image</label>
			@include('admin.layouts.media_input', [
			"name" => "primary_photo_id",
			"ids"  => [$row->primary_photo_id]
			])
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (Ar)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_ar_id",
			"ids"  => [$row->map_photo_ar_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (En)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_en_id",
			"ids"  => [$row->map_photo_en_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (Fr)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_fr_id",
			"ids"  => [$row->map_photo_fr_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (Pe)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_fa_id",
			"ids"  => [$row->map_photo_fa_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (Ru)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_ru_id",
			"ids"  => [$row->map_photo_ru_id]
			])
		</div>
	</div>
	
		<div class="form-group col-md-6">
        <label>Section 1</label>
        <select name="sec1_post_id" class="form-control select2me" >
			<option value="0"></option>
			<?php
			$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
			?>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->sec1_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
		</div>	
		<div class="form-group col-md-6">
        <label>Section 2</label>
        <select name="sec2_post_id" class="form-control select2me" >
			<option value="0"></option>
			<?php
			$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
			?>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->sec2_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
		</div>	
		<div class="form-group col-md-6">
        <label>Section 3</label>
        <select name="sec3_post_id" class="form-control select2me" >
			<option value="0"></option>
			<?php
			$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
			?>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->sec3_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
		</div>

<?php /*
			<div class="col-md-4">
				<div class="form-group">
					<label>Categories</label>
					<select name="category_id[]" class="form-control select2me" multiple>
						<option value=""></option>
						@foreach($row->regions() as $cat)
						<option value="<?= $cat->id; ?>" <?= in_array($cat->id, $row->categories()->lists('post_category_id')->toArray()) ? 'selected' : ''; ?>><?= $cat->name_en; ?></option>
						@endforeach
					</select>
				</div>
			</div> */ ?>
			
			
			
	
	
	
	
	
		</div>



    </div>
</fieldset>
@endif

@include("admin.layouts.tinymce_js")
@include("admin.layouts.media_input_js")

@endsection