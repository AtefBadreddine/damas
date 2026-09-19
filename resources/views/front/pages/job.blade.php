<?php
$current_lang = LaravelLocalization::getCurrentLocale();
$style_lang = in_array($current_lang, ['en', 'fr', 'ru']) ? 'en' : 'ar';
?>
@section('styles')
<?php
$infos = Helper::get_params();


$is_mobile = Helper::get_device() != 'full' ? true : false;

$right = ($style_lang == 'ar' ? 'right' : 'left');
?>


<style>
    .content_section{
        width: 100%;
        text-align: right;
        direction: rtl;
    }
</style>


<?php if (App::isLocal()) { ?>
    <?= Html::style("resources/assets/css/job.css"); ?>
    <?php if ($current_lang == 'en' || $current_lang == 'fr' || $current_lang == 'ru') { ?>
        <?= Html::style("resources/assets/css/job-en.css"); ?>
    <?php } ?>


<?php } else { ?>

    <?= Html::style("css/job.min.css"); ?>

<?php } ?>


@endsection





@extends('front.layout', [
"page_title"        =>    $job->getSeoTitle(),
"page_description"  =>    $job->getSeoDescription(),
"page_keywords"     =>    $job->getSeoKeywords(),
"og_image"          =>    ($job->media?Helper::media_url_full($job->media):null),
/*"amp_url"           =>    route("amp.front.faq")*/
])


@section('main_content')



<div class="col-md-10 offset-md-1">
    <div class="full_sections int_job int_page">


        <!-- Start Left Section -->
        <div class="left_sec">

            <div class="top_control_sec">

                <header>
                    <h1 class="jazzira_font_bold">{{ $job->getTitle() }}</h1>

                    <ul class="job_details_list">
                        <li>
                            <i class="fa fa-calendar"></i>
                            <span class="num"><?= date_format(new DateTime($job->created_at), "d/m/Y"); ?></span>
                        </li>
                        <li>
                            <i class="fa fa-flag"></i>
                            <span class="num">Istanbul - TR</span>
                        </li>
                        <li>
                            <i class="fa fa-money"></i>
                            <span class="num">{{ $job->estimatedSalary }} {{ $job->salaryCurrency }}</span>
                        </li>
                        <li class="full">
                            <i class="fa fa-calendar"></i>
                            <span><p><?= trans("front.Application deadline"); ?></p>  <b class="num">{{ $job->validThrough }}</b></span>
                        </li>
                    </ul>
                </header>



            </div>


            <div class="int_content">
                <div class="content_section">
                    <?= $job->getAbout() ?>
                </div>

                <div class="sec">
                    <a href="{{ route('front.land_vacancies') }}?p=<?= $job->position ?>#job-application" class="apply_job"><span><?= trans("front.Apply btn"); ?></span><i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                </div>

            </div>





