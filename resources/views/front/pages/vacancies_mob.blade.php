<?php
$current_lang = LaravelLocalization::getCurrentLocale();
//$photoCard = $post->photoCard;
$infos = Helper::get_params();
$is_mobile = Helper::is_mobile();
?>
@section('styles')





<?php if (App::isLocal()) { ?>


    <?= Html::style("https://foliotek.github.io/Croppie/croppie.css"); ?>
    <?= Html::style("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); ?>
    <?= Html::style("resources/assets/css/vacancies_full.css"); ?>
    <?= Html::style("resources/assets/css/slider-project-card.css"); ?>
    <?php if ($current_lang == 'ar' || $current_lang == 'fa') { ?>
    <?php } else { ?>
        <?= Html::style("resources/assets/css/vacancies-en.css"); ?>
        <?= Html::style("resources/assets/css/job-en.css"); ?>
    <?php } ?>


<?php } else { ?>
    <?= Html::style("https://foliotek.github.io/Croppie/croppie.css"); ?>
    <?= Html::style("https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"); ?>
    <?= Html::style("css/vacancies_full.min.css"); ?>

    <?php if ($current_lang == 'ar' || $current_lang == 'fa') { ?>

    <?php } else { ?>
        <?= Html::style("css/vacancies-en.min.css"); ?>
        <?= Html::style("css/job-en.min.css"); ?>
    <?php } ?>

<?php } ?>


@endsection
<?php
$current_lang = LaravelLocalization::getCurrentLocale();
?>
<?php
//$page_title = $row->getSeoTitle();
$page_title = trans("front.jobs page title");
$page_description = trans("front.jobs page description");
$media = $row->media;
?>
@extends('front.layout', [
"page_title" => $page_title ? $page_title : $row->getTitle(),
"page_description"  =>    $page_description,
"page_keywords"     =>    $row->getSeoKeywords(),
"og_image"          =>    asset('img/job-opportunities-share-photo.jpg'),
"page" => 'vac'
])
@section('main_content')



<!--
<div class="whatsapp"><div class="whatsapp-icon" onclick="open_tab('https://damas.net/whatsapp_share?icon=4')"><i class="fa fa-whatsapp"></i></div></div>
-->
<style>
    li.hidden{display:none!important}

    .left_sec {
        padding-right: 0px;
    }
</style>


<div id="fullpage" class="full-type">

    <div class="container">


        <div class="section" id="ws1">



            <!--            <div class="top_photo">
                            @if($media)
                            <img src="<?= Helper::media_url($media); ?>" alt="<?= $page_title; ?>">
                            @endif
                        </div>-->

            <div class="top_photo">

                <img src="/img/job-top-photo.png" alt="<?= $page_title; ?>"/>

                <h1>
                    <span><?= trans("front.jobs page header one") ?></span>
                    <br>
                    <?= trans("front.jobs page header two") ?>
                </h1>

            </div>

        </div>




        <!--<div class="section our_team_slider">
			
            <div class="int_content int">

                <h2 class="sub_title int jazzira_font_bold"><?= trans("front.Join our professional team"); ?></h2>

                <div class="wrapper sec">

                    <div class="slider" <?php if ($current_lang == 'ar' || $current_lang == 'pe') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>

                        <div class="slider__wrap swiper-wrapper">


                            <div class="item swiper-slide">
                                <div class="card shadow_type"> 
                                    <div class="image_cont marketing"></div>
                                    <img width="90" height="90" class="photo" src="<?= asset("/img/muaz3.png"); ?>" alt="damasturk"/>
                                    <h4 class="num">Muaz Alhaj</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 1"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.job Company departments text 1"); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="item swiper-slide">
                                <div class="card shadow_type"> 
                                    <div class="image_cont consulting"></div>
                                    <img width="90" height="90" class="photo" src="<?= asset("/img/default-with-logo-100.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Hazem Zino</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 2"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.job Company departments text 2"); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="item swiper-slide">
                                <div class="card shadow_type"> 
                                    <div class="image_cont sales"></div>
                                    <img width="90" height="90" class="photo" src="<?= asset("/img/managment-sec-photo-3.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Samer Najjar</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 3"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.job Company departments text 3"); ?>
                                    </p>
                                    <span class="point"></span>
                                </div>
                            </div>

                            <div class="item swiper-slide">
                                <div class="card shadow_type"> 
                                    <div class="image_cont quality_control"></div>
                                    <img width="90" height="90" class="photo" src="<?= asset("/img/managment-sec-photo-2.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Sherif Abdelaal</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 20"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.job Company departments text 5"); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="item swiper-slide">
                                <div class="card shadow_type"> 
                                    <div class="image_cont after_sales"></div>
                                    <img width="90" height="90" class="photo" src="<?= asset("/img/managment-sec-photo-9.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Sait Hikmetoğlu</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 4"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.job Company departments text 4"); ?>
                                    </p>
                                </div>
                            </div>

                            <?php /* <div class="item swiper-slide">
                              <div class="card shadow_type">
                              <div class="image_cont accounting"></div>
                              <img width="90" height="90" class="photo" src="<?= asset("/img/managment-sec-photo-10.jpg"); ?>" alt="damasturk"/>
                              <h4 class="num">BERAT MEHMET OĞLU</h4>
                              <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 7"); ?></h3>
                              <p class="jazzira_font">
                              <?= trans("front.job Company departments text 6"); ?>
                              </p>
                              </div>
                              </div>*/ ?>

                            <div class="item swiper-slide">
                                <div class="card shadow_type"> 
                                    <div class="image_cont lawyer"></div>
                                    <img width="90" height="90" class="photo" src="<?= asset("/img/managment-sec-photo-6.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Necmettin Barman</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 6"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.job Company departments text 7"); ?>
                                    </p>
                                </div>
                            </div>

                            <div class="item swiper-slide">
                                <div class="card shadow_type"> 
                                    <div class="image_cont HR"></div>
                                    <img width="90" height="90" class="photo" src="<?= asset("/img/managment-sec-photo-21.jpg"); ?>" alt="damasturk"/>
                                    <h4 class="num">Mohammed Adel</h4>
                                    <h3 class="jazzira_font_bold"><?= trans("front.about Company departments title 5"); ?></h3>
                                    <p class="jazzira_font">
                                        <?= trans("front.job Company departments text 8"); ?>
                                    </p>
                                </div>
                            </div>



                        </div>

                        <div class="slider__controls">

                            <div class="slider__pagination"></div>

                            <div class="slider__button-next"></div>
                            <div class="slider__button-prev"></div>
                        </div>


                        <a href="{{ route('front.aboutus') }}" class="more shadow_type"><?= trans("front.show more"); ?></a>


                    </div>

                </div>
            </div>


        </div>
