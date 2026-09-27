@extends('admin.layouts.form', ["app_title" => "Cities", "app_desc" => "City Information"])
@section('main_form')
<?php
$countries = \App\Models\Country::orderBy('name_en', 'asc')->get();
$selectedCountryId = old('country_id', $row->country_id);
$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
?>
<style>
#city-form fieldset{min-width:0;clear:both;margin-bottom:20px}
#city-form fieldset:after{content:"";display:table;clear:both}
#city-form .city-row{display:flex;flex-wrap:wrap;margin-left:-15px;margin-right:-15px}
#city-form .city-row > [class*="col-"]{float:none}
#city-form .city-language-tabs{display:flex;flex-wrap:wrap}
#city-form .city-language-tabs > li{float:none}
#city-form .city-language-tabs > li > a{white-space:nowrap}
@media(max-width:991px){#city-form .city-row > [class*="col-md-"]{width:100%}}
.select-medias {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
}
input[name=slug] {
    max-width: 150px;
}
.form-group.col-md-6:nth-of-type(4) {
    display: flex;
    flex-direction: column;
}
</style>

<div id="city-form">
<fieldset>
    <legend>City Location</legend>
    <div class="form-group col-md-6">
        <label>Country <span class="red">(*)</span></label>
        <select name="country_id" id="city-country-id" class="form-control select2me" required>
            <option value=""></option>
            @foreach($countries as $country)
            <option value="{{ $country->id }}" data-code="{{ $country->code }}" data-slug="{{ $country->slug }}" {{ $selectedCountryId == $country->id ? 'selected' : '' }}>{{ $country->name_en }}</option>
            @endforeach
        </select>
        <input type="hidden" name="country" id="city-country-code" value="{{ old('country', $row->country) }}">
    </div>
</fieldset>

<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading lang-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1default" data-toggle="tab">Arabic Section</a></li>
            <li><a href="#tab2default" data-toggle="tab">English Section</a></li>
            <li><a href="#tab3default" data-toggle="tab">French Section</a></li>
            <li><a href="#tab4default" data-toggle="tab">Farisi Section</a></li>
            <li><a href="#tab5default" data-toggle="tab">Russian Section</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
        <!-- Section Arabic -->
        <div class="tab-pane fade in active" id="tab1default">

<fieldset>
    <div class="form-group col-md-6">
        <label style="color:red;">H1 title <span class="red">(*)</span></label>
        <?= Form::text("h1_ar", $row->h1_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control", "dir" => "rtl"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon" id="city-slug-prefix">https://damas.net/country/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
        </div>
    </div>
	<div class="form-group col-md-6">
        <label>Link Preview Image</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_id",
            "ids"   =>	[$row->media_id]
        ])
        @if($row->media_id)
        <small><a href="<?= route('admin.medias.edit', $row->media_id); ?>" target="_blank">Image Link</a></small>
        @endif
    </div>
	<div class="form-group col-md-6">
        <label style="color:red;">Bring Content From Post</label>
        <select name="post_id" class="form-control select2me" >
			<option value="0"></option>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
    </div>

<div class="form-group col-md-12">
    <label style="color:red;">Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_ar", "editor_value" => $row->about_ar])
