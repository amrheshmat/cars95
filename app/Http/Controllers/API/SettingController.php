<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
    public function androidMinVersion()
    {
        $settings = Setting::find('1');        
        $response['value'] = (string)$settings['min_supported_version'];        
        return response()->json( $response,200);
    }
}
