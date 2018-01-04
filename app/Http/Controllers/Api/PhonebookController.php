<?php

namespace App\Http\Controllers\Api;

use App\Model\PbContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class PhonebookController extends Controller
{
    //
    public function index()
    {

        /* response to phone */
        $phonebooks = PbContact::all();
        $result['result'] = $phonebooks;
        return response()->json($result, 200);
    }
    public function store(Request $request)
    {
        /* receive from phonebook */
        $this->savePbContact($request->get('Contact_ID'), $request, 'add');
    }

    public function update($id, Request $request)
    {
        $this->savePbContact($id, $request, 'edit');

    }
    public function destroy($id, Request $request)
    {
        $wevoServerId = $request->get('wevo_server_id');
        $pbContact = PbContact::where('contact_id', $id)
            ->where('wevo_server_id', $request->get('wevo_server_id'));

        if ($pbContact->delete())
            $this->createCronLog($wevoServerId . '/' . 'delete_' . $id);

        return response()->json(['result' => 'success'], 200);
    }

    public function actionHistory(Request $request)
    {
        $wevoServerId = $request->get('wevo_server_id');
        $pbxActionHistory = $request->get('action_history');

        if (!file_exists(public_path('pb_cron_history/' . $wevoServerId)))
            File::makeDirectory(public_path('pb_cron_history/' . $wevoServerId), $mode = 0777, true, true);

        $directory = public_path('pb_cron_history/' . $wevoServerId);
        $scanned_directory = array_values(array_diff(scandir($directory), array('..', '.')));
        return response()->json($scanned_directory, 200);
    }

    public function syncAll(Request $request)
    {
        Log::debug( $request->all());
        $wevoServerId = $request->get('wevo_server_id');
        $contacts = $request->get('contacts');
        PbContact::truncate();
        foreach ($contacts as $contact) {
            $pbContact = new PbContact;
            $pbContact->contact_id = $contact['Contact_ID'];
            $pbContact->last_name = $contact['LastName'];
            $pbContact->first_name = $contact['FirstName'];
            $pbContact->gender = $contact['Gender'];
            $pbContact->mobile_number = $contact['MobileNo'];
            $pbContact->address = $contact['Address'];
            $pbContact->city = $contact['City'];
            $pbContact->state = $contact['State'];
            $pbContact->postal_code = $contact['PostalCode'];
            $pbContact->country = $contact['Country'];
            $pbContact->extension = $contact['Extension'];
            $pbContact->email = $contact['Email'];
            $pbContact->department_id = $contact['Department_ID'];
            /*$pbContact->company_id = $contact['Company_ID'];*/
            $pbContact->accessibility = $contact['Accessibility'];
            $pbContact->stage = $contact['STAGE'];
            $pbContact->wevo_server_id = $wevoServerId;
            $pbContact->save();
        }

        if (!file_exists(public_path('pb_cron_history/' . $wevoServerId)))
            File::makeDirectory(public_path('pb_cron_history/' . $wevoServerId), $mode = 0777, true, true);

        if (!file_exists(public_path('pb_cron_history/' . $wevoServerId . '/new')))
        {
            File::put(public_path('pb_cron_history/' . $wevoServerId . '/new'), 'Log');
            return response()->json(['result' => 'success'], 200);
        }
    }
    private function savePbContact($contactId, $request, $action)
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
        /*$pbContact->company_id = $request->get('Company_ID');*/
        $pbContact->accessibility = $request->get('Accessibility');
        $pbContact->stage = $request->get('STAGE');
        $pbContact->wevo_server_id = $request->get('wevo_server_id');

        if ($pbContact->save() && $request->get('create_history') === 'yes') {
            if (!file_exists(public_path('pb_cron_history/' . $pbContact->wevo_server_id)))
                File::makeDirectory(public_path('pb_cron_history/' . $pbContact->wevo_server_id), $mode = 0777, true, true);

            $this->createCronLog($pbContact->wevo_server_id . '/' . $action . '_' . $pbContact->contact_id);
        }
    }
    private function createCronLog($fileName)
    {
        File::put(public_path('pb_cron_history/' . $fileName), 'Log');
    }
}
