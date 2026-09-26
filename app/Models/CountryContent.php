<?php
namespace App\Models;
use LaravelLocalization;

class CountryContent extends BaseModel
{
    public $table = "countrycontent";

    protected $fillable = [
        "country_id",
        "title",
        "content",
        "title_en",
        "content_en",
    ];

    public function country()
    {
        return $this->belongsTo("App\Models\Country", "country_id");
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
