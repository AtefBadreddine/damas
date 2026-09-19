@extends('admin.layouts.form', ["app_title" => "Salesman", "app_desc" => "Salesman Information"])
@section('main_form')

<fieldset>
    <legend>Salesman Information</legend>
    <div class="form-group col-md-3">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name English</label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name French</label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control ltr"]); ?>
    </div>
	<div class="form-group col-md-3">
        <label>Name Fa<span class="red">(*)</span></label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
    </div>
	<div class="form-group col-md-3">
        <label>Name Ru<span class="red">(*)</span></label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control"]); ?>
    </div>



    <div class="form-group col-md-3">
        <label>Career Ar<span class="red">(*)</span></label>
        <?= Form::text("career", $row->career, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Career En<span class="red">(*)</span></label>
        <?= Form::text("career_en", $row->career_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Career Fr<span class="red">(*)</span></label>
        <?= Form::text("career_fr", $row->career_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Career Fa<span class="red">(*)</span></label>
        <?= Form::text("career_fa", $row->career_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Career Ru<span class="red">(*)</span></label>
        <?= Form::text("career_ru", $row->career_ru, ["class" => "form-control"]); ?>
    </div>
    
	
	<div class="form-group col-md-3">
        <label>Email<span class="red">(*)</span></label>
        <?= Form::email("email", $row->email, ["class" => "form-control"]); ?>
    </div>
	
	
	
	
	
    <div class="form-group col-md-3">
        <label>Facebook</label>
        <?= Form::text("facebook", $row->facebook, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Twitter</label>
        <?= Form::text("twitter", $row->twitter, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Linkedin</label>
        <?= Form::text("linkedin", $row->linkedin, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Instagram</label>
        <?= Form::text("instagram", $row->instagram, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Youtube</label>
        <?= Form::text("youtube", $row->youtube, ["class" => "form-control ltr"]); ?>
    </div>
	
	
	
	
    <div class="form-group col-md-3">
        <label>Phone Number <span class="red">(*)</span></label>
        <?= Form::text("phone", $row->phone, ["class" => "form-control ltr"]); ?>
    </div>
	
	<div class="form-group col-md-3">
        <label>Link <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">agents/</span>
			<?= Form::text("slug", $row->slug, ["class" => "form-control input-sm ltr"]); ?>
			</div>
    </div>
	
	
    <div class="form-group col-md-3" style="clear:both">
        <label>Main region:</label>
        <select name="region_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("Region", "all") as $region)
                <option value="<?= $region->id; ?>" <?= $region->id == $row->region_id ? 'selected' : ''; ?>><?= $region->name_ar; ?></option>
            @endforeach
        </select>
    </div>
	
    <div class="form-group col-md-3">
        <label>Photo</label>
        @include('admin.layouts.media_input', [
            "name" => "media_id",
            "ids"  => [$row->media_id]
        ])
    </div>
    
	
	
    <?php $photo = $row->photo; ?>
    @if($photo)
        <div class="form-group col-md-3" style="text-align:center">
            <img src="<?= Helper::media_url($photo); ?>" alt="" style="max-width:100px">
        </div>
    @endif
    
	
	
	
	
    <div class="form-group col-md-12" style="margin-bottom:3px">
	<h4>About this agent:</h4>
	</div>
    <div class="form-group col-md-6">
        <label>Title (ar):</label>
        <?= Form::text("about_agent_title", $row->about_agent_title, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description (ar):</label>
        <?= Form::textarea("about_agent_desc", $row->about_agent_desc, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Title (en):</label>
        <?= Form::text("about_agent_title_en", $row->about_agent_title_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description (en):</label>
        <?= Form::textarea("about_agent_desc_en", $row->about_agent_desc_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Title (fr):</label>
        <?= Form::text("about_agent_title_fr", $row->about_agent_title_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description (fr):</label>
        <?= Form::textarea("about_agent_desc_fr", $row->about_agent_desc_fr, ["class" => "form-control"]); ?>
    </div>

	<div class="form-group col-md-6">
        <label>Title (fa):</label>
        <?= Form::text("about_agent_title_fa", $row->about_agent_title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description (fa):</label>
        <?= Form::textarea("about_agent_desc_fa", $row->about_agent_desc_fa, ["class" => "form-control"]); ?>
    </div>
	
    <div class="form-group col-md-6">
        <label>Title (Ru):</label>
        <?= Form::text("about_agent_title_ru", $row->about_agent_title_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description (Ru):</label>
        <?= Form::textarea("about_agent_desc_ru", $row->about_agent_desc_ru, ["class" => "form-control"]); ?>
    </div>

    <div class="form-group col-md-12" style="margin-bottom:3px">
	<h4>Advantages of this customer:</h4>
	</div>
    <div class="form-group col-md-4">
        <label>Title (ar):</label>
        <?= Form::text("avantages_title", $row->avantages_title, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Description (ar):</label>
        <?= Form::textarea("avantages_desc", $row->avantages_desc, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Regions (ar):</label>
        <?= Form::textarea("avantages_regions", $row->avantages_regions, ["class" => "form-control"]); ?>
    </div>
	
	
    <div class="form-group col-md-4">
        <label>Title (en):</label>
        <?= Form::text("avantages_title_en", $row->avantages_title_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Description (en):</label>
        <?= Form::textarea("avantages_desc_en", $row->avantages_desc_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Regions (en):</label>
        <?= Form::textarea("avantages_regions_en", $row->avantages_regions_en, ["class" => "form-control"]); ?>
    </div>

	
    <div class="form-group col-md-4">
        <label>Title (fr):</label>
        <?= Form::text("avantages_title_fr", $row->avantages_title_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Description (fr):</label>
        <?= Form::textarea("avantages_desc_fr", $row->avantages_desc_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Regions (fr):</label>
        <?= Form::textarea("avantages_regions_fr", $row->avantages_regions_fr, ["class" => "form-control"]); ?>
    </div>
	
	
	<div class="form-group col-md-4">
        <label>Title (fa):</label>
        <?= Form::text("avantages_title_fa", $row->avantages_title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Description (fa):</label>
        <?= Form::textarea("avantages_desc_fa", $row->avantages_desc_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Regions (fa):</label>
        <?= Form::textarea("avantages_regions_fa", $row->avantages_regions_fa, ["class" => "form-control"]); ?>
    </div>
	
    <div class="form-group col-md-4">
        <label>Title (Ru):</label>
        <?= Form::text("avantages_title_ru", $row->avantages_title_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Description (Ru):</label>
        <?= Form::textarea("avantages_desc_ru", $row->avantages_desc_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Regions (Ru):</label>
        <?= Form::textarea("avantages_regions_ru", $row->avantages_regions_ru, ["class" => "form-control"]); ?>
    </div>
	
	@include('admin.layouts.seo',['hide_keywords'=>true])
</fieldset>

@include('admin.layouts.media_input_js')

@endsection