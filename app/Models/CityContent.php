<?php
namespace App\Models;
use LaravelLocalization;

class CityContent extends BaseModel
{
    public $table = "citycontent";

    protected $fillable = [
        "city_id",
        "title",
        "content",
        "title_en",
        "content_en",
        "title_fr",
        "content_fr",
        "title_fa",
        "content_fa",
        "title_ru",
        "content_ru",
    ];

    public function city()
    {
        return $this->belongsTo("App\Models\City", "city_id");
    }

    public function getTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if ($lang != 'ar') {
            $field = "title_$lang";
            return $this->$field;
        }
        return $this->title;
    }

    public function getContent()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if ($lang != 'ar') {
            $field = "content_$lang";
            return $this->$field;
        }
        return $this->content;
    }
}
