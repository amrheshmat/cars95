<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Complaint;

class ComplaintsServiceController extends Controller
{
    public function index()
    {
        $complaints = Complaint::all();
        return response()->json($complaints, 200);        
    }
}
