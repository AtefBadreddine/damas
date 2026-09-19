<?php
namespace App\Models;

class FooterLink extends BaseModel
{
    public $table = "footer_links";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "link_type",
        "link_value",
        "link",
        "parent_id",
        "placement",
        "lang",
        "footer_section",
        "country"
    ];
}