<?php

namespace App\Http\Controllers;

use App\Model\PbContact;
use App\Model\WevoServer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $wevoServerId = $request->get('wevo_server_id');
        $wevoServer = WevoServer::find($wevoServerId);
        $fields = array
        (

        );


        $headers = array
        (
            'Content-Type: application/json'
        );

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
        curl_setopt($ch, CURLOPT_URL, $wevoServer->domain . "/Phonebook/api/phonebook");

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        $data = json_decode(curl_exec($ch));
        $status = curl_getinfo($ch);
        curl_close($ch);
        $phonebooks = $data->phonebook;
        $wevoServerId = $data->wevoServerId;
        foreach ($phonebooks as $phonebook)
            $this->savePhonebook($phonebook, $wevoServerId);

        $alert['msg'] = 'Phonebook has been synced successfully';
        $alert['type'] = 'success';

        return redirect()->route('phonebook.index')->with('alert', $alert);
    }

    public function savePhonebook($phonebook, $wevoServerId)
    {
        $pbContact = PbContact::where('contact_id', $phonebook->Contact_ID)
            ->where('wevo_server_id', $wevoServerId)->first();
        if ($pbContact === null)
            $pbContact = new PbContact;
        $pbContact->contact_id = $phonebook->Contact_ID;
        $pbContact->last_name = $phonebook->LastName;
        $pbContact->first_name = $phonebook->FirstName;
        $pbContact->gender = $phonebook->Gender;
        $pbContact->mobile_number = $phonebook->MobileNo;
        $pbContact->address = $phonebook->Address;
        $pbContact->city = $phonebook->City;
        $pbContact->state = $phonebook->State;
        $pbContact->postal_code = $phonebook->PostalCode;
        $pbContact->country = $phonebook->Country;
        $pbContact->extension = $phonebook->Extension;
        $pbContact->email = $phonebook->Email;
        $pbContact->department_id = $phonebook->Department_ID;
        $pbContact->company_id = $phonebook->Company_ID;
        $pbContact->accessibility = $phonebook->Accessibility;
        $pbContact->stage = $phonebook->STAGE;
        $pbContact->wevo_server_id = $wevoServerId;
        $pbContact->save();
    }
}
