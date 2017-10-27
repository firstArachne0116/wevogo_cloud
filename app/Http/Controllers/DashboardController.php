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

        /*$xmlArray = [
            'methodName' => 'device_token',
            'params' => [
                'param1' => [
                    0 => [
                        'value' => array(
                            'string' => 'test'
                        )
                    ],
                    1 => [
                        'value' => [
                            'string' => 'test1'
                        ]
                    ],
                    2 => [
                        'value' => [
                            'string' => 'test2'
                        ]
                    ],
                ]
            ]
        ];

        $xmlContent = ArrayToXml::convert($xmlArray, 'methodCall');
        print_r( $xmlContent);*/

        return view('dashboard.index', $data);
    }
}
