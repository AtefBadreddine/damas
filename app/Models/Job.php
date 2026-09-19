<?php
namespace App\Models;
use LaravelLocalization;
class Job extends BaseModel
{
    public $table = "jobs";
    
    protected $fillable = [
        "slug",
        "title_ar",
        "title_en",
        "about_ar",
        "about_en",
        "media_id",
        "media_en_id",

        "position",
        "applicantLocationRequirements",
        "baseSalary",
        "estimatedSalary",
        "jobImmediateStart",
        "streetAddress",
        "addressLocality",
        "addressRegion",
        "postalCode",
        "addressCountry",
        "jobStartDate",
        "salaryCurrency",
        "totalJobOpenings",
        "validThrough",


        "educationRequirements_ar",
        "eligibilityToWorkRequirement_ar",
        "employerOverview_ar",
        "employmentType_ar",
        "experienceInPlaceOfEducation",
        "experienceRequirements_ar",
        "incentiveCompensation_ar",
        "jobBenefits_ar",
        "industry_ar",
        "occupationalCategory_ar",
        "physicalRequirement_ar",
        "qualifications_ar",
        "responsibilities_ar",
        "securityClearanceRequirement_ar",
        "sensoryRequirement_ar",
        "skills_ar",
        "specialCommitments_ar",
        "workHours_ar",


        "educationRequirements_en",
        "eligibilityToWorkRequirement_en",
        "employerOverview_en",
        "employmentType_en",
        "experienceInPlaceOfEducation",
        "experienceRequirements_en",
        "incentiveCompensation_en",
        "jobBenefits_en",
        "industry_en",
        "occupationalCategory_en",
        "physicalRequirement_en",
        "qualifications_en",
        "responsibilities_en",
        "securityClearanceRequirement_en",
        "sensoryRequirement_en",
        "skills_en",
        "specialCommitments_en",
        "workHours_en",

        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",

        "placement",

    ];
    
    /**
    * media
    *
    * @return void
    */
    public function media()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if($lang=='ar')
			return $this->belongsTo("App\Models\Media", "media_id");
		else
			return $this->belongsTo("App\Models\Media", "media_".$lang."_id");
    }
    public function media_index()
    {
        return $this->belongsTo("App\Models\Media", "media_index");
    }
    public function mediaAr()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    public function mediaEn()
    {
        return $this->belongsTo("App\Models\Media", "media_en_id");
    }
    
	
	
}