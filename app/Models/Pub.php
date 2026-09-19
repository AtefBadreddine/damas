<?php
namespace App\Models;
use LaravelLocalization;
class Pub extends BaseModel
{
    public $table = "pubs";
    
    protected $fillable = [
        "name",
        "media_id",
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "link",
        "content_ar",
        "content_en",
        "content_fr",
        "content_ru",
        "content_fa",
    ];
    
    /**
    * media
    *
    * @return void
    */
    public function media()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
}