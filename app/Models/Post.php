<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable  = [
        'id', 'title', 'slug',
        'description', 'thumb_img', 'seo_title', 'seo_keyword',
        'seo_description', 'published', 'view', 'status',
    ];

    /**
     * get admin for posts
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(){
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    /**
     * get categories for posts
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category(){
        return $this->belongsToMany(Categories::class, 'category_posts');
    }

    /**
     * get tags for posts
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(){
        return $this->belongsToMany(Tag::class, 'tag_post');
    }
}
