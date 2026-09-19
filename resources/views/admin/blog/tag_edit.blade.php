@extends('admin.layouts.form', ["app_title" => " Tags"])
@section('main_form')

<fieldset>
    <legend>Tag Information</legend>
    <div class="form-group col-md-4">
	<input type="hidden" name="type" value="<?= $type ?>" >
        <label>Name<span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title Arabic<span class="red">(*)</span></label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title English</label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title French</label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title Persian</label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title Russian</label>
        <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Slug<span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon"><?= url('/tags/')."/" ?></span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm"]); ?>
        </div>
    </div>
	<div class="form-group col-md-4">
        <label>Picture</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_id",
            "ids"   =>	[$row->media_id]
        ])
    </div>
	
</fieldset>

@include("admin.layouts.seo",["hide_keywords" => true])

@endsection
