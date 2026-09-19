@extends('admin.layouts.form', ["app_title" => "Add Videos", "app_desc" => ""])
@section('main_form')

<style>
    .select2-disabled {
        display: none;
    }
</style>
<fieldset>
    <!--    <legend>Videos Information</legend>-->
    <div class="form-group col-md-2">
        <label>Language <span class="red">(*)</span></label>
		    <?php
	if($row->lang)
		$langs = explode(',',$row->lang);
	else
		$langs = ['ar'];
	?>
        <?= Form::select("lang[]", ["ar" => "Arabic", "en" => "English", "fr" => "French", "fa" => "Persian", "ru" => "Russian"], $langs, ["multiple"=>"multiple","class" => "form-control select2me"]); ?>
    </div>

    <?php
    $arr_ssecs = $row->sections()->lists('sectionvideo_id')->toArray();
    $arr_posts = $row->posts()->lists('post_id')->toArray();
    $arr_projects = $row->projects()->lists('project_id')->toArray();

    $projects = Helper::query("Project", "all");
    $posts = Helper::query("Post", "all");
    $sections = Helper::query("Sectionvideo", "all");
    ?>



    <div class="form-group col-md-2">
        <label>Category:</label>
        <select name="sections[]" class="form-control select2me">
            <option value=""></option>
            @foreach($sections as $sec)
            <option lang="<?= $sec->lang ?>" value="<?= $sec->id; ?>" <?= in_array($sec->id, $arr_ssecs) ? 'selected' : ''; ?>><?= $sec->title_en ?></option>
            @endforeach
        </select>
    </div>


    <div class="form-group col-md-4">
        <label>Project:</label>
        <select name="projects[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach($projects as $p)
            <option value="<?= $p->id; ?>" <?= in_array($p->id,$arr_projects) ? 'selected' : ''; ?>><?= $p->title_en; ?></option>
            @endforeach
        </select>
    </div>




    <div class="form-group col-md-4">
        <label>Articles:</label>
        <select name="posts[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach($posts as $sec)
            <option value="<?= $sec->id; ?>" <?= in_array($sec->id, $arr_posts) ? 'selected' : ''; ?>><?php
			if(trim($sec->title_ar)!='')
				echo $sec->title_ar;
			elseif(trim($sec->title_en)!='')
				echo $sec->title_en;
			elseif(trim($sec->title_fr)!='')
				echo $sec->title_fr;
			elseif(trim($sec->title_fa)!='')
				echo $sec->title_fa;
			
			?></option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label>Link</label>
        <?= Form::url("link", $row->link, ["class" => "form-control ltr"]); ?>
    </div>


    <input type="hidden" name="last_update" value="2021-04-20">
    <!--    <div class="form-group col-md-6">
            <label>Title</label>
    <?= Form::text("title", $row->title, ["class" => "form-control ltr"]); ?>
        </div>-->
<div class="form-group col-md-6">
    <label>Slug</label>
    <?= Form::text("slug", $row->slug, ["class" => "form-control ltr"]); ?>
</div>


    <div class="form-group col-md-6" style="display:none">
        <label>Photo</label>
        @include('admin.layouts.media_input', [
        "name" => "media_id",
        "ids"  => [$row->media_id]
        ])
    </div>


    <!--    <div class="form-group col-md-6" style="padding-top:27px"><label> </label>
            <label><input type="checkbox" name="show_on_media" value="1" <?= $row->show_on_media == true ? 'checked="checked"' : '' ?>>  Display on Media page</label>
        </div>-->
    <?php /* $photo = $row->photo; 
      @if($photo)
      <div class="form-group col-md-6">
      <img src="<?= Helper::media_url($photo); ?>" alt="">
      </div>
      @endif
     */ ?>
</fieldset>

@include('admin.layouts.media_input_js')


<script>
    /*$('select[name=lang]').trigger('change');
    $('select[name=lang]').change(function () {
        var lang = $(this).val();

        $("select[name='sections[]'] option").prop("selected", false);
        $("select[name='sections[]'] option").attr('disabled', true);
        $("select[name='sections[]'] option[lang='" + lang + "']").removeAttr('disabled');

        $("select[name='sections[]']").select2("destroy");

        $("select[name='sections[]']").select2();
    });*/
</script>
@endsection