@extends('admin.layouts.form', ["app_title" => "Types", "app_desc" => "Types Information"])
@section('main_form')

<fieldset>
    <legend>Type</legend>
    <div class="form-group col-md-3">
        <label>Name Arabic <span class="red">(*)</span></label>
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
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
        </div>
    </div>
</fieldset>

<!--<fieldset>
    <legend>الرابط</legend>
    
    <div class="clearfix"></div>
    <div class="form-group col-md-6">
        <label>عنوان الصفحة بالعربي</label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>عنوان الصفحة بالإنجليزي </label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
</fieldset>-->
<style>
.dblocks input{
	width:60px;
}
.dblocks .row{
	margin: 0;
}
</style>
<fieldset>
    <legend>Pattern Options</legend>
    <div class="form-group col-md-12">
	<span>Salon</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>Room</span>
	<div class="dblocks">
		<?php
		$patt = [];
		if($row->pattern!='')
			$patt = unserialize($row->pattern);

		foreach($patt as $r){ ?>
		<div class="row">
			<input type="text" name="salon[]" value="<?= $r['salon'] ?>" />
			<input type="text" name="room[]" value="<?= $r['room'] ?>" />
			<input type="button" value="x" class="delrow">
		</div>
		<?php } ?>
	</div>
	<input class="btn btn-primary" type="button" id="addrow" value="+">	
    </div>
</fieldset>
<fieldset>
    <legend>About this type of property</legend>
	
	
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
    <div class="form-group col-md-12 hiddenz">
        <label>Title Arabic</label>
        <?= Form::text("about_title_ar", $row->about_title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About Arabic</label>
        <?= Form::textarea("about_ar", $row->about_ar, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>Title English</label>
        <?= Form::text("about_title_en", $row->about_title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About English</label>
        <?= Form::textarea("about_en", $row->about_en, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>Title French</label>
        <?= Form::text("about_title_fr", $row->about_title_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About French</label>
        <?= Form::textarea("about_fr", $row->about_fr, ["class" => "form-control tinyeditor"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>Title Persian</label>
        <?= Form::text("about_title_fa", $row->about_title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12 hiddenz">
        <label>About Persian</label>
        <?= Form::textarea("about_fa", $row->about_fa, ["class" => "form-control tinyeditor"]); ?>
    </div>*/ ?>
</fieldset>

@include('admin.layouts.seo')

@include("admin.layouts.tinymce_js")


<script>
$('#addrow').click(function(){
	$('.dblocks').append('<div class="row"><input type="text" name="salon[]"><input type="text" name="room[]"><input type="button" class="delrow" value="x"></div>');
});

$('body').on('click','.delrow',function(){
	$(this).parent('.row').remove();
});
</script>



@endsection