</div>
<div class="col-md-12">
                    <fieldset>
                        <legend>Metatag Arabic</legend>
                        <div class="form-group col-md-4">
                                                        <label>Title</label>
                            <?= Form::text("seo_title_ar", $row->seo_title_ar, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                                                        <label>Description</label>
                            <?= Form::textarea("seo_description_ar", $row->seo_description_ar, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4" style="">
                                                        <label>Keywords</label>
                            <?= Form::text("seo_keywords_ar", $row->seo_keywords_ar, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>

</fieldset>

</div>

        <!-- Section English -->
        <div class="tab-pane fade" id="tab2default">

<fieldset>
    <div class="form-group col-md-6">
        <label style="color:red;">H1 title <span class="red">(*)</span></label>
        <?= Form::text("h1_en", $row->h1_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name English<span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control", "dir" => "ltr"]); ?>
    </div>
<div class="form-group col-md-3">
    <label>Share Image(English)</label>
    @include('admin.layouts.media_input', [
        "name"	=>	"media_en_id",
        "ids"   =>	[$row->media_en_id]
    ])
    @if($row->media_en_id)
    <small><a href="<?= route('admin.medias.edit', $row->media_en_id); ?>" target="_blank">Image Link</a></small>
    @endif
</div>
<div class="form-group col-md-12">
    <label style="color:red;">Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_en", "editor_value" => $row->about_en])
</div>
<!-- seo eng -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>English</legend>
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_keywords_en", $row->seo_keywords_en, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>

</fieldset>



        </div>

        <!-- Section French -->
        <div class="tab-pane fade" id="tab3default">

<fieldset>
    <div class="form-group col-md-6">
        <label style="color:red;">H1 title <span class="red">(*)</span></label>
        <?= Form::text("h1_fr", $row->h1_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name French<span class="red">(*)</span></label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control", "dir" => "ltr"]); ?>
    </div>
<div class="form-group col-md-3">
    <label>Share Image(French)</label>
    @include('admin.layouts.media_input', [
        "name"	=>	"media_fr_id",
        "ids"   =>	[$row->media_fr_id]
    ])
    @if($row->media_fr_id)
    <small><a href="<?= route('admin.medias.edit', $row->media_fr_id); ?>" target="_blank">Image Link</a></small>
    @endif
</div>
<div class="form-group col-md-12">
    <label style="color:red;">Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_fr", "editor_value" => $row->about_fr])
</div>
<!-- seo FR -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>FRENCH</legend>
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_keywords_fr", $row->seo_keywords_fr, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>

</fieldset>

</div>
            <!-- Section Farisi -->
            <div class="tab-pane fade" id="tab4default">

<fieldset>
    <div class="form-group col-md-6">
        <label style="color:red;">H1 title <span class="red">(*)</span></label>
        <?= Form::text("h1_fa", $row->h1_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name Persian<span class="red">(*)</span></label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control", "dir" => "rtl"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Share Image(Persian)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_fa_id",
            "ids"   =>	[$row->media_fa_id]
        ])
        @if($row->media_fa_id)
        <small><a href="<?= route('admin.medias.edit', $row->media_fa_id); ?>" target="_blank">Image Link</a></small>
        @endif
    </div>

<div class="form-group col-md-12">
    <label style="color:red;">Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_fa", "editor_value" => $row->about_fa])
</div>
<!-- seo FA -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>PERSIAN</legend>
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_keywords_fa", $row->seo_keywords_fa, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>

</fieldset>
</div>

<!-- Section Russian -->

<div class="tab-pane fade" id="tab5default">

<fieldset>
    <div class="form-group col-md-6">
        <label style="color:red;">H1 title <span class="red">(*)</span></label>
        <?= Form::text("h1_ru", $row->h1_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name Russian<span class="red">(*)</span></label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control", "dir" => "ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Share Image(Russian)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_ru_id",
            "ids"   =>	[$row->media_ru_id]
        ])
        @if($row->media_ru_id)
        <small><a href="<?= route('admin.medias.edit', $row->media_ru_id); ?>" target="_blank">Image Link</a></small>
        @endif
    </div>

<div class="form-group col-md-12">
    <label style="color:red;">Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_ru", "editor_value" => $row->about_ru])
</div>
<!-- seo RU -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>Russian</legend>
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control text-align-left", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control text-align-left", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <?= Form::text("seo_keywords_ru", $row->seo_keywords_ru, ["class" => "form-control text-align-left", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>

</fieldset>
</div>

    </div>
</div>

</div>
</div>

@if(false)

<br><br>
<h2 style="color: #ff0000">Old Edits</h2>
<hr style="border: 2px solid #ff0000">
<br><br>

<fieldset id="city-old-edits" disabled>
<div>
<fieldset>
    <legend>City Information</legend>
<div class="city-row">
    
    <div class="form-group col-md-6">
        <label>Country</label>
        <select name="country" class="form-control select2me" required>
    		<option value=""></option>
    		<option value="turkey" <?=  $row->country=='turkey' ? 'selected':'' ?>>Turkey</option>
    		<option value="oman" <?=  $row->country=='oman' ? 'selected':'' ?>>Oman</option>
    		<option value="emirates" <?=  $row->country=='emirates' ? 'selected':'' ?>>Emirates</option>
    		<option value="syria" <?=  $row->country=='syria' ? 'selected':'' ?>>Syria</option>
    	</select>
    </div>
    <div class="form-group col-md-4">
        <label>Picture</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_index",
            "ids"   =>	[$row->media_index]
        ])
    </div>
</div>
</fieldset>
<fieldset>
    <legend>About The City</legend>
<div class="city-row">
	<div class="form-group col-md-6">
        <label>Content</label>
        <select name="post_id" class="form-control select2me" >
			<option value="0"></option>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
    </div>
</div>
</fieldset>
<fieldset>
    <legend>Location and Coordinates</legend>
<div class="city-row">
    <div class="form-group col-md-12">
        @include('admin.layouts.location_map')
    </div>
</div>
</fieldset>
<div id="city-shared-seo">
@include('admin.layouts.seo')
</div>
@if(isset($row))
<fieldset>
    <legend>Districts Page</legend>
<div class="city-row">
    <div class="form-group col-md-12">
        <div class="city-row">
			<div class="form-group col-md-4">
				<div class="form-group">
					<label class="enable_district_page"><input type="checkbox" value="1" name="enable_district_page" <?= $row->enable_district_page == 1 ? 'checked' : ''; ?>> Enable districts page </label>
				</div>
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
		<div class="form-group col-md-6">
        <label>Section 1</label>
        <select name="sec1_post_id" class="form-control select2me" >
			<option value="0"></option>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->sec1_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
		</div>
		<div class="form-group col-md-6">
        <label>Section 2</label>
        <select name="sec2_post_id" class="form-control select2me" >
			<option value="0"></option>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->sec2_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
		</div>
		<div class="form-group col-md-6">
        <label>Section 3</label>
        <select name="sec3_post_id" class="form-control select2me" >
			<option value="0"></option>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->sec3_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
		</div>
		</div>
    </div>
</div>
</fieldset>
@endif
</div>
</fieldset>
@endif
@include("admin.layouts.tinymce_js")
@include("admin.layouts.media_input_js")
<script>
(function () {
    function syncCountry() {
        var country = document.getElementById('city-country-id');
        var code = document.getElementById('city-country-code');
        var prefix = document.getElementById('city-slug-prefix');
        if (!country || !code || !prefix) return;
        var option = country.options[country.selectedIndex];
        code.value = option ? option.getAttribute('data-code') || '' : '';
        prefix.textContent = 'https://damas.net/' + (option ? option.getAttribute('data-slug') || 'country' : 'country') + '/';
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncCountry);
    } else {
        syncCountry();
    }
    var country = document.getElementById('city-country-id');
    if (country) country.addEventListener('change', syncCountry);
})();
</script>
@endsection
