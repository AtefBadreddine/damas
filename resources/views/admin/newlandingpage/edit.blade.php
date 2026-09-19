@extends('admin.layouts.form', ["app_title" => "Landing Pages", "app_desc" => "Landing Page"])
@section('main_form')

<?php $direction = $row->lang == 'en' ? 'ltr' : 'rtl'; ?>
<fieldset>
	
    
	
    <div class="form-group col-md-4">
        <label>Title <span class="red">(*)</span></label>
        <div class="">
            <?= Form::text("title", $row->title, ["class" => "form-control ltr"]); ?>
        </div>
    </div>
    <div class="form-group col-md-4">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/landing-</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control ltr"]); ?>
        </div>
    </div>


    <div class="form-group col-md-4 img_ar">
        <label>Image</label>
        @include("admin.layouts.media_input", [
            "name"     =>    "og_photo",
            "ids"      =>    [$row->og_photo],
        ])
    </div>
    
</fieldset>
@include('admin.layouts.seo2')

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
