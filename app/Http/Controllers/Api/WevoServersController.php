<?php

namespace App\Http\Controllers\Api;

use App\Model\WevoServer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WevoServersController extends Controller
{
    //

    public function index(Request $request) {
        $requests = $request->all();
         Log::debug($requests);
        if (isset($requests['methodName'])) {
            if ($requests['methodName'] === 'server_register') {
                /*return response()->xml(User::all());*/
                $params = $requests['params']['param'];
                $macAddress = $params[0]['value']['string'];
                $serialNumber = $params[1]['value']['string'];
                $dateTime = $params[2]['value']['string'];
                $wevoServer = WevoServer::where('mac_address', $macAddress)->where('sn', $serialNumber)->first();

                if ($wevoServer === null)
                    $wevoServer = new WevoServer;

                $wevoServer->mac_address = $macAddress;
                $wevoServer->sn = $serialNumber;
                $wevoServer->date_time = $dateTime;
                $wevoServer->save();

                $data['statusCode'] = 200;
                $data['wevoServerId'] = $wevoServer->id;
                $content = view('api_response', $data);
                return response($content, 200)
                    ->header('Content-Type', 'text/xml');
            }
        }
    }
}
