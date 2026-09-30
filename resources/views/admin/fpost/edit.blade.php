@extends('admin.layouts.form', ["app_title" => "Featured Posts"])
@section('main_form')

<fieldset>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="fade in active" id="tab1default">
                    <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <div class="dblocks">
                                @foreach($countries as $country)
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><?= $country->name_en ?> Featured Posts</label>
                                        <select name="fposts[<?= $country->id ?>][]" class="form-control select2me" multiple>
                                            <option value=""></option>
                                            @foreach(\App\Models\Post::where('country_id', $country->id)->orderBy('post_type')->orderBy('title_ar')->get() as $post)
                                            <option value="<?= $post->id; ?>" <?= in_array($post->id, isset($featuredByCountry[$country->id]) ? $featuredByCountry[$country->id] : array()) ? 'selected' : ''; ?>><?= $post->title_ar; ?> (<?= $post->post_type ? $post->post_type : $post->type; ?>)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>

@endsection
