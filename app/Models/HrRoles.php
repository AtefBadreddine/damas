<?php
namespace App\Models;

use LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Model;
class HrRoles extends BaseModel
{
	
	protected $connection = 'mysql_crm';
	public $table = "hr_roles";
    protected $fillable = [
		"name",
		"report_to",
		"job_title_ar",
		"job_title_en",
		"section",
		"commission",
		"published",
		"updated_by",
		"created_by",
		"updated_at",
		"created_at",
		"deleted"
    ];



}