<?php

namespace App\Http\Controllers\API\AddPropertyRequest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Covid19;
use Carbon\Carbon;
use Image;
use File;
use Input;
use App\User;
use App\AddPropertyRequest;

class AddPropertyRequestController extends Controller
{
    
    public function receive_request(Request $request)
    {
        //return response()->json("no data", 200);
        
        if(isset($request->property_name) && isset($request->property_address)&& isset($request->property_describtion) )  
        {
            $addRequest = new AddPropertyRequest();
            $addRequest->property_name = $request->property_name;
            $addRequest->property_address = $request->property_address;
            $addRequest->property_describtion = $request->property_describtion;
            $addRequest->save();
            return response()->json("data", 200);
        }
    
    }

}