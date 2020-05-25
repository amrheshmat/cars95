<?php

namespace App\Http\Controllers\API\Medical;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profession;


class ProfessionsController extends Controller
{
    public function index()
    {
        $professions = Profession::all();
        $response['status']  = 200;
        $response['status_message_en'] = 'Found';
        $response['status_message_ar'] = 'وجدت';       
        $response['data'] = $professions;
        return response()->json($response, 200);
    }
}
