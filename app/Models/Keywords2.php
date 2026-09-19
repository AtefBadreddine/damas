<?php
namespace App\Models;
use LaravelLocalization;
class Keywords2 extends BaseModel
{
    public $table = "keywords2";
    
    protected $fillable = [
        "keyword_ar",
        "keyword_en",
        "keyword_fr",
        "keyword_ru",
        "keyword_fa",
        "url",
        "display",
    ];
    
	
	
	public function getKeyword()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "keyword_$lang";
        return $this->$field;
    }
	public function getDisplay()
    {
		
		$arr = explode(';',$this->display);
		

        return $arr;
    }
	
	
    
}