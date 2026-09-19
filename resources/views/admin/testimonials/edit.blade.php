@extends('admin.layouts.form', ["app_title" => "Testimonials", "app_desc" => "Testimonial"])
@section('main_form')

<fieldset>
    <legend>Agent Information</legend>
    <div class="form-group col-md-4">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name English</label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name French</label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name Persian</label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name Russian</label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control ltr"]); ?>
    </div>


    <div class="form-group col-md-4" style="clear:both">
        <label>Testimonial Arabic<span class="red">(*)</span></label>
        <?= Form::textarea("content_ar", $row->content_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Testimonial English</label>
        <?= Form::textarea("content_en", $row->content_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Testimonial French</label>
        <?= Form::textarea("content_fr", $row->content_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Testimonial Persian</label>
        <?= Form::textarea("content_fa", $row->content_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Testimonial Russian</label>
        <?= Form::textarea("content_ru", $row->content_ru, ["class" => "form-control"]); ?>
    </div>


    <div class="form-group col-md-4" style="clear:both">
        <label>Video Arabic<span class="red">(*)</span></label>
        <?= Form::text("video_ar", $row->video_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Video English</label>
        <?= Form::text("video_en", $row->video_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Video French</label>
        <?= Form::text("video_fr", $row->video_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Video Persian</label>
        <?= Form::text("video_fa", $row->video_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Video Russian</label>
        <?= Form::text("video_ru", $row->video_ru, ["class" => "form-control"]); ?>
    </div>

    <div class="form-group col-md-6" style="clear:both">
        <label>Image</label>
        @include('admin.layouts.media_input', [
            "name" => "media_id",
            "ids"  => [$row->media_id]
        ])
    <?php $photo = $row->photo; ?>
    @if($photo)
        <div class="form-group col-md-12">
            <img src="<?= Helper::media_url($photo); ?>" style="max-width:100%" alt="">
        </div>
    @endif
		
		
    </div>

    <div class="form-group col-md-6">
        <label>Background</label>
        @include('admin.layouts.media_input', [
            "name" => "media_back_id",
            "ids"  => [$row->media_back_id]
        ])
    <?php $photo = $row->background; ?>
    @if($photo)
        <div class="form-group col-md-12">
            <img src="<?= Helper::media_url($photo); ?>" style="max-width:100%" alt="">
        </div>
    @endif
    </div>
    
</fieldset>

@include('admin.layouts.media_input_js')

@endsection