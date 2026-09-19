<?php
namespace App\Models;

class LandofferPattern extends BaseModel
{
    public $table = "landoffers_patterns";
    protected $fillable = [
        "landoffer_id",
        "project_id",
		"type",
		"pattern",
		"area",
		"view"
    ];
    
    
}