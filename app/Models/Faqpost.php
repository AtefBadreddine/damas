<?php
namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;

class Faqpost extends BaseModel
{
    use SearchableTrait;
    public $table = "faqpost";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fa",
        "icon",
        "slug",
        "media_id",
        "published",
        "placement",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "seo_title_fa",
        "seo_keywords_fa",
		"seo_description_fa",
        "title_fr",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
		
        "title_ru",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
    ];
    

    
    
    /**
    * media
    *
    * @return void
    */
    public function photoCard()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    
 	
    
}