-->





    </div>

    <div class="container">

        <!-- share page links -->
        <?php //if (Helper::get_device() == 'mob') { ?> 
        <div class="sec">
            @include("front.partials.share_links", [])
        </div>
        <?php //} ?>


        <div id="job-application" class="full_sections content_section_job">


            <!-- Start Left Section -->
            <div class="left_sec">



                <!-- Nav tabs -->
                <ul id="tabs" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#formContent" role="tab" data-toggle="tab"><?= trans("front.Job Application") ?></a></li>
                </ul>

                <?php
                $html_years = '';
                for ($i = date('Y') - 50; $i <= date('Y'); $i++) {
                    $html_years = $html_years . '<option value="' . $i . '">' . $i . '</option>';
                }
                $html_months = '';
                for ($i = 1; $i <= 12; $i++) {
                    $html_months = $html_months . '<option value="' . substr('0' . $i, -2) . '">' . $i . '</option>';
                }
                ?>
                <div class="tab-content sec">
                    <div role="tabpanel" class="tab-pane fade in active" id="formContent">
                        <div class="career_info">
                            <!--<div class="title"><h2>معلومات المتقدم</h2></div>-->

                            <div class="sub_title_new">
                                <?php echo html_entity_decode($row->getAbout()); //trans("front.form title")  ?>
                            </div>


                            <!-- Thanks to Pieter B. for helping out with the logistics -->
                            <div class="container">




                                <div class="profile_image_sec">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <label class="cabinet center-block">
                                                <figure>
                                                    <img src="" class="gambar img-responsive img-thumbnail" id="item-img-output" width="150" height="150"/>
                                                    <figcaption><i class="fa fa-camera"></i></figcaption>
                                                </figure>
                                                <input type="file" class="item-img file center-block" name="file_photo" accept="image/png, image/jpg, image/jpeg"/>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel"></h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id="upload-demo" class="center-block"></div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?= trans("front.Close btn") ?></button>
                                                <button type="button" id="cropImageBtn" class="btn btn-primary"><?= trans("front.Crop btn") ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <form id="contact" class="career_form" action="{{ route('front.callvac') }}">
                                    {!! csrf_field() !!}

                                    <div>

                                        <h3 class="headerTag"><?= trans("front.personal info") ?></h3>
                                        <section class="step_content">


                                            <div class="prifle_image_value">
                                                <div class="form-group">
                                                    <input type="text" id="h_profile_image" name="h_profile_image" value="" required />
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="job" class="form-label"><?= trans("front.job input title") ?></label>
                                                    <select name="h_position[]" id="job" class="form-control selectpicker job" title="<?= trans("front.Please select a job") ?>" required>
					<?php
					$roles = \App\Models\HrJobs::where("published",true)->orderBy('id','asc')->get();?>
					<p hidder><?= var_dump($roles) ?></p>
					<?php
					$arr_sections[] = ['id'=>1,'title_en'=>'Consultancy Department','title_ar'=>'قسم الاستشارات العقارية'];
					$arr_sections[] = ['id'=>2,'title_en'=>'Sales Department','title_ar'=>'قسم المبيعات'];
					$arr_sections[] = ['id'=>3,'title_en'=>'Marketing Department','title_ar'=>'قسم التسويق'];
					$arr_sections[] = ['id'=>4,'title_en'=>'HR Management','title_ar'=>'إدارة الموارد البشرية'];
					$arr_sections[] = ['id'=>5,'title_en'=>'Other jobs','title_ar'=>'وظائف أخرى'];
					
					$sec_lang = ($current_lang=='ar'?'ar':'en');
					
					foreach($arr_sections as $row_sec){ ?>
					<optgroup label="<?= $row_sec['title_'.$sec_lang] ?>">
						<?php foreach($roles as $r){
							if($r->section==$row_sec['id']){ ?>
						<option data-name="<?= $r->commission ?>" 
						value="{{ $r->job_title_en }}" 
						<?= (isset($_GET['p']) && $_GET['p'] == $r->job_title_en) ? 'selected' : '' ?>>
						<?php
						$fname = "job_title_$sec_lang";
						echo $r->$fname;
						?></option>
						<?php }} ?>
					</optgroup>
					<?php } ?>
                                                        <!--<optgroup label="<?= trans("front.job consultancy department") ?>">
                                                            <option data-name="withCommission" value="Telesales Manager" <?= (isset($_GET['p']) && $_GET['p'] == 'Telesales Manager') ? 'selected' : '' ?>><?= trans("front.job consultancy department Manager") ?></option>
                                                            <option data-name="withCommission" value="Arabic Telesales" <?= (isset($_GET['p']) && $_GET['p'] == 'Arabic Telesales') ? 'selected' : '' ?>><?= trans("front.job Telesales Consultant Arabic") ?></option>
                                                            <option data-name="withCommission" value="English Telesales" <?= (isset($_GET['p']) && $_GET['p'] == 'English Telesales') ? 'selected' : '' ?>><?= trans("front.job Telesales Consultant English") ?></option>
                                                            <option data-name="withCommission" value="French Telesales" <?= (isset($_GET['p']) && $_GET['p'] == 'French Telesales') ? 'selected' : '' ?>><?= trans("front.job Telesales Consultant French") ?></option>
                                                            <option data-name="withCommission" value="Persian Telesales" <?= (isset($_GET['p']) && $_GET['p'] == 'Persian Telesales') ? 'selected' : '' ?>><?= trans("front.job Telesales Consultant Persian") ?></option>
                                                            <option data-name="withCommission" value="Russian Telesales" <?= (isset($_GET['p']) && $_GET['p'] == 'Russian Telesales') ? 'selected' : '' ?>><?= trans("front.job Telesales Consultant Russian") ?></option>
                                                        </optgroup>
                                                        <optgroup label="<?= trans("front.job Sales Department") ?>">
                                                            <option data-name="withCommission" value="Sales Manager" <?= (isset($_GET['p']) && $_GET['p'] == 'Sales Manager') ? 'selected' : '' ?>><?= trans("front.job Sales manager") ?></option>
                                                            <option data-name="withCommission" value="Salesman" <?= (isset($_GET['p']) && $_GET['p'] == 'Salesman') ? 'selected' : '' ?>><?= trans("front.job field sales officer") ?></option>
                                                            <option data-name="withCommission" value="Portfolio Manager" <?= (isset($_GET['p']) && $_GET['p'] == 'Portfolio Manager') ? 'selected' : '' ?>><?= trans("front.job portfolio manager") ?></option>
                                                            <option data-name="notCommission" value="After Sales" <?= (isset($_GET['p']) && $_GET['p'] == 'After Sales') ? 'selected' : '' ?>><?= trans("front.job After-sales service officer") ?></option>
                                                        </optgroup>
                                                        <optgroup label="<?= trans("front.job Marketing department") ?>">
                                                            <option data-name="notCommission" value="Marketing Manager" <?= (isset($_GET['p']) && $_GET['p'] == 'Marketing Manager') ? 'selected' : '' ?>><?= trans("front.job Marketing Manager") ?></option>
                                                            <option data-name="notCommission" value="Social Media Manager" <?= (isset($_GET['p']) && $_GET['p'] == 'Social Media Manager') ? 'selected' : '' ?>><?= trans("front.job Social Media Manager") ?></option>
                                                            <option data-name="notCommission" value="Media Manager" <?= (isset($_GET['p']) && $_GET['p'] == 'Media Manager') ? 'selected' : '' ?>><?= trans("front.job Media Manager") ?></option>
                                                            <option data-name="notCommission" value="Backend Developer" <?= (isset($_GET['p']) && $_GET['p'] == 'Backend Developer') ? 'selected' : '' ?>><?= trans("front.job Backend Developer") ?></option>
                                                            <option data-name="notCommission" value="Frontend Developer" <?= (isset($_GET['p']) && $_GET['p'] == 'Frontend Developer') ? 'selected' : '' ?>><?= trans("front.job Frontend Developer") ?></option>
                                                            <option data-name="notCommission" value="SEO Specialist" <?= (isset($_GET['p']) && $_GET['p'] == 'SEO Specialist') ? 'selected' : '' ?>><?= trans("front.job SEO specialist") ?></option>
                                                            <option data-name="notCommission" value="Ads Specialist" <?= (isset($_GET['p']) && $_GET['p'] == 'Ads Specialist') ? 'selected' : '' ?>><?= trans("front.job Ads Specialist") ?></option>
                                                            <option data-name="notCommission" value="Graphic Designer" <?= (isset($_GET['p']) && $_GET['p'] == 'Graphic Designer') ? 'selected' : '' ?>><?= trans("front.job Graphic designer") ?></option>
                                                            <option data-name="notCommission" value="Photographer" <?= (isset($_GET['p']) && $_GET['p'] == 'Photographer') ? 'selected' : '' ?>><?= trans("front.job Photographer") ?></option>
                                                            <option data-name="notCommission" value="Monteur" <?= (isset($_GET['p']) && $_GET['p'] == 'Monteur') ? 'selected' : '' ?>><?= trans("front.job Monteur") ?></option>
                                                            <option data-name="notCommission" value="Social Media Specialist" <?= (isset($_GET['p']) && $_GET['p'] == 'Social Media Specialist') ? 'selected' : '' ?>><?= trans("front.job Social Media specialist") ?></option>
                                                            <option data-name="notCommission" value="Content Writer" <?= (isset($_GET['p']) && $_GET['p'] == 'Content Writer') ? 'selected' : '' ?>><?= trans("front.job Content Writer") ?></option>
                                                            <option data-name="notCommission" value="IT Hardware" <?= (isset($_GET['p']) && $_GET['p'] == 'IT Hardware') ? 'selected' : '' ?>><?= trans("front.job IT officer") ?></option>
                                                            <option data-name="notCommission" value="Video Presenter" <?= (isset($_GET['p']) && $_GET['p'] == 'Video Presenter') ? 'selected' : '' ?>><?= trans("front.job Video Presenter") ?></option>

                                                        </optgroup>
                                                        <optgroup label="<?= trans("front.job HR Management") ?>">
                                                            <option data-name="notCommission" value="HR Manager" <?= (isset($_GET['p']) && $_GET['p'] == 'HR Manager') ? 'selected' : '' ?>><?= trans("front.job HR Manager") ?></option>
                                                            <option data-name="notCommission" value="Quality Assurance Supervisor" <?= (isset($_GET['p']) && $_GET['p'] == 'Quality Assurance Supervisor') ? 'selected' : '' ?>><?= trans("front.job Quality Assurance Supervisor") ?></option>
                                                            <option data-name="notCommission" value="Personnel Supervisor" <?= (isset($_GET['p']) && $_GET['p'] == 'Personnel Supervisor') ? 'selected' : '' ?>><?= trans("front.job Personnel Supervisor") ?></option>
                                                        </optgroup>
                                                        <optgroup label="<?= trans("front.job Other jobs") ?>">
                                                            <option data-name="notCommission" value="CEO" <?= (isset($_GET['p']) && $_GET['p'] == 'CEO') ? 'selected' : '' ?>><?= trans("front.job CEO") ?></option>
                                                            <option data-name="notCommission" value="Lawyer" <?= (isset($_GET['p']) && $_GET['p'] == 'Lawyer') ? 'selected' : '' ?>><?= trans("front.job Lawyer") ?></option>
                                                            <option data-name="notCommission" value="Legal Affairs Officer" <?= (isset($_GET['p']) && $_GET['p'] == 'Legal Affairs Officer') ? 'selected' : '' ?>><?= trans("front.job Legal Affairs Officer") ?></option>
                                                            <option data-name="notCommission" value="Accountant" <?= (isset($_GET['p']) && $_GET['p'] == 'Accountant') ? 'selected' : '' ?>><?= trans("front.job Accountant") ?></option>
                                                            <option data-name="notCommission" value="Construction Engineer" <?= (isset($_GET['p']) && $_GET['p'] == 'Construction Engineer') ? 'selected' : '' ?>><?= trans("front.job Construction Engineer") ?></option>
                                                            <option data-name="notCommission" value="Administrative" <?= (isset($_GET['p']) && $_GET['p'] == 'Administrative') ? 'selected' : '' ?>><?= trans("front.job Administrative") ?></option>
                                                            <option data-name="notCommission" value="Trainee" <?= (isset($_GET['p']) && $_GET['p'] == 'Trainee') ? 'selected' : '' ?>><?= trans("front.job Trainee") ?></option>
                                                            <option data-name="notCommission" value="Secretary" <?= (isset($_GET['p']) && $_GET['p'] == 'Secretary') ? 'selected' : '' ?>><?= trans("front.job Secretary") ?></option>
                                                            <option data-name="notCommission" value="Cars Coordinator" <?= (isset($_GET['p']) && $_GET['p'] == 'Cars Coordinator') ? 'selected' : '' ?>><?= trans("front.job Cars Manager") ?></option>
                                                        </optgroup>
                                                    --></select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="src" value="<?= isset($_GET['src']) ? $_GET['src'] : '' ?>" />
                                            <div class="col-md-4 col-sm-6 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="fullName" class="form-label"><?= trans("front.job name") ?></label>
                                                    <input type="text" class="form-control" name="h_name" id="fullName" placeholder="<?= trans("front.job name") ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="mobile" class="form-label"><?= trans("front.job phone") ?></label>
                                                    <input type="text" class="form-control" name="h_mobile" id="mobile-smn" placeholder="<?= trans("front.job phone") ?>" value="+90" minlength="10" required />
                                                </div>
                                            </div>

                                            <div class="col-md-5 col-sm-5 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <div class="email_sec">
                                                        <label for="emailAddress" class="form-label"><?= trans("front.job email") ?></label>
                                                        <select name="emailType" id="emailType" class="form-control selectpicker emailType">
                                                            <option value="@gmail.com">@gmail.com</option>
                                                            <option value="@hotmail.com">@hotmail.com</option>
                                                            <option value="@yahoo.com">@yahoo.com</option>
                                                        </select>
                                                        <input type="text" class="form-control" name="h_email" id="emailAddress" placeholder="E.g. Ahmed, Mary .." required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="city" class="form-label"><?= trans("front.job city") ?></label>
                                                    <select name="h_city" id="city" class="form-control selectpicker cities" data-live-search="true" title="<?= trans("front.job city") ?>" required>
                                                        <option value=""><?= trans("front.job city select") ?></option>
                                                        <option value="Outside Turkey">Outside Turkey</option>
                                                        <option value="Istanbul">Istanbul</option>
                                                        <option value="Antalya">Antalya</option>
                                                        <option value="Bursa">Bursa</option>
                                                        <option value="Kocaeli">Kocaeli</option>
                                                        <option value="Ankara">Ankara</option>
                                                        <option value="Trabzon">Trabzon</option>
                                                        <option value="Gaziantep">Gaziantep</option>
                                                        <option value="Mersin">Mersin</option>
                                                        <option value="Hatay">Hatay</option>
                                                        <option value="Izmir">İzmir</option>
                                                        <option value="Adana">Adana</option>
                                                        <option value="Adıyaman">Adıyaman</option>
                                                        <option value="Afyonkarahisar">Afyonkarahisar</option>
                                                        <option value="Ağrı">Ağrı</option>
                                                        <option value="Amasya">Amasya</option>
                                                        <option value="Artvin">Artvin</option>
                                                        <option value="Aydın">Aydın</option>
                                                        <option value="Balıkesir">Balıkesir</option>
                                                        <option value="Bilecik">Bilecik</option>
                                                        <option value="Bingöl">Bingöl</option>
                                                        <option value="Bitlis">Bitlis</option>
                                                        <option value="Bolu">Bolu</option>
                                                        <option value="Burdur">Burdur</option>
                                                        <option value="Çanakkale">Çanakkale</option>
                                                        <option value="Çankırı">Çankırı</option>
                                                        <option value="Çorum">Çorum</option>
                                                        <option value="Denizli">Denizli</option>
                                                        <option value="Diyarbakır">Diyarbakır</option>
                                                        <option value="Edirne">Edirne</option>
                                                        <option value="Elazığ">Elazığ</option>
                                                        <option value="Erzincan">Erzincan</option>
                                                        <option value="Erzurum">Erzurum</option>
                                                        <option value="Eskişehir">Eskişehir</option>
                                                        <option value="Giresun">Giresun</option>
                                                        <option value="Gümüşhane">Gümüşhane</option>
                                                        <option value="Hakkâri">Hakkâri</option>
                                                        <option value="Hatay">Hatay</option>
                                                        <option value="Isparta">Isparta</option>
                                                        <option value="Kars">Kars</option>
                                                        <option value="Kastamonu">Kastamonu</option>
                                                        <option value="Kayseri">Kayseri</option>
                                                        <option value="Kırklareli">Kırklareli</option>
                                                        <option value="Kırşehir">Kırşehir</option>
                                                        <option value="Konya">Konya</option>
                                                        <option value="Kütahya">Kütahya</option>
                                                        <option value="Malatya">Malatya</option>
                                                        <option value="Manisa">Manisa</option>
                                                        <option value="Kahramanmaraş">Kahramanmaraş</option>
                                                        <option value="Mardin">Mardin</option>
                                                        <option value="Muğla">Muğla</option>
                                                        <option value="Muş">Muş</option>
                                                        <option value="Nevşehir">Nevşehir</option>
                                                        <option value="Niğde">Niğde</option>
                                                        <option value="Ordu">Ordu</option>
                                                        <option value="Rize">Rize</option>
                                                        <option value="Sakarya">Sakarya</option>
                                                        <option value="Samsun">Samsun</option>
                                                        <option value="Siirt">Siirt</option>
                                                        <option value="Sinop">Sinop</option>
                                                        <option value="Sivas">Sivas</option>
                                                        <option value="Tekirdağ">Tekirdağ</option>
                                                        <option value="Tokat">Tokat</option>
                                                        <option value="Tunceli">Tunceli</option>
                                                        <option value="Şanlıurfa">Şanlıurfa</option>
                                                        <option value="Uşak">Uşak</option>
                                                        <option value="Van">Van</option>
                                                        <option value="Yozgat">Yozgat</option>
                                                        <option value="Zonguldak">Zonguldak</option>
                                                        <option value="Aksaray">Aksaray</option>
                                                        <option value="Bayburt">Bayburt</option>
                                                        <option value="Karaman">Karaman</option>
                                                        <option value="Kırıkkale">Kırıkkale</option>
                                                        <option value="Batman">Batman</option>
                                                        <option value="Şırnak">Şırnak</option>
                                                        <option value="Bartın">Bartın</option>
                                                        <option value="Ardahan">Ardahan</option>
                                                        <option value="Iğdır">Iğdır</option>
                                                        <option value="Yalova">Yalova</option>
                                                        <option value="Karabük">Karabük</option>
                                                        <option value="Kilis">Kilis</option>
                                                        <option value="Osmaniye">Osmaniye</option>
                                                        <option value="Düzce">Düzce</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="district" class="form-label"><?= trans("front.job district") ?></label>
                                                    <input type="text" class="form-control" name="h_district" id="district" placeholder="<?= trans("front.job district") ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="nationality" class="form-label"><?= trans("front.job original nationality") ?></label>
                                                    <select name="h_citizenship" id="nationality" class="form-control selectpicker nationality" data-live-search="true" title="<?= trans("front.job original nationality") ?>" required>
                                                        <option value="">Citizenship</option>
                                                        <?php
                                                        $arrcountries = Helper::code_to_country('');

                                                        foreach ($arrcountries as $k => $v) {
                                                            if ($k == 'TR') {
                                                                ?>
                                                                <option value="Turkey">Turkey (By Birth)</option>
                                                            <?php } else { ?>
                                                                <option value="<?= $v ?>"><?= $v ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php //<option value=syrian>Syrian</option><option value=egyptian>Egyptian</option><option value=Palestinian>Palestinian</option><option value=iraqi>Iraqi</option><option value=jordanian>Jordanian</option><option value=afghan>Afghan</option><option value=albanian>Albanian</option><option value=algerian>Algerian</option><option value=american>American</option><option value=andorran>Andorran</option><option value=angolan>Angolan</option><option value=antiguans>Antiguans</option><option value=argentinean>Argentinean</option><option value=armenian>Armenian</option><option value=australian>Australian</option><option value=austrian>Austrian</option><option value=azerbaijani>Azerbaijani</option><option value=bahamian>Bahamian</option><option value=bahraini>Bahraini</option><option value=bangladeshi>Bangladeshi</option><option value=barbadian>Barbadian</option><option value=barbudans>Barbudans</option><option value=batswana>Batswana</option><option value=belarusian>Belarusian</option><option value=belgian>Belgian</option><option value=belizean>Belizean</option><option value=beninese>Beninese</option><option value=bhutanese>Bhutanese</option><option value=bolivian>Bolivian</option><option value=bosnian>Bosnian</option><option value=brazilian>Brazilian</option><option value=british>British</option><option value=bruneian>Bruneian</option><option value=bulgarian>Bulgarian</option><option value=burkinabe>Burkinabe</option><option value=burmese>Burmese</option><option value=burundian>Burundian</option><option value=cambodian>Cambodian</option><option value=cameroonian>Cameroonian</option><option value=canadian>Canadian</option><option value="cape verdean">Cape Verdean</option><option value="central african">Central African</option><option value=chadian>Chadian</option><option value=chilean>Chilean</option><option value=chinese>Chinese</option><option value=colombian>Colombian</option><option value=comoran>Comoran</option><option value=congolese>Congolese</option><option value="costa rican">Costa Rican</option><option value=croatian>Croatian</option><option value=cuban>Cuban</option><option value=cypriot>Cypriot</option><option value=czech>Czech</option><option value=danish>Danish</option><option value=djibouti>Djibouti</option><option value=dominican>Dominican</option><option value=dutch>Dutch</option><option value="east timorese">East Timorese</option><option value=ecuadorean>Ecuadorean</option><option value=emirian>Emirian</option><option value="equatorial guinean">Equatorial Guinean</option><option value=eritrean>Eritrean</option><option value=estonian>Estonian</option><option value=ethiopian>Ethiopian</option><option value=fijian>Fijian</option><option value=filipino>Filipino</option><option value=finnish>Finnish</option><option value=french>French</option><option value=gabonese>Gabonese</option><option value=gambian>Gambian</option><option value=georgian>Georgian</option><option value=german>German</option><option value=ghanaian>Ghanaian</option><option value=greek>Greek</option><option value=grenadian>Grenadian</option><option value=guatemalan>Guatemalan</option><option value=guinea-bissauan>Guinea-Bissauan</option><option value=guinean>Guinean</option><option value=guyanese>Guyanese</option><option value=haitian>Haitian</option><option value=herzegovinian>Herzegovinian</option><option value=honduran>Honduran</option><option value=hungarian>Hungarian</option><option value=icelander>Icelander</option><option value=indian>Indian</option><option value=indonesian>Indonesian</option><option value=iranian>Iranian</option><option value=irish>Irish</option><option value=israeli>Israeli</option><option value=italian>Italian</option><option value=ivorian>Ivorian</option><option value=jamaican>Jamaican</option><option value=japanese>Japanese</option><option value=kazakhstani>Kazakhstani</option><option value=kenyan>Kenyan</option><option value="kittian and nevisian">Kittian and Nevisian</option><option value=kuwaiti>Kuwaiti</option><option value=kyrgyz>Kyrgyz</option><option value=laotian>Laotian</option><option value=latvian>Latvian</option><option value=lebanese>Lebanese</option><option value=liberian>Liberian</option><option value=libyan>Libyan</option><option value=liechtensteiner>Liechtensteiner</option><option value=lithuanian>Lithuanian</option><option value=luxembourger>Luxembourger</option><option value=macedonian>Macedonian</option><option value=malagasy>Malagasy</option><option value=malawian>Malawian</option><option value=malaysian>Malaysian</option><option value=maldivan>Maldivan</option><option value=malian>Malian</option><option value=maltese>Maltese</option><option value=marshallese>Marshallese</option><option value=mauritanian>Mauritanian</option><option value=mauritian>Mauritian</option><option value=mexican>Mexican</option><option value=micronesian>Micronesian</option><option value=moldovan>Moldovan</option><option value=monacan>Monacan</option><option value=mongolian>Mongolian</option><option value=moroccan>Moroccan</option><option value=mosotho>Mosotho</option><option value=motswana>Motswana</option><option value=mozambican>Mozambican</option><option value=namibian>Namibian</option><option value=nauruan>Nauruan</option><option value=nepalese>Nepalese</option><option value="new zealander">New Zealander</option><option value=ni-vanuatu>Ni-Vanuatu</option><option value=nicaraguan>Nicaraguan</option><option value=nigerien>Nigerien</option><option value="north korean">North Korean</option><option value="northern irish">Northern Irish</option><option value=norwegian>Norwegian</option><option value=omani>Omani</option><option value=pakistani>Pakistani</option><option value=palauan>Palauan</option><option value=panamanian>Panamanian</option><option value="papua new guinean">Papua New Guinean</option><option value=paraguayan>Paraguayan</option><option value=peruvian>Peruvian</option><option value=polish>Polish</option><option value=portuguese>Portuguese</option><option value=qatari>Qatari</option><option value=romanian>Romanian</option><option value=russian>Russian</option><option value=rwandan>Rwandan</option><option value="saint lucian">Saint Lucian</option><option value=salvadoran>Salvadoran</option><option value=samoan>Samoan</option><option value="san marinese">San Marinese</option><option value="sao tomean">Sao Tomean</option><option value=saudi>Saudi</option><option value=scottish>Scottish</option><option value=senegalese>Senegalese</option><option value=serbian>Serbian</option><option value=seychellois>Seychellois</option><option value="sierra leonean">Sierra Leonean</option><option value=singaporean>Singaporean</option><option value=slovakian>Slovakian</option><option value=slovenian>Slovenian</option><option value="solomon islander">Solomon Islander</option><option value=somali>Somali</option><option value="south african">South African</option><option value="south korean">South Korean</option><option value=spanish>Spanish</option><option value="sri lankan">Sri Lankan</option><option value=sudanese>Sudanese</option><option value=surinamer>Surinamer</option><option value=swazi>Swazi</option><option value=swedish>Swedish</option><option value=swiss>Swiss</option><option value=taiwanese>Taiwanese</option><option value=tajik>Tajik</option><option value=tanzanian>Tanzanian</option><option value=thai>Thai</option><option value=togolese>Togolese</option><option value=tongan>Tongan</option><option value="trinidadian or tobagonian">Trinidadian or Tobagonian</option><option value=tunisian>Tunisian</option><option value=turkish>Turkish</option><option value=tuvaluan>Tuvaluan</option><option value=ugandan>Ugandan</option><option value=ukrainian>Ukrainian</option><option value=uruguayan>Uruguayan</option><option value=uzbekistani>Uzbekistani</option><option value=venezuelan>Venezuelan</option><option value=vietnamese>Vietnamese</option><option value=welsh>Welsh</option><option value="Yemeni">Yemeni</option><option value=zambian>Zambian</option><option value=zimbabwean>Zimbabwean</option>    ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12 page_sec">


                                                <div class="form-group start_date_sec">
                                                    <label for="age" class="form-label"><?= trans("front.job Date of Birth") ?></label>
                                                    <select class="form-control selectpicker startMonth" name="h_age_m" id="h_age_m" required>
                                                        <option value=""> <?= trans("front.Month") ?></option>
                                                        <?= $html_months ?>
                                                    </select>
                                                    <select class="form-control selectpicker startYear" name="h_age_y" id="h_age_y" required>
                                                        <option value=""> <?= trans("front.Year") ?></option>
                                                        <?= $html_years ?>
                                                    </select>
                                                </div>

<!--                                                    <input type="text" class="form-control" name="h_age" id="age" placeholder=" <?= trans("front.job Date of Birth") ?>" required>-->
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="gender" class="form-label"><?= trans("front.job gender") ?></label>
                                                    <select name="h_gender" id="gender" class="form-control selectpicker" title=" <?= trans("front.job gender") ?>" required>
                                                        <option value=""><?= trans("front.job gender") ?></option>
                                                        <option value="Male"><?= trans("front.job Male") ?></option>
                                                        <option value="Female"><?= trans("front.job Female") ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-3 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="marital" class="form-label"><?= trans("front.job Marital status") ?></label>
                                                    <select name="h_marriage" id="marital" class="form-control selectpicker" title="<?= trans("front.job Marital status") ?>" required>
                                                        <option value=""><?= trans("front.job Marital status") ?></option>
                                                        <option value="Married"><?= trans("front.job Married") ?></option>
                                                        <option value="Single"><?= trans("front.job Single") ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="identification" class="form-label"><?= trans("front.job Legal Document in Turkey") ?></label>
                                                    <select name="h_identification" id="identification" class="form-control selectpicker" title="<?= trans("front.job Legal Document in Turkey select") ?>" required>
                                                        <option value=""><?= trans("front.job Legal Document in Turkey select") ?></option>
                                                        <option value="Passport"><?= trans("front.job Legal Document Just a passport") ?></option>
                                                        <option value="Tourist Card"><?= trans("front.job Legal Document Tourist accommodation") ?></option>
                                                        <option value="Work Card"><?= trans("front.job Legal Document Work stay") ?></option>
                                                        <option value="Student Card"><?= trans("front.job Legal Document Student Card") ?></option>
                                                        <option value="Humanity Card"><?= trans("front.job Legal Document Humanity Card") ?></option>
                                                        <option value="Family Card"><?= trans("front.job Legal Document Family Card") ?></option>
                                                        <option value="T.C Card"><?= trans("front.job Legal Document Holds Turkish citizenship") ?></option>
                                                        <option value="Protection"><?= trans("front.job Legal Document Temporary protection") ?></option>
                                                        <option value="Other"><?= trans("front.job Language Other") ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6 col-xs-12 page_sec">

                                                <div class="form-group start_date_sec">
                                                    <label for="dateEntryTurkey" class="form-label"><?= trans("front.job Date of entry to Turkey") ?></label>
                                                    <select class="form-control selectpicker startMonth" name="h_entry_to_turkey_m" id="h_entry_to_turkey_m" required>
                                                        <option value=""> <?= trans("front.Month") ?></option>
                                                        <?= $html_months ?>
                                                    </select>
                                                    <select class="form-control selectpicker startYear" name="h_entry_to_turkey_y" id="h_entry_to_turkey_y" required>
                                                        <option value=""> <?= trans("front.Year") ?></option>
                                                        <?= $html_years ?>
                                                    </select>
                                                </div>


<!--                                                    <input type="text" class="form-control" name="h_entry_to_turkey" id="dateEntryTurkey" placeholder="<?= trans("front.job Date of entry to Turkey") ?>" required>-->

                                            </div>

                                            <div class="col-md-4 col-sm-6 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="drivingLicense" class="form-label"><?= trans("front.job Turkish driving license") ?></label>
                                                    <select name="h_license" id="drivingLicense" class="form-control selectpicker" title="<?= trans("front.job Turkish driving license") ?>" required>
                                                        <option value=""><?= trans("front.job Turkish driving license") ?></option>
                                                        <option value="yes"><?= trans("front.job Yes") ?></option>
                                                        <option value="no"><?= trans("front.job No") ?></option>
                                                    </select>
                                                </div>
                                            </div>






                                            <!--                                            <div class="col-md-6 col-sm-6 col-xs-12 page_sec source_sec">
                                                                                            <div class="form-group">
                                                                                                <label for="source" class="form-label">كيف تعرفت علينا</label>
                                                                                                <select name="h_source_txt" id="source" class="form-control selectpicker" title="كيف تعرفت علينا" required>
                                                                                                    <option value="">كيف تعرفت علينا</option>
                                                                                                    <option value="Google">محرك البحث غوغل</option>
                                                                                                    <option value="Social Media">سوشيال ميديا</option>
                                                                                                    <option value="LinkedIn">لينكد إن</option>
                                                                                                    <option value="Job opportunities in Turkey">فرص عمل في تركيا</option>
                                                                                                    <option value="friends">أصدقاء</option>
                                                                                                    <option value="other">أخرى</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>-->
                                        </section>


                                        <h3 class="headerTag"><?= trans("front.job Experience and education") ?></h3>
                                        <section class="step_content">

                                            <div class="big_content">
                                                <div class="add_content">
                                                    <div class="col-md-12 col-sm-12 col-xs-12 sector_company_sec">
                                                        <div class="form-group border_mob">
                                                            <label class="form-label jazzira_font_bold bold_title"><?= trans("front.job company question") ?></label>

                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="companyName1" class="form-label"><?= trans("front.job company Name") ?></label>
                                                                    <input type="text" class="form-control companyName1" name="companyName[0]" id="companyName1" placeholder="<?= trans("front.job For English Title") ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="companySector1" class="form-label"><?= trans("front.job company sector") ?></label>
                                                                    <div class="other_sector">
                                                                        <select name="companySector[0]" id="companySector1" class="form-control companySector" title="<?= trans("front.job company sector") ?>" required>
                                                                            <option value=""><?= trans("front.job company sector") ?></option>
                                                                            <option value="Real Estate"><?= trans("front.job Real Estate") ?></option>
                                                                            <option value="Digital Marketing"><?= trans("front.job Digital Marketing") ?></option>
                                                                            <option value="Management Consulting"><?= trans("front.job Management Consulting") ?></option>
                                                                            <option value="Education"><?= trans("front.job Education") ?></option>
                                                                            <option value="Tourism"><?= trans("front.job Tourism") ?></option>
                                                                            <option value="General Trade"><?= trans("front.job General Trade") ?></option>
                                                                            <option value="Electrical and Electronics"><?= trans("front.job Electrical and Electronics") ?></option>
                                                                            <option value="Medical and Pharmacy"><?= trans("front.job Medicine and Pharmacology") ?></option>
                                                                            <option value="Furniture and Decoration"><?= trans("front.job Furniture and Decoration") ?></option>
                                                                            <option value="Food and Agriculture"><?= trans("front.job Food and Agriculture") ?></option>
                                                                            <option value="IT Hardware"><?= trans("front.job IT Hardware") ?></option>
                                                                            <option value="Financial or Investment"><?= trans("front.job Financial or Investment") ?></option>
                                                                            <option value="Manufacturing"><?= trans("front.job Manufacturing") ?></option>
                                                                            <option value="Other"><?= trans("front.job Language Other") ?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="experience1" class="form-label"><?= trans("front.job Position") ?></label>
                                                                    <input type="text" class="form-control experience1" name="experience[0]" id="experience1" placeholder="<?= trans("front.job For English Title") ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">                                                                    
    <!--                                                                <span class="input_title durationWork_title"><?= trans("front.job Month") ?></span>-->

                                                                <div class="form-group start_date_sec">
                                                                    <label for="durationWorkFrom" class="form-label"><?= trans("front.job Working time from") ?></label>
                                                                    <select class="form-control startMonth durationWorkFrom_m" name="durationWorkFrom_m[0]" id="durationWorkFrom_m" required>
                                                                        <option value=""> <?= trans("front.Month") ?></option>
                                                                        <?= $html_months ?>
                                                                    </select>
                                                                    <select class="form-control startYear durationWorkFrom_y" name="durationWorkFrom_y[0]" id="durationWorkFrom_y" required>
                                                                        <option value=""> <?= trans("front.Year") ?></option>
                                                                        <?= $html_years ?>
                                                                    </select>
                                                                </div>

<!--                                                                    <input type="text" class="form-control durationWork dateFrom" name="durationWorkFrom[0]" id="durationWorkFrom1" placeholder="<?= trans("front.job Start") ?>" required>
<input type="text" class="form-control durationWork dateTo" name="durationWorkTo[0]" id="durationWorkTo1" placeholder="<?= trans("front.job End") ?>" required>-->

                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">                                                                    

                                                                <div class="form-group start_date_sec">
                                                                    <label for="durationWorkTo_m" class="form-label"><?= trans("front.job Working time to") ?></label>
                                                                    <label class="error date_alert_message"></label>
                                                                    <select class="form-control startMonth durationWorkTo_m" name="durationWorkTo_m[0]" id="durationWorkTo_m" required>
                                                                        <option value=""> <?= trans("front.Month") ?></option>
                                                                        <?= $html_months ?>
                                                                    </select>
                                                                    <select class="form-control startYear durationWorkTo_y" name="durationWorkTo_y[0]" id="durationWorkTo_y" required>
                                                                        <option value=""> <?= trans("front.Year") ?></option>
                                                                        <?= $html_years ?>
                                                                    </select>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label class="jazzira_font_bold bold_title"><?= trans("front.second company") ?></label>
                                                    </div>

                                                    <div class="col-md-12 col-sm-12 col-xs-12 sector_company_sec">

                                                        <div class="form-group">
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="companyName2" class="form-label"><?= trans("front.job company Name") ?></label>
                                                                    <input type="text" class="form-control companyName2" name="companyName[1]" id="companyName2" placeholder="<?= trans("front.job For English Title") ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="companySector2" class="form-label"><?= trans("front.job company sector") ?></label>
                                                                    <div class="other_sector">
                                                                        <select name="companySector[1]" id="companySector2" class="form-control companySector" title="<?= trans("front.job company sector") ?>" required>
                                                                            <option value=""><?= trans("front.job company sector") ?></option>
                                                                            <option value="Real Estate"><?= trans("front.job Real Estate") ?></option>
                                                                            <option value="Digital Marketing"><?= trans("front.job Digital Marketing") ?></option>
                                                                            <option value="Management or Consulting"><?= trans("front.job Management Consulting") ?></option>
                                                                            <option value="Education"><?= trans("front.job Education") ?></option>
                                                                            <option value="Tourism"><?= trans("front.job Tourism") ?></option>
                                                                            <option value="General Trade"><?= trans("front.job General Trade") ?></option>
                                                                            <option value="Electrical and Electronics"><?= trans("front.job Electrical and Electronics") ?></option>
                                                                            <option value="Medical and Pharmacy"><?= trans("front.job Medicine and Pharmacology") ?></option>
                                                                            <option value="Furniture and Decoration"><?= trans("front.job Furniture and Decoration") ?></option>
                                                                            <option value="Food and Agriculture"><?= trans("front.job Food and Agriculture") ?></option>
                                                                            <option value="IT Hardware"><?= trans("front.job IT Hardware") ?></option>
                                                                            <option value="Financial or Investment"><?= trans("front.job Financial or Investment") ?></option>
                                                                            <option value="Manufacturing"><?= trans("front.job Manufacturing") ?></option>
                                                                            <option value="Other"><?= trans("front.job Language Other") ?></option>
                                                                        </select>   
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="experience2" class="form-label"><?= trans("front.job Position") ?></label>
                                                                    <input type="text" class="form-control experience2" name="experience[1]" id="experience2" placeholder="<?= trans("front.job For English Title") ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">                                                                    
    <!--                                                                <span class="input_title durationWork_title"><?= trans("front.job Month") ?></span>-->

                                                                <div class="form-group start_date_sec">
                                                                    <label for="durationWorkFrom_m" class="form-label"><?= trans("front.job Working time from") ?></label>
                                                                    <select class="form-control startMonth durationWorkFrom_m" name="durationWorkFrom_m[1]" id="durationWorkFrom_m" required>
                                                                        <option value=""> <?= trans("front.Month") ?></option>
                                                                        <?= $html_months ?>
                                                                    </select>
                                                                    <select class="form-control startYear durationWorkFrom_y" name="durationWorkFrom_y[1]" id="durationWorkFrom_y" required>
                                                                        <option value=""> <?= trans("front.Year") ?></option>
                                                                        <?= $html_years ?>
                                                                    </select>
                                                                </div>

<!--                                                                    <input type="text" class="form-control durationWork dateFrom" name="durationWorkFrom[0]" id="durationWorkFrom1" placeholder="<?= trans("front.job Start") ?>" required>
<input type="text" class="form-control durationWork dateTo" name="durationWorkTo[0]" id="durationWorkTo1" placeholder="<?= trans("front.job End") ?>" required>-->

                                                            </div>

                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">                                                                    
    <!--                                                                <span class="input_title durationWork_title"><?= trans("front.job Month") ?></span>-->

                                                                <div class="form-group start_date_sec">
                                                                    <label for="durationWorkTo_m" class="form-label"><?= trans("front.job Working time to") ?></label>
                                                                    <label class="error date_alert_message"></label>
                                                                    <select class="form-control  startMonth durationWorkTo_m" name="durationWorkTo_m[1]" id="durationWorkTo_m" required>
                                                                        <option value=""> <?= trans("front.Month") ?></option>
                                                                        <?= $html_months ?>
                                                                    </select>
                                                                    <select class="form-control startYear durationWorkTo_y" name="durationWorkTo_y[1]" id="durationWorkTo_y" required>
                                                                        <option value=""> <?= trans("front.Year") ?></option>
                                                                        <?= $html_years ?>
                                                                    </select>
                                                                </div>

<!--                                                                    <input type="text" class="form-control durationWork dateFrom" name="durationWorkFrom[0]" id="durationWorkFrom1" placeholder="<?= trans("front.job Start") ?>" required>
<input type="text" class="form-control durationWork dateTo" name="durationWorkTo[0]" id="durationWorkTo1" placeholder="<?= trans("front.job End") ?>" required>-->

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="add_btn_content">
                                                    <span class="add_btn add_company_btn first_company_sec num">+</span> 
                                                    <p><?= trans("front.job Company Other add") ?></p>
                                                </div>


                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="others_company_sec">

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>




                                            <div class="big_content certificates_sec">

                                                <div class="col-md-12 col-sm-12 col-xs-12">

                                                    <div class="form-group">
                                                        <div class="add_content">
                                                            <label class="form-label jazzira_font_bold bold_title"><?= trans("front.job certificate question") ?></label>

                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="certificateName" class="form-label"><?= trans("front.job Academic Degree") ?></label>
                                                                    <select name="certificateName[]" id="certificateName" class="form-control selectpicker" title="<?= trans("front.job Academic Degree") ?>" required>
                                                                        <option value=""><?= trans("front.job Academic Degree") ?></option>
                                                                        <option value="PhD"><?= trans("front.job PhD") ?></option>
                                                                        <option value="Master"><?= trans("front.job Master") ?></option>
                                                                        <option value="Bachelor's Degree"><?= trans("front.job Bachelors Degree") ?></option>
                                                                        <option value="Diploma"><?= trans("front.job Diploma") ?></option>
                                                                        <option value="Institute"><?= trans("front.job Institute") ?></option>
                                                                        <option value="High School"><?= trans("front.job High School") ?></option>
                                                                        <option value="Middle School"><?= trans("front.job Middle School") ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="specialization" class="form-label"><?= trans("front.job Specialization") ?></label>
                                                                    <input type="text" class="form-control" name="specialization[]" id="specialization" placeholder="<?= trans("front.job Specialization") ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="universityName" class="form-label"><?= trans("front.job university Name") ?></label>
                                                                    <input type="text" class="form-control" name="universityName[]" id="universityName" placeholder="<?= trans("front.job university Name") ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="stillStudying" class="form-label"><?= trans("front.job Study Status") ?></label>
                                                                    <select name="stillStudying[]" id="stillStudying" class="form-control selectpicker stillStudying" title="<?= trans("front.job Study Status") ?>" required>
                                                                        <option data-id="" value=""><?= trans("front.job Study Status") ?></option>
                                                                        <option data-id="1" value="Certified"><?= trans("front.job Certified") ?></option>
                                                                        <option data-id="3" value="Still Studying"><?= trans("front.job Still Studying") ?></option>
                                                                        <option data-id="2" value="Stop Studying"><?= trans("front.job Stop Studying") ?></option>
                                                                    </select>
                                                                    <span class="hasCertificat_alert"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="certificateDegree" class="form-label"><?= trans("front.job Grade") ?></label>
                                                                    <span class="input_title certificateDegree_title">%</span>
                                                                    <input type="text" class="form-control certificateDegree" name="certificateDegree[]" id="certificateDegree" placeholder=" " required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 col-sm-4 col-xs-12 page_sec">
                                                                <div class="form-group">
                                                                    <label for="certificateDate" class="form-label"><?= trans("front.job Graduation Date") ?></label>
                                                                    <select class="form-control selectpicker startYear date" name="certificateDate[]" id="certificateDate" required>
                                                                        <option value=""> <?= trans("front.Year") ?></option>
                                                                        <?= $html_years ?>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="add_btn_content">
                                                    <span class="add_btn add_certificate_btn num">+</span> 
                                                    <p><?= trans("front.job Certificate Other add") ?></p>
                                                </div>


                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="others_certificate_sec page_sec">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </section>



                                        <h3 class="headerTag"><?= trans("front.job Languages and entitlements") ?></h3>
                                        <section class="step_content">

                                            <div class="big_content">
                                                <div class="add_content">

                                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                                        <div class="form-group">
                                                            <label class="form-label jazzira_font_bold bold_title"><?= trans("front.job Except for the mother tongue") ?></label>

                                                            <div class="col-md-2 col-sm-2 col-xs-2 page_sec static_lang">
                                                                <div class="form-group pdding_right_15">
                                                                    <label for="langName" class="form-label"></label>
                                                                    <input type="hidden" class="form-control" name="langName[0]" id="langName1" value="Turkish"/>

<!--                                                                    <select name="langName[0]" id="langName1" class="form-control selectpicker" title="<?= trans("front.job Turkish") ?>" required>
                                                                        <option value="Turkish" selected><?= trans("front.job Language Turkish") ?></option>
                                                                    </select>-->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6 page_sec md_size">
                                                                <div class="form-group">
                                                                    <label for="langLevel" class="form-label"><?= trans("front.job Language Turkish") ?></label>
                                                                    <select name="langLevel[0]" id="langLevel1" class="form-control selectpicker" title="<?= trans("front.job Language Level") ?>" required>
                                                                        <option value=""><?= trans("front.job Chose Language Level") ?></option>
                                                                        <option value="Beginner"><?= trans("front.job Beginner") ?></option>
                                                                        <option value="Intermediate"><?= trans("front.job Intermediate") ?></option>
                                                                        <option value="Upper Intermediate"><?= trans("front.job Upper Intermediate") ?></option>
                                                                        <option value="Advanced"><?= trans("front.job Advanced") ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6 page_sec md_size">
                                                                <div class="form-group">
                                                                    <label for="hasCertificat" class="form-label"><?= trans("front.job Proficiency Proof") ?></label>
                                                                    <select name="hasCertificat[0]" id="hasCertificat1" class="form-control selectpicker hasCertificat" title="<?= trans("front.job Proficiency Proof subtitle") ?>" required>
                                                                        <option value=""><?= trans("front.job Proficiency Proof") ?></option>
                                                                        <option value="yes"><?= trans("front.job Yes") ?></option>
                                                                        <option value="no"><?= trans("front.job No") ?></option>
                                                                    </select>
                                                                    <span class="hasCertificat_alert"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 col-sm-12 col-xs-12">


                                                        <div class="form-group">

                                                            <div class="col-md-2 col-sm-2 col-xs-2 page_sec static_lang">
                                                                <div class="form-group pdding_right_15">

                                                                    <label for="langName" class="form-label"></label>
                                                                    <input type="hidden" class="form-control" name="langName[1]" id="langName1" value="English"/>

<!--                                                                    <select name="langName[1]" id="langName2" class="form-control selectpicker" title="<?= trans("front.job English") ?>" required>
    <option value="English" selected><?= trans("front.job Language English") ?></option>
</select>-->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6 page_sec md_size">
                                                                <div class="form-group">
                                                                    <label for="langLevel" class="form-label"><?= trans("front.job Language English") ?></label>
                                                                    <select name="langLevel[1]" id="langLeve2" class="form-control selectpicker" title="<?= trans("front.job Language Level") ?>" required>
                                                                        <option value=""><?= trans("front.job Chose Language Level") ?></option>
                                                                        <option value="Beginner"><?= trans("front.job Beginner") ?></option>
                                                                        <option value="Intermediate"><?= trans("front.job Intermediate") ?></option>
                                                                        <option value="Upper Intermediate"><?= trans("front.job Upper Intermediate") ?></option>
                                                                        <option value="Advanced"><?= trans("front.job Advanced") ?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6 page_sec md_size">
                                                                <div class="form-group">
                                                                    <label for="hasCertificat" class="form-label"><?= trans("front.job Proficiency Proof") ?></label>
                                                                    <select name="hasCertificat[1]" id="hasCertificat2" class="form-control selectpicker hasCertificat" title="<?= trans("front.job Proficiency Proof subtitle") ?>" required>
                                                                        <option value=""><?= trans("front.job Proficiency Proof") ?></option>
                                                                        <option value="yes"><?= trans("front.job Yes") ?></option>
                                                                        <option value="no"><?= trans("front.job No") ?></option>
                                                                    </select>
                                                                    <span class="hasCertificat_alert"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="add_btn_content">
                                                    <span class="add_btn add_lang_btn num">+</span>
                                                    <p><?= trans("front.job Language Other add") ?></p>
                                                </div>


                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <div class="others_lang_sec page_sec">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>





                                            <div class="col-md-12 col-sm-12 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="message" class="form-label"><?= trans("front.job Message Title") ?></label>
                                                    <textarea type="text" class="form-control" name="h_message" id="message" placeholder="<?= trans("front.job Message placeholder Title") ?>" required></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4 page_sec">
                                                <div class="form-group">
                                                    <label for="availability" class="form-label"><?= trans("front.job Availability") ?></label>
                                                    <select name="h_availability" id="availability" class="form-control selectpicker" title=" <?= trans("front.job Availability") ?>" required>
                                                        <option value=""><?= trans("front.job Availability") ?></option>
                                                        <option value="Direct"><?= trans("front.job Availability Direct") ?></option>
                                                        <option value="Soon"><?= trans("front.job Availability Soon") ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4 page_sec">
                                                <div class="form-group">
                                                    <label for="typeJob" class="form-label"><?= trans("front.job Type Job") ?></label>
                                                    <select name="h_type_job" id="typeJob" class="form-control selectpicker" title="<?= trans("front.job Type Job") ?>" required>
                                                        <option value=""><?= trans("front.job Type Job") ?></option>
                                                        <option value="Full time"><?= trans("front.job Type Full time") ?></option>
                                                        <option value="Part time"><?= trans("front.job Type Part time") ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4 page_sec">
                                                <div class="form-group">
                                                    <label for="salary" class="form-label">
                                                        <?= trans("front.job expected salary") ?>
                                                    </label>
                                                    <span class="input_title salary_title"><?= trans("front.job TL") ?></span>
                                                    <div class="salary_sec">
                                                        <input type="text" id="salary" name="h_salary" class="form-control salary" value="" required/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-4 page_sec commission_sec">

                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4 page_sec number_sales_sec">

                                            </div>

                                            <div class="col-md-12 col-sm-12 col-xs-12 page_sec">
                                                <div class="form-group">
                                                    <label for="h_linkedin" class="form-label"><?= trans("front.job linkedin") ?></label>
                                                    <span class="input_title commission_title"><i class="fa fa-linkedin"></i></span>
                                                    <input type="url" class="form-control" name="h_linkedin" id="h_linkedin" placeholder="https://www.linkedin.com/">
                                                </div>
                                            </div>


                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <span class="line"></span>
                                            </div>

                                            <div class="col-md-12 col-sm-12 col-xs-12 page_sec acceptTerms_sec">
                                                <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"/>
                                                <label for="acceptTerms"><?= trans("front.job accept title") ?></label>
                                            </div>

                                        </section>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- share page links -->
                <?php //if (Helper::get_device() == 'mob') { ?>
                <div class="sec">
                    @include("front.partials.share_links", [])
                </div>
                <?php //} ?>



                <!--
				<div class="section"  id="ws1">
					<div class="item">
						<h2 class="jazzira_font_bold"><?= trans("front.job work our us title") ?></h2>
							<img class="vacancies-photo" src="/img/vacancies-photo-full.png">
							<div class="col-md-12"><img class="guarantee" src="/img/guarantee-section.svg"></div>
					</div>
				</div>-->





                <div class="jobs_list sec">

                    <h2 class="sub_title int jazzira_font_bold"><?= trans("front.Latest jobs in Turkey at damasturk") ?></h2>

                    <?php
                    /*$arr_jobs = array(
                        "Telesales Manager" => trans("front.job consultancy department Manager"),
                        "Arabic Telesales" => trans("front.job Telesales Consultant Arabic"),
                        "English Telesales" => trans("front.job Telesales Consultant English"),
                        "French Telesales" => trans("front.job Telesales Consultant French"),
                        "Persian Telesales" => trans("front.job Telesales Consultant Persian"),
                        "Russian Telesales" => trans("front.job Telesales Consultant Russian"),
                        "Sales Manager" => trans("front.job Sales manager"),
                        "Salesman" => trans("front.job field sales officer"),
                        "Portfolio Manager" => trans("front.job portfolio manager"),
                        "After Sales" => trans("front.job After-sales service officer"),
                        "Marketing Manager" => trans("front.job Marketing Manager"),
                        "Media Manager" => trans("front.job Media Manager"),
                        "Backend Developer" => trans("front.job Backend Developer"),
                        "Frontend Developer" => trans("front.job Frontend Developer"),
                        "SEO Specialist" => trans("front.job SEO specialist"),
                        "Ads Specialist" => trans("front.job Ads Specialist"),
                        "Graphic Designer" => trans("front.job Graphic designer"),
                        "Photographer" => trans("front.job Photographer"),
                        "Monteur" => trans("front.job Monteur"),
                        "Social Media Specialist" => trans("front.job Social Media specialist"),
                        "Content Writer" => trans("front.job Content Writer"),
                        "IT Hardware" => trans("front.job IT officer"),
                        "Video Presenter" => trans("front.job Video Presenter"),
                        "HR Manager" => trans("front.job HR Manager"),
                        "Quality Assurance Supervisor" => trans("front.job Quality Assurance Supervisor"),
                        "Personnel Supervisor" => trans("front.job Personnel Supervisor"),
                        "Lawyer" => trans("front.job Lawyer"),
                        "Legal Affairs Officer" => trans("front.job Legal Affairs Officer"),
                        "Accountant" => trans("front.job Accountant"),
                        "Construction Engineer" => trans("front.job Construction Engineer"),
                        "Administrative" => trans("front.job Administrative"),
                        "Trainee" => trans("front.job Trainee"),
                        "Secretary" => trans("front.job Secretary"),
                        "Cars Coordinator" => trans("front.job Cars Manager"),
                        "CEO" => trans("front.job CEO"),
                        "Social Media Manager" => trans("front.job Social Media Manager")
                    );*/
					
                    foreach ($jobs as $j) {
						
						$role = \App\Models\HrJobs::where("published",true)->where("job_title_en",$j->position)->first();
                        ?>
                        <div class="job_item">
                            <div class="cont shadow_type">
                                <span class="job_top_title"> {{ $j->getTitle() }} </span>
                                <?php if($role!=false){ ?>
								<h3 class="jazzira_font_bold">{{ ($current_lang == 'ar'?$role->job_title_ar:$role->job_title_en) }} </h3>
                                <?php } ?>
								<ul class="job_details_list">
                                    <li>
                                        <i class="fa fa-calendar"></i>
                                        <span><?= date_format(new DateTime($j->created_at), "d/m/Y"); ?></span>
                                    </li>
                                    <li>
                                        <i class="fa fa-flag"></i>
                                        <span class="num">Global - USD</span>
                                    </li>
                                </ul>
                                <div class="description">
                                    <p>
                                        {{ Helper::str_limit($j->getAbout(),350) }}
                                    </p>
                                </div>
                                <a href="{{ route('front.job_details',$j->slug) }}" title="Meta Title" alt='Meta Description'><?= trans("front.details") ?></a>
                            </div>
                        </div>
                    <?php } ?>

                </div>




            </div>
            <!-- End Left Section -->


        </div>


        <div class="content_section"> 
            <div class="cont">
                <?php echo html_entity_decode($row->getContent()); //trans("front.job caption text")  ?>
            </div> 
            <div class="action_content"> 
                <span class="show_more_btn"><?= trans("front.read more"); ?></span> 
                <span class="show_less_btn" style="display: none;"><?= trans("front.read less"); ?></span>
            </div> 
        </div>


        <div class="section work_features_slider">

            <div class="int_content int">

                <h2 class="sub_title int jazzira_font_bold"><?= trans("front.job work our us title") ?></h2>

                <div class="wrapper sec">

                    <div class="slider" <?php if ($current_lang == 'ar' || $current_lang == 'pe') { ?>  dir="rtl"  <?php } else { ?>  dir="ltr" <?php } ?>>

                        <div class="slider__wrap swiper-wrapper">

                            <div class="item swiper-slide">
                                <div class="cont shadow_type">
                                    <h4 class="cont_sub_title"><?= trans("front.Functional features") ?></h4>
                                    <img class="lazy" loading="lazy" src='/img/FU1-1-<?= $current_lang ?>.svg' title="<?= trans("front.Functional features") ?>" alt="رواتب ونسب مجزية، بدل طعام ومواصلات، اذن عمل وتأمين صحي لك ولعائلتك، نعتمد قانون العمل التركي بشكل تام، مواصلات سهلة قرب محطة المترو والمتروبوس">
                                    <div class="icon"></div>
                                </div>
                            </div>

                            <div class="item swiper-slide">
                                <div class="cont shadow_type">
                                    <h4 class="cont_sub_title"><?= trans("front.How can you increase your sales with us") ?></h4>
                                    <img class="lazy" loading="lazy" src="/img/FU1-2-<?= $current_lang ?>.svg" title="<?= trans("front.How can you increase your sales with us") ?>" alt="دورات تدريبية دورية من قبل مختصين بالعقار التركي، متابعة يومية من قبل مشرفين مختصين لرفع الأداء، عملاء مهتمين يوميا بجودة عالية، طرق احترافية في ادارة العملاء، جولات ميدانية دورية على المشاريع العقارية">
                                    <div class="icon"></div>
                                </div>
                            </div>

                            <div class="item swiper-slide">
                                <div class="cont shadow_type">
                                    <h4 class="cont_sub_title"><?= trans("front.damasturk in a glimmer") ?></h4>
                                    <img class="lazy" loading="lazy" src="/img/FU1-3-<?= $current_lang ?>.svg" title="<?= trans("front.damasturk in a glimmer") ?>" alt="خبرتنا في سوق العقار التركي منذ العام 2014، مكاتبنا في مركز التجارة العالمي في اسطنبول، شركة مؤسساتية تضم عدة اقسام وفروع، كادر احترافي ذو خبرة واسعة في سوق العقارات التركية">
                                    <div class="icon"></div>
                                </div>
                            </div>

                        </div>

                        <div class="slider__controls">

                            <div class="slider__pagination"></div>

                            <div class="slider__button-next"></div>
                            <div class="slider__button-prev"></div>
                        </div>




                    </div>

                </div>
            </div>


        </div>



    </div>
</div>







@endsection



@section('scriptjs')

<!--<script src="{{ URL::to('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') }}"></script> -->
<!--<script src="{{ URL::to('https://into-the-program.com/demo/assets/js/jquery.validate.min.js') }}"></script> -->
<script src="{{ URL::to('https://foliotek.github.io/Croppie/croppie.js') }}"></script> 
<script src="{{ URL::to('https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js') }}"></script> 
<script src="{{ URL::to('https://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js') }}"></script>

<?php if ($current_lang == 'ar') { ?>
    <script src="{{ URL::to('https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/localization/messages_ar.js') }}"></script> 
<?php } else { ?>
    <script src="{{ URL::to('https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/localization/messages_en.js') }}"></script> 

<?php } ?>


<script src="{{ URL::to('https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.js') }}"></script> 
<!--<script src="{{ URL::to('https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js') }}"></script> -->
<!--<script src="{{ URL::to('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js') }}"></script>-->
<script src="{{ URL::to('https://cdn.jsdelivr.net/momentjs/latest/moment.min.js') }}"></script>
<!--<script src="{{ URL::to('https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js') }}"></script>-->


<div class="overlay" style="opacity:0.2;display:none">
    <div class="overlayDoor"></div>
    <div class="overlayContent">
        <div class="loader">
            <div class="inner"></div>
        </div>
    </div>
</div>
<script src="{{ URL::to('js/jquery.form.js') }}"></script> 
<!--<script type="text/javascript" src="{{ URL::to('js/scrol_overflow.js') }}"></script>
<script type="text/javascript" src="{{ URL::to('js/scrollpage.js') }}"></script>-->
<script>

$('.main_menu .links>li>a.job_btn').addClass("active");
$('.whatsapp_direct_btn').hide();

$('#tabs li a').click(function () {
    id = $(this).attr('href');
    $("#tabs.nav li").removeClass("active");
    $(this).parent("li").addClass("active");
    $('.tab-pane').removeClass('in').removeClass('active');
    $(id).addClass('in').addClass('active');
});


// Start upload preview image
$(".gambar").attr("src", "/img/profile-defult.svg");
var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.upload-demo').addClass('ready');
            $('#cropImagePop').modal('show');
            rawImg = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        swal("Sorry - you're browser doesn't support the FileReader API");
    }
}

