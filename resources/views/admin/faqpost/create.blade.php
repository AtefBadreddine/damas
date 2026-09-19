@extends('admin.layouts.form', ["app_title" => "Add FAQ Category"])
@section('main_form')



<style>
    .dblocks input{

    }
    .dblocks .row{
        margin: 0;
    }
</style>
<?php
$posts = Helper::query("Post", "all");
?>
<fieldset>
    <!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-body">
                <div class="">

                    <!-- Section Arabic -->
                    <div class="tab-pane fade in active" id="tab1default">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Title Arabic<span class="red">(*)</span></label>
                                <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control", "placeholder" => "Arabic Title"]); ?>
                            </div> 
                        </div>
                        <div class="form-group col-md-4">
                            <label>Title English</label>
                            <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr", "placeholder" => "English Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Title Frensh</label>
                            <?= Form::text("title_fr", $row->title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Title Persian</label>
                            <?= Form::text("title_fa", $row->title_fa, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                        </div>
						
                        <div class="form-group col-md-4">
                            <label>Title Russian</label>
                            <?= Form::text("title_ru", $row->title_ru, ["class" => "form-control ltr", "placeholder" => "Title Ru"]); ?>
                        </div>
						
                        <div class="col-md-4">
                            <div class="form-group">
                                <!----><label>Slug<span class="red">(*)</span></label>
                                <div class="input-group ltr">
                                    <span class="input-group-addon"><?= url('/faq') . "/" ?></span>
                                    <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm", "placeholder" => "Slug"]); ?>
                                </div>
                            </div>
                        </div>
                        <!--<div class="col-md-2">
                            <div class="form-group">
                                <label class="enabled-section"><input type="checkbox" name="published" <?php //$row->published == 1 ? 'checked' : '';   ?>> Enabled</label>
                            </div>
                        </div>-->
                        <div class="form-group col-md-6">
                            <label>Icon</label>
                            <?= Form::text("icon", $row->icon, ["class" => "form-control ltr", "placeholder" => "Icon"]); ?>
                        </div>

                        <div class="col-md-6">


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Image Card</label>
                                    @include("admin.layouts.media_input", [
                                    "name"    =>    "media_id",
                                    "ids"    =>    [$row->media_id]
                                    ])
                                </div>
                            </div>
                        </div>





                        <div class="col-md-12">
                            <div class="form-group">
                                <h3>Questions?</h3>
                                        <!--<span>Question</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span>Answer</span>-->
                                <div class="dblocks">
                                    <?php
                                    //$rows = DB::select("select * from dms_faq order by id asc");

                                    foreach ($faqs as $r) {
                                        ?>
                                        <div class="row add_question_sec">
                                            <div class="col-md-3">
                                                <input  class="form-control" type="text" name="q_ar[]" placeholder="Question (Ar)" value="<?= $r->q_ar ?>" />
                                                <textarea class="form-control" name="r_ar[]" placeholder="Answer (Ar)"><?= $r->r_ar ?></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <input  class="form-control" type="text" name="q_en[]" placeholder="Question (En)" value="<?= $r->q_en ?>" />
                                                <textarea class="form-control" name="r_en[]" placeholder="Answer (En)"><?= $r->r_en ?></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <input  class="form-control" type="text" name="q_fr[]" placeholder="Question (Fr)" value="<?= $r->q_fr ?>" />
                                                <textarea class="form-control" name="r_fr[]" placeholder="Answer (Fr)"><?= $r->r_fr ?></textarea>
                                            </div>
                                            <div class="col-md-3">
                                                <input  class="form-control" type="text" name="q_fa[]" placeholder="Question (Pe)" value="<?= $r->q_fa ?>" />
                                                <textarea class="form-control" name="r_fa[]" placeholder="Answer (Pe)"><?= $r->r_fa ?></textarea>
                                            </div>
                                            <input type="button" value="x" class="delrow" />

                                            <div class="col-md-3">
                                                <input  class="form-control" type="text" name="q_ru[]" placeholder="Question (Ru)" value="<?= $r->q_ru ?>" />
                                                <textarea class="form-control" name="r_ru[]" placeholder="Answer (Ru)"><?= $r->r_ru ?></textarea>
                                            </div>
											<div class="form-group col-md-6" style="float:right">
												<input type="hidden" value="<?= $r->str_posts ?>" class="str_posts" name="str_posts[]" />
													<select name="posts[]" placeholder="Posts" class="form-control select2me" multiple>
													<option value=""></option>
													@foreach($posts as $sec)
													<option value="<?= $sec->id; ?>" <?= in_array($sec->id, explode(',',$r->str_posts)) ? 'selected' : ''; ?>><?php
													if(trim($sec->title_ar)!='')
														echo $sec->title_ar;
													elseif(trim($sec->title_en)!='')
														echo $sec->title_en;
													elseif(trim($sec->title_fr)!='')
														echo $sec->title_fr;
													elseif(trim($sec->title_fa)!='')
														echo $sec->title_fa;
													elseif(trim($sec->title_ru)!='')
														echo $sec->title_ru;
													?></option>
													@endforeach
												</select>
											</div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <input class="btn btn-primary" type="button" id="addrow" value="Add +">	
                            </div>
                        </div>





                        @include("admin.layouts.seo")
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
                '<input  class="form-control" type="text" name="q_ar[]" placeholder="Question (Ar)" />' +
                '<textarea class="form-control" name="r_ar[]" placeholder="Answer (Ar)"></textarea>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input  class="form-control" type="text" name="q_en[]" placeholder="Question (En)" />' +
                '<textarea class="form-control" name="r_en[]" placeholder="Answer (En)"></textarea>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input  class="form-control" type="text" name="q_fr[]" placeholder="Question (Fr)" />' +
                '<textarea class="form-control" name="r_fr[]" placeholder="Answer (Fr)"></textarea>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input  class="form-control" type="text" name="q_fa[]" placeholder="Question (Fa)" />' +
                '<textarea class="form-control" name="r_fa[]" placeholder="Answer (Fa)"></textarea>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<input  class="form-control" type="text" name="q_ru[]" placeholder="Question (Ru)" />' +
                '<textarea class="form-control" name="r_ru[]" placeholder="Answer (Ru)"></textarea>' +
                '</div>' +
                '<input type="button" value="x" class="delrow" />' +
				'<div class="form-group col-md-6" style="float:right">' +
				'<input type="hidden" value="" class="str_posts" name="str_posts[]" />'+
				'<select name="posts[]" placeholder="Posts" class="form-control select2me" multiple>' +
					'<option value=""></option>'+
					@foreach($posts as $sec)
					'<option value="<?= $sec->id; ?>">'+'<?php
					if(trim($sec->title_ar)!='')
						echo $sec->title_ar;
					elseif(trim($sec->title_en)!='')
						echo $sec->title_en;
					elseif(trim($sec->title_fr)!='')
						echo $sec->title_fr;
					elseif(trim($sec->title_fa)!='')
						echo $sec->title_fa;
					?>'+
					'</option>'+
					@endforeach
				'</select>'+
			'</div>'+
                '</div>' +
                '</div>');
		$('select.select2me').select2();
    });

    $('body').on('change', 'select[name="posts[]"]', function () {
        $(this).parent('div').children('.str_posts').val(','+$(this).val()+',');
	});
    $('body').on('click', '.delrow', function () {
        $(this).parent('.row').remove();
    });
</script>
@endsection
