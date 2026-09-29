@extends('admin.layouts.form', ["app_title" => "Countries", "app_desc" => "Country Information"])
@section('main_form')

<fieldset>
    <legend>Country Information</legend>
    <div class="form-group col-md-3">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Name English<span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-2">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
        </div>
        <span class="help-block">Used in the URL, e.g. turkiye</span>
    </div>
    <div class="form-group col-md-2">
        <label>Code <span class="red">(*)</span></label>
        <?= Form::text("code", $row->code, ["class" => "form-control ltr"]); ?>
        <span class="help-block">Matches the old country string, e.g. turkey</span>
    </div>
    <div class="form-group col-md-2">
        <label>WhatsApp number</label>
        <?= Form::text("whatsapp_number", $row->whatsapp_number, ["class" => "form-control ltr", "placeholder" => "905551605000"]); ?>
        <span class="help-block">Used on this country's pages. Digits only, e.g. 905551605000</span>
    </div>
    <div class="form-group col-md-2">
        <label>Placement</label>
        <?= Form::text("placement", $row->placement, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>
            <input type="checkbox" name="show" value="1" <?= (!isset($row->show) || $row->show == 1) ? 'checked' : ''; ?>>
            Show in search filters
        </label>
        <span class="help-block">When unchecked, this country and its cities and districts are hidden from filters on the home page and listing pages. URLs still work.</span>
    </div>
</fieldset>

<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading lang-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#country_tab_ar" data-toggle="tab">Arabic Section</a></li>
            <li><a href="#country_tab_en" data-toggle="tab">English Section</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">

            <div class="tab-pane fade in active" id="country_tab_ar">
                <fieldset>
                    <legend>Content Arabic</legend>
                    <div class="form-group col-md-6">
                        <label>H1</label>
                        <?= Form::text("h1_ar", $row->h1_ar, ["class" => "form-control"]); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Share Image</label>
                        @include('admin.layouts.media_input', [
                            "name" => "media_id",
                            "ids" => [$row->media_id]
                        ])
                        @if($row->media_id)
                        <small><a href="<?= route('admin.medias.edit', $row->media_id); ?>" target="_blank">Image Link</a></small>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Content</label>
                        @include('admin.layouts.full_editor', [
                            "name" => "content_ar",
                            "rows" => 8,
                            "editor_value" => $row->content_ar
                        ])
                    </div>
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Metatag Arabic</legend>
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <?= Form::text("seo_title_ar", $row->seo_title_ar, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <?= Form::textarea("seo_description_ar", $row->seo_description_ar, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>

            <div class="tab-pane fade" id="country_tab_en">
                <fieldset>
                    <legend>Content English</legend>
                    <div class="form-group col-md-6">
                        <label>H1</label>
                        <?= Form::text("h1_en", $row->h1_en, ["class" => "form-control ltr"]); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Share Image</label>
                        @include('admin.layouts.media_input', [
                            "name" => "media_en_id",
                            "ids" => [$row->media_en_id]
                        ])
                        @if($row->media_en_id)
                        <small><a href="<?= route('admin.medias.edit', $row->media_en_id); ?>" target="_blank">Image Link</a></small>
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label>Content</label>
                        @include('admin.layouts.full_editor', [
                            "name" => "content_en",
                            "rows" => 8,
                            "editor_value" => $row->content_en
                        ])
                    </div>
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Metatag English</legend>
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Description</label>
                                <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>

        </div>
    </div>
</div>

@include("admin.layouts.media_input_js")
@endsection
