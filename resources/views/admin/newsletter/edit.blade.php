@extends('admin.layouts.form', ["app_title" => "Newsletter ", "app_desc" => "Update email"])
@section('main_form')

<fieldset>
    <legend>Email</legend>
    <div class="form-group col-md-6">

		<div>
        <?= Form::text("email", $row->email, ["class" => "form-control ltr"]); ?>
		</div>
    </div>

</fieldset>

@endsection