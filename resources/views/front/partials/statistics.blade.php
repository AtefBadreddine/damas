<?php
$hide_demog_most = isset($hide_demog_most) ? $hide_demog_most : false;
$hide_most = isset($hide_most) ? $hide_most : false;

if ($current_lang == 'ar')
    $list_months = array('يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر');
else
    $list_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');


$static_citys = array('Trabzon' => 'طرابزون', 'Ankara' => 'أنقرة', 'Bursa' => 'بورصة', 'Antalya' => 'أنطاليا',
    'Istanbul' => 'اسطنبول', 'Mersin' => 'مرسين', 'Yalova' => 'يالوفا', 'Mugla' => 'موغلا', 'Sakarya' => 'سكاريا', 'Samsun' => 'سامسون');
?>
<input type="hidden" value='<?= $region_name ?>' id="iregion_name">
<input type="hidden" value='<?= $region_name_en ?>' id="iregion_name_en">
<div class="statistics-section">
    
<!--    <h2><img src="<?= asset("img/chart-icon.png"); ?>" alt="Damas"/> {{ trans('front.Region Report') }}</h2>-->
    <div class="my-row">

        <?php /* @if($hide_demog_most==false) */ ?>

        <?php if ((int) $data_demog['population'] > 0) { ?>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">
                <div class="title"><h3>{{ trans('front.Social status in') }} <?= $region_name ?></h3></div>
                <div class="content-new">
                    <div class="col-md-6 col-sm-6 col-xs-6 pull-left border-bottom">
                        <div class="col-md-12 col-sm-12 col-xs-12 pull-left">
                            <div class="section population">
                                <div class="image-cont"></div>
                                <p>{{ trans('front.population') }}</p>
                                <span><strong class="count"><?= number_format($data_demog['population'], 0, ',', '.') ?></strong></span>
                                <span>{{ trans('front.people') }}</span>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 pull-left padding border-right">
                            <div id="pie"></div>
                            <ul class="progess-info">
                                <li><span class="dot"></span><p>{{ trans('front.Males') }}</p></li>
                                <li class="left"><p>{{ trans('front.Females') }}</p><span class="dot green"></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 pull-left">
                        <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                            <div class="section age">
                                <div class="image-cont"></div>
                                <p>{{ trans('front.Average age') }}</p>
                                <span class="sub"><strong class="count"><?= round($data_demog['averageAge']) ?></strong><strong>{{ trans('front.year') }}</strong></span>
                                <span>({{ trans('front.young society') }})</span>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 pull-left padding">
                            <div id="pie2"></div>
                            <ul class="progess-info">
                                <li><span class="dot red"></span><p>{{ trans('front.Married') }}</p></li>
                                <li class="left"><p>{{ trans('front.Single') }}</p><span class="dot orange"></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php /* @endif */ ?>

        <?php
        if ($r_reg->transport + $r_reg->health + $r_reg->social + $r_reg->shopping + $r_reg->schools > 0) {


            $sum_red = $r_reg->transport * (sin(deg2rad(72)) * $r_reg->health) / 2;
            $sum_red = $sum_red + $r_reg->social * (sin(deg2rad(72)) * $r_reg->health) / 2;
            $sum_red = $sum_red + $r_reg->social * (sin(deg2rad(72)) * $r_reg->shopping) / 2;
            $sum_red = $sum_red + $r_reg->schools * (sin(deg2rad(72)) * $r_reg->shopping) / 2;
            $sum_red = $sum_red + $r_reg->schools * (sin(deg2rad(72)) * $r_reg->transport) / 2;

            $max_val = max($r_reg->transport, $r_reg->health, $r_reg->social, $r_reg->shopping, $r_reg->schools);


            $sum_all = ($max_val * (sin(deg2rad(72)) * $max_val) / 2) * 5;
            ?>
            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">
                <div class="title"><h3>{{ trans('front.Services and power of the region') }} <?= $region_name ?>

                        <?= round(($sum_red / $sum_all) * 100, 0) . '%'; ?>
                    </h3></div>
                <div class="content-new">
                    <div class="section-radar">

                        <?php if ($current_lang == 'ar') { ?>
                            <div class="icon-one area-services-btn" data-id="<?= $r_reg->health_desc ?>" data-title="{{ trans('front.health-institutions') }}"><img src="<?= asset('/img/health-institutions.svg') ?>" alt="health-institutions"/></div>
                            <div class="icon-two area-services-btn" data-id="<?= $r_reg->transport_desc ?>" data-title="{{ trans('front.transportation') }}"><img src="<?= asset('/img/transportation.svg') ?>" alt="transportation"/></div>
                            <div class="icon-three area-services-btn" data-id="<?= $r_reg->schools_desc ?>" data-title="{{ trans('front.schools') }}"><img src="<?= asset('/img/schools.svg') ?>" alt="schools"/></div>
                            <div class="icon-four area-services-btn" data-id="<?= $r_reg->shopping_desc ?>" data-title="{{ trans('front.shopping') }}"><img src="<?= asset('/img/shopping.svg') ?>" alt="shopping"/></div>
                            <div class="icon-five area-services-btn" data-id="<?= $r_reg->social_desc ?>" data-title="{{ trans('front.facilities') }}"><img src="<?= asset('/img/facilities.svg') ?>" alt="facilities"/></div>
                        <?php } else { ?>
                            <div class="icon-one area-services-btn" data-id="<?= $r_reg->health_desc ?>" data-title="{{ trans('front.health-institutions') }}"><img src="<?= asset('/img/health-institutions-'.$current_lang.'.svg') ?>" alt="health-institutions"/></div>
                            <div class="icon-two area-services-btn" data-id="<?= $r_reg->transport_desc ?>" data-title="{{ trans('front.transportation') }}"><img src="<?= asset('/img/transportation-'.$current_lang.'.svg') ?>" alt="transportation"/></div>
                            <div class="icon-three area-services-btn" data-id="<?= $r_reg->schools_desc ?>" data-title="{{ trans('front.schools') }}"><img src="<?= asset('/img/schools-'.$current_lang.'.svg') ?>" alt="schools"/></div>
                            <div class="icon-four area-services-btn" data-id="<?= $r_reg->shopping_desc ?>" data-title="{{ trans('front.shopping') }}"><img src="<?= asset('/img/shopping-'.$current_lang.'.svg') ?>" alt="shopping"/></div>
                            <div class="icon-five area-services-btn" data-id="<?= $r_reg->social_desc ?>" data-title="{{ trans('front.facilities') }}"><img src="<?= asset('/img/facilities-'.$current_lang.'.svg') ?>" alt="facilities"/></div>
                        <?php }
                        ?>
                        <canvas id="radarChart" width="400" height="380"></canvas>
                    </div>
                </div>
            </div>
        <?php } ?>


        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">
            <div class="title"><h3>{{ trans('front.Projects sold in') }} <?= $region_name ?></h3></div>
            <div class="content-new">
                <!---- Start Section Filters ---->
                <div class="chart-filters chart-filters-sale">
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <div class="col s4 dropOption select-years-one">
                            <div class="input-field select">
                                <div class="dropdown dropdown--image" value="">
                                    <div class="dropdown__select">
                                        <div class="dropdown__select-wrap">
                                            <span>{{ trans('front.year') }}</span>
                                        </div>
                                    </div>
                                    <div class="dropdown__options-wrap">
                                        <input type="hidden" value="" name="rs_year"/>
                                        <a class="dropdown__option">
                                            <span data-value='0'>{{ trans('front.all') }}</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2019'>2019</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2018'>2018</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2017'>2017</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2016'>2016</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2015'>2015</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="price_type" value="price_m" checked class="btn btn-outline-primary"><label>{{ trans('front.Price per meter') }}</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="project_type" value="apartments_villas" checked class="btn btn-outline-primary"><label>{{ trans('front.Apartments and villas') }}</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <div class="col s4 dropOption select-months-one">
                        <!--<select >
                                                                                                                <option value="">الشهر</option>
                                                                                                                <option value="juin">يناير</option>
                                                                                                                </select>-->
                            <div class="input-field select">
                                <div class="dropdown dropdown--image" value="">
                                    <div class="dropdown__select">
                                        <div class="dropdown__select-wrap">
                                            <span>{{ trans('front.month') }}</span>
                                        </div>
                                    </div>
                                    <div class="dropdown__options-wrap">
                                        <input type="hidden" value="" name="rs_month"/>
                                        <a class="dropdown__option">
                                            <span data-value="0">{{ trans('front.all') }}</span>
                                        </a>
                                        <?php
                                        $i = 1;
                                        foreach ($list_months as $m) {
                                            ?>
                                            <a class="dropdown__option">
                                                <span data-value="<?= $i ?>"><?= $m ?></span>
                                            </a>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="price_type" value="price_total" class="btn btn-outline-primary"><label>{{ trans('front.total price') }}</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="project_type" value="office_shops" class="btn btn-outline-primary"><label>{{ trans('front.Offices and shops') }}</label>
                    </div>
                </div>
                <!---- Start Section Filters ---->

                <canvas id="propertiesSold" width="250" height="250"></canvas>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">
            <div class="title"><h3>{{ trans('front.Rental properties in') }} {{ $region_name }}</h3></div>
            <div class="content-new">

                <!---- Start Section Filters ---->
                <div class="chart-filters chart-filters-rent">
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <div class="col s4 dropOption select-years-two">
                            <div class="input-field select">
                                <div class="dropdown dropdown--image" value="">
                                    <div class="dropdown__select">
                                        <div class="dropdown__select-wrap">
                                            <span>{{ trans('front.year') }}</span>
                                        </div>
                                    </div>
                                    <div class="dropdown__options-wrap">
                                        <input type="hidden" value="0" name="r_rs_year"/>
                                        <a class="dropdown__option">
                                            <span data-value='0'>{{ trans('front.all') }}</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2019'>2019</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2018'>2018</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2017'>2017</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2016'>2016</span>
                                        </a>
                                        <a class="dropdown__option">
                                            <span data-value='2015'>2015</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="r_price_type" value="price_m" checked class="btn btn-outline-primary"><label>{{ trans('front.Price per meter') }}</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="r_project_type" value="apartments_villas" checked class="btn btn-outline-primary"><label>{{ trans('front.Apartments and villas') }}</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <div class="col s4 dropOption select-months-two">
                            <div class="input-field select">
                                <div class="dropdown dropdown--image" value="">
                                    <div class="dropdown__select">
                                        <div class="dropdown__select-wrap">
                                            <span>{{ trans('front.month') }}</span>
                                        </div>
                                    </div>
                                    <div class="dropdown__options-wrap">
                                        <input type="hidden" value="0" name="r_rs_month"/>
                                        <a class="dropdown__option">
                                            <span data-value="0">{{ trans('front.all') }}</span>
                                        </a>
                                        <?php
                                        $i = 1;
                                        foreach ($list_months as $m) {
                                            ?>
                                            <a class="dropdown__option">
                                                <span data-value="<?= $i ?>"><?= $m ?></span>
                                            </a>
                                            <?php
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="r_price_type" value="price_total" class="btn btn-outline-primary"><label>{{ trans('front.total price') }}</label>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                        <input type="radio" name="r_project_type" value="office_shops" class="btn btn-outline-primary"><label>{{ trans('front.Offices and shops') }}</label>
                    </div>
                </div>
                <!---- Start Section Filters ---->

                <canvas id="rentalProperties" width="250" height="250"></canvas>
            </div>
        </div>

        @if($hide_most==false)
        @include("front.partials.statistics_most", [])
        @endif
    </div>
</div>
<!-- End Statistics Section -->

<div class="area-services-modal animated">
    <i class="fa fa-close"></i>
    <div class="int-content">
        <h2><span></span> <?= $region_name ?></h2>
        <div class="text">
            <p>

            </p>
        </div>
    </div>
</div>