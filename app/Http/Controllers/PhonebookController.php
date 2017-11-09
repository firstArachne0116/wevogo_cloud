<?php

namespace App\Http\Controllers;

use App\Model\PbContact;
use App\Model\WevoServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PhonebookController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if ($alert = Session::get('alert')) {
            $data['alert'] = $alert;
        }

        $data['wevoServersList'] = WevoServer::pluck('sn', 'id');
        $data['phonebookList'] = PbContact::paginate(10);
        return view('phonebook.index', $data);
    }

    public function sync(Request $request)
    {
        $fields = array
        (
            'priority'  => 'high',
        );


        $headers = array
        (
            'Content-Type: application/json'
        );

        $wevoServerId = $request->get('wevo_server_id');
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_exec($ch);
        $status = curl_getinfo($ch);
        curl_close($ch);
    }
}
