@extends('admin.layouts.app', ["app_title" => "Newsletter"])
@section('main_content')
    <?php $get_params = "&search=".Input::get("search"); ?>
    <div class="form-group text-left">
        <?= Form::open(); ?>
            <button type="submit" class="btn btn-default btn-xs">Download XLS file</button>
        <?= Form::close(); ?>
    </div>
    <?php
        $lignes = [
            "id"    =>  "",
            "email"  =>  "Phone Number",
            "created_at"  =>  "Created at",
        ]; 
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "List of Emails",
		"get_params"   =>    $get_params
    ])
    
@endsection
