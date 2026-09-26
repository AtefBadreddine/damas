<?php
if (!isset($contentRow) || !$contentRow) {
    $contentRow = (object) array(
        'title' => '',
        'content' => '',
        'title_en' => '',
        'content_en' => '',
    );
}
?>
<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading lang-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#geo_tab_ar" data-toggle="tab">Arabic Section</a></li>
            <li><a href="#geo_tab_en" data-toggle="tab">English Section</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">

            <div class="tab-pane fade in active" id="geo_tab_ar">
                <fieldset>
                    <legend>Content Arabic</legend>
                    <div class="form-group col-md-12">
                        <label>Title</label>
                        <?= Form::text("geo_title", $contentRow->title, ["class" => "form-control"]); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Text</label>
                        @include('admin.layouts.full_editor', [
                            "name" => "geo_content",
                            "rows" => 8,
                            "editor_value" => isset($contentRow->content) ? $contentRow->content : ''
                        ])
                    </div>
                </fieldset>
            </div>

            <div class="tab-pane fade" id="geo_tab_en">
                <fieldset>
                    <legend>Content English</legend>
                    <div class="form-group col-md-12">
                        <label>Title</label>
                        <?= Form::text("geo_title_en", $contentRow->title_en, ["class" => "form-control ltr"]); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Text</label>
                        @include('admin.layouts.full_editor', [
                            "name" => "geo_content_en",
                            "rows" => 8,
                            "editor_value" => isset($contentRow->content_en) ? $contentRow->content_en : ''
                        ])
                    </div>
                </fieldset>
            </div>

        </div>
    </div>
</div>