<?php if(count($jobs)>1){ ?>
            <div class="jobs_list sec">

                <h2 class="sub_title int jazzira_font_bold"><?= trans("front.Latest jobs in Turkey at damasturk") ?></h2>

                <?php
				/*	
$arr_jobs = array(
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
 
 
					foreach($jobs as $j){
						if($j->slug!=$job->slug){
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
                                    <span class="num">Istanbul - TR</span>
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
					<?php }} ?>

            </div>
<?php } ?>




        </div>
        <!-- End Left Section -->


        <!-- Start Fixed Section -->
        <!--        <div class="right_sec">
        
                                <a class="close_filter_btn">
                                    <svg version="1.1" id="Layer_1"  x="0px" y="0px" viewBox="0 0 211.4 218.9" xml:space="preserve"><g> <path class="st0" d="M628.8-7.9c31.7,0,63.3,0,95,0c6.1,0,10.8,2.3,13.6,7.6c2.6,4.9,2.5,10.2-1,14.6c-1.9,2.3-4.9,3.8-7.4,5.6 c-2.5,1.7-5.6,2.8-7.5,5c-22,26.7-43.9,53.6-65.7,80.6c-1.7,2.1-2.8,5.3-2.8,8c-0.2,28.3-0.2,56.5,0,84.8c0,4.6-1.6,7.4-5.4,9.7 c-11.5,7.1-22.7,14.6-34.2,21.6c-2.2,1.4-6.1,2.2-8.1,1.1c-1.9-1-3.4-4.8-3.4-7.4c-0.2-19.7,0-39.3,0-59c0-17.6,0-35.3-0.3-52.9 c0-2-0.9-4.3-2.1-5.8c-22.4-27.7-45-55.3-67.6-82.9c-1.1-1.3-2.7-2.4-4.3-3.2c-7-3.3-10.3-9.5-8.7-16.7c1.4-6.3,7.1-10.8,14.4-10.8 C565.2-7.9,597-7.9,628.8-7.9z M714.5,21c-58.3,0-115.7,0-173.4,0c0.3,0.8,0.4,1.1,0.6,1.3c21.2,26.1,42.5,52.2,63.9,78.2 c1.1,1.4,3.6,2.3,5.5,2.3c8.5,0.2,17.1-0.5,25.5,0.3c8.2,0.8,13.3-2.2,18.3-8.6C674.2,70,694.2,45.9,714.5,21z M609.7,110.9 c0,37.5,0,74.3,0,112c11.8-7.5,22.8-14.4,33.6-21.5c1.2-0.8,1.9-3,1.9-4.6c0.2-8.3,0.1-16.7,0.1-25c0.1-14.1,0.2-28.2,0.3-42.3 c0-6.1,0-12.2,0-18.6C633.2,110.9,621.6,110.9,609.7,110.9z M628.8-0.2c-30.7,0-61.3,0-92,0c-7.5,0-10.8,2.1-10.6,6.7 c0.1,4.4,3.4,6.4,10.6,6.4c61.3,0,122.6,0,183.9,0c2,0,4.5,0.4,5.8-0.6c2-1.5,4.6-4.3,4.4-6.2c-0.3-2.3-3.1-4.4-5.3-6.1 c-0.9-0.7-2.9-0.2-4.4-0.2C690.5-0.2,659.7-0.2,628.8-0.2z"/> </g> <path class="st0" d="M7.6,128.7L87.9,209c10.2,10.2,26.7,10.2,36.9,0c10.2-10.2,10.2-26.8,0-37l-31.3-31.4l86.3,0 c16.3,0,29.5-11.5,29.5-27.9c0-16.3-13.2-27.9-29.5-27.9l-90.9,0l35.9-37.5c10.2-10.2,10.2-27.5,0-37.7C114.7-0.5,98.1-0.9,87.9,9.3 L7.6,89.4C2.2,94.8-0.3,101.9,0,109C-0.3,116.1,2.2,123.2,7.6,128.7z"/> </svg>
                                </a>
                                <a id="outMenu" class="out_filter_btn"></a>
        
                    <div id="fixed_sec" class="fixed_sec">
        
        
        
        
                        <section class="form shadow_type form_sec">
                            @include("front.partials.call_us_fixed")
                        </section>
        
        
        
                    </div>
                </div>-->
        <!-- End Fixed Section -->





    </div>
</div>





@endsection



@section('scriptjs')
<?= Html::script("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"); ?>




<script>
    $(document).ready(function () {

        $(window).scroll(function () {
            var scrollingjob = 0;
            var scrollingjob2 = 0;
            ;
            var scroll = $(window).scrollTop();
            if (scroll >= scrollingjob) {
                $(".header").addClass("scrolling");
            } else {
                $(".header").removeClass("scrolling");
            }
            if (scroll >= scrollingjob2) {
                $(".fixed_sec").addClass("fixed");
            } else {
                $(".fixed_sec").removeClass("fixed");
            }
        });




        var startScroll = 150;
        var supportLinks = $(".support_links");
        var oldsctop = $(window).scrollTop();
        $(window).scroll(function () {

            /*console.log('old' + oldsctop + ' ----new: '+ $(this).scrollTop());*/
            if (($(this).scrollTop()) > oldsctop) {
                $(".top_control_sec").addClass("scrollMob");
            } else {
                $(".top_control_sec").removeClass("scrollMob");
            }
            oldsctop = $(this).scrollTop();
        });
    });


</script>


@endsection



