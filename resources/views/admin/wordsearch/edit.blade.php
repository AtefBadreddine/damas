@extends('admin.layouts.form', ["app_title" => "Post research", "app_desc" => ""])
@section('main_form')

<fieldset>
    <legend></legend>
    <div class="form-group col-md-12">
        <label>Words </label>
        <?= Form::text("word", $row->word, [ "class" => "form-control", "data-role"=>"tagsinput" ]); ?>
    </div>
	<?php
	/*
    <div class="form-group col-md-4">
        <label>اللغة</label>
		<?= Form::select("lang", Helper::langs(), $row->lang, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>صفحة البحث</label>
		<?= Form::select("type", ["all" => "الكل", "project" => "المشاريع", "post" => "المنشورات"], $row->type, ["class" => "form-control select2me"]); ?>
    </div>
*/?>
</fieldset>
<link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
@endsection

