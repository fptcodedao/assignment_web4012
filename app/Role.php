<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'id', 'name', 'slug', 'permission'
    ];
    protected $casts = [
        'permissions' => 'array',
    ];
}
