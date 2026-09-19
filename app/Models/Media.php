<?php
namespace App\Models;

class Media extends BaseModel
{
    public $table = "medias";
    
    protected $fillable = [
        "name_ar",
        "name_en",
        "name_fr",
        "name_ru",
        "name_fa",
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "description_ar",
        "description_en",
        "description_fr",
        "description_ru",
        "description_fa",
        "folder_id",
        "filename",
        "path",
        "filename_mobile",
        "path_mobile",
    ];
    
    public function folder()
    {
        return $this->belongsTo("App\Models\MediaFolder");
    }
    public function getSizeAttribute()
    {
        $fullPath = public_path($this->path);
    
        if (!file_exists($fullPath)) {
            return null;
        }
    
        $size = filesize($fullPath);
    
        if ($size >= 1024 * 1024) {
            return round($size / (1024 * 1024), 2) . ' MB';
        }
    
        if ($size >= 1024) {
            return round($size / 1024, 2) . ' KB';
        }
    
        return $size . ' B';
    }
    public function getSizeBytesAttribute()
    {
        $fullPath = public_path($this->path);
    
        if (!file_exists($fullPath)) {
            return 0;
        }
    
        return filesize($fullPath);
    }
}