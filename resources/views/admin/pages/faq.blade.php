@extends('admin.layouts.form', ["app_title" => @$app_title])
@section('main_form')

<fieldset>
    <legend>Page information</legend>
    <div class="form-group col-md-6">
        <label>Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
	
	<div class="form-group col-md-4">
        <label>Title (Ar)</label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title (En)</label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title (Fr)</label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
    </div>
	<div class="form-group col-md-4">
        <label>Title (Fa)</label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Title (Ru)</label>
        <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr"]); ?>
    </div>
	
    <div class="form-group col-md-6">
        <label>Picture</label>
        @include('admin.layouts.media_input', [
            "name"   =>    "media_id",
            "ids"    =>    [$row->media_id]
        ])
    </div>
    <div class="form-group col-md-6">
        <label>Link</label>
        <span class="form-control ltr" readonly><?= url("$row->slug_link"); ?></span>
    </div>
</fieldset>

<?php /* ?>
<fieldset style="display:none">
    <legend>بالعربي</legend>

    <div class="form-group col-md-12">
        <label>المحتوى</label>
        @include("admin.layouts.full_editor", ["name" => "content_ar"])
    </div>
</fieldset>

<fieldset style="display:none">
    <legend>بالإنجليزي</legend>
    <div class="form-group col-md-12">
        <label>المحتوى</label>
        @include("admin.layouts.full_editor", ["name" => "content_en", "lang_editor" => "en"])
    </div>
</fieldset>

<fieldset>
    <legend>Nationality decisions</legend>
    <div class="form-group col-md-6">
        <label>Photo of the first resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision1_media",
            "ids"    =>    [$row->nationality_decision1_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision1_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision1_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label>Photo of the second resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision2_media",
            "ids"    =>    [$row->nationality_decision2_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision2_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision2_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-6">
        <label>Photo of the third resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision3_media",
            "ids"    =>    [$row->nationality_decision3_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision3_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision3_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>
	
    <div class="form-group col-md-6">
        <label>Photo of the fourth resolution </label>
        @include('admin.layouts.media_input', [
            "name"   =>    "nationality_decision4_media",
            "ids"    =>    [$row->nationality_decision4_media]
        ])
    </div>
	<div class="form-group col-md-6">
        <label>Translation</label>
        <select name="nationality_decision4_trans" class="form-control select2me">
            <option value="0"></option>
            @foreach(Helper::query("Post", "all") as $p)
                <option value="<?= $p->id; ?>" <?= $row->nationality_decision4_trans == $p->id ? 'selected' : ''; ?>><?= $p->title_ar; ?></option>
            @endforeach
        </select>
    </div>



</fieldset>

<fieldset>
    <legend>Details steps to Applying for turkish citizenship (AR)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3", "lang_editor" => "en"])
    </div>
</fieldset>

<fieldset>
    <legend>Details steps to Applying for turkish citizenship (EN)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1_en", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2_en", "lang_editor" => "en"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3_en", "lang_editor" => "en"])
    </div>
</fieldset>
<fieldset>
    <legend>Details steps to Applying for turkish citizenship (FR)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1_fr", "lang_editor" => "fr"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2_fr", "lang_editor" => "fr"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3_fr", "lang_editor" => "fr"])
    </div>
</fieldset>

<fieldset>
    <legend>Details steps to Applying for turkish citizenship (FA)</legend>
    <div class="form-group col-md-4">
        <label>Certificate of Conformity</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality1_fa", "lang_editor" => "fa"])
    </div>
    <div class="form-group col-md-4">
        <label>Investor residence</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality2_fa", "lang_editor" => "fa"])
    </div>
    <div class="form-group col-md-4">
        <label>Applying for Turkish citizenship</label>
        @include("admin.layouts.full_editor", ["name" => "steps_progress_nationality3_fa", "lang_editor" => "fa"])
    </div>
</fieldset>
<?php */ ?>



<?php /*
<style>
.dblocks input{
	
}
.dblocks .row{
	margin: 0;
}
</style>
<fieldset>
    <legend>Questions & answers</legend>
    <div class="form-group col-md-12">
	<!--<span>Question</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>Answer</span>-->
	<div class="dblocks">
		<?php
		$rows = DB::select("select * from dms_faq order by id asc");

		foreach($rows as $r){ ?>
		<div class="row">
		<div class="col-md-3">
			<input  class="form-control" type="text" name="q_ar[]" placeholder="Question (Ar)" value="<?= $r->q_ar  ?>" />
			<textarea class="form-control" name="r_ar[]" placeholder="Answer (Ar)"><?= $r->r_ar  ?></textarea>
		</div>
		<div class="col-md-3">
			<input  class="form-control" type="text" name="q_en[]" placeholder="Question (En)" value="<?= $r->q_en  ?>" />
			<textarea class="form-control" name="r_en[]" placeholder="Answer (En)"><?= $r->r_en  ?></textarea>
		</div>
		<div class="col-md-3">
			<input  class="form-control" type="text" name="q_fr[]" placeholder="Question (Fr)" value="<?= $r->q_fr  ?>" />
			<textarea class="form-control" name="r_fr[]" placeholder="Answer (Fr)"><?= $r->r_fr  ?></textarea>
		</div>
		<div class="col-md-3">
			<input  class="form-control" type="text" name="q_fa[]" placeholder="Question (Pe)" value="<?= $r->q_fa  ?>" />
			<textarea class="form-control" name="r_fa[]" placeholder="Answer (Pe)"><?= $r->r_fa  ?></textarea>
		</div>
		<input type="button" value="x" class="delrow" />
		</div>
		<?php } ?>
	</div>
	<input class="btn btn-primary" type="button" id="addrow" value="+">	
    </div>
</fieldset> */?>


@include("admin.layouts.seo")

@include("admin.layouts.media_input_js")
@include("admin.layouts.tinymce_js")
<?php /*
<script>
$('#addrow').click(function(){
	$('.dblocks').append('<div class="row">'+
'<div class="col-md-3">'+
'<input  class="form-control" type="text" name="q_ar[]" placeholder="Question (Ar)" />'+
'<textarea class="form-control" name="r_ar[]" placeholder="Answer (Ar)"></textarea>'+
'</div>'+
'<div class="col-md-3">'+
'<input  class="form-control" type="text" name="q_en[]" placeholder="Question (En)" />'+
'<textarea class="form-control" name="r_en[]" placeholder="Answer (En)"></textarea>'+
'</div>'+
'<div class="col-md-3">'+
'<input  class="form-control" type="text" name="q_fr[]" placeholder="Question (Fr)" />'+
'<textarea class="form-control" name="r_fr[]" placeholder="Answer (Fr)"></textarea>'+
'</div>'+
'<div class="col-md-3">'+
'<input  class="form-control" type="text" name="q_fa[]" placeholder="Question (Fa)" />'+
'<textarea class="form-control" name="r_fa[]" placeholder="Answer (Fa)"></textarea>'+
'</div>'+
'<input type="button" value="x" class="delrow" />'+
'</div>'+
'</div>');
});

$('body').on('click','.delrow',function(){
	$(this).parent('.row').remove();
});
</script>*/?>
@endsection