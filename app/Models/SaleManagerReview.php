<?php
namespace App\Models;
use LaravelLocalization;

class SaleManagerReview extends BaseModel
{
    public $table = "sales_managers_reviews";
    
    protected $fillable = [
        "sale_manager_id",
        "client_name",
        "client_country",
        "client_name_en",
        "client_country_en",
		"rv1",
		"rv2",
		"rv3",
		"rv4",
		"rv5",
		"rv6",
		"avg_rv",
		"comment",
		"comment_en",
		"comment_fa",
		"comment_fr",
		"comment_ru",
		"enabled",
    ];

	
	public function getF($field)
    {
        $lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        //$field = 'career';
		if($lang!='ar')
			$field = $field.'_'.$lang;
		
		return $this->$field;
    }
}