<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <fieldset>
                <div class="col-md-12">
                    <!-- seo ar -->
                    <div class="col-md-4">
                        <fieldset>
                            <legend>Metatag Arabic</legend>
                            <div class="form-group col-md-12">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_ar", $row->seo_title_ar, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_ar", $row->seo_description_ar, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-12" style="">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_ar", $row->seo_keywords_ar, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
                    <!-- seo eng -->
                    <div class="col-md-4">
                        <fieldset>
                            <legend>English</legend>
                            <div class="form-group col-md-12">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-12">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_en", $row->seo_keywords_en, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
                    <!-- seo FR -->
                    <div class="col-md-4">
                        <fieldset>
                            <legend>FRENCH</legend>
                            <div class="form-group col-md-12">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-12">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_fr", $row->seo_keywords_fr, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
                    <!-- seo FA -->
                    <div class="col-md-4">
                        <fieldset>
                            <legend>PERSIAN</legend>
                            <div class="form-group col-md-12">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-12">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_fa", $row->seo_keywords_fa, ["class" => "form-control text-align-right", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
					
					
                    <!-- seo FR -->
                    <div class="col-md-4">
                        <fieldset>
                            <legend>RUSSIAN</legend>
                            <div class="form-group col-md-12">
                                <!--                            <label>Title</label>-->
                                <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control ltr", "placeholder" => "Title"]); ?>
                            </div>
                            <div class="form-group col-md-12">
                                <!--                            <label>Description</label>-->
                                <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control ltr", "rows" => 5, "placeholder" => "Description"]); ?>
                            </div>

                            @if(@$hide_keywords==false)
                            <div class="form-group col-md-12">
                                <!--                            <label>Keywords</label>-->
                                <?= Form::text("seo_keywords_ru", $row->seo_keywords_ru, ["class" => "form-control ltr", "placeholder" => "Keywords"]); ?>
                            </div>
                            @endif
                        </fieldset>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>

