<?php
namespace App\Models;

class Sitemap extends BaseModel
{
    public $table = "sitemap";
    
    protected $fillable = [
        "title",
        "lang",
		
        "links",

        "seo_title",
        "seo_description",
        "seo_keywords",
    ];
}