<?php
namespace App\Models;

class VisitorTrack extends BaseModel
{
    public $table = "visitors_track";
    
    protected $fillable = [
        "ip",
        "date_visit",
        "iso_code",
        "country",
        "city",
        "browser",
        "hostname",
        "page_views",
        "blocked",
        "deleted",
    ];
}