@extends('admin.layouts.form', ["app_title" => " رسائل الواتس اب", "app_desc" => "معلومات رسائل الواتس اب"])
@section('main_form')

<fieldset>
    <legend>معلومات رسالة الواتساب - رقم الطلب: <?= $row->id; ?></legend>
    <div class="form-group col-md-4">
        <label>الإسم</label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>الشهرة</label>
        <?= Form::text("fame", $row->fame, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>البريد الإلكتروني</label>
        <?= Form::text("email", $row->email, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>رقم الجوال</label>
        <?= Form::text("mobile", $row->mobile, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>الرسالة</label>
        <?= Form::textarea("message", $row->message, ["class" => "form-control", "rows" => 3]); ?>
    </div>
    <!--<div class="form-group col-md-6">
        <label>المصدر</label>
        <?= Form::text("src", ($row->src ? $row->src : "Facebook"), ["class" => "form-control", "required" => true]); ?>
    </div>-->
</fieldset>

@endsection