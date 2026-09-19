<?php
namespace App\Models;

class RedirectSearch extends BaseModel
{
    public $table = "redirectsearch";
    
    protected $fillable = [
        "words",
        "lang",
        "type",
    ];
    
	
    
}