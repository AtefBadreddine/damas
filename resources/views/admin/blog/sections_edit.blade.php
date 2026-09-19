@extends('admin.layouts.form', ["app_title" => "Sections"])
@section('main_form')

<fieldset>
    <legend>Section Information</legend>
    <div class="form-group col-md-5">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-5">
        <label>Name English</label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-5">
        <label>Name French</label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-5">
        <label>Name Persian<span class="red">(*)</span></label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
	
    <div class="form-group col-md-2">
        <label>Show Title</label>
        <div>
            <input type="checkbox" name="show_title" <?= $row->show_title == 1 ? 'checked' : ''; ?>>
        </div>
    </div>
    <div class="form-group col-md-3">
        <label>Website version</label>
        <?= Form::select("lang", Helper::langs("all"), $row->lang, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Template Display</label>
        <?= Form::select("model", [
            "model1" => "نموذج 1",
            "model2" => "نموذج 2",
            "model3" => "نموذج 3",
            "model4" => "نموذج 4",
            "model5" => "نموذج 5",
            "model6" => "نموذج 6",
            ], $row->model, ["class" => "form-control select2me"]); ?>
        <p class="help-block"><a href="<?= asset("img/blog_sections.png"); ?>" target="_blank">Photo Forms</a></p>
    </div>
    <div class="form-group col-md-3">
        <label>Content Type</label>
        <?= Form::select("content_type", [
            "posts" => "مقالات",
            "news" => "أخبار",
            "videos" => "فيديوهات",
            "projects" => "عقارات",
            "category" => "تصنيف",
            ], $row->content_type, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Content</label>
        <?= Form::select("content_display", [
            "latest" => "الأحدث",
            "selected" => "المختارة",
            "most_visited" => "الأكثر زيارة",
            ], $row->content_display, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Selected Properties - <small class="text-info">Effective when Choosing Properties Content Type</small></label> 
        <?php $posts = Helper::query("Post", "all"); ?>
        <select name="posts_selected[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach($posts as $post)
                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->posts()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_ar; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-12">
        <label>Selected Properties</label>
        <?php $projects = Helper::query("Project", "published"); ?>
        <select name="projects_selected[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach($projects as $project)
                <option value="<?= $project->id; ?>" <?= in_array($project->id, $row->projects()->lists('project_id')->toArray()) ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-12">
        <label>Category - <small class="text-info">Effective when Selecting Content Type Category</small></label>
        <?php $cats = Helper::query("PostCategory", "all"); ?>
        <select name="category_id" class="form-control select2me">
            <option value=""></option>
            @foreach($cats as $cat)
                <option value="<?= $cat->id; ?>" <?= ($cat->id == $row->category_id) ? 'selected' : ''; ?>><?= $cat->name_ar; ?></option>
            @endforeach
        </select>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-md-4">
        <label>Arrangement</label>
        <?= Form::text("placement", ($row->placement ? $row->placement : $row->max('placement')+1), ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Number of Items</label>
        <?= Form::text("number_items", ($row->number_items?$row->number_items:6), ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Position</label>
        <?= Form::select("section_position", [
            "" => "",
            "sidebar" => "الشريط الجانبي للمدونة",
            "sidebar_post" => "الشريط الجانبي للمنشور",
            "slider" => "سلايدر"
            ], $row->section_position, ["class" => "form-control"]); ?>
    </div>
</fieldset>

@endsection
