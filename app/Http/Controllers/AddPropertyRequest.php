<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddPropertyRequest extends Controller
{
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function recieveRequest(Request $request)
    {
        if(isset(($request)))
        {
            if(isset($request->property_name) && isset($request->property_address) && isset($request->property_describtion)  && isset($request->attachments))  
            {

                $postfields = array();
                $postfields['property_name'] = $request->property_name;  
                $postfields['property_address'] = $request->property_address;  
                $postfields['property_describtion'] = $request->property_describtion;  
                $postfields['attachments'] = $request->attachments;  
                $ch = curl_init();
                $headers = array(
                    "cache-control: no-cache",
                 );
                 curl_setopt($ch,CURLOPT_URL,"http:/localhost:8000/api/v1/AddPropertyRequest ");
                 curl_setopt($ch,CURLOPT_POST, true );
                 curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST" );
                 curl_setopt($ch,CURLOPT_HTTPHEADER, $headers );
                 curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );
                 curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
                 curl_setopt($ch,CURLOPT_POST, count($postfields));
                 curl_setopt($ch,CURLOPT_POSTFIELDS, $postfields);
                 
    
                    $providers =json_decode(curl_exec($ch), true) ;
                    $err = curl_error($ch);          
                    curl_close($ch);    
                    if(!empty( $providers))
                    {
                        return redirect('/');
                    }

            }else{
                echo "missing data";
            }
           
        }
    }

    
}
