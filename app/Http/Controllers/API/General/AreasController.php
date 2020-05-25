<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Area;

class AreasController extends Controller
{
    public function index()
    {
        $areas = Area::get([
            'areas.*',
            'areas.area_id AS area_id',
            'areas.governorate_id AS gov_id',
            ]);
        $response['status']  = 200;
        $response['status_message_en'] = 'Found';
        $response['status_message_ar'] = 'وجدت';       
        $response['data'] = $areas;
        return response()->json($response, 200);
    }
}
