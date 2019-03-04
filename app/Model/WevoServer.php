<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WevoServer extends Model
{
    //
    public static $rules = [
        'date_time' => 'required',
        'sn' => 'required',
        'mac_address' => 'required|max:100',
    ];

    public static $messages = [
        'date_time.required' => 'Date Time is required',
        'sn.required' => 'SN is required',
        'mac_address.required' => 'MAC Address is required'
    ];
}
