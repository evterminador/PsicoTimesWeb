<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    public function users()
    {
        return $this->belongsToMany('App\User', 'state_uses', 'app_id', 'user_id')
            ->withPivot('time_use', 'quantity', 'last_use_time')
            ->withTimestamps();
    }
}
