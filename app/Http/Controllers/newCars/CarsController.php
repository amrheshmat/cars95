<?php

namespace App\Http\Controllers\newCars;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cars;

class CarsController extends Controller
{
    public function showNewCars(Request $request){
        $cars = Cars::where('status_id','1')->orderBy('id', 'desc')->paginate(12);
        return view('newCars',compact('cars'));
    }
    public function showUsedCars(Request $request){
        $cars = Cars::where('status_id','2')->orderBy('id', 'desc')->paginate(12);
        return view('usedCars',compact('cars'));
    }
}
