<?php
namespace App\Models;

//use Nicolaslopezj\Searchable\SearchableTrait;

class Faq extends BaseModel
{
    //use SearchableTrait;
    public $table = "faq";

    protected $fillable = [
        "faq_post",
        "q_ar",
        "q_en",
        "q_fr",
        "q_ru",
        "q_fa",
        "r_ar",
        "r_en",
        "r_fr",
        "r_ru",
        "r_fa",
		"str_posts",
    ];




   
    
 	
    
}