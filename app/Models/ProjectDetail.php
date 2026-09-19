<?php
namespace App\Models;
use LaravelLocalization;
class ProjectDetail extends BaseModel
{
    public $table = "projects_details";
    protected $fillable = [
        "project_id",
        'pm3',
		'pm3_usd',
		'pm4',
		'pm4_usd',
		'pm5',
		'pm5_usd',
		'pm6',
		'pm6_usd',
		'pm7',
		'pm7_usd',
		'pm8',
		'pm8_usd',
		'pm9',
		'pm9_usd',
        "is_price_usd",
		
        "ytb_likes_ar",
        "ytb_likes_en",
        "ytb_likes_fr",
        "ytb_likes_ru",
        "ytb_likes_fa",
		
        "c_likes_ar",
        "c_likes_en",
        "c_likes_fr",
        "c_likes_ru",
        "c_likes_fa",

        "ytb_views_ar",
        "ytb_views_en",
        "ytb_views_fr",
        "ytb_views_ru",
        "ytb_views_fa",
    ];
	
	
	public function getLikes()
    {
        $field = "ytb_likes_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field2 = "c_likes_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        return ($this->$field+$this->$field2);
    }
	public function getViews()
    {
        $field = "ytb_views_".(LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        return $this->$field;
    }
}