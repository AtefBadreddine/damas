<?php
namespace App\Models;

class SitemapCats extends BaseModel
{
    public $table = "sitemapcats";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "link_type",
        "link_value",
        "link",
        "link_en",
        "parent_id",
        "placement",
        "lang",
    ];
}