$uploadCrop = $('#upload-demo').croppie({
    viewport: {
        width: 150,
        height: 150,
        type: 'circle'
    },
    enforceBoundary: false,
    enableExif: true
});
$('#cropImagePop').on('shown.bs.modal', function () {
    // alert('Shown pop');
    $uploadCrop.croppie('bind', {
        url: rawImg
    }).then(function () {
        console.log('jQuery bind complete');
    });
});

$('.item-img').on('change', function () {
    imageId = $(this).data('id');
    tempFilename = $(this).val();
    $('#cancelCropBtn').data('id', imageId);
    readFile(this);
});
$('#cropImageBtn').on('click', function (ev) {
    $uploadCrop.croppie('result', {
        type: 'base64',
        format: 'jpeg',
        size: {width: 150, height: 150}
    }).then(function (resp) {
        $('#h_profile_image').val(resp);
        $('#item-img-output').attr('src', resp);
        $('#cropImagePop').modal('hide');
    });
});
// End upload preview image









/*
 //$(document).ready(function () {
 //    $('.minus').click(function () {
 //        var $input = $(this).parent().find('input.salary');
 //        var count = parseInt($input.val()) - 200;
 //        count = count < 4000 ? 4000 : count;
 //        $input.val(count);
 //        $input.change();
 //        return false;
 //    });
 //    $('.plus').click(function () {
 //        var $input = $(this).parent().find('input.salary');
 //        $input.val(parseInt($input.val()) + 200);
 //        $input.change();
 //        return false;
 //    });
 //});
 */



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


