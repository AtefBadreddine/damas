<?php
namespace App\Models;

class Keywords extends BaseModel
{
    public $table = "keywords";
    
    protected $fillable = [
        "keyword",
        "lang",
        "table",
    ];
    
	
    
}