@extends('admin.layouts.form', ["app_title" => "Jobs", "app_desc" => "Job Information"])
@section('main_form')

<ul class="nav nav-tabs">
    <li class="active"><a href="#tab1default" data-toggle="tab">Arabic Section</a></li>
    <li><a href="#tab2default" data-toggle="tab">English Section</a></li>
</ul>



<div class="panel-body">
    <div class="tab-content">

        <!-- Section Arabic -->
        <div class="tab-pane fade in active" id="tab1default">
            <div class="form-group col-md-4">
                <label>Slug <span class="red">(*)</span></label>
                <div class="input-group ltr">
                    <span class="input-group-addon">/</span>
                    <?= Form::text("slug", $row->slug, ["class" => "form-control"]); ?>
                </div>
            </div>
            <div class="form-group col-md-4">
                <label>Share Image (Arabic)</label>
                @include('admin.layouts.media_input', [
                "name"	=>	"media_id",
                "ids"   =>	[$row->media_id]
                ])
            </div>
            <div class="form-group col-md-12 ">
                <label>Title Arabic</label>
                <?= Form::text("title_ar", $row->title_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-12 ">
                <label>About Arabic</label>
                <?= Form::textarea("about_ar", $row->about_ar, ["class" => "form-control tinyeditor"]); ?>
            </div>

            <div class="form-group col-md-6 ">
                <label>Position</label>
                <select name="position" id="job" class="form-control selectpicker job changedfield" title="Chose Position" data-live-search="true"  required="" tabindex="-98">
					<option value=""></option>
					<?php
					/*$arr_jobs = array(
					"Telesales Manager"=>"",
					"Arabic Telesales"=>"",
					"English Telesales"=>"",
					"French Telesales"=>"",
					"Persian Telesales"=>"",
					"Russian Telesales"=>"",
					"Sales Manager"=>"",
					"Salesman"=>"",
					"Portfolio Manager"=>"",
					"After Sales"=>"",
					
					"Marketing Manager"=>"",
					"Media Manager"=>"",

					"Backend Developer"=>"",
					"Frontend Developer"=>"",
					"SEO Specialist"=>"",
					"Ads Specialist"=>"",
					"Graphic Designer"=>"",
					"Photographer"=>"",
					"Monteur"=>"",
					"Social Media Specialist"=>"",
					"Content Writer"=>"",


					"IT Hardware"=>"",
					"Video Presenter"=>"",
					"HR Manager"=>"",
					"Quality Assurance Supervisor"=>"",
					"Personnel Supervisor"=>"",
					"Lawyer"=>"",
					"Legal Affairs Officer"=>"",
					"Accountant"=>"",
					"Construction Engineer"=>"",
					"Administrative"=>"",
					"Trainee"=>"",
					"Secretary"=>"",
					"Cars Coordinator"=>"",
					"CEO"=>"",
					"Social Media Manager"=>""
					
					);*/
					
					$arr_jobs = \App\Models\HrJobs::where("published",true)->orderBy('id','asc')->get();
					foreach($arr_jobs as $r){ ?>
					<option value="<?= $r->job_title_en ?>" <?= $r->job_title_en==$row->position?'selected':'' ?>><?= $r->job_title_en ?></option>
					<?php } ?>
				</select>
				<?php /*foreach($arr_jobs as $k=>$v){ ?>
				<input value="<?= $k ?>" type="text" name="options[]">
				<?php }*/ ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Applicant Location Requirements</label>
                <?= Form::text("applicantLocationRequirements", $row->applicantLocationRequirements, ["class" => "form-control","placeholder" => "TR"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Base Salary</label>
                <?= Form::text("baseSalary", $row->baseSalary, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Education Requirements</label>
				<?= Form::text("educationRequirements_ar", $row->educationRequirements_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Eligibility To Work Requirement</label>
				<?= Form::text("eligibilityToWorkRequirement_ar", $row->eligibilityToWorkRequirement_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Employer Overview</label>
                <textarea class="form-control" name="employerOverview_ar"><?= $row->employerOverview_ar ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Employment Type</label>
				<?= Form::text("employmentType_ar", $row->employmentType_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Estimated Salary</label>
                <?= Form::text("estimatedSalary", $row->estimatedSalary, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Experience In Place Of Education</label>
                <select class="form-control" name="experienceInPlaceOfEducation">
					<option value="true" <?= $row->experienceInPlaceOfEducation=='true'?'selected':'' ?>>True</option>
					<option value="false" <?= $row->experienceInPlaceOfEducation=='false'?'selected':'' ?> >False</option>
				</select>
            </div>
			
            <div class="form-group col-md-6 ">
                <label>Experience Requirements</label>
				<?= Form::text("experienceRequirements_ar", $row->experienceRequirements_ar, ["class" => "form-control"]); ?>
            </div>
			
            <div class="form-group col-md-6 ">
                <label>Incentive Compensation</label>
                <textarea class="form-control" name="incentiveCompensation_ar"><?= $row->incentiveCompensation_ar ?></textarea>
            </div>
			
            <div class="form-group col-md-6 ">
                <label>job Benefits</label>
				<?= Form::text("jobBenefits_ar", $row->jobBenefits_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Industry</label>
                <?= Form::text("industry_ar", $row->industry_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Job Immediate Start</label>
				<select class="form-control" name="jobImmediateStart">
					<option value="true" <?= $row->jobImmediateStart=='true'?'selected':'' ?>>True</option>
					<option value="false" <?= $row->jobImmediateStart=='false'?'selected':'' ?> >False</option>
				</select>
            </div>
			<hr>
			<h4>Job Location</h4>
            <div class="form-group col-md-6 ">
                <label>streetAddress</label>
                <?= Form::text("streetAddress", $row->streetAddress, ["class" => "form-control", "placeholder"=>"1600 Amphitheatre Pkwy"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>addressLocality</label>
                <?= Form::text("addressLocality", $row->addressLocality, ["class" => "form-control", "placeholder"=>"Mountain View"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>addressRegion</label>
                <?= Form::text("addressRegion", $row->addressRegion, ["class" => "form-control", "placeholder"=>"CA"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>postalCode</label>
                <?= Form::text("postalCode", $row->postalCode, ["class" => "form-control", "placeholder"=>"94043"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>addressCountry</label>
                <?= Form::text("addressCountry", $row->addressCountry, ["class" => "form-control", "placeholder"=>"TR"]); ?>
            </div>
			
			
			
			
            <div class="form-group col-md-6 ">
                <label>Job Start Date</label>
                <?= Form::text("jobStartDate", $row->jobStartDate, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Occupational Category</label>
				<?= Form::text("occupationalCategory_ar", $row->occupationalCategory_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Physical Requirement</label>
				<?= Form::text("physicalRequirement_ar", $row->physicalRequirement_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Qualifications</label>
                <textarea class="form-control" name="qualifications_ar"><?= $row->qualifications_ar ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Responsibilities</label>
                <textarea class="form-control" name="responsibilities_ar"><?= $row->responsibilities_ar ?></textarea>
            </div>
			
            <div class="form-group col-md-6 ">
                <label>Salary Currency</label>
                <?= Form::text("salaryCurrency", $row->salaryCurrency, ["class" => "form-control","placeholder"=>"USD"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Security Clearance Requirement</label>
                <?= Form::text("securityClearanceRequirement_ar", $row->securityClearanceRequirement_ar, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Sensory Requirement</label>
                <textarea class="form-control" name="sensoryRequirement_ar"><?= $row->sensoryRequirement_ar ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Skills</label>
                <textarea class="form-control" name="skills_ar"><?= $row->skills_ar ?></textarea>
            </div>
            <div class="form-group col-md-12 ">
                <label>Special Commitments</label>
                <textarea class="form-control" name="specialCommitments_ar"><?= $row->specialCommitments_ar ?></textarea>
            </div>
            <div class="form-group col-md-4 ">
                <label>Total Job Openings</label>
                <?= Form::text("totalJobOpenings", $row->totalJobOpenings, ["class" => "form-control","placeholder"=>6]); ?>
            </div>
            <div class="form-group col-md-4 ">
                <label>Valid Through</label>
                <?= Form::text("validThrough", $row->validThrough, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-4 ">
                <label>Work Hours</label>
                <?= Form::text("workHours_ar", $row->workHours_ar, ["class" => "form-control","placeholder"=>"40 hours per week"]); ?>
            </div>



        </div>




        <!-- Section English -->
        <div class="tab-pane fade" id="tab2default">
            <div class="form-group col-md-4">
                <label>Share Image(English)</label>
                @include('admin.layouts.media_input', [
                "name"	=>	"media_en_id",
                "ids"   =>	[$row->media_en_id]
                ])
            </div>
            <div class="form-group col-md-12 ">
                <label>Title English</label>
                <?= Form::text("title_en", $row->title_en, ["class" => "form-control ltr"]); ?>
            </div>
            <div class="form-group col-md-12 ">
                <label>About English</label>
                <?= Form::textarea("about_en", $row->about_en, ["class" => "form-control tinyeditor"]); ?>
            </div>

            <div class="form-group col-md-6 ">
                <label>Education Requirements</label>
                <?= Form::text("educationRequirements_en", $row->educationRequirements_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Eligibility To Work Requirement</label>
                <textarea class="form-control" name="eligibilityToWorkRequirement_en"><?= $row->eligibilityToWorkRequirement_en ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Employer Overview</label>
                <textarea class="form-control" name="employerOverview_en"><?= $row->employerOverview_en ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Employment Type</label>
                <?= Form::text("employmentType_en", $row->employmentType_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Experience Requirements</label>
				<?= Form::text("experienceRequirements_en", $row->experienceRequirements_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Incentive Compensation</label>
                <textarea class="form-control" name="incentiveCompensation_en"><?= $row->incentiveCompensation_en ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>job Benefits</label>
				<?= Form::text("jobBenefits_en", $row->jobBenefits_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Industry</label>
                <?= Form::text("industry_en", $row->industry_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Occupational Category</label>
				<?= Form::text("occupationalCategory_en", $row->occupationalCategory_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Physical Requirement</label>
				<?= Form::text("physicalRequirement_en", $row->physicalRequirement_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Qualifications</label>
                <textarea class="form-control" name="qualifications_en"><?= $row->qualifications_en ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Responsibilities</label>
                <textarea class="form-control" name="responsibilities_en"><?= $row->responsibilities_en ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Security Clearance Requirement</label>
                <?= Form::text("securityClearanceRequirement_en", $row->securityClearanceRequirement_en, ["class" => "form-control"]); ?>
            </div>
            <div class="form-group col-md-6 ">
                <label>Sensory Requirement</label>
                <textarea class="form-control" name="sensoryRequirement_en"><?= $row->sensoryRequirement_en ?></textarea>
            </div>
            <div class="form-group col-md-6 ">
                <label>Skills</label>
                <textarea class="form-control" name="skills_en"><?= $row->skills_en ?></textarea>
            </div>
            <div class="form-group col-md-12 ">
                <label>Special Commitments</label>
                <textarea class="form-control" name="specialCommitments_en"><?= $row->specialCommitments_en ?></textarea>
            </div>
            <div class="form-group col-md-4 ">
                <label>Work Hours</label>
                <?= Form::text("workHours_en", $row->workHours_en, ["class" => "form-control","placeholder"=>"40 hours per week"]); ?>
            </div>

        </div>


    </div>
</div>

<!--<fieldset>
    <legend>Job Information</legend>



</fieldset>

<fieldset>





</fieldset>-->


@include('admin.layouts.seo')


@include("admin.layouts.tinymce_js")
@include("admin.layouts.media_input_js")

@endsection