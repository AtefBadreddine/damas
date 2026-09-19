<?php
namespace App\Models;

class PostCategory extends BaseModel
{
    public $table = "posts_categories";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fr",
        "name_ru",
        "name_fa",
        "placement",
        "slug",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
        "seo_title_fa",
        "seo_description_fa",
        "seo_keywords_fa",
        "icon",
        "country",
        "type",//blog or news
    ];
    
    /**
    * posts
    *
    * @return void
    */
    public function posts()
    {
        return $this->belongsToMany("App\Models\Post", "post_category");
    }

}