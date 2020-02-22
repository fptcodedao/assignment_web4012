<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log_sys extends Model
{
    protected $table = 'log_sys';

    protected $fillable = [
        'id', 'admin_id', 'type', 'description'
    ];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
