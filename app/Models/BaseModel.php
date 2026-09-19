<?php
namespace App\Models;
use LaravelLocalization;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    
    public static function table_name()
    {
        return with(new static)->getTable();
    }
    public function getLF($field)
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		$field = $field.'_'.$lang;
		return $this->$field;
    }
    public function getTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "title_$lang";
        return $this->$field;
    }
    
    public function getName()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "name_$lang";
        return $this->$field;
    }
    public function getSlug()
    {
        return $this->slug;
    }
    
	public function getNameEn()
    {
        return $this->name_en;
    }
	public function getNameFr()
    {
        return $this->name_fr;
    }
	public function getNameRu()
    {
        return $this->name_ru;
    }
	public function getNameFa()
    {
        return $this->name_fa;
    }
	public function getNameAr()
    {
        return $this->name_ar;
    }
    public function getDescription()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "description_$lang";
        return $this->$field;
    }
    
    public function getSeoTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "seo_title_$lang";
        return $this->$field;
    }
    
    public function getSeoDescription()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "seo_description_$lang";
        return $this->$field;
    }
    
    public function getSeoKeywords()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "seo_keywords_$lang";
        return $this->$field;
    }
    
    public function getAboutTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "about_title_$lang";
        return $this->$field;
    }
    
    public function getAbout()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "about_$lang";
        return $this->$field;
    }
    
    public function getContent()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "content_$lang";
        return $this->$field;
    }
    
    public function getAddress()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        $field = "address_$lang";
        return $this->$field;
    }
    
}