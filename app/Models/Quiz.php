<?php
namespace App\Models;

class Quiz extends BaseModel
{
    public $table = "quizs";
    
    protected $fillable = [
        "familymembers",
		"name",
        "fame",
        "email",
        "mobile",
        "country",
        "communication_time",
        "budget",
        "message",
        "src",
        "full_src",
        "page",
        "device",
        "device_type",
        "browser",
        "platform",
        "ip",
        "form_type",
        "manual_insert",
        "zoho",
        "navigation",
        "lang",
        "send_email",
        "gclid",
        "tags",
		"whatsapp_id",
		"share",
    ];
} 