@extends('admin.layouts.form', ["app_title" => "Sections", "app_desc" => "Section Information"])
@section('main_form')

<fieldset>
    <legend>Section</legend>
    <div class="form-group col-md-6"  style="display:none">
        <label>Name <span class="red">(*)</span></label>
        <?= Form::text("name", $row->name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6"  style="display:none">
        <div class="row">
            <div class="col-md-8">
                <label>Content Type<span class="red">(*)</span></label>
                <input type="hidden" name="sectiontype_id" value="1">
                <!--<select name="sectiontype_id" class="form-control select2me">
                    <option value=""></option>
                    @foreach(Helper::query("SectionType", "all") as $typ)
                        <option value="<?= $typ->id; ?>" <?= $row->sectiontype_id == $typ->id ? 'selected' : ''; ?>><?= ucfirst($typ->slug); ?></option>
                    @endforeach
                </select>-->
            </div>
        </div>
    </div>
            <div class="col-md-4">
                <label>Number of Items <span class="red">(*)</span></label>
                <?= Form::text("number_items", ($row->number_items ? $row->number_items : 3), ["class" => "form-control"]); ?>
            </div>
    <!--<div class="form-group col-md-3" style="">
        <label>موضع القسم <span class="red">(*)</span></label>
        <select name="sectionposition_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("SectionPosition", "all") as $pos)
                <option value="<?= $pos->id; ?>" <?= $row->sectionposition_id == $pos->id ? 'selected' : ''; ?>><?= $pos->name; ?></option>
            @endforeach
        </select>
    </div>-->
	<input type="hidden" value="1" name="sectionposition_id">
    <div class="form-group col-md-4" style="display:none">
        <label>Lang<span class="red">(*)</span></label>
        <?= Form::select("lang", ["ar" => "العربية", "en" => "الإنجليزية"], $row->lang, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Device</label>
        <?= Form::select("device", ["all" => "All", "desktop" => "Computer", "mobile" => "Mobile"], $row->device, ["class" => "form-control select2me"]); ?>
    </div>
</fieldset>

<fieldset>
    <legend></legend>
    <div class="form-group col-md-3">
        <label>Title Arabic<span class="red">(*)</span></label>
        <?= Form::text("title", $row->title, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title English<span class="red">(*)</span></label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title French<span class="red">(*)</span></label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Title Persian<span class="red">(*)</span></label>
        <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
    </div>
	
	
    <div class="form-group col-md-3">
        <label>Placement</label>
        <?= Form::text("placement", ($row->placement), ["class" => "form-control"]); ?>
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-md-6" style="display:none">
        <label>Section Link </label>
        <?= Form::text("section_link", $row->section_link, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="clearfix"></div>
    
    @if($row->id)
        
            <?php
                $arr_pjcts = $row->projects()->lists('project_id')->toArray();
                //$projects = Helper::query("Project", "where", ["field" => "featured", "value" => 1])->get();
                $projects = Helper::query("Project", "all");
            ?>
            
            <div class="col-md-12 text-danger form-group">
                <i class="fa fa-warning"></i> 
                <b>If you select a category, the projects of this category will be displayed without showing the selected projects in the last rectangle (Select Projects)</b>
            </div>

<div class="form-group col-md-12">
<label><input type="checkbox" value="1" name="latestproject" id="latestproject" <?= @$row->latestproject == 1 ? 'checked' : ''; ?>> عرض احدث المشاريع</label>
</div>

			
            <div class="form-group col-md-12">
                <label>Project Categories</label>
                <select name="project_category" class="form-control select2me">
                    <option value="0">Without Category</option>
                    @foreach(Helper::query("ProjectCategory", "all") as $cat)
                        <option value="<?= $cat->id; ?>" <?= $cat->id==$row->project_category ? 'selected' : ''; ?>><?= $cat->name_ar; ?></option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group col-md-12">
                <label>Selection of Projects</label>
                <select name="projects[]" class="form-control select2me" multiple>
                    <option value=""></option>
                    @foreach($projects as $prj)
                        <option value="<?= $prj->id; ?>" <?= in_array($prj->id, $arr_pjcts) ? 'selected' : ''; ?>><?= $prj->name_ar; ?></option>
                    @endforeach
                </select>
            </div>
		@if($row->sectiontype_id == "1")
		@else
			<!--<div class="form-group col-md-12">
                <label>Post Category</label>
                <select name="post_category" class="form-control select2me">
                    <option value="0">Last Posts</option>
                    @foreach(Helper::query("PostCategory", "all") as $cat)
                        <option value="<?= $cat->id; ?>" <?= $cat->id==$row->post_category ? 'selected' : ''; ?>><?= $cat->name_ar; ?></option>
                    @endforeach
                </select>
            </div>-->
        @endif
    @endif
    
</fieldset>

@endsection
