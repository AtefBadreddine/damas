@extends('admin.layouts.form', ["app_title" => "Landing Offer", "app_desc" => "Landing offer"])
@section('main_form')

<style>
    .add_offer{
        margin-bottom: 24px;
        position: relative;
        top: 10px;
    }
    .delete_offer{
        width: 30px;
        height: 30px;
        background-color: #ffffff;
        display: block;
        text-align: center;
        border-radius: 100%;
        color: red;
        font-size: 21px;
        border: 1px solid red;
        line-height: 24px;
        position: relative;
        top: 29px;
        cursor: pointer;
    }
    .delete_offer:hover{
        background-color: red;
        color: #ffffff;
    }
    .other_offers,
    .offer_cont{
        float: left;
        width: 100%;
    }
    .offer_cont{
        background-color: #dbdbdb;
        padding: 10px;
        border-bottom: 1px solid #b9b9b9;
    }
    .offer_cont:last-child{
        border-bottom: 0px;
    }
    .form-control {
        border-color: #b1b1b1;
    }
    /*    .offer_cont:nth-child(odd) {background: #ececec}*/
</style>
<?php
	$direction = in_array($row->lang,['en','fr','ru']) ? 'ltr' : 'rtl';
	
	/*
	$resells = \App\Model\Resellproject::where('id','>',0)->get();
	$offers = \App\Model\Landoffer::where('id','>',0)->get();
	$landing2_resell_offers = DB::select("SELECT * FROM `dms_landing2_resell_offer` WHERE `landing2_id`=?",[$row->id]);*/
?>
<fieldset>
    <legend>Landing Page Settings</legend>


    <div class="form-group col-md-6">
        <label>Lang<span class="red">(*)</span>: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <?php //Form::select("lang", Helper::langs(), $row->lang, ["class" => "form-control select2me"]); ?>
        <?php
        if ($row->lang)
            $langs = explode(',', $row->lang);
        else
            $langs = ['ar'];
        ?>
        <label><input type="checkbox" class="ch_lang" name="lang[]" value="ar" <?= in_array('ar', $langs) ? 'checked="checked"' : '' ?>>Arabic</label>
        &nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" class="ch_lang" name="lang[]" value="en" <?= in_array('en', $langs) ? 'checked="checked"' : '' ?>>English</label>
        &nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" class="ch_lang" name="lang[]" value="pe" <?= in_array('pe', $langs) ? 'checked="checked"' : '' ?>>Farisi</label>
        &nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" class="ch_lang" name="lang[]" value="fr" <?= in_array('fr', $langs) ? 'checked="checked"' : '' ?>>French</label>
        &nbsp;&nbsp;&nbsp;
        <label><input type="checkbox" class="ch_lang" name="lang[]" value="ru" <?= in_array('ru', $langs) ? 'checked="checked"' : '' ?>>Russian</label>

    </div>




    <!--    <div class="form-group col-md-6">
            <label>Name <span class="red">(*)</span></label>
    <?= Form::text("name", $row->name, ["class" => "form-control $direction"]); ?>
        </div>-->


    <div class="form-group col-md-6">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/landing3/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control ltr"]); ?>
        </div>
    </div>
</fieldset>

