<div class="clearfix"></div>
<div class="">
    <div class="col-md-12">
        <fieldset>
            <legend>Meta Tag</legend>
            <div class="form-group col-md-12">
                <label>Title</label>
                <?= Form::text("seo_title", $row->seo_title, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-12">
                <label>Description</label>
                <?= Form::text("seo_description", $row->seo_description, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-12">
                <label>Keywords</label>
                <?= Form::text("seo_keywords", $row->seo_keywords, ["class" => "form-control"]); ?>
            </div>
        </fieldset>
    </div>
</div>