@extends('admin.layouts.form', ["app_title" => "Folders", "app_desc" => "Folder Information"])
@section('main_form')

<fieldset>
    <legend></legend>
	<div class="form-group col-md-6">
        <label>Folder Name</label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
</fieldset>

@endsection