<fieldset style="display:none">
    <legend>Page Content</legend>
    <div class="col-md-6 cont_ar <?= in_array('ar', $langs) ? '' : 'hidden' ?>">
        <div class="form-group">
            <label>Title Ar</label>
            <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control ltr"]); ?>
        </div>

        <div class="form-group">
            <label>Content Ar</label>
            @include("admin.layouts.full_editor", ["name" => "content_ar"])
        </div>
    </div>

    <div class="col-md-6 cont_en <?= in_array('en', $langs) ? '' : 'hidden' ?>">
        <div class="form-group">
            <label>Title En</label>
            <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
        </div>

        <div class="form-group">
            <label>Content En</label>
            @include("admin.layouts.full_editor", ["name" => "content_en"])
        </div>
    </div>

    <div class="col-md-6 cont_pe <?= in_array('pe', $langs) ? '' : 'hidden' ?>">
        <div class="form-group">
            <label>Title Pe</label>
            <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control ltr"]); ?>
        </div>

        <div class="form-group">
            <label>Content Pe</label>
            @include("admin.layouts.full_editor", ["name" => "content_fa"])
        </div>
    </div>

    <div class="col-md-6 cont_fr <?= in_array('fr', $langs) ? '' : 'hidden' ?>">
        <div class="form-group">
            <label>Title Fr</label>
            <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
        </div>

        <div class="form-group">
            <label>Content Fr</label>
            @include("admin.layouts.full_editor", ["name" => "content_fr"])
        </div>
    </div>

    <div class="col-md-6 cont_ru <?= in_array('ru', $langs) ? '' : 'hidden' ?>">
        <div class="form-group">
            <label>Title Ru</label>
            <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr"]); ?>
        </div>

        <div class="form-group">
            <label>Content Ru</label>
            @include("admin.layouts.full_editor", ["name" => "content_ru"])
        </div>
    </div>
</fieldset>

<?php /*
<fieldset>
    <legend>Offers Section</legend>
    <div class="form-group col-md-6">
        <label>Choose Offers</label>
        <select name="landing2_offer[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("Land2offer", "all") as $offer)
            <option value="<?= $offer->id; ?>" <?= in_array($offer->id, $row->offers()->lists('land2offer_id')->toArray()) ? 'selected' : ''; ?>><?= ($offer->title_en!=''?$offer->title_en:$offer->title_ar); ?></option>
            @endforeach
        </select>            
    </div>
</fieldset>
*/ ?>
<fieldset>
    <legend>Offers Section <a class="add_offer btn btn-default">+ Add Offer</a></legend>


    


    <div class="other_offers">
	<?php
	foreach($landing3_resell_offers as $l){
		
		
		?>
				<div class="offer_cont">
                    <div class="form-group col-md-3">
                    <label>Project Type</label>
                    <select name="type_project[]" class="form-control">
                    <option value="">Project Type</option>
                    <option value="offer" <?= $l->type_project=='offer'?'selected':'' ?>>New Project</option>
                    <option value="resale" <?= $l->type_project=='resale'?'selected':'' ?>>Resale Project</option>
                    </select> 
                    </div>
                    <div class="form-group col-md-3">
                    <label><?= ucfirst($l->type_project) ?></label>
                    <select name="offer_id[]" class="form-control" style="<?= $l->type_project=='offer'?'':'display:none' ?>">
                    <option value="">Choose Offer</option>
					<?php //$resells;
					$i=0;
					foreach($offers as $o){ ?>
                    <option value="<?= $o->id ?>" <?= $l->offer_id==$o->id?'selected':'' ?>><?= $offers_label[$i] ?></option>
                    <?php $i++; } ?>
                    </select> 
                    <select name="resale_id[]" class="form-control" style="<?= $l->type_project=='offer'?'display:none':'' ?>">
                    <option value="">Choose Resale</option>
					<?php
					$i=0;
					foreach($resells as $o){
					?>
                    <option value="<?= $o->id ?>" <?= $l->resale_id==$o->id?'selected':'' ?>><?= $resells2_label[$i] ?></option>
                    <?php $i++; } ?>
                    </select> 
                    </div>
                    <div class="form-group col-md-4">
                    <label>Button Title(Ar)</label>
                    <input name="title[]" class="form-control" value="<?= $l->title ?>" />
                    </div>
                    <div class="form-group col-md-4">
                    <label>Button Title(En)</label>
                    <input name="ititle_en[]" class="form-control" value="<?= $l->title_en ?>" />
                    </div>
                    <div class="form-group col-md-4">
                    <label>Button Title(Fr)</label>
                    <input name="ititle_fr[]" class="form-control" value="<?= $l->title_fr ?>" />
                    </div>
                    <div class="form-group col-md-4">
                    <label>Button Title(Ru)</label>
                    <input name="ititle_ru[]" class="form-control" value="<?= $l->title_ru ?>" />
                    </div>
                    <div class="form-group col-md-4">
                    <label>Button Title(Pe)</label>
                    <input name="ititle_pe[]" class="form-control" value="<?= $l->title_pe ?>" />
                    </div>
                    <div class="form-group col-md-1">
                    <label>Arrange</label>
                    <input name="arrange[]" class="form-control" value="<?= $l->arrange ?>" />
                    </div>
                    <div class="form-group col-md-1">
                    <a class="delete_offer" title="Do you want to delete this offer?">x</a>
                    </div>
				</div>
	<?php } ?>
    </div>




    <!--    <div class="form-group col-md-6">
            <label>Choose Offers</label>
            <select name="project_id" class="form-control select2me" multiple>
                <option value=""></option>
                @foreach(Helper::query("Project", "published") as $project)
                <option value="<?= $project->id; ?>" <?= $row->project_id == $project->id ? 'selected' : ''; ?>><?= $project->name_ar; ?></option>
                @endforeach
            </select>            
        </div>-->
