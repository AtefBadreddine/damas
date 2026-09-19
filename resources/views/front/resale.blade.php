<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr']) ? 'en' : 'ar';

//$photoCard = $post->photoCard;
$infos = Helper::get_params();
$branchs = Helper::query("Branch", "orderBy", ["filed" => "id", "value" => "ASC"])->get();
$is_mobile = Helper::is_mobile();

$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
?>

@section('styles')
<?php if (App::isLocal()) { ?>
    <?= Html::style("/resources/assets/css/resale.css"); ?>




    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("/resources/assets/css/resale-en.css"); ?>
    <?php } ?>

<?php } else { ?>
    <?= Html::style("/css/resale.min.css?v=1"); ?>

    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>

    <?php } ?>
<?php } ?>



@endsection

<?php
$page_title = $row->getSeoTitle();
$media = $row->media;
?>
@extends('front.layout', [
"page_title" => $page_title ? $page_title : $row->getTitle(),
"page_description"  =>    $row->getSeoDescription(),
"page_keywords"     =>    $row->getSeoKeywords(),
"og_image"          =>    Helper::media_mob($media)
])
@section('main_content')



<div class="full_sections int_page">
    <div class="container">

        <div class="top_control_sec">
            <h1 class="jazzira_font_bold"><?= $row->getTitle(); ?><?php trans("front.resale page title"); ?></h1>
        </div>

        <img width="100%" height="400" class="big_photo" src="<?= @Helper::media_url($media); ?>" loading="lazy" alt="damasturk resale"/>

        <div class="int_content">
            {!! html_entity_decode($row->getContent()) !!}
        </div>


        <section class="resale_form sec">



            <div class="int_content">
                <h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.resale Real estate appraisal") ?></h2>
                <p class="evaluationText"><?= trans("front.resale Real estate appraisal text") ?></p>

                <form id="evaluationForm" class="sec" method="post" action="{{ route('front.ajax','evaluation') }}">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12 ">
                            <div class="form-group">
                                <label class=""><?= trans("front.resale form title city") ?></label>
                                <select class="form-control selectpicker" data-live-search='true' name="ev_city_id" id="ev_city_id" required>
                                    <option value=""><?= trans("front.resale form title city") ?></option>
                                    <?php
                                    $cities = \App\Models\City::where('id', '!=', 2)->orderBy('placement')->get();
                                    ?>
                                    @foreach($cities as $city)
                                    <option value="<?= $city->id; ?>"><?= $city->getName() ?></option>
                                    @endforeach
                                </select>
                                <div class="invalid_city_id_ev disabled alert"><?= trans("front.resale form title alert city") ?></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 ">
                            <div class="form-group">
                                <label class=""><?= trans("front.resale form title region") ?></label>
                                <select class="form-control selectpicker" data-live-search='true'  name="ev_region_id" id="ev_region_id" required>
                                    <option value=""><?= trans("front.resale form title region") ?></option>
                                </select>
                                <div class="invalid_region_id_ev disabled alert"><?= trans("front.resale form title alert region") ?></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 ">
                            <div class="form-group">
                                <label class=""><?= trans("front.resale form title type") ?></label>
                                <select class="form-control selectpicker" name="ev_type_id" id="ev_type_id" required>
                                    <option value=""><?= trans("front.resale form title type") ?></option>
                                    <?php $types = Helper::query("ProjectType", "all"); ?>
                                    <?php /* @foreach($types as $r)
                                      <option value="<?= $r->id; ?>" data-type-en="<?= $r->name_en ?>"><?= $r->getName(); ?></option>
                                      @endforeach
                                     */ ?>
                                </select>
                                <div class="invalid_type_id_ev disabled alert"><?= trans("front.resale form title alert type") ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label class=""><?= trans("front.resale form title room") ?></label>
                                <select class="form-control selectpicker" name="ev_room" id="ev_room" required>
                                    <option value=""><?= trans("front.resale form title room") ?></option>
                                    <?php
                                    /* foreach ($types as $type) {
                                      $patt = [];
                                      if ($type->pattern != '')
                                      $patt = unserialize($type->pattern);

                                      foreach ($patt as $r) {
                                      ?>
                                      <option value="{{ $r['salon'] }}+{{ $r['room'] }}"

                                      data-type="{{ $type->name_en }}">{{ $r['salon'] }}+{{ $r['room'] }}</option>
                                      <?php
                                      }
                                      } */
                                    ?>
                                </select>
                                <div class="invalid_room_ev disabled alert"><?= trans("front.resale form title alert room") ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 ">
                            <div class="form-group">
                                <label class=""><?= trans("front.area (m)") ?></label>
                                <input class="form-control" name="ev_area" id="ev_area"/>
                                <div class="invalid_area_ev disabled alert"><?= trans("front.resale form title alert area") ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12 ">
                            <div class="form-group">
                                <label class=""><?= trans("front.resale form title building type") ?></label>
                                <select class="form-control selectpicker" name="ev_building_type" id="ev_building_type" required>
                                    <option value="" disabled><?= trans("front.resale form title building type") ?></option>
                                    <option value="Complex"><?= trans("front.resale form title building type Complex") ?></option>
                                    <option value="Normal" disabled><?= trans("front.resale form title building type Normal") ?></option>
                                </select>
                                <div class="invalid_building_type_ev disabled alert"><?= trans("front.resale form title alert building type") ?></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary send_btn" name="save" id="send_evaluation"><?= trans("front.Calculate") ?></button>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="price_sec_message d-none">
                    <p>
                        <?= trans("front.expected price") ?>
                    </p>
                    <b class="num"></b>
                </div>

            </div>




            <div class="int_content">

                <?= Form::open(["class" => "sec", "method" => "post", 'id' => 'resaleForm', 'novalidate' => '']); ?>
                <!--<form id="resaleForm" class="sec" method="post" action="{{ route('front.ajax','submit_resale') }}">-->

                <h2 class="sub_title jazzira_font_bold text_sec_title"><?= trans("front.resale form title") ?></h2>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title name") ?></label>
                            <input class="form-control" name="name2" id="name2"/>
                            <div class="invalid_name disabled alert"><?= trans("front.resale form title alert name") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title phone") ?></label>
                            <input id="mobile-sm" type="tel" class="form-control" name="phone" id="phone" required/>
                            <div class="invalid_phone disabled alert"><?= trans("front.resale form title alert phone") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title city") ?></label>
                            <select class="form-control selectpicker" data-live-search='true' name="ajax_city_id" id="ajax_city_id" required>
                                <option value=""><?= trans("front.resale form title city") ?></option>
                                <?php
                                $ajax_cities = DB::select("select CityID,CityName from dms_resal_city");
                                ?>
                                @foreach($ajax_cities as $city)
                                <option value="<?= $city->CityID; ?>"><?= $city->CityName ?></option>
                                @endforeach
                            </select>
                            <div class="invalid_city_id disabled alert"><?= trans("front.resale form title alert city") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title region") ?></label>
                            <select class="form-control selectpicker" data-live-search='true'  name="region_id" id="region_id" required>
                                <option value=""><?= trans("front.resale form title region") ?></option>
                            </select>
                            <div class="invalid_region_id disabled alert"><?= trans("front.resale form title alert region") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title district") ?></label>
                            <select class="form-control selectpicker" data-live-search='true' name="zone_id" id="zone_id" required>
                                <option value=""><?= trans("front.resale form title district") ?></option>
                            </select>
                            <div class="invalid_zone_id disabled alert"><?= trans("front.resale form title alert district") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title type") ?></label>
                            <select class="form-control selectpicker" name="type_id" id="type_id" required>
                                <option value=""><?= trans("front.resale form title type") ?></option>
                                <?php $types = Helper::query("ProjectType", "all"); ?>
                                @foreach($types as $r)
                                <option value="<?= $r->id; ?>" data-type-en="<?= $r->name_en ?>"><?= $r->getName(); ?></option>
                                @endforeach
                            </select>
                            <div class="invalid_type_id disabled alert"><?= trans("front.resale form title alert type") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 room_sec">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title room") ?></label>
                            <select class="form-control selectpicker" name="room" id="room" required>
                                <option class="first_option_room" value=""><?= trans("front.resale form title room") ?></option>
                                <?php
                                foreach ($types as $type) {
                                    $patt = [];
                                    if ($type->pattern != '')
                                        $patt = unserialize($type->pattern);

                                    foreach ($patt as $r) {
                                        ?>
                                        <option value="{{ $r['salon'] }}+{{ $r['room'] }}" 

                                                data-type="{{ $type->name_en }}">{{ $r['salon'] }}+{{ $r['room'] }}</option>
                                                <?php
                                            }
                                        }
                                        ?>
                            </select>
                            <div class="invalid_room disabled alert"><?= trans("front.resale form title alert room") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.area (m)") ?></label>
                            <input class="form-control" name="m2" id="m2"/>
                            <div class="invalid_m2 disabled alert"><?= trans("front.resale form title alert area") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale-details floor") ?></label>
                            <select class="form-control selectpicker" name="floor" id="floor">
                                <option value=""><?= trans("front.resale-details floor") ?></option>
                                <option value="-2">-2</option>
                                <option value="-1">-1</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                                <option value="17">17</option>
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                                <option value="32">32</option>
                                <option value="33">33</option>
                                <option value="34">34</option>
                            </select>
                            <div class="invalid_floor disabled alert"><?= trans("front.resale form title alert floor") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale-details kitchen") ?></label>
                            <select class="form-control selectpicker" name="kitchen" id="kitchen">
                                <option value=""><?= trans("front.resale-details kitchen") ?></option>
                                <option value="Open"><?= trans("front.resale-details kitchen open") ?></option>
                                <option value="Close"><?= trans("front.resale-details kitchen close") ?></option>
                            </select>
                            <div class="invalid_kitchen disabled alert"><?= trans("front.resale form title alert kitchen") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale-details bathroom") ?></label>
                            <select class="form-control selectpicker" name="bathroom" id="bathroom">
                                <option value=""><?= trans("front.resale-details bathroom") ?></option>
                                <option value="0"><?= trans("front.select no") ?></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                            </select>
                            <div class="invalid_bathroom disabled alert"><?= trans("front.resale form title alert bathroom") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale-details balcony") ?></label>
                            <select class="form-control selectpicker" name="balkon" id="balkon">
                                <option value=""><?= trans("front.resale-details balcony") ?></option>
                                <option value="0"><?= trans("front.select no") ?></option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                            <div class="invalid_balkon disabled alert"><?= trans("front.resale form title alert balcony") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title building type") ?></label>
                            <select class="form-control selectpicker" name="building_type" id="building_type" required>
                                <option value=""><?= trans("front.resale form title building type") ?></option>
                                <option value="Complex" ><?= trans("front.resale form title building type Complex") ?></option>
                                <option value="Normal"><?= trans("front.resale form title building type Normal") ?></option>
                            </select>
                            <div class="invalid_building_type disabled alert"><?= trans("front.resale form title alert building type") ?></div>
                        </div>
                    </div>
                    <div class="complex_name_sec">
                        <!--                        <div class="col-md-3 col-sm-6 col-xs-12">
                                                    <div class="form-group">
                                                        <label class=""><?= trans("front.resale form title building type Complex name") ?></label>
                                                        <input class="form-control" value="" name="complex_name" id="complex_name"/>
                                                        <div class="invalid_complex_name disabled alert"><?= trans("front.resale form title alert Complex name") ?></div>
                                                    </div>
                                                </div>-->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title view") ?></label>
                            <select class="form-control selectpicker" name="view" id="view" required>
                                <option value=""><?= trans("front.resale form title view") ?></option>							
                                <option value="Internal"><?= trans("front.resale form title view Internal") ?></option>
                                <option value="Alley"><?= trans("front.resale form title view Alley") ?></option>
                                <option value="Street"><?= trans("front.resale form title view Street") ?></option>
                                <option value="Sea"><?= trans("front.resale form title view Sea") ?></option>
                                <option value="Lake"><?= trans("front.resale form title view Lake") ?></option>
                                <option value="Sea Lake"><?= trans("front.resale form title view Sea Lake") ?></option>
                                <option value="Mountain"><?= trans("front.resale form title view Mountain") ?></option>
                                <option value="Valley"><?= trans("front.resale form title view Valley") ?></option>
                                <option value="Jungle"><?= trans("front.resale form title view Jungle") ?></option>
                                <option value="Landscape"><?= trans("front.resale form title view Landscape") ?></option>
                                <option value="City"><?= trans("front.resale form title view City") ?></option>
                                <option value="Bosphorus"><?= trans("front.resale form title view Bosphorus") ?></option>
                            </select>
                            <div class="invalid_view disabled alert"><?= trans("front.resale form title alert view") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title tabu") ?></label>
                            <select class="form-control selectpicker" name="tabu" id="tabu" required>
                                <option value=""><?= trans("front.resale form title tabu") ?></option>
                                <option value="1"><?= trans("front.resale form title tabu yes") ?></option>
                                <option value="0"><?= trans("front.resale form title tabu no") ?></option>
                            </select>
                            <div class="invalid_tabu disabled alert"><?= trans("front.resale form title alert tabu") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 ">
                        <div class="form-group">
                            <label class=""><?= trans("front.resale form title price") ?></label>
                            <div class="input-group price_sec">
                                <div class="input-group-prepend">
                                    <span class="input-group-text num" id="currency">TL</span>
                                </div>
                                <input type="hidden" value="TRY" name="currency" />
                                <input type="text" class="form-control" id="price" name="price" aria-describedby="currency" required>
                            </div>
                            <div class="invalid_price disabled alert"><?= trans("front.resale form title alert price") ?></div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary send_btn" name="save" id="bsave"><?= trans("front.resale form title send") ?></button>
                        </div>
                    </div>

                </div>
                </form>
                <div class="success_message">
                    <div class="ui-success">
                        <svg width="50" height="50" viewBox="0 0 87 87" version="1.1">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Group-3" transform="translate(2.000000, 2.000000)">
                        <circle id="Oval-2" stroke="rgba(165, 220, 134, 0.2)" stroke-width="4" cx="41.5" cy="41.5" r="41.5"></circle>
                        <circle  class="ui-success-circle" id="Oval-2" stroke="#A5DC86" stroke-width="4" cx="41.5" cy="41.5" r="41.5"></circle>
                        <polyline class="ui-success-path" id="Path-2" stroke="#A5DC86" stroke-width="4" points="19 38.8036813 31.1020744 54.8046875 63.299221 28"></polyline>
                        </g>
                        </g>
                        </svg>
                    </div>
                    <h2>
                        <?= trans("front.Your request has been sent successfully") ?>
                        <br>
                        <?= trans("front.Your request has been sent successfully text") ?>
                    </h2>
                    <a href="https://wa.me/905496421045?text=<?= trans("front.Hello, I would like to inquire about this request") ?>" class="whatsapp_icon" target="_blank">
                        <i class="fa fa-whatsapp my-float"></i>
                    </a>
                </div>
            </div>









        </section>



    </div>
