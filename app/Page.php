<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable  = [
        'id', 'title', 'slug',
        'description', 'thumb_img', 'seo_title', 'seo_keyword',
        'seo_description', 'published', 'view', 'status',
    ];

    /**
     * get admin for page
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(){
        return $this->belongsTo(App\Admin::class, 'admin_id');
    }

    /**
     * get tag for page
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tages(){
        return $this->belongsToMany(App\Tag::class, 'tag_page');
    }
}
