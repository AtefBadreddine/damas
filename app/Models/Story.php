<?php
namespace App\Models;
use LaravelLocalization;

//use Nicolaslopezj\Searchable\SearchableTrait;

class Story extends BaseModel
{
    //use SearchableTrait;
    public $table = "story";
    
    protected $fillable = [
        "project_id",
        "story_title_ar",
        "story_title_en",
        "story_title_fr",
        "story_title_ru",
        "story_title_fa",
        "file1",
        "file2",
        "file3",
        "file4",
        "file5",
        "lang1",
        "lang2",
        "lang3",
        "lang4",
        "lang5",
    ];

	public function getTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "story_title_$lang";
        return $this->$field;
    }


	/**
    * project
    *
    * @return void
    */
    public function project()
    {
        return $this->belongsTo("App\Models\Project", "project_id");
    }
   
    
 	
    
}