@extends('admin.layouts.form', ["app_title" => "Keywords"])
@section('main_form')

<?php
/*echo $row->keyword_ar;
		exit;*/
		?>
<style>
    .dblocks input{

    }
    .dblocks .row{
        margin: 13px 0;
    }
    .delrow{float:right}
</style>
<?php //$row = 1; ?>
<fieldset>
    <!--    <legend>Add a New post</legend>-->
    <div class="col-md-12">
        <div class="panel with-nav-tabs panel-default">
            <div class="panel-heading">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1default" data-toggle="tab">Arabic Section</a></li>
                    <li><a href="#tab2default" data-toggle="tab">English Section</a></li>
                    <li><a href="#tab3default" data-toggle="tab">French Section</a></li>
                    <li><a href="#tab4default" data-toggle="tab">Persian Section</a></li>
                    <li><a href="#tab5default" data-toggle="tab">Russian Section</a></li>
                </ul>
            </div>
            <div class="panel-body">
                <div class="tab-content">

                    <!-- Section Arabic -->
                    <div class="tab-pane fade in active" id="tab1default">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Arabic Keyword</label>
                                <input class="form-control" placeholder="Arabic Keyword" value="<?= $row->keyword_ar ?>" name="keyword_ar" type="text">
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>URL</label>
                                <div class="input-group ltr">
                                    <span class="input-group-addon">URL</span>
                                    <input class="form-control input-sm" placeholder="URL" value="<?= $row->url ?>" name="url" type="url">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>Display in</label>
                            <select name="display[]" class="form-control select2me" multiple required>
                                <option value="projects" <?= strpos($row->display, ';projects;') !== false ?'selected':'' ?>>Projects</option>
								@foreach(\App\Models\PostCategory::orderBy('type','asc')->get() as $cat)
								<option value="<?= $cat->id ?>" <?= strpos($row->display, ';'. $cat->id .';') !== false ?'selected':'' ?>><?= $cat->name_en ?></option>
								@endforeach
                            </select>
                        </div>

                    </div>

                    <!-- Section English -->
                    <div class="tab-pane fade" id="tab2default">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>English Keyword</label>
                                <input class="form-control" placeholder="English Keyword" value="<?= $row->keyword_en ?>" name="keyword_en" type="text">
                            </div> 
                        </div>

                    </div>

                    <!-- Section Fr -->
                    <div class="tab-pane fade" id="tab3default">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>French Keyword</label>
                                <input class="form-control" placeholder="French Keyword" value="<?= $row->keyword_fr ?>" name="keyword_fr" type="text">
                            </div> 
                        </div>

                    </div>
                    <!-- Section Fa -->
                    <div class="tab-pane fade" id="tab4default">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Persian Keyword</label>
                                <input class="form-control" placeholder="Persian Keyword" value="<?= $row->keyword_fa ?>" name="keyword_fa" type="text">
                            </div> 
                        </div>

                    </div>




                    <!-- Section Ru -->
                    <div class="tab-pane fade" id="tab5default">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Russian Keyword</label>
                                <input class="form-control" placeholder="Russian Keyword" value="<?= $row->keyword_ru ?>" name="keyword_ru" type="text">
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

</script>
@endsection
