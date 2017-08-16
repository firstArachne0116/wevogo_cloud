<?php

namespace App\Http\Controllers\Api;

use App\Model\WevoUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Aloha\Twilio\Twilio;

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

                $content = view('api_response', compact('statusCode'));
                return response($content, 200)
                    ->header('Content-Type', 'text/xml');
            } else if ($requests['methodName'] === 'recover_phone_account') {
                $params = $requests['params']['param'];
                $phoneNumber = $params[0]['value']['string'];
                /*$phoneNumber = substr($phoneNumber, 1);*/

                $email = $params[1]['value']['string'];
                $wevoUser = WevoUser::where('phone_number', $phoneNumber)->where('email', $email)->first();
                if ($wevoUser !== null) {
                    $statusCode = 'OK';
                    try {
                        $rememberToken = generateRandomNumber(4);
                        $message = 'Wevo says that Your verification code is ' . $rememberToken;

                        $twilio = new Twilio(getenv('TWILIO_SID'), getenv('TWILIO_TOKEN'), getenv('TWILIO_FROM'));
                        $twilio->message($phoneNumber, $message);

                        $wevoUser->remember_token = $rememberToken;
                        $wevoUser->save();
                    } catch ( \Services_Twilio_RestException $e ) {
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
                    $statusCode = $wevoUser->username . ',' . $wevoUser->password . ',' . $wevoUser->freepbx_domain;
                    $wevoUser->is_verified = true;
                    $wevoUser->save();
                } else $statusCode = 'ERROR_ACCOUNT_DOESNT_EXIST';
            }

            $content = view('api_response', compact('statusCode'));
            return response($content, 200)
                ->header('Content-Type', 'text/xml');
        }
    }
}
