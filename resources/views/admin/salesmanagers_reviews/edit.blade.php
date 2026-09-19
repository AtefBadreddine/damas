@extends('admin.layouts.form', ["app_title" => "Reviews", "app_desc" => "Client Information"])
@section('main_form')

<fieldset>
    <legend>Reviews</legend>
    <div class="form-group col-md-4">
        <label>Name Ar<span class="red">(*)</span></label>
        <?= Form::text("client_name", $row->client_name, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name En</label>
        <?= Form::text("client_name_en", $row->client_name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name Fr</label>
        <?= Form::text("client_name_fr", $row->client_name_fr, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name Fa</label>
        <?= Form::text("client_name_fa", $row->client_name_fa, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Name Ru</label>
        <?= Form::text("client_name_ru", $row->client_name_ru, ["class" => "form-control ltr"]); ?>
    </div>
	
	
    <div class="form-group col-md-4">
        <label>Country Ar<span class="red">(*)</span></label>
        <?= Form::text("client_country", $row->client_country, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Country En<span class="red">(*)</span></label>
        <?= Form::text("client_country_en", $row->client_country_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Country Fr<span class="red">(*)</span></label>
        <?= Form::text("client_country_fr", $row->client_country_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Country Fa<span class="red">(*)</span></label>
        <?= Form::text("client_country_fa", $row->client_country_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Country Ru<span class="red">(*)</span></label>
        <?= Form::text("client_country_ru", $row->client_country_ru, ["class" => "form-control"]); ?>
    </div>




    <div class="form-group col-md-4">
        <label>Comment (ar):</label>
        <?= Form::textarea("comment", $row->comment, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Comment (en):</label>
        <?= Form::textarea("comment_en", $row->comment_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Comment (fr):</label>
        <?= Form::textarea("comment_fr", $row->comment_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Comment (fa):</label>
        <?= Form::textarea("comment_fa", $row->comment_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Comment (ru):</label>
        <?= Form::textarea("comment_ru", $row->comment_ru, ["class" => "form-control"]); ?>
    </div>








    <div class="form-group col-md-4"><br>
        <label>
		<input type="checkbox" name="enabled" value="1" <?= ($row->enabled == true) ? 'checked' : ''; ?>> Published</label>
    </div>

</fieldset>

@include('admin.layouts.media_input_js')

@endsection