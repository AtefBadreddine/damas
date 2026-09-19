<?php
namespace App\Models;

class PageSearch extends BaseModel
{
    public $table = "page_search";
    
    protected $fillable = [
        "name",
        "link",
        "media_id",
        "media_en_id",
        "title",
        "content",
        "title_en",
        "content_en",
        "seo_title_ar",
        "seo_description_ar",
        "seo_keywords_ar",
        "seo_title_en",
        "seo_description_en",
        "seo_keywords_en",
        "title_fa",
        "content_fa",
        "seo_title_fa",
        "seo_description_fa",
        "seo_keywords_fa",
        "media_fr_id",
        "title_fr",
        "content_fr",
        "seo_title_fr",
        "seo_description_fr",
        "seo_keywords_fr",
		
        "media_ru_id",
        "title_ru",
        "content_ru",
        "seo_title_ru",
        "seo_description_ru",
        "seo_keywords_ru",
		"post_id",
    ];
    
	public function getPost()
    {
		return $this->belongsTo("App\Models\Post", "post_id");
    }
	

	public function getTitle()
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if($lang!='ar')
			$field = "title_$lang";
		else
			$field = "title";
        return $this->$field;
    }
	
    public function media()
    {
        return $this->belongsTo("App\Models\Media", "media_id");
    }
    public function mediaEn()
    {
        return $this->belongsTo("App\Models\Media", "media_en_id");
    }
    public function mediaFr()
    {
        return $this->belongsTo("App\Models\Media", "media_fr_id");
    }
    public function mediaRu()
    {
        return $this->belongsTo("App\Models\Media", "media_ru_id");
    }
    public function mediaFa()
    {
        return $this->belongsTo("App\Models\Media", "media_fa_id");
    }
	
    public function getMedia()
    {
		$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
		
        if($lang=='en' && $this->mediaEn())
			return $this->mediaEn();
		elseif($lang=='fr' && $this->mediaFr())
			return $this->mediaFr();
		elseif($lang=='fa' && $this->mediaFa())
			return $this->mediaFa();
		elseif($lang=='ru' && $this->mediaRu())
			return $this->mediaRu();
		
		return $this->media();
    }
	
	
    
}