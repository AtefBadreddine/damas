@extends('admin.layouts.form', ["app_title" => "Cities", "app_desc" => ""])
@section('main_form')
<?php
$countries = \App\Models\Country::ordered()->get();
$selectedCountryId = old('country_id', $row->country_id);
$posts = \App\Models\Post::where('title_ar', '!=', '')->get();
?>
<style>
#city-form fieldset{min-width:0;clear:both;margin-bottom:20px}
#city-form fieldset:after{content:"";display:table;clear:both}
#city-form .city-row{display:flex;flex-wrap:wrap;margin-left:-15px;margin-right:-15px}
#city-form .city-row > [class*="col-"]{float:none}
#city-form .city-language-tabs{display:flex;flex-wrap:wrap}
#city-form .city-language-tabs > li{float:none}
#city-form .city-language-tabs > li > a{white-space:nowrap}
@media(max-width:991px){#city-form .city-row > [class*="col-md-"]{width:100%}}
.select-medias {
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
}
input[name=slug] {
    max-width: 150px;
}
.form-group.col-md-6:nth-of-type(4) {
    display: flex;
    flex-direction: column;
}
label {
    display: block;
}
</style>

<div id="city-form">
<fieldset>
    <legend>Common City Data</legend>
    <div class="form-group col-md-6">
        <label for="city-country-id" style="display:block">Country <span class="red">(*)</span></label>
        <select name="country_id" id="city-country-id" class="form-control select2me">
            <option value=""></option>
            @foreach($countries as $country)
            <option value="{{ $country->id }}" data-code="{{ $country->code }}" data-slug="{{ $country->slug }}" {{ $selectedCountryId == $country->id ? 'selected' : '' }}>{{ $country->name_en }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label>Slug <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon" id="city-slug-prefix">https://damas.net/country/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control", "data-search-validation-root" => "true"]); ?>
        </div>
    </div>
</fieldset>

<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading lang-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1default" data-toggle="tab">Arabic</a></li>
            <li><a href="#tab2default" data-toggle="tab">English</a></li>
            <li><a href="#tab3default" data-toggle="tab">French</a></li>
            <li><a href="#tab4default" data-toggle="tab">Persian</a></li>
            <li><a href="#tab5default" data-toggle="tab">Russian</a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div class="tab-content">
        <!-- Section Arabic -->
        <div class="tab-pane fade in active" id="tab1default">

<fieldset>
    <div class="form-group col-md-6">
        <label >H1 Tag<span class="red">(*)</span></label>
        <?= Form::text("h1_ar", $row->h1_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name Arabic<span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control", "dir" => "rtl"]); ?>
    </div>
	<div class="form-group col-md-6">
        <label>Link Preview Image</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_id",
            "ids"   =>	[$row->media_id]
        ])
        @if($row->media_id)
        <small><a href="<?= route('admin.medias.edit', $row->media_id); ?>" target="_blank">Image Link</a></small>
        @endif
    </div>
	<div class="form-group col-md-6">
        <label >Bring Content From Post</label>
        <select name="post_id" class="form-control select2me" >
			<option value="0"></option>
			@foreach($posts as $post)
				<option value="<?= $post->id; ?>" <?= $post->id == $row->post_id ? 'selected':'' ?>><?= $post->title_ar; ?></option>
			@endforeach
		</select>
    </div>

<div class="form-group col-md-12">
    <label >Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_ar", "editor_value" => $row->about_ar])
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

        <!-- Section English -->
        <div class="tab-pane fade" id="tab2default">

