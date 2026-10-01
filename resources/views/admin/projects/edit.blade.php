@extends('admin.layouts.form', ["app_title" => "Add a new property"])
@section('main_form')


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">

<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css">-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/plugins/piexif.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.1/js/fileinput.min.js"></script>
<style>
    .file-preview {
        border: 0px;
        padding: 0px;
        margin-bottom: 0px;
    }
    .file-preview .fileinput-remove {
        display: none;
    }
    .file-drop-zone {
        border: 0px;
        margin: 0px 0px 0px 0px;
        padding: 0px;
    }
    .file-drop-zone .file-preview-thumbnails,
    .file-drop-zone-title {
        display: none;
    }
    .section-video{
        float: left;
        width: 100%;
        position: relative;
    }
    .section-video.sub{
        margin-top: 15px;
    }
    .section-youtube.sub{
        margin-top: 15px;
    }
    .section-video .add-video-btn{
        position: absolute;
        top: 17px;
        right: -16px;
        font-size: 30px;
        color: #000000;
        cursor: pointer;
    }
    .section-video .add-video-btn:hover{
        opacity: 0.6;
    }
    .section-sub-video{
        float: left;
        width: 100%;
        position: relative;
    }
    .remove-video-btn{
        position: absolute;
        right: -13px;
        top: 6px;
        font-size: 16px;
        color: red;
        cursor: pointer;
        opacity: 0.6;
    }
    .remove-video-btn:hover{
        color: red;
        opacity: 1;
    }
    .relatedArticlesEn .select2-choices{
        min-height: 109px;
        max-height: 109px;
        overflow-y: auto;
    }
    .remove-video-ajax {
        position: absolute;
        right: -13px;
        top: 6px;
        font-size: 16px;
        color: red;
        cursor: pointer;
        opacity: 0.6;
    }
    .section-youtube {
        float: left;
        width: 100%;
        position: relative;
    }
</style>


