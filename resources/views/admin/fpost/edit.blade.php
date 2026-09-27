@extends('admin.layouts.form', ["app_title" => "Featured Posts"])
@section('main_form')

<?php $row = 1; ?>
<fieldset>
    <!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
            

                    <!-- Section Arabic -->
                    <div class=" fade in active" id="tab1default">

                       

                        <div class="col-md-12">










                            <div class="form-group col-md-12">
                                
                                        <!--<span>Question</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>Answer</span>-->
                                <div class="dblocks">
								
								<div class="col-md-12">
                                <!--                            <legend>Similar Posts</legend>-->
                                <div class="form-group">
                                    <label>TR Featured Posts</label>
                                    <select name="fposts[]" class="form-control select2me" multiple>
                                        <option value=""></option>
                                        @foreach(Helper::query("Post", "all")->where('country','turkey')->where('post_type', \App\Enums\PostType::$BLOG->value) as $post)
                                        <option value="<?= $post->id; ?>" <?= in_array($post->id, $rows) ? 'selected' : ''; ?>><?= $post->title_ar; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <!--                            <legend>Similar Posts</legend>-->
                                <div class="form-group">
                                    <label>OM Featured Posts</label>
                                    <select name="fposts_om[]" class="form-control select2me" multiple>
                                        <option value=""></option>
                                        @foreach(Helper::query("Post", "all")->where('country','oman')->where('post_type', \App\Enums\PostType::$BLOG->value) as $post)
                                        <option value="<?= $post->id; ?>" <?= in_array($post->id, $rows_om) ? 'selected' : ''; ?>><?= $post->title_ar; ?></option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                                </div>
                               
                            </div>




                        </div>



                    </div>


               
            </div>
        </div>
    </div>

</fieldset>



@include("admin.layouts.media_input_js")
<script>
    $('#addrow').click(function () {
        $('.dblocks').append('<div class="row add_question_sec">' +
                '<div class="col-md-3">' +
                '<input  class="form-control" style="direction:rtl" type="text" name="title_ar[]" placeholder="Title (Ar)" value="" />' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input  class="form-control" style="direction:rtl" type="text" name="title_fa[]" placeholder="Title (Pe)" value="" />' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input  class="form-control" type="text" name="title_en[]" placeholder="Title (En)" value="" />' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input  class="form-control" type="text" name="title_fr[]" placeholder="Title (Fr)" value="" />' +
                '</div>' +
                '<input type="button" value="x" class="delrow" />' +
                '</div>');
    });

    $('body').on('click', '.delrow', function () {
        $(this).parent('.row').remove();
    });
</script>
@endsection
