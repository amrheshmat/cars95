<?php

namespace App\Http\Controllers\API\EngSyndicate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function request($serviceID,$oldRefID)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('Syndicate_Server')."/api/service?serviceID=$serviceID&oldRefID=$oldRefID",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
          ));
          
          $response = curl_exec($curl);
          
          curl_close($curl);
          return $response;
    }
}
