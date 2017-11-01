<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WevoUser extends Model
{
    //
    public function wevoDevice()
    {
        return $this->hasOne('App\Model\WevoDevice');
    }

    public function wevoServer()
    {
        return $this->belongsTo('App\Model\WevoServer');
    }
}