var companyNameTitle = "<?= trans("front.job company Name") ?>";
var MonthTitle = "<?= trans("front.job Month") ?>";
var PositionTitle = "<?= trans("front.job Position") ?>";
var AcademicDegreeTitle = "<?= trans("front.job Academic Degree") ?>";
var MiddleSchoolTitle = "<?= trans("front.job Middle School") ?>";
var HighSchoolTitle = "<?= trans("front.job High School") ?>";
var InstituteTitle = "<?= trans("front.job Institute") ?>";
var DiplomaTitle = "<?= trans("front.job Diploma") ?>";
var BachelorsDegreeTitle = "<?= trans("front.job Bachelors Degree") ?>";
var MasterTitle = "<?= trans("front.job Master") ?>";
var PhDTitle = "<?= trans("front.job PhD") ?>";
var SpecializationTitle = "<?= trans("front.job Specialization") ?>";
var StudyStatusTitle = "<?= trans("front.job Study Status") ?>";
var CertifiedTitle = "<?= trans("front.job Certified") ?>";
var StopStudyingTitle = "<?= trans("front.job Stop Studying") ?>";
var StillStudyingTitle = "<?= trans("front.job Still Studying") ?>";
var ChoseLanguageTitle = "<?= trans("front.job Chose Language") ?>";
var TurkishTitle = "<?= trans("front.job Language Turkish") ?>";
var EnglishTitle = "<?= trans("front.job Language English") ?>";
var FrancaisTitle = "<?= trans("front.job Language Francais") ?>";
var PersianTitle = "<?= trans("front.job Language Persian") ?>";
var RussianTitle = "<?= trans("front.job Language Russian") ?>";
var ArabicTitle = "<?= trans("front.job Language Arabic") ?>";
var UrduTitle = "<?= trans("front.job Language Urdu") ?>";
var OtherTitle = "<?= trans("front.job Language Other") ?>";
var LanguageLevelTitle = "<?= trans("front.job Language Level") ?>";
var BeginnerTitle = "<?= trans("front.job Beginner") ?>";
var IntermediateTitle = "<?= trans("front.job Intermediate") ?>";
var UpperIntermediateTitle = "<?= trans("front.job Upper Intermediate") ?>";
var AdvancedTitle = "<?= trans("front.job Advanced") ?>";
var ProficiencyProofTitle = "<?= trans("front.job Proficiency Proof") ?>";
var YesTitle = "<?= trans("front.job Yes") ?>";
var NoTitle = "<?= trans("front.job No") ?>";
var commissionTitle = "<?= trans("front.job commission title") ?>";
var numberSalesTitle = "<?= trans("front.job number sales title") ?>";
var numberSalesTitle_small = "<?= trans("front.job number sales title small") ?>";
var PropertyTitle = "<?= trans("front.job Property") ?>";
var companySectorTitle = "<?= trans("front.job company sector") ?>";
var RealEstateTitle = "<?= trans("front.job Real Estate") ?>";
var DigitalMarketingTitle = "<?= trans("front.job Digital Marketing") ?>";
var ManagementConsultingTitle = "<?= trans("front.job Management Consulting") ?>";
var EducationTitle = "<?= trans("front.job Education") ?>";
var TourismTitle = "<?= trans("front.job Tourism") ?>";
var GeneralTradeTitle = "<?= trans("front.job General Trade") ?>";
var ElectricalElectronicsTitle = "<?= trans("front.job Electrical and Electronics") ?>";
var MedicinePharmacologyTitle = "<?= trans("front.job Medicine and Pharmacology") ?>";
var FurnitureDecorationTitle = "<?= trans("front.job Furniture and Decoration") ?>";
var FoodAgricultureTitle = "<?= trans("front.job Food and Agriculture") ?>";
var StartTitle = "<?= trans("front.job Start") ?>";
var EndTitle = "<?= trans("front.job End") ?>";
var LabelNameEnglishTitle = "<?= trans("front.job For English Title") ?>";
var LanguageNameTitle = "<?= trans("front.job Language Name") ?>";
var otherSectorTitle = "<?= trans("front.job other Sector Title") ?>";
var ProficiencyAlertTitle = "<?= trans("front.job Proficiency proof is required in interview") ?>";
var universityNameTitle = "<?= trans("front.job university Name") ?>";
var GradeTitle = "<?= trans("front.job Grade") ?>";
var GraduationDateTitle = "<?= trans("front.job Graduation Date") ?>";


