<?php
namespace App\Models;
use LaravelLocalization;
class NewLandingPage extends BaseModel
{
    public $table = "newlandingpages";
    
    protected $fillable = [
        "slug",
        "title",
        
		"og_photo",
        "seo_title",
        "seo_description",
        "seo_keywords",
		
		'views',
    ];

    /**
    * media background for mobile relation
    *
    * @return void
    */
    public function media()
    {
        return $this->belongsTo("App\Models\Media", "og_photo");
    }
	
	
    public function getTitle()
    {
        $field = "title";
        return $this->$field;
    }
    public function getSeoTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "seo_title";
        return $this->$field;
    }
    
    public function getSeoDescription()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "seo_description";
        return $this->$field;
    }
    
    public function getSeoKeywords()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "seo_keywords";
        return $this->$field;
    }
	
}