<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading lang-heading">
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
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Basic Information
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <!--                                <div class="col-md-12">
                                                                    <h2 class="new-title">Basic Information</h2>
                                                                </div>-->
                                <fieldset class="background-section">


                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                    <label>Name (AR) <span class="red">(*)</span></label>
                                                    <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control", "required" => "required"]); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                    <label>Title (AR)</label>
                                                    <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                    <label>Project Link <span class="red"></span></label>
                                                    <?= Form::text("project_link", $row->project_link, ["class" => "form-control"]); ?>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <div class="form-group">
                                                    <label>Company</label>
                                                    <select name="companies[]" class="form-control select2me" multiple required>
                                                        <option value=""></option>
                                                        @foreach(Helper::query("Company", "all") as $typ)
                                                        <option value="<?= $typ->id; ?>" <?= in_array($typ->id, $row->companies()->lists('company_id')->toArray()) ? 'selected' : ''; ?>><?= $typ->company_name; ?></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <div class="form-group">
                                                    <label>Slug <span class="red">(*)</span></label>
                                                    <div class="input-group ltr">
                                                        <span class="input-group-addon">projects/</span>
                                                        <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm ltr"]); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <div class="form-group">
                                                    <label>Old Slug</label>
                                                    <div class="input-group ltr">
                                                        <span class="input-group-addon">projects/</span>
                                                        <?= Form::text("old_slug", $row->old_slug, ["class" => "form-control input-sm ltr", "placeholder" => "Old slug (301 to current URL)"]); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <div class="form-group">
                                                    <label class="enabled-project"><input type="checkbox" name="published" <?= $row->published == 1 ? 'checked' : ''; ?>> Enabled</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>




                                    <!--<div class="form-group col-md-2">
                                        <div class="form-group">
                                            <label>Company Name<span class="red"></span></label>
                                    <?= Form::text("company", $row->company, ["class" => "form-control ltr"]); ?>
                                        </div>
                                    </div>-->



                                    <div class="col-md-12">
                                        <div class="row">


                                            <?php
                                            $countryCodeToId = array();
                                            foreach ($countries as $countryItem) {
                                                $countryCodeToId[$countryItem->code] = (int) $countryItem->id;
                                            }
                                            ?>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Country</label>
                                                    <select id="project_filter_country" class="form-control select2me">
                                                        <option value=""></option>
                                                        @foreach($countries as $country)
                                                        <option value="<?= $country->id; ?>" <?= (int) $initialCountryId === (int) $country->id ? 'selected' : ''; ?>><?= $country->name_en; ?></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>City <span class="red">(*)</span></label>
                                                    <select name="city_id" id="project_city_id" class="form-control select2me">
                                                        <option value=""></option>
                                                        @foreach(Helper::query("City", "all") as $city)
                                                        <?php
                                                        $cityCountryId = (int) $city->country_id;
                                                        ?>
                                                        <option value="<?= $city->id; ?>" data-country-id="<?= $cityCountryId; ?>" <?= $city->id == $row->city_id ? 'selected' : ''; ?>><?= $city->name_ar; ?></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>District</label>
                                                    <select name="region_id" id="project_region_id" class="form-control select2me">
                                                        <option value=""></option>
                                                        @foreach(Helper::query("Region", "all") as $region)
                                                        <option value="<?= $region->id; ?>" data-city-id="<?= (int) $region->city_id; ?>" <?= $region->id == $row->region_id ? 'selected' : ''; ?>><?= $region->name_ar; ?></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Distance To Center</label>
                                                    <?= Form::text("distance_center", $row->distance_center, ["class" => "form-control"]); ?>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Card Intro</label>
                                                    <?= Form::text("intro_card_ar", $row->intro_card_ar, ["class" => "form-control"]); ?>
                                                </div>
                                            </div>



                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Similar Projects</label>
                                                    <select name="similar_projects[]" class="form-control select2me" multiple>
                                                        <option value=""></option>
                                                        @foreach(Helper::query("Project", "all") as $prj)
                                                        <option value="<?= $prj->id; ?>" <?= in_array($prj->id, explode(",", $row->similar_projects)) ? 'selected' : ''; ?>><?= $prj->name_ar; ?></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Related Articles</label>
                                                    <select name="post_id[]" class="form-control select2me" multiple>
                                                        <option value=""></option>
                                                        <?php
                                                        $posts = \App\Models\Post::where("published", 1)->where('title_ar', '!=', '')->get();
                                                        ?>
                                                        @foreach($posts as $post)
                                                        <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->posts()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_ar; ?></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Project Type</label>
                                                    <select name="projecttype_id[]" class="form-control select2me" multiple>
                                                        <option value=""></option>
                                                        @foreach(Helper::query("ProjectType", "all") as $typ)
                                                        <option value="<?= $typ->id; ?>" <?= in_array($typ->id, $row->types()->lists('project_type_id')->toArray()) ? 'selected' : ''; ?>><?= $typ->name_ar; ?></option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php /*
                                      <div class="col-md-3">
                                      <div class="form-group">
                                      <label>Delivery Date</label>
                                      <?= Form::text("delivered_date", $row->delivered_date, ["class" => "form-control date5"]); ?>
                                      </div>
                                      </div> */ ?>

                                    <!--                                    <div class="col-md-3" style="display:none">
                                                                            <div class="form-group">
                                                                                <label>Distance To Airport</label>
                                    <?= Form::text("distance_airport", $row->distance_airport, ["class" => "form-control", "disabled"]); ?>
                                                                            </div>
                                                                        </div>-->
                                    <!--                                    <div class="col-md-3" style="display:none">
                                                                            <div class="form-group col-md-4" style="display:none">
                                                                                <label>Status</label>
                                    <?=
                                    Form::select("project_etat", [
                                        "قيد الإنشاء" => "قيد الإنشاء", "جاهز" => "جاهز", "جاهز - قيد الإنشاء" => "جاهز - قيد الإنشاء"
                                            ], $row->project_etat, ["class" => "form-control select2me"]);
                                    ?>
                                                                            </div>
                                                                        </div>-->
                                    <?php /*
                                      <div class="col-md-3">
                                      <div class="form-group">
                                      <label>Advantages</label>
                                      <select name="category_id[]" class="form-control select2me" multiple>
                                      <option value=""></option>
                                      @foreach(Helper::query("ProjectCategory", "all") as $category)
                                      <option value="<?= $category->id; ?>" <?= in_array($category->id, $row->categories()->lists('project_category_id')->toArray()) ? 'selected' : ''; ?>><?= $category->name_ar; ?></option>
                                      @endforeach
                                      </select>
                                      </div>
                                      </div> */ ?>

                                    <!--                                    <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label>Agent</label>
                                                                                <select name="salemanager_ar_id" class="form-control select2me">
                                                                                    <option value=""></option>
                                                                                    @foreach(Helper::query("SaleManager", "all") as $manager)
                                                                                    <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_ar_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div> 
                                                                        </div>-->








                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Overview & Details
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <fieldset class="background-section">

                                    <div class="col-md-6">
                                        <!--                                        <div class="form-group">
                                                                                    <label>Intro</label>
                                        <?= Form::textarea("intro_features_ar", $row->intro_features_ar, ["class" => "form-control text-align-right", "rows" => 4]); ?>
                                                                                </div>-->
                                        <div class="form-group">
                                            <label>Overview</label>
                                            <?= Form::textarea("intro_location_ar", $row->intro_location_ar, ["class" => "form-control text-align-right", "rows" => 5]); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Facilities</label>
                                            <select name="feature_id[]" class="form-control select2me" multiple>
                                                <option value=""></option>
                                                @foreach(Helper::query("ProjectFeature", "all") as $feature)
                                                <option value="<?= $feature->id; ?>" <?= in_array($feature->id, $row->features()->lists('project_feature_id')->toArray()) ? 'selected' : ''; ?>><?= $feature->name_ar; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <hr>


                                    <!--                    <div class="col-md-12">
                                                            <legend>Project location and strategic importance (Arabic)</legend>
                                                        </div>-->


                                    <!--                                    <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Location</label>
                                    <?= Form::textarea("location_ar", $row->location_ar, ["class" => "form-control text-align-right", "rows" => 4]); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Nearby institutions</label>
                                    <?= Form::textarea("governmental_ar", $row->governmental_ar, ["class" => "form-control text-align-right", "rows" => 4]); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Transportation</label>
                                    <?= Form::textarea("transportation_ar", $row->transportation_ar, ["class" => "form-control text-align-right", "rows" => 4]); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label>Future Look</label>
                                    <?= Form::textarea("future_look_ar", $row->future_look_ar, ["class" => "form-control text-align-right", "rows" => 4]); ?>
                                                                            </div>
                                                                        </div>-->

                                </fieldset>
                            </div>
                        </div>
                    </div>



                    <?php /* ?>
                      <div class="panel panel-default">
                      <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                      <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      Prices List
                      </a>
                      </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                      <fieldset class="background-section">
                      <!--                    <div class="col-md-12">
                      <legend>Price Table</legend>
                      </div>-->
                      <div class="col-md-12" style="clear:both">
                      <div class="form-group">
                      <label class="enabled-project"><input type="checkbox" value="1" name="buyed" <?= $row->buyed == 1 ? 'checked' : ''; ?>> Sold Out</label>
                      </div>
                      </div>

                      <div class="col-md-6">
                      <div class="form-group">
                      <label>Notes</label>
                      <?= Form::text("paymentmethod_ar", $row->paymentmethod_ar, ["class" => "form-control"]); ?>
                      </div>
                      </div>

                      <div class="col-md-6 payment-method <?= $row->payment_method != "نقدي" ? 'withPlan' : '' ?>">
                      <label>Payment Method</label>
                      <div class="form-group">
                      <?= Form::select("payment_method", ["تقسيط" => "تقسيط", "نقدي" => "نقدي"], $row->payment_method, ["class" => "form-control select2me"]); ?>
                      </div>
                      <div class="payment-plan-section" style="">
                      <div class="form-group">
                      <?= Form::text("payment_percent", $row->payment_percent, ["class" => "form-control"]); ?>
                      <span class="title">%</span>
                      </div>
                      <div class="form-group">
                      <?= Form::text("payment_months", $row->payment_months, ["class" => "form-control"]); ?>
                      <span class="title">M</span>
                      </div>
                      </div>
                      </div>

                      <div class="col-md-12">
                      <div class="form-group">
                      <div class="panel panel-default">
                      <div class="panel-heading prices-heading">
                      <div class="col-md-2">
                      <div class="form-group">
                      <label><input type="checkbox" name="is_price_usd" <?= $row->is_price_usd == 1 ? 'checked' : ''; ?>>Prices in Dollars</label>
                      </div>
                      </div>
                      <button type="button" id="btn_dup_price" class="btn btn-default btn-xs btn-flat">Add New</button>
                      </div>
                      <div class="panel-body">
                      <div class="table-responsive">
                      <table class="table table-bordered table-striped m0" id="table_prices_content">
                      <thead>
                      <tr>
                      <th>Offer</th>
                      <th>Price TRY</th>
                      <th>Rooms</th>
                      <th>Area</th>
                      <th>Salons</th>
                      <!--<th>Date Created</th>-->
                      <th style="width:230px;"> AR Notes</th>
                      <th style="width:230px;">EN Notes</th>
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


                      </div>
                      </div>
                      </div>
                      </div>



                      </fieldset>
                      </div>
                      </div>
                      </div>
                      <?php */ ?>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Location & Metatag
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                            <div class="panel-body">
                                <fieldset class="background-section">
                                    <div class="col-md-12">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group hidden">
                                            <label>Real GPS Code</label>
                                            <?= Form::text("dms_map_real", $row->dms_map_real, ["class" => "form-control ltr", "placeholder" => "41°07'29.8\"N 28°46'48.6\"E"]); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Nearby GPS Code</label>
                                            <?= Form::text("dms_map", $row->dms_map, ["class" => "form-control ltr", "placeholder" => "41°07'29.8\"N 28°46'48.6\"E"]); ?>
                                        </div>
                                        <div class="form-group">
                                            @include('admin.layouts.location_map')
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <fieldset>
                                                <legend>Meta Tag</legend>
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
                                                    <?= Form::text("seo_keywords_ar", $row->seo_keywords_ar, ["class" => "form-control", "placeholder" => "Keywords"]); ?>
                                                </div>
                                                @endif
                                            </fieldset>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingSeven">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                    Project Data
                                </a>
                            </h4>
                        </div>
                        <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                            <div class="panel-body">
                                <fieldset class="background-section">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Project Images</label>
                                            @include('admin.layouts.media_input', [
                                            "name" => "project_photos",
                                            "multiple"  => true,
                                            "ids"    =>    $row->projectphotos()->lists('media_id')->toArray()
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Card Image</label>
                                            @include('admin.layouts.media_input', [
                                            "name" => "card_photo_id",
                                            "ids"  => [$row->card_photo_id]
                                            ])
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Floor Plan</label>
                                            @include('admin.layouts.media_input', [
                                            "name" => "plan_photos",
                                            "multiple"  => true,
                                            "ids"    =>    $row->planPhotos()->lists('media_id')->toArray()
                                            ])
                                        </div>
                                    </div>
                                    <!--                                    <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label>Youtube Video Link AR</label>
                                    <?= Form::text("linkvideo_ar", $row->linkvideo_ar, ["class" => "form-control ltr"]); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label>Youtube Video Link FA</label>
                                    <?= Form::text("linkvideo_fa", $row->linkvideo_fa, ["class" => "form-control ltr"]); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label>Youtube Video Link EN</label>
                                    <?= Form::text("linkvideo_en", $row->linkvideo_en, ["class" => "form-control ltr"]); ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <div class="form-group">
                                                                                <label>Youtube Video Link FR</label>
                                    <?= Form::text("linkvideo_fr", $row->linkvideo_fr, ["class" => "form-control ltr"]); ?>
                                                                            </div>
                                                                        </div>-->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>3D</label>
                                            <!--<input id="project3d" name="link_3d" type="text" class="form-control" />-->
                                            <?= Form::text("link_3d", $row->link_3d, ["class" => "form-control ltr", "id" => "project3d"]); ?>
                                        </div>
                                    </div>


                                    <?php /*
                                      <div class="col-md-4" style="clear:both">
                                      <div class="form-group">
                                      <label>Infographic (AR)</label>
                                      <div class="file-loading">
                                      <input id="input-infographic" name="file_infographic" type="file" accept="image/*">
                                      </div>
                                      <?php if(@$row->file_infographic!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_infographic) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                      <div class="col-md-4">
                                      <div class="form-group">
                                      <label>Infographic (EN)</label>
                                      <div class="file-loading">
                                      <input id="input-infographic-en" name="file_infographic_en" type="file" accept="image/*">
                                      </div>
                                      <?php if(@$row->file_infographic_en!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_infographic_en) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                      <div class="col-md-4">
                                      <div class="form-group">
                                      <label>Infographic (FR)</label>
                                      <div class="file-loading">
                                      <input id="input-infographic-fr" name="file_infographic_fr" type="file" accept="image/*">
                                      </div>
                                      <?php if(@$row->file_infographic_fr!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_infographic_fr) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                     */ ?>




                                    <?php
                                    /* ?>
                                      <div class="col-md-12" style="clear:both">
                                      <div class="form-group">
                                      <label class="enabled-project"><input type="checkbox" value="1" name="enable_offer" <?= $row->enable_offer == 1 ? 'checked' : ''; ?>> Activate offer</label>
                                      </div>
                                      </div>


                                      <div class="col-md-4" style="clear:both">
                                      <div class="form-group">
                                      <label>Offer (AR)</label>
                                      <div class="file-loading">
                                      <input id="input-offer" name="file_offer" type="file" accept="image/*">
                                      </div>
                                      <?php if(@$row->file_offer!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_offer) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                      <div class="col-md-4">
                                      <div class="form-group">
                                      <label>Offer (EN)</label>
                                      <div class="file-loading">
                                      <input id="input-offer-en" name="file_offer_en" type="file" accept="image/*">
                                      </div>
                                      <?php if(@$row->file_offer_en!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_offer_en) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                      <div class="col-md-4">
                                      <div class="form-group">
                                      <label>Offer (FR)</label>
                                      <div class="file-loading">
                                      <input id="input-offer-fr" name="file_offer_fr" type="file" accept="image/*">
                                      </div>
                                      <?php if(@$row->file_offer_fr!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_offer_fr) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>




                                      <div class="col-md-4" style="clear:both">
                                      <div class="form-group">
                                      <label>PDF (AR)</label>
                                      <div class="file-loading">
                                      <?php // Form::file("file_pdf", $row->file_pdf, ["id" => "input-pdf", "accept"=>"pdf/*"]); ?>
                                      <input id="input-pdf" name="file_pdf" type="file" accept="pdf/*" />
                                      </div>
                                      <?php if(@$row->file_pdf!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_pdf) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                      <div class="col-md-4">
                                      <div class="form-group">
                                      <label>PDF (EN)</label>
                                      <div class="file-loading">
                                      <?php // Form::file("file_pdf", $row->file_pdf, ["id" => "input-pdf", "accept"=>"pdf/*"]); ?>
                                      <input id="input-pdf-en" name="file_pdf_en" type="file" accept="pdf/*" />
                                      </div>
                                      <?php if(@$row->file_pdf_en!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_pdf_en) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                      <div class="col-md-4">
                                      <div class="form-group">
                                      <label>PDF (FR)</label>
                                      <div class="file-loading">
                                      <?php // Form::file("file_pdf", $row->file_pdf, ["id" => "input-pdf", "accept"=>"pdf/*"]); ?>
                                      <input id="input-pdf-fr" name="file_pdf_fr" type="file" accept="pdf/*" />
                                      </div>
                                      <?php if(@$row->file_pdf_fr!=''){ ?>
                                      <p><a target="_blank" href="<?= asset(@$row->file_pdf_fr) ?>">View</a></p>
                                      <?php } ?>
                                      </div>
                                      </div>
                                      <?php
                                     */
                                    $arr_rooms = array(
                                        '0+1' => '0+1', '1+1' => '1+1', '2+1' => '2+1', '3+1' => '3+1', '3+2' => '3+2', '4+1' => '4+1', '5+1' => '5+1', '5+2' => '5+2', '6+1' => '6+1', 'Office' => 'Office', 'Outside' => 'Outside'
                                    );
                                    $videos = [];
                                    $yvideos = [];
                                    if ($row->id) {
                                        $videos = DB::table('crm_videos')->where('project', $row->id)->where('video', 'not like', '%youtube%')->get();
                                        $yvideos = DB::table('crm_videos')->where('project', $row->id)->where('video', 'like', '%youtube%')->get();
                                    }
                                    //echo count($videos).'####'.$row->id;
                                    ?>
                                    <?php
                                    if (count($videos) > 0) {
                                        $rv = $videos[0];
                                        //foreach ($videos as $rv) {
                                        ?>
                                        <div class="col-md-12">
                                            <div class="section-video">
                                                <div class="col-md-2">
                                                    <label>Select Rooms</label>
                                                    <input type="hidden" name="crm_video_id[]" value="<?= $rv->id ?>">

                                                    <?= Form::select("rooms[]", $arr_rooms, $rv->rooms, ["class" => "form-control"]); ?>

                                                </div>
                                                <div class="col-md-5">
                                                    <label>Title</label>
                                                    <input type="text" name="video_title[]" class="form-control"  value="<?= $rv->video_title ?>"/>
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Video</label>
                                                    <input name="video[]" id="input-video" class="input-video" type="file" accept="video/*">
                                                    <p><a target="_blank" href="<?= asset(@$rv->video) ?>">View</a></p>
                                                </div>
                                                <a class="add-video-btn">+</a>
                                                <?php if ($rv->id) { ?>
                                                    <a class="remove-video-ajax delete_video" data-eq="0" data-id="<?= $rv->id ?>">X</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="section-sub-video">
                                            <?php
                                            $first = true;
                                            foreach ($videos as $rv) {
                                                if ($first == false) {
                                                    ?>
                                                    <div class="section-video sub">
                                                        <input type="hidden" name="crm_video_id[]" value="<?= $rv->id ?>">
                                                        <div class="col-md-2">
                                                            <?= Form::select("rooms[]", $arr_rooms, $rv->rooms, ["class" => "form-control"]); ?>

                                                        </div>

                                                        <div class="col-md-5">
                                                            <?= Form::text("video_title[]", @$rv->video_title, ["class" => "form-control"]); ?>    
                                                        </div>
                                                        <div class="col-md-5"><input id="input-video<?= $rv->id + 5 ?>" name="video[]" type="file" accept="video/*">
                                                            <p><a target="_blank" href="<?= asset(@$rv->video) ?>">View</a></p>
                                                        </div>
                                                        <a class="remove-video-ajax delete_video" data-eq="0" data-id="<?= $rv->id ?>">X</a>
                                                    </div>
                                                    <script>$("#input-video<?= $rv->id + 5 ?>").fileinput({/*uploadUrl: '/file-upload-batch/2',*/previewFileType: "video", allowedFileExtensions: ["mp4"], browseClass: "btn btn-success", browseLabel: "Pick Video", browseIcon: "<i class='fa fa-file-movie-o'></i>", removeClass: "btn btn-danger", removeLabel: "Delete", uploadClass: "btn btn-info hidden", /*uploadLabel: "Upload",*/});</script>
                                                    <?php
                                                }
                                                $first = false;
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        //}
                                    } else {
                                        ?>
                                        <div class="col-md-12">
                                            <div class="section-video">
                                                <div class="col-md-2">
                                                    <label>Select Rooms</label>
                                                    <input type="hidden" name="crm_video_id[]" value="0">
                                                    <?= Form::select("rooms[]", $arr_rooms, '', ["class" => "form-control"]); ?>
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Title</label>
                                                    <input type="text" name="video_title[]" class="form-control" />
                                                </div>
                                                <div class="col-md-5">
                                                    <label>Video</label>
                                                    <input name="video[]" id="input-video" type="file" accept="video/*">

                                                </div>
                                                <a class="add-video-btn">+</a>
                                            </div>
                                            <div class="section-sub-video"></div>
                                        </div>
                                    <?php } ?>
















                                    <!--
                                                                        <div class="col-md-12">
                                    
                                                                            <input type="button" value="Add youtube video" class="btn btn-primary add-youtube-btn" style="margin: 30px 0 14px 0;">
                                                                        </div>
                                                                        <div class="section-sub-youtube">
                                    <?php
                                    foreach ($yvideos as $rv) {
                                        ?>
                                                                                                                <div class="section-youtube sub">
                                                                                                                    <input type="hidden" name="ycrm_video_id[]" value="<?= $rv->id ?>">
                                                                                                                    <div class="col-md-2">
                                        <?= Form::select("yrooms[]", $arr_rooms, $rv->rooms, ["class" => "form-control"]); ?>
                                                                                                                    </div>
                                                                                                                    <div class="col-md-3">
                                        <?= Form::text("yvideo_title[]", @$rv->video_title, ["class" => "form-control", "placeholder" => "Title"]); ?>    
                                                                                                                    </div>
                                                                                                                    <div class="col-md-3">
                                        <?= Form::text("yvideo_title_en[]", @$rv->video_title_en, ["class" => "form-control", "placeholder" => "Title EN"]); ?>    
                                                                                                                    </div>
                                                                                                                    <div class="col-md-4"><input name="yvideo[]" value="<?= $rv->video ?>" type="text" class="form-control" placeholder="Youtube Link">
                                                                                                                        <p><a target="_blank" href="<?= @$rv->video ?>">View</a></p>
                                                                                                                    </div>
                                                                                                                    <a class="delete_youtube remove-video-ajax" data-eq="0" data-id="<?= $rv->id ?>">X</a>
                                                                                                                </div>
                                    <?php } ?>
                                    
                                                                        </div>-->


                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section English -->
            <div class="tab-pane fade" id="tab2default">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFive">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    Basic Information
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
                            <div class="panel-body">
                                <fieldset class="background-section">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Name (EN) <span class="red">(*)</span></label>
                                                <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr", "required" => "required"]); ?>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Title (EN)</label>
                                                <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Card Intro</label>
                                            <?= Form::text("intro_card_en", $row->intro_card_en, ["class" => "form-control ltr"]); ?>
                                        </div>
                                        <div class="form-group">
                                            <label>Overview</label>
                                            <?= Form::textarea("intro_location_en", $row->intro_location_en, ["class" => "form-control ltr", "rows" => 5]); ?>
                                        </div>
                                        <!--                                        <div class="form-group">
                                                                                    <label>Salesman</label>
                                                                                    <select name="salemanager_en_id" class="form-control select2me">
                                                                                        <option value=""></option>
                                                                                        @foreach(Helper::query("SaleManager", "all") as $manager)
                                                                                        <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_en_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group relatedArticlesEn">
                                            <label>Related Articles</label>
                                            <select name="post_en_id[]" class="form-control select2me" multiple>
                                                <option value=""></option>
                                                <?php
                                                $posts = \App\Models\Post::where("published", 1)->where('title_en', '!=', '')->get();
                                                ?>
                                                @foreach($posts as $post)
                                                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsEn()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_en; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <fieldset>
                                                <legend>Meta Tag</legend>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Title</label>-->
                                                    <?= Form::text("seo_title_en", $row->seo_title_en, ["class" => "form-control text-align-left", "placeholder" => "Title"]); ?>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Description</label>-->
                                                    <?= Form::textarea("seo_description_en", $row->seo_description_en, ["class" => "form-control text-align-left", "rows" => 5, "placeholder" => "Description"]); ?>
                                                </div>

                                                @if(@$hide_keywords==false)
                                                <div class="form-group col-md-12" style="">
                                                    <!--                            <label>Keywords</label>-->
                                                    <?= Form::text("seo_keywords_en", $row->seo_keywords_en, ["class" => "form-control", "placeholder" => "Keywords"]); ?>
                                                </div>
                                                @endif
                                            </fieldset>
                                        </div>
                                    </div>


                                    <!--                                    <div class="col-md-6" style="display:none">
                                                                            <div class="form-group">
                                                                                <label>Payment Method</label>
                                    <?= Form::text("paymentmethod_en", $row->paymentmethod_en, ["class" => "form-control"]); ?>
                                                                            </div>
                                                                        </div>-->

                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingSix">
                                                <h4 class="panel-title">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                        Overview & Details
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                                <div class="panel-body">
                                                    <fieldset  class="background-section">
                                                                            <legend>Project location and strategic importance (English)</legend>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Overview</label>
                    <?= Form::textarea("intro_location_en", $row->intro_location_en, ["class" => "form-control ltr", "rows" => 5]); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Location</label>
                    <?= Form::textarea("location_en", $row->location_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                                            </div> 
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Governmental institutions</label>
                    <?= Form::textarea("governmental_en", $row->governmental_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Transportation</label>
                    <?= Form::textarea("transportation_en", $row->transportation_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Future Look</label>
                    <?= Form::textarea("future_look_en", $row->future_look_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Intro Features</label>
                    <?= Form::textarea("intro_features_en", $row->intro_features_en, ["class" => "form-control ltr", "rows" => 4]); ?>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>-->
                </div>
            </div>

            <!-- Section French -->
            <div class="tab-pane fade" id="tab3default">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFive">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive2" aria-expanded="true" aria-controls="collapseFive">
                                    Basic Information
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive">
                            <div class="panel-body">
                                <fieldset class="background-section">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Card Intro</label>
                                            <?= Form::text("intro_card_fr", $row->intro_card_fr, ["class" => "form-control ltr"]); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Overview</label>
                                                <?= Form::textarea("intro_location_fr", $row->intro_location_fr, ["class" => "form-control ltr", "rows" => 5]); ?>
                                            </div>
                                        </div>
                                        <!--                                        <div class="form-group">
                                                                                    <label>Salesman</label>
                                                                                    <select name="salemanager_fr_id" class="form-control select2me">
                                                                                        <option value=""></option>
                                                                                        @foreach(Helper::query("SaleManager", "all") as $manager)
                                                                                        <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_fr_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group relatedArticlesEn">
                                            <label>Related Articles</label>
                                            <select name="post_fr_id[]" class="form-control select2me" multiple>
                                                <?php
                                                $posts = \App\Models\Post::where("published", 1)->where('title_fr', '!=', '')->get();
                                                ?>
                                                <option value=""></option>
                                                @foreach($posts as $post)
                                                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsFr()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_fr; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <fieldset>
                                                <legend>Meta Tag</legend>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Title</label>-->
                                                    <?= Form::text("seo_title_fr", $row->seo_title_fr, ["class" => "form-control text-align-left", "placeholder" => "Title"]); ?>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Description</label>-->
                                                    <?= Form::textarea("seo_description_fr", $row->seo_description_fr, ["class" => "form-control text-align-left", "rows" => 5, "placeholder" => "Description"]); ?>
                                                </div>

                                                @if(@$hide_keywords==false)
                                                <div class="form-group col-md-12" style="">
                                                    <!--                            <label>Keywords</label>-->
                                                    <?= Form::text("seo_keywords_fr", $row->seo_keywords_fr, ["class" => "form-control", "placeholder" => "Keywords"]); ?>
                                                </div>
                                                @endif
                                            </fieldset>
                                        </div>
                                    </div>


                                    <!--<div class="col-md-6" style="display:none">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                    <?= Form::text("paymentmethod_fr", $row->paymentmethod_fr, ["class" => "form-control"]); ?>
                                        </div>
                                    </div>-->

                                </fieldset>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Section Farisi -->
            <div class="tab-pane fade" id="tab4default">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFiveA">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive2A" aria-expanded="true" aria-controls="collapseFive">
                                    Basic Information
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive2A" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFiveA">
                            <div class="panel-body">
                                <fieldset class="background-section">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Card Intro</label>
                                            <?= Form::text("intro_card_fa", $row->intro_card_fa, ["class" => "form-control rtl text-align-right"]); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Overview</label>
                                                <?= Form::textarea("intro_location_fa", $row->intro_location_fa, ["class" => "form-control rtl text-align-right", "rows" => 5]); ?>
                                            </div>
                                        </div>
                                        <!--                                        <div class="form-group">
                                                                                    <label>Salesman</label>
                                                                                    <select name="salemanager_fa_id" class="form-control select2me">
                                                                                        <option value=""></option>
                                                                                        @foreach(Helper::query("SaleManager", "all") as $manager)
                                                                                        <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_fa_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group relatedArticlesEn">
                                            <label>Related Articles</label>
                                            <select name="post_fr_id[]" class="form-control select2me" multiple>
                                                <?php
                                                $posts = \App\Models\Post::where("published", 1)->where('title_fa', '!=', '')->get();
                                                ?>
                                                <option value=""></option>
                                                @foreach($posts as $post)
                                                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsFr()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_fr; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <fieldset>
                                                <legend>Meta Tag</legend>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Title</label>-->
                                                    <?= Form::text("seo_title_fa", $row->seo_title_fa, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Description</label>-->
                                                    <?= Form::textarea("seo_description_fa", $row->seo_description_fa, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                                                </div>

                                                @if(@$hide_keywords==false)
                                                <div class="form-group col-md-12" style="">
                                                    <!--                            <label>Keywords</label>-->
                                                    <?= Form::text("seo_keywords_fa", $row->seo_keywords_fa, ["class" => "form-control", "placeholder" => "Keywords"]); ?>
                                                </div>
                                                @endif
                                            </fieldset>
                                        </div>
                                    </div>


                                    <?php /*
                                      <div class="col-md-6">
                                      <div class="form-group relatedArticlesEn">
                                      <label>Related Articles</label>
                                      <select name="post_fa_id[]" class="form-control select2me" multiple>
                                      <?php
                                      $posts = \App\Models\Post::where("published", 1)->where('title_fa','!=','')->get();
                                      ?>
                                      <option value=""></option>
                                      @foreach($posts as $post)
                                      <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsFa()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_fa; ?></option>
                                      @endforeach
                                      </select>
                                      </div>
                                      </div> */ ?>
                                    <!--<div class="col-md-6" style="display:none">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                    <?php // Form::text("paymentmethod_fr", $row->paymentmethod_fr, ["class" => "form-control"]);  ?>
                                        </div>
                                    </div>-->

                                </fieldset>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
			
			
            <!-- Section Russian -->
            <div class="tab-pane fade" id="tab5default">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFiveA">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive2A" aria-expanded="true" aria-controls="collapseFive">
                                    Basic Information
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFive2A" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFiveA">
                            <div class="panel-body">
                                <fieldset class="background-section">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Card Intro</label>
                                            <?= Form::text("intro_card_ru", $row->intro_card_ru, ["class" => "form-control rtl text-align-right"]); ?>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Overview</label>
                                                <?= Form::textarea("intro_location_ru", $row->intro_location_ru, ["class" => "form-control rtl text-align-right", "rows" => 5]); ?>
                                            </div>
                                        </div>
                                        <!--                                        <div class="form-group">
                                                                                    <label>Salesman</label>
                                                                                    <select name="salemanager_ru_id" class="form-control select2me">
                                                                                        <option value=""></option>
                                                                                        @foreach(Helper::query("SaleManager", "all") as $manager)
                                                                                        <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_ru_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>-->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group relatedArticlesEn">
                                            <label>Related Articles</label>
                                            <select name="post_fr_id[]" class="form-control select2me" multiple>
                                                <?php
                                                $posts = \App\Models\Post::where("published", 1)->where('title_ru', '!=', '')->get();
                                                ?>
                                                <option value=""></option>
                                                @foreach($posts as $post)
                                                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsFr()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_fr; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <fieldset>
                                                <legend>Meta Tag</legend>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Title</label>-->
                                                    <?= Form::text("seo_title_ru", $row->seo_title_ru, ["class" => "form-control text-align-right", "placeholder" => "Title"]); ?>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <!--                            <label>Description</label>-->
                                                    <?= Form::textarea("seo_description_ru", $row->seo_description_ru, ["class" => "form-control text-align-right", "rows" => 5, "placeholder" => "Description"]); ?>
                                                </div>

                                                @if(@$hide_keywords==false)
                                                <div class="form-group col-md-12" style="">
                                                    <!--                            <label>Keywords</label>-->
                                                    <?= Form::text("seo_keywords_ru", $row->seo_keywords_ru, ["class" => "form-control", "placeholder" => "Keywords"]); ?>
                                                </div>
                                                @endif
                                            </fieldset>
                                        </div>
                                    </div>


                                    <?php /*
                                      <div class="col-md-6">
                                      <div class="form-group relatedArticlesEn">
                                      <label>Related Articles</label>
                                      <select name="post_ru_id[]" class="form-control select2me" multiple>
                                      <?php
                                      $posts = \App\Models\Post::where("published", 1)->where('title_ru','!=','')->get();
                                      ?>
                                      <option value=""></option>
                                      @foreach($posts as $post)
                                      <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsFa()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_ru; ?></option>
                                      @endforeach
                                      </select>
                                      </div>
                                      </div> */ ?>
                                    <!--<div class="col-md-6" style="display:none">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                    <?php // Form::text("paymentmethod_fr", $row->paymentmethod_fr, ["class" => "form-control"]);  ?>
                                        </div>
                                    </div>-->

                                </fieldset>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>



<!-- media js -->
@include('admin.layouts.media_input_js')

<script>
    $(function () {

        $(document).on("click", ".delete_video", function () {
            var result = confirm("Want to delete?");
            if (result) {
                var id = $(this).data('id');
                //var eq= $(this).data('eq');
                var ths = $(this);
                $.ajax({
                    type: 'POST',
                    url: "<?= route('admin.projects.deletevideo', ['ididid']); ?>".replace('ididid', id),
                    data: {
                        _token: '<?= csrf_token(); ?>'
                    }
                }).done(function (resp) {
                    ths.parent('.section-video').remove();
                });
            }
        });

        $(document).on("click", ".delete_youtube", function () {
            var result = confirm("Want to delete?");
            if (result) {
                $(this).parent('.section-youtube').remove();
            }
        });

        /*$("#btn_dup_price").on('click', function() {
         var dv = $("#tr_price").clone().removeClass('hidden').removeAttr('id').appendTo("#table_prices_content");
         });*/
        $(document).on("click", ".btn_tr_delete", function () {
            $(this).closest("tr").remove();
        });
        $(document).on("click", "#btn_dup_price", function () {
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
            }).done(function (resp) {
                $.getScript("<?= asset('admin/js/admin.js'); ?>");
                $("#table_prices_content tbody").append(resp);
                $("#ajaxloading").hide();
            });
            return false;
        });
    });



    $('.date5').datepicker({format: "yyyy-mm-dd"});



    $("select[name='payment_method']").on("change", function () {
        var paymentMethod = $(this).val();
        if (paymentMethod == "تقسيط") {
            $(".payment-method").addClass("withPlan");
        } else {
            $(".payment-method").removeClass("withPlan");
        }
    });


    $('.panel-collapse').on('shown.bs.collapse', function (e) {
        var $panel = $(this).closest('.panel');
        $('html,body').animate({
            scrollTop: $panel.offset().top
        }, 500);
    });



    $(document).ready(function () {
        /**-- Infographic Upload --**/
        $("#input-offer").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            previewFileType: "image",
            allowedFileExtensions: ["jpg"],
            browseClass: "btn btn-success",
            browseLabel: "Pick Infographic",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> "
        });
        $("#input-offer-fr").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            previewFileType: "image",
            allowedFileExtensions: ["jpg"],
            browseClass: "btn btn-success",
            browseLabel: "Pick Infographic",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> "
        });
        $("#input-offer-en").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            previewFileType: "image",
            allowedFileExtensions: ["jpg"],
            browseClass: "btn btn-success",
            browseLabel: "Pick Infographic",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> "
        });
        $("#input-infographic").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            previewFileType: "image",
            allowedFileExtensions: ["jpg"],
            browseClass: "btn btn-success",
            browseLabel: "Pick Infographic",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> "
        });
        $("#input-infographic-fr").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            previewFileType: "image",
            allowedFileExtensions: ["jpg"],
            browseClass: "btn btn-success",
            browseLabel: "Pick Infographic",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> "
        });
        $("#input-infographic-en").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            previewFileType: "image",
            allowedFileExtensions: ["jpg"],
            browseClass: "btn btn-success",
            browseLabel: "Pick Infographic",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> "
        });

        /**-- Infographic Upload --**/
        $("#input-pdf").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            caption: 'caption',
            text: 'desert.jpg',
            showCaption: true,

            allowedFileExtensions: ["pdf"],
            browseClass: "btn btn-success",
            browseLabel: "Pick PDF",
            browseIcon: "<i class=\"fa fa-file-pdf-o\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
        });
        $("#input-pdf-en").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            caption: 'caption',
            text: 'desert.jpg',
            showCaption: true,

            allowedFileExtensions: ["pdf"],
            browseClass: "btn btn-success",
            browseLabel: "Pick PDF",
            browseIcon: "<i class=\"fa fa-file-pdf-o\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
        });
        $("#input-pdf-fr").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            caption: 'caption',
            text: 'desert.jpg',
            showCaption: true,

            allowedFileExtensions: ["pdf"],
            browseClass: "btn btn-success",
            browseLabel: "Pick PDF",
            browseIcon: "<i class=\"fa fa-file-pdf-o\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
        });

        /**-- Infographic Upload --**/
        $("#input-video,.input-video").fileinput({
            //uploadUrl: '/file-upload-batch/2',
            previewFileType: "video",
            allowedFileExtensions: ["mp4"],
            browseClass: "btn btn-success",
            browseLabel: "Pick Video",
            browseIcon: "<i class=\"fa fa-file-movie-o\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info hidden",
            //uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
        });
    });

    var i = 1;
    $(document).on("click", ".add-video-btn", function () {
        var Id = i++;
        $(".section-sub-video").append(
                '<div class="section-video sub">' +
                '<input type="hidden" name="crm_video_id[]" value="0">' +
                '<div class="col-md-2">' +
                '<?= Form::select("rooms[]", $arr_rooms, '', ["class" => "form-control"]); ?>' +
                '</div>' +
                '<div class="col-md-5">' +
                '<input type="text" name="video_title[]" class="form-control" />' +
                '</div>' +
                '<div class="col-md-5">' +
                '<input id="input-video' + Id + '"  name="video[]" type="file" accept="video/*">' +
                '</div>' +
                '<a class="remove-video-btn">X</a>' +
                '<script>' +
                '$("#input-video' + Id + '").fileinput({' +
                "/*uploadUrl: '/file-upload-batch/2',*/" +
                'previewFileType: "video",' +
                'allowedFileExtensions: ["mp4"],' +
                'browseClass: "btn btn-success",' +
                'browseLabel: "Pick Video",' +
                'browseIcon: "<i class=\'fa fa-file-movie-o\'></i>",' +
                'removeClass: "btn btn-danger",' +
                'removeLabel: "Delete",' +
                'uploadClass: "btn btn-info hidden",' +
                '/*uploadLabel: "Upload",*/' +
                '});' +
                '</' +
                'script>' +
                '</div>'
                )
    });
    i = 1;
    $(document).on("click", ".add-youtube-btn", function () {
        var Id = i++;
        $(".section-sub-youtube").append(
                '<div class="section-youtube sub">' +
                '<input type="hidden" name="ycrm_video_id[]" value="0">' +
                '<div class="col-md-2">' +
                '<?= Form::select("yrooms[]", $arr_rooms, '', ["class" => "form-control"]); ?>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<?= Form::text("yvideo_title[]", "", ["class" => "form-control", "placeholder" => "Title"]); ?>' +
                '</div>' +
                '<div class="col-md-3">' +
                '<?= Form::text("yvideo_title_en[]", "", ["class" => "form-control", "placeholder" => "Title EN"]); ?>' +
                '</div>' +
                '<div class="col-md-4">' +
                '<input class="form-control" name="yvideo[]" type="text" placeholder="Youtube Link">' +
                '</div>' +
                '<a class="delete_youtube remove-video-ajax">X</a>' +
                '</div>'
                )
    });

    $(document).on("click", ".remove-video-btn", function () {
        var thisCont = $(this).parents(".section-video.sub");
        $(thisCont).remove();
    });

    (function () {
        var $country = $('#project_filter_country');
        var $city = $('#project_city_id');
        var $region = $('#project_region_id');

        if (!$country.length || !$city.length || !$region.length) {
            return;
        }

        function setOptionVisibility($select, dataAttr, parentValue, preserveValue) {
            var current = preserveValue ? $select.val() : '';
            $select.find('option').each(function () {
                var $opt = $(this);
                if (!$opt.val()) {
                    $opt.prop('disabled', false);
                    return;
                }
                var match = parentValue && String($opt.attr('data-' + dataAttr)) === String(parentValue);
                $opt.prop('disabled', !match);
            });
            if (current && $select.find('option:selected').prop('disabled')) {
                $select.val('');
            }
        }

        function applyCountryFilter(preserveSelections) {
            var countryId = $country.val();
            setOptionVisibility($city, 'country-id', countryId, preserveSelections);
            applyCityFilter(preserveSelections);
        }

        function applyCityFilter(preserveSelections) {
            var cityId = $city.val();
            if (!$country.val()) {
                cityId = '';
            }
            setOptionVisibility($region, 'city-id', cityId, preserveSelections);
        }

        function syncSelect2($select) {
            if (!$select.data('select2')) {
                return;
            }
            $select.select2('val', $select.val());
        }

        function clearCityAndDistrict() {
            $city.val('');
            $region.val('');
            syncSelect2($city);
            syncSelect2($region);
        }

        applyCountryFilter(true);

        $country.on('change', function () {
            clearCityAndDistrict();
            applyCountryFilter(false);
            syncSelect2($city);
            syncSelect2($region);
        });

        $city.on('change', function () {
            $region.val('');
            applyCityFilter(false);
            syncSelect2($region);
        });
    })();

</script>


@endsection
