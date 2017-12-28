<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $table = "historics";

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
