<?php
namespace App\Models;

class Company extends BaseModel
{
    public $table = "companies";
    
    protected $fillable = [
		"company_name",
		"establishment_year",
		"under_cons_projects",
		"ready_projects",
		"finishing_quality",
		"external_expansion",
		"delayed_projects",
		"link",
    ];
}