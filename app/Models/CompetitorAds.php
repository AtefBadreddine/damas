<?php
namespace App\Models;

class CompetitorAds extends BaseModel
{
    public $table = "competitors_ads";
    
    protected $fillable = [
		"competitor_id",
		"title",
		"link",
		"ad_type",
		"tab_section",
		"image",
    ];
}