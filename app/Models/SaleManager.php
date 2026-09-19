<?php
namespace App\Models;
use LaravelLocalization;

class SaleManager extends BaseModel
{
    public $table = "sales_managers";
    
    protected $fillable = [
        "slug",
        "name_ar",
        "name_en",
        "email",
        "phone",
        "skype",
        "career",
        "media_id",
		"career_en",
		"career_fa",
		"about_agent_title",
		"about_agent_desc",
		"about_agent_title_en",
		"about_agent_desc_en",
		"about_agent_title_fa",
		"about_agent_desc_fa",
		"avantages_title",
		"avantages_desc",
		"avantages_title_en",
		"avantages_desc_en",
		"avantages_title_fa",
		"avantages_desc_fa",
		"avantages_regions",
		"avantages_regions_en",
		"avantages_regions_fa",
		"region_id",
		"seo_title_ar",
		"seo_description_ar",
		"seo_title_en",
		"seo_description_en",
		"seo_title_fa",
		"seo_description_fa",		
		"facebook","twitter","linkedin","instagram","youtube",
		
		"seo_title_fr",
		"seo_description_fr",	
		"avantages_regions_fr",
		"avantages_title_fr",
		"avantages_desc_fr",
		"career_fr",
		"about_agent_title_fr",
		"about_agent_desc_fr",
		
		"seo_title_ru",
		"seo_description_ru",	
		"avantages_regions_ru",
		"avantages_title_ru",
		"avantages_desc_ru",
		"career_ru",
		"about_agent_title_ru",
		"about_agent_desc_ru",
    ];
    
    public function reviews()
    {
        return $this->hasMany("App\Models\SaleManagerReview");
    }
    public function photo()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    public function region()
    {
        return $this->belongsTo("App\Models\Region", "region_id");
    }
	public function getF($field)
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        //$field = 'career';
		if($lang=='en' or $lang=='ru' or $lang=='fr' or $lang=='fa')
			$field = $field.'_'.$lang;
		
		return $this->$field;
    }

}