<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
class ServicesController extends Controller
{
    //
    public function inquiry(Request $request){
        $validator = Validator::make($request->all(), ['OldRefID'=>'required|numeric',/*'ServiceGroupID'=>'required|numeric'*/]);
        if ($validator->fails()) {return response()->json($validator->errors(),422);}

        $curl = curl_init();        
        curl_setopt_array($curl, array(CURLOPT_URL => env('Syndicate_Server')."/api/annualSubscription?oldRefID=$request->OldRefID",
          CURLOPT_RETURNTRANSFER => true,CURLOPT_MAXREDIRS => 10,CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,CURLOPT_CUSTOMREQUEST => "GET",
        ));
        
        $response = curl_exec($curl);
        $response = json_decode($response,true);
        
        curl_close($curl);
        $result = array();
        if($response['status']['code'])
        {
            $result['OldRefID'] = $response['content']['oldRefID'];
            $result['name'] = isset($response['content']['name']) ? $response['content']['oldRefID'] : "غير معلوم";
            $result['datee'] = ' ';
            $result['paymentType'] = $response['content']['serviceId'];
            $result['date'] = $response['content']['birthdate'];
            $result['date'] = $response['content']['pensionYear'];
            $result['dateee'] = $response['content']['graduationYear'];
            $result['Message'] = ' ';
            $result['total_amount'] = $response['content']['receipt']['totalCharges'];
        }
        else{

        }
        return response()->json($result, 200); 

        // echo config('app.WS').'Service/inquiry/'.$request->ServiceGroupID.'/'.$request->OldRefID;
        // return '';
        // $json    = json_decode(file_get_contents(config('app.WS').'Service/inquiry/'.$request->ServiceGroupID.'/'.$request->OldRefID));    
        // if (is_string($json)){return Response()->json(['message'=>trans('neqabty.'.$json)],422);}
        return response()->json($result, 200);        
    }
}
