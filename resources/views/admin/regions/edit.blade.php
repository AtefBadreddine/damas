@extends('admin.layouts.form', ["app_title" => "Districts", "app_desc" => "District Information"])
@section('main_form')
<style>
.rtl{direction:rtl}
</style>
<fieldset>
    <legend>District</legend>
    <div class="form-group col-md-3">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name English<span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name French<span class="red">(*)</span></label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name Persian<span class="red">(*)</span></label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name Russian<span class="red">(*)</span></label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control ltr"]); ?>
    </div>
	
	
	
	
	
	
	
	
	
	
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
	<div class="form-group col-md-3">
        <label>Video Arabic</label>
        <?= Form::text("linkvideo_ar", $row->linkvideo_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Video English</label>
        <?= Form::text("linkvideo_en", $row->linkvideo_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Video French</label>
        <?= Form::text("linkvideo_fr", $row->linkvideo_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Video Persian</label>
        <?= Form::text("linkvideo_fa", $row->linkvideo_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Video Russian</label>
        <?= Form::text("linkvideo_ru", $row->linkvideo_ru, ["class" => "form-control"]); ?>
    </div>
</fieldset>


<fieldset>
    <legend>About District</legend>
	
	
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

</fieldset>

@include('admin.layouts.geo_content_tabs')

<fieldset>
    <legend>
	Overview & Details
</legend>


<div class="col-md-3">
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

<div class="col-md-3">
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

<div class="col-md-3">
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

<div class="col-md-3">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Location (Ar)</label>
                                            <?= Form::textarea("location_ar", $row->location_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Location (Fa)</label>
                                            <?= Form::textarea("location_fa", $row->location_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Location (En)</label>
                                            <?= Form::textarea("location_en", $row->location_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Location (Fr)</label>
                                            <?= Form::textarea("location_fr", $row->location_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Governmental institutions (Ar)</label>
                                            <?= Form::textarea("governmental_ar", $row->governmental_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Governmental institutions (Fa)</label>
                                            <?= Form::textarea("governmental_fa", $row->governmental_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Governmental institutions (En)</label>
                                            <?= Form::textarea("governmental_en", $row->governmental_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Governmental institutions (Fr)</label>
                                            <?= Form::textarea("governmental_fr", $row->governmental_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Transportation (Ar)</label>
                                            <?= Form::textarea("transportation_ar", $row->transportation_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Transportation (Fa)</label>
                                            <?= Form::textarea("transportation_fa", $row->transportation_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Transportation (En)</label>
                                            <?= Form::textarea("transportation_en", $row->transportation_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Transportation (Fr)</label>
                                            <?= Form::textarea("transportation_fr", $row->transportation_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Future Look (Ar)</label>
                                            <?= Form::textarea("future_look_ar", $row->future_look_ar, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Future Look (Fa)</label>
                                            <?= Form::textarea("future_look_fa", $row->future_look_fa, ["class" => "form-control rtl", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Future Look (En)</label>
                                            <?= Form::textarea("future_look_en", $row->future_look_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Future Look (Fr)</label>
                                            <?= Form::textarea("future_look_fr", $row->future_look_fr, ["class" => "form-control ltr", "rows" => 4]); ?>
                                        </div>
                                    </div>
</div> */ ?>
</fieldset>

<fieldset>
    <legend>Location and Coordinates</legend>
    <div class="form-group col-md-12">
        @include('admin.layouts.location_map')
    </div>
</fieldset>

@include('admin.layouts.seo')


<fieldset>
    <div class="col-md-12">
        <div class="col-md-12">
            <legend>Services and Strength of the District</legend>
            <div class="form-group col-md-6">
                <label>Transportation </label>
                <?= Form::text("transport", $row->transport, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Post</label>
                <select name="transport_desc" class="form-control select2me">
                    <option value=""></option>
                    @foreach(Helper::query("Post", "all") as $p)
                    <option value="<?= $p->id; ?>" <?= $row->transport_desc == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>Schools and Universities</label>
                <?= Form::text("schools", $row->schools, ["class" => "form-control"]); ?>
            </div>

            <div class="form-group col-md-6">
                <label>Post</label>
                <select name="schools_desc" class="form-control select2me">
                    <option value=""></option>
                    @foreach(Helper::query("Post", "all") as $p)
                    <option value="<?= $p->id; ?>" <?= $row->schools_desc == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6">
                <label>Health Institutions</label>
                <?= Form::text("health", $row->health, ["class" => "form-control"]); ?>
            </div>

            <div class="form-group col-md-6">
                <label>Post</label>
                <select name="health_desc" class="form-control select2me">
                    <option value=""></option>
                    @foreach(Helper::query("Post", "all") as $p)
                    <option value="<?= $p->id; ?>" <?= $row->health_desc == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-md-6">
                <label>Social Facilities</label>
                <?= Form::text("social", $row->social, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Post</label>
                <select name="social_desc" class="form-control select2me">
                    <option value=""></option>
                    @foreach(Helper::query("Post", "all") as $p)
                    <option value="<?= $p->id; ?>" <?= $row->social_desc == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label>Shopping Centers</label>
                <?= Form::text("shopping", $row->shopping, ["class" => "form-control"]); ?>
            </div>

            <div class="form-group col-md-6">
                <label>Post</label>
                <select name="shopping_desc" class="form-control select2me">
                    <option value=""></option>
                    @foreach(Helper::query("Post", "all") as $p)
                    <option value="<?= $p->id; ?>" <?= $row->shopping_desc == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
                    @endforeach
                </select>
            </div>


        </div>
    </div>
</fieldset>



<fieldset>
    <legend>Districts page</legend>
	
	<div class="form-group col-md-12">
				<div class="form-group">
					<label class="show_on_districts_page"><input type="checkbox" value="1" name="show_on_districts_page" <?= $row->show_on_districts_page == 1 ? 'checked' : ''; ?>> Display on districts page </label>
				</div>
		</div>
		
	



	<div class="form-group col-md-4">
        <label>H1 Arabic<span class="red">(*)</span></label>
        <?= Form::text("h1_ar", $row->h1_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 English<span class="red">(*)</span></label>
        <?= Form::text("h1_en", $row->h1_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 French<span class="red">(*)</span></label>
        <?= Form::text("h1_fr", $row->h1_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 Persian<span class="red">(*)</span></label>
        <?= Form::text("h1_fa", $row->h1_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>H1 Russian<span class="red">(*)</span></label>
        <?= Form::text("h1_ru", $row->h1_ru, ["class" => "form-control ltr"]); ?>
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
	
	
	
	<div class="col-md-4">
		<div class="form-group">
			<label>Primary Image</label>
			@include('admin.layouts.media_input', [
			"name" => "primary_photo_id",
			"ids"  => [$row->primary_photo_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (Ar)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_ar_id",
			"ids"  => [$row->map_photo_ar_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (En)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_en_id",
			"ids"  => [$row->map_photo_en_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (Fr)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_fr_id",
			"ids"  => [$row->map_photo_fr_id]
			])
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Map Image (Pe)</label>
			@include('admin.layouts.media_input', [
			"name" => "map_photo_fa_id",
			"ids"  => [$row->map_photo_fa_id]
			])
		</div>
	</div>
	<div class="col-md-4">
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
	<div class="form-group col-md-6">
        <label>Faq:</label>
        <select name="faq_category_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("Faqpost", "all") as $city)
            <option value="<?= $city->id; ?>" <?= $row->faq_category_id == $city->id ? 'selected' : ''; ?>><?= $city->title_ar; ?></option>
            @endforeach
        </select>
    </div>
</fieldset>


@include('admin.layouts.media_input_js')
@endsection