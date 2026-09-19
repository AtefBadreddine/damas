<?php
namespace App\Models;

class Redirectsearchprojects extends BaseModel
{
    public $table = "projectssearchkeywords";
    
    protected $fillable = [
        "class",
        "lang",
        "keywords",
    ];
    
}
