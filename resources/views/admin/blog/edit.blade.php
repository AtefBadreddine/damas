@extends('admin.layouts.form', ["app_title" => "Add a new post"])
@section('main_form')


<style>
    .projects_filter_section{
        display: none;
        margin-bottom: 30px;
        background-color: #eaeaea;
        padding: 16px 5px;
    }
    .projects_filter_section.show{
        display: block;
    }
</style>


<fieldset>
    <!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1default" data-toggle="tab">Arabic Section</a></li>
                    <li><a href="#tab2default" data-toggle="tab">English Section</a></li>
                    <li><a href="#tab3default" data-toggle="tab">French Section</a></li>
                    <li><a href="#tab4default" data-toggle="tab">Persian Section</a></li>
                    <li><a href="#tab5default" data-toggle="tab">Russian Section</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">

                    <!-- Section Arabic -->
                    <div class="tab-pane fade in active" id="tab1default">
                        <input type="hidden" name="type" value="<?= $type ?>" >
                        <div class="col-md-4">
                            <div class="form-group">
<!--                                <label>Title Arabic<span class="red">(*)</span></label>-->
                                <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control", "placeholder" => "Arabic Title"]); ?>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
<!--                                <label>Slug<span class="red">(*)</span></label>-->
                                <div class="input-group ltr">
                                    <span class="input-group-addon"><?= url('/' . $type) . "/" ?><?= $row->country=='turkey'?'':$row->country.'/' ?></span>
                                    <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm", "placeholder" => "Slug"]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="enabled-section"><input type="checkbox" id="published" name="published" <?= $row->published == 1 ? 'checked' : ''; ?>> Enabled</label>
                            </div>
                        </div>

                        <div class="col-md-12 block_redirect col-md-offset-2 " style="padding-top: 20px;<?= ($row->published == 0 ? 'display:block' : 'display:none') ?>">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="enabled-section"><input type="checkbox" id="post_scheduling" name="post_scheduling" <?= $row->post_scheduling == 1 ? 'checked' : ''; ?>> Post scheduling</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <?= Form::text("post_scheduling_date", $row->post_scheduling_date, ["placeholder" => "Date Time", "class" => "form-control date5"]); ?>
                                </div>
                            </div>
                        </div>

                        @if(isset($row->id))
                        <div class="col-md-8 block_redirect col-md-offset-2 " style="<?= ($row->published == 0 ? 'display:block' : 'display:none') ?>">
                            <div class="form-group">
                                <label>Redirect Post:</label>
                                <select name="redirect_post_id" class="form-control select2me" >
                                    <option value="0"></option>
                                    <?php
                                    $posts = \App\Models\Post::where("published", 1)->where("type", $type)->where('id', '!=', $row->id)->where('title_ar', '!=', '')->get();
                                    ?>
                                    @foreach($posts as $post)
                                    <option value="<?= $post->id; ?>" <?= $post->id == $row->redirect_post_id ? 'selected' : '' ?>><?= $post->title_ar; ?></option>
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                        @endif		
                        <div class="col-md-12">
                            <!--<legend>Featured Post</legend>-->
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select name="country_id" class="form-control select2me">
                                        <?php foreach ($countries as $country): ?>
                                        <option value="<?= $country->id ?>" <?= ((int)$row->country_id === (int)$country->id || $row->country == $country->code) ? 'selected' : '' ?>><?= $country->title_en ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select name="category_id[]" class="form-control select2me" multiple>
                                        <option value=""></option>
                                        @foreach(\App\Models\PostCategory::where("type", $type)->get() as $cat)
                                        <option value="<?= $cat->id; ?>" <?= in_array($cat->id, $row->categories()->lists('post_category_id')->toArray()) ? 'selected' : ''; ?>><?= ucfirst($cat->country) .' > '. $cat->name_en; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tags</label>
                                    <select name="tag_id[]" class="form-control select2me" multiple>
                                        <option value=""></option>
                                        @foreach(\App\Models\Tag::where('type',$type)->get() as $cat)
                                        <option value="<?= $cat->id; ?>" <?= in_array($cat->id, $row->tags()->lists('tag_id')->toArray()) ? 'selected' : ''; ?> title="<?= $cat->title_en != '' ? $cat->title_en . "\n" : '' ?><?= $cat->title_ar != '' ? $cat->title_ar . "\n" : '' ?><?= $cat->title_fr != '' ? $cat->title_fr . "\n" : '' ?><?= $cat->title_pe != '' ? $cat->title_pe . "\n" : '' ?><?= $cat->title_ru != '' ? $cat->title_ru : '' ?>"><?= $cat->name; ?>
                                            (<?= $cat->title_ar != '' ? 'AR ' : '' ?><?= $cat->title_en != '' ? 'EN ' : '' ?><?= $cat->title_fr != '' ? 'FR ' : '' ?><?= $cat->title_fa != '' ? 'PE ' : '' ?><?= $cat->title_ru != '' ? 'RU ' : '' ?>)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="display:none">
                                <div class="form-group">
                                    <label>Website Version</label>
                                    <?= Form::select("lang", ["all" => "All", "ar" => "Arabic", "en" => "English", "fa" => "Persian"], $row->lang, ["class" => "form-control select2me"]); ?>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Post Type</label>
                                    <?= Form::select("post_type", ["posts" => "Post", "news" => "News", "videos" => "Video"], $row->post_type, ["class" => "form-control select2me"]); ?>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <!--                            <legend>Real Estate Projects</legend>-->
                                <div class="form-group">
                                    <label>Related Projects</label>
                                    <select name="project_id[]" class="form-control select2me" multiple>
                                        <option value=""></option>
                                        @foreach(Helper::query("Project", "all") as $project)
                                        <option value="<?= $project->id; ?>" <?= in_array($project->id, $row->projects()->lists('project_id')->toArray()) ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!--                            <legend>Similar Posts</legend>-->
                                <div class="form-group">
                                    <label>Similar Posts</label>
                                    <select name="similar_posts[]" class="form-control select2me" multiple>
                                        <option value=""></option>
                                        @foreach(\App\Models\Post::where('type',$type)->get() as $post)
                                        <option value="<?= $post->id; ?>" <?= in_array($post->id, explode(",", $row->similar_posts)) ? 'selected' : ''; ?>><?= $post->title_ar; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Image Card</label>
                                    @include("admin.layouts.media_input", [
                                    "name"    =>    "media_id",
                                    "ids"    =>    [$row->media_id]
                                    ])
                                </div>
                            </div>



                            <div class="col-md-4">
                                <div class="form-group" style="padding:24px 14px">
                                    <label class="enabled-section"><input type="checkbox" id="prevent_archiving_in_blog" name="prevent_archiving_in_blog" <?= $row->prevent_archiving_in_blog == 1 ? 'checked' : ''; ?>> Prevent archiving in <?= ucfirst($type) ?> </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group" style="padding:24px 14px">
                                    <label class="enabled-section with_projects_blog"><input type="checkbox" id="with_projects_blog" name="with_projects_blog" <?= $row->with_projects_blog == 1 ? 'checked' : ''; ?>> With projects Blog </label>
                                </div>
                            </div>
	<?php
		/*$all_regions = \App\Models\Region::select('regions.*')->leftJoin('projects AS p', 'p.region_id', '=', 'regions.id')->where("p.published", 1)->where("p.sold", '!=', 100)->groupBy('regions.id')->having(DB::raw('count(dms_p.id)'), '>', 0)->orderBy(DB::raw('count(dms_p.id)'), 'desc')->get();
		$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
		$citys = App\Models\City::where('id', '!=', 2)->orderBy('placement', 'asc')->get();
		$all_project_types = Helper::query('ProjectType', 'all');
		
		$arr_cities = [];
		foreach($citys as $c)
			$arr_cities[$c->id] = $c->getName();*/
	?>
                            <!-- Start Projects Filters -->
                            <div class="col-md-12 projects_filter_section <?= $row->with_projects_blog==true?'show':'' ?>">
                                <div class="col-md-12">
								<input type="text" class="form-control" placeholder="Search URL" name="projects_url" value="<?= $row->projects_url ?>"/>
								</div>
								<?php /*<!--<div class="col-md-2">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select class="form-control" name="city" id="city">
                                            @foreach($citys as $city)
											<option value="<?= $city->slug; ?>" data-city="<?= $city->id; ?>"><?= $city->getName(); ?></option>
											@endforeach
                                        </select>
                                    </div>
                                </div>-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>City Region</label>
                                        <select class="form-control" name="region" id="region" >
											@foreach($all_regions as $r)
											<option value="<?= $r->slug; ?>"  data-city="<?= $r->city_id; ?>"><?= $arr_cities[$r->city_id]; ?> - <?= $r->getName(); ?></option>
											@endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Types</label>
                                        <select class="form-control" name="project_type" id="project_type">
                                            @foreach($all_project_types as $typ)
											<option value="<?= $typ->slug; ?>"><?= $typ->getName(); ?></option>
											@endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Features</label>
                                        <select class="form-control select2me" name="project_category[]" id="features" multiple>
                                            @foreach($proj_cats as $cat)
											<option value="<?= $cat->slug; ?>"><?= $cat->getName(); ?></option>
											@endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Content Place</label>
                                        <select class="form-control" name="content_place" id="content_place">
                                            <option value="up">Up</option>
                                            <option value="down">Down</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Number of results: <b>(25)</b></label>
                                    </div>
                                </div>*/ ?>
                            </div>
                            <!-- End Peojects Filters -->


                        </div>


                        <div class="form-group col-md-12">
                            <label>Content Arabic<span class="red">(*)</span></label>
                            @include("admin.layouts.full_editor", ["name" => "content_ar"])
                        </div>


                        <!-- seo ar -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Title</label>-->
                                    <?= Form::text("seo_title_ar", $row->seo_title_ar, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Description</label>-->
                                    <?= Form::textarea("seo_description_ar", $row->seo_description_ar, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>

                                @if(@$hide_keywords==false)
                                <div class="form-group col-md-12" style="">
                                    <!--                            <label>Keywords</label>-->
                                    <?= Form::text("seo_keywords_ar", $row->seo_keywords_ar, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                                </div>
                                @endif
                            </fieldset>
                        </div>


                    </div>

                    <!-- Section English -->
                    <div class="tab-pane fade" id="tab2default">
                        <div class="form-group col-md-12">
                            <!--                            <label>Title English</label>-->
                            <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr", "placeholder" => "English Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content English</label>
                            @include("admin.layouts.full_editor", ["name" => "content_en"])
                        </div>


                        <!-- seo eng -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Title</label>-->
                                    <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Description</label>-->
                                    <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>

                                @if(@$hide_keywords==false)
                                <div class="form-group col-md-12">
                                    <!--                            <label>Keywords</label>-->
                                    <?= Form::text("seo_keywords_en", $row->seo_keywords_en, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                                </div>
                                @endif
                            </fieldset>
                        </div>


                    </div>

                    <!-- Section Fr -->
                    <div class="tab-pane fade" id="tab3default">
                        <div class="form-group col-md-12">
                            <!--                            <label>Title English</label>-->
                            <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content</label>
                            @include("admin.layouts.full_editor", ["name" => "content_fr"])
                        </div>


                        <!-- seo FR -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Title</label>-->
                                    <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Description</label>-->
                                    <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>

                                @if(@$hide_keywords==false)
                                <div class="form-group col-md-12">
                                    <!--                            <label>Keywords</label>-->
                                    <?= Form::text("seo_keywords_fr", $row->seo_keywords_fr, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                                </div>
                                @endif
                            </fieldset>
                        </div>


                    </div>
                    <!-- Section Fa -->
                    <div class="tab-pane fade" id="tab4default">
                        <div class="form-group col-md-12">
                            <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content</label>
                            @include("admin.layouts.full_editor", ["name" => "content_fa"])
                        </div>

                        <!-- seo FA -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Title</label>-->
                                    <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Description</label>-->
                                    <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>

                                @if(@$hide_keywords==false)
                                <div class="form-group col-md-12">
                                    <!--                            <label>Keywords</label>-->
                                    <?= Form::text("seo_keywords_fa", $row->seo_keywords_fa, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                                </div>
                                @endif
                            </fieldset>
                        </div>


                    </div>




                    <!-- Section Ru -->
                    <div class="tab-pane fade" id="tab5default">
                        <div class="form-group col-md-12">
                            <!--                            <label>Title English</label>-->
                            <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content</label>
                            @include("admin.layouts.full_editor", ["name" => "content_ru"])
                        </div>


                        <!-- seo RU -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                    <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <!--                            <label>Description</label>-->
                                    <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>

                                @if(@$hide_keywords==false)
                                <div class="form-group col-md-12">
                                    <!--                            <label>Keywords</label>-->
                                    <?= Form::text("seo_keywords_ru", $row->seo_keywords_ru, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                                </div>
                                @endif
                            </fieldset>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>

</fieldset>
<link rel="stylesheet" href="<?= asset('admin/js/bootstrap-datetimepicker.css'); ?>">
<script src="<?= asset('admin/js/bootstrap-datetimepicker.js') ?>"></script>

@include("admin.layouts.media_input_js")

<script>
    $(document).on("ifChanged", "#published", function () {

        if ($(this).is(':checked'))
            $('.block_redirect').hide();
        else
            $('.block_redirect').show();

    });


    $(document).on("ifChanged", "#with_projects_blog", function () {
        if ($(this).is(':checked'))
            $(".projects_filter_section").addClass("show");
        else
            $(".projects_filter_section").removeClass("show");
    });


    $('.date5').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
    });





</script>
@endsection
