<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $table = 'comments';

    protected $fillable = ['user_id', 'post_id', 'content'];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts(){
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function getCreatedAtAttribute($date)
    {
        $locale = \App::getLocale();
        Carbon::setLocale($locale);
        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $now = Carbon::now();
        return $dt->diffForHumans($now);
    }

    protected $dates = ['deleted_at'];
}
