<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];

        /*$input = array(
            'methodName' => 'device_token',
            'params' => array(
                'para' => array(
                    0 => array(
                        'value' => array(
                            'string' => '1.png'
                        )
                    ),
                    1 => array(
                        'value' => array(
                            'string' => '1.png'
                        )
                    ),
                )
            )
        );
        print ArrayToXml::convert($input, 'methodCall');*/

        return view('dashboard.index', $data);
    }
}
