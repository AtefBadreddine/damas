@extends('admin.layouts.form', ["app_title" => "Search Pages", "app_desc" => "Link Information"])
@section('main_form')



<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading lang-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1default" data-toggle="tab">Arabic Section</a></li>
            <li><a href="#tab2default" data-toggle="tab">English Section</a></li>
            <li><a href="#tab3default" data-toggle="tab">French Section</a></li>
            <li><a href="#tab4default" data-toggle="tab">Farisi Section</a></li>
            <li><a href="#tab5default" data-toggle="tab">Russian Section</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">

            <!-- Section Arabic -->
            <div class="tab-pane fade in active" id="tab1default">
			
			
<fieldset>
    <div class="form-group col-md-6">
        <label>H1 title <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Link <span class="red">(*)</span></label>
        <?= Form::text("link", $row->link, ["class" => "form-control ltr"]); ?>
    </div>
	<div class="form-group col-md-6">
        <label>Share Image</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_id",
            "ids"   =>	[$row->media_id]
        ])
        <small><a href="<?= route('admin.medias.edit', $row->media_id); ?>" target="_blank">Image Link</a></small>
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
	
	
	
	

    <legend>Content Arabic</legend>
    
	<div class="form-group col-md-12">
        <label>Title</label>
        <?= Form::text("title", $row->title, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Text</label>
        @include('admin.layouts.full_editor', ["name" => "content"])        
    </div>
	<div class="col-md-12">
                        <fieldset>
                            <legend>Metatag Arabic</legend>
                            <div class="form-group col-md-4">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_ar", $row->seo_title_ar, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_ar", $row->seo_description_ar, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-4" style="">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_ar", $row->seo_keywords_ar, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
</fieldset>


</div>

            <!-- Section English -->
            <div class="tab-pane fade" id="tab2default">

<fieldset>
    <legend>Content English</legend>
	
    <div class="form-group col-md-3">
        <label>Share Image(English)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_en_id",
            "ids"   =>	[$row->media_en_id]
        ])
        <small><a href="<?= route('admin.medias.edit', $row->media_en_id); ?>" target="_blank">Image Link</a></small>
    </div>
    <div class="form-group col-md-12">
        <label>Title</label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Text</label>
        @include('admin.layouts.full_editor', ["name" => "content_en"])
    </div>
	<!-- seo eng -->
                    <div class="col-md-12">
                        <fieldset>
                            <legend>English</legend>
                            <div class="form-group col-md-4">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-4">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_en", $row->seo_keywords_en, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
</fieldset>



            </div>

            <!-- Section French -->
            <div class="tab-pane fade" id="tab3default">

<fieldset>

    <div class="form-group col-md-3">
        <label>Share Image(French)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_fr_id",
            "ids"   =>	[$row->media_fr_id]
        ])
        <small><a href="<?= route('admin.medias.edit', $row->media_fr_id); ?>" target="_blank">Image Link</a></small>
    </div>
    <legend>Content French</legend>
    <div class="form-group col-md-12">
        <label>Title</label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Text</label>
        @include('admin.layouts.full_editor', ["name" => "content_fr"])
    </div>
	<!-- seo FR -->
                    <div class="col-md-12">
                        <fieldset>
                            <legend>FRENCH</legend>
                            <div class="form-group col-md-4">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-4">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_fr", $row->seo_keywords_fr, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
					
					
</fieldset>

</div>
            <!-- Section Farisi -->
            <div class="tab-pane fade" id="tab4default">
			
<fieldset>
    <div class="form-group col-md-3">
        <label>Share Image(Persian)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_fa_id",
            "ids"   =>	[$row->media_fa_id]
        ])
        <small><a href="<?= route('admin.medias.edit', $row->media_fa_id); ?>" target="_blank">Image Link</a></small>
    </div>
	
    <legend>Content Persian</legend>
    <div class="form-group col-md-12">
        <label>Title</label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Text</label>
        @include('admin.layouts.full_editor', ["name" => "content_fa"])        
    </div>
	<!-- seo FA -->
                    <div class="col-md-12">
                        <fieldset>
                            <legend>PERSIAN</legend>
                            <div class="form-group col-md-4">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-4">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_fa", $row->seo_keywords_fa, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
</fieldset>
</div>

<!-- Section Russian -->
<div class="tab-pane fade" id="tab5default">

<fieldset>
    <div class="form-group col-md-3">
        <label>Share Image(Russian)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_ru_id",
            "ids"   =>	[$row->media_ru_id]
        ])
        <small><a href="<?= route('admin.medias.edit', $row->media_ru_id); ?>" target="_blank">Image Link</a></small>
    </div>
	
    <legend>Content Russian</legend>
    <?php /*<div class="form-group col-md-12">
        <label>Title</label>
        <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Text</label>
        @include('admin.layouts.full_editor', ["name" => "content_ru"])        
    </div>*/?>
	<!-- seo FA -->
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Russian</legend>
                            <div class="form-group col-md-4">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control text-align-left", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-4">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control text-align-left", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-4">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_ru", $row->seo_keywords_ru, ["class" => "form-control text-align-left", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
</fieldset>
</div>

        </div>
    </div>
</div>

@include('admin.layouts.media_input_js')

@endsection
