<?php
namespace App\Models;

class ChatMessage extends BaseModel
{
    public $table = "chat_messages";
    
    protected $fillable = [
        "chat_user_id",
        "user_id",
        "author",
        "message",
        "parent_id",
        "viewed"
    ];
}