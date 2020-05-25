<?php

namespace App\Http\Controllers\API\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalRequest;
use App\MedicalRequestDoc;
use App\MedicalProviders;
use Carbon\Carbon;
use Image;
use File;
use Input;
use App\MedicalServiceProviderType;
use App\User;

class MedicalRequestController extends Controller
{
   
    public function receive_request(Request $request)
    {
         
        if(isset(($request->json_request)))
        {
           $request_array = json_decode($request->json_request);
           
             if(isset($request_array->main_syndicate_id) && isset($request_array->syndicate_user_number) && isset($request_array->email)   
              && isset($request_array->email) && isset($request_array->phone) && isset($request_array->provider_id) &&isset($request_array->provider_type_id)
           ) 
           {
                   # code
                   $provider = MedicalServiceProviderType::where('id',$request_array->provider_type_id)->get();
                   $mRequest = new MedicalRequest();
                  $mRequest->main_syndicate_id     = $request_array->main_syndicate_id;
                   $mRequest->syndicate_user_number = $request_array->syndicate_user_number;
                   $mRequest->email = $request_array->email;
                   $mRequest->phone = $request_array->phone;
                   $mRequest->provider_id = $request_array->provider_id;
                   
                   foreach($provider as $provider1){
                   $mRequest->provider_type_id = $provider1->provider_type_ar;
                   }
                  //////////////////////////////////////////////////////////////////
                   
                //default status ...
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $mRequestType = $mRequest->where('provider_type_id',$request_array->provider_type_id)->count();
                
                    if ($mRequestType == 0){
                       foreach($provider as $provider1){
                        $requestNameValue = $provider1->provider_type_ar;

                       }
                        
                         $getFirstUsers = User::where([['provider_type_id','like','%'.$requestNameValue.'%'],['activated',1]])->first();//
                        $getUsers = User::where([['provider_type_id', 'like','%'.$requestNameValue.'%'],['activated',1]])->get();
                        if(!empty($getFirstUsers)){
                             $firstID = $getFirstUsers->username;
                        }
                        $firstUser = 0;
                        $firstUserID =0;
                        foreach($getUsers as $getUser){
                           $firstUser = MedicalRequest::where([['username',$firstID],['status',0]])->count();
                           $firstUserID = $getFirstUsers->username;
                           $users = MedicalRequest::where([['username',$getUser->username],['status',0]])->count();
                           if($users < $firstUser){
                               $firstID =$getUser->username;     
                               $firstUserID = $getUser->username;
                           }
                            $mRequest->username = $firstUserID;
                        }
                        $mRequest->save();

                        $_response['smallestUser'] =  $firstUser;
                        $_response['smallestUserID'] =  $firstUserID ;
                         $_response['status'] = 200;
                        $_response['status_message_en'] = "first request in this type";
                        return response()->json($_response, 200);
                    }else{
                        foreach($provider as $provider1){
                            $requestNameValue = $provider1->provider_type_ar;
                        }
                        
                        $getFirstUsers = User::where([['provider_type_id','like','%'.$requestNameValue.'%'],['activated',1]])->first();
                        $getUsers = User::where([['provider_type_id', 'like','%'.$requestNameValue.'%'],['activated',1]])->get();
                         if(!empty($getFirstUsers)){
                             $firstID = $getFirstUsers->username;
                        }
                        $firstUser = 0;
                        $firstUserID =0;
                       foreach($getUsers as $getUser){
                           $firstUser = MedicalRequest::where([['username',$firstID],['status',0]])->count();
                           $firstUserID = $getFirstUsers->username;
                           $users = MedicalRequest::where([['username',$getUser->username],['status',0]])->count();
                           if($users < $firstUser){
                               $firstID =$getUser->username;  
                               $firstUserID = $getUser->username;
                           }
                            $mRequest->username = $firstUserID ;
                            
                       }
                       $mRequest->save();
                       // $usersRequst =  $mRequest->where('user_id',)
                        $_response['requestCount']=$mRequestType;
                         $_response['smallestUser'] =  $firstUser;
                        $_response['smallestUserID'] =  $firstUserID ;
                         $_response['status'] = 200;
                         $_response['status_message_en'] = "thanks 2";
                        return response()->json($_response, 200);
                    }           
                
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $mRequest->name = $request->name;
                   $mRequest->area_id = 0;
                   $mRequest->created_at = Carbon::now()->toDateTimeString();
                   $mRequest->save();

                   

                   $index = 1;
                    for ($i=0; $i < $request->docs_num ; $i++) 
                    { 
                        $file_name = "doc".$index;
                        if(!empty($request->file($file_name))){
                        //Check picture path exists or not
                        if(File::exists(public_path('/upload/MedicalRequests/'.$mRequest->requestid)) == false ){File::makeDirectory(public_path('/upload/MedicalRequests/'.$mRequest->requestid,0777,true));}
                              // img
                              $picture = Image::make($request->file($file_name));
                              $picture->resize(600, null, function ($constraint) {$constraint->aspectRatio();});
                              $picture->save(public_path().'/upload/MedicalRequests/'.$mRequest->requestid.'/logo'.$index.'.jpg',50);
                              $path  = '/upload/MedicalRequests/'.$mRequest->requestid.'/logo'.$index.'.jpg';
                              $medical_requestdocs = new MedicalRequestDoc();
                              // uploadImage();  
                              $medical_requestdocs->medical_requestid = $mRequest->requestid;
                              $medical_requestdocs->doc                = $path;
                              $medical_requestdocs->save();
                        }
                        $index++;   
                        
                    }   

            }
            else{
                $response['status']  = 200;
                $response['status_message_ar'] = 'missed paramters in json';
                $response['status_message_en'] = 'missed paramters in json';
                return response()->json($response, 200);
            }
        }
        
    }
    


    
}


