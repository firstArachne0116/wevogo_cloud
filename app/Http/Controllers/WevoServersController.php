<?php

namespace App\Http\Controllers;

use App\Model\WevoServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class WevoServersController extends Controller
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

        $data['wevoServers'] = WevoServer::paginate(10);
        return view('wevo-servers.index', $data);
    }

    public function create()
    {
        return view('wevo-servers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), WevoServer::$rules, WevoServer::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $this->saveWevoServer($request);

            $alert['msg'] = 'One Wevo Server has been stored successfully';
            $alert['type'] = 'success';


            return redirect()->route('wevo-servers.index')->with('alert', $alert);
        }
    }

    public function edit($id)
    {
        $data['wevoServer'] = WevoServer::find($id);
        return view('wevo-servers.edit', $data);
    }

    public function update($id, Request $request)
    {
        $wevoServer = WevoServer::find($id);
        $validator = Validator::make($request->all(), WevoServer::$rules, WevoServer::$messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $this->saveWevoServer($request, $wevoServer);

            $alert['msg'] = 'Wevo Server has been updated successfully';
            $alert['type'] = 'success';


            return redirect()->route('wevo-servers.index')->with('alert', $alert);
        }
    }

    private function saveWevoServer($request, $wevoServer=null)
    {
        if ($wevoServer === null)
            $wevoServer = new WevoServer;

        $wevoServer->date_time = $request->get('date_time');
        $wevoServer->sn = $request->get('sn');
        $wevoServer->mac_address = $request->get('mac_address');
        $wevoServer->save();
    }
}
