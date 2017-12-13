<?php

namespace App\Http\Controllers\Api;

use App\Model\PbContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PhonebookController extends Controller
{
    //
    public function index()
    {

        /* response to phone */
        $phonebooks = PbContact::all();
        return response()->json($phonebooks, 200);
    }
    public function store(Request $request)
    {
        /* receive from phonebook */
        $this->savePbContact($request->get('Contact_ID'), $request);
    }

    public function update($id, Request $request)
    {
        $this->savePbContact($id, $request);

    }
    public function destroy($id, Request $request)
    {
        Log::debug($id);
        PbContact::where('contact_id', $id)
            ->where('wevo_server_id', $request->get('wevo_server_id'))->delete();

        return response()->json(['result' => 'success'], 200);
    }

    private function savePbContact($contactId, $request)
    {
        $pbContact = PbContact::where('contact_id', $contactId)
            ->where('wevo_server_id', $request->get('wevo_server_id'))->first();
        if ($pbContact === null)
            $pbContact = new PbContact;
        $pbContact->contact_id = $request->get('Contact_ID');
        $pbContact->last_name = $request->get('LastName');
        $pbContact->first_name = $request->get('FirstName');
        $pbContact->gender = $request->get('Gender');
        $pbContact->mobile_number = $request->get('MobileNo');
        $pbContact->address = $request->get('Address');
        $pbContact->city = $request->get('City');
        $pbContact->state = $request->get('State');
        $pbContact->postal_code = $request->get('PostalCode');
        $pbContact->country = $request->get('Country');
        $pbContact->extension = $request->get('Extension');
        $pbContact->email = $request->get('Email');
        $pbContact->department_id = $request->get('Department_ID');
        $pbContact->company_id = $request->get('Company_ID');
        $pbContact->accessibility = $request->get('Accessibility');
        $pbContact->stage = $request->get('STAGE');
        $pbContact->wevo_server_id = $request->get('wevo_server_id');
        $pbContact->save();
        Log::debug($request->get('Contact_ID'));
    }
}
