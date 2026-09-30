<?php
namespace App\Models;
use LaravelLocalization;
class City extends BaseModel
{
    public $table = "cities";
    
    protected $fillable = [
        "country_id",
        "name_ar",
        "name_en",
        "name_fa",
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
        "media_index",
        "media_id",
        "media_en_id",
        "media_fr_id",
        "media_ru_id",
        "media_fa_id",
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
		"enable_district_page",
		"post_id",
		"sec1_post_id",
		"sec2_post_id",
		"sec3_post_id",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
        "about_fr",
        "about_title_fr",
        "title_fr",
        "name_fr",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
        "about_ru",
        "about_title_ru",
        "title_ru",
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
    ];
	
	
	
    public function getH1()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "h1_$lang";
		return $this->$field;
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
	public function getPost()
    {
		return $this->belongsTo("App\Models\Post", "post_id");
    }
	public function getPostSec1()
    {
		return $this->belongsTo("App\Models\Post", "sec1_post_id");
    }
	public function getPostSec2()
    {
		return $this->belongsTo("App\Models\Post", "sec2_post_id");
    }
	public function getPostSec3()
    {
		return $this->belongsTo("App\Models\Post", "sec3_post_id");
    }
    
    /**
    * media
    *
    * @return void
    */
    public function media()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if($lang=='ar')
			return $this->belongsTo("App\Models\Media", "media_id");
		else
			return $this->belongsTo("App\Models\Media", "media_".$lang."_id");
    }
    public function indexMedia()
    {
        return $this->belongsTo("App\Models\Media", "media_index");
    }
    public function mediaAr()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    public function mediaEn()
    {
        return $this->belongsTo("App\Models\Media", "media_en_id");
    }
    public function mediaFr()
    {
        return $this->belongsTo("App\Models\Media", "media_fr_id");
    }
    public function mediaRu()
    {
        return $this->belongsTo("App\Models\Media", "media_ru_id");
    }
    public function mediaFa()
    {
        return $this->belongsTo("App\Models\Media", "media_fa_id");
    }
    
	
    /**
     * Geographic country parent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function countryRel()
    {
        return $this->belongsTo("App\Models\Country", "country_id");
    }

    /**
     * Country slug used in geo URLs (turkiye), not the country code (turkey).
     *
     * @return string|null
     */
    public function getCountrySlug()
    {
        return $this->countryRel ? $this->countryRel->slug : null;
    }

    /**
    * regions
    *
    * @return void
    */
    public function regions()
    {
        return $this->hasMany("App\Models\Region","city_id");
    }

    /**
     * City listing URL: /{locale}/{country}/{city}/
     *
     * @param bool $absolute
     * @return string|null
     */
    public function listingUrl($absolute = true)
    {
        $countrySlug = $this->getCountrySlug();
        if (!$countrySlug || !$this->slug) {
            return null;
        }

        return route('front.location.city', array(
            'country' => $countrySlug,
            'city' => $this->slug,
        ), $absolute);
    }
}