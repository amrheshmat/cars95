<?php

namespace App\Http\Controllers\API\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Country;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return response()->json($countries, 200);        
    }
}
