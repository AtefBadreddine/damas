<?php
namespace App\Models;
use LaravelLocalization;
class Tag extends BaseModel
{
    public $table = "tags";
    
    protected $fillable = [
        "slug",
        "name",
        "title_ar",
        "title_en",
        "title_fa",
		"title_fr",
		"title_ru",

        "media_id",
        /*"media_en_id",
        "media_fr_id",
        "media_ru_id",
        "media_fa_id",*/
        
		"placement",
		
		"seo_title_ar",
        "seo_description_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_title_fa",
        "seo_description_fa",

		"seo_title_fr",
        "seo_description_fr",
        "seo_title_ru",
        "seo_description_ru",
        "type",
        
        
    ];
    
    /**
    * media
    *
    * @return void
    */
    public function media()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        //if($lang=='ar')
			return $this->belongsTo("App\Models\Media", "media_id");
		/*else
			return $this->belongsTo("App\Models\Media", "media_".$lang."_id");*/
    }
    
    
	
    /**
    * posts
    *
    * @return void
    */
    public function posts()
    {
        return $this->belongsToMany("App\Models\Post","post_tag");
    }
	
	
	
    /**
    * Sync project posts relation
    *
    * @param array $types
    * @return void
    */
    /*public function syncPosts($posts = [])
    {
        if ( count($posts) ) {
            $this->posts()->sync($posts); return;
        }
        $this->posts()->detach();
    }*/
	
}