<?php
namespace App\Models;

class Rating extends BaseModel
{
    public $table = "rating";
    
    protected $fillable = [
        "off_msg_ar",
        "off_msg_en",
        "off_msg_fa",
        "off_msg_fr",
        "off_msg_ru",
		
        "fresh_msg_ar",
        "fresh_msg_en",
        "fresh_msg_fa",
        "fresh_msg_fr",
        "fresh_msg_ru",
		
        "tour_msg_ar",
        "tour_msg_en",
        "tour_msg_fa",
        "tour_msg_fr",
        "tour_msg_ru",
		
        "deal_msg_ar",
        "deal_msg_en",
        "deal_msg_fa",
        "deal_msg_fr",
        "deal_msg_ru",

    ];
}
