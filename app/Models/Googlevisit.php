<?php
namespace App\Models;
use LaravelLocalization;
class Googlevisit extends BaseModel
{
    public $table = "googlevisits";
    
    protected $fillable = [
        "post_id",
        "visit_date",
        "visit_count",
        "cat_ids"
    ];

}