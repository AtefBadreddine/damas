<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;
/* $arr_prices = [
  "50000-100000" => Helper::usd_to_format("50K $") . "-" . Helper::usd_to_format("100K $"), "100000-150000" => Helper::usd_to_format("100K $") . "-" . Helper::usd_to_format("150K $"), "150000-250000" => Helper::usd_to_format("150K $") . "-" . Helper::usd_to_format("250K $"), "250000-400000" => Helper::usd_to_format("250K $") . "-" . Helper::usd_to_format("400K $"), "400000-600000" => Helper::usd_to_format("400K $") . "-" . Helper::usd_to_format("600K $"), "600000-1000000" => Helper::usd_to_format("600K $") . "-" . Helper::usd_to_format("1M $"), "1000000-2000000" => Helper::usd_to_format("1M $") . "-" . Helper::usd_to_format("2M $"), "2000000-+" => '+' . Helper::usd_to_format("2M $")
  ]; */
$right = ($style_lang == 'ar' ? 'right' : 'left');
$all_project_types = Helper::query('ProjectType', 'all');
//$emptypic = '/img/0.png';
$emptypic = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
$proj_cats = Helper::query('ProjectCategory', "where", ["field" => "hide_search_page", "value" => false])->get();
?>
<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?= Html::style("resources/assets/css/living.css"); ?>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("resources/assets/css/living-en.css"); ?>
    <?php } ?>

<?php } else { ?>

    <?= Html::style("css/slider-project-card.min.css"); ?>
    <?= Html::style("css/living.min.css"); ?>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("css/living-en.min.css"); ?>
    <?php } ?>

<?php } ?>


@endsection



@extends('front.layout', [
"page_title"        =>    $page->getSeoTitle(),
"page_description"  =>    $page->getSeoDescription(),
"page_keywords"     =>    $page->getSeoKeywords(),
"og_image"          =>    ($page->media?Helper::media_url_full($page->media):null)
])



@section('main_content')


<div class="top_animate_sec">
    <div class="container">
        <div class="image_group">


            <h1 class="jazzira_font living_page">
                <span><?= trans("front.Living in Turkey"); ?></span>
                <span><?= trans("front.Living in Turkey sub title"); ?></span>
            </h1>

            <img class="base animate__animated" src="<?= asset("/img/Base.png"); ?>" alt="damasturk"/>
            <img class="living_page_top_1 animate__animated" src="<?= asset("/img/living-page-top-1.png"); ?>" alt="damasturk"/>
            <img class="living_page_top_2 animate__animated" src="<?= asset("/img/living-page-top-2.png"); ?>" alt="damasturk"/>
            <img class="living_page_top_3 animate__animated" src="<?= asset("/img/living-page-top-3.png"); ?>" alt="damasturk"/>
            <img class="living_page_top_4 animate__animated" src="<?= asset("/img/living-page-top-4.png"); ?>" alt="damasturk"/>


            <img class="cloud1 animate__animated" src="<?= asset("/img/cloud1.png"); ?>" alt="damasturk"/>
            <img class="cloud2 animate__animated" src="<?= asset("/img/cloud2.png"); ?>" alt="damasturk"/>
            <img class="cloud3 animate__animated" src="<?= asset("/img/cloud3.png"); ?>" alt="damasturk"/>
        </div>
    </div>
</div>




