<?php
namespace App\Models;

use Nicolaslopezj\Searchable\SearchableTrait;

class Livingcat extends BaseModel
{
    use SearchableTrait;
    public $table = "livingcat";
    
    protected $fillable = [
        "title_ar",
        "title_en",
        "title_fr",
        "title_ru",
        "title_fa",
        "type",//jobs or livelihood
        "placement",
    ];
    

    
    /**
    * items relation
    *
    * @return void
    */
    public function items()
    {
        return $this->hasMany("App\Models\Livingitem");
    }
   
    
 	
    
}