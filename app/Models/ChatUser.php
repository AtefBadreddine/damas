<?php
namespace App\Models;

class ChatUser extends BaseModel
{
    public $table = "chat_users";
    
    protected $fillable = [
        "name",
        "email",
        "mobile"
    ];
}