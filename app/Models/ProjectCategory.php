<?php
namespace App\Models;

class ProjectCategory extends BaseModel
{
    public $table = "projects_categories";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fa",
        "slug",
        "about_title_ar",
        "about_title_en",
        "about_title_fa",
        "about_ar",
        "about_en",
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
        "icon",
		"hide_search_page",
		"post_id",
		"placement",
        "about_fr",
        "about_title_fr",
        "name_fr",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
		
        "about_ru",
        "about_title_ru",
        "name_ru",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
        "svg",
    ];
	public function getPost()
    {
		return $this->belongsTo("App\Models\Post", "post_id");
    }
    
    public function projects()
    {
        return $this->belongsToMany("App\Models\Project", "project_category");
    }
    
}
