@extends('admin.layouts.form', ["app_title" => "Properties", "app_desc" => "Properties Information"])
@section('main_form')

<fieldset>
    <legend>Project</legend>
    <div class="form-group col-md-1">
        <label>ID <span class="red">(*)</span></label>
        <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6 hidden">
        <label>Arabic Name <span class="red">(*)</span></label>
        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
    </div>

    <div class="form-group col-md-3">
        <label>English Name <span class="red"></span></label>
        <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-3">
        <label>Arabic Name <span class="red"></span></label>
        <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control rtl"]); ?>
    </div>
	
    <div class="form-group col-md-3">
        <label>Company <span class="red"></span></label>
        <?= Form::text("company", $row->company, ["class" => "form-control ltr"]); ?>
    </div>

    <div class="form-group col-md-2">
        <label>Link <span class="red">(*)</span></label>
        <div class="input-group ltr">
            <span class="input-group-addon">projects/</span>
            <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm ltr"]); ?>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>General Information</legend>
    <div class="form-group col-md-4">
        <label>City <span class="red">(*)</span></label>
        <select name="city_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("City", "all") as $city)
                <option value="<?= $city->id; ?>" <?= $city->id == $row->city_id ? 'selected' : ''; ?>><?= $city->name_ar; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Project Type</label>
        <select name="projecttype_id[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("ProjectType", "all") as $typ)
                <option value="<?= $typ->id; ?>" <?= in_array($typ->id, $row->types()->lists('project_type_id')->toArray()) ? 'selected' : ''; ?>><?= $typ->name_ar; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Payment Method</label>
        <?= Form::select("payment_method", ["نقدي" => "نقدي", "تقسيط" => "تقسيط"], $row->payment_method, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Region</label>
        <select name="region_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("Region", "all") as $region)
                <option value="<?= $region->id; ?>" <?= $region->id == $row->region_id ? 'selected' : ''; ?>><?= $region->name_ar; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label>Delivered Date</label>
        <?= Form::text("delivered_date", $row->delivered_date, ["class" => "form-control date5"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Distance To Center</label>
        <?= Form::text("distance_center", $row->distance_center, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4">
        <label>Distance To Airport</label>
        <?= Form::text("distance_airport", $row->distance_airport, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-4" style="display:none">
        <label>Status</label>
        <?= Form::select("project_etat", [
            "قيد الإنشاء" => "قيد الإنشاء", "جاهز" => "جاهز", "جاهز - قيد الإنشاء" => "جاهز - قيد الإنشاء"
            ], $row->project_etat, ["class" => "form-control select2me"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Features</label>
        <select name="category_id[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("ProjectCategory", "all") as $category)
                <option value="<?= $category->id; ?>" <?= in_array($category->id, $row->categories()->lists('project_category_id')->toArray()) ? 'selected' : ''; ?>><?= $category->name_ar; ?></option>
            @endforeach
        </select>
    </div>
</fieldset>

<fieldset> 
    <legend>Provide Card</legend>
    <div class="form-group col-md-12">
        <label>Intro Card Arabic</label>
        <?= Form::text("intro_card_ar", $row->intro_card_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Intro Card English</label>
        <?= Form::text("intro_card_en", $row->intro_card_en, ["class" => "form-control ltr"]); ?>
    </div>
</fieldset>

<fieldset> 
    <legend>Media</legend>
    <div class="form-group col-md-12">
        <label>Project Images</label>
        @include('admin.layouts.media_input', [
            "name" => "project_photos",
            "multiple"  => true,
            "ids"    =>    $row->projectphotos()->lists('media_id')->toArray()
        ])
    </div>
    <div class="form-group col-md-4">
        <label>Card Images</label>
        @include('admin.layouts.media_input', [
            "name" => "card_photo_id",
            "ids"  => [$row->card_photo_id]
        ])
    </div>
    <div class="clearfix"></div>
    <div class="form-group col-md-6">
        <label>Youtube Video Link (Arabic)</label>
        <?= Form::text("linkvideo_ar", $row->linkvideo_ar, ["class" => "form-control ltr"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Youtube Video Link (English)</label>
        <?= Form::text("linkvideo_en", $row->linkvideo_en, ["class" => "form-control ltr"]); ?>
    </div>
</fieldset>

<fieldset>
    <legend>Project location and strategic importance (Arabic)</legend>
    <div class="form-group col-md-12">
        <label>Introduce</label>
        <?= Form::textarea("intro_location_ar", $row->intro_location_ar, ["class" => "form-control", "rows" => 5]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Location</label>
        <?= Form::textarea("location_ar", $row->location_ar, ["class" => "form-control", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Governmental institutions</label>
        <?= Form::textarea("governmental_ar", $row->governmental_ar, ["class" => "form-control", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Transportation</label>
        <?= Form::textarea("transportation_ar", $row->transportation_ar, ["class" => "form-control", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Future Look</label>
        <?= Form::textarea("future_look_ar", $row->future_look_ar, ["class" => "form-control", "rows" => 4]); ?>
    </div>
</fieldset>

<fieldset>
    <legend>Project location and strategic importance (English)</legend>
    <div class="form-group col-md-12">
        <label>Introduce</label>
        <?= Form::textarea("intro_location_en", $row->intro_location_en, ["class" => "form-control ltr", "rows" => 5]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Location</label>
        <?= Form::textarea("location_en", $row->location_en, ["class" => "form-control ltr", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Governmental institutions</label>
        <?= Form::textarea("governmental_en", $row->governmental_en, ["class" => "form-control ltr", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Transportation</label>
        <?= Form::textarea("transportation_en", $row->transportation_en, ["class" => "form-control ltr", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Future Look</label>
        <?= Form::textarea("future_look_en", $row->future_look_en, ["class" => "form-control ltr", "rows" => 4]); ?>
    </div>
</fieldset>

<fieldset>
    <legend>Facilities and Features of the Project</legend>
    <div class="form-group col-md-6">
        <label>Intro Features Arabic</label>
        <?= Form::textarea("intro_features_ar", $row->intro_features_ar, ["class" => "form-control", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Intro Features English</label>
        <?= Form::textarea("intro_features_en", $row->intro_features_en, ["class" => "form-control ltr", "rows" => 4]); ?>
    </div>
    <div class="form-group col-md-12">
        <label>Facilities and Features of the Project</label>
        <select name="feature_id[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("ProjectFeature", "all") as $feature)
                <option value="<?= $feature->id; ?>" <?= in_array($feature->id, $row->features()->lists('project_feature_id')->toArray()) ? 'selected' : ''; ?>><?= $feature->name_ar; ?></option>
            @endforeach
        </select>
    </div>
</fieldset>

<fieldset>
    <legend>Price Table</legend>
    <div class="form-group col-md-6">
        <label>Payment Method Arabic</label>
        <?= Form::text("paymentmethod_ar", $row->paymentmethod_ar, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-6">
        <label>Payment Method English</label>
        <?= Form::text("paymentmethod_en", $row->paymentmethod_en, ["class" => "form-control"]); ?>
    </div>
    <div class="form-group col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Price Details</b> 
                <button type="button" id="btn_dup_price" class="btn btn-default btn-xs btn-flat">Add New</button>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped m0" id="table_prices_content">
                        <thead>
                            <tr>
                                <th>Special Offer</th>
                                <th>Price TRY</th>
                                <th>Number of Rooms</th>
                                <th>Area</th>
                                <th>Number of Salons</th>
                                <!--<th>Date Created</th>-->
                                <th style="width:230px;">Notes Arabic</th>
                                <th style="width:230px;">Notes English</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($row->flavors as $key => $flavor)
                            <tr>
                                <td><input type="text" name="offer[]" value="<?= $flavor->offer; ?>" class="form-control input-sm"></td>
                                <td><input type="text" name="price[]" value="<?= $flavor->price; ?>" class="form-control input-sm"></td>
                                <td><input type="text" name="room[]" value="<?= $flavor->room; ?>" class="form-control input-sm"></td>
                                <td><input type="text" name="area[]" value="<?= $flavor->area; ?>" class="form-control input-sm"></td>
                                <td><input type="text" name="salon[]" value="<?= $flavor->salon; ?>" class="form-control input-sm"></td>
                                <!--<td><input type="text" name="date_created[]" value="<?= $flavor->date_created; ?>" class="form-control input-sm"></td>-->
                                <td><input type="text" name="observation[]" value="<?= $flavor->observation; ?>" class="form-control input-sm"></td>
                                <td><input type="text" name="observation_en[]" value="<?= $flavor->observation_en; ?>" class="form-control input-sm"></td>
                                <td><button type="button" class="btn btn-default btn-xs btn-flat btn_tr_delete"><i class="fa fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="form-group">
                    <label><input type="checkbox" name="is_price_usd" <?= $row->is_price_usd == 1 ? 'checked' : ''; ?>> Show the price directly in dollars without conversion</label>
                </div>
                <div>
                    <label>Images of Room Schemes </label>
                    @include('admin.layouts.media_input', [
                        "name" => "plan_photos",
                        "multiple"  => true,
                        "ids"    =>    $row->planPhotos()->lists('media_id')->toArray()
                    ])
                </div>
            </div>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>Sales Manager</legend>
    <div class="form-group col-md-6">
        <label>Arabic</label>
        <select name="salemanager_ar_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("SaleManager", "all") as $manager)
                <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_ar_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label>English</label>
        <select name="salemanager_en_id" class="form-control select2me">
            <option value=""></option>
            @foreach(Helper::query("SaleManager", "all") as $manager)
                <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_en_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
            @endforeach
        </select>
    </div>
</fieldset>

<fieldset>
    <legend>Related Articles and Projects</legend>
    <div class="form-group col-md-12">
        <label>Selected Articles(Arabic)</label>
        <select name="post_id[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("Post", "whereIn", ["field" => "lang", "value" => ["ar", "all"]])->get() as $post)
                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->posts()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_ar; ?></option>
            @endforeach
        </select>
    </div>
	<div class="form-group col-md-12">
        <label>Selected Articles(English)</label>
        <select name="post_en_id[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("Post", "whereIn", ["field" => "lang", "value" => ["en", "all"]])->get() as $post)
                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsEn()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_en; ?></option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-12">
        <label>Similar Projects</label>
        <select name="similar_projects[]" class="form-control select2me" multiple>
            <option value=""></option>
            @foreach(Helper::query("Project", "all") as $prj)
                <option value="<?= $prj->id; ?>" <?= in_array($prj->id, explode(",", $row->similar_projects)) ? 'selected' : ''; ?>><?= $prj->name_ar; ?></option>
            @endforeach
        </select>
    </div>
</fieldset>

<fieldset>
    <legend>Location and Coordinates</legend>
    <div class="form-group col-md-6">
        <label>Coordinates</label>
        <?= Form::text("dms_map", $row->dms_map, ["class" => "form-control ltr", "placeholder" => "41°07'29.8\"N 28°46'48.6\"E"]); ?>
    </div>
    <div class="form-group col-md-12">
       @include('admin.layouts.location_map')
    </div>
</fieldset>

<fieldset>
    <legend>Other Options</legend>
    <div class="form-group col-md-3">
        <label><input type="checkbox" name="published" <?= $row->published == 1 ? 'checked' : ''; ?>> Enabled</label>
    </div>
    <!--<div class="form-group col-md-3">
        <label><input type="checkbox" name="featured" <?= $row->featured == 1 ? 'checked' : ''; ?>> مميّز</label>
    </div>-->
</fieldset>

@include('admin.layouts.seo')

<!-- media js -->
@include('admin.layouts.media_input_js')

<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css">-->
<script>
$(function(){
    /*$("#btn_dup_price").on('click', function() {
        var dv = $("#tr_price").clone().removeClass('hidden').removeAttr('id').appendTo("#table_prices_content");
    });*/
    $(document).on("click", ".btn_tr_delete", function(){
        $(this).closest("tr").remove();
    });
    $(document).on("click", "#btn_dup_price", function(){
        var inputs = {};
        var trs = $("#table_prices_content tbody").find("tr").length;
        inputs["length"] = trs;        
        $.ajax({
            type: 'POST',
            url: '<?= route('admin.ajaxqueries'); ?>',
            data: {
                _token: '<?= csrf_token(); ?>',
                func: 'getTrPriceProject',
                inputs: inputs,
            }
        }).done(function(resp){
            $.getScript("<?= asset('admin/js/admin.js'); ?>");
            $("#table_prices_content tbody").append(resp);
            $("#ajaxloading").hide();
        });
        return false;
    });
});



$('.date5').datepicker({format: "yyyy-mm-dd"});

</script>


@endsection
