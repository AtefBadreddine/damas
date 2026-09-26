<?php
namespace App\Models;

use LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;

class Project extends BaseModel
{
    use SearchableTrait;
    public $table = "projects";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "slug",
		"project_link",
        "city_id",
        "payment_method",
        "region_id",
        "construction_year",
        "delivered_date",
        "distance_beach",
        "distance_airport",
        "distance_center",
        "project_etat",
        "intro_card_ar",
        "intro_card_en",
        "intro_card_fr",
        "intro_card_ru",
        "card_photo_id",
        "linkvideo_ar",
        "linkvideo_en",
        "linkvideo_fr",
        "linkvideo_ru",
        "intro_location_ar",
        "location_ar",
        "governmental_ar",
        "transportation_ar",
        "future_look_ar",
        "intro_location_en",
        "location_en",
        "governmental_en",
        "transportation_en",
        "future_look_en",
        "intro_features_ar",
        "intro_features_en",
        //"paymentmethod_ar",
        "paymentmethod_en",
        "is_price_usd",
        "salemanager_ar_id",
        "salemanager_en_id",
        "latitude",
        "longitude",
        "dms_map",
        "dms_map_real",
        "similar_projects",
        "published",
        "featured",
        //"buyed",
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
        "user_id",
        "user_name",
        "send_notif_ar",
        "send_notif_en",
		"edit_date",
		'title_ar',
		'title_en',
		'company',
		'payment_percent',
		'payment_months',
		'link_3d',
		/*'file_offer',
		'file_offer_en',
		'file_offer_fr',*/
		'enable_offer',
		
		
		
		'salemanager_fr_id',
		'intro_location_fr',
		'location_fr',
		'governmental_fr',
		'transportation_fr',
		'future_look_fr',
		'intro_features_fr',
		
		'salemanager_ru_id',
		'intro_location_ru',
		'location_ru',
		'governmental_ru',
		'transportation_ru',
		'future_look_ru',
		'intro_features_ru',
		
		
		
		'offer_type',
		'offer_duration',
		'offer_cache_discount',
		'offer_installment_discount',
		'offer_installment_months',
		
		
		"cash_cetizenship_price",
		"sold",


