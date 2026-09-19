@extends('admin.layouts.form', ["app_title" => "Sitemap", "app_desc" => ""])
@section('main_form')

<?php $direction = $row->lang == 'en' ? 'ltr' : 'rtl'; ?>
<fieldset>
    <legend><?= $row->title ?></legend>
    <div class="form-group col-md-4">
        <label>Title<span class="red">(*)</span></label>
        <?= Form::text("title", $row->title, ["class" => "form-control $direction"]); ?>
    </div>
        <?= Form::hidden("lang", $row->lang); ?>
</fieldset>

<fieldset>
    <legend>Metatac Settings</legend>
    <div class="form-group col-md-12">
        <label>Title</label>
        <?= Form::text("seo_title", $row->seo_title, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Description</label>
        <?= Form::text("seo_description", $row->seo_description, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-12 hidden">
        <label>الكلمات المفتاحية</label>
        <?= Form::text("seo_keywords", ''/*$row->seo_keywords*/, ["class" => "form-control $direction"]); ?>
    </div>
</fieldset>

@endsection