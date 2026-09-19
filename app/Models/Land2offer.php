<?php
namespace App\Models;

use LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
class Land2offer extends BaseModel
{
    use SearchableTrait;
    public $table = "landoffers";
    
    protected $fillable = [
		"slug",
		"project_id",
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
		"content_fr",
		"content_ru",
		"content_ar",
		"content_en",
		"content_fa",
		"details_fr",
		"details_ru",
		"details_ar",
		"details_en",
		"details_fa",
		"type",
		"pattern",
		"area",
		"view",
		"citizenship",
		"typelandoffer",
		"status",
		"price_list",
		"cash",
		"currency",
		"offer_end_date",
		"youtube_video",
		//"landoffer_end_date",
		"landoffer_photo",
		"paln_photos",
		"user_id",
		"user_name",
		"media_id",
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
		"published",
		"typeOffer",
		"placement",
		"created_at",
		"updated_at",
		"update_by",
		"update_by_name"
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
    * user
    *
    * @return void
    */
    public function project()
    {
        return $this->belongsTo("App\Models\Project", "project_id");
    }
    /**
    * user
    *
    * @return void
    */
    public function offertype()
    {
        return $this->belongsTo("App\Models\ProjectType", "type");
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
    * project pattern relation
    *
    * @return void
    */
    public function patterns()
    {
        return $this->hasMany("App\Models\LandofferPattern",'landoffer_id');
    }
    public function getDeatails()
    {
        
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "details_$lang";
		$arr = explode("\n",$this->$field);
		
        return $arr;
    }
	
}