<fieldset>
    <div class="form-group col-md-6">
        <label >H1 Tag<span class="red">(*)</span></label>
        <?= Form::text("h1_en", $row->h1_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name English<span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control", "dir" => "ltr"]); ?>
    </div>
<div class="form-group col-md-3">
    <label>Share Image(English)</label>
    @include('admin.layouts.media_input', [
        "name"	=>	"media_en_id",
        "ids"   =>	[$row->media_en_id]
    ])
    @if($row->media_en_id)
    <small><a href="<?= route('admin.medias.edit', $row->media_en_id); ?>" target="_blank">Image Link</a></small>
    @endif
</div>
<div class="form-group col-md-12">
    <label >Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_en", "editor_value" => $row->about_en])
</div>
<!-- seo eng -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>English</legend>
                        <div class="form-group col-md-12">
                            <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>
                    </fieldset>
                </div>

</fieldset>



        </div>

        <!-- Section French -->
        <div class="tab-pane fade" id="tab3default">

<fieldset>
    <div class="form-group col-md-6">
        <label >H1 Tag<span class="red">(*)</span></label>
        <?= Form::text("h1_fr", $row->h1_fr, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name French<span class="red">(*)</span></label>
        <?= Form::text("name_fr", $row->name_fr, ["class" => "form-control", "dir" => "ltr"]); ?>
    </div>
<div class="form-group col-md-3">
    <label>Share Image(French)</label>
    @include('admin.layouts.media_input', [
        "name"	=>	"media_fr_id",
        "ids"   =>	[$row->media_fr_id]
    ])
    @if($row->media_fr_id)
    <small><a href="<?= route('admin.medias.edit', $row->media_fr_id); ?>" target="_blank">Image Link</a></small>
    @endif
</div>
<div class="form-group col-md-12">
    <label >Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_fr", "editor_value" => $row->about_fr])
</div>
<!-- seo FR -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>FRENCH</legend>
                        <div class="form-group col-md-12">
                            <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>
                    </fieldset>
                </div>

</fieldset>

</div>
            <!-- Section Farisi -->
            <div class="tab-pane fade" id="tab4default">

<fieldset>
    <div class="form-group col-md-6">
        <label >H1 Tag<span class="red">(*)</span></label>
        <?= Form::text("h1_fa", $row->h1_fa, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name Persian<span class="red">(*)</span></label>
        <?= Form::text("name_fa", $row->name_fa, ["class" => "form-control", "dir" => "rtl"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Share Image(Persian)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_fa_id",
            "ids"   =>	[$row->media_fa_id]
        ])
        @if($row->media_fa_id)
        <small><a href="<?= route('admin.medias.edit', $row->media_fa_id); ?>" target="_blank">Image Link</a></small>
        @endif
    </div>

<div class="form-group col-md-12">
    <label >Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_fa", "editor_value" => $row->about_fa])
</div>
<!-- seo FA -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>PERSIAN</legend>
                        <div class="form-group col-md-12">
                            <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>
                    </fieldset>
                </div>

</fieldset>
</div>

<!-- Section Russian -->

<div class="tab-pane fade" id="tab5default">

<fieldset>
    <div class="form-group col-md-6">
        <label >H1 Tag<span class="red">(*)</span></label>
        <?= Form::text("h1_ru", $row->h1_ru, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Name Russian<span class="red">(*)</span></label>
        <?= Form::text("name_ru", $row->name_ru, ["class" => "form-control", "dir" => "ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Share Image(Russian)</label>
        @include('admin.layouts.media_input', [
            "name"	=>	"media_ru_id",
            "ids"   =>	[$row->media_ru_id]
        ])
        @if($row->media_ru_id)
        <small><a href="<?= route('admin.medias.edit', $row->media_ru_id); ?>" target="_blank">Image Link</a></small>
        @endif
    </div>

<div class="form-group col-md-12">
    <label >Content</label>
    @include('admin.layouts.full_editor', ["name" => "about_ru", "editor_value" => $row->about_ru])
</div>
<!-- seo RU -->
                <div class="col-md-12">
                    <fieldset>
                        <legend>Russian</legend>
                        <div class="form-group col-md-12">
                            <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control text-align-left", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control text-align-left", "rows" => 5, "placeholder" => "Description"]); ?>
                        </div>
                    </fieldset>
                </div>

</fieldset>
</div>

    </div>
</div>

</div>
</div>

@include("admin.layouts.tinymce_js")
@include("admin.layouts.media_input_js")
<script>
(function () {
    function syncCountry() {
        var country = document.getElementById('city-country-id');
        var prefix = document.getElementById('city-slug-prefix');
        if (!country || !prefix) return;
        var option = country.options[country.selectedIndex];
        prefix.textContent = 'https://damas.net/' + (option ? option.getAttribute('data-slug') || 'country' : 'country') + '/';
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncCountry);
    } else {
        syncCountry();
    }
    var country = document.getElementById('city-country-id');
    if (country) country.addEventListener('change', syncCountry);
})();
</script>

<!-- Frontend required-field checks; supports TinyMCE, Select2 and language tabs. -->
<script>
$(function () {
    var countryField = document.querySelector('[data-search-validation-root]');
    if (!countryField || !countryField.form) return;
    var form = countryField.form;
    // Edit this list to choose which fields are required.
    var fields = [
    [
        "country_id",
        "Country"
    ],
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
        "about_ar",
        "Arabic content"
    ],
    [
        "about_en",
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
