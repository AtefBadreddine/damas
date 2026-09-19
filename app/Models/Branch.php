<?php
namespace App\Models;

class Branch extends BaseModel
{
    public $table = "branchs";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fr",
        "name_ru",
        "name_fa",
        "mobile",
        "phone",
        "email",
        "address_ar",
        "address_en",
		"address_fr",
		"address_ru",
		"address_fa",
        "emails",
        "latitude",
        "longitude",
    ];
}