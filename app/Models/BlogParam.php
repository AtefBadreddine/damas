<?php
namespace App\Models;

class BlogParam extends BaseModel
{
    public $table = "blog_params";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fa",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fa",
        "seo_description_fa",
        "seo_keywords_fa",
        "featured_post",
		
        "seo_description_fr",
        "title_fr",
        "seo_title_fr",
        "seo_keywords_fr",
		
        "seo_description_ru",
        "title_ru",
        "seo_title_ru",
        "seo_keywords_ru",
    ];
}
