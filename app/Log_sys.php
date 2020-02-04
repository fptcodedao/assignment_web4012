<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log_sys extends Model
{
    protected $table = 'log_sys';

    protected $fillable = [
        'id', 'admin_id', 'type', 'description'
    ];

    public function admin(){
        return $this->belongsTo(App\Admin::class);
    }
}
