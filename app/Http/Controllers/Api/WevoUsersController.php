<?php

namespace App\Http\Controllers\Api;

use App\Model\WevoDevice;
use App\Model\WevoUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Nexmo\Laravel\Facade\Nexmo;
use Spatie\ArrayToXml\ArrayToXml;

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
                $wevoUser = WevoUser::where('phone_number', $phoneNumber)->where('email', $email)->first();
                if ($wevoUser !== null) {
                    $statusCode = 'OK';
                    try {
                        $rememberToken = generateRandomNumber(4);
                        $message = 'Wevogo says that Your verification code is ' . $rememberToken;

                        /*Nexmo::message()->send([
                            'to' => $phoneNumber,
                            'from' => 'WevoGo',
                            'text' => $message
                        ]);*/

                        $wevoUser->remember_token = $rememberToken;
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
                $deviceType = $params[3]['value']['string'];
                $deviceToken = $params[4]['value']['string'];
                $wevoUser = WevoUser::where('phone_number', $phoneNumber)->where('remember_token', $rememberToken)->first();
                if ($wevoUser !== null) {
                    $wevoDevice = $wevoUser->wevoDevice;
                    $statusCode = $wevoDevice->acc_uname . ',' . $wevoDevice->acc_secret . ',' . $wevoUser->wevopbx_local_domain;
                    $wevoUser->is_verified = true;
                    $wevoUser->save();

                    $wevoDevice->device_type = $deviceType;
                    $wevoDevice->device_token = $deviceToken;
                    $wevoDevice->save();

                    $this->sendDeviceTokenToPbx($wevoUser);
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
                    $wevoUser->wevo_server_id = 1;
                    $wevoUser->email = $email;
                    $wevoUser->phone_number = $phoneNumber;
                    $wevoUser->save();

                    try {
                        $rememberToken = generateRandomNumber(4);
                        $message = 'WevoGo says that Your verification code is ' . $rememberToken;

                        /*Nexmo::message()->send([
                            'to' => $phoneNumber,
                            'from' => 'WevoGo',
                            'text' => $message
                        ]);*/

                        $wevoUser->remember_token = $rememberToken;
                        $wevoUser->save();
                    } catch ( \Exception $e ) {
                        $statusCode = 'ERROR_CANNOT_SEND_SMS';
                    }

                } else
                    $statusCode = 'ERROR_ACCOUNT_ALREADY_IN_USE';

            } else if ($requests['methodName'] === 'get_provision_settings') {
                Log::debug($request->all());
                $params = $requests['params']['param'];
                $phoneNumber = $params['value']['string'];
                $wevoUser = WevoUser::where('phone_number', $phoneNumber)->first();
                if ($wevoUser === null) {
                    $statusCode = 'ERROR_ACCOUNT_DOESNT_EXIST';
                } else if ($wevoUser->extension === null) {
                    $statusCode = 'ERROR_ACCOUNT_IS_NOT_PROVISIONED_YET';
                } else {
                    $wevoDevice = $wevoUser->wevoDevice;
                    $statusCode = $wevoDevice->acc_uname . ',' . $wevoDevice->acc_secret . ',' . $wevoUser->wevopbx_local_domain;
                }

            }

            $content = view('api_response', compact('statusCode'));
            return response($content, 200)
                ->header('Content-Type', 'text/xml');
        }
    }

    public function create(Request $request)
    {
        $requests = $request->all();
        if (isset($requests['methodName'])) {
            if ($requests['methodName'] === 'wevo_user_info') {
                /*return response()->xml(User::all());*/
                $params = $requests['params']['param'];
                $wevoServerId = is_array($params[0]['value']['string']) ? '' : $params[0]['value']['string'];
                $wevopbxDomain = is_array($params[1]['value']['string']) ? '' : $params[1]['value']['string'];
                $wevopbxLocalDomain = $params[2]['value']['string'];
                $extension = $params[51]['value']['string'];
                $phoneNumber = $params[52]['value']['string'];
                $email = $params[53]['value']['string'];
                $displayName = $params[54]['value']['string'];

                $wevoUser = WevoUser::where('phone_number', $phoneNumber)
                    ->where('email', $email)->first();
                if ($wevoUser === null) {
                    $wevoUser = new WevoUser;
                    $wevoUser->email = $email;
                    $wevoUser->phone_number = '+' . $phoneNumber;
                    $wevoUser->wevo_server_id = $wevoServerId;
                    $wevoDevice = new WevoDevice;
                } else $wevoDevice = $wevoUser->wevoDevice;

                $wevoUser->extension = $extension;
                $wevoUser->display_name = $displayName;
                $wevoUser->wevopbx_local_domain = $wevopbxLocalDomain;
                $wevoUser->wevopbx_domain = $wevopbxDomain;

                $wevoUser->save();

                $wevoDevice->wevo_user_id = $wevoUser->id;
                $wevoDevice->acc_uname = $params[3]['value']['string'];
                $wevoDevice->acc_auth = is_array($params[4]['value']['string']) ? '' : $params[4]['value']['string'];
                $wevoDevice->acc_secret = $params[5]['value']['string'];
                $wevoDevice->acc_transport = $params[6]['value']['string'];
                $wevoDevice->acc_proxy = is_array($params[7]['value']['string']) ? '' : $params[7]['value']['string'];
                $wevoDevice->acc_proxy_enable = $params[8]['value']['string'];
                $wevoDevice->acc_reg_expire = $params[9]['value']['string'];
                $wevoDevice->acc_prefix = is_array($params[10]['value']['string']) ? '' : $params[10]['value']['string'];
                $wevoDevice->acc_avpf_enable = $params[11]['value']['string'];
                $wevoDevice->acc_avpf_interval = $params[12]['value']['string'];
                $wevoDevice->acc_plus_00 = $params[13]['value']['string'];
                $wevoDevice->acc_disableac = $params[14]['value']['string'];
                $wevoDevice->audio_eco_can_enable = $params[15]['value']['string'];
                $wevoDevice->audio_adp_rate_enable = $params[16]['value']['string'];
                $wevoDevice->audio_codec_rate_lim = $params[17]['value']['string'];
                $wevoDevice->audio_codec = $params[18]['value']['string'];
                $wevoDevice->video_enable = $params[19]['value']['string'];
                $wevoDevice->video_always_initiate = $params[20]['value']['string'];
                $wevoDevice->video_always_accept = $params[21]['value']['string'];
                $wevoDevice->video_preset = $params[22]['value']['string'];
                $wevoDevice->video_size = $params[23]['value']['string'];
                $wevoDevice->video_overlay = $params[24]['value']['string'];
                $wevoDevice->video_codec = $params[25]['value']['string'];
                $wevoDevice->call_use_internal_ringtone = $params[26]['value']['string'];
                $wevoDevice->call_media_encryption = $params[27]['value']['string'];
                $wevoDevice->call_dtmf_sipinfo_enable = $params[28]['value']['string'];
                $wevoDevice->call_dtmf_rfc2833_enable = $params[29]['value']['string'];
                $wevoDevice->call_auto_answer_enable = $params[30]['value']['string'];
                $wevoDevice->call_vm_uri = $params[31]['value']['string'];
                $wevoDevice->chat_encrypt_enable = $params[32]['value']['string'];
                $wevoDevice->chat_share_server = $params[33]['value']['string'];
                $wevoDevice->net_wifi_only = $params[34]['value']['string'];
                $wevoDevice->net_dmode_enable = $params[35]['value']['string'];
                $wevoDevice->net_stun_turn_server = is_array($params[36]['value']['string']) ? '' : $params[36]['value']['string'];
                $wevoDevice->net_ice_enable = $params[37]['value']['string'];
                $wevoDevice->net_turn_enable = $params[38]['value']['string'];
                $wevoDevice->net_stun_turn_uname = is_array($params[39]['value']['string']) ? '' : $params[39]['value']['string'];
                $wevoDevice->net_stun_turn_pass = is_array($params[40]['value']['string']) ? '' : $params[40]['value']['string'];
                $wevoDevice->net_rnd_ports_enable = $params[41]['value']['string'];
                $wevoDevice->net_sip_port = is_array($params[42]['value']['string']) ? '' : $params[42]['value']['string'];
                $wevoDevice->net_push_notify_enable = $params[43]['value']['string'];
                $wevoDevice->net_ipv6_allow = $params[44]['value']['string'];
                $wevoDevice->adv_flist_subs_enable = $params[45]['value']['string'];
                $wevoDevice->adv_bg_enable = $params[46]['value']['string'];
                $wevoDevice->adv_svc_notify_enable = $params[47]['value']['string'];
                $wevoDevice->adv_boot_start = $params[48]['value']['string'];
                $wevoDevice->adv_pa_dname = is_array($params[49]['value']['string']) ? '' : $params[49]['value']['string'];;
                $wevoDevice->adv_pa_uname = is_array($params[50]['value']['string']) ? '' : $params[50]['value']['string'];
                $wevoDevice->save();

                $statusCode = 200;

                $xmlArray = [
                    'methodCall' => [
                        'methodName' => 'device_token',
                        'params' => [
                            0 => [
                                'param' => [
                                    'value' => [ 'string' => $wevoDevice->acc_uname],
                                ]
                            ],
                            1 => [
                                'param' => [
                                    'value' => [ 'string' => $wevoDevice->device_type],
                                ]
                            ],
                            2 => [
                                'param' => [
                                    'value' => [ 'string' => $wevoDevice->device_token],
                                ]
                            ],
                        ]
                    ]
                ];
                $xmlContent = ArrayToXml::convert($xmlArray);

                return response($xmlContent, 200)
                    ->header('Content-Type', 'text/xml');
            }
        }

    }

    public function sendDeviceTokenToPbx($wevoUser)
    {
        $headers = array(
            "Content-type: text/xml",
        );
        $deviceToken = $wevoUser->wevoDevice->device_token;
        $deviceUserName = $wevoUser->wevoDevice->acc_uname;
        $deviceType = $wevoUser->wevoDevice->device_type;

        $xmlArray = [
            'methodCall' => [
                'methodName' => 'device_token',
                'params' => [
                    0 => [
                        'param' => [
                            'value' => [ 'string' => $deviceUserName],
                        ]
                    ],
                    1 => [
                        'param' => [
                            'value' => [ 'string' => $deviceType],
                        ]
                    ],
                    2 => [
                        'param' => [
                            'value' => [ 'string' => $deviceToken],
                        ]
                    ],
                ]
            ]
        ];

        $xmlContent = ArrayToXml::convert($xmlArray);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    # required for https urls
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, config('services.wevopbx_url') . "/wevogo/");

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlContent);
        curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
    }

    public function destroy($extension)
    {
        WevoUser::where('extension', $extension)->delete();
    }
}
