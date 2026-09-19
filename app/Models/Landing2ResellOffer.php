<?php
namespace App\Models;

class Landing2ResellOffer extends BaseModel
{
    public $table = "landing2_resell_offer";
	
    protected $fillable = [
		"landing2_id",
		"type_project",
		"offer_id",
		"title",
		"title_en",
		"title_fr",
		"title_pe",
		"title_ru",
		"arrange",
    ];
    
	
	
    
}