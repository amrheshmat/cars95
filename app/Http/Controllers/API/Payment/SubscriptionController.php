<?php

namespace App\Http\Controllers\API\Payment;

use App\User;
use App\Transaction;
use Ramsey\Uuid\Uuid;
use App\helper\Initiation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscriptionController extends Controller
{
    public function types(Request $request)
    {
        $curl = curl_init();        
        curl_setopt_array($curl, array(
          CURLOPT_URL => env('Syndicate_Server')."/api/services",
          CURLOPT_RETURNTRANSFER => true,
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


