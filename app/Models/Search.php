<?php
namespace App\Models;

class Search extends BaseModel
{
    public $table = "search";
    
    protected $fillable = [
        "word",
        "cnt_search",
        "country",
        "lastcountry",
        "source",
        "campaign",
        "target",
		"lang",
    ];
} 