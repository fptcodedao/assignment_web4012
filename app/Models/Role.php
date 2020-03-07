<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Sluggable;
    protected $table = 'roles';

    protected $fillable = [
        'id', 'name', 'slug', 'permissions'
    ];
    protected $casts = [
        'permissions' => 'array',
    ];

    public function admins(){
        return $this->belongsToMany(Admin::class, 'role_admin');
    }

    /**
     * @param array $permissions
     * @return bool
     */
    public function hasAccess(array $permissions): bool
    {
        foreach($permissions as $permission){
            if ($this->hasPermission($permission)){
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * check exists permission
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $permission){
        return $this->permissions[$permission] ?? false;
    }
}
