<?php
    $ids = @$ids ? $ids : [];
    $multiple = @$multiple;
    $small_btn = @$small_btn;
    $name_input = $multiple ? $name.'[]' : $name;
?>

<style>
    .select2-search-choice {
        max-width: 100%;
        overflow: hidden;
        font-size: 0.8em;
    }
    .select2-container {
        max-width: 280px;
    }
</style>

<div class="input-group select-medias <?= $small_btn ? "input-group-sm" : ""; ?>">
    <select name="<?= $name_input; ?>" id="<?= $name; ?>" class="form-control select2me" <?= $multiple == true ? 'multiple' : ''; ?> <?= @$required == true ? 'required' : ''; ?>>
        <option value=""></option>
        @foreach(Helper::query("Media", "whereIn", ["field" => "id", "value" => $ids])->get() as $md)
            <option value="<?= $md->id; ?>" selected><?= $md->name_en; ?></option>
			<?php $md_id = $md->id; ?>
        @endforeach
    </select>
    <div class="input-group-btn">
        <button type="button" class="btn btn-default btn_add_media_modal" data-target="#<?= $name; ?>" title="Add New"><i class="fa fa-plus-circle"></i></button>
        <button type="button" class="btn btn-default btn_list_files" data-target="#<?= $name; ?>" <?= $multiple == true ? 'data-multiple="1"' : ''; ?> title="List of Files"><i class="fa fa-list"></i></button>
        @if(isset($md_id))
		<a target="_blank" href="{{ route('admin.medias.edit',$md_id) }}" style="color:#0b7f7f" class="btn btn-default" title="Edit File"><i class="fa fa-edit"></i></a>
		@endif
        @if(!$small_btn)
        <button type="button" class="btn btn-default btn_empty_select_media" title="Delete"><i class="fa fa-trash"></i></button>
        @endif
    </div>
</div>
