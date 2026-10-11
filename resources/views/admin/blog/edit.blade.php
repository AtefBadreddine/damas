@extends('admin.layouts.form', ["app_title" => isset($postType) ? $postType->label() : "Add a new post"])
@section('main_form')


<style>
    .select2-container {
        max-width: none !important;
    }
    label {
        display: block;
    }
</style>

<fieldset>
    <legend>Common {{ $postType->label() }} Data</legend>
    <div class="col-md-2">
        <div class="form-group">
            <label>Country</label>
            <select name="country_id" class="form-control select2me">
                <?php foreach ($countries as $country): ?>
                <option value="<?= $country->id ?>" <?= ((int)$row->country_id === (int)$country->id) ? 'selected' : '' ?>><?= $country->name_en ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Slug<span class="red">(*)</span></label>
            <div class="input-group ltr">
                <span class="input-group-addon">https://damas.net/{{ \DB::table('countries')->where('id', $row->country_id)->first()->slug ?: 'country' }}/{{strtolower($postType->label())}}/</span>
                <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm", "placeholder" => "Slug"]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="margin-top:25px;">
        <div class="form-group">
            <label class="enabled-section"><input type="checkbox" id="published" name="published" <?= $row->published == 1 ? 'checked' : ''; ?>> Enabled</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <div class="input-group ltr">
                <span class="input-group-addon" style="color:red;">Old slug</span>
                <?= Form::text("old_slug", $row->old_slug, ["class" => "form-control input-sm", "placeholder" => "Old slug (301 to current URL)"]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="enabled-section" style="color:red;"><input type="checkbox" id="prevent_archiving_in_blog" name="prevent_archiving_in_blog" <?= $row->prevent_archiving_in_blog == 1 ? 'checked' : ''; ?>>Add noindex Tag for Google</label>
        </div>
    </div>
</fieldset>

<fieldset>
    <!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
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
                        <input type="hidden" name="type" value="<?= $type ?>" >
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>H1 Tag</label>
                                <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control", "placeholder" => "Arabic Title"]); ?>
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Categories</label>
                                <select name="category_id[]" class="form-control select2me" multiple>
                                    <option value=""></option>
                                    @foreach(\App\Models\PostCategory::orderBy('placement', 'asc')->get() as $cat)
                                    <option value="<?= $cat->id; ?>" <?= in_array($cat->id, $row->categories()->lists('post_category_id')->toArray()) ? 'selected' : ''; ?>><?= $cat->getName(); ?></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tags</label>
                                <select name="tag_id[]" class="form-control select2me" multiple>
                                    <option value=""></option>
                                    @foreach(\App\Models\Tag::orderBy('placement', 'asc')->orderBy('id', 'asc')->get() as $cat)
                                    <option value="<?= $cat->id; ?>" <?= in_array($cat->id, $row->tags()->lists('tag_id')->toArray()) ? 'selected' : ''; ?> title="<?= $cat->title_en != '' ? $cat->title_en . "\n" : '' ?><?= $cat->title_ar != '' ? $cat->title_ar . "\n" : '' ?><?= $cat->title_fr != '' ? $cat->title_fr . "\n" : '' ?><?= $cat->title_pe != '' ? $cat->title_pe . "\n" : '' ?><?= $cat->title_ru != '' ? $cat->title_ru : '' ?>"><?= $cat->name; ?>
                                        (<?= $cat->title_ar != '' ? 'AR ' : '' ?><?= $cat->title_en != '' ? 'EN ' : '' ?><?= $cat->title_fr != '' ? 'FR ' : '' ?><?= $cat->title_fa != '' ? 'PE ' : '' ?><?= $cat->title_ru != '' ? 'RU ' : '' ?>)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Post Image</label>
                                @include("admin.layouts.media_input", [
                                "name"    =>    "media_id",
                                "ids"    =>    [$row->media_id]
                                ])
                            </div>
                        </div>

                        <div class="col-md-12 block_redirect col-md-offset-2 " style="padding-top: 20px;<?= ($row->published == 0 ? 'display:block' : 'display:none') ?>">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="enabled-section"><input type="checkbox" id="post_scheduling" name="post_scheduling" <?= $row->post_scheduling == 1 ? 'checked' : ''; ?>> Post scheduling</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <?= Form::text("post_scheduling_date", $row->post_scheduling_date, ["placeholder" => "Date Time", "class" => "form-control date5"]); ?>
                                </div>
                            </div>
                        </div>

                        @if(isset($row->id))
                        <div class="col-md-8 block_redirect col-md-offset-2 " style="<?= ($row->published == 0 ? 'display:block' : 'display:none') ?>">
                            <div class="form-group">
                                <label>Redirect Post:</label>
                                <select name="redirect_post_id" class="form-control select2me" >
                                    <option value="0"></option>
                                    <?php
                                    $posts = \App\Models\Post::where("published", 1)->where("type", $type)->where('id', '!=', $row->id)->where('title_ar', '!=', '')->get();
                                    ?>
                                    @foreach($posts as $post)
                                    <option value="<?= $post->id; ?>" <?= $post->id == $row->redirect_post_id ? 'selected' : '' ?>><?= $post->title_ar; ?></option>
                                    @endforeach
                                </select>
                            </div> 
                        </div>
                        @endif		
                        <div class="col-md-12">
                            <!--<legend>Featured Post</legend>-->
                            <div class="col-md-3" style="display:none">
                                <div class="form-group">
                                    <label>Website Version</label>
                                    <?= Form::select("lang", ["all" => "All", "ar" => "Arabic", "en" => "English", "fa" => "Persian"], $row->lang, ["class" => "form-control select2me"]); ?>
                                </div>
                            </div>


                            

                            




                            



                        </div>


                        <div class="form-group col-md-12">
                            <label>Content Arabic<span class="red">(*)</span></label>
                            @include("admin.layouts.full_editor", ["name" => "content_ar"])
                        </div>


                        <!-- seo ar -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
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


                    </div>

                    <!-- Section English -->
                    <div class="tab-pane fade" id="tab2default">
                        <div class="form-group col-md-12">
                            <label>H1 Tag</label>
                            <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr", "placeholder" => "English Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content English</label>
                            @include("admin.layouts.full_editor", ["name" => "content_en"])
                        </div>


                        <!-- seo eng -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
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


                    </div>

                    <!-- Section Fr -->
                    <div class="tab-pane fade" id="tab3default">
                        <div class="form-group col-md-12">
                            <label>H1 Tag</label>
                            <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content</label>
                            @include("admin.layouts.full_editor", ["name" => "content_fr"])
                        </div>


                        <!-- seo FR -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                <label>Title</label>
                                    <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                <label>Description</label>
                                    <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>
                            </fieldset>
                        </div>


                    </div>
                    <!-- Section Fa -->
                    <div class="tab-pane fade" id="tab4default">
                        <label>H1 Tag</label>
                        <div class="form-group col-md-12">
                            <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content</label>
                            @include("admin.layouts.full_editor", ["name" => "content_fa"])
                        </div>

                        <!-- seo FA -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                <label>Title</label>
                                    <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                <label>Description</label>
                                    <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>
                            </fieldset>
                        </div>
                    </div>




                    <!-- Section Ru -->
                    <div class="tab-pane fade" id="tab5default">
                        <div class="form-group col-md-12">
                            <label>H1 Tag</label>
                            <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Content</label>
                            @include("admin.layouts.full_editor", ["name" => "content_ru"])
                        </div>


                        <!-- seo RU -->
                        <div class="col-md-12">
                            <fieldset>
                                <legend>Metatag</legend>
                                <div class="form-group col-md-12">
                                    <label>Title</label>
                                    <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                                </div>

                            </fieldset>
                        </div>


                    </div>


                </div>
            </div>
        </div>
    </div>

</fieldset>
<link rel="stylesheet" href="<?= asset('admin/js/bootstrap-datetimepicker.css'); ?>">
<script src="<?= asset('admin/js/bootstrap-datetimepicker.js') ?>"></script>

@include("admin.layouts.media_input_js")

<script>
    $(document).on("ifChanged", "#published", function () {

        if ($(this).is(':checked'))
            $('.block_redirect').hide();
        else
            $('.block_redirect').show();

    });




    $('.date5').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
    });





</script>

<script>
$(function () {
    var countryField = document.querySelector('select[name="country_id"]');
    if (!countryField || !countryField.form) return;
    var form = countryField.form;
    var fields = [
        ['country_id', 'Country'],
        ['slug', 'Slug'],
        ['title_ar', 'Arabic H1 tag'],
        ['category_id[]', 'Categories'],
        ['content_ar', 'Arabic content'],
        ['title_en', 'English H1 tag'],
        ['content_en', 'English content'],
        ['seo_title_ar', 'Arabic meta title'],
        ['seo_description_ar', 'Arabic meta description'],
        ['seo_title_en', 'English meta title'],
        ['seo_description_en', 'English meta description']
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
        if (field.name === 'content_ar' || field.name === 'content_en') {
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
        field.setAttribute('aria-required', 'true');
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
        form.querySelectorAll('[data-post-required-error]').forEach(function (message) {
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
            message.setAttribute('data-post-required-error', 'true');
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
