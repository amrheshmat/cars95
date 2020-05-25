<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalRequestDoc;
use App\MobileUser;
use App\tripRequest;
use App\tripRequestDoc;
use App\EngineeringRecordRequest;
use App\OrganizationMember;
use Validator;
use DB;

class NotificationController extends Controller
{
    //TEST
    public function countUnread(Request $request){
        $validator = Validator::make($request->all(), ['user_number'=>'required:organization_members,user_number']);        
        if ($validator->fails()) {return response()->json($validator->errors(),422);}    
        $count = \App\Notification::where('user_number',$request->user_number)->where('mobile_view',0)->count();  
        return response()->json(array('value' => "$count"), 200);
    }
    public function list(Request $request){
        $validator = Validator::make($request->all(), ['user_number'=>'required:organization_members,user_number']);
        if ($validator->fails()) {return response()->json($validator->errors(),422);}    
        $json = \App\Notification::where('user_number',$request->user_number)->orderBy('created_at','DESC')->get();
        return response()->json($json, 200);  
    }
    public function show(Request $request,$id){
        $validator = Validator::make($request->all(), ['notification_type'=>'required']);
        if ($validator->fails()) {return response()->json($validator->errors(),422);}
        $result = ['message'=>'can\'t define  notification type'];   
        if($request->notification_type == 1){
            $result = $this->medicalRequest($id);
        }elseif($request->notification_type == 2){
            $result = $this->tripRequest($id);   
        }elseif($request->notification_type == 3){
            $result = $this->EngineeringRecord($id);   
        }
        return response()->json($result, 200);
    }







    
    // END TEST

// old must to delete
    public function getNotification(Request $request)
    {
        if(isset($request->service_id) && isset($request->type) && isset($request->user_number))
        {
            switch ($request->service_id) {
                case 1:
                    # Trips
                    if($request->type == 1) 
                    {
                        # Get one Request                       
                        if(isset($request->request_id))
                        {
                            return $result = $this->tripRequest($request->request_id);
                            // return response()->json($result, 200);
                        }
                        else{
                            $response['status']  = 200;
                            $response['status_message_en'] = 'missed paramters';
                            $response['status_message_ar'] = 'حقول ناقصة';
                            return response()->json($response, 200);
                        }
                    }
                    else if($request->type == 2){
                        # Get All Request 
                        $result = $this->tripRequests($request->user_number);
                        return response()->json($result, 200);
                    }
                    break;
                case 2:
                    # Medical
                    if($request->type == 1) 
                    {
                        # Get one Request                         
                        if(isset($request->request_id))
                        {
                            $result = $this->medicalRequest($request->request_id);
                            return response()->json($result, 200);
                        }
                        else{
                            $response['status']  = 200;
                            $response['status_message_en'] = 'missed paramters';
                            $response['status_message_ar'] = 'حقول ناقصة';
                            return response()->json($response, 200);
                        }
                    }
                    else if($request->type == 2){
                        # Get All Request 
                        $result = $this->medicalRequests($request->user_number);
                        return response()->json($result, 200);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        else{
            $response['status']  = 200;
            $response['status_message_en'] = 'missed paramters';
            $response['status_message_ar'] = 'حقول ناقصة';
            return response()->json($response, 200);
        }
    }

    private function medicalRequest($request_id)
    {
        # start Coding
        $my_requests = DB::table('medical_requests')
                           ->leftJoin('professions', 'professions.profession_id', '=', 'medical_requests.profession_id')
                           ->leftJoin('degrees'    , 'degrees.degree_id', '=', 'medical_requests.degree_id')
                           ->leftJoin('areas'      , 'areas.area_id', '=', 'medical_requests.area_id')
                           ->leftJoin('medical_providers'    , 'medical_providers.id', '=', 'medical_requests.provider_id')
                           ->select('medical_requests.request_id','medical_requests.syndicate_user_number',
                                    'medical_requests.status','medical_requests.approval_number','medical_requests.approval_image',
                                    'medical_requests.comment','medical_requests.provider_type_id','medical_requests.provider_id',
                                    'medical_requests.created_at','professions.profession','degrees.profession as degree','areas.area_name','medical_providers.name'
                                   )                               
                           ->where('medical_requests.request_id',$request_id)
                           ->get()->first();
        \App\MedicalRequest::find($request_id)->update(['mobile_view'=>'1']);
        if(!empty($my_requests))
        {
            # ==================== start Coding =======================================================================
            $request_array = array();
            $index = 0;     
            $request_array['request_id'] = $my_requests->request_id;
            $request_array['notification_type_id'] = 1;
            $request_array['notification_type'] = "مطالبات طبية";
            $request_array['requester_title'] = "مقدم الخدمة";
            $temp = explode(' ',$my_requests->created_at);
            $request_array['created_at']    = $my_requests->created_at;
            $request_array['date']       = $my_requests->created_at == null ? "" : $temp[0];
            $request_array['time']       = $my_requests->created_at == null ? "" : date("g:i a", strtotime($temp[1]));
            $request_array['user_number'] = $my_requests->syndicate_user_number;
            $request_array['profession']    = $my_requests->profession;
            $request_array['degree']        = $my_requests->degree;
            $request_array['area']          = $my_requests->area_name;
            $request_array['requester_name'] = $my_requests->name; 
    
            if ($my_requests->status == 0 || $my_requests->status == NULL) {
                $request_array['status_name'] = 'طلبكم تحت الدراسة';
            }
            else if($my_requests->status == 1) {
                $request_array['status_name'] = 'تم قبول الطلب';
            }
            else if($my_requests->status == 2) {
                $request_array['status_name'] = 'تم رفض الطلب';
            }
            else {
                $request_array['status_name'] = NULL;
            }
    
            $request_array['approval_number'] = $my_requests->approval_number;
            $request_array['approval_image']  = asset($my_requests->approval_image);
            $request_array['comment']         = $my_requests->comment;
    
            $docs = MedicalRequestDoc::where('medical_request_id',$my_requests->request_id)->get();
            $doc_index = 1;
            foreach ($docs as $doc) 
            {
                $request_array['doc'.$doc_index] = asset($doc->doc);
                $doc_index++;
            }
            $index++;
    
            if (count($request_array) > 0) 
            {
                return $request_array;
            } 
            else {
                $response['status']  = 200;
                $response['status_message_en'] = 'no data found';
                $response['status_message_ar'] = 'لا يوجد بيانات';
                return $response;
    
            }
            # ==================== end Coding   =======================================================================
        }   
        else{
            $response['status']  = 200;
            $response['status_message_en'] = 'no data found';
            $response['status_message_ar'] = 'لا يوجد بيانات';
            return $response;
        }                
        
        
    }

    private function medicalRequests($user_number)
    {
        # start Coding
        $my_requests = DB::table('medical_requests')
                           ->leftJoin('professions', 'professions.profession_id', '=', 'medical_requests.profession_id')
                           ->leftJoin('degrees'    , 'degrees.degree_id', '=', 'medical_requests.degree_id')
                           ->leftJoin('areas'      , 'areas.area_id', '=', 'medical_requests.area_id')
                           ->leftJoin('medical_providers'    , 'medical_providers.id', '=', 'medical_requests.provider_id')
                           ->select('medical_requests.request_id','medical_requests.syndicate_user_number',
                                    'medical_requests.status','medical_requests.approval_number','medical_requests.approval_image',
                                    'medical_requests.comment','medical_requests.provider_type_id','medical_requests.provider_id',
                                    'medical_requests.created_at','professions.profession','degrees.profession as degree','areas.area_name','medical_providers.name','medical_requests.mobile_view'
                                   )                               
                           ->where('medical_requests.syndicate_user_number',$user_number)
                           ->orderBy('medical_requests.created_at','DESC')
                           ->get();
        $request_array = array();
        $index = 0;     
        
        foreach ($my_requests as $my_request) 
        {
                $doc_index=1;                
                $request_array[$index]['id'] = $my_request->request_id;
                $temp = explode(' ',$my_request->created_at);
                $request_array[$index]['date']          = $my_request->created_at == null ? "" : $temp[0];
                $request_array[$index]['time']          = $my_request->created_at == null ? "" : date("g:i a", strtotime($temp[1]));
                $request_array[$index]['profession']    = $my_request->profession;
                $request_array[$index]['provider_name'] = $my_request->name;
                $request_array[$index]['read']          = $my_request->mobile_view;                
                            

                if ($my_request->status == 0 || $my_request->status == NULL) {
                    $request_array[$index]['status_name'] = 'طلبكم تحت الدراسة';
                }
                else if($my_request->status == 1) {
                    $request_array[$index]['status_name'] = 'تم قبول الطلب';
                }
                else if($my_request->status == 2) {
                    $request_array[$index]['status_name'] = 'تم رفض الطلب';
                }
                else {
                    $request_array[$index]['status_name'] = NULL;
                }
                $index++;
        }

        if (count($request_array) > 0) 
        {
            return $request_array;
        } 
        else {
            $response['status']  = 200;
            $response['status_message_en'] = 'no data found';
            $response['status_message_ar'] = 'لا يوجد بيانات';
            return $response;
        }
    }


    public function register_token(Request $request)
    {
        if (isset($request->token) && isset($request->mobile_id) 
            && isset($request->syndicate_id) && isset($request->syndicate_user_number) ) 
        {
            $user = OrganizationMember::where('token', '=', $request->token)->first();
            if ($user === null) 
            {
                $member = OrganizationMember::create([
                'token'            => $request->token,
                'mobile_id'         => $request->mobile_id,
                'syndicate_id'      => $request->syndicate_id,
                'syndicate_number'  => $request->syndicate_user_number,
                ]);
                $_response['status'] = 200;
                $_response['status_message'] = "token created successfully";
                $_response['data'] = $member;
                return response()->json($_response, 200);
            }
            else{
                $_response['status'] = 200;
                $_response['status_message'] = "user already exist";
                $_response['data'] = "";
                return response()->json($_response, 200);
            }          
        }
        else{
            $_response['status'] = 200;
            $_response['status_message'] = "fail : missing paramters";
            $_response['data'] = "";
            return response()->json($_response, 200);
        }
    }


    private function tripRequest($request_id)
    {
        # start Coding
        $my_requests = tripRequest::where('id',$request_id)->get()->first();
        if(isset($my_requests))
        {
            \App\tripRequest::find($request_id)->update(['mobile_view'=>'1']);
            
            $request_array = array();
            $request_array['request_id'] = $my_requests->request_id;
            $request_array['notification_type_id'] = 2;
            $request_array['notification_type'] = "الرحلات";
            $request_array['requester_title'] = "طالب الخدمة";
            $temp = explode(' ',$my_requests->created_at);
            $request_array['user_number'] = $my_requests->syndicate_user_number;
            // Error
            $request_array['trip']     = @$my_requests->trip->trip_title;
            $request_array['regiment'] = @$my_requests->regiment->date_from;
            if ($my_requests->status == 0 || $my_requests->status == NULL) {
                $request_array['status_name'] = 'طلبكم تحت الدراسة';
            }
            else if($my_requests->status == 1) {
                $request_array['status_name'] = 'تم قبول الطلب';
            }
            else if($my_requests->status == 2) {
                $request_array['status_name'] = 'تم رفض الطلب';
            }
            else {
                $request_array['status_name'] = "غير معلوم";
            }
            
            $request_array['approval_ammount_cost'] = $my_requests->approval_ammount_cost;
            $request_array['comment']               = $my_requests->comment;
            $request_array['housing_type']          = $my_requests->housing_type;
            $request_array['num_child']             = $my_requests->num_child;
            $request_array['requester_name']                  = $my_requests->name;
            $request_array['date'] = $my_requests->created_at == null ? "" : $temp[0];
            $request_array['time'] = $my_requests->created_at == null ? "" : date("g:i a", strtotime($temp[1]));
            $docs = tripRequestDoc::where('trip_request_id',$my_requests->id)->get();
            $doc_index = 1;
            foreach ($docs as $doc) 
            {
                $request_array['doc'.$doc_index] = url('/').'/storage/files/trip_requests/'.$doc->doc;
                $doc_index++;
            }
            
            if (count($request_array) > 0) 
            {
                return $request_array;                
            } 
            else {
                $response['status']  = 200;
                $response['status_message_en'] = 'no data found';
                $response['status_message_ar'] = 'لا يوجد بيانات';
                return $response;
            }
        }
        else {
            $response['status']  = 200;
            $response['status_message_en'] = 'no data found';
            $response['status_message_ar'] = 'لا يوجد بيانات';
            return response()->json($response, 200);
        }      
          
        
       
    }




    private function EngineeringRecord($request_id)
    {
        
        # start Coding
        $my_requests = EngineeringRecordRequest::where('request_id',$request_id)->get()->first();
        if(isset($my_requests))
        {
            \App\EngineeringRecordRequest::find($request_id)->update(['mobile_view'=>'1']);
            $request_array = array();
            $request_array['request_id'] = $my_requests->request_id;
            $request_array['notification_type_id'] = 3;
            $request_array['notification_type'] = "السجلات الهندسية";
            $request_array['requester_title'] = "طالب الخدمة";
            $temp = explode(' ',$my_requests->created_at);
            $request_array['user_number'] = $my_requests->syndicate_user_number;
            // Error
            $request_array['requester_name'] = @$my_requests->name;
            $request_array['cost'] = @$cost;
            
            
            if ($my_requests->status == 0 || $my_requests->status == NULL) {
                $request_array['status_name'] = 'طلبكم تحت الدراسة';
            }
            else if($my_requests->status == 1) {
                $request_array['status_name'] = 'تم قبول الطلب';
            }
            else if($my_requests->status == 2) {
                $request_array['status_name'] = 'تم رفض الطلب';
            }
            else {
                $request_array['status_name'] = NULL;
            }
            
            $request_array['email']               = $my_requests->email;
            $request_array['phone']               = $my_requests->phone;            
            
            
            $request_array['date'] = $my_requests->created_at == null ? "" : $temp[0];
            $request_array['time'] = $my_requests->created_at == null ? "" : date("g:i a", strtotime($temp[1]));
            $docs = \App\EngineeringRecordRequestDoc::where('request_id',$request_id)->get();
            $doc_index = 1;
            foreach ($docs as $doc) 
            {
                $request_array['doc'.$doc_index] = url('/').'/upload/EngineeringRecordsRequests/'.$doc->doc;
                $doc_index++;
            }
            
            if (count($request_array) > 0) 
            {
                return $request_array;                
            } 
            else {
                $response['status']  = 200;
                $response['status_message_en'] = 'no data found';
                $response['status_message_ar'] = 'لا يوجد بيانات';
                return $response;
            }
        }
        else {
            $response['status']  = 200;
            $response['status_message_en'] = 'no data found';
            $response['status_message_ar'] = 'لا يوجد بيانات';
            return response()->json($response, 200);
        }      
          
        
       
    }


    private function tripRequests($user_number)
    {
        # start Coding
        $my_requests = tripRequest::where('syndicate_user_number',$user_number)
                       ->orderBy('created_at','DESC')->get();            
        $request_array = array();
        $index = 0;
        foreach ($my_requests as $my_request) 
        {
            $doc_index=1;      
            //////////////////////////////////////////////////////////////////////////////////////////
            $request_array[$index]['id'] = $my_request->id;
            $temp = explode(' ',$my_request->created_at);
            $request_array[$index]['syndicate_user_number'] = $my_request->syndicate_user_number;
            $request_array[$index]['trip']     = $my_request->trip->trip_title;
            $request_array[$index]['regiment'] = $my_request->regiment->date_from;            

            if ($my_request->status == 0 || $my_request->status == NULL) {
                $request_array[$index]['status'] = 'طلبكم تحت الدراسة';
            }
            else if($my_request->status == 1) {
                $request_array[$index]['status'] = 'تم قبول الطلب';
            }
            else if($my_request->status == 2) {
                $request_array[$index]['status'] = 'تم رفض الطلب';
            }
            else {
                $request_array[$index]['status'] = NULL;
            }                
            $request_array[$index]['approval_ammount_cost'] = $my_request->approval_ammount_cost;
            $request_array[$index]['comment']               = $my_request->comment;
            $request_array[$index]['housing_type']          = $my_request->housing_type;
            $request_array[$index]['num_child']             = $my_request->num_child;
            $request_array[$index]['name']                  = $my_request->name;
            $request_array[$index]['date']                  = $my_request->created_at == null ? "" : $temp[0];
            $request_array[$index]['time']                  = $my_request->created_at == null ? "" : date("g:i a", strtotime($temp[1]));          
            
            $index++;
            
        }
        if (count($request_array) > 0) 
        {
            return $request_array;
        } 
        else {
            $response['status']  = 200;
            $response['status_message_en'] = 'no data found';
            $response['status_message_ar'] = 'لا يوجد بيانات';
            return $response;
        } 
    }


}
