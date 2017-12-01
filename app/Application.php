<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    public function users()
    {
        return $this->belongsToMany('App\User', 'state_uses', 'id_app', 'id_users')
            ->withPivot('timeUse', 'quantity', 'lastUseTime')
            ->withTimestamps();
    }
}
