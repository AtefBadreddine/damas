<?php
namespace App\Models;

class Whatsappmsg extends BaseModel
{
    public $table = "whatsapp_msg";
    
    protected $fillable = [
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
        "navigation",
        "gclid",
        "download",
        "tags",
        "code",
        "deleted",
		"is_damas_net",
		"crm"
    ];
} 