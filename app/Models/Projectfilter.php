<?php
namespace App\Models;
use LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;

class Projectfilter extends BaseModel
{
    use SearchableTrait;
    public $table = "projectfilters";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "link",
    ];
    
  
}