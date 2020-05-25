<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Cars;

class CarsHomeController extends Controller
{
    public function showFeatures(){
         $news = News::orderBy('id', 'desc')->take(3)->get();
         $cars = Cars::orderBy('id', 'desc')->take(12)->get();
        return view('welcome',compact('news','cars'));
    }
}