<div class="col-md-10 offset-md-1">
    <div class="full_sections">


        <div class="left_sec">

            <?php //if (Helper::get_device() == 'mob') { ?>
                <section class="form shadow_type mob_form">
                    @include("front.partials.call_us_fixed")
                </section>
            <?php //} ?>

            <div class="col-md-12">
                <div class="int_content population_sec">
                    <img class="icon" src="<?= asset("/img/population-icon.png"); ?>" alt="damasturk"/>
                    <span class="jazzira_font"><p><?= trans("front.population"); ?>:</p><strong class="jazzira_font_bold">90 <?= trans("front.Million"); ?></strong></span>
                    <div class="line"></div>
                    <span class="jazzira_font"><p><?= trans("front.Religion"); ?>:</p><strong class="jazzira_font_bold"><?= trans("front.Islam"); ?></strong></span>
                </div>
            </div>

            <div class="col-md-12">
                <div class="int_content ethnicities_sec">
                    <h2 class="sub_title"><?= trans("front.Ethnicities and official language"); ?></h2>

                    <?php /*if (Helper::get_device() == 'mob') { ?>
                        <img src="<?= asset("/img/ethnicities-mob-$current_lang.svg"); ?>" alt="damasturk"/>
                    <?php } else { ?>
                        <img src="<?= asset("/img/ethnicities-$current_lang.svg"); ?>" alt="damasturk"/>
                    <?php }*/ ?>
					
					
					<picture>
					   <source media="(min-width: 650px)" srcset="<?= asset("/img/ethnicities-$current_lang.svg"); ?>">
					   <source media="(max-width: 650px)" srcset="<?= asset("/img/ethnicities-mob-$current_lang.svg") ?>">
					   <img src="<?= asset("/img/ethnicities-$current_lang.svg"); ?>" 
					   loading="lazy" alt="damasturk">
					</picture>

                </div>
            </div>



            <div class="col-md-12">
                @include("front.partials.pub",['_index'=>1])
            </div>





            <div class="col-md-12">
                <h2 class="sub_title jazzira_font_bold"><?= trans("front.Prices of basic commodities in Turkey"); ?></h2>
                <?php
                /*
                  echo '<pre>';
                  print_r($ex);
                  echo '</pre>';
                 * */
                ?>

                <table class="table shadow_type tbl_cat">

                    <!--Table head-->
                    <thead>
                        <tr>
                            <th>
                                <select class="selectpicker select_cat">
                                    <?php
                                    foreach ($cats as $cat) {
                                        if ($cat->type == 'products') {
                                            ?>
                                            <option value="cat_{{ $cat->id }}">{{ $cat->getTitle() }}</option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </th>
                            <th class="num">TL</th>
                            <th>
                                <select class="selectpicker currency">
                                    <?php //$selected_curr = session()->get("currency") == '' ? 'TRY' : session()->get("currency"); //echo $selected_curr;    ?>
                                    <?php $selected_curr = in_array(session()->get("currency"), ['TRY', '']) ? 'USD' : session()->get("currency"); //echo $selected_curr;    ?>
                                    <?php
                                    $ex = unserialize($infos->exchange);
                                    if ($ex)
                                        foreach ($ex as $k => $v) {
                                            if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND', 'TRY'))) {
                                                ?>
                                                <option data-icon="flag_icon <?= $k ?>" class="<?= $k ?>" <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= $k ?>"><?= $k ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                    <!--<option data-icon="flag_icon TRY" class="TRY" value="TRY">TRY</option>
<option data-icon="flag_icon USD" class="USD" value="USD">USD</option>
<option data-icon="flag_icon EUR" class="EUR" value="EUR">EUR</option>
<option data-icon="flag_icon IRR" class="IRR" value="IRR">IRR</option>
<option data-icon="flag_icon GBP" class="GBP" value="GBP">GBP</option>
<option data-icon="flag_icon SAR" class="SAR" value="SAR">SAR</option>
<option data-icon="flag_icon IQD" class="IQD" value="IQD">IQD</option>
<option data-icon="flag_icon AED" class="AED" value="AED">AED</option>
<option data-icon="flag_icon KWD" class="KWD" value="KWD">KWD</option>
<option data-icon="flag_icon OMR" class="OMR" value="OMR">OMR</option>
<option data-icon="flag_icon SYP" class="SYP" value="SYP">SYP</option>
<option data-icon="flag_icon QAR" class="QAR" value="QAR">QAR</option>
<option data-icon="flag_icon BHD" class="BHD" value="BHD">BHD</option>
<option data-icon="flag_icon JOD" class="JOD" value="JOD">JOD</option>
<option data-icon="flag_icon DZD" class="DZD" value="DZD">DZD</option>
<option data-icon="flag_icon YER" class="YER" value="YER">YER</option>-->
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <!--Table head-->

                    <!--Table body-->
                    <?php
                    $i = 0;
                    foreach ($cats as $cat) {
                        if ($cat->type == 'products') {
                            $i++;
                            ?>
                            <tbody class="jazzira_font cat_<?= $cat->id ?> <?= $i == 1 ? '' : 'hidden' ?>">
                                <?php
                                $items = $cat->items;
                                foreach ($items as $itm) {



                                    //$price_usd = Helper::to_usd_format($ex,$itm->price,'TRY',false);
                                    ?>
                                    <tr>
                                        <td><?= $itm->getName() ?></td>
                                        <td><?= $itm->price ?></td>
                                        <td><?php
                                            foreach ($ex as $k => $v) {
                                                if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND', 'TRY'))) {
                                                    ?>
                                                    <span class="price_k price_<?= $k ?> <?= $selected_curr == $k ? '' : 'hidden' ?>"><?= round($itm->price * (float) $ex[$k], 0) //Helper::usd_to_format($price_usd,$k);                                                                   ?></span>
                                                    <?php
                                                }
                                            }
                                            ?>


                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <?php
                        }
                    }
                    ?>
                    <!--Table body-->


                </table>
                <!--Table-->


            </div>




            <div class="col-md-12">
                <h2 class="sub_title jazzira_font_bold"><?= trans("front.Minimum salary for basic professions"); ?></h2>


                <table class="table shadow_type tbl_jobs">

                    <!--Table head-->
                    <thead>
                        <tr>
                            <th><?= trans("front.Job title"); ?></th>
                            <th class="num">TL</th>
                            <th>
                                <select class="selectpicker currency">

                                    <?php
                                    $ex = unserialize($infos->exchange);
                                    if ($ex)
                                        foreach ($ex as $k => $v) {
                                            if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND', 'TRY'))) {
                                                ?>
                                                <option data-icon="flag_icon <?= $k ?>" class="<?= $k ?>" <?= $selected_curr == $k ? 'selected' : '' ?> value="<?= $k ?>"><?= $k ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </th>
                        </tr>
                    </thead>
                    <!--Table head-->

                    <!--Table body-->
                    <?php
                    foreach ($cats as $cat) {
                        if ($cat->type == 'jobs') {
                            ?>
                            <tbody class="jazzira_font cat_<?= $cat->id ?>">
                                <?php
                                $items = $cat->items;
                                foreach ($items as $itm) {
                                    //$price_usd = Helper::to_usd_format($ex,$itm->price,'TRY',false);
                                    ?>
                                    <tr>
                                        <td><?= $itm->getName() ?></td>
                                        <td><?= $itm->price ?></td>
                                        <td><?php
                                            foreach ($ex as $k => $v) {
                                                if (!in_array($k, array('EGP', 'ILS', 'LYD', 'MAD', 'TND', 'TRY'))) {
                                                    ?>
                                                    <span class="price_k price_<?= $k ?> <?= $selected_curr == $k ? '' : 'hidden' ?>"><?= round($itm->price * (float) $ex[$k], 0); ?></span>
                                                    <?php
                                                }
                                            }
                                            ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <?php
                        }
                    }
                    ?>

                </table>
                <!--Table-->


            </div>



            <?php //if (Helper::get_device() == 'mob') { ?>
                <section class="form shadow_type mob_form">
                    @include("front.partials.call_us_fixed")
                </section>
            <?php //} ?>


            <div class="col-md-12">
                <div class="row">
                    @include("front.partials.share_links", [])
                </div>
            </div>



            <div class="col-md-12">
                <div class="row">
                    @include("front.partials.subscribe_youtube", [])
                </div>
            </div>





            <!-- Out Link Section -->
<!--            <div class="col-md-12">
                <div class="row">
                    <div class="space_link citizenship_out_link">
                        <div class="content">
                            <p><?= trans("front.TurkishCitizenship"); ?></p>
                            <img class="icon" src="<?= asset("/img/out-link-button1.svg"); ?>" alt="damasturk"/>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Out Link Section -->
            
            
            
            <!-- Slider Pages links -->
            @include("front.partials.slider_pages_links")
            <!-- Slider Pages links -->



            <div class="col-md-12">
                <div class="int_content business_sectors">
                    <?php /*if (Helper::get_device() == 'mob') { ?>
                        <img src="<?= asset("/img/business-sectors-mob-$current_lang.svg"); ?>" alt="damasturk"/>
                    <?php } else { ?>
                        <img src="<?= asset("/img/business-sectors-$current_lang.svg"); ?>" alt="damasturk"/>
                    <?php }*/ ?>
					
					<picture>
					   <source media="(min-width: 650px)" srcset="<?= asset("/img/business-sectors-$current_lang.svg"); ?>">
					   <source media="(max-width: 650px)" srcset="<?= asset("/img/business-sectors-mob-$current_lang.svg"); ?>">
					   <img src="<?= asset("/img/business-sectors-$current_lang.svg"); ?>" loading="lazy" alt="damasturk" >
					</picture>
					
                </div>
            </div>



            <div class="col-md-12">
                <div class="int_content h_f_sec">

                    <div class="title">
                        <img class="icon" src="<?= asset("/img/h-title-icon-1.svg"); ?>" alt="damasturk"/>
                        <h2><?= $page->getTitleP() ?></h2><!--مراحل شراء عقار في تركيا للأجانب-->
                    </div>



                    <p class="jazzira_font">
                        <?= $page->getDescriptionP() ?>
                        <?php /*
                          تسمح تركيا لمعظم الجنسيات بالتملك العقاري على أراضيها دون شروط أو قيود مسبقة، يستثنى من ذلك بعض الجنسيات، لأسباب ترجع لمعاهدات أو قرارات قديمة وهي الجنسيات: السورية، الكوبية، القبرصية، الأرمنية، الكورية الشمالية.
                          يمكن لمواطني هذه الدول التملك في حال حصولهم على الجنسية التركية، أو إنشاء شركة تركية بأسمائهم، والتملك على اسم هذه الشركة.
                          <br><br>

                          <span class="jazzira_font_bold">أولاً: مرحلة الاستشارات والاطلاع على الخيارات العقارية قبل الوصول إلى تركيا:</span><br>
                          يوجد في تركيا آلاف المجمعات العقارية بمراحل ومزايا وتشطيبات متفاوتة، لذا عليك بداية اختيار شركة عقارية محترفة في تركيا وتتواصل معها عبر الهاتف لتكون مستشارك العقاري في تركيا.
                          عليك أن تجيبَ مستشارك العقاري في تركيا على الأسئلة التالية، ليتمكن من تحديد وحصر الخيارات العقارية التي تناسب طلبكم، ومن ثم إرسالها لكم عبر الوتساب، وبذلك ستختصر كثيراً من الوقت، وهذه الأسئلة هي:
                          <br>
                          <strong class="num">1.</strong>ما هو الهدف من الشراء؟ هل العقار للسكن أو للاستثمار، أم لقضاء العطل؟ أم أنك ترغب بالتملك للحصول على الجنسية التركية؟
                          <br>
                          <strong class="num">2.</strong>طبيعة العقار (شقة أم فيلا أم محل تجاري)، كم عدد غرف النوم المطلوبة في العقار، وذلك حسب عدد أفراد الأسرة.
                          <br>
                          <strong class="num">3.</strong>هل يوجد حدود معينة للميزانية المرصودة للعقار؟ هل ترغب بالدفع بالأقساط أم بالكاش؟ هل أنت مرتبط بمدينة معينة في تركيا؟ أم لا مشكلة لديك بالتملك في أي مدينة تركية؟
                          <br>
                          <strong class="num">4.</strong>هل يوجد مزايا خاصة تطمح أن يحويها العقار؟ كالإطلالة البحرية، أو القرب من المواصلات، أو المؤسسات الخدمية؟
                          <br><br>

                          <span class="jazzira_font_bold">ثانياً: مرحلة الجولات العقارية في تركيا، للإطلاع على العروض على أرض الواقع.</span><br>
                          بعد وصولك إلى تركيا، ستتواصل مع استشاري الشركة العقارية، والذي سيصحبُك في جولة عقارية ليزيارة المشاريع العقارية التي اطلعت عليها سابقاً، وهنا يبرز دور الشركة العقارية الاحترافية، والتي يجب أن يكون صُلب عملها ما يأتي:
                          <br>
                          <strong class="num">1.</strong>الكشف عن سلامة العقار من الناحية القانونية في دائرتي الطابو والبلدية.
                          <br>
                          <strong class="num">2.</strong>إطلاعك على المنطقة المحيطة بالمشروع بجولة ميدانية تفصيلية.
                          <br>
                          <strong class="num">3.</strong>عرض المشاريع العقارية المناسبة لطلبلكم تماماً في تلك المنطقة.
                          <br>
                          <strong class="num">4.</strong>مفاوضة الشركة الإنشائية، للحصول على أفضل خصم طريقة دفع.


                          <br><br>

                          <span class="jazzira_font_bold">ثالثاً مرحلة الشراء وتثبيت العقود رسمياً في المؤسسات التركية.</span><br>
                          <em>في حالة شراء العقار بدفعة واحدة (كاش):</em>
                          <br>
                          بعد تحويل كامل قيمة العقار من حسابك البنكي داخل تركيا أو خارجها إلى الحساب البنكي للشركة المنشئة، يمكنك المباشرة بنقل الملكية من البائع إليك، أو عبر توكيل قانوني لأي شخص أو جهة تثق بها في حال عدم وجودك بتركيا، والمستندات والأوراق اللازمة للتملك في تركيا هي:

                          <br>
                          <strong class="num">1.</strong>جواز سفر ساري المعفول، مترجم وموثق لدى كاتب العدل التركي (النوتر).
                          <br>
                          <strong class="num">2.</strong>وكالة قانونية رسمية لمن سينوب عن المشتري، في حال عدم وجوده.
                          <br>
                          <strong class="num">3.</strong>رقم ضريبي من أي دائرة ضريبية في تركيا.
                          <br>
                          <strong class="num">4.</strong>استخراج وثيقة التأمين ضد الزلازل والكوارث.
                          <br>
                          <strong class="num">5.</strong>صور شحصية عدد /3/.
                          <br><br>

                          <em>في حالة شراء العقار بالتقسيط (دفعة أولية، والباقي أقساط على عدة سنوات):</em>
                          <br>
                          غالباً تكون هذه الحالة عند الشراء في المشاريع قيد الإنشاء، التي لم تكتمل بعد. هنا تُؤجّل عملية نقل الملكية من البائع إلى المشتري لحين سداد كامل قيمة العقار. يمكنك ضمان حقك بإبرام عقد بيع أولي مع الشركة المنشئة، ومن ثم تسجيل وتوثيق هذا العقد عند كاتب العدل (النوتر)، لتجنب أي مشكلات مستقبلية، بتكلفة 1% من قيمة العقار. طبعاً عليك الالتزام بتسديد الأقساط الشهرية حسب الاتفاق المبرم مع البائع، وإلا ستتعرض لغرامات مالية.


                          <span class="jazzira_font_bold">في دائرة الطابو التابعة للمنطقة المتواجد فيها العقار:</span><br>
                          بعد تنظيم الملف يُؤخذ موعد من الموقع الكتروني <a target="_blank" href="https://randevu.tkgm.gov.tr/">randevu.tkgm.gov.tr</a> التابع لدائرة الطابو (الشهر العقاري)، يتم تحديد الموعد حسب الأسبقية، وذلك باستلام رسالة نصية على الهاتف الجوال بالموعد الخاص بالمعاملة.
                          يتوجه البائع والمشتري أو من ينوب عنهما بوكالة قانونية إلى دائرة الطابو في الموعد المحدد، ويتم تسليم الملف للموظف المسؤول في دائرة الطابو، الذي يقوم بإحتساب ضريبة نقل الملكية، والتي تقدر بحوالي 4% من قيمة العقار المتفق عليها في عقد البيع الأولي، ويتم تسديدها في دائرة الطابو، أو في أحد المصارف البنكية الحكومية، عادة تدفع هذه الضريبة مناصفة بين البائع والمشتري، أو يدفعها أحدهما حسب الاتفاق في مفاوضات الشراء.

                          <br><br>


                          <span class="jazzira_font_bold">المحظورات أو السلبيات الأربع عند شراء عقار في تركيا:</span><br>

                          يقوم <strong class="jazzira_font_bold">فريق داماس تورك</strong> القانوني بالتأكد من سلامة العقار قانونياً، وعدم وجود أي مشاكل مستقبلية غير متوقعة، ولعل أهم النقاط الواجب الحذر منها هي:


                          <br>
                          <strong class="num">1.</strong>قبل الشراء يجب التأكد من عدم وجود أي حجز أو رهن أو مخالفات إسكان أو إعمار على العقار.
                          <br>
                          <strong class="num">2.</strong>لا تقم بأي تحويلات مالية خاصة بثمن العقار إلا لحساب الشركة الإنشائية المذكورة في العقد.
                          <br>
                          <strong class="num">3.</strong>في حال شراء العقار بالتقسيط، يجب توثيق العقد لدى كاتب العدل (النوتر)، لحين نقل الملكية واستلام الطابو بعد انتهاء الأقساط.
                          <br>
                          <strong class="num">4.</strong>في حالة شراء عقار قيد الإنشاء، يجب أن تكون الشركة الإنشائية معروفة ولها اسمها في سوق العقار التركي، وتاريخ مشرف في موعد تسليم مشاريعها السابقة.
                         */ ?>


                    </p>



                    <div class="footer_document green"></div>
                </div>
            </div>



            <div class="col-md-12 inverse">

                <div class="citizenship_steps_sec passport_strong shadow_type">

                    <img class="earth_icon" src="<?= asset("/img/earth.svg"); ?>" alt="damasturk"/>
                    <img class="point_flag" src="<?= asset("/img/point-turkey-flag.svg"); ?>" alt="damasturk"/>
                    <img class="passport" src="<?= asset("/img/Passport2.png"); ?>" alt="damasturk"/>

                    <h2 class="jazzira_font_bold"><?= trans("front.Turkish citizenship heading top one"); ?> <br> <?= trans("front.Turkish citizenship heading top two"); ?> <br> <?= trans("front.Turkish citizenship heading top three"); ?></h2>

                    <ul class="jazzira_font">
                        <?= trans("front.turkish citizenship decisions"); ?>
                    </ul>

                    <a class="more green" href="{{ route('front.turkish_citizenship') }}"><?= trans("front.Learn more about Turkish citizenship"); ?></a>

                </div>

            </div>


            <div class="col-md-12">
                <div class="row">
                    @include("front.partials.subscribe_allow", [])
                </div>
            </div>


            <div class="col-md-12">
                <div class="sec faq_sec margin_bottom_20">
                    <div class="int_content shadow_type">

                        <h2 class="jazzira_font_bold"> <?= trans("front.FAQ about"); ?> <?= trans("front.Living in Turkey"); ?> </h2>

                        <img class="icon" src="<?= asset("/img/invest14.svg"); ?>" alt="damasturk"/>

                        <div class="sec">
                            <ul class="jazzira_font">
                                <?php
                                $faqs = DB::select("select * from dms_faq where faq_post=?  order by id asc LIMIT 3", [6]);

                                /* print_r($faqs);
                                  echo $faqs[0]->q_ar;
                                  exit; */
                                $i = 0;
                                foreach ($faqs as $r) {
                                    $i++;
                                    $q = 'q_' . ($current_lang == 'pe' ? 'fa' : $current_lang);
                                    $res = 'r_' . ($current_lang == 'pe' ? 'fa' : $current_lang);

                                    if (trim($r->$q) != '') {
                                        ?>
                                        <li>
                                            <span class="jazzira_font_bold"><?= $r->$q ?></span>
                                            <p><?= $r->$res ?></p>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>


                        <div class="sec">
                            <a class="more green" href="<?= route("front.faq_show", ["living-turkey"]) ?>"><?= trans("front.view more"); ?></a>
                        </div>

                    </div>
                </div>
            </div>




            <div class="col-md-12">
                @include("front.partials.testimonials_slider", [])
            </div>

			@include("front.partials.top_visited_posts", ['cat_id'=>4])
			
        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <div class="right_sec">

            <div class="fixed_sec">

                <section class="form shadow_type form_sec">
                    @include("front.partials.call_us_fixed")
                </section>


                @include("front.partials.about_sec", [])


            </div>
        </div>

    </div>
    <!-- End Fixed Section -->

</div>






@endsection



@section('scriptjs')
<?php if (App::isLocal()) { ?>
   <!-- <?= Html::script("resources/assets/js/swiper.min.js"); ?>-->
<?php } else { ?>
    <!--<?= Html::script("js/swiper.min.js"); ?>-->
<?php } ?>



<script>


    $(document).ready(function () {


        $('.select_cat').change(function () {
            var class_cat = $(this).val();
            $('.tbl_cat tbody').addClass('hidden');
            $('.tbl_cat tbody.' + class_cat).removeClass('hidden');

        });

        $('.tbl_cat .currency').change(function () {
            var currency = $(this).val();

            $('.tbl_cat .price_k').addClass('hidden');
            $('.tbl_cat .price_' + currency).removeClass('hidden');

        });
        $('.tbl_jobs .currency').change(function () {


            var currency = $(this).val();

            $('.tbl_jobs .price_k').addClass('hidden');
            $('.tbl_jobs .price_' + currency).removeClass('hidden');

        });








        var decisionPhotoH = $('.decision-photo').height() - 20;
        $(".decision-arabic").css("max-height", decisionPhotoH);
    });





    $(window).scroll(function () {
        var scrollingPage = 700;
        var scrollingPage2 = 700;
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



    $(document).ready(function () {

        var windowH = $(window).height();
        //$(".top_animate_sec").height(windowH);
        //$('.main_menu .links>li>a.turkish_citizenship').addClass("active");

        setTimeout(function () {
            $('.base').addClass("animate__fadeInUp");
            $('.cloud1').addClass("animate__zoomIn");
            $('.cloud2').addClass("animate__zoomIn");
            $('.cloud3').addClass("animate__zoomIn");
            $('.living_page_top_1').addClass("animate__fadeInLeft");
            $('.living_page_top_2').addClass("animate__zoomIn");
            $('.living_page_top_3').addClass("animate__zoomIn");
            $('.living_page_top_4').addClass("animate__zoomIn");
        }, 500);

        setTimeout(function () {
            $('.top_animate_sec .image_group h1 span').addClass("animate");
        }, 800);
        setTimeout(function () {
            $('.top_animate_sec .image_group h1 span').addClass("animate");
        }, 1000);
        setTimeout(function () {
            $('.cloud1').addClass("playing");
            $('.cloud2').addClass("playing");
            $('.cloud3').addClass("playing");
        }, 1500);



        var cloud1 = $(".cloud1");
        var cloud2 = $(".cloud2");
        var cloud3 = $(".cloud3");
        var livingPageTop1 = $(".living_page_top_1");
        var livingPageTop2 = $(".living_page_top_2");
        var livingPageTop3 = $(".living_page_top_3");
        var livingPageTop4 = $(".living_page_top_4");
        var base = $(".base");
        var H1 = $(".top_animate_sec .image_group h1");
        $("body").mousemove(function (event) {
            var x = event.pageX;
            var y = event.pageY;
            cloud1.css({'margin-top': y / 50, 'margin-left': x / 50}); // better use CSS
            cloud2.css({'margin-top': y / 40, 'margin-left': x / 40}); // better use CSS
            cloud3.css({'margin-top': y / 30, 'margin-left': x / 30}); // better use CSS
            livingPageTop1.css({'margin-top': y / 60, 'margin-left': x / 60}); // better use CSS
            livingPageTop2.css({'margin-top': y / 50, 'margin-left': x / 60}); // better use CSS
            livingPageTop3.css({'margin-top': y / 40, 'margin-left': x / 60}); // better use CSS
            livingPageTop4.css({'margin-top': y / 30, 'margin-left': x / 60}); // better use CSS
            base.css({'margin-top': y / 100, 'margin-left': x / 100}); // better use CSS
            H1.css({'margin-top': y / 70, 'margin-left': x / 70}); // better use CSS
        });


    });


/*
    (function ($) {
        $(function () {

            var agSwiper = $('.slider');

            if (agSwiper.length > 0) {

                var sliderView = 3;
                var ww = $(window).width();
                if (ww >= 1700)
                    sliderView = 3;
                if (ww <= 1700)
                    sliderView = 3;
                if (ww <= 1560)
                    sliderView = 2;
                if (ww <= 1400)
                    sliderView = 2;
                if (ww <= 1060)
                    sliderView = 2;
                if (ww <= 800)
                    sliderView = 2;
                if (ww <= 560)
                    sliderView = 1;
                if (ww <= 400)
                    sliderView = 1;

                var swiper = new Swiper('.slider', {
                    slidesPerView: sliderView,
                    spaceBetween: 0,
                    pagination: {
                        el: '.slider__pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.slider__button-next',
                        prevEl: '.slider__button-prev',
                    },
                    autoplay: {delay: 5000, },
                    //loop: true,
                    //loopedSlides: 16,
                    speed: 700,
                    autoplay: true,
                    autoplayDisableOnInteraction: true,
                    //centeredSlides: true
                });

                $(window).resize(function () {
                    var ww = $(window).width();
                    if (ww >= 1700)
                        sliderView = 3;
                    if (ww <= 1700)
                        sliderView = 3;
                    if (ww <= 1560)
                        sliderView = 2;
                    if (ww <= 1400)
                        sliderView = 2;
                    if (ww <= 1060)
                        sliderView = 2;
                    if (ww <= 800)
                        sliderView = 2;
                    if (ww <= 560)
                        sliderView = 1;
                    if (ww <= 400)
                        sliderView = 1;
                });

                $(window).trigger('resize');

                var mySwiper = document.querySelector('.slider').swiper;

                agSwiper.mouseenter(function () {
                    mySwiper.autoplay.stop();
                    console.log('slider stopped');
                });

                agSwiper.mouseleave(function () {
                    mySwiper.autoplay.start();
                    console.log('slider started again');
                });
            }

        });
    })(jQuery);

*/

</script>


@endsection



@section('schemaorg')

<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "Organization",
    "url": "{{url('/')}}",
    "logo": "<?= asset('img/logo2.png'); ?>"
    }
</script>
<script type="application/ld+json">
    {
    "@context": "http://schema.org",
    "@type": "WebSite",
    "url": "{{url('/')}}",
    "potentialAction": {
    "@type": "SearchAction",
    "target": "{{url('/')}}/search?s={search_term_string}",
    "query-input": "required name=search_term_string"
    }
    }
</script>

<?php if(count($faqs)>0){ ?>
<script type="application/ld+json">
	{
	"@context": "https://schema.org",
	"@type": "FAQPage",
	"mainEntity": [
	<?php
	$i = 0;
	foreach ($faqs as $r) {
		$i++;
		$q = 'q_' . ($current_lang=='pe'?'fa':$current_lang);
		$res = 'r_' . ($current_lang=='pe'?'fa':$current_lang);
		if (trim($r->$q) != '') {
	if($i>1)
	echo ',';
	?>
	
	{"@type": "Question",
	"name": " <?= htmlentities($r->$q) ?>",
	"acceptedAnswer": {"@type": "Answer","text": "<?= htmlentities($r->$res) ?>"}}
	<?php }} ?>
]}
</script>
<?php } ?>
<script type="application/ld+json">
	{
	"@context":"http://schema.org",
	"@type":"BreadcrumbList",
	"itemListElement":[

	{"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
	{"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trans('front.living turkey') }}","item":"{{ route('front.living_turkey') }}"}


	]
	}
</script>
@endsection