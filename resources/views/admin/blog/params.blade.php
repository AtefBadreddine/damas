@extends('admin.layouts.app', ["app_title" => ucfirst($type) . " Params"])
@section('main_content')

<?= Form::open(); ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= ucfirst($type) . " Params" ?></h3>
    </div>
    <div class="box-body">
        <fieldset>
            <div class="form-group col-md-6">
                <label>Title (Ar) <span class="red">(*)</span></label>
                <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control", "required" => true]); ?>
            </div>
            <div class="form-group col-md-6">
                <label>Title (En) <span class="red">(*)</span></label>
                <?= Form::text("title_en", $row->title_en, ["class" => "form-control", "required" => true]); ?>
            </div>
        </fieldset>
        @include("admin.layouts.seo")        
    </div>
    <div class="box-footer">
        <button class="btn btn-primary">update</button>
    </div>
</div>
<?= Form::close(); ?>

@endsection
