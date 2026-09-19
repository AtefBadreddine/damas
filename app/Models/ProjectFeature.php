<?php
namespace App\Models;

class ProjectFeature extends BaseModel
{
    public $table = "project_features";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fr",
        "name_ru",
        "name_fa",
        "slug",
    ];
}
