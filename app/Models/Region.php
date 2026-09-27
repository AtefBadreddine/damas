<?php
namespace App\Models;
use LaravelLocalization;
class Region extends BaseModel
{
    public $table = "regions";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fa",
		
		
        "city_id",
        "slug",
        "title_ar",
        "title_en",
        "title_fr",
        "title_fa",
        "about_title_ar",
        "about_title_en",
        "about_title_fa",
		"about_ar",
        "about_en",
        "about_fa",
        "latitude",
        "longitude",
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

		"transport",
        "schools",
        "health",
        "social",
        "shopping",

        "transport_desc",
        "schools_desc",
        "health_desc",
        "social_desc",
        "shopping_desc",
		
        "linkvideo_ar",
        "linkvideo_en",
        "linkvideo_fa",
		
		
		"location_ar",
        "governmental_ar",
        "transportation_ar",
        "future_look_ar",
		
		"location_en",
        "governmental_en",
        "transportation_en",
        "future_look_en",
		
		
		"location_fa",
        "governmental_fa",
        "transportation_fa",
        "future_look_fa",
		
		
		
		
		"r_title_ar",
		"r_title_en",
		"r_title_fa",
		
		"r_descr_ar",
		"r_descr_en",
		"r_descr_fa",
		
		"r_descr_fr",
		"r_title_fr",
		"location_fr",
        "governmental_fr",
        "transportation_fr",
        "future_look_fr",
        "linkvideo_fr",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
        "about_fr",
        "about_title_fr",
        "name_fr",
		
		"r_descr_ru",
		"r_title_ru",
		"location_ru",
        "governmental_ru",
        "transportation_ru",
        "future_look_ru",
        "linkvideo_ru",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
        "about_ru",
        "about_title_ru",
        "name_ru",
		
		"h1_ar",
        "h1_en",
        "h1_fa",
        "h1_fr",
        "h1_ru",
		"primary_photo_id",
		
		"map_photo_ar_id",
		"map_photo_en_id",
		"map_photo_fr_id",
		"map_photo_fa_id",
		"map_photo_ru_id",
		"map_photo_id",
		"show_on_districts_page",
		
		"post_id",
		"post_id2",
		
		
		
		
		"location_post_id",
		"governmental_post_id",
		"transportation_post_id",
		"future_look_post_id",
		
		"r_post_id",
		"faq_category_id",
		
    ];

	public function city()
    {
		return $this->belongsTo("App\Models\City", "city_id");
    }

	public function getPost()
    {
		return $this->belongsTo("App\Models\Post", "post_id");
    }
	public function getPost1()
    {
		return $this->belongsTo("App\Models\Post", "r_post_id");
    }
	public function getPost2()
    {
		return $this->belongsTo("App\Models\Post", "post_id2");
    }



    public function getLocation($lang='')
    {	
		
		$belong_post = $this->belongsTo("App\Models\Post", "location_post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['content'];
		}
		//return '';
		
		
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "location_$lang";
        return $this->$field;
    }
    public function getGovernmental($lang='')
    { 
		$belong_post = $this->belongsTo("App\Models\Post", "governmental_post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['content'];
		}
		//return '';
		
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "governmental_$lang";
        return $this->$field;
    }
    public function getTransportation($lang='')
    {
		$belong_post = $this->belongsTo("App\Models\Post", "transportation_post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['content'];
		}
		//return '';
		
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "transportation_$lang";
        return $this->$field;
    }
    public function getFutureLook($lang='')
    {
		$belong_post = $this->belongsTo("App\Models\Post", "future_look_post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['content'];
		}
		//return '';
		
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "future_look_$lang";
        return $this->$field;
    }



    public function getTitlePg($lang='')
    {
		$belong_post = $this->belongsTo("App\Models\Post", "r_post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['title'];
		}
		//return '';
		
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "r_title_$lang";
        return $this->$field;
    }
    public function getDescriptionPg($lang='')
    {
		$belong_post = $this->belongsTo("App\Models\Post", "r_post_id")->first();
		if($belong_post!=false){
			return $belong_post->getCustomPost()['content'];
		}
		//return '';
		
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "r_descr_$lang";
        return $this->$field;
    }






	/**
    * project photos relation
    *
    * @return void
    */
    public function regionphotos()
    {
        return $this->belongsToMany("App\Models\Media", "region_photos")->orderBy('id', 'ASC');
    }
    
    /**
    * Sync region photos relation
    *
    * @param array $photos
    * @return void
    */
    public function syncRegionPhotos($photos = [])
    {
        if ( count($photos) ) {
            $this->regionphotos()->sync($photos); return;
        }
        $this->regionphotos()->detach();
    }
    
    /**
    * primary photo relation
    *
    * @return void
    */
    public function primaryphoto()
    {
        return $this->belongsTo("App\Models\Media", "primary_photo_id");
    }
    /**
    * map photo relation
    *
    * @return void
    */
    public function mapphoto()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());

        return $this->belongsTo("App\Models\Media", "map_photo_".$lang."_id");
		
    }
	
    public function getLinkVideo()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "linkvideo_$lang";
        /*if(!$this->$field)
		return $this->linkvideo_ar;
		*/
		return $this->$field;
    }
    public function getH1()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "h1_$lang";
        /*if(!$this->$field)
		return $this->linkvideo_ar;
		*/
		return $this->$field;
    }
	
	
	
	
	
	
	
	

    /**
     * District listing URL: /{locale}/{country}/{city}/{region}/
     *
     * @param bool $absolute
     * @return string|null
     */
    public function listingUrl($absolute = true)
    {
        $city = $this->city;
        if (!$city || !$city->slug || !$this->slug) {
            return null;
        }
        $countrySlug = $city->getCountrySlug();
        if (!$countrySlug) {
            return null;
        }

        return route('front.location.region', array(
            'country' => $countrySlug,
            'city' => $city->slug,
            'region' => $this->slug,
        ), $absolute);
    }
}