$('.plus_degree').click(function () {

    $('#hide_degree_blk .line2:first').appendTo('.degree_blk');
});
$('.plus_exper').click(function () {
    $('.exper_blk').append($('#hide_exper_blk').html());
});
$(document).on('click', '.remove_degree', function () {
    $(this).parent('div').parent('div').appendTo('#hide_degree_blk');

});
$(document).on('click', '.remove_exper', function () {
    $(this).parent('div').parent('div').remove();
});



$(document).on('click', '.add_company_btn', function () {


    if ($('.others_company_sec .add_content').length < 1) {
        $(".others_company_sec").append(
                '<div class="add_content sector_company_sec" id="' + $('.others_company_sec .add_content').length + '">' +
                '<span class="delete_btn delete_company_btn num">x</span>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group pdding_right_15">' +
                '<input type="text" class="form-control" name="companyName[2]" id="companyName" placeholder="' + companyNameTitle + LabelNameEnglishTitle + '" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<div class="other_sector">' +
                '<select name="companySector[2]" id="companySector3" class="form-control companySector" title="' + companySectorTitle + '" required>' +
                '<option value="">' + companySectorTitle + '</option>' +
                '<option value="Real Estate">' + RealEstateTitle + '</option>' +
                '<option value="Digital Marketing">' + DigitalMarketingTitle + '</option>' +
                '<option value="Management Consulting">' + ManagementConsultingTitle + '</option>' +
                '<option value="Education">' + EducationTitle + '</option>' +
                '<option value="Tourism">' + TourismTitle + '</option>' +
                '<option value="General Trade">' + GeneralTradeTitle + '</option>' +
                '<option value="Electrical and Electronics">' + ElectricalElectronicsTitle + '</option>' +
                '<option value="Medical and Pharmacy">' + MedicinePharmacologyTitle + '</option>' +
                '<option value="Furniture and Decoration">' + FurnitureDecorationTitle + '</option>' +
                '<option value="Food and Agriculture">' + FoodAgricultureTitle + '</option>' +
                '<option value="IT Hardware"><?= trans("front.job IT Hardware") ?></option>' +
                '<option value="Financial or Investment"><?= trans("front.job Financial or Investment") ?></option>' +
                '<option value="Manufacturing"><?= trans("front.job Manufacturing") ?></option>' +
                '<option value="Other">' + OtherTitle + '</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<input type="text" class="form-control experience3" name="experience[2]" id="experience3" placeholder="' + PositionTitle + LabelNameEnglishTitle + '" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group start_date_sec">' +
                '<label for="durationWorkFrom_m" class="form-label"><?= trans("front.job Working time from") ?></label>' +
                '<select class="form-control startMonth durationWorkFrom_m" name="durationWorkFrom_m[2]" id="durationWorkFrom_m" required>' +
                '<option value=""> <?= trans("front.Month") ?></option>' +
                '<?= $html_months ?>' +
                '</select>' +
                '<select class="form-control startYear durationWorkFrom_y" name="durationWorkFrom_y[2]" id="durationWorkFrom_y" required>' +
                '<option value=""> <?= trans("front.Year") ?></option>' +
                '<?= $html_years ?>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group start_date_sec">' +
                '<label for="durationWorkTo_m" class="form-label"><?= trans("front.job Working time to") ?></label>' +
                '<label class="error date_alert_message"></label>' +
                '<select class="form-control startMonth durationWorkTo_m" name="durationWorkTo_m[2]" id="durationWorkTo_m" required>' +
                '<option value=""> <?= trans("front.Month") ?></option>' +
                '<?= $html_months ?>' +
                '</select>' +
                '<select class="form-control startYear durationWorkTo_y" name="durationWorkTo_y[2]" id="durationWorkTo_y" required>' +
                '<option value=""> <?= trans("front.Year") ?></option>' +
                '<?= $html_years ?>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>'
                );

    }
});


