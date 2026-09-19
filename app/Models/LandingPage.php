<?php
namespace App\Models;
use LaravelLocalization;
class LandingPage extends BaseModel
{
    public $table = "landingpages";
    
    protected $fillable = [
        "name",
        "lang",
        "slug",
        "title",
        "content",
        
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
		'views_ru',
    ];
    
    
    
    /**
    * landing sliders relation
    *
    * @return void
    */
    public function sliders()
    {
        return $this->belongsToMany("App\Models\Media", "landingpage_slider");
    }
    
    /**
    * Sync landing media relation
    *
    * @param array $photos
    * @return void
    */
    public function syncLandingSliders($sliders = [])
    {
        if ( count($sliders) ) {
            $this->sliders()->sync($sliders); return;
        }
        $this->sliders()->detach();
    }
    
    /**
    * infos relation
    *
    * @param int $var
    * @return void
    */
    public function infos()
    {
        return $this->hasMany("App\Models\LandingPageInfos", "landingpage_id");
    }
    
    /**
    * media background relation
    *
    * @return void
    */
    public function background($lang='')
    {
		if($lang=='')
			$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		
		if($lang=='ar')
			return $this->belongsTo("App\Models\Media", "background_photo");
		else
			return $this->belongsTo("App\Models\Media", "background_photo_".$lang);
    }

    /**
    * media background for mobile relation
    *
    * @return void
    */
    public function backgroundMobile()
    {
        return $this->belongsTo("App\Models\Media", "background_photo_mobile");
    }
    
    /**
    * media infos relation
    *
    * @return void
    */
    public function infosPhoto()
    {
        return $this->belongsTo("App\Models\Media", "infos_photo");
    }
    
    /**
    * project relation
    *
    * @return void
    */
    public function project()
    {
        return $this->belongsTo("App\Models\Project", "project_id");
    }
    
}
