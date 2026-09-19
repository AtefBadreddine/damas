<?php
namespace App\Models;

class Message2 extends BaseModel
{
    public $table = "messages2";
    
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
		"is_damas_net",

		"free_tour_form",
		"arrival_date",
		"tour_type",
		"ccountry"
    ];
} 