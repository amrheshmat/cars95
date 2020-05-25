<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Governorate;

class GovernoratesController extends Controller
{
    public function index()
    {
        // $governorates = Governorate::all();

        $governorates = Governorate::get([
            'governorates.*',
            'governorates.id AS governorate_id',            
            ]);

        return response()->json($governorates, 200);
    }
}
