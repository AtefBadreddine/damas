@extends('admin.layouts.form', ["app_title" => @$app_title])
@section('main_form')

<fieldset>
    <legend>Page Information</legend>
    <div class="form-group col-md-6">
        <label>Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Image</label>
        @include('admin.layouts.media_input', [
            "name"   =>    "media_id",
            "ids"    =>    [$row->media_id]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>Permalink to Page</label>
        <span class="form-control ltr" readonly><?= url("$row->slug_link"); ?></span>
    </div>
</fieldset>

<fieldset class="">
    <legend>Content</legend>
	<div class="col-md-6">
    <div class="form-group">
        <label>Title Ar</label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group">
        <label>Content Ar</label>
        @include("admin.layouts.full_editor", ["name" => "content_ar"])
    </div>
	</div>

    <div class="col-md-6">
    <div class="form-group">
        <label>Title En</label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group">
        <label>Content En</label>
        @include("admin.layouts.full_editor", ["name" => "content_en", "lang_editor" => "en"])
    </div>
    </div>


    
    <div class="col-md-6">
    <div class="form-group">
        <label>Title Fr</label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group">
        <label>Content Fr</label>
        @include("admin.layouts.full_editor", ["name" => "content_fr", "lang_editor" => "en"])
    </div>
    </div>

	<div class="col-md-6">
    <div class="form-group">
        <label>Title Pe</label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group">
        <label>Content Pe</label>
        @include("admin.layouts.full_editor", ["name" => "content_fa", "lang_editor" => "fa"])
    </div>
    </div>
	
    <div class="col-md-6">
    <div class="form-group">
        <label>Title Ru</label>
        <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group">
        <label>Content Ru</label>
        @include("admin.layouts.full_editor", ["name" => "content_ru", "lang_editor" => "en"])
    </div>
    </div>
</fieldset>
<fieldset class="">
    <legend>Why Damas Turk</legend>
    <div class="form-group col-md-6">
        <label>Content (AR)</label>
        @include("admin.layouts.full_editor", ["name" => "about_ar", "lang_editor" => "ar"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (EN)</label>
        @include("admin.layouts.full_editor", ["name" => "about_en", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (FR)</label>
        @include("admin.layouts.full_editor", ["name" => "about_fr", "lang_editor" => "fr"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (FA)</label>
        @include("admin.layouts.full_editor", ["name" => "about_fa", "lang_editor" => "fa"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (RU)</label>
        @include("admin.layouts.full_editor", ["name" => "about_ru", "lang_editor" => "en"])
    </div>
</fieldset>
<fieldset class="">
    <legend>Our niche</legend>
    <div class="form-group col-md-6">
        <label>Content (AR)</label>
        @include("admin.layouts.full_editor", ["name" => "niche_ar", "lang_editor" => "ar"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (EN)</label>
        @include("admin.layouts.full_editor", ["name" => "niche_en", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (FR)</label>
        @include("admin.layouts.full_editor", ["name" => "niche_fr", "lang_editor" => "fr"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (FA)</label>
        @include("admin.layouts.full_editor", ["name" => "niche_fa", "lang_editor" => "fa"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (RU)</label>
        @include("admin.layouts.full_editor", ["name" => "niche_ru", "lang_editor" => "en"])
    </div>
</fieldset>
<fieldset class="">
    <legend>Our vision</legend>
    <div class="form-group col-md-6">
        <label>Content (AR)</label>
        @include("admin.layouts.full_editor", ["name" => "vision_ar", "lang_editor" => "ar"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (EN)</label>
        @include("admin.layouts.full_editor", ["name" => "vision_en", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (FR)</label>
        @include("admin.layouts.full_editor", ["name" => "vision_fr", "lang_editor" => "fr"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (FA)</label>
        @include("admin.layouts.full_editor", ["name" => "vision_fa", "lang_editor" => "fa"])
    </div>
    <div class="form-group col-md-6">
        <label>Content (RU)</label>
        @include("admin.layouts.full_editor", ["name" => "vision_ru", "lang_editor" => "en"])
    </div>
</fieldset>

<fieldset class="">
    <legend>Real Estate Projects</legend>
    <div class="form-group col-md-6">
        <label>Projects </label>
        <select name="project_id[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("Project", "all") as $project)
                <option value="<?= $project->id; ?>" <?= in_array($project->id, $row->projects()->lists('project_id')->toArray()) ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
            @endforeach
        </select>
    </div>
</fieldset>

@include("admin.layouts.seo")

@include("admin.layouts.media_input_js")
@include("admin.layouts.tinymce_js")

@endsection