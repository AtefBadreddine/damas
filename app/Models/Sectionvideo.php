<?php
namespace App\Models;

class Sectionvideo extends BaseModel
{
    public $table = "sectionvideos";
    protected $fillable = [
        
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "placement",
    ];
    
    /**
    * section position relation
    *
    * @return void
    */
    public function position()
    {
        return $this->belongsTo("App\Models\SectionPosition", "sectionposition_id");
    }

    /**
    * section videos relation
    *
    * @return void
    */
    public function videos()
    {
        return $this->belongsToMany("App\Models\Video");
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