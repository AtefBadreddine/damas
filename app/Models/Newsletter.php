<?php
namespace App\Models;

class Newsletter extends BaseModel
{
    public $table = "newsletter";
	
	protected $fillable = [
        "email",
		];
	
}