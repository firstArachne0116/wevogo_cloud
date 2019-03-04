<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Facades\File;

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
        if (!file_exists(public_path('pb_cron_history/1'))) {
            // path does not exist
            File::makeDirectory(public_path('pb_cron_history/1'), $mode = 0777, true, true);
        }
        $directory = public_path('pb_cron_history/1');
        $scanned_directory = array_values(array_diff(scandir($directory), array('..', '.')));
        var_dump($scanned_directory);
        /*File::put(public_path('pb_cron_history/1/test_1'), 'contents');*/
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
        /*$statusCode = 200;
        $content = view('api_response', compact('statusCode'))->render();
        print_r($content);*/

        return view('dashboard.index', $data);
    }
}
