<?php
namespace App\Models;

class RedirectShort extends BaseModel
{
    public $table = "redirect";
    
    protected $fillable = [
        "slug",
        "url",
        "date",
        "description",
        "hits",
    ];
} 