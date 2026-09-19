<style>
.clearfix{clear:both}

.project-insert-images label {
    width: 100%;
    align-self: left;
}

small {
    color: red;
}

input:focus {
    border: none;
}

input[type="file"]::file-selector-button {
    display: none;
}

input[type="file"]::before {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    line-height: normal;
    content: '+';
    background-color: #0f8280;
    color: #fff;
    border-radius: 100%;
    font-size: 1.2em;
    font-weight: 700;
    margin: 0 10px 0 0;
    vertical-align: middle;
    width: 15px;
    height: 15px;
    overflow: hidden;
    transition: all 150ms ease;
}

input[type="file"]:hover::before {
    width: 20px;
    height: 20px;
    font-size: 1.5em;
}

input[type="file"]:active::before {
    width: 25px;
    height: 25px;
    font-size: 1.7em;
}

.hidden {
    display: none;
}

</style>
<fieldset class="project-insert-images">
    <legend>Insert Images</legend>
    <div class="form-group col-md-4">
        <label>Image Name (AR)</label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Image Title (AR)</label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Image Description (AR)</label>
        <?= Form::text("description_ar", $row->description_ar, ["class" => "form-control"]); ?>
    </div>
	<div class="clearfix"></div>
    <br>
    <div class="form-group col-md-4">
        <label>Image Name (EN)</label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Image Title (EN)</label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Image Description (EN)</label>
        <?= Form::text("description_en", $row->description_en, ["class" => "form-control ltr"]); ?>
    </div>
	<div class="clearfix"></div>
    <br>
    <div class="form-group col-md-4">
        <label>Add Computer Image<span class="red">(*)</span></label>
        @if($row->id)
            <input type="file" name="file" class="form-control ltr">
        @else
            <input type="file" name="files[]" class="form-control ltr" multiple required>
        @endif
        <small class="help-block">Preferred image: 2560×1440 px • 100–200 KB</small>
    </div>
    <div class="form-group col-md-4">
        <label>Add Mobile Image</label>
        @if($row->id)
            <input type="file" name="file_mobile" class="form-control ltr">
        @else
            <input type="file" name="files_mobile[]" class="form-control ltr" multiple>
        @endif
    </div>
    <div class="form-group col-md-4" style="width: 16.6%;">
        <label>Existing Folder</label>
        <select name="folder_id" class="form-control select2me image-folder-selection">
            <option value="0">Empty</option>
            @foreach(Helper::query("MediaFolder", "all") as $folder)
                <option value="<?= $folder->id; ?>" <?= $row->folder_id == $folder->id ? 'selected' : ''; ?>><?= $folder->name; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4" style="width: 16.6%;">
        <label>New Folder</label>
        <?= Form::text("folder", null, ["class" => "form-control"]); ?>
    </div>
    
    <div class="clearfix"></div>
    <div class="form-group col-md-4 create-new-folder">
        <label style="direction: rtl;">Insert the Logo inside the image<input type="checkbox" name="insert_logo"></label>
    </div>
    <div class="clearfix"></div>
    
    @if($row->filename)
        <div class="form-group col-md-2">
            Computer Image
            <a href="<?= asset("uploads/$row->filename"); ?>" target="_blank">
                <img src="<?= Helper::get_thumbnail($row, 150, 120); ?>" alt="" class="img-responsive">
            </a>
        </div>
        @if($row->path_mobile)
        <div class="form-group col-md-2">
            Mobile Image
            <a href="<?= asset("$row->path_mobile"); ?>" target="_blank">
                <img src="<?= asset("$row->path_mobile"); ?>" width="150" height="120" alt="" class="img-responsive">
            </a>
            <a href="?delmobile=true" class="btn btn-danger btn-xs" style="position:absolute;top:0;left:0;"><i class="fa fa-trash"></i></a>
        </div>
        @endif
    @endif
    <div class="hidden">
        <div class="form-group col-md-4">
            <label>File Name in French</label>
            <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control ltr"]); ?>
        </div>
        <div class="form-group col-md-4">
            <label>File Name in Persian</label>
            <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control"]); ?>
        </div>
        <div class="form-group col-md-4">
            <label>File Name in Russian</label>
            <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control ltr"]); ?>
        </div>
        <div class="form-group col-md-4">
        <label>Image Title in French</label>
        <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr"]); ?>
        </div>
        <div class="form-group col-md-4">
            <label>Image Title in Persian</label>
            <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control"]); ?>
        </div>
        <div class="form-group col-md-4">
            <label>Image Title in Russian</label>
            <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control"]); ?>
        </div>
    
    
        <div class="form-group col-md-4">
            <label>Image Description in French</label>
            <?= Form::text("description_fr", $row->description_fr, ["class" => "form-control ltr"]); ?>
        </div>
	    <div class="form-group col-md-4">
            <label>Image Description in Persian</label>
            <?= Form::text("description_fa", $row->description_fa, ["class" => "form-control"]); ?>
        </div>
        <div class="form-group col-md-4">
            <label>Image Description in Russian</label>
            <?= Form::text("description_ru", $row->description_ru, ["class" => "form-control ltr"]); ?>
        </div>
    </div>

</fieldset>



<script>
$(function(){
    $("select[name=folder_id]").on("change", function(){
        $("input[name=folder]").val('');
    });
    $("input[name=folder]").on("change", function(){
        var select = $("select[name=folder_id]");
        select.val('0');
        select.trigger("change.select2");
    });
});
</script>