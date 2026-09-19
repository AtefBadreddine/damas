<?php
namespace App\Models;

//use Nicolaslopezj\Searchable\SearchableTrait;

class Livingitem extends BaseModel
{
    //use SearchableTrait;
    public $table = "livingitem";
    
    protected $fillable = [
        "livingcat_id",
        "name_ar",
        "name_en",
        "name_fr",
        "name_ru",
        "name_fa",
        "price",
    ];




   
    
 	
    
}