<?php

namespace App\Http\Controllers\Api;

use App\Model\PbContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PhonebookController extends Controller
{
    //
    public function store(Request $request)
    {
        $pbContact = PbContact::where('contact_id', $request->get('Contact_ID'))
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
