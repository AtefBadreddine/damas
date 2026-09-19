@extends('admin.layouts.form', ["app_title" => @$app_title])
@section('main_form')

<fieldset>
    <legend>Page information</legend>
    <div class="form-group col-md-4">
        <label>Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
	
	<div class="form-group col-md-4">
        <label>Title (Ar)</label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title (En)</label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title (Fr)</label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
    </div>
	<div class="form-group col-md-4">
        <label>Title (Fa)</label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title (Ru)</label>
        <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr"]); ?>
    </div>
	
    <div class="form-group col-md-6">
        <label>Picture (Ar)</label>
        @include('admin.layouts.media_input', [
            "name"   =>    "media_id",
            "ids"    =>    [$row->media_id]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>Picture (En)</label>
        @include('admin.layouts.media_input', [
            "name"   =>    "media_id_en",
            "ids"    =>    [$row->media_id_en]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>Picture (Fr)</label>
        @include('admin.layouts.media_input', [
            "name"   =>    "media_id_fr",
            "ids"    =>    [$row->media_id_fr]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>Picture (Fa)</label>
        @include('admin.layouts.media_input', [
            "name"   =>    "media_id_fa",
            "ids"    =>    [$row->media_id_fa]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>Picture (Ru)</label>
        @include('admin.layouts.media_input', [
            "name"   =>    "media_id_ru",
            "ids"    =>    [$row->media_id_ru]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>Link</label>
        <span class="form-control ltr" readonly><?= url("$row->slug_link"); ?></span>
    </div>
	
</fieldset>
	
<fieldset>
    <div class="form-group col-md-12">
        <label>Content (AR)</label>
        @include("admin.layouts.full_editor", ["name" => "content_ar", "lang_editor" => "ar"])
    </div>
</fieldset>

<fieldset>
    <legend>Content (EN)</legend>
    <div class="form-group col-md-12">
        @include("admin.layouts.full_editor", ["name" => "content_en", "lang_editor" => "en"])
    </div>
</fieldset>
<fieldset>
    <legend>Content (FR)</legend>
    <div class="form-group col-md-12">
        @include("admin.layouts.full_editor", ["name" => "content_fr", "lang_editor" => "fr"])
    </div>
</fieldset>

<fieldset>
    <legend>Content (FA)</legend>
    <div class="form-group col-md-12">
        @include("admin.layouts.full_editor", ["name" => "content_fa", "lang_editor" => "fa"])
    </div>
</fieldset>

<fieldset>
    <legend>Content (RU)</legend>
    <div class="form-group col-md-12">
        @include("admin.layouts.full_editor", ["name" => "content_ru", "lang_editor" => "en"])
    </div>
</fieldset>
	
	

<?php /* ?>
<fieldset style="display:none">
    <legend>بالعربي</legend>

    <div class="form-group col-md-12">
        <label>المحتوى</label>
        @include("admin.layouts.full_editor", ["name" => "content_ar"])
    </div>
</fieldset>

<fieldset style="display:none">
    <legend>بالإنجليزي</legend>
    <div class="form-group col-md-12">
        <label>المحتوى</label>
        @include("admin.layouts.full_editor", ["name" => "content_en", "lang_editor" => "en"])
    </div>
</fieldset>

<fieldset>
    <legend>Nationality decisions</legend>
    <div class="form-group col-md-6">
        <label>Photo of the first resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision1_media",
            "ids"    =>    [$row->nationality_decision1_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision1_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision1_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label>Photo of the second resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision2_media",
            "ids"    =>    [$row->nationality_decision2_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision2_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision2_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label>Photo of the third resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision3_media",
            "ids"    =>    [$row->nationality_decision3_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision3_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision3_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>
	
    <div class="form-group col-md-6">
        <label>Photo of the fourth resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision4_media",
            "ids"    =>    [$row->nationality_decision4_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision4_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision4_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>



</fieldset>

<fieldset>
    <legend>Details steps to Applying for turkish citizenship (AR)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3", "lang_editor" => "en"])
    </div>
</fieldset>

<fieldset>
    <legend>Details steps to Applying for turkish citizenship (EN)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1_en", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2_en", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3_en", "lang_editor" => "en"])
    </div>
</fieldset>
<fieldset>
    <legend>Details steps to Applying for turkish citizenship (FR)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1_fr", "lang_editor" => "fr"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2_fr", "lang_editor" => "fr"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3_fr", "lang_editor" => "fr"])
    </div>
</fieldset>

<fieldset>
    <legend>Details steps to Applying for turkish citizenship (FA)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1_fa", "lang_editor" => "fa"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2_fa", "lang_editor" => "fa"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3_fa", "lang_editor" => "fa"])
    </div>
</fieldset>
<?php */ ?>

@include("admin.layouts.seo")

@include("admin.layouts.media_input_js")
@include("admin.layouts.tinymce_js")

@endsection