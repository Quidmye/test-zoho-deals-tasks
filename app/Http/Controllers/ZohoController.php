<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use function Couchbase\defaultDecoder;

class ZohoController extends Controller
{
    public function auth(Request $request)
    {
        $uri = route('zohocrm');
        $clientid = env('ZOHO_CLIENT_ID');

        $redirectTo = 'https://accounts.zoho.com/oauth/v2/auth' . '?' . http_build_query(
                [
                    'client_id' => $clientid,
                    'redirect_uri' => $uri,
                    'scope' => 'ZohoCRM.modules.ALL',
                    'response_type' => 'code',
                ]);

        return redirect($redirectTo);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $contact_id = \Session::get('zoho_contact_id');
        $client_id = env('ZOHO_CLIENT_ID');
        $client_secret = env('ZOHO_CLIENT_SECRET');

        // Get ZohoCRM Token
        $tokenUrl = 'https://accounts.zoho.com/oauth/v2/token?code=' . $input["code"] . '&client_id=' . $client_id . '&client_secret=' . $client_secret . '&redirect_uri=' . route('zohocrm') . '&grant_type=authorization_code';

        $tokenData = [

        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 300);
        curl_setopt($curl, CURLOPT_POST, TRUE);//Regular post
        curl_setopt($curl, CURLOPT_URL, $tokenUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($tokenData));

        $tResult = curl_exec($curl);
        curl_close($curl);
        $tokenResult = json_decode($tResult);
        if (isset($tokenResult->access_token) && $tokenResult->access_token != '') {
            \Session::forget('zoho_token');
            \Session::put('zoho_token', $tokenResult->access_token);
            return redirect('/');
        } else {
            \Session::put('error', 'ZohoCRM token not generated, please try again.!!');
            return redirect('404');
        }
    }
}
