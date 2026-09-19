<?php
namespace App\Models;

class Crm_video extends BaseModel
{
    public $table = "crm_videos";
    
    protected $fillable = [
		"project",
		"rooms",
		"video_title",
		"video_title_en",
		"video",
		'views',
		'pic',
		'date_published',
		'title'
    ];
}