</div>







@endsection



@section('scriptjs')



<script>
    $(document).ready(function () {
        $('body').on('change', '#type_id', function () {
            var type = $(this).find('option:selected').data('type-en');
            if ($(this).val() != '') {
                if (type == "office" || type == "shop") {
                    $('#room option').not(':first').hide();
                    $('.first_option_room').val("none").prop("selected", true);
                    $('.resale_form select[name="room"]').removeClass("error");
                    $('.resale_form select[name="room"]').parents(".bootstrap-select").removeClass("error");
                    $('.invalid_room').hide();
                    $('#room').selectpicker('refresh');
                } else {
                    $('.first_option_room').val("");
                    $(".option_none").remove();
                    $('#room option').not(':first').hide();
                    $('#room option:selected').prop("selected", false);
                    $('#room').val("");
                    $('#room option[data-type=' + type + ']').show();
                    $('#room').selectpicker('refresh');
                }

            }
        });


        $('body').on('change', '#building_type', function () {

            var building_type = $(this).val();
            if (building_type == "Complex") {
                $(".complex_name_sec").addClass("col-md-3 col-sm-6 col-xs-12");
                $(".complex_name_sec").append(
                        '<div class="form-group">' +
                        '<label class=""><?= trans("front.resale form title building type Complex name") ?></label>' +
                        '<input class="form-control" value="" name="complex_name" id="complex_name"/>' +
                        '<div class="invalid_complex_name disabled alert"><?= trans("front.resale form title alert Complex name") ?></div>' +
                        '</div>'
                        );
                $('input[name="complex_name"]').focus();
            } else {
                $(".complex_name_sec").removeClass("col-md-3 col-sm-6 col-xs-12");
                $(".complex_name_sec").empty();
            }

        });



        /* check price  */
        $('body').on('change', '#ev_city_id', function () {
            $('.price_sec_message').addClass('d-none');

            var city_id = $(this).val();
            $.ajax({
                type: "post",
                data: {
                    _token: "<?= csrf_token(); ?>",
                    city_id: city_id
                },
                url: "{{ route('front.ajax','load_complex_regions') }}",
                success: function (response) {
                    $('#ev_region_id').html(response);
                    $('#ev_region_id').selectpicker('refresh');
                },
                error: function (response) {
                    alert('The operation failed..., Please reload the page and try again');
                }
            });
        });
        $('body').on('change', '#ev_region_id', function () {

            $('.price_sec_message').addClass('d-none');
            var region_id = $(this).val();
            $.ajax({
                type: "post",
                data: {
                    _token: "<?= csrf_token(); ?>",
                    region_id: region_id
                },
                url: "{{ route('front.ajax','load_complex_types_by_region') }}",
                success: function (response) {
                    $('#ev_type_id').html(response);
                    $('#ev_type_id').selectpicker('refresh');
                },
                error: function (response) {
                    alert('The operation failed..., Please reload the page and try again');
                }
            });
        });
        $('body').on('change', '#ev_type_id', function () {

            $('.price_sec_message').addClass('d-none');
            var region_id = $('#ev_region_id').val();
            var type_id = $(this).val();
            $.ajax({
                type: "post",
                data: {
                    _token: "<?= csrf_token(); ?>",
                    region_id: region_id,
                    type_id: type_id
                },
                url: "{{ route('front.ajax','load_complex_rooms_by_types_and_region') }}",
                success: function (response) {
                    $('#ev_room').html(response);
                    $('#ev_room').selectpicker('refresh');
                },
                error: function (response) {
                    alert('The operation failed..., Please reload the page and try again');
                }
            });
        });



        $('body').on('change', '#ajax_city_id', function () {


            var city_id = $(this).val();
            $.ajax({
                type: "post",
                data: {
                    _token: "<?= csrf_token(); ?>",
                    city_id: city_id
                },
                url: "{{ route('front.ajax','load_regions') }}",
                success: function (response) {
                    $('#region_id').html(response);
                    $('#region_id').selectpicker('refresh');
                },
                error: function (response) {
                    alert('The operation failed..., Please reload the page and try again');
                }
            });
        });
        $('body').on('change', '#region_id', function () {


            var region_id = $(this).val();
            $.ajax({
                type: "post",
                data: {
                    _token: "<?= csrf_token(); ?>",
                    region_id: region_id
                },
                url: '{{ route('front.ajax','load_zones') }}',
                success: function (response) {
                    $('#zone_id').html(response);
                    $('#zone_id').selectpicker('refresh');
                },
                error: function (response) {
                    alert('The operation failed..., Please reload the page and try again');
                }
            });
        });
        $('#bsave').click(function (e) {
			var btn_sbmint = $(this);
			btn_sbmint.attr("disabled", true);
			
			
            /*prevent default action and bubbling*/
            e.preventDefault();
            var phoneFilter = /\d{10}\b/;
            var numberFilter = /^-?\d+$/;
            /* variables for input field values*/
            var name = $('.resale_form input[name="name2"]').val();
            var phone = $('.resale_form input[name="phone"]').val().replace(" ", "").replace(" ", "").replace(" ", "").replace(" ", "");
            var city_id = $('.resale_form select[name="ajax_city_id"]').val();
            var region_id = $('.resale_form select[name="region_id"]').val();
            var zone_id = $('.resale_form select[name="zone_id"]').val();
            var type_id = $('.resale_form select[name="type_id"]').val();
            var room = $('.resale_form select[name="room"]').val();
            var m2 = $('.resale_form input[name="m2"]').val();
            var floor = $('.resale_form select[name="floor"]').val();
            var kitchen = $('.resale_form select[name="kitchen"]').val();
            var bathroom = $('.resale_form select[name="bathroom"]').val();
            var balkon = $('.resale_form select[name="balkon"]').val();
            var building_type = $('.resale_form select[name="building_type"]').val();
            var complex_name = $('.resale_form input[name="complex_name"]').val();
            var view = $('.resale_form select[name="view"]').val();
            var tabu = $('.resale_form select[name="tabu"]').val();
            var price = $('.resale_form input[name="price"]').val();
            /* if email is invalid... **/

            if (name == "") {
                $('.invalid_name').show().delay(2000).fadeOut(300);
                $('.resale_form input[name="name2"]').focus();
                $('.resale_form input[name="name2"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (!phoneFilter.test(phone)) {
                /* show invalid message and hide others*/
                $('.invalid_phone').show().delay(2000).fadeOut(300);
                $('.resale_form input[name="phone"]').focus();
                $('.resale_form input[name="phone"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (city_id == "") {
                $('.invalid_city_id').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="ajax_city_id"]').focus();
                $('.resale_form select[name="ajax_city_id"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (region_id == "") {
                $('.invalid_region_id').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="region_id"]').focus();
                $('.resale_form select[name="region_id"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (zone_id == "") {
                $('.invalid_zone_id').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="zone_id"]').focus();
                $('.resale_form select[name="zone_id"]').addClass("error");
            } else if (type_id == "") {
                $('.invalid_type_id').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="type_id"]').focus();
                $('.resale_form select[name="type_id"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (room == "") {
                $('.invalid_room').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="room"]').focus();
                $('.resale_form select[name="room"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (m2 == "") {
                $('.invalid_m2').show().delay(2000).fadeOut(300);
                $('.resale_form input[name="m2"]').focus();
                $('.resale_form input[name="m2"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (floor == "") {
                $('.invalid_floor').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="floor"]').focus();
                $('.resale_form select[name="floor"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (kitchen == "") {
                $('.invalid_kitchen').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="kitchen"]').focus();
                $('.resale_form select[name="kitchen"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (bathroom == "") {
                $('.invalid_bathroom').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="bathroom"]').focus();
                $('.resale_form select[name="bathroom"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (balkon == "") {
                $('.invalid_balkon').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="balkon"]').focus();
                $('.resale_form select[name="balkon"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (building_type == "") {
                $('.invalid_building_type').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="building_type"]').focus();
                $('.resale_form select[name="building_type"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (complex_name == "") {
                $('.invalid_complex_name').show().delay(2000).fadeOut(300);
                $('.resale_form input[name="complex_name"]').focus();
                $('.resale_form input[name="complex_name"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (view == "") {
                $('.invalid_view').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="view"]').focus();
                $('.resale_form select[name="view"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (tabu == "") {
                $('.invalid_tabu').show().delay(2000).fadeOut(300);
                $('.resale_form select[name="tabu"]').focus();
                $('.resale_form select[name="tabu"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else if (!numberFilter.test(price)) {
                $('.invalid_price').show().delay(2000).fadeOut(300);
                $('.resale_form input[name="price"]').focus();
                $('.resale_form input[name="price"]').addClass("error");
				btn_sbmint.removeAttr("disabled");
            } else {

                var formURL = "{{ route('front.ajax','submit_resale') }}";
                var postData = $("form#resaleForm").serialize();
                $.ajax({
                    type: 'POST',
                    url: formURL,
                    data: postData,
                    success: function (response) {
                        if (response.success == true) {
                            $('#resaleForm').hide();



                            $('.success_message .whatsapp_icon').attr('href', $('.success_message .whatsapp_icon').attr('href') + response.code);
                            $('.success_message').show();
                        } else {
                            alert("reeor");
							btn_sbmint.removeAttr("disabled");
                        }
                        /*$(location).attr('href', '/home');*/
                    },
                    error: function (errorThrown) {
                        alert("reeor");
						btn_sbmint.removeAttr("disabled");
                        /* show error message and hide others9*/
                        $('.error').show().delay(2000).fadeOut(300);
                        $('.invalid, .success').hide();
                        /* log error message in console
                        console.log(errorThrown);*/
                    }
                });
            }
        });
        $(".resale_form input").keyup(function () {
            var thisVal = $(this).val();
            var thisAlert = $(this).parents(".form-group").find(".alert");
            if (thisVal != "") {
                $(this).removeClass("error");
                $(thisAlert).fadeOut();
            } else {
                $(this).addClass("error");
                $(thisAlert).fadeIn();
            }
        });
        $(".resale_form select").on("change", function () {
            var thisVal = $(this).val();
            var thisParents = $(this).parents(".bootstrap-select");
            var thisAlert = $(this).parents(".form-group").find(".alert");
            if (thisVal != "") {
                $(thisParents).removeClass("error");
                $(thisAlert).fadeOut();
            } else {
                $(thisParents).addClass("error");
                $(thisAlert).fadeIn();
            }
        });
    });
    $(window).scroll(function () {
        var scrollingPage = 0;
        var scrollingPage2 = 500;
        ;
        var scroll = $(window).scrollTop();
        if (scroll >= scrollingPage) {
            $(".header").addClass("scrolling");
        } else {
            $(".header").removeClass("scrolling");
        }
        if (scroll >= scrollingPage2) {
            $(".fixed_sec").addClass("fixed");
        } else {
            $(".fixed_sec").removeClass("fixed");
        }
    });






    $('#send_evaluation').click(function (e) {
        /*prevent default action and bubbling*/
        e.preventDefault();
        var numberFilter = /^-?\d+$/;
        /* variables for input field values*/
        var city_id_ev = $('.resale_form select[name="ev_city_id"]').val();
        var region_id_ev = $('.resale_form select[name="ev_region_id"]').val();
        var type_id_ev = $('.resale_form select[name="ev_type_id"]').val();
        var room_ev = $('.resale_form select[name="ev_room"]').val();
        var area_ev = $('.resale_form input[name="ev_area"]').val();
        var building_type_ev = $('.resale_form select[name="ev_building_type"]').val();

        $('.price_sec_message').addClass('d-none');

        if (city_id_ev == "") {
            $('.invalid_city_id_ev').show().delay(2000).fadeOut(300);
            $('.resale_form select[name="ev_city_id"]').focus();
            $('.resale_form select[name="ev_city_id"]').addClass("error");
        } else if (region_id_ev == "") {
            $('.invalid_region_id_ev').show().delay(2000).fadeOut(300);
            $('.resale_form select[name="ev_region_id"]').focus();
            $('.resale_form select[name="ev_region_id"]').addClass("error");
        } else if (type_id_ev == "") {
            $('.invalid_type_id_ev').show().delay(2000).fadeOut(300);
            $('.resale_form select[name="ev_type_id"]').focus();
            $('.resale_form select[name="ev_type_id"]').addClass("error");
        } else if (room_ev == "") {
            $('.invalid_room_ev').show().delay(2000).fadeOut(300);
            $('.resale_form select[name="ev_room"]').focus();
            $('.resale_form select[name="ev_room"]').addClass("error");
        } else if (!numberFilter.test(area_ev)) {
            $('.invalid_area_ev').show().delay(2000).fadeOut(300);
            $('.resale_form input[name="ev_area"]').focus();
            $('.resale_form input[name="ev_area"]').addClass("error");
        } else if (building_type_ev == "") {
            $('.invalid_building_type_ev').show().delay(2000).fadeOut(300);
            $('.resale_form select[name="ev_building_type"]').focus();
            $('.resale_form select[name="ev_building_type"]').addClass("error");
        } else {


            /*setTimeout( function(){ */
            m2_p = $('#ev_room :selected').data('m2-price');
            area = $('#ev_area').val();
            $('.price_sec_message').removeClass('d-none');
            $('.price_sec_message .num').html(m2_p * area + ' TRY');
            /*}  , 2000 );*/

            /*var formURL = "{{ route('front.ajax','submit_evaluationForm') }}";
             var postData = $("form#resaleForm").serialize();
             $.ajax({
             type: 'POST',
             url: formURL,
             data: postData,
             success: function (response) {
             if (response.success == true) {
             alert("success");
             } else {
             alert("reeor");
             }
             //$(location).attr('href', '/home');
             },
             error: function (errorThrown) {
             alert("reeor");
             // show error message and hide others9
             $('.error').show().delay(2000).fadeOut(300);
             $('.invalid, .success').hide();
             // log error message in console
             console.log(errorThrown);
             }
             });*/
        }
    });



</script>



@endsection