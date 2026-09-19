@extends('admin.layouts.form', ["app_title" => "Edit ", "app_desc" => "Faq"])
@section('main_form')

<fieldset>

<div class="roestion_sec">
<input type="hidden" value="<?= isset($_GET['category'])?$_GET['category']:$id ?>" name="category" >
<input type="hidden" value="<?= isset($_GET['category'])?'0':'1' ?>" name="create" >
<div class="form-group col-md-3">
<label>Question (Ar)<span class="red">(*)</span></label>
<input  class="form-control" type="text" name="q_ar" placeholder="Question (Ar)" value="<?= $row->q_ar ?>" />
</div>
<div class="form-group col-md-3">
<label>Answer (Ar)<span class="red">(*)</span></label>
<textarea class="form-control" name="r_ar" placeholder="Answer (Ar)"><?= $row->r_ar ?></textarea>
</div>

<div class="form-group col-md-3">
<label>Question (En)<span class="red">(*)</span></label>
<input  class="form-control" type="text" name="q_en" placeholder="Question (En)" value="<?= $row->q_en ?>" />
</div><div class="form-group col-md-3">
<label>Answer (En)<span class="red">(*)</span></label>
<textarea class="form-control" name="r_en" placeholder="Answer (En)"><?= $row->r_en ?></textarea>

</div><div class="form-group col-md-3">
<label>Question (Fr)<span class="red">(*)</span></label>
<input  class="form-control" type="text" name="q_fr" placeholder="Question (Fr)" value="<?= $row->q_fr ?>" />
</div><div class="form-group col-md-3">
<label>Answer (Fr)<span class="red">(*)</span></label>
<textarea class="form-control" name="r_fr" placeholder="Answer (Fr)"><?= $row->r_fr ?></textarea>
</div><div class="form-group col-md-3">
<label>Question (Pe)<span class="red">(*)</span></label>
<input  class="form-control" type="text" name="q_fa" placeholder="Question (Pe)" value="<?= $row->q_fa ?>" />
</div><div class="form-group col-md-3">
<label>Answer (Pe)<span class="red">(*)</span></label>
<textarea class="form-control" name="r_fa" placeholder="Answer (Pe)"><?= $row->r_fa ?></textarea>

</div><div class="form-group col-md-3">
<label>Question (Ru)<span class="red">(*)</span></label>
<input  class="form-control" type="text" name="q_ru" placeholder="Question (Ru)" value="<?= $row->q_ru ?>" />
</div><div class="form-group col-md-3">
<label>Answer (Ru)<span class="red">(*)</span></label>
<textarea class="form-control" name="r_ru" placeholder="Answer (Ru)"><?= $row->r_ru ?></textarea>
</div>
<?php
$posts = Helper::query("Post", "all");
?>
<div class="form-group col-md-3">
<label>Posts<span class="red">(*)</span></label>
<select name="posts[]" placeholder="Posts" class="form-control select2me" multiple>
@foreach($posts as $sec)
<option value="<?= $sec->id; ?>" <?= in_array($sec->id, explode(',',$row->str_posts)) ? 'selected' : ''; ?>><?php
if(trim($sec->title_ar)!='')
echo $sec->title_ar;
elseif(trim($sec->title_en)!='')
echo $sec->title_en;
elseif(trim($sec->title_fr)!='')
echo $sec->title_fr;
elseif(trim($sec->title_fa)!='')
echo $sec->title_fa;
elseif(trim($sec->title_ru)!='')
echo $sec->title_ru;
?></option>
@endforeach
</select>
</div>




</fieldset>

@endsection