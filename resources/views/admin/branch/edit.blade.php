@extends('admin.layouts.form', ["app_title" => "Branches", "app_desc" => "Branch Information"])
@section('main_form')

<fieldset>
    <legend>Branch</legend>
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
        <label>Mobile <span class="red">(*)</span></label>
        <?= Form::text("mobile", $row->mobile, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Phone <span class="red">(*)</span></label>
        <?= Form::text("phone", $row->phone, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Email<span class="red">(*)</span></label>
        <?= Form::email("email", $row->email, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6 hidden">
        <label>Other Emails</label>
        <?= Form::textarea("emails", $row->emails, ["class" => "form-control ltr", "rows" => 4]); ?>
    </div>
</fieldset>

<fieldset>
    <legend>Branch Address</legend>
    <div class="form-group col-md-6">
        <label>Arabic</label>
        <?= Form::text("address_ar", $row->address_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>English </label>
        <?= Form::text("address_en", $row->address_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>French </label>
        <?= Form::text("address_fr", $row->address_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Persian </label>
        <?= Form::text("address_fa", $row->address_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Russian </label>
        <?= Form::text("address_ru", $row->address_ru, ["class" => "form-control ltr"]); ?>
    </div>
</fieldset>

<fieldset>
    <legend>Location and Coordinates</legend>
    <div class="form-group col-md-12">
        @include('admin.layouts.location_map')
    </div>
</fieldset>

@endsection
