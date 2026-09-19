<?php
namespace App\Models;

class ProjectType extends BaseModel
{
    public $table = "projects_types";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fa",
        "city_id",
        "slug",
        "title_ar",
        "title_en",
        "title_fa",
        "about_title_ar",
        "about_ar",
        "about_title_en",
        "about_en",
        "about_title_fa",
        "about_fa",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fa",
        "seo_description_fa",
        "seo_keywords_fa",
        "placement",
        "pattern",
		
        "name_fr",
        "title_fr",
        "about_title_fr",
        "about_fr",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
		
        "name_ru",
        "title_ru",
        "about_title_ru",
        "about_ru",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
		
		"post_id",
    ];
	public function getPost()
    {
		return $this->belongsTo("App\Models\Post", "post_id");
    }
}