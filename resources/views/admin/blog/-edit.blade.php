@extends('admin.layouts.form', ["app_title" => "Add New post"])
@section('main_form')



<fieldset>
<!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1default" data-toggle="tab">Arabic Section</a></li>
                    <li><a href="#tab2default" data-toggle="tab">English Section</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">

                    <!-- Section Arabic -->
                    <div class="tab-pane fade in active" id="tab1default">

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
                                    <span class="input-group-addon"><?= url('/blog') . "/" ?></span>
                                    <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm", "placeholder" => "Slug"]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="enabled-section"><input type="checkbox" name="published" <?= $row->published == 1 ? 'checked' : ''; ?>> Enabled</label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <!--                            <legend>Featured Post</legend>-->

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Categories</label>
                                    <select name="category_id[]" class="form-control select2me" multiple>
                                        <option value=""></option>
                                        @foreach(Helper::query("PostCategory", "all") as $cat)
                                        <option value="<?= $cat->id; ?>" <?= in_array($cat->id, $row->categories()->lists('post_category_id')->toArray()) ? 'selected' : ''; ?>><?= $cat->name_en; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Website Version</label>
                                    <?= Form::select("lang", ["all" => "All", "ar" => "Arabic", "en" => "English"], $row->lang, ["class" => "form-control select2me"]); ?>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                        @foreach(Helper::query("Post", "all") as $post)
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

                        </div>


                        <div class="form-group col-md-12">
                            <label>Content Arabic<span class="red">(*)</span></label>
                            @include("admin.layouts.full_editor", ["name" => "content_ar"])
                        </div>


                        @include("admin.layouts.seo")
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

                    </div>
                </div>
            </div>
        </div>
    </div>

</fieldset>



@include("admin.layouts.media_input_js")

@endsection
