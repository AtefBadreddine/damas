<?php
namespace App\Models;
use LaravelLocalization;
class Competitor extends BaseModel
{
    public $table = "competitors";
    
    protected $fillable = [
        "name"
    ];
    
  
    /**
    * project flavor relation
    *
    * @return void
    */
    public function ads()
    {
        return $this->hasMany("App\Models\CompetitorAds");
    }
	
	
}