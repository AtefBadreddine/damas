@extends('admin.layouts.form', ["app_title" => "Landing Pages", "app_desc" => "Landing Page Settings"])
@section('main_form')

<?php $direction = $row->lang == 'en' ? 'ltr' : 'rtl'; ?>
<fieldset>
    <legend>Landing Page Settings</legend>
    <div class="form-group col-md-4">
        <label>Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control $direction"]); ?>
    </div>
	
	
	
  
	
	
	
    <div class="form-group col-md-4">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/landing2/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control ltr"]); ?>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>Background Image</legend>
    <div class="form-group col-md-4 img_ar>
        <label>Image Ar</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "background_photo",
            "ids"      =>    [$row->background_photo],
        ])
    </div>
</fieldset>

<fieldset>
    <legend>Project Information</legend>
    <div class="form-group col-md-6">
        <label>Project</label>
        <select name="project_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("Project", "published") as $project)
                <option value="<?= $project->id; ?>" <?= $row->project_id == $project->id ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
            @endforeach
        </select>            
    </div>
    <div class="form-group col-md-6 ">
        <label>District</label>
        <?= Form::text("region_title", $row->region_title, ["class" => "form-control $direction"]); ?>
    </div>
</fieldset>

<script>
$(function(){
    $("#btndup").on("click", function(){
        var dv = $("#tr_other_row").clone().removeClass('hidden').removeAttr('id').appendTo("#table_other_content");
    });
	
    $(".ch_lang").on("ifChanged ", function(){
		if($(this).is(':checked')){
			$('.img_'+$(this).val()).removeClass('hidden');
		}else{
			$('.img_'+$(this).val()).addClass('hidden');
		}
        
    });
});
</script>

@include("admin.layouts.media_input_js")
@include("admin.layouts.tinymce_js")

@endsection
