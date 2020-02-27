<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Categories extends Model
{
    use Sluggable, SoftDeletes;
    protected $table = 'categories';

    protected $fillable = [
        'id', 'name', 'slug', 'description', 'thumb_img', 'parent_id', 'status'
    ];


    public function posts(){
        return $this->belongsToMany(Post::class, 'category_posts', 'category_id', 'post_id');
    }

    public function child(){
        return $this->hasMany(Categories::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
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

    protected $dates = ['deleted_at'];
}
