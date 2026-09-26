@extends('admin.layouts.form', ["app_title" => "Countries", "app_desc" => "Country Information"])
@section('main_form')

<fieldset>
    <legend>Country Information</legend>
    <div class="form-group col-md-3">
        <label>Title Arabic<span class="red">(*)</span></label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title English<span class="red">(*)</span></label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
        </div>
        <span class="help-block">Used in the URL, e.g. turkiye</span>
    </div>
    <div class="form-group col-md-3">
        <label>Code <span class="red">(*)</span></label>
        <?= Form::text("code", $row->code, ["class" => "form-control ltr"]); ?>
        <span class="help-block">Matches the old country string, e.g. turkey</span>
    </div>
</fieldset>

@include('admin.layouts.geo_content_tabs')

@endsection
