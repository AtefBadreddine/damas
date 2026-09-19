@extends('admin.layouts.form', ["app_title" => "Sources Coding"])
@section('main_form')

<fieldset>
    <legend>Source</legend>
    <div class="form-group col-md-6">
        <label>Src <span class="red">(*)</span></label>
        <?= Form::text("src", $row->src, ["class" => "form-control", "required" => true]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Code <span class="red">(*)</span></label>
        <?= Form::text("code", $row->code, ["class" => "form-control", "required" => true]); ?>
    </div>
</fieldset>

@endsection