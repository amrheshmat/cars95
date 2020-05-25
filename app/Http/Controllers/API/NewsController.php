<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\News;
use DB;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('id', 'DESC')->limit(20)->get([
            'news.id AS news_id',
            'news.title AS news_title',
             DB::raw('CONCAT("'.URL('/').'", img) AS news_img'),
            'news.desc AS news_desc',
            'news.news_type_id AS type_id',
            'news.source AS source',
            'news.created_at AS date',
            'news.created_at AS time',
            ]);
        if (count($news)>0) 
        {
            $news_articles = array();           
            $_response['status'] = config('constants.Found');
            $_response['status_message_en'] = "Found";
            $_response['status_message_ar'] = "وجدت";
            $_response['data'] = $news;
            return response()->json($_response, 200);
        } 
        else {
            $_response['status'] = config('constants.NotFound');
            $_response['status_message_en'] = "Empty Data";
            $_response['status_message_ar'] = "لا يوجد بيانات";
            $_response['data'] = "";
            return response()->json($_response, 200);
        }
    }

    public function news_by(Request $request)
    {
        if (isset($request->action)) 
        {
           switch ($request->action) {
               case '1':
                   # by main_syndicate
                   $news = News::where('main_syndicate_id','=',$request->main_syndicate)->orderBy('id', 'desc')->limit(20)->get([
                    'news.id AS news_id',
                    'news.title AS news_title',
                     DB::raw('CONCAT("'.URL('/').'", img) AS news_img'),
                    'news.desc AS news_desc',
                    'news.news_type_id AS type_id',
                    'news.source AS source',
                    'news.created_at AS date',
                    'news.created_at AS time',
                    ]);
                   
                   if (count($news)>0) 
                   {
                       $_response['status'] = config('constants.Found');
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $news;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = config('constants.NotFound');
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 200);
                   }
                   break;

               case '2':
                   # all By sub syndicate_id
                   $news_articles = News::where('sub_syndicate_id','=',$request->sub_syndicate)->orderBy('id', 'desc')->limit(20)->get();
                   if (count($news_articles)>0) 
                   {
                       $_response['status'] = config('constants.Found');
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $news_articles;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = config('constants.NotFound');
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 200);
                   }
                   break;             
                   
               
               default:
                    $_response['status'] = config('constants.Unauthorized');
                    $_response['status_message_en'] = "fail : Unkown Action Key";
                    $_response['status_message_ar'] = "خطأ فى بيانات";
                    $_response['data'] = "";
                    return response()->json($_response, 200);
                   break;
           }
        } 
        else 
        {
            $_response['status'] = config('constants.Unauthorized');
            $_response['status_message_en'] = "fail : missing paramters";
            $_response['status_message_ar'] = "missing paramters";
            $_response['data'] = "";
            return response()->json($_response, 200);
        }       
    }
}
