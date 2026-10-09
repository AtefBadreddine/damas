@extends('admin.layouts.form', ["app_title" => "Districts", "app_desc" => "District Information"])
@section('main_form')
<style>
#district-form .rtl{direction:rtl}
#district-form fieldset{min-width:0;clear:both;margin-bottom:24px}
#district-form fieldset:after,#district-form .tab-pane:after{content:"";display:table;clear:both}
#district-form .panel{clear:both}
#district-form .district-row{display:flex;flex-wrap:wrap}
#district-form .district-row>[class*="col-"]{float:none}
#district-form .tab-pane>.form-group.col-md-12{clear:both}
#district-form .lang-heading .nav-tabs{display:flex;flex-wrap:wrap}
#district-form .lang-heading .nav-tabs>li{float:none}
#district-form .lang-heading .nav-tabs>li>a{white-space:nowrap}
#district-form .select-medias{display:flex;flex-wrap:wrap;gap:8px}
#district-form .old-edits{clear:both;margin-top:40px;padding:20px 15px 0;border:2px solid #d32f2f;border-top:6px solid #d32f2f;border-radius:4px;background:#fff8f8}
#district-form .old-edits-title{margin:-20px -15px 24px;padding:18px 20px;background:#b71c1c;color:#fff;font-size:28px;font-weight:700;letter-spacing:1px}
#district-form .old-edits fieldset{margin-bottom:24px}
@media(max-width:991px){#district-form [class*="col-md-"]{width:100%;float:none}}
</style>
<div id="district-form">
<fieldset>
<legend>Districts</legend>
<div class="district-row">
<div class="form-group col-md-6">
        <label>City</label>
        <select name="city_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("City", "all") as $city)
            <option value="<?= $city->id; ?>" <?= $row->city_id == $city->id ? 'selected' : ''; ?>><?= $city->name_ar; ?></option>
            @endforeach
        </select>
    </div>
<div class="form-group col-md-6">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
        </div>
    </div>

</div>
</fieldset>
<div class="panel with-nav-tabs panel-default">
<div class="panel-heading lang-heading"><ul class="nav nav-tabs">
<li class="active"><a href="#district_about_ar" data-toggle="tab">Arabic</a></li>
<li><a href="#district_about_en" data-toggle="tab">English</a></li>
<li><a href="#district_about_fr" data-toggle="tab">French</a></li>
<li><a href="#district_about_fa" data-toggle="tab">Persian</a></li>
<li><a href="#district_about_ru" data-toggle="tab">Russian</a></li>
</ul></div>
<div class="panel-body"><div class="tab-content">
<div class="tab-pane fade in active" id="district_about_ar">
<div class="district-row">
<div class="form-group col-md-6">
        <label>H1 Arabic<span class="red">(*)</span></label>
        <?= Form::text("h1_ar", $row->h1_ar, ["class" => "form-control"]); ?>
    </div>
<div class="form-group col-md-6">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
</div>
                <div class="form-group col-md-12">
                    <label>Video Arabic</label>
                    <?= Form::text("linkvideo_ar", $row->linkvideo_ar, ["class" => "form-control ltr"]); ?>
                </div>
                <div class="form-group col-md-12">
                    <label>Content Arabic</label>
                    @include('admin.layouts.full_editor', ["name" => "about_ar", "rows" => 8, "editor_value" => $row->about_ar])
                </div>
                <div class="col-md-12">
<fieldset>
                        <legend>Metatag Arabic</legend>
                        <div class="form-group col-md-4">
                                                        <label>Title</label>
                            <?= Form::text("seo_title_ar", $row->seo_title_ar, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                                                        <label>Description</label>
                            <?= Form::textarea("seo_description_ar", $row->seo_description_ar, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4" style="">
                                                        <label>Keywords</label>
                            <?= Form::text("seo_keywords_ar", $row->seo_keywords_ar, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>
            </div>
<div class="tab-pane fade" id="district_about_en">
<div class="district-row">
<div class="form-group col-md-6">
        <label>H1 English<span class="red">(*)</span></label>
        <?= Form::text("h1_en", $row->h1_en, ["class" => "form-control ltr"]); ?>
    </div>
<div class="form-group col-md-6">
        <label>Name English<span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
</div>
                <div class="form-group col-md-12">
                    <label>Video English</label>
                    <?= Form::text("linkvideo_en", $row->linkvideo_en, ["class" => "form-control ltr"]); ?>
                </div>
                <div class="form-group col-md-12">
                    <label>Content English</label>
                    @include('admin.layouts.full_editor', ["name" => "about_en", "rows" => 8, "editor_value" => $row->about_en])
                </div>
                <div class="col-md-12">
<fieldset>
                        <legend>Metatag English</legend>
                        <div class="form-group col-md-4">
                            <label>Title</label>
                            <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Description</label>
                            <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <label>Keywords</label>
                            <?= Form::text("seo_keywords_en", $row->seo_keywords_en, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>
            </div>
<div class="tab-pane fade" id="district_about_fr">
<div class="district-row">
<div class="form-group col-md-6">
        <label>H1 French<span class="red">(*)</span></label>
        <?= Form::text("h1_fr", $row->h1_fr, ["class" => "form-control ltr"]); ?>
    </div>
<div class="form-group col-md-6">
        <label>Name French<span class="red">(*)</span></label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control ltr"]); ?>
    </div>
</div>
                <div class="form-group col-md-12">
                    <label>Video French</label>
                    <?= Form::text("linkvideo_fr", $row->linkvideo_fr, ["class" => "form-control ltr"]); ?>
                </div>
                <div class="form-group col-md-12">
                    <label>Content French</label>
                    @include('admin.layouts.full_editor', ["name" => "about_fr", "rows" => 8, "editor_value" => $row->about_fr])
                </div>
                <div class="col-md-12">
<fieldset>
                        <legend>Metatag French</legend>
                        <div class="form-group col-md-4">
                            <label>Title</label>
                            <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Description</label>
                            <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <label>Keywords</label>
                            <?= Form::text("seo_keywords_fr", $row->seo_keywords_fr, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>
            </div>
<div class="tab-pane fade" id="district_about_fa">
<div class="district-row">
<div class="form-group col-md-6">
        <label>H1 Persian<span class="red">(*)</span></label>
        <?= Form::text("h1_fa", $row->h1_fa, ["class" => "form-control"]); ?>
    </div>
<div class="form-group col-md-6">
        <label>Name Persian<span class="red">(*)</span></label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
    </div>
</div>
                <div class="form-group col-md-12">
                    <label>Video Persian</label>
                    <?= Form::text("linkvideo_fa", $row->linkvideo_fa, ["class" => "form-control ltr"]); ?>
                </div>
                <div class="form-group col-md-12">
                    <label>Content Persian</label>
                    @include('admin.layouts.full_editor', ["name" => "about_fa", "rows" => 8, "editor_value" => $row->about_fa])
                </div>
                <div class="col-md-12">
<fieldset>
                        <legend>Metatag Persian</legend>
                        <div class="form-group col-md-4">
                            <label>Title</label>
                            <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Description</label>
                            <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <label>Keywords</label>
                            <?= Form::text("seo_keywords_fa", $row->seo_keywords_fa, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>
            </div>
<div class="tab-pane fade" id="district_about_ru">
<div class="district-row">
<div class="form-group col-md-6">
        <label>H1 Russian<span class="red">(*)</span></label>
        <?= Form::text("h1_ru", $row->h1_ru, ["class" => "form-control ltr"]); ?>
    </div>
<div class="form-group col-md-6">
        <label>Name Russian<span class="red">(*)</span></label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control ltr"]); ?>
    </div>
</div>
                <div class="form-group col-md-12">
                    <label>Video Russian</label>
                    <?= Form::text("linkvideo_ru", $row->linkvideo_ru, ["class" => "form-control ltr"]); ?>
                </div>
                <div class="form-group col-md-12">
                    <label>Content Russian</label>
                    @include('admin.layouts.full_editor', ["name" => "about_ru", "rows" => 8, "editor_value" => $row->about_ru])
                </div>
                <div class="col-md-12">
<fieldset>
                        <legend>Metatag Russian</legend>
                        <div class="form-group col-md-4">
                            <label>Title</label>
                            <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control text-align-left", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Description</label>
                            <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control text-align-left", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>

                        @if(@$hide_keywords==false)
                        <div class="form-group col-md-4">
                            <label>Keywords</label>
                            <?= Form::text("seo_keywords_ru", $row->seo_keywords_ru, ["class" => "form-control text-align-left", "placeholder" => "Keywords"]); ?>
                        </div>
                        @endif
                    </fieldset>
                </div>
            </div>
</div></div>
</div>
<section class="old-edits" aria-labelledby="district-old-edits-title">
<h2 class="old-edits-title" id="district-old-edits-title">OLD EDITS</h2>
<fieldset>
<legend>Legacy Content and FAQ</legend>
<div class="district-row">
<div class="col-md-6">
		<div class="form-group">
			<label>Primary Image</label>
			@include('admin.layouts.media_input', [
			"name" => "primary_photo_id",
			"ids"  => [$row->primary_photo_id]
			])
		</div>
	</div>
<div class="form-group col-md-6">
        <label>Content</label>
        <select name="post_id" class="form-control select2me" >
			<option value="0"></option>
			<?php
			$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
			?>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
    </div>
<div class="form-group col-md-6">
        <label>Faq:</label>
        <select name="faq_category_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("Faqpost", "all") as $city)
            <option value="<?= $city->id; ?>" <?= $row->faq_category_id == $city->id ? 'selected' : ''; ?>><?= $city->title_ar; ?></option>
            @endforeach
        </select>
    </div>
</div>
</fieldset>



<?php /* 
    <div class="form-group col-md-6 hiddenz">
        <label>Title Arabic</label>
        <?= Form::text("about_title_ar", $row->about_title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6 hiddenz">
        <label>About Arabic</label>
        <?= Form::textarea("about_ar", $row->about_ar, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-6 hiddenz">
        <label>Title English</label>
        <?= Form::text("about_title_en", $row->about_title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6 hiddenz">
        <label>About English</label>
        <?= Form::textarea("about_en", $row->about_en, ["class" => "form-control tinyeditor"]); ?>
    </div>

    <div class="form-group col-md-6 hiddenz">
        <label>Title French</label>
        <?= Form::text("about_title_fr", $row->about_title_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6 hiddenz">
        <label>About French</label>
        <?= Form::textarea("about_fr", $row->about_fr, ["class" => "form-control tinyeditor"]); ?>
    </div>
	
	
	<div class="form-group col-md-6 hiddenz">
        <label>Title Persian</label>
        <?= Form::text("about_title_fa", $row->about_title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6 hiddenz">
        <label>About Persian</label>
        <?= Form::textarea("about_fa", $row->about_fa, ["class" => "form-control tinyeditor"]); ?>
    </div>*/ ?>

<fieldset>
    <legend>
	Overview & Details
</legend>


<div class="col-md-6">
<div class="form-group">
	<label>Location</label>
	<select name="location_post_id" class="form-control select2me">
		<option value="0"></option>
		<?php
		if(!isset($posts))
		$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
		?>
		@foreach($posts as $post)
			<option value="<?= $post->id; ?>" <?= $post->id == $row->location_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
		@endforeach
	</select>
</div> 
</div>

<div class="col-md-6">
<div class="form-group">
	<label>Governmental institutions</label>
	<select name="governmental_post_id" class="form-control select2me">
		<option value="0"></option>
		<?php
		if(!isset($posts))
		$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
		?>
		@foreach($posts as $post)
			<option value="<?= $post->id; ?>" <?= $post->id == $row->governmental_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
		@endforeach
	</select>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
	<label>Transportation</label>
	<select name="transportation_post_id" class="form-control select2me">
		<option value="0"></option>
		<?php
		if(!isset($posts))
		$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
		?>
		@foreach($posts as $post)
			<option value="<?= $post->id; ?>" <?= $post->id == $row->transportation_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
		@endforeach
	</select>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
	<label>Future Look</label>
	<select name="future_look_post_id" class="form-control select2me">
		<option value="0"></option>
		<?php
		if(!isset($posts))
		$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
		?>
		@foreach($posts as $post)
			<option value="<?= $post->id; ?>" <?= $post->id == $row->future_look_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
		@endforeach
	</select>
</div>
</div>

<?php /*
<div class=" hiddenz">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location (Ar)</label>
                                            <?= Form::textarea("location_ar", $row->location_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location (Fa)</label>
                                            <?= Form::textarea("location_fa", $row->location_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location (En)</label>
                                            <?= Form::textarea("location_en", $row->location_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location (Fr)</label>
                                            <?= Form::textarea("location_fr", $row->location_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Governmental institutions (Ar)</label>
                                            <?= Form::textarea("governmental_ar", $row->governmental_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Governmental institutions (Fa)</label>
                                            <?= Form::textarea("governmental_fa", $row->governmental_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Governmental institutions (En)</label>
                                            <?= Form::textarea("governmental_en", $row->governmental_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Governmental institutions (Fr)</label>
                                            <?= Form::textarea("governmental_fr", $row->governmental_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transportation (Ar)</label>
                                            <?= Form::textarea("transportation_ar", $row->transportation_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transportation (Fa)</label>
                                            <?= Form::textarea("transportation_fa", $row->transportation_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transportation (En)</label>
                                            <?= Form::textarea("transportation_en", $row->transportation_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Transportation (Fr)</label>
                                            <?= Form::textarea("transportation_fr", $row->transportation_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Future Look (Ar)</label>
                                            <?= Form::textarea("future_look_ar", $row->future_look_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Future Look (Fa)</label>
                                            <?= Form::textarea("future_look_fa", $row->future_look_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Future Look (En)</label>
                                            <?= Form::textarea("future_look_en", $row->future_look_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Future Look (Fr)</label>
                                            <?= Form::textarea("future_look_fr", $row->future_look_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
</div> */ ?>
</fieldset>

<fieldset>
    <legend>Districts page</legend>
	
	<div class="form-group col-md-12">
				<div class="form-group">
					<label class="show_on_districts_page"><input type="checkbox" value="1" name="show_on_districts_page" <?= $row->show_on_districts_page == 1 ? 'checked' : ''; ?>> Display on districts page </label>
				</div>
		</div>

<div class="col-md-6">
<div class="form-group">
	<label>Content 1</label>
	<select name="r_post_id" class="form-control select2me">
		<option value="0"></option>
		<?php
		if(!isset($posts))
		$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
		?>
		@foreach($posts as $post)
			<option value="<?= $post->id; ?>" <?= $post->id == $row->r_post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
		@endforeach
	</select>
</div> 
</div>


	<div class="form-group col-md-6">
        <label>Content 2</label>
        <select name="post_id2" class="form-control select2me" >
			<option value="0"></option>
			<?php
			//$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
			?>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->post_id2 ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
    </div>
	

<?php /*
	<div style="clear:both" class=" hiddenz">
	
    <div class="form-group col-md-6">
        <label>Title Arabic</label>
        <?= Form::text("r_title_ar", $row->r_title_ar, ["class" => "form-control"]); ?>
    </div>
	    <div class="form-group col-md-6">
        <label>Title English</label>
        <?= Form::text("r_title_en", $row->r_title_en, ["class" => "form-control"]); ?>
    </div>
	    <div class="form-group col-md-6">
        <label>Title French</label>
        <?= Form::text("r_title_fr", $row->r_title_fr, ["class" => "form-control"]); ?>
    </div>
	    <div class="form-group col-md-6">
        <label>Title Persian</label>
        <?= Form::text("r_title_fa", $row->r_title_fa, ["class" => "form-control"]); ?>
    </div>
	
	
    <div class="form-group col-md-6">
        <label>Description Arabic</label>
        <?= Form::textarea("r_descr_ar", $row->r_descr_ar, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description English</label>
        <?= Form::textarea("r_descr_en", $row->r_descr_en, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description French</label>
        <?= Form::textarea("r_descr_fr", $row->r_descr_fr, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Description Persian</label>
        <?= Form::textarea("r_descr_fa", $row->r_descr_fa, ["class" => "form-control tinyeditor"]); ?>
    </div>
	
    </div>*/ ?>

	<div class="col-md-6">
		<div class="form-group">
			<label>Map Image (Ar)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_ar_id",
			"ids"  => [$row->map_photo_ar_id]
			])
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Map Image (En)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_en_id",
			"ids"  => [$row->map_photo_en_id]
			])
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Map Image (Fr)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_fr_id",
			"ids"  => [$row->map_photo_fr_id]
			])
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Map Image (Pe)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_fa_id",
			"ids"  => [$row->map_photo_fa_id]
			])
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Map Image (Ru)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_ru_id",
			"ids"  => [$row->map_photo_ru_id]
			])
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label>Project Images</label>
			@include('admin.layouts.media_input', [
			"name" => "region_photos",
			"multiple"  => true,
			"ids"    =>    $row->regionphotos()->lists('media_id')->toArray()
			])
		</div>
	</div>
	
</fieldset>
</section>
</div>
@include('admin.layouts.media_input_js')
@endsection
