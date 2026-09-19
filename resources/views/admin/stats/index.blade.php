@extends('admin.layouts.app', ["app_title" => "Visitors"])
@section('main_content')
    <style>
        td{word-wrap: break-word;}
    </style>
    
    <div class="form-group">
        <form class="form-inline">
            <div class="form-group">
                <label class="sr-only">IP</label>
                <input type="text" name="ip" class="form-control" placeholder="IP" title="IP" value="<?= Input::get('ip'); ?>">
            </div>
            <div class="form-group">
                <label class="sr-only">Date</label>
                <input type="text" name="date" class="form-control" placeholder="<?= date("Y-m-d"); ?>" title="Date" value="<?= Input::get('date'); ?>">
            </div>
            <div class="form-group">
                <label class="sr-only">Country</label>
                <input type="text" name="country" class="form-control" placeholder="Country" title="Country" value="<?= Input::get('country'); ?>">
            </div>
            <div class="form-group">
                <label class="sr-only">City</label>
                <input type="text" name="city" class="form-control" placeholder="City" title="City" value="<?= Input::get('city'); ?>">
            </div>
            <input type="hidden" name="field" value="<?= input::get("field"); ?>">
            <input type="hidden" name="sort" value="<?= input::get("sort"); ?>">
            <input type="hidden" name="page" value="<?= input::get("page"); ?>">
            <button type="submit" class="btn btn-default">Filter</button>
        </form>
    </div>
    <?php $get_params = "&ip=".Input::get("ip")."&date=".Input::get("date")."&country=".Input::get("country")."&city=".Input::get("city"); ?>
    
    <?php
        $lignes = [
            "id"    =>  "",
            "ip"  =>  "IP",
            "country"  =>  "Country",
            "city"  =>  "City",
            "hostname"  =>  "Bot",
            "updated_at"  =>  "Updated at",
            "page_views"  =>  "Page Views",
        ];
    ?>
    @include("admin.layouts.table", [
        "box_title"    =>    "Visitors",
        "get_params"   =>    $get_params
    ])
    
@endsection
