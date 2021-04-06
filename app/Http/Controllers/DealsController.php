<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DealsController extends Controller
{
    public function create()
    {
        return view('Zoho.deals.create', [
            'accounts' => $this->getAccounts(),
            'contacts' => $this->getContacts()
        ]);
    }

    public function createPost(Request $request)
    {
        $account = explode('-', $request->input('account'));
        $contact = explode('-', $request->input('contact'));
        $closingDate = new \DateTime($request->input('cdate'));

        $curl_pointer = curl_init();
        $curl_options = array();
        $url = "https://www.zohoapis.com/crm/v2/Deals";

        $curl_options[CURLOPT_URL] = $url;
        $curl_options[CURLOPT_RETURNTRANSFER] = true;
        $curl_options[CURLOPT_HEADER] = 1;
        $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";
        $requestBody = array();
        $recordArray = array();
        $recordObject = array();
        $recordObject["Deal_Name"] = $request->input('dname');
        $recordObject["Amount"] = $request->input('amount');
        $recordObject["Description"] = $request->input('description');
        $recordObject["Lead_Source"] = $request->input('lsource');
        $recordObject["Next_Step"] = $request->input('nstep');
        $recordObject["Probability"] = $request->input('probability');
        $recordObject["Stage"] = $request->input('stage');
        $recordObject["Type"] = $request->input('dtype');
        $recordObject["Closing_Date"] = $closingDate->format('Y-m-d');
        $recordObject["Account_Name"] = [
            'id' => $account[0],
            'name' => $account[1]
        ];
        $recordObject["Contact_Name"] = [
            'id' => $contact[0],
            'name' => $contact[1]
        ];


        $recordArray[] = $recordObject;
        $requestBody["data"] = $recordArray;
        $curl_options[CURLOPT_POSTFIELDS] = json_encode($requestBody);
        $headersArray = array();

        $headersArray[] = "Authorization" . ":" . "Zoho-oauthtoken " . \Session::get('zoho_token');

        $curl_options[CURLOPT_HTTPHEADER] = $headersArray;

        curl_setopt_array($curl_pointer, $curl_options);

        $result = curl_exec($curl_pointer);
        $responseInfo = curl_getinfo($curl_pointer);
        curl_close($curl_pointer);
        list ($headers, $content) = explode("\r\n\r\n", $result, 2);
        if (strpos($headers, " 100 Continue") !== false) {
            list($headers, $content) = explode("\r\n\r\n", $content, 2);
        }
        $headerArray = (explode("\r\n", $headers, 50));
        $headerMap = array();
        foreach ($headerArray as $key) {
            if (strpos($key, ":") != false) {
                $firstHalf = substr($key, 0, strpos($key, ":"));
                $secondHalf = substr($key, strpos($key, ":") + 1);
                $headerMap[$firstHalf] = trim($secondHalf);
            }
        }
        $jsonResponse = json_decode($content, true);
        if ($jsonResponse == null && $responseInfo['http_code'] != 204) {
            list ($headers, $content) = explode("\r\n\r\n", $content, 2);
            $jsonResponse = json_decode($content, true);
        }
        \Session::flash('succes', 'Deal succesful created!');
        return redirect()->route('dashboard');
    }

    private function getAccounts()
    {

        $curl_pointer = curl_init();

        $curl_options = array();
        $url = "https://www.zohoapis.com/crm/v2/Accounts?";
        $parameters = array();
        $parameters['fields'] = 'Account_Name,id';


        foreach ($parameters as $key => $value) {
            $url = $url . $key . "=" . $value . "&";
        }
        $curl_options[CURLOPT_URL] = $url;
        $curl_options[CURLOPT_RETURNTRANSFER] = true;
        $curl_options[CURLOPT_HEADER] = 1;
        $curl_options[CURLOPT_CUSTOMREQUEST] = "GET";
        $headersArray = array();
        $headersArray[] = "Authorization" . ":" . "Zoho-oauthtoken " . \Session::get('zoho_token');
        $curl_options[CURLOPT_HTTPHEADER] = $headersArray;

        curl_setopt_array($curl_pointer, $curl_options);

        $result = curl_exec($curl_pointer);
        $responseInfo = curl_getinfo($curl_pointer);
        curl_close($curl_pointer);
        list ($headers, $content) = explode("\r\n\r\n", $result, 2);
        if (strpos($headers, " 100 Continue") !== false) {
            list($headers, $content) = explode("\r\n\r\n", $content, 2);
        }
        $headerArray = (explode("\r\n", $headers, 50));
        $headerMap = array();
        foreach ($headerArray as $key) {
            if (strpos($key, ":") != false) {
                $firstHalf = substr($key, 0, strpos($key, ":"));
                $secondHalf = substr($key, strpos($key, ":") + 1);
                $headerMap[$firstHalf] = trim($secondHalf);
            }
        }
        $jsonResponse = json_decode($content, true);
        if ($jsonResponse == null && $responseInfo['http_code'] != 204) {
            list ($headers, $content) = explode("\r\n\r\n", $content, 2);
            $jsonResponse = json_decode($content, true);
        }
        return $jsonResponse['data'];

    }

    private function getContacts()
    {

        $curl_pointer = curl_init();

        $curl_options = array();
        $url = "https://www.zohoapis.com/crm/v2/Contacts?";
        $parameters = array();
        $parameters['fields'] = 'Full_Name,id';


        foreach ($parameters as $key => $value) {
            $url = $url . $key . "=" . $value . "&";
        }
        $curl_options[CURLOPT_URL] = $url;
        $curl_options[CURLOPT_RETURNTRANSFER] = true;
        $curl_options[CURLOPT_HEADER] = 1;
        $curl_options[CURLOPT_CUSTOMREQUEST] = "GET";
        $headersArray = array();
        $headersArray[] = "Authorization" . ":" . "Zoho-oauthtoken " . \Session::get('zoho_token');
        $curl_options[CURLOPT_HTTPHEADER] = $headersArray;

        curl_setopt_array($curl_pointer, $curl_options);

        $result = curl_exec($curl_pointer);
        $responseInfo = curl_getinfo($curl_pointer);
        curl_close($curl_pointer);
        list ($headers, $content) = explode("\r\n\r\n", $result, 2);
        if (strpos($headers, " 100 Continue") !== false) {
            list($headers, $content) = explode("\r\n\r\n", $content, 2);
        }
        $headerArray = (explode("\r\n", $headers, 50));
        $headerMap = array();
        foreach ($headerArray as $key) {
            if (strpos($key, ":") != false) {
                $firstHalf = substr($key, 0, strpos($key, ":"));
                $secondHalf = substr($key, strpos($key, ":") + 1);
                $headerMap[$firstHalf] = trim($secondHalf);
            }
        }
        $jsonResponse = json_decode($content, true);
        if ($jsonResponse == null && $responseInfo['http_code'] != 204) {
            list ($headers, $content) = explode("\r\n\r\n", $content, 2);
            $jsonResponse = json_decode($content, true);
        }
        return $jsonResponse['data'];

    }
}
