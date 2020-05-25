<?php

namespace App\Http\Controllers\HomeNews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\News;
class NewsController extends Controller
{
    public function showNews(){
        $news = News::orderBy('id', 'desc')->paginate(6);
        return view('news',compact('news'));
    }
}