		//"pm2",
		"cash_discount",
		
		
		"bs",
		"fs",
		"tabu",
		"sort",
		
		
		
		
		
"name_fa",
"intro_card_fa",
"linkvideo_fa",
"intro_location_fa",
"location_fa",
"governmental_fa",
"transportation_fa",
"future_look_fa",
"intro_features_fa",
"salemanager_fa_id",
"seo_title_fa",
"seo_description_fa",
"seo_keywords_fa",
"send_notif_fa",
"old_slug",
		
		
		/*'file_infographic',
		'file_pdf'*/
    ];
    
	
    /**
    * user
    *
    * @return void
    */
    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id");
    }

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'projects.name_ar' => 10,
            'projects.name_en' => 10,
            'projects.payment_method' => 10,
            'projects.construction_year' => 10,
            'projects.delivered_date' => 10,
            'projects.distance_airport' => 5,
            'projects.intro_card_ar' => 5,
            'projects.intro_card_en' => 5,
            'projects.intro_location_ar' => 5,
            'projects.location_ar' => 5,
            'projects.governmental_ar' => 5,
            'projects.transportation_ar' => 5,
            'projects.future_look_ar' => 5,
            'projects.intro_location_en' => 5,
            'projects.location_en' => 5,
            'projects.governmental_en' => 5,
            'projects.transportation_en' => 5,
            'projects.future_look_en' => 5,
            'projects.intro_features_ar' => 5,
            'projects.intro_features_en' => 5,
            //'projects.paymentmethod_ar' => 5,
            'projects.paymentmethod_en' => 5,
        ]
    ];
    
    /**
    * sale manager arabe relation
    *
    * @return void
    */
    public function manager_ar()
    {
        return $this->belongsTo("App\Models\SaleManager", "salemanager_ar_id");
    }
	/**
    * sale manager fr relation
    *
    * @return void
    */
    public function manager_fr()
    {
        return $this->belongsTo("App\Models\SaleManager", "salemanager_fr_id");
    }
	/**
    * sale manager ru relation
    *
    * @return void
    */
    public function manager_ru()
    {
        return $this->belongsTo("App\Models\SaleManager", "salemanager_ru_id");
    }
    
    /**
    * city relation
    *
    * @return void
    */
    public function city()
    {
        return $this->belongsTo("App\Models\City", "city_id");
    }
    
    /**
    * region relation
    *
    * @return void
    */
    public function region()
    {
        return $this->belongsTo("App\Models\Region", "region_id");
    }

    /**
     * Canonical geo URL: /{locale}/{country}/{city}/{region}/{project}
     * Returns null when city/region/country are missing so callers can skip the 301.
     *
     * @param bool $absolute
     * @return string|null
     */
    public function geoUrl($absolute = true)
    {
        $city = $this->city;
        $region = $this->region;
        if (!$city || !$region || !$city->slug || !$region->slug) {
            return null;
        }

        $countrySlug = $city->getCountrySlug();
        if (!$countrySlug) {
            return null;
        }

        return route('front.project.show', array(
            'country' => $countrySlug,
            'city' => $city->slug,
            'region' => $region->slug,
            'project' => $this->slug,
        ), $absolute);
    }

    /**
     * Public project URL for menus, cards, and shares.
     * Prefers the geo path; falls back to the legacy /projects/{slug} 301.
     *
     * @param bool $absolute
     * @return string
     */
    public function frontUrl($absolute = true)
    {
        $url = $this->geoUrl($absolute);
        return $url ? $url : route('front.project', $this->slug, $absolute);
    }
    
    /**
    * card photo relation
    *
    * @return void
    */
    public function cardphoto()
    {
        return $this->belongsTo("App\Models\Media", "card_photo_id");
    }
    
    /**
    * project types relation
    *
    * @return void
    */
    public function types()
    {
        return $this->belongsToMany("App\Models\ProjectType", "project_type");
    }
	
    /**
    * companies relation
    *
    * @return void
    */
    public function companies()
    {
        return $this->belongsToMany("App\Models\Company", "project_company");
    }
    
    /**
    * Sync project type relation
    *
    * @param array $types
    * @return void
    */
    public function syncTypes($types = [])
    {
        if ( count($types) ) {
            $this->types()->sync($types); return;
        }
        $this->types()->detach();
    }

    /**
    * Sync companies relation
    *
    * @param array $companies
    * @return void
    */
    public function syncCompanies($companies = [])
    {
        if ( count($companies) ) {
            $this->companies()->sync($companies); return;
        }
        $this->companies()->detach();
    }
    
    /**
    * project types relation
    *
    * @return void
    */
    public function categories()
    {
        return $this->belongsToMany("App\Models\ProjectCategory", "project_category");
    }
    
    /**
    * Sync project category relation
    *
    * @param array $categories
    * @return void
    */
    public function syncCategories($categories = [])
    {
        if ( count($categories) ) {
            $this->categories()->sync($categories); return;
        }
        $this->categories()->detach();
    }
    
    /**
    * project features relation
    *
    * @return void
    */
    public function features()
    {
        return $this->belongsToMany("App\Models\ProjectFeature", "project_feature");
    }
    
    /**
    * Sync project feature relation
    *
    * @param array $categories
    * @return void
    */
    public function syncFeatures($features = [])
    {
        if ( count($features) ) {
            $this->features()->sync($features); return;
        }
        $this->features()->detach();
    }
    
    /**
    * project photos relation
    *
    * @return void
    */
    public function projectphotos()
    {
        return $this->belongsToMany("App\Models\Media", "project_photos")->orderBy('id', 'ASC');
    }
    
    /**
    * Sync project photos relation
    *
    * @param array $photos
    * @return void
    */
    public function syncProjectPhotos($photos = [])
    {
        if ( count($photos) ) {
            $this->projectphotos()->sync($photos); return;
        }
        $this->projectphotos()->detach();
    }
    
    /**
    * project interior photos relation
    *
    * @return void
    */
    public function interiorPhotos()
    {
        return $this->belongsToMany("App\Models\Media", "project_interior_photos");
    }
    
    /**
    * Sync project interior photos relation
    *
    * @param array $photos
    * @return void
    */
    public function syncInteriorPhotos($photos = [])
    {
        if ( count($photos) ) {
            $this->interiorPhotos()->sync($photos); return;
        }
        $this->interiorPhotos()->detach();
    }
    
    /**
    * project plan photos relation
    *
    * @return void
    */
    public function planPhotos()
    {
        return $this->belongsToMany("App\Models\Media", "project_plan_photos");
    }
    
    /**
    * Sync project plan photos relation
    *
    * @param array $photos
    * @return void
    */
    public function syncPlanPhotos($photos = [])
    {
        if ( count($photos) ) {
            $this->planPhotos()->sync($photos); return;
        }
        $this->planPhotos()->detach();
    }
    
    /**
    * project flavor relation
    *
    * @return void
    */
    public function flavors()
    {
        return $this->hasMany("App\Models\ProjectFlavor");
    }
	
	/**
    * story
    *
    * @return void
    */
    public function story()
    {
        return $this->belongsTo("App\Models\Story", "id", "project_id");
    }
	
	
    /**
    * project data videos relation
    *
    * @return void
    */
    public function crmvideos()
    {
        return $this->hasMany("App\Models\Crm_video",'project');
    }
    
    /**
    * project posts relation
    *
    * @return void
    */
    public function posts()
    {
        return $this->belongsToMany("App\Models\Post", "project_post");
    }
    
    /**
    * Sync project posts relation
    *
    * @param array $types
    * @return void
    */
    public function syncPosts($posts = [])
    {
        if ( count($posts) ) {
            $this->posts()->sync($posts); return;
        }
        $this->posts()->detach();
    }
    
    /**
    * project posts anglais relation
    *
    * @return void
    */
    public function postsEn()
    {
        return $this->belongsToMany("App\Models\Post", "project_post_en");
    }
    
    /**
    * Sync project posts relation
    *
    * @param array $types
    * @return void
    */
    public function syncPostsEn($posts = [])
    {
        if ( count($posts) ) {
            $this->postsEn()->sync($posts); return;
        }
        $this->postsEn()->detach();
    }
	
    /**
    * project posts fr relation
    *
    * @return void
    */
    public function postsFr()
    {
        return $this->belongsToMany("App\Models\Post", "project_post_fr");
    }
    
    /**
    * Sync project posts relation
    *
    * @param array $types
    * @return void
    */
    public function syncPostsFr($posts = [])
    {
        if ( count($posts) ) {
            $this->postsFr()->sync($posts); return;
        }
        $this->postsFr()->detach();
    }
	
	/**
    * project posts ru relation
    *
    * @return void
    */
    public function postsRu()
    {
        return $this->belongsToMany("App\Models\Post", "project_post_ru");
    }
    
    /**
    * Sync project posts relation
    *
    * @param array $types
    * @return void
    */
    public function syncPostsRu($posts = [])
    {
        if ( count($posts) ) {
            $this->postsRu()->sync($posts); return;
        }
        $this->postsRu()->detach();
    }
	
    /**
    * project posts fa relation
    *
    * @return void
    */
    public function postsFa()
    {
        return $this->belongsToMany("App\Models\Post", "project_post_fa");
    }
    
    /**
    * Sync project posts relation
    *
    * @param array $types
    * @return void
    */
    public function syncPostsFa($posts = [])
    {
        if ( count($posts) ) {
            $this->postsFa()->sync($posts); return;
        }
        $this->postsFa()->detach();
    }
	
    public function getPosts()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		if($lang=='ar'){
			return $this->posts();
		}elseif($lang=='en'){
			return $this->postsEn();
		}elseif($lang=='fr'){
			return $this->postsFr();
		}elseif($lang=='ru'){
			return $this->postsRu();
		}elseif($lang=='fa'){
			return $this->postsFa();
		}
    }
    
	
	
	
	
    /**
    * translate
    *
    * @return void
    */
    public function getIntroCard()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "intro_card_$lang";
        return $this->$field;
    }
    public function getIntoLocation($lang='')
    {
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "intro_location_$lang";
        return $this->$field;
    }
    public function getNameEn()
    {
        return $this->name_en;
    }
	
	
	
	
    public function getLocation($lang='')
    {
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "location_$lang";
		$reg = $this->region;
		if($reg->getLocation($lang)!='')
			return $reg->getLocation($lang);
		else
			return $this->$field;
    }
    public function getGovernmental($lang='')
    {
		//return 'AZAZAZAZA';
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
	
        $field = "governmental_$lang";
		$reg = $this->region;
		if($reg->getGovernmental($lang)!='')
			return $reg->getGovernmental($lang);
		else
			return $this->$field;
    }
    public function getTransportation($lang='')
    {
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "transportation_$lang";
		$reg = $this->region;
		if($reg->getTransportation($lang)!='')
			return $reg->getTransportation($lang);
		else
			return $this->$field;
    }
    public function getFutureLook($lang='')
    {
		if($lang=='')
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "future_look_$lang";
		$reg = $this->region;
		if($reg->getFutureLook($lang)!='')
			return $reg->getFutureLook($lang);
		else
			return $this->$field;
    }
	
	
	
	
	
	
	
	
    public function getPaymentMethod()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "paymentmethod_$lang";
        return $this->$field;
    }
    public function getIntroFeatures()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "intro_features_$lang";
        return $this->$field;
    }
    public function getIntroFeaturesEn()
    {
        return $this->intro_features_en;
    }
    public function getIntroFeaturesFr()
    {
        return $this->intro_features_fr;
    }
    public function getLinkVideo()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "linkvideo_$lang";
        return $this->$field;
    }
    public function getStatus()
    {
		if($this->sold=='100')
			return array('resale',trans("front.Resale"));
		
		
		if($this->project_etat=='قيد الإنشاء')
			return array('under-construction',trans("front.under cons"));
		else
			return array('ready',trans("front.ready"));
		/*
		$dif = ((strtotime($this->delivered_date) - strtotime(date('Y-m-d')))/3600)/24;
		$statu = '';
		$class = '';
		if($dif>=0){
			$statu = trans("front.under cons");
			$class = 'under-construction';
		}elseif($dif<-1000){
			$statu = trans("front.Resale");
			$class = 'resale';
		}else{ 
			$statu = trans("front.ready");
			$class = 'ready';
        }*/
		return array($class,$statu);
    }
	/**
    * detail
    *
    * @return void
    */
    public function Detail()
    {
        return $this->belongsTo("App\Models\ProjectDetail", "id", "project_id");
    }
	public function getLikes()
    {
        $field = "ytb_likes_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field2 = "c_likes_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        return ($this->Detail->$field+$this->Detail->$field2);
    }
	
	
	/**
    * section videos relation
    *
    * @return void
    */
    public function videos()
    {
        return $this->belongsToMany("App\Models\Video", "project_video");
    }
	
	/**
    * Sync section videos relation
    *
    * @param array $videos
    * @return void
    */
    public function syncVideos($videos = [])
    {
        if ( count($videos) ) {
            $this->videos()->sync($videos); return;
        }
        $this->videos()->detach();
    }
}