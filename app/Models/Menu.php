<?php
namespace App\Models;

class Menu extends BaseModel
{
    public $table = "menus";
    
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
    ];
}