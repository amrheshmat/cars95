<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\ComplaintRequest;

class ReceiveComplaintRequestController extends Controller
{
      public function receive_request(Request $request)
    {
        # code
        if(isset($request))
        {
            if(isset($request->full_name) && isset($request->phone) 
               && isset($request->email) && isset($request->describtion))
            {
                # code
                $complaintRequest = new ComplaintRequest(); 
                $complaintRequest->name = isset($request->full_name) ? $request->full_name : "";
                $complaintRequest->phone  = isset($request->phone) ? $request->phone : 0;
                $complaintRequest->email = isset($request->email) ? $request->email : "";
               // $complaintRequest->mobile_token = isset($request->mobile_token) ? $request->mobile_token : "";
                $complaintRequest->status     = 0;
                $complaintRequest->describtion     = isset($request->describtion) ? $request->describtion : "";

                if($complaintRequest->save()){
                     $_response['status'] = 200;
                    $_response['status_message_en'] = "thanks , we will response you soon";
                    $_response['status_message_ar'] = "تم إستلام طلبكم بنجاح وسيتم الرد عليكم خلال 48 ساعة";
                    return redirect()->route('home');//response()->json($_response, 200);
                }else{
                    $_response['status'] = 200;
                    $_response['status_message_en'] = "Error , please try again";
                    $_response['status_message_ar'] = "حدث خطأ برجاء المحاولة مرة اخرى";
                    return response()->json($_response, 200);
                }
            }else{
                $response['status']  = 200;
                $response['status_message_ar'] = 'missed paramters in json';
                $response['status_message_en'] = 'missed paramters in json';
                return response()->json($response, 200);
            }
        }
        else{
            $response['status']  = 200;
            $response['status_message_ar'] = 'missed request';
            $response['status_message_en'] = 'missed request';
            return response()->json($response, 200);
        }
    }
}
