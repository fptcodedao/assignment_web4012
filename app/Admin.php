<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = ['id', 'full_name', 'avatar', 'story', 'email', 'username', 'password', 'token_hash', 'token_expired'];

    /**
     * foreign for post
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany(App\Post::class);
    }

    /**
     * foreign for page
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages(){
        return $this->hasMany(App\Page::class);
    }

    /**
     * foreign for log_sys
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(){
        return $this->hasMany(App\Log_sys::class);
    }

    /**
     * foreign for roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany(App\Role::class, 'role_admin');
    }
}
