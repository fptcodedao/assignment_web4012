<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{

    use Notifiable;

    protected $guard = 'admins';

    protected $fillable = ['id', 'full_name', 'avatar', 'story', 'email', 'username', 'password', 'token_hash', 'token_expired'];


    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * foreign for post
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }

    /**
     * foreign for page
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages(){
        return $this->hasMany(Page::class);
    }

    /**
     * foreign for log_sys
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs(){
        return $this->hasMany(Log_sys::class);
    }

    /**
     * foreign for roles
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(){
        return $this->belongsToMany(Role::class, 'role_admin');
    }
}
