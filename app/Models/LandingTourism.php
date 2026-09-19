<?php
namespace App\Models;
use LaravelLocalization;
class LandingTourism extends BaseModel
{
    public $table = "landing_tourism";
    
    protected $fillable = [
        //"name",
        "lang",
        "slug",
        //"title",
        //"content",
        
		
		
		"title_ar",
		"title_en",
		"title_fr",
		"title_ru",
		"title_fa",
		
		"content_fr",
		"content_ru",
		"content_ar",
		"content_en",
		"content_fa",
		
		/*
		"background_photo",
		"background_photo_en",
		"background_photo_fr",
		"background_photo_ru",
		"background_photo_fa",
        "background_photo_mobile",
        
		"project_id",
        "region_title",
        "region_content",
        "infos_photo",
        "hide_whatsapp",
        "hide_popup",
        "seo_title",
        "seo_description",
        "seo_keywords",
		
		'views',
		'views_en',
		'views_fa',
		'views_fr',
		'views_ru',*/
		
		
		"seo_title_fa",
		"seo_description_fa",
		"seo_keywords_fa",
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
    ];
    
    
    
    /**
    * landing sliders relation
    *
    * @return void
    */
   /* public function sliders()
    {
        return $this->belongsToMany("App\Models\Media", "landingpage_slider");
    }*/
    
    /**
    * Sync landing media relation
    *
    * @param array $photos
    * @return void
    */
   /* public function syncLandingSliders($sliders = [])
    {
        if ( count($sliders) ) {
            $this->sliders()->sync($sliders); return;
        }
        $this->sliders()->detach();
    }*/
    
    /**
    * infos relation
    *
    * @param int $var
    * @return void
    */
   /* public function infos()
    {
        return $this->hasMany("App\Models\LandingPageInfos", "landingpage_id");
    }
    */
    /**
    * media background relation
    *
    * @return void
    */
   /* public function background($lang='')
    {
		if($lang=='')
			$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		
		if($lang=='ar')
			return $this->belongsTo("App\Models\Media", "background_photo");
		else
			return $this->belongsTo("App\Models\Media", "background_photo_".$lang);
    }*/

    /**
    * media background for mobile relation
    *
    * @return void
    */
    /*public function backgroundMobile()
    {
        return $this->belongsTo("App\Models\Media", "background_photo_mobile");
    }*/
    
    /**
    * media infos relation
    *
    * @return void
    */
    /*public function infosPhoto()
    {
        return $this->belongsTo("App\Models\Media", "infos_photo");
    }*/
    
    /**
    * project relation
    *
    * @return void
    */
    /*public function project()
    {
        return $this->belongsTo("App\Models\Project", "project_id");
    }*/
    
	
	
	
	/*
    * project photos relation
    *
    * @return void
    
    public function offers()
    {
        return $this->belongsToMany("App\Models\Land3offer", "landing3_landoffer")->orderBy('id', 'ASC');
    }
    
    
    * Sync project offers relation
    *
    * @param array $offers
    * @return void
    
    public function syncOffers($offers = [])
    {
        if ( count($offers) ) {
            $this->offers()->sync($offers); return;
        }
        $this->offers()->detach();
    }*/
}
