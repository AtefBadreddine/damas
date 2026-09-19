<?php
namespace App\Models;

class Landing3ResellOffer extends BaseModel
{
    public $table = "landing3_resell_offer";
	
    protected $fillable = [
		"landing3_id",
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