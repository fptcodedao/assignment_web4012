<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
class Post extends Model
{
    use Sluggable, SoftDeletes;
    protected $table = 'posts';

    protected $fillable  = [
        'id', 'title', 'slug',
        'description', 'thumb_img', 'seo_title', 'seo_keyword',
        'seo_description', 'published', 'view', 'status', 'admin_id'
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
        return $this->belongsToMany(Categories::class, 'category_posts', 'post_id', 'category_id');
    }

    /**
     * get tags for posts
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags(){
        return $this->belongsToMany(Tag::class, 'tag_post');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function getCreatedAtAttribute($date)
    {
        $locale = \App::getLocale();
        Carbon::setLocale($locale);
        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $now = Carbon::now();
        return $dt->diffForHumans($now);
    }

    /**
     * @inheritDoc
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $dates = ['deleted_at'];
}
