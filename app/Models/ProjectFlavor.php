<?php
namespace App\Models;
use LaravelLocalization;
class ProjectFlavor extends BaseModel
{
    public $table = "projects_flavors";
    
    protected $fillable = [
        "project_id",
        "price",
        "price_usd",
        "offer",
        "room",
        "area",
        "salon",
        "observation",
        "observation_en",
        "observation_fr",
        "observation_ru",
        "bathroom",
        "date_created",
        "flavor_media_id",
        "rates_exchange",
		"checked",
		"cntx",
		
		
		"type",//villa, flat, shop ..
		"sold_out",//true flase		
		"note",
		
    ];
    
    // media relation
    public function media()
    {
        return $this->belongsTo("App\Models\Media", "flavor_media_id");
    }
	
	
    public function getObservation()
    {
        /*$lang = (LaravelLocalization::getCurrentLocale()=='pe'?'fa':LaravelLocalization::getCurrentLocale());
        if($lang=='ar')
			$field = "observation";
		else
			$field = "observation_$lang";*/
		if(trim($this->note)!=''){
			$notes = explode(';',$this->note);
			$note = [];
			foreach($notes as $n)
				$note[] = str_replace('front.','',trans('front.'.$n));
			
			return implode(', ',$note);
		}else
			return '-';
    }
	
	
    
}