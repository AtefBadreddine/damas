@extends('admin.layouts.form', ["app_title" => "Lead ", "app_desc" => "Backup"])
@section('main_form')

<fieldset>
    <legend>Convert Lead to CRM: <?= $row->id; ?></legend>
    <div class="form-group col-md-3">
        <label>Name</label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <!--<div class="form-group col-md-4">
        <label>Fame</label>
        <?= Form::text("fame", $row->fame, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Email</label>
        <?= Form::text("email", $row->email, ["class" => "form-control ltr"]); ?>
    </div>-->
    <div class="form-group col-md-3">
        <label>Mobile</label>
        <?= Form::text("mobile", $row->mobile, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Message</label>
        <?= Form::textarea("message", $row->message, ["class" => "form-control", "rows" => 3]); ?>
    </div>
    <!--<div class="form-group col-md-6">
        <label>المصدر</label>
        <?= Form::text("src", ($row->src ? $row->src : "Facebook"), ["class" => "form-control", "required" => true]); ?>
    </div>-->
</fieldset>

@endsection