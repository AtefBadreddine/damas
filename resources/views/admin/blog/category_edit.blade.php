@extends('admin.layouts.form', ["app_title" => " Categories"])
@section('main_form')

<fieldset>
    <legend>Category Information</legend>
    <div class="form-group col-md-4">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name English</label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name French</label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name Persian</label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name Russian</label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
    </div>
    <div class="col-md-3" style="clear: both;">
        <div class="form-group">
            <label>Country</label>
            <select name="country_id" class="form-control select2me">
                <?php foreach ($countries as $country): ?>
                <option value="<?= $country->id ?>" <?= ((int)$row->country_id === (int)$country->id || $row->country == $country->code) ? 'selected' : '' ?>><?= $country->title_en ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group col-md-9">
        <label>Slug<span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon"><?= url('/' . $type . '/category')."/" ?><?= $row->country=='turkey'?'':$row->country.'/' ?></span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm"]); ?>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label>Icon<span class="red">(svg)</span></label>
        <div class=" col-md-12">
            <?= Form::text("icon", $row->icon, ["class" => "form-control input-sm"]); ?>
        </div>
    </div>
	<input type="hidden" name="type" value="<?= $type ?>" >
</fieldset>

@include("admin.layouts.seo")

@endsection
