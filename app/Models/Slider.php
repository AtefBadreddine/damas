<?php
namespace App\Models;

class Slider extends BaseModel
{
    public $table = "sliders";
    
    protected $fillable = [
        "media_id",
        "media_mobile_id",
        "video_desktop",
        "video_mobile",
        "name",
        "lang",
        "background_color",
        "slider_link",
        "content",
    ];
    
    public function media()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    
    public function mediaMobile()
    {
        return $this->belongsTo("App\Models\Media", "media_mobile_id");
    }
    
}