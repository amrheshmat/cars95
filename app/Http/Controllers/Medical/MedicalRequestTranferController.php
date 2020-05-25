<?php

namespace App\Http\Controllers\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalRequest;
use App\MedicalRequestDoc;
use App\statuses;
use App\helper\Notification;
use App\OrganizationMember;
use Auth;
use DB;
use File;
use Image;
use App\User;
class MedicalRequestTranferController extends Controller
{
      public function receive_request(Request $request,$id)
    {
         
        if(isset($request))
        {
            $docs = MedicalRequest::where('request_id',$id)->first();   
            //$_response['status_message_en'] = $request->provider_type_id;
            //$_response['id'] =  $id;
            //return response()->json($_response, 200);
            $docs->provider_type_id = $request->provider_type_id;
            $docs->username =  $request->user_provider_type_id;
            $docs->save();
                
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
       return redirect()->route('MedicalRequest.index');
        }   
    
    }
    
}