$(document).on('click', '.add_certificate_btn', function () {


    if ($('.others_certificate_sec .add_content').length < 2) {
        $(".others_certificate_sec").append(
                '<div class="add_content" id="' + $('.others_certificate_sec .add_content').length + '">' +
                '<span class="delete_btn delete_certificate_btn num">x</span>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<select name="certificateName[' + ($('.others_certificate_sec .add_content').length + 1) + ']" id="certificateName3" class="form-control" title="' + AcademicDegreeTitle + '" required>' +
                '<option value="">' + AcademicDegreeTitle + '</option>' +
                '<option value="PhD">' + PhDTitle + '</option>' +
                '<option value="Master">' + MasterTitle + '</option>' +
                '<option value="' + "Bachelor's Degree" + '">' + BachelorsDegreeTitle + '</option>' +
                '<option value="Diploma">' + DiplomaTitle + '</option>' +
                '<option value="Institute">' + InstituteTitle + '</option>' +
                '<option value="High School">' + HighSchoolTitle + '</option>' +
                '<option value="Middle School">' + MiddleSchoolTitle + '</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<input type="text" class="form-control" name="specialization[' + ($('.others_certificate_sec .add_content').length + 1) + ']" id="specialization3" placeholder="' + SpecializationTitle + '" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<input type="text" class="form-control" name="universityName[' + ($('.others_certificate_sec .add_content').length + 1) + ']" id="universityName3" placeholder="' + universityNameTitle + '" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<select name="stillStudying[' + ($('.others_certificate_sec .add_content').length + 1) + ']" id="stillStudying3" class="form-control stillStudying" title="' + StudyStatusTitle + '" required>' +
                '<option value="">' + StudyStatusTitle + '</option>' +
                '<option data-id="1" value="Certified">' + CertifiedTitle + '</option>' +
                '<option data-id="3" value="Still Studying">' + StillStudyingTitle + '</option>' +
                '<option data-id="2" value="Stop Studying">' + StopStudyingTitle + '</option>' +
                '</select>' +
                '<span class="hasCertificat_alert"></span>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<span class="input_title certificateDegree_title">%</span>' +
                '<input type="text" class="form-control certificateDegree" name="certificateDegree[' + ($('.others_certificate_sec .add_content').length + 1) + ']" id="certificateDegree3" placeholder="' + GradeTitle + '" required>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-12 page_sec">' +
                '<div class="form-group">' +
                '<select class="form-control startYear date" name="certificateDate[' + ($('.others_certificate_sec .add_content').length + 1) + ']" id="certificateDate" required>' +
                '<option value=""> <?= trans("front.Year") ?></option>' +
                '<?= $html_years ?>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>'
                );

    }
});

