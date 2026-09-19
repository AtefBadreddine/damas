<?php
namespace App\Models;

class LandingPageInfos extends BaseModel
{
    public $table = "landingpage_infos";
    
    protected $fillable = [
        "landingpage_id",
        "icon",
        "title",
        "description"
    ];
}