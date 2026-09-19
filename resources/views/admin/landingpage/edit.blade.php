@extends('admin.layouts.form', ["app_title" => "Landing Pages", "app_desc" => "Landing Page Settings"])
@section('main_form')

<?php $direction = $row->lang == 'en' ? 'ltr' : 'rtl'; ?>
<fieldset>
    <legend>Landing Page Settings</legend>
    <!--<div class="form-group col-md-4">
        <label>Landing Page Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control $direction"]); ?>
    </div>-->
	
	
	
    <div class="form-group col-md-12">
        <label>Lang<span class="red">(*)</span>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <?php //Form::select("lang", Helper::langs(), $row->lang, ["class" => "form-control select2me"]); ?>
    <?php
	if($row->lang)
		$langs = explode(',',$row->lang);
	else
		$langs = ['ar'];
	?>
	<label><input type="checkbox" class="ch_lang" name="lang[]" value="ar" <?= in_array('ar',$langs)?'checked="checked"':'' ?>>Arabic</label>
	&nbsp;&nbsp;&nbsp;
	<label><input type="checkbox" class="ch_lang" name="lang[]" value="fa" <?= in_array('fa',$langs)?'checked="checked"':'' ?>>Persian</label>
	&nbsp;&nbsp;&nbsp;
	<label><input type="checkbox" class="ch_lang" name="lang[]" value="en" <?= in_array('en',$langs)?'checked="checked"':'' ?>>English</label>
	&nbsp;&nbsp;&nbsp;
	<label><input type="checkbox" class="ch_lang" name="lang[]" value="fr" <?= in_array('fr',$langs)?'checked="checked"':'' ?>>French</label>
	&nbsp;&nbsp;&nbsp;
	<label><input type="checkbox" class="ch_lang" name="lang[]" value="ru" <?= in_array('ru',$langs)?'checked="checked"':'' ?>>Russian</label>
	
	</div>
	
	
	
    <div class="form-group col-md-4 hidden">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon"><?= $row->lang!='ar'?'/'.$row->lang:'' ?>/landing/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control ltr"]); ?>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>Background Image</legend>
    <div class="form-group col-md-4 img_ar <?= in_array('ar',$langs)?'':'hidden' ?>">
        <label>Image Ar</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "background_photo",
            "ids"      =>    [$row->background_photo],
        ])
    </div>
    <div class="form-group col-md-4 img_fa <?= in_array('fa',$langs)?'':'hidden' ?>">
        <label>Image Fa</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "background_photo_fa",
            "ids"      =>    [$row->background_photo_fa],
        ])
    </div>
    <div class="form-group col-md-4 img_en <?= in_array('en',$langs)?'':'hidden' ?>">
        <label>Image En</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "background_photo_en",
            "ids"      =>    [$row->background_photo_en],
        ])
    </div>
    <div class="form-group col-md-4  img_fr <?= in_array('fr',$langs)?'':'hidden' ?>">
        <label>Image Fr</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "background_photo_fr",
            "ids"      =>    [$row->background_photo_fr],
        ])
    </div>
    <div class="form-group col-md-4  img_ru <?= in_array('ru',$langs)?'':'hidden' ?>">
        <label>Image Ru</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "background_photo_ru",
            "ids"      =>    [$row->background_photo_ru],
        ])
    </div>
    <div class="form-group col-md-6 hidden">
        <label>Mobile Version Image</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "background_photo_mobile",
            "ids"      =>    [$row->background_photo_mobile],
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
    <div class="form-group col-md-6 hidden">
        <label>District</label>
        <?= Form::text("region_title", $row->region_title, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-12 hidden">
        <label>Information about the District</label>
    </div>
</fieldset>

<?php /* ?>
<fieldset>
    <legend>Damas Turk Real Estate Services</legend>
    <div class="clearfix" style="display:none">
        <div class="form-group col-md-6">
            <label>Image</label>
            @include("admin.layouts.media_input", [
                "name"     =>    "infos_photo",
                "ids"      =>    [$row->infos_photo],
            ])
        </div>
        <div class="form-group col-md-12">
            <label><input type="checkbox" name="hide_whatsapp" <?= $row->hide_whatsapp == 1 ? 'checked' : ''; ?>> Disable the WhatsApp Icon</label>
        </div>
        <div class="form-group col-md-12">
            <label><input type="checkbox" name="hide_popup" <?= $row->hide_popup == 1 ? 'checked' : ''; ?>> Disable the Pop Up </label>
        </div>
    </div>
    
    <div class="clearfix">
        <table class="table table-bordered">
            <thead>
                <th style="display:none">Icon Name (<a href="http://fontawesome.io/icons/" target="_blank">From Here</a>)</th>
                <th style="width:40%;">Title</th>
                <th style="width:50%;">Description</th>
            </thead>
            <tbody id="table_other_content">
                @foreach($row->infos as $info)
                <tr>
                    <td style="display:none">
                        <input type="text" name="infos_icon[]" class="form-control ltr" value="<?= $info->icon; ?>">
                    </td>
                    <td>
                        <input type="text" name="infos_title[]" class="form-control <?= $direction; ?>" value="<?= $info->title; ?>">
                    </td>
                    <td>
                        <textarea name="infos_description[]" rows="4" class="form-control <?= $direction; ?>"><?= $info->description; ?></textarea>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfooter>
                <tr class="hidden" id="tr_other_row">
                    <td>
                        <input type="text" name="infos_icon[]" class="form-control ltr">
                    </td>
                    <td>
                        <input type="text" name="infos_title[]" class="form-control <?= $direction; ?>">
                    </td>
                    <td>
                        <textarea name="infos_description[]" rows="4" class="form-control <?= $direction; ?>"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><a href="javascript:;" id="btndup" class="btn btn-default btn-xs">Add New</a></td>
                </tr>
            </tfooter>
        </table>
    </div>
    
</fieldset>
@include('admin.layouts.seo2')
<?php */ ?>
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