$(document).on('click', '.add_lang_btn', function () {


    if ($(".others_lang_sec .add_content").length < 1) {
        $(".others_lang_sec").append(
                '<div class="add_content" id="' + $('.others_lang_sec .add_content').length + '">' +
                '<span class="delete_btn delete_lang_btn num">x</span>' +
                '<div class="col-md-4 col-sm-4 col-xs-4 page_sec">' +
                '<div class="form-group">' +
                '<div class="other_lang">' +
                '<select name="langName[2]" id="langName3" class="form-control langName_select" required>' +
                '<option value="">' + ChoseLanguageTitle + '</option>' +
                '<option value="French">' + FrancaisTitle + '</option>' +
                '<option value="Persian">' + PersianTitle + '</option>' +
                '<option value="Urdu">' + UrduTitle + '</option>' +
                '<option value="Russian">' + RussianTitle + '</option>' +
                '<option value="Arabic">' + ArabicTitle + '</option>' +
                '<option value="Other">' + OtherTitle + '</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-4 page_sec">' +
                '<div class="form-group">' +
                '<select name="langLevel[2]" id="langLeve3" class="form-control " title="' + LanguageLevelTitle + '" required>' +
                '<option value="">' + LanguageLevelTitle + '</option>' +
                '<option value="Beginner">' + BeginnerTitle + '</option>' +
                '<option value="Intermediate">' + IntermediateTitle + '</option>' +
                '<option value="Upper Intermediate">' + UpperIntermediateTitle + '</option>' +
                '<option value="Advanced">' + AdvancedTitle + '</option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '<div class="col-md-4 col-sm-4 col-xs-4 page_sec">' +
                '<div class="form-group">' +
                '<select name="hasCertificat[2]" id="hasCertificat3" class="form-control hasCertificat" title="' + ProficiencyProofTitle + '" required>' +
                '<option value="">' + ProficiencyProofTitle + '</option>' +
                '<option value="yes">' + YesTitle + '</option>' +
                '<option value="no">' + NoTitle + '</option>' +
                '</select>' +
                '<span class="hasCertificat_alert"></span>' +
                '</div>' +
                '</div>'
                );

    }
});



$(document).on('click', '.delete_company_btn', function () {

    $(this).parents(".add_content").remove();

    var dataName = 'notCommission';
    var dataSector = '';

    $('#job').find('option:selected').each(function () {
        if ($(this).attr("data-name") == 'withCommission') {
            dataName = 'withCommission';
        }
    });


    if ($('select[name="companySector[0]"]').val() == 'Real Estate' || $('select[name="companySector[1]"]').val() == 'Real Estate' || $('select[name="companySector[2]"]').val() == 'Real Estate') {
        dataSector = 'Real Estate';
    } else {
        dataSector = 'Other';
    }

    if (dataName == 'withCommission' && dataSector == 'Real Estate') {
        $(".commission_sec").empty();
        $(".number_sales_sec").empty();

        $(".commission_sec").append(
                '<div class="form-group">' +
                '<label for="commission" class="form-label">' + commissionTitle + '</label>' +
                '<span class="input_title commission_title">%</span>' +
                '<input type="text" class="form-control" name="h_commission" id="commission" placeholder=""  min="1" max="10" required>' +
                '</div>'
                );
        $(".number_sales_sec").append(
                '<div class="form-group">' +
                '<label for="numberSales" class="form-label">' + numberSalesTitle + '</label>' +
                '<small>' + numberSalesTitle_small + '</small>' +
                '<span class="input_title number_sales_title">' + PropertyTitle + '</span>' +
                '<input type="text" id="numberSales" name="h_number_sales" class="form-control" value="" min="0" max="200" required/>' +
                '</div>'
                );

    } else {
        $(".commission_sec").empty();
        $(".number_sales_sec").empty();
    }



});


$(document).on('click', '.delete_certificate_btn', function () {

    $(this).parents(".add_content").remove();
});


$(document).on('click', '.delete_lang_btn', function () {

    $(this).parents(".add_content").remove();
});



$('.read_more').click(function () {
    $('.text_content').toggleClass('full');
});



$(document).on('change', '.stillStudying', function () {
    var StudyingVal = $(this).find(':selected').attr('data-id');
    var thisDate = $(this).parents('.add_content').find('.date');
    var thisDegree = $(this).parents('.add_content').find('.certificateDegree');
    var thisAlert = $(this).parents(".form-group").find(".hasCertificat_alert");
    if (StudyingVal == 2) {
        $(thisDate).attr("disabled", "disabled");
        $(thisDegree).attr("disabled", "disabled");
        $(thisAlert).fadeOut();
        $(thisAlert).text("");
    } else if (StudyingVal == 3) {
        $(thisDate).attr("disabled", "disabled");
        $(thisDegree).attr("disabled", "disabled");
        $(thisAlert).fadeOut();
        $(thisAlert).text("");
    } else if (StudyingVal == 1) {
        $(thisAlert).fadeIn();
        $(thisAlert).text(ProficiencyAlertTitle);
        $(thisDate).removeAttr("disabled");
        $(thisDegree).removeAttr("disabled");
    } else {
        $(thisDate).removeAttr("disabled");
        $(thisDegree).removeAttr("disabled");
        $(thisAlert).fadeOut();
        $(thisAlert).text("");
    }

});



$(document).on('change', 'select#job', function () {
    /*var dataName = $(this).find('option:selected').attr("data-name");*/
    var dataName = 'notCommission';
    var dataSector = '';

    $('#job').find('option:selected').each(function () {
        if ($(this).attr("data-name") == 'withCommission') {
            dataName = 'withCommission';
        }
    });


    if ($('select[name="companySector[0]"]').val() == 'Real Estate' || $('select[name="companySector[1]"]').val() == 'Real Estate' || $('select[name="companySector[2]"]').val() == 'Real Estate') {
        dataSector = 'Real Estate';
    } else {
        dataSector = 'Other';
    }

    if (dataName == 'withCommission' && dataSector == 'Real Estate') {
        $(".commission_sec").empty();
        $(".number_sales_sec").empty();

        $(".commission_sec").append(
                '<div class="form-group">' +
                '<label for="commission" class="form-label">' + commissionTitle + '</label>' +
                '<span class="input_title commission_title">%</span>' +
                '<input type="text" class="form-control" name="h_commission" id="commission" placeholder=""  min="1" max="10" required>' +
                '</div>'
                );
        $(".number_sales_sec").append(
                '<div class="form-group">' +
                '<label for="numberSales" class="form-label">' + numberSalesTitle + '</label>' +
                '<small>' + numberSalesTitle_small + '</small>' +
                '<span class="input_title number_sales_title">' + PropertyTitle + '</span>' +
                '<input type="text" id="numberSales" name="h_number_sales" class="form-control" value="" min="0" max="200" required/>' +
                '</div>'
                );

    } else {
        $(".commission_sec").empty();
        $(".number_sales_sec").empty();
    }

});

$(document).on('change', 'select.companySector', function () {
    var SectorName = this.value;
    var thisOtherSector = $(this).parents(".other_sector");
    var commissionSec = $(".commission_sec");
    var numberSalesSec = $(".number_sales_sec");
    var dataName = 'notCommission';
    var dataSector = '';

    if ($('select[name="companySector[0]"]').val() == 'Real Estate' || $('select[name="companySector[1]"]').val() == 'Real Estate' || $('select[name="companySector[2]"]').val() == 'Real Estate') {
        dataSector = 'Real Estate';
    } else {
        dataSector = 'Other';
    }

    $('#job').find('option:selected').each(function () {
        if ($(this).attr("data-name") == 'withCommission') {
            dataName = 'withCommission';
        }
    });


    if (SectorName == "Other") {
        var nme = $(this).attr('name');
        $(thisOtherSector).empty();
        $(thisOtherSector).append(
                '<div class="input_other_sector">' +
                '<span class="delete_other_sector">x</span>' +
                '<input type="text" id="inputOtherSector" name="' + nme + '" class="form-control" placeholder="' + otherSectorTitle + '" required/>' +
                '</div>'
                );

    } else if (dataName == 'withCommission' && dataSector == 'Real Estate') {

        $(".commission_sec").empty();
        $(".number_sales_sec").empty();

        $(".commission_sec").append(
                '<div class="form-group">' +
                '<label for="commission" class="form-label">' + commissionTitle + '</label>' +
                '<span class="input_title commission_title">%</span>' +
                '<input type="text" class="form-control" name="h_commission" id="commission" placeholder=""  min="1" max="10" required>' +
                '</div>'
                );
        $(".number_sales_sec").append(
                '<div class="form-group">' +
                '<label for="numberSales" class="form-label">' + numberSalesTitle + '</label>' +
                '<small>' + numberSalesTitle_small + '</small>' +
                '<span class="input_title number_sales_title">' + PropertyTitle + '</span>' +
                '<input type="text" id="numberSales" name="h_number_sales" class="form-control" value="" min="0" max="200" required/>' +
                '</div>'
                );

    } else {
        $(".commission_sec").empty();
        $(".number_sales_sec").empty();
    }
});

$(document).on('click', '.delete_other_sector', function () {
    var thisOtherSector = $(this).parents(".other_sector");
    var nme = $(thisOtherSector).find("input").attr('name');
    $(thisOtherSector).empty();
    $(thisOtherSector).append(
            '<select name="' + nme + '" id="companySector" class="form-control companySector" title="<?= trans("front.job company sector") ?>" required>' +
            '<option value=""><?= trans("front.job company sector") ?></option>' +
            '<option value="Real Estate"><?= trans("front.job Real Estate") ?></option>' +
            '<option value="Digital Marketing"><?= trans("front.job Digital Marketing") ?></option>' +
            '<option value="Management Consulting"><?= trans("front.job Management Consulting") ?></option>' +
            '<option value="Education"><?= trans("front.job Education") ?></option>' +
            '<option value="Tourism"><?= trans("front.job Tourism") ?></option>' +
            '<option value="General Trade"><?= trans("front.job General Trade") ?></option>' +
            '<option value="Electrical and Electronics"><?= trans("front.job Electrical and Electronics") ?></option>' +
            '<option value="Medical and Pharmacy"><?= trans("front.job Medicine and Pharmacology") ?></option>' +
            '<option value="Furniture and Decoration"><?= trans("front.job Furniture and Decoration") ?></option>' +
            '<option value="Food and Agriculture"><?= trans("front.job Food and Agriculture") ?></option>' +
            '<option value="IT Hardware"><?= trans("front.job IT Hardware") ?></option>' +
            '<option value="Financial or Investment"><?= trans("front.job Financial or Investment") ?></option>' +
            '<option value="Manufacturing"><?= trans("front.job Manufacturing") ?></option>' +
            '<option value="Other"><?= trans("front.job Language Other") ?></option>' +
            '</select>'
            );
});





$(document).on('change', 'select.langName_select', function () {
    var langName = this.value;
    if (langName == "Other") {
        $(this).remove();
        $(".other_lang").append(
                '<div class="input_other_lang">' +
                '<span class="delete_input">x</span>' +
                '<input type="text" id="inputOtherLang" name="langName[2]" class="form-control" placeholder="' + LanguageNameTitle + '" required/>' +
                '</div>'
                );
        $("#inputOtherLang").focus();
    }
});


$(document).on('click', '.delete_input', function () {
    $(".other_lang").empty();
    $(".other_lang").append(
            '<select name="langName[2]" id="langName3" class="form-control langName_select" required>' +
            '<option value="">' + ChoseLanguageTitle + '</option>' +
            '<option value="French">' + FrancaisTitle + '</option>' +
            '<option value="Persian">' + PersianTitle + '</option>' +
            '<option value="Urdu">' + UrduTitle + '</option>' +
            '<option value="Russian">' + RussianTitle + '</option>' +
            '<option value="Arabic">' + ArabicTitle + '</option>' +
            '<option value="Other">' + OtherTitle + '</option>' +
            '</select>'
            );
});



$(document).on('change', 'select.hasCertificat', function () {
    var langName = this.value;
    var thisAlert = $(this).parents(".form-group").find(".hasCertificat_alert");
    if (langName == "yes") {
        $(thisAlert).fadeIn();
        $(thisAlert).text(ProficiencyAlertTitle);
    } else {
        $(thisAlert).fadeOut();
        $(thisAlert).text("");
    }


});


$(document).on('change', 'select.hasCertificat', function () {
    var langName = this.value;
    var thisAlert = $(this).parents(".form-group").find(".hasCertificat_alert");
    if (langName == "yes") {
        $(thisAlert).fadeIn();
        $(thisAlert).text(ProficiencyAlertTitle);
    } else {
        $(thisAlert).fadeOut();
        $(thisAlert).text("");
    }


});



$(document).on('change', 'select.durationWorkFrom_m', function () {
    var fromMonth = this.value;
    var fromYear = $(this).parents(".sector_company_sec").find(".durationWorkFrom_y").val();
    var toMonth = $(this).parents(".sector_company_sec").find(".durationWorkTo_m").val();
    var toYear = $(this).parents(".sector_company_sec").find(".durationWorkTo_y").val();
    var toMonthSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_m");
    var toYearSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_y");
    var thisAlart = $(this).parents(".sector_company_sec").find(".date_alert_message");

    if (toYear != "") {
        if (toYear > fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
        } else if (toYear == fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
            if (toMonth <= fromMonth) {
                $(toMonthSelect).val("");
                $(toMonthSelect).addClass("error");
                $(thisAlart).fadeIn();
                $(thisAlart).text("<?= trans("front.Please select a higher month") ?>");
            }
        } else {
            $(toYearSelect).val("");
            $(toYearSelect).addClass("error");
            $(thisAlart).fadeIn();
            $(thisAlart).text("<?= trans("front.Please select a higher year") ?>");
        }
    }
});

$(document).on('change', 'select.durationWorkFrom_y', function () {
    var fromYear = this.value;
    var fromMonth = $(this).parents(".sector_company_sec").find(".durationWorkFrom_m").val();
    var toMonth = $(this).parents(".sector_company_sec").find(".durationWorkTo_m").val();
    var toYear = $(this).parents(".sector_company_sec").find(".durationWorkTo_y").val();
    var toMonthSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_m");
    var toYearSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_y");
    var thisAlart = $(this).parents(".sector_company_sec").find(".date_alert_message");

    if (toYear != "") {
        if (toYear > fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
        } else if (toYear == fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
            if (toMonth <= fromMonth) {
                $(toMonthSelect).val("");
                $(toMonthSelect).addClass("error");
                $(thisAlart).fadeIn();
                $(thisAlart).text("<?= trans("front.Please select a higher month") ?>");
            }
        } else {
            $(toYearSelect).val("");
            $(toYearSelect).addClass("error");
            $(thisAlart).fadeIn();
            $(thisAlart).text("<?= trans("front.Please select a higher year") ?>");
        }
    }
});

