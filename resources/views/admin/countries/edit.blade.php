@extends('admin.layouts.form', ["app_title" => "Countries", "app_desc" => ""])
@section('main_form')
<style>
</style>
<fieldset>
    <legend>Common Country Data</legend>
    <div class="form-group col-md-3">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control", "data-search-validation-root" => "true"]); ?>
        </div>
        <span class="help-block">Used in the URL, e.g. turkiye</span>
    </div>
    <div class="form-group col-md-3">
        <label>Code <span class="red">(*)</span></label>
        <?= Form::text("code", $row->code, ["class" => "form-control ltr"]); ?>
        <span class="help-block">Matches the old country string, e.g. turkey</span>
    </div>
    <div class="form-group col-md-3">
        <label>WhatsApp number</label>
        <?= Form::text("whatsapp_number", $row->whatsapp_number, ["class" => "form-control ltr", "placeholder" => "905551605000"]); ?>
        <span class="help-block">Used on this country's pages. Digits only, e.g. 905551605000</span>
    </div>
    <div class="form-group col-md-3">
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
            <li class="active"><a href="#country_tab_ar" data-toggle="tab">Arabic</a></li>
            <li><a href="#country_tab_en" data-toggle="tab">English</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">

            <div class="tab-pane fade in active" id="country_tab_ar">
                <fieldset>
                    <div class="form-group col-md-6">
                        <label>H1 Tag</label>
                        <?= Form::text("h1_ar", $row->h1_ar, ["class" => "form-control"]); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Name Arabic<span class="red">(*)</span></label>
                        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
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
                            "height" => 400,
                            "editor_value" => $row->content_ar
                        ])
                    </div>
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Metatag Arabic</legend>
                            <div class="form-group col-md-12">
                                <label>Title</label>
                                <?= Form::text("seo_title_ar", $row->seo_title_ar, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <?= Form::textarea("seo_description_ar", $row->seo_description_ar, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>
                        </fieldset>
                    </div>
                </fieldset>
            </div>

            <div class="tab-pane fade" id="country_tab_en">
                <fieldset>
                    <div class="form-group col-md-6">
                        <label>H1 Tag</label>
                        <?= Form::text("h1_en", $row->h1_en, ["class" => "form-control ltr"]); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Name English<span class="red">(*)</span></label>
                        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
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
                            "height" => 400,
                            "editor_value" => $row->content_en
                        ])
                    </div>
                    <div class="col-md-12">
                        <fieldset>
                            <legend>Metatag English</legend>
                            <div class="form-group col-md-12">
                                <label>Title</label>
                                <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-12">
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

<!-- Frontend required-field checks; supports TinyMCE, Select2 and language tabs. -->
<script>
$(function () {
    var countryField = document.querySelector('[data-search-validation-root]');
    if (!countryField || !countryField.form) return;
    var form = countryField.form;
    // Edit this list to choose which fields are required.
    var fields = [
    [
        "slug",
        "Slug"
    ],
    [
        "h1_ar",
        "Arabic H1 tag"
    ],
    [
        "h1_en",
        "English H1 tag"
    ],
    [
        "seo_title_ar",
        "Arabic meta title"
    ],
    [
        "seo_description_ar",
        "Arabic meta description"
    ],
    [
        "seo_title_en",
        "English meta title"
    ],
    [
        "seo_description_en",
        "English meta description"
    ],
    [
        "content_ar",
        "Arabic content"
    ],
    [
        "content_en",
        "English content"
    ]
];

    function editorFor(field) {
        return window.tinymce && field.id ? window.tinymce.get(field.id) : null;
    }

    function hasValue(field) {
        if (field.tagName === 'SELECT') {
            return Array.prototype.some.call(field.options, function (option) {
                return option.selected && option.value.trim() !== '';
            });
        }
        var editor = editorFor(field);
        var value = editor ? editor.getContent() : field.value;
        if (field.name === 'content_ar' || field.name === 'content_en' || field.name === 'about_ar' || field.name === 'about_en') {
            var container = document.createElement('div');
            container.innerHTML = value;
            // Images and other embedded content also count as content.
            if (container.querySelector('img, video, audio, iframe, object, embed, svg')) return true;
            value = container.textContent || '';
        }
        return value.replace(/[\s\u00a0\u200b-\u200f\ufeff]/g, '') !== '';
    }

    fields.forEach(function (item) {
        var field = form.elements.namedItem(item[0]);
        if (!field) return;
        var group = field.closest('.form-group');
        var label = group && group.querySelector('label');
        if (label && !label.querySelector('.red')) {
            var marker = document.createElement('span');
            marker.className = 'red';
            marker.textContent = ' (*)';
            label.appendChild(marker);
        }
    });

    // Validate before existing submit handlers run. Native required attributes
    // cannot reliably focus hidden TinyMCE textareas or inactive language tabs.
    form.addEventListener('submit', function (event) {
        if (window.tinymce) window.tinymce.triggerSave();
        form.querySelectorAll('[data-search-required-error]').forEach(function (message) {
            var group = message.closest('.form-group');
            if (group) group.classList.remove('has-error');
            message.remove();
        });
        var firstMissing = null;
        fields.forEach(function (item) {
            var field = form.elements.namedItem(item[0]);
            if (!field || hasValue(field)) return;
            if (!firstMissing) firstMissing = field;
            var group = field.closest('.form-group');
            var message = document.createElement('span');
            message.className = 'help-block';
            message.setAttribute('data-search-required-error', 'true');
            message.textContent = item[1] + ' is required.';
            if (group) {
                group.classList.add('has-error');
                group.appendChild(message);
            } else {
                field.parentNode.appendChild(message);
            }
        });
        if (!firstMissing) return;
        event.preventDefault();
        event.stopImmediatePropagation();
        var pane = firstMissing.closest('.tab-pane');
        if (pane) {
            var tab = $(form).find('a[data-toggle="tab"]').filter(function () {
                return this.getAttribute('href') === '#' + pane.id;
            });
            if (tab.length) tab.tab('show');
        }
        window.setTimeout(function () {
            var group = firstMissing.closest('.form-group') || firstMissing;
            group.scrollIntoView({behavior: 'smooth', block: 'center'});
            var editor = editorFor(firstMissing);
            if (editor) editor.focus();
            else if ($(firstMissing).hasClass('select2-hidden-accessible') || $(firstMissing).data('select2')) {
                $(firstMissing).select2('open');
            } else firstMissing.focus();
        }, 200);
    }, true);
});
</script>
@endsection
