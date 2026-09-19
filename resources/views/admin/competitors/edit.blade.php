@extends('admin.layouts.form', ["app_title" => "Competitors", "app_desc" => ""])
@section('main_form')





<div class="panel-body">



	<div class="form-group col-md-12 ">
		<label>Name</label>
		<?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
	</div>



</div>

<!--<fieldset>
    <legend>Job Information</legend>



</fieldset>

<fieldset>





</fieldset>-->


@endsection