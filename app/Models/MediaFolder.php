<?php
namespace App\Models;

class MediaFolder extends BaseModel
{
    public $table = "medias_folder";
    
    protected $fillable = [
        "name",
    ];
    
    public function medias()
    {
        return $this->hasMany("App\Models\Media", "folder_id");
    }
    
}