@extends('admin.layouts.form', ["app_title" => "Links Shortcut", "app_desc" => "Links Shortcut"])
@section('main_form')

<fieldset>
    <legend>Enter the Link</legend>




	<div class="form-group col-md-6">
        <label>Link <span class="red">(*)</span></label>
        <?= Form::url("url", $row->url, ["class" => "form-control","placeholder" => "URL"]); ?>
    </div>
	<div class="form-group col-md-6">
        <label>Description <span class="red"></span></label>
        <?= Form::textarea("description", $row->description, ['cols'=>'50','rows'=>'2',"class" => "form-control","placeholder" => "Description"]); ?>
    </div>
	
	
	
	</fieldset>

@endsection