<?php

namespace App\Http\Controllers\Api;

use App\Model\WevoUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Nexmo\Laravel\Facade\Nexmo;

class WevoUsersController extends Controller
{
    //
    public function index(Request $request)
    {
        /*$xml = XmlParser::load($request->all());*/

        /*return response()->xml(WevoUser::all());*/
        $statusCode = '';
        $requests = $request->all();
       /* Log::debug($requests);*/
        if (isset($requests['methodName'])) {
            if ($requests['methodName'] === 'is_phone_number_used') {
                /*return response()->xml(User::all());*/
                $params = $requests['params']['param'];
                $phoneNumber = $params[0]['value']['string'];
                /*$phoneNumber = substr($phoneNumber, 1);*/

                if (WevoUser::where('phone_number', $phoneNumber)->exists())
                    $statusCode = 'OK_ACCOUNT';
                else
                    $statusCode = 'NOK';

            } else if ($requests['methodName'] === 'recover_phone_account') {
                $params = $requests['params']['param'];
                $phoneNumber = $params[0]['value']['string'];
                /*$phoneNumber = substr($phoneNumber, 1);*/

                $email = $params[1]['value']['string'];
                $deviceType = $params[2]['value']['string'];
                $deviceToken = $params[3]['value']['string'];
                $wevoUser = WevoUser::where('phone_number', $phoneNumber)->where('email', $email)->first();
                if ($wevoUser !== null) {
                    $statusCode = 'OK';
                    try {
                        $rememberToken = generateRandomNumber(4);
                        $message = 'Wevogo says that Your verification code is ' . $rememberToken;

                        Nexmo::message()->send([
                            'to' => $phoneNumber,
                            'from' => 'WevoGo',
                            'text' => $message
                        ]);

                        $wevoUser->remember_token = $rememberToken;
                        $wevoUser->device_type = $deviceType;
                        $wevoUser->device_token = $deviceToken;
                        $wevoUser->save();
                    } catch ( \Exception $e ) {
                        $statusCode = 'ERROR_CANNOT_SEND_SMS';
                    }
                } else
                    $statusCode = 'ERROR_ACCOUNT_DOESNT_EXIST';
            } else if ($requests['methodName'] === 'activate_phone_account') {
                $params = $requests['params']['param'];
                $phoneNumber = $params[0]['value']['string'];
                $rememberToken = $params[2]['value']['string'];

                $wevoUser = WevoUser::where('phone_number', $phoneNumber)->where('remember_token', $rememberToken)->first();
                if ($wevoUser !== null) {
                    $statusCode = $wevoUser->extension . ',' . $wevoUser->secret . ',' . $wevoUser->freepbx_domain;
                    $wevoUser->is_verified = true;
                    $wevoUser->save();
                } else $statusCode = 'ERROR_ACCOUNT_DOESNT_EXIST';
            } else if ($requests['methodName'] === 'get_phone_number_for_account') {
                /*return response()->xml(User::all());*/
                $params = $requests['params']['param'];
                $phoneNumber = $params[0]['value']['string'];
                /*$phoneNumber = substr($phoneNumber, 1);*/

                if (WevoUser::where('phone_number', $phoneNumber)->exists())
                    $statusCode = 'ERROR_ALIAS_DOESNT_EXIST';
                else
                    $statusCode = 'ERROR_ACCOUNT_DOESNT_EXIST';

            } else if ($requests['methodName'] === 'create_phone_account') {
                /*return response()->xml(User::all());*/
                $params = $requests['params']['param'];
                $phoneNumber = $params[0]['value']['string'];
                /*$phoneNumber = substr($phoneNumber, 1);*/
                $email = $params[1]['value']['string'];
                $wevoUser = WevoUser::where('phone_number', $phoneNumber)->where('email', $email)->first();

                if ($wevoUser === null) {
                    $statusCode = 'OK';
                    $wevoUser = new WevoUser;
                    $wevoUser->wevo_user_id = 1;
                    $wevoUser->freepbx_id = 1;
                    $wevoUser->email = $email;
                    $wevoUser->phone_number = $phoneNumber;
                    $wevoUser->save();

                    try {
                        $rememberToken = generateRandomNumber(4);
                        $message = 'WevoGo says that Your verification code is ' . $rememberToken;

                        Nexmo::message()->send([
                            'to' => $phoneNumber,
                            'from' => 'WevoGo',
                            'text' => $message
                        ]);

                        $wevoUser->remember_token = $rememberToken;
                        $wevoUser->save();
                    } catch ( \Exception $e ) {
                        $statusCode = 'ERROR_CANNOT_SEND_SMS';
                    }

                } else
                    $statusCode = 'ERROR_ACCOUNT_ALREADY_IN_USE';

            }

            $content = view('api_response', compact('statusCode'));
            return response($content, 200)
                ->header('Content-Type', 'text/xml');
        }
    }

    public function create(Request $request)
    {
        $extension = $request->get('extension');
        $email = $request->get('email');
        $secret = $request->get('secret');
        $phoneNumber = $request->get('phone_number');
        $displayName = $request->get('display_name');
        $freepbxDomain = $request->get('freepbx_domain');

        $wevoUser = WevoUser::where('phone_number', $phoneNumber)
                                ->where('email', $email)->first();
        if ($wevoUser === null) {
            $wevoUser = new WevoUser;
            $wevoUser->email = $email;
            $wevoUser->phone_number = '+' . $phoneNumber;
            $wevoUser->wevo_user_id = 1;
            $wevoUser->freepbx_id = 1;
        }
        $wevoUser->extension = $extension;
        $wevoUser->secret = $secret;
        $wevoUser->display_name = $displayName;
        $wevoUser->freepbx_domain = $freepbxDomain;
        $wevoUser->save();
    }
}
