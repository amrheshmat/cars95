<?php

namespace App\Http\Controllers\API\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Degree;


class DegreesController extends Controller
{
    public function index()
    {
        $degrees = Degree::all();
        $response['status']  = 200;
        $response['status_message_en'] = 'Found';
        $response['status_message_ar'] = 'وجدت';       
        $response['data'] = $degrees;
        return response()->json($response, 200);
    }
}
