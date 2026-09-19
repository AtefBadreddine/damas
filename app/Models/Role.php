<?php
namespace App\Models;

use Bican\Roles\Traits\Slugable;
use Illuminate\Database\Eloquent\Model;
use Bican\Roles\Traits\RoleHasRelations;
use Bican\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;

class Role extends BaseModel implements RoleHasRelationsContract
{
    use Slugable, RoleHasRelations;
    
    public $table = "roles";
    
    protected $fillable = [
        "name",
        "slug",
    ];
    
    public function permissions()
    {
        return $this->belongsToMany("App\Models\Permission", "permission_role");
    }
    
}