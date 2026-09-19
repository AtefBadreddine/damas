<?php
namespace App\Models;

class Projectssearchkeywords extends BaseModel
{
    public $table = "projectssearchkeywords";
    
    protected $fillable = [
        "class",
        "slug",
        "keywords",
    ];

}