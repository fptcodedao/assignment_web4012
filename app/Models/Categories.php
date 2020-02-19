<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id', 'name', 'slug', 'description', 'thumb_img', 'parent_id', 'status'
    ];

    public $timestamps = false;

    public function posts(){
        return $this->belongsToMany(Post::class, 'category_posts');
    }

    public function child(){
        return $this->hasMany(Categories::class, 'parent_id');
    }
}
