@extends('admin.layouts.form', ["app_title" => "الإعدادات", "app_desc" => "إعدادات عامة"])
@section('main_form')

<?php $direction = $row->lang == 'en' ? 'ltr' : 'rtl'; ?>
<fieldset>
    <legend>إعدادات عامة</legend>
    <div class="form-group col-md-4">
        <label>اسم الإعدادات<span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>رقم الهاتف 1 </label>
        <?= Form::text("tel_1", $row->tel_1, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>رقم الهاتف 2 </label>
        <?= Form::text("tel_2", $row->tel_2, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>الإيميل <span class="red">(*)</span></label>
        <?= Form::email("email", $row->email, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-8">
        <label>العنوان <span class="red">(*)</span></label>
        <?= Form::text("address", $row->address, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>فايسبوك - Facebook</label>
        <?= Form::text("facebook", $row->facebook, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>تويتر - Twitter</label>
        <?= Form::text("twitter", $row->twitter, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4" style="display:none">
        <label>جوجل بلس - GooglePlus</label>
        <?= Form::text("gplus", $row->gplus, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>لينكدين - Linkedin</label>
        <?= Form::text("linkedin", $row->linkedin, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>انستغرام - Instagram</label>
        <?= Form::text("instagram", $row->instagram, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>يوتيوب - Youtube</label>
        <?= Form::text("youtube", $row->youtube, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>ايميلات أخرى</label>
        <?= Form::textarea("emails", $row->emails, ["class" => "form-control ltr", "rows" => 4]); ?>
    </div>
</fieldset>

<fieldset>
    <legend>فقرة الصفحة الرئيسية</legend>
    <div class="form-group col-md-4">
        <label>العنوان</label>
        <?= Form::text("parag_index_title", $row->parag_index_title, ["class" => "form-control " . ($row->id==2?'ltr':'' )]); ?>
    </div>
    <div class="form-group col-md-8">
        <label>المحتوى</label>
        <?= Form::textarea("parag_index_content", $row->parag_index_content, ["class" => "form-control tinyeditor"]); ?>
    </div>
</fieldset>

<fieldset>
    <legend>إعدادات أخرى</legend>
    <div class="form-group col-md-12">
        <label>نص رسالة الواتساب التلقائية المرسلة للإدارة</label>
        <?= Form::text("whatsapp_share", $row->whatsapp_share, ["class" => "form-control $direction"]); ?>
    </div>
	<div class="form-group col-md-8">
        <label>صورة المشاركة</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"index_og_pic",
            "ids"   =>	[$row->index_og_pic]
        ])
    </div>
    <div class="form-group col-md-12">
        <label>عنوان فورم الرئيسية</label>
        <?= Form::text("form_title", $row->form_title, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>نص الرسالة المرسلة للعميل </label>
        <p class="text-danger">
            <b>سيتم تعويض القيم بمعلومات العميل:</b>
            <br>{name}: الاسم
            <br>{email}: الايميل
            <br>{mobile}: رقم الهاتف
            <br>{message}: الرسالة
            <br>{communication_time}: ساعات التواصل
            <br>{budget}: الميزانية
        </p>
        <div class="row">
            <div class="col-md-6">
                
                <div class="form-group">
                    <label> <input type="checkbox" name="user_email_send" <?= $row->user_email_send == 1 ? "checked" : ""; ?>> إلغاء إرسال الرسالة</label>
                </div>
                
                <?= Form::text("user_email_title", $row->user_email_title, ["class" => "form-control $direction", "placeholder" => "العنوان"]); ?>
                <?= Form::textarea("user_email_text", $row->user_email_text, ["class" => "form-control $direction", "placeholder" => "نص الايميل"]); ?>
            </div>
            @if($row->user_email_text)
            <div class="col-md-6 <?= $direction; ?>">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], ["الاسم", "example@email.com", "+90 123456789", "الرسالة", "AM", "20k"], nl2br($row->user_email_title)); ?></div>
                    <div class="panel-body">
                        <?= str_replace(["{name}", "{email}", "{mobile}", "{message}", "{communication_time}", "{budget}"], ["الاسم", "example@email.com", "+90 123456789", "الرسالة", "AM", "100K$"], nl2br($row->user_email_text)); ?>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>الموقع والإحداثيات</legend>
    <div class="form-group col-md-12">
        @include('admin.layouts.location_map')
    </div>
</fieldset>

<fieldset>
    <legend>إعدادات الميتاتاك</legend>
    <div class="form-group col-md-12">
        <label>العنوان</label>
        <?= Form::text("seo_title", $row->seo_title, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>الوصف</label>
        <?= Form::text("seo_description", $row->seo_description, ["class" => "form-control $direction"]); ?>
    </div>
    <div class="form-group col-md-12" style="display:none">
        <label>الكلمات المفتاحية</label>
        <?= Form::text("seo_keywords", $row->seo_keywords, ["class" => "form-control $direction"]); ?>
    </div>
</fieldset>
@include("admin.layouts.tinymce_js")
<!-- media js -->
@include('admin.layouts.media_input_js')

@endsection