@extends('admin.layouts.form', ["app_title" => "Post research", "app_desc" => ""])
@section('main_form')

<fieldset>
    <legend>Post research</legend>
    <div class="form-group col-md-12">
        <label>Keywords: </label>
        <?= Form::text("words", $row->words, [ "class" => "form-control", "data-role"=>"tagsinput" ]); ?>
    </div>
    <?php /*<div class="form-group col-md-4">
        <label>اللغة</label>
		<input type="text" readonly value="<?= $row->lang=='ar'?'عربي':'إنجليزي' ?>" class="form-control ">
    </div> 
    <div class="form-group col-md-4">
        <label>صفحة البحث</label>
		<input type="text" readonly value="<?= $row->type=='project'?'المشاريع':'المنشورات' ?>" class="form-control ">
		<?php // Form::select("type", ["project" => "", "post" => ""], $row->type, []); ?>
    </div>*/ ?>
</fieldset>
<link rel="stylesheet" type="text/css" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
<script src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
@endsection

