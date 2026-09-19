<?php
namespace App\Models;

class Messagevac extends BaseModel
{
    public $table = "messagesvac";
    
    protected $fillable = [
        "name",
        "mobile",
        "email",
        "citizenship",
		
        "academic_degree",
        "field",
		
        "company",
        "period",
    ];
} 