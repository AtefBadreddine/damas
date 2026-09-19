<?php
namespace App\Models;

class Param extends BaseModel
{
    public $table = "params";
    
    protected $fillable = [
        "name",
        "tel_1",
        "tel_2",
        "email",
        "lang",
        "address",
        "facebook",
        "twitter",
        "gplus",
        "linkedin",
        "instagram",
        "youtube",
        "emails",
        "form_title",
        "user_email_send",
        "user_email_title",
        "user_email_text",
        "latitude",
        "longitude",
        "footer_about",
        "footer_text_newsletter",
        "seo_title",
        "seo_description",
        "seo_keywords",
        "whatsapp_share",
        "exchange",
        "exch_gold",
		"parag_index_title",
		"parag_index_content",
		"index_og_pic",
    ];
	
	
	
    /**
    * card photo relation
    *
    * @return void
    */
    public function index_og_pic()
    {
        return $this->belongsTo("App\Models\Media", "index_og_pic");
    }
}