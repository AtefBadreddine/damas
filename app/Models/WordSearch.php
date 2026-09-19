<?php
namespace App\Models;

class WordSearch extends BaseModel
{
    public $table = "wordsearch";
    
    protected $fillable = [
        "word",
        "lang",
        "type",
    ];
    
	
    
}