@section('schemaorg')
<?php
function remove_backslash($str){
	$str = htmlentities($str);
	return str_replace('\\', '',$str);
}
$curent_lang = ($current_lang == 'pe' ? 'fa' : $current_lang);
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "JobPosting",
    "title": "<?= $job->getTitle() ?>",
    "description": "<?= htmlentities(strip_tags($job->getAbout())) ?>",
	"datePosted":"<?= date(DATE_ISO8601, strtotime($job->created_at)) ?>",




    "hiringOrganization" : {
        "@type": "Organization",
        "@id": "http://damas.net",
        "name": "DAMASTURK",
        "url": "http://damas.net"
    },
    "employmentUnit" : {
        "@type": "Organization",
        "name": "DAMASTURK",
        "parentOrganization" : {
            "@id": "http://damas.net"
        }
    },
	
	
	
	
	"experienceInPlaceOfEducation": "<?= remove_backslash($job->experienceInPlaceOfEducation) ?>",
      <?php
	  if(0<(int)$job->getLF("experienceRequirements")){ ?>
	  "experienceRequirements" : {
        "@type" : "OccupationalExperienceRequirements",
        "monthsOfExperience" : "<?= (int)$job->getLF("experienceRequirements") ?>"
      },
	  <?php } ?>
	"incentiveCompensation": "<?= remove_backslash($job->getLF('incentiveCompensation')) ?>", 
	
	"jobBenefits": "<?= remove_backslash($job->getLF('jobBenefits')) ?>",
	"industry": "<?= remove_backslash($job->getLF('industry')) ?>",
	"jobImmediateStart": "<?= remove_backslash($job->jobImmediateStart) ?>",
	"jobStartDate": "<?= remove_backslash($job->jobStartDate) ?>",
	"jobLocation": {
      "@type": "Place",
        "address": {
        "@type": "PostalAddress",
        "streetAddress": "<?= remove_backslash($job->streetAddress) ?>",
        "addressLocality": "<?= remove_backslash($job->addressLocality) ?>",
        "addressRegion": "<?= remove_backslash($job->addressRegion) ?>",
        "postalCode": "<?= remove_backslash($job->postalCode) ?>",
        "addressCountry": "<?= remove_backslash($job->addressCountry) ?>"
        }
    },
	"occupationalCategory": "<?= remove_backslash($job->getLF('occupationalCategory')) ?>",
	"physicalRequirement": "<?= remove_backslash($job->getLF('physicalRequirement')) ?>",
	"qualifications": "<?= remove_backslash($job->getLF('qualifications')) ?>",
	"responsibilities": "<?= remove_backslash($job->getLF('responsibilities')) ?>",
	"salaryCurrency": "<?= remove_backslash($job->salaryCurrency) ?>",
	"securityClearanceRequirement": "<?= remove_backslash($job->getLF('securityClearanceRequirement')) ?>",
	"sensoryRequirement": "<?= remove_backslash($job->getLF('sensoryRequirement')) ?>",
	"skills": "<?= remove_backslash($job->getLF('skills')) ?>",
	"specialCommitments": "<?= remove_backslash($job->getLF('specialCommitments')) ?>"
	,
      /*"educationRequirements" : {
        "@type" : "DefinedTerm",
        "name" : "<?= remove_backslash($job->getLF('educationRequirements')) ?>"
      },*/
	"eligibilityToWorkRequirement": "<?= remove_backslash($job->getLF('eligibilityToWorkRequirement')) ?>",
	"employerOverview": "<?= remove_backslash($job->getLF('employerOverview')) ?>",
	"employmentType": "<?= remove_backslash($job->getLF('employmentType')) ?>",
	"totalJobOpenings": "<?= remove_backslash($job->totalJobOpenings) ?>",
	"validThrough": "<?= remove_backslash($job->validThrough) ?>",
	"workHours": "<?= remove_backslash($job->getLF('workHours')) ?>", 
	
	"baseSalary": {
  "@type": "MonetaryAmount",
  "currency": "<?= $job->salaryCurrency ?>",
  "value": {
    "@type": "QuantitativeValue",
    "value": "<?= $job->baseSalary ?>",
    "unitText": "MONTH"
  }
},
	"estimatedSalary": "<?= htmlentities($job->estimatedSalary) ?>",
	
  "applicantLocationRequirements": {
    "@type": "Country",
    "name": "<?= htmlentities($job->applicantLocationRequirements) ?>"
  }
	
	
}
</script>
<script type="application/ld+json">
	{
	"@context":"http://schema.org",
	"@type":"BreadcrumbList",
	"itemListElement":[

	{"@type":"ListItem","position":1,"name":"{{ trans('front.home') }}","item":"{{ route('front.index') }}"},
	{"@type":"ListItem","position":2,"name":"{{ trans('front.turkey guide') }}","item":"{{ route('front.turkey_guide') }}"},
	{"@type":"ListItem","position":3,"name":"{{ trans('front.turkey jobs') }}","item":"{{ route('front.land_vacancies') }}"},
	{"@type":"ListItem","position":4,"name":"{{ $job->getTitle() }}","item":"{{ route('front.job_details',$job->slug) }}"}


	]
	}
</script>
@endsection