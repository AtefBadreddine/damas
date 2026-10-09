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
    <div class="form-group col-md-12">
        <label>Slug<span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon"><?= url('/category') ?>/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm"]); ?>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label>Icon<span class="red">(svg)</span></label>
        <div class=" col-md-12">
            <?= Form::text("icon", $row->icon, ["class" => "form-control input-sm"]); ?>
        </div>
    </div>
</fieldset>

@endsection
