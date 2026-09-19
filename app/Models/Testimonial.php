<?php
namespace App\Models;
use LaravelLocalization;
class Testimonial extends BaseModel
{
    public $table = "testimonials";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fr",
        "name_ru",
        "name_fa",
        "job_ar",
        "job_en",
        "job_fr",
        "job_ru",
        "job_fa",
        "content_ar",
        "content_en",
        "content_fr",
        "content_ru",
        "content_fa",
        "video_ar",
        "video_en",
        "video_fr",
        "video_ru",
        "video_fa",
        "media_id",
        "media_back_id",
    ];
    
    public function photo()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    public function background()
    {
        return $this->belongsTo("App\Models\Media", "media_back_id");
    }
	public function getName()
    {
        $field = "name_". (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        return $this->$field;
    }
	public function getVideo()
    {
        $field = "video_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        return $this->$field;
    }
	public function getJob()
    {
        $field = "job_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        return $this->$field;
    }
	public function getContent()
    {
        $field = "content_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        return $this->$field;
    }
}