<?php
namespace App\Models;
use LaravelLocalization;

class DistrictContent extends BaseModel
{
    public $table = "districtcontent";

    protected $fillable = [
        "region_id",
        "title",
        "content",
        "title_en",
        "content_en",
    ];

    public function region()
    {
        return $this->belongsTo("App\Models\Region", "region_id");
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
