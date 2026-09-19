@extends('admin.layouts.form', ["app_title" => "WhatsApp", "app_desc" => "WhatsApp Information"])
@section('main_form')

<fieldset>
    <legend>WhatsApp Information - Order Number: <?= $row->id; ?></legend>
    <div class="form-group col-md-4">
        <label>Name</label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Fame</label>
        <?= Form::text("fame", $row->fame, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Email</label>
        <?= Form::text("email", $row->email, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Mobile</label>
        <?= Form::text("mobile", $row->mobile, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Message</label>
        <?= Form::textarea("message", $row->message, ["class" => "form-control", "rows" => 3]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Country</label>
        <select name="crm" class="form-control select2me" >
			<option value="" <?= ($row->crm=='turkey' or $row->crm=='')?'selected':'' ?>>Turkey</option>
			<option value="oman" <?= $row->crm=='oman'?'selected':'' ?>>Oman</option>
		</select>
    </div>
    
    <!--<div class="form-group col-md-6">
        <label>المصدر</label>
        <?= Form::text("src", ($row->src ? $row->src : "Facebook"), ["class" => "form-control", "required" => true]); ?>
    </div>-->
</fieldset>

@endsection