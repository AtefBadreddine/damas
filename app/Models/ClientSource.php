<?php
namespace App\Models;

class ClientSource extends BaseModel
{
    public $table = "client_source";
    
    protected $fillable = [
        "src",
        "code"
    ];
}