$(document).on('change', 'select.durationWorkTo_m', function () {
    var toMonth = this.value;
    var fromMonth = $(this).parents(".sector_company_sec").find(".durationWorkFrom_m").val();
    var fromYear = $(this).parents(".sector_company_sec").find(".durationWorkFrom_y").val();
    var toYear = $(this).parents(".sector_company_sec").find(".durationWorkTo_y").val();
    var toMonthSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_m");
    var toYearSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_y");
    var thisAlart = $(this).parents(".sector_company_sec").find(".date_alert_message");

    if (toYear != "") {
        if (toYear > fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
        } else if (toYear == fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
            if (toMonth <= fromMonth) {
                $(toMonthSelect).val("");
                $(toMonthSelect).addClass("error");
                $(thisAlart).fadeIn();
                $(thisAlart).text("<?= trans("front.Please select a higher month") ?>");
            }
        } else {
            $(toYearSelect).val("");
            $(toYearSelect).addClass("error");
            $(thisAlart).fadeIn();
            $(thisAlart).text("<?= trans("front.Please select a higher year") ?>");
        }
    }
});

$(document).on('change', 'select.durationWorkTo_y', function () {
    var toYear = this.value;
    var fromMonth = $(this).parents(".sector_company_sec").find(".durationWorkFrom_m").val();
    var fromYear = $(this).parents(".sector_company_sec").find(".durationWorkFrom_y").val();
    var toMonth = $(this).parents(".sector_company_sec").find(".durationWorkTo_m").val();
    var toMonthSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_m");
    var toYearSelect = $(this).parents(".sector_company_sec").find(".durationWorkTo_y");
    var thisAlart = $(this).parents(".sector_company_sec").find(".date_alert_message");

    if (toYear != "") {
        if (toYear > fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
        } else if (toYear == fromYear) {
            $(thisAlart).fadeOut();
            $(toYearSelect).removeClass("error");
            if (toMonth <= fromMonth) {
                $(toMonthSelect).val("");
                $(toMonthSelect).addClass("error");
                $(thisAlart).fadeIn();
                $(thisAlart).text("<?= trans("front.Please select a higher month") ?>");
            }
        } else {
            $(toYearSelect).val("");
            $(toYearSelect).addClass("error");
            $(thisAlart).fadeIn();
            $(thisAlart).text("<?= trans("front.Please select a higher year") ?>");
        }
    }
});





$(document).on('keypress', 'input[name=h_mobile]', function () {
    check_mob_field();
});
$(document).on('blur', 'input[name=h_mobile]', function () {
    check_mob_field();
});

function check_mob_field() {

    var mob = $('input[name=h_mobile]').val();
    if (mob.length > 2) {
        if (mob[0] == '+' || (mob[0] == '0' && mob[1] == '0')) {

        } else {
            $('#mobile-smn-error').show();
            $('#mobile-smn-error').html('من فضلك حدد الرمز الدولي');
            $('input[name=h_mobile]').addClass('error');
            return false;
        }
    }
    return true;
}


$(document).on('change', 'select#nationality', function () {
    var citizenshipName = this.value;
    if (citizenshipName == "Turkey") {
        $('select[name=h_identification]').prop('disabled', true);
        $('select[name=h_identification]').selectpicker('refresh');
    } else {
        $('select[name=h_identification]').prop('disabled', false);
        $('select[name=h_identification]').selectpicker('refresh');

    }
});


/*
 $('#form-vac').ajaxForm({
 beforeSubmit: function () {
 var btn = $('#form-vac').find("button[type=submit]");
 btn.html("<i class='fa fa-spinner fa-spin' style='color:#fff'></i>");
 btn.attr("disabled", true);
 
 }, // pre-submit callback 
 success: function (resp) {
 if (resp.input) {
 var btn = $('#form-vac').find("button[type=submit]");
 btn.html('<p> JOIN US </p>');
 btn.removeAttr("disabled");
 alert(resp.message);
 } else {
 alert('Thank you! The message was sent successfully!');
 window.location.href = 'https://damas.net';
 }
 },
 error: function () {
 alert('error');
 var btn = $('#form-vac').find("button[type=submit]");
 btn.html(' <p> JOIN US </p> ');
 btn.removeAttr("disabled");
 }
 
 
 });*/


$("#ws2 .next").click(function () {
    $('html, body').animate({
        scrollTop: $("#ws3").offset().top - 90
    }, 1000);
});
$("#ws3 .next").click(function () {
    $('html, body').animate({
        scrollTop: $("#ws4").offset().top - 90
    }, 1000);
});
$("#ws4 .next").click(function () {
    $('html, body').animate({
        scrollTop: $("#ws5").offset().top - 130
    }, 1000);
});



<?php /* for ($i = 0; $i < 10; $i++) { ?>
  $('.fiiext<?= $i ?> input').change(function (e) {
  $(".fiiext<?= $i ?>").children('p').html(e.target.files[0].name.replace("C:\\fakepath\\", ""));
  });
  <?php } */ ?>




var nextBtn = "<?= trans("front.nextBtn") ?>";
var previousBtn = "<?= trans("front.previousBtn") ?>";
var sendBtn = "<?= trans("front.sendBtn") ?>";
var RequiredAlert = "<?= trans("front.Join Some Fields are Required") ?>";


jQuery.validator.addMethod(
        "lettersonly2",
        function (value, element) {
            return this.optional(element) || /[^0-9~`!@#$%\^&\*\(\)\-+=\\\|\}\]\{\['&quot;:?.>,</]+/i.test(value);
        },
        "<?= trans("front.Please write letters only") ?>"
        );


var form = $("#contact");
form.validate({
    errorPlacement: function errorPlacement(error, element) {
        element.before(error);
    },
    lang: 'ar',
    rules: {
        h_profile_image: {
            required: true
        },
        h_name: {
            required: true,
            minlength: 3,
            maxlength: 25,
            lettersonly2: true
        },
        h_city: {
            required: true
        },
        h_district: {
            required: true,
            lettersonly2: true
        },
        "companyName[0]": {
            required: true,
            minlength: 3,
            maxlength: 30,
            lettersonly2: true
        },
        "companyName[1]": {
            required: true,
            minlength: 3,
            maxlength: 30,
            lettersonly2: true
        },
        "experience[]": {
            required: true,
            minlength: 3,
            maxlength: 22,
            lettersonly2: true
        },
        "specialization[]": {
            required: true,
            minlength: 3,
            maxlength: 25,
            lettersonly2: true
        },
        h_message: {
            required: true,
            minlength: 10,
            maxlength: 300
        },
        h_salary: {
            required: true,
            integer: true
        },
        h_commission: {
            required: true
        },
        h_number_sales: {
            required: true
        },
        "certificateDegree[]": {
            required: true,
            integer: true,
            range: [50, 100]
        },
        h_email: {
            required: true,
            minlength: 3,
            maxlength: 20,
            nowhitespace: true
        }
    },

    messages: {
        h_profile_image: "<?= trans("front.Please upload a profile picture") ?>",
        h_position: "<?= trans("front.This field is mandatory") ?>",
        h_citizenship: "<?= trans("front.This field is mandatory") ?>",
        h_marriage: "<?= trans("front.This field is mandatory") ?>",
        h_license: "<?= trans("front.This field is mandatory") ?>",
        /*h_source_txt: "هذا الحقل إلزامي",*/
        h_city: "<?= trans("front.This field is mandatory") ?>",
        h_district: "<?= trans("front.This field is mandatory") ?>",
        /*'certificateDegree[]': "<?= trans("front.This field is mandatory") ?>",*/
        /*'certificateDate[]': "<?= trans("front.This field is mandatory") ?>",*/
        /*'specialization[]': "<?= trans("front.This field is mandatory") ?>",*/
    },
});





var formHasChanged = false;

$(document).ready(function () {
    $('.form-control').change(function () {
        formHasChanged = true;
    });

    window.onbeforeunload = function (e) {
        if (formHasChanged) {
            var message = "You have not saved your changes.", e = e || window.event;
            if (e) {
                e.returnValue = message;
            }
            return message;
        }
    }
});
form.children("div").steps({
    labels: {
        current: "current step:",
        pagination: "Pagination",
        finish: sendBtn,
        next: nextBtn,
        previous: previousBtn,
        loading: "جاري التحميل ..."
    },
    headerTag: ".headerTag",
    bodyTag: ".step_content",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {



        form.validate().settings.ignore = ":disabled,:hidden";
        $(".actions.clearfix").append(
                '<p class="validat_page_alert">' + RequiredAlert + '</p>'
                );

        setTimeout(function () {
            $(".validat_page_alert").remove();
        }, 1500);


        if (form.valid() == false) {
            return false;
        }
        if (check_mob_field() == false) {
            return false;
        }

        return form.valid();

    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        $(".actions.clearfix").append(
                '<p class="validat_page_alert">' + RequiredAlert + '</p>'
                );

        setTimeout(function () {
            $(".validat_page_alert").remove();
        }, 1500);
        return form.valid();

    },
    onFinished: function (event, currentIndex)
    {

        $(".validat_page_alert").remove();
        $('.overlay').show();

        $('input[name="certificateDate[]"]').removeAttr("disabled");
        $('input[name="certificateDegree[]"]').removeAttr("disabled");

        $.ajax({
            type: "post",
            data: $('#contact').serializeArray(),
            url: "<?= route('front.callvac') ?>",
            success: function (data) {
                formHasChanged = false;
                $('.overlay').hide();
                window.location.href = "{{ route('front.submitted_job') }}?job_code=" + data.job_code;

            },
            error: function (response) {
                alert('The operation failed..., Please reload the page and try again');
            }
        });


    }
});






$(document).on('click', 'input.date', function () {
    var date = new Date();
    date.setFullYear(date.getFullYear() - 10);
    date.setMonth(0);
    date.setDate(1);
    $(this).datepicker({
        autoclose: true,
        todayHighlight: true,
        minViewMode: 2,
        format: 'yyyy',
        endDate: new Date()
    }).focus().datepicker("setDate", date);
    $(this).removeClass('datepicker');
});


$(document).on('click', 'input#age', function () {
    var date = new Date();
    date.setFullYear(date.getFullYear() - 10);
    date.setMonth(0);
    date.setDate(1);
    $(this).datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        endDate: new Date()
    }).focus().datepicker("setDate", date);
    $(this).removeClass('datepicker');
});


$(document).on('click', 'input#dateEntryTurkey', function () {
    var date = new Date();
    date.setFullYear(date.getFullYear() - 10);
    date.setMonth(0);
    date.setDate(1);
    $(this).datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        endDate: new Date()
    }).focus().datepicker("setDate", date);
    $(this).removeClass('datepicker');
});


$(document).on('click', 'input.durationWork', function () {
    var date = new Date();
    date.setFullYear(date.getFullYear() - 10);
    date.setMonth(0);
    date.setDate(1);
    $(this).datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        endDate: new Date()
    }).focus().datepicker("setDate", date);
    $(this).removeClass('datepicker');
});

/*$('input.durationWork').datepicker({
 format: "mm-yyyy",
 startView: "months",
 minViewMode: "months"
 });*/


window.onload = function () {
    $('.selectpicker').selectpicker('refresh');

    $("#mobile-smn").intlTelInput({
        preferredCountries: ["tr", "sa", "qa", "sy", "iq", "kw", "bh", "ae", "ye", "jo", "dz", "ly", "eg", "sd", "om"]
    });
};






var counter = 1;

$(".show_less_btn").hide();
$(document).on("click", ".show_more_btn", function () {

    if (counter == 1) {
        var height_div = $('.content_section .cont').css({'max-height': 'initial'}).height();
        $('.content_section .cont').animate({'max-height': height_div}, 200);
        $('html, body').animate({
            scrollTop: $('.content_section').offset().top - 100
        }, 'slow');
        $(".show_more_btn").hide();
        $(".show_less_btn").show();
        $(".action_content").addClass("type_less");
        counter++;
        return true;

    } else {
        counter = 1;
        return false;
    }


});


$(document).on("click", ".show_less_btn", function () {
    $('.content_section .cont').animate({'max-height': '170px'}, 300);
    $('html, body').animate({
        scrollTop: $('.content_section').offset().top - 100
    }, 'slow');
    counter = 1;
    $(".action_content").removeClass("type_less");
    setTimeout(function () {
        $(".show_less_btn").hide();
        $(".show_more_btn").show();
    }, 300);
});



function changeTheText(string) {
    string = string.toLowerCase();
    return string.charAt(0).toUpperCase() + string.slice(1);
}

jQuery('input.form-control').on('focusout', function () {
    jQuery(this).val(changeTheText(jQuery(this).val()));
});

jQuery('#message').on('focusout', function () {
    jQuery(this).val(changeTheText(jQuery(this).val()));
});



</script>

@endsection
@section('schemaorg')
<script type="application/ld+json">
    {
    "@context":"http://schema.org",
    "@type":"BreadcrumbList",
    "itemListElement":[

    {"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
    {"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
    {"@type":"ListItem","position":3,"name":"{{ trans('front.turkey jobs') }}","item":"{{ route('front.land_vacancies') }}"}


    ]
    }
</script>
@endsection