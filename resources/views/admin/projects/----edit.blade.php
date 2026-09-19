@extends('admin.layouts.form', ["app_title" => "Properties", "app_desc" => "Properties Information"])
@section('main_form')







<div class="panel with-nav-tabs panel-default">
    <div class="panel-heading lang-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab1default" data-toggle="tab">Arabic Section</a></li>
            <li><a href="#tab2default" data-toggle="tab">English Section</a></li>
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
                                    <div class="form-group col-md-1">
                                        <div class="form-group">
                                            <label>ID <span class="red">(*)</span></label>
                                            <?= Form::text("name_en", $row->name_en, ["class" => "form-control ltr"]); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="form-group">
                                            <label>Project Name <span class="red"></span></label>
                                            <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="form-group">
                                            <label>Project Link <span class="red"></span></label>
                                            <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control rtl"]); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="form-group">
                                            <label>Company Name<span class="red"></span></label>
                                            <?= Form::text("company", $row->company, ["class" => "form-control ltr"]); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="form-group">
                                            <label>Slug <span class="red">(*)</span></label>
                                            <div class="input-group ltr">
                                                <span class="input-group-addon">projects/</span>
                                                <?= Form::text("slug", $row->slug, ["class" => "form-control input-sm ltr"]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="form-group">
                                            <label class="enabled-project"><input type="checkbox" name="published" <?= $row->published == 1 ? 'checked' : ''; ?>> Enabled</label>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6 hidden">
                                        <label>Arabic Name <span class="red">(*)</span></label>
                                        <?= Form::text("name_ar", $row->name_ar, ["class" => "form-control"]); ?>
                                    </div>



                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>City <span class="red">(*)</span></label>
                                            <select name="city_id" class="form-control select2me">
                                                <option value=""></option>
                                                @foreach(Helper::query("City", "all") as $city)
                                                <option value="<?= $city->id; ?>" <?= $city->id == $row->city_id ? 'selected' : ''; ?>><?= $city->name_ar; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>District</label>
                                            <select name="region_id" class="form-control select2me">
                                                <option value=""></option>
                                                @foreach(Helper::query("Region", "all") as $region)
                                                <option value="<?= $region->id; ?>" <?= $region->id == $row->region_id ? 'selected' : ''; ?>><?= $region->name_ar; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Delivery Date</label>
                                            <?= Form::text("delivered_date", $row->delivered_date, ["class" => "form-control date5"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Distance To Center</label>
                                            <?= Form::text("distance_center", $row->distance_center, ["class" => "form-control"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Distance To Airport</label>
                                            <?= Form::text("distance_airport", $row->distance_airport, ["class" => "form-control", "disabled"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="display:none">
                                        <div class="form-group col-md-4" style="display:none">
                                            <label>Status</label>
                                            <?=
                                            Form::select("project_etat", [
                                                "قيد الإنشاء" => "قيد الإنشاء", "جاهز" => "جاهز", "جاهز - قيد الإنشاء" => "جاهز - قيد الإنشاء"
                                                    ], $row->project_etat, ["class" => "form-control select2me"]);
                                            ?>
                                        </div>
                                    </div>
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
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Agent</label>
                                            <select name="salemanager_ar_id" class="form-control select2me">
                                                <option value=""></option>
                                                @foreach(Helper::query("SaleManager", "all") as $manager)
                                                <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_ar_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
                                                @endforeach
                                            </select>
                                        </div> 
                                    </div>
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
                                                @foreach(Helper::query("Post", "whereIn", ["field" => "lang", "value" => ["ar", "all"]])->get() as $post)
                                                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->posts()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_ar; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Youtube Video Link</label>
                                            <?= Form::text("linkvideo_ar", $row->linkvideo_ar, ["class" => "form-control ltr"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Card Intro</label>
                                            <?= Form::text("intro_card_ar", $row->intro_card_ar, ["class" => "form-control"]); ?>
                                        </div>
                                    </div>


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
                                        <div class="form-group">
                                            <label>Intro</label>
                                            <?= Form::textarea("intro_features_ar", $row->intro_features_ar, ["class" => "form-control text-align-right", "rows" => 4]); ?>
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

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Overview</label>
                                            <?= Form::textarea("intro_location_ar", $row->intro_location_ar, ["class" => "form-control text-align-right", "rows" => 5]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                    </div>
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


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                            <?= Form::text("paymentmethod_ar", $row->paymentmethod_ar, ["class" => "form-control"]); ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6 payment-method">
                                        <label>Payment Method</label>
                                        <div class="form-group">
                                            <?= Form::select("payment_method", ["نقدي" => "نقدي", "تقسيط" => "تقسيط"], $row->payment_method, ["class" => "form-control select2me"]); ?>
                                        </div>
                                        <div class="payment-plan-section">
                                            <div class="form-group">
                                                <?= Form::text("percent", "", ["class" => "form-control"]); ?>
                                                <span class="title">%</span>
                                            </div> 
                                            <div class="form-group">
                                                <?= Form::text("numberOfMonths", "", ["class" => "form-control"]); ?>
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
                                        <div class="form-group">
                                            <label>GPS Code</label>
                                            <?= Form::text("dms_map", $row->dms_map, ["class" => "form-control ltr", "placeholder" => "41°07'29.8\"N 28°46'48.6\"E"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            @include('admin.layouts.location_map')

                                            @include('admin.layouts.seo')
                                        </div>
                                    </div>
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Card Intro</label>
                                            <?= Form::text("intro_card_en", $row->intro_card_en, ["class" => "form-control ltr"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Youtube Video Link</label>
                                            <?= Form::text("linkvideo_en", $row->linkvideo_en, ["class" => "form-control ltr"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                            <?= Form::text("paymentmethod_en", $row->paymentmethod_en, ["class" => "form-control"]); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Salesman</label>
                                            <select name="salemanager_en_id" class="form-control select2me">
                                                <option value=""></option>
                                                @foreach(Helper::query("SaleManager", "all") as $manager)
                                                <option value="<?= $manager->id; ?>" <?= $manager->id == $row->salemanager_en_id ? 'selected' : ''; ?>><?= $manager->name_ar; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Related Articles</label>
                                            <select name="post_en_id[]" class="form-control select2me" multiple>
                                                <option value=""></option>
                                                @foreach(Helper::query("Post", "whereIn", ["field" => "lang", "value" => ["en", "all"]])->get() as $post)
                                                <option value="<?= $post->id; ?>" <?= in_array($post->id, $row->postsEn()->lists('post_id')->toArray()) ? 'selected' : ''; ?>><?= $post->title_en; ?></option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
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
                                    <!--                    <legend>Project location and strategic importance (English)</legend>-->
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
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>



<!-- media js -->
@include('admin.layouts.media_input_js')

<script  src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css">-->
<script>
    $(function () {
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

</script>


@endsection
