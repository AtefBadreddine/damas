<?php
namespace App\Models;

class Stat_house_sales extends BaseModel
{
    public $table = "stat_house_sales";
    
    protected $fillable = [
	"year",
	"city",
	"city_ar",
	"country",
	"country_ar",
	"month",
	"imonth",
	"value",
	"type",
    ];
	
}