</fieldset>
@include("admin.layouts.seo",["hide_keywords" => true])

<script>
    $(function () {
        $("#btndup").on("click", function () {
            var dv = $("#tr_other_row").clone().removeClass('hidden').removeAttr('id').appendTo("#table_other_content");
        });

        $(".ch_lang").on("ifChanged ", function () {
            if ($(this).is(':checked')) {
                $('.cont_' + $(this).val()).removeClass('hidden');
            } else {
                $('.cont_' + $(this).val()).addClass('hidden');
            }

        });
		
	
       




        $(document).on("change", "select[name='type_project[]']", function () {
			var parent_div = $(this).parent('div').parent('div');
			if($(this).val()=='offer'){
				parent_div.find("select[name='offer_id[]']").show();
				parent_div.find("select[name='resale_id[]']").hide();
			}else if($(this).val()=='resale'){
				parent_div.find("select[name='offer_id[]']").hide();
				parent_div.find("select[name='resale_id[]']").show();
			}else{
				parent_div.find("select[name='offer_id[]']").hide();
				parent_div.find("select[name='resale_id[]']").hide();
			}
		});
		$(document).on("click", ".delete_offer", function () {
            $(this).parents(".offer_cont").remove();
        });
    });
</script>

<script>
$(document).ready(function(){
	 $(".add_offer").on("click", function () {
            $(".other_offers").append(
                    '<div class="offer_cont">' +
                    '<div class="form-group col-md-3">' +
                    '<label>Project Type</label>' +
                    '<select name="type_project[]" class="form-control">' +
                    '<option value="">Project Type</option>' +
                    '<option value="offer">New Project</option>' +
                    '<option value="resale">Resale Project</option>' +
                    '</select> ' +
                    '</div>' +
                    '<div class="form-group col-md-3">' +
                    '<label>Offer</label>' +
                    '<select name="offer_id[]" class="form-control" style="display:none">' +
                    '<option value="">Choose Offer</option>' +
					<?php //$resells;
					$i = 0;
					foreach($offers as $o){
					?>
                    '<option value="<?= $o->id ?>"><?= $offers_label[$i] ?></option>' +
                    <?php $i++; } ?>
                    '</select> ' +
                    '<select name="resale_id[]" class="form-control" style="display:none">' +
                    '<option value="">Choose Resale</option>' +
					<?php
					$i = 0;
					foreach($resells as $o){
						?>
                    '<option value="<?= $o->id ?>"><?= $resells2_label[$i] ?></option>' +
                    <?php $i++; } ?>
                    '</select> ' +
                    '</div>' +
                    '<div class="form-group col-md-4">' +
                    '<label>Button Title</label>' +
                    '<input name="title[]" class="form-control" />' +
                    '</div>' +
                    '<div class="form-group col-md-1">' +
                    '<label>Arrange</label>' +
                    '<input name="arrange[]" class="form-control" />' +
                    '</div>' +
                    '<div class="form-group col-md-1">' +
                    '<a class="delete_offer" title="Do you want to delete this offer?">x</a>' +
                    '</div>' +
                    '</div>'
                    );

        });
});
</script>

@include("admin.layouts.media_input_js")
@include("admin.layouts.tinymce_js")

@endsection
