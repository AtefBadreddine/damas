@extends('admin.layouts.form', ["app_title" => "Add IP"])
@section('main_form')

<fieldset>
    <div class="form-group col-md-6">
        <label>IP <span class="red">(*)</span></label>
        <?= Form::text("ip", $row->ip, ["class" => "form-control"]); ?>
    </div>
</fieldset>

@endsection