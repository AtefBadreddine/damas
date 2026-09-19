<?php
/*
$current_lang = LaravelLocalization::getCurrentLocale();
$fix_lang = ($current_lang == 'ar' ? '_ar' : '');
$ncountrys = DB::select("select country_ar,country from stat_house_sales where type='country' group by country");
$ncitys = DB::select("select city,city_ar from stat_house_sales where type ='city' group by city");
$nyears = DB::select("select distinct year from stat_house_sales order by year desc");


if ($current_lang == 'ar')
    $list_months = array('يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر');
else
    $list_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
?>
<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">
    <div class="chart_content c shadow_type">
        <div class="title"><h3>{{ trans('front.Mots Nationalities Buying Houses in Turkey') }}</h3></div>
        <div class="content-new myChart myChart_n">
            <!---- Start Section Filters ---->
            <div class="chart-filters">
                <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                    <div class="col s4 dropOption select-years-three">
                        <div class="input-field select">
                            <div class="dropdown dropdown--image" value="">
                                <div class="dropdown__select">
                                    <div class="dropdown__select-wrap">
                                        <span>{{ trans('front.year') }}</span>
                                    </div>
                                </div>
                                <div class="dropdown__options-wrap">
                                    <input type="hidden" value="" name="n_rs_year"/>
									<a class="dropdown__option">
                                        <span data-value='0'>{{ trans('front.all') }}</span>
                                    </a>
                                    <?php
									foreach ($nyears as $y) { ?>
                                        <a class="dropdown__option">
                                            <span data-value='<?= $y->year ?>'><?= $y->year ?></span>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                    <div class="col s4 dropOption select-months-three">
                        <div class="input-field select">
                            <div class="dropdown dropdown--image" value="">
                                <div class="dropdown__select">
                                    <div class="dropdown__select-wrap">
                                        <span>{{ trans('front.month') }}</span>
                                    </div>
                                </div>
                                <div class="dropdown__options-wrap">
                                    <input type="hidden" value="0" name="n_rs_month"/>
									
									<a class="dropdown__option">
                                        <span data-value='0'>{{ trans('front.all') }}</span>
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
                <div class="col-md-4 col-sm-4 col-xs-12 pull-right blk_select_countrys">
                    <span class="speech-bubble animated">{{ trans('front.alert message slect only') }}</span>
                    <input type="hidden" id="select-countrie-last" value="" />
                    <select id="select-countries" multiple="multiple">
                        <?php
                        foreach ($ncountrys as $y) {
                            $cofx = 'country' . $fix_lang;
                            ?>
                            <option value="<?= $y->country ?>"><?= $y->$cofx ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!---- Start Section Filters ---->


            <!---- Start Chart ---->
            <div class="chart">
                <div class="bars">
                    <div class="firstLine"><span>0</span></div>
                    <div class="secondLine"><span>500</span></div>
                    <div class="thirdLine"><span>1000</span></div>
                    <div class="fourthLine"><span>2000</span></div>
                    <ul>
                    </ul>
                </div>
                <div class="lables">
                    <ul>
                    </ul>
                </div>
            </div>
            <!---- End Chart ---->

        </div>
    </div>
</div>

<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 pull-right">
    <div class="chart_content n shadow_type">
        <div class="title"><h3>{{ trans('front.Most Turkish cities buy properties') }}</h3></div>
        <div class="content-new myChart myChart_c">
            <!---- Start Section Filters ---->
            <div class="chart-filters">
                <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                    <div class="col s4 dropOption select-years-four">

                        <div class="input-field select">
                            <div class="dropdown dropdown--image" value="">
                                <div class="dropdown__select">
                                    <div class="dropdown__select-wrap">
                                        <span>{{ trans('front.year') }}</span>
                                    </div>
                                </div>
                                <div class="dropdown__options-wrap">

                                    <input type="hidden" value="0" name="tc_year"/>

                                    <a class="dropdown__option">
                                        <span data-value='0'>{{ trans('front.all') }}</span>
                                    </a>
                                    <?php
									foreach ($nyears as $y) {
										if((int)$y->year>=2015){
										?>
                                        <a class="dropdown__option">
                                            <span data-value='<?= $y->year ?>'><?= $y->year ?></span>
                                        </a>
                                    <?php }} ?>
									
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 pull-right">
                    <div class="col s4 dropOption select-months-four">
                        <div class="input-field select">
                            <div class="dropdown dropdown--image" value="">
                                <div class="dropdown__select">
                                    <div class="dropdown__select-wrap">
                                        <span>{{ trans('front.month') }}</span>
                                    </div>
                                </div>
                                <div class="dropdown__options-wrap">
                                    <input type="hidden" value="0" name="tc_month"/>
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
                <div class="col-md-4 col-sm-4 col-xs-12 pull-right blk_select_citys">
                    <span class="speech-bubble animated">{{ trans('front.alert message slect only') }}</span>
                    <input type="hidden" id="select-citie-last" value="" />
                    <select id="select-cities" name="tc_citys[]" multiple="multiple">
                        <?php
                        foreach ($ncitys as $c) {
                            $cifx = 'city' . $fix_lang;
                            ?>
                            <option value="<?= $c->city ?>"><?= $c->$cifx ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!---- End Section Filters ---->

            <!---- Start Chart ---->
            <div class="chart">
                <div class="bars">
                    <div class="firstLine"><span>0</span></div>
                    <div class="secondLine"><span>500</span></div>
                    <div class="thirdLine"><span>1000</span></div>
                    <div class="fourthLine"><span>2000</span></div>
                    <ul>
                        
                    </ul>
                </div>
                <div class="lables">
                    <ul>
                    </ul>
                </div>
            </div>
            <!---- End Chart ---->

        </div>
    </div>
</div>*/ ?>