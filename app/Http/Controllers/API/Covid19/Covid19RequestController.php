<?php

namespace App\Http\Controllers\API\Covid19;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Covid19;
use App\Covid19doc;
use Carbon\Carbon;
use Image;
use File;
use Input;
use App\User;

class Covid19RequestController extends Controller
{
    
    public function receive_request(Request $request)
    {
        //'OldRefID','approval_number','type_of_injury','job','job_destination','treatment_destination','treatment_destination_address','family_number','desc_of_injury','approval_image'
         
        if(isset(($request->json_request)))
        {
           $request_array = json_decode($request->json_request);
           
             if(isset($request_array->syndicate_user_number) && isset($request_array->type_of_injury) && isset($request_array->job)   && isset($request_array->docs_num)
              && isset($request_array->job_destination)&& isset($request_array->treatment_destination)  && isset($request_array->treatment_destination_address) && isset($request_array->family_number) &&isset($request_array->desc_of_injury)
           ) 
           {
                   # code
                   $mRequest = new Covid19();
                   $mRequest->OldRefID = $request_array->syndicate_user_number;
                   $mRequest->phone = $request_array->phone;
                   $mRequest->type_of_injury = $request_array->type_of_injury;
                   $mRequest->job = $request_array->job;
                   $mRequest->job_destination = $request_array->job_destination;
                   $mRequest->treatment_destination = $request_array->treatment_destination;
                   $mRequest->treatment_destination_address = $request_array->treatment_destination_address;
                   $mRequest->family_number = $request_array->family_number;
                   $mRequest->desc_of_injury = $request_array->desc_of_injury;
                   $mRequest->created_at = Carbon::now()->toDateTimeString();
                   $mRequest->save();
                //default status ...          
//////////////////////////////////////////////////////////////////////////////////////////////
$index = 1;
for ($i=0; $i < $request_array->docs_num ; $i++) 
{ 
    $file_name = "doc".$index;
    if(!empty($request->file($file_name))){
    //Check picture path exists or not
    if(File::exists(public_path('/upload/Covid19/'.$mRequest->id)) == false ){File::makeDirectory(public_path('/upload/Covid19/'.$mRequest->id,0777,true));}
          // img
          $picture = Image::make($request->file($file_name));
          $picture->resize(600, null, function ($constraint) {$constraint->aspectRatio();});
          $picture->save(public_path().'/upload/Covid19/'.$mRequest->id.'/logo'.$index.'.jpg',50);
          $path  = '/upload/Covid19/'.$mRequest->id.'/logo'.$index.'.jpg';
          $medical_request_docs = new Covid19doc();
          // uploadImage();  
          $medical_request_docs->covid19_request_id = $mRequest->id;
          $medical_request_docs->doc                = $path;
          $medical_request_docs->save();
          $_response['file'] = "done";
    }else{
        $_response['file'] = "no";
    }
    
    
    // $medical_request_docs = medical_request_docs::create([
    //     'medical_request_id'     => $request_id,
    //     'doc'                    => $doc_path
    //     ]);
    $index++;   
    
}   

        $_response['status'] = 200;
        $_response['status_message_en'] = "thanks , we will response you soon";
        $_response['status_message_ar'] = "تم إستلام طلبكم بنجاح وسيتم الرد عليكم قريباً";
        return response()->json($_response, 200);

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


