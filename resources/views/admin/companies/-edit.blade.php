@extends('admin.layouts.form', ["app_title" => "Companies", "app_desc" => ""])
@section('main_form')









 




<fieldset>
    <legend>Company</legend>
    <div class="form-group col-md-6">
        <label>Company's name<span class="red">(*)</span></label>
        <?= Form::text("company_name", $row->company_name, ["class" => "form-control","required"=>""]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Date of Establishment<span class="red"></span></label>
        <?= Form::text("establishment_year", $row->establishment_year, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Under cons. Projects<span class="red"></span></label>
        <?= Form::text("under_cons_projects", $row->under_cons_projects, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Ready Projects<span class="red"></span></label>
        <?= Form::text("ready_projects", $row->ready_projects, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Finishing & Quality<span class="red"></span></label>
        <?= Form::text("finishing_quality", $row->finishing_quality, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>External Expansion<span class="red"></span></label>
        <?= Form::text("external_expansion", $row->external_expansion, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Delayed Projects<span class="red"></span></label>
        <?= Form::text("delayed_projects", $row->delayed_projects, ["class" => "form-control ltr"]); ?>
    </div>
</fieldset>


@endsection