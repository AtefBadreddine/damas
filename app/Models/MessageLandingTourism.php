<?php
namespace App\Models;

class MessageLandingTourism extends BaseModel
{
    public $table = "messages_landing_tourism";
    
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
        "zoho",
        "navigation",
        "lang",
        "send_email",
        "gclid",
        "tags",
		"whatsapp_id",
		"insert_crm",
		"search_fields",
		"code",
		"is_damas_net",
    ];
} 