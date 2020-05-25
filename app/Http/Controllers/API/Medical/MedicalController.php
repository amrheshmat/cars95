<?php

namespace App\Http\Controllers\API\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\MedicalProviders;
use App\MedicalServiceProviderType;

class MedicalController extends Controller
{
    public function getProviders(Request $request)
    {
        if (isset($request->provider_type_id) && isset($request->gov_id)) 
        {
            $postfields = array();
            $fields_string ="";
            $postfields['provider_type_id'] = $request->provider_type_id;
            $postfields['gov_id'] = $request->gov_id;
            if(isset($request->provider_id))   { $postfields['provider_id']   = $request->provider_id;  }
            if(isset($request->area_id))       { $postfields['area_id']       = $request->area_id;  }
            if(isset($request->profession_id)) { $postfields['profession_id'] = $request->profession_id;  }            
            if(isset($request->degree_id))     { $postfields['degree_id']     = $request->degree_id;  }    
            foreach($postfields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');

            $ch = curl_init();
            $headers = array(
                "cache-control: no-cache",
             );
             curl_setopt($ch,CURLOPT_URL, env('Syndicate_Server').'/api/v1/Medical/providers');
             curl_setopt($ch,CURLOPT_POST, true );
             curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST" );
             curl_setopt($ch,CURLOPT_HTTPHEADER, $headers );
             curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
             curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
             curl_setopt($ch,CURLOPT_POST, count($postfields));
             curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            
            $providers =json_decode(curl_exec($ch), true) ;
            $err = curl_error($ch);            
            curl_close($ch);           
            
            if(isset($providers) && !empty($providers))
            {               
                $response['status']  = 200;
                $response['status_message_en'] = 'Found';
                $response['status_message_ar'] = 'وجدت';       
                $response['data'] = $providers;
                return response()->json($response, 200); 
            }
            else{
                # Not Found
                $provider_data = array();
                $response['status']  = 200;
                $response['status_message_en'] = 'NotFound';
                $response['status_message_ar'] = 'لا يوجد بيانات';       
                $response['data'] = $provider_data;
                return response()->json($response, 200);
            }
            
                          
        } 
        else 
        {
            $response['status']  = 200;
            $response['status_message_ar'] = 'missed paramter';
            $response['status_message_en'] = 'حقل ناقص';
            return response()->json($response, 200);
        }        
    }

    public function service_provider_types(Request $request)
    {
        # Start Coding
        if(isset($request->medical_type) && $request->medical_type == "claiming")
        {
          #service_type = 2 claiming
          $provider_types = MedicalServiceProviderType::where('service_type',2)->get();
          $response['status']  = 200;
          $response['status_message_en'] = 'Found';
          $response['status_message_ar'] = 'وجدت';       
          $response['data'] = $provider_types;
          return response()->json($response, 200);   
            
        }
        else if(isset($request->medical_type) && $request->medical_type == "directory"){
            #service_type =  1 directory
            $provider_types = MedicalServiceProviderType::All();
            $response['status']  = 200;
            $response['status_message_en'] = 'Found';
            $response['status_message_ar'] = 'وجدت';       
            $response['data'] = $provider_types;
            return response()->json($response, 200);   
            
        }
        else{
            $response['status']  = 200;
            $response['status_message_ar'] = 'missed paramters';
            $response['status_message_en'] = 'missed paramters';  
            return response()->json($response, 200);             
        }

    }

    public function provider_details(Request $request)
    {
        if (isset($request->provider_type_id)) 
        {
            $postfields = array();
            $fields_string ="";
            $postfields['provider_type_id'] = $request->provider_type_id;
            if(isset($request->gov_id))        { $postfields['gov_id']        = $request->gov_id;  }
            if(isset($request->provider_id))   { $postfields['provider_id']   = $request->provider_id;  }
            if(isset($request->area_id))       { $postfields['area_id']       = $request->area_id;  }
            if(isset($request->profession_id)) { $postfields['profession_id'] = $request->profession_id;  }            
            if(isset($request->degree_id))     { $postfields['degree_id']     = $request->degree_id;  }    
            foreach($postfields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');

            $ch = curl_init();
            $headers = array(
                "cache-control: no-cache",
             );
             curl_setopt($ch,CURLOPT_URL, env('Syndicate_Server').'/api/v1/Medical/providerDetails');
             curl_setopt($ch,CURLOPT_POST, true );
             curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST" );
             curl_setopt($ch,CURLOPT_HTTPHEADER, $headers );
             curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
             curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
             curl_setopt($ch,CURLOPT_POST, count($postfields));
             curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
            
            $providers =json_decode(curl_exec($ch), true) ;
            $err = curl_error($ch);            
            curl_close($ch);           
            
            if(isset($providers) && !empty($providers))
            {               
                $response['status']  = 200;
                $response['status_message_en'] = 'Found';
                $response['status_message_ar'] = 'وجدت';       
                $response['data'] = $providers;
                return response()->json($response, 200); 
            }
            else{
                # Not Found
                $provider_data = array();
                $response['status']  = 200;
                $response['status_message_en'] = 'NotFound';
                $response['status_message_ar'] = 'لا يوجد بيانات';       
                $response['data'] = $provider_data;
                return response()->json($response, 200);
            }
            
                          
        } 
        else 
        {
            $response['status']  = 200;
            $response['status_message_ar'] = 'missed paramter';
            $response['status_message_en'] = 'حقل ناقص';
            return response()->json($response, 200);
        }     
        
    }


    public function getDoctors(Request $request)
    {
        echo "gov ".$request->gov_id;
        if (isset($request->gov_id)) 
        {
            # GovID Required
            $where_array = array();
            $where_array['governorate_id']     = $request->gov_id;            
            if(isset($request->doctor_id))     { $where_array['id']            = $request->doctor_id;  }            
            if(isset($request->profession_id)) { $where_array['profession_id'] = $request->profession_id;  }            
            if(isset($request->degree_id))     { $where_array['degree_id']     = $request->degree_id;  }            
            if(isset($request->area_id))       { $where_array['area_id']       = $request->area_id;  }  

            // $doctors = doctors::where($where_array)->get();
            $providers = MedicalProviders::select('id','name','address','phones','profession_id','degree_id','area_id','governorate_id')
                        ->where('governorate_id',$request->gov_id)->where('provider_type_id',2)
                        ->where($where_array)->get();
                        dd();

            if(isset($providers) && !empty($providers))
            {
                # found Data
                $doctors = array();
                $index = 0;
                foreach ($providers as $provider) 
                {
                    # code...
                    $doctors[$index]['id']          = $provider->id;
                    $doctors[$index]['name']        = $provider->name;
                    $doctors[$index]['address']     = $provider->address;
                    $doctors[$index]['profession']  = isset($provider->profession->profession) ? $provider->profession->profession : "";
                    $doctors[$index]['degree']      = isset($provider->degree->profession) ? $provider->degree->profession : "";
                    $doctors[$index]['area']        = isset($provider->area->area_name) ? $provider->area->area_name: "";
                    $doctors[$index]['governorate'] = isset($provider->governorate->governorate_desc_ar) ? $provider->governorate->governorate_desc_ar : "";
                    $index++;
                }
                $response['status']  = 200;
                $response['status_message_en'] = 'Found';
                $response['status_message_ar'] = 'وجدت';       
                $response['data'] = $doctors;
                return response()->json($response, 200); 
            }
            else{
                # Not Found
                $doctors = array();
                $response['status']  = 200;
                $response['status_message_en'] = 'NotFound';
                $response['status_message_ar'] = 'لا يوجد بيانات';       
                $response['data'] = $doctors;
                return response()->json($response, 200); 
            }
                            
        } 
        else 
        {
            $response['status']  = 200;
            $response['status_message_ar'] = 'missed paramter';
            $response['status_message_en'] = 'حقل ناقص';
            return response()->json($response, 200);
        }
        
    }


}
