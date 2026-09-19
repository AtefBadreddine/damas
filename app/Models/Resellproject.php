<?php
namespace App\Models;

use LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
class Resellproject extends BaseModel
{
    use SearchableTrait;
	
    public $table = "resellprojects";
    
    protected $fillable = [
        "name2",
        "name",
        "city_id",
        "region_id",
		
		"zone_id",
		"type_id",
		"room",
		"m2",
		"floor",
		"kitchen",
		"bathroom",
		"balkon",
		"view",
		"price",
		"currency",
		"citizenship",
		"drive_url",
        "user_id",
        "user_name",
        "source",
		
		
		
		
		"title_ar",
		"title_en",
		"title_fr",
		"title_ru",
		"title_fa",
		
		"details_ar",
		"details_en",
		"details_fr",
		"details_ru",
		"details_fa",
		
		"offer_end_date",
		"youtube_video",
		"landoffer_end_date",
		"landoffer_photo",
		"paln_photos",
		"tabu",
		
		
		'building_type',
		'complex_name',
		'special_offer',
		'phone',
		'residence_permit',
		"ajax_city_id",
		"published"
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
    * card photo relation
    *
    * @return void
    */
    public function cardphoto()
    {
        return $this->belongsTo("App\Models\Media", "landoffer_photo");
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
    * zone relation
    *
    * @return void
    */
    public function zone()
    {
        return $this->belongsTo("App\Models\Zone", "zone_id");
    }
	
	
    /**
    * region relation
    *
    * @return void
    */
    public function type()
    {
        return $this->belongsTo("App\Models\ProjectType", "type_id");
    }
	
	
	
    public function getDescription()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "details_$lang";

        return $this->$field;
    }
	
	
    public function getDeatails()
    {
        
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "details_$lang";
		$arr = explode("\n",$this->$field);
		
        return $arr;
    }
    
    
}