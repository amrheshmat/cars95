<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trip;
use App\Image;
use App\Place;
use App\TripRegiment;
use App\tripRequest;
use App\tripRequestDoc;
use DB;
use File;

class TripsController extends Controller
{
    public function trips_by(Request $request)
    {
        if (isset($request->action)) 
        {
           switch ($request->action) {
               case '1':
                   # all By main
                   $trips = Trip::where('mainSyndicate_id','=',$request->main_syndicate)->where('trip_status_id',1)->
                   get([
                    'trips.id AS trip_ID','trips.trip_title','trips.trip_dateFrom','trips.trip_dateTo','trips.mainSyndicate_id','trips.subSyndicate_id',
                     DB::raw('CONCAT("'.URL('/').'", trip_image) AS trip_image'),
                    'trips.year','trips.notes','trips.price','trips.person_price','trips.child_price'
                    ]);                   
                   
                   if (count($trips)>0) 
                   {
                       $_response['status'] = 200;
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $trips;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = 204;
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 204);
                   }
                   break;

               case '2':
                   # all By sub
                   $trips = Trip::where('subSyndicate_id','=',$request->sub_syndicate)->where('trip_status_id',1)->
                   get([
                    'trips.id AS trip_ID','trips.trip_title','trips.trip_dateFrom','trips.trip_dateTo','trips.mainSyndicate_id','trips.subSyndicate_id',
                     DB::raw('CONCAT("'.URL('/').'", trip_image) AS trip_image'),
                    'trips.year','trips.notes','trips.price','trips.person_price','trips.child_price'
                    ]);     
                   if (count($trips)>0) 
                   {
                       
                       $_response['status'] = config('constants.Found');
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $trips;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = 204;
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 204);
                   }
                   break;

               case '3':
                   # all By main & sub
                   
                   $trips = Trip::where('mainSyndicate_id','=',$request->main_syndicate)->where('subSyndicate_id','=',$request->sub_syndicate)->where('trip_status_id',1)->
                   get([
                    'trips.id AS trip_ID','trips.trip_title','trips.trip_dateFrom','trips.trip_dateTo','trips.mainSyndicate_id','trips.subSyndicate_id',
                     DB::raw('CONCAT("'.URL('/').'", trip_image) AS trip_image'),
                    'trips.year','trips.notes','trips.price','trips.person_price','trips.child_price'
                    ]);             
                   if (count($trips)>0) 
                   {
                       
                       $_response['status'] = 200;
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $trips;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = 204;
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 204);
                   }
                   break;

               case '4':
                   # all By sub & trip to
                //     $trips = trips::All()
                //             ->where('subSyndicate_id','=',$request->sub_syndicate)
                //             ->where('governorate_id','=',$request->to)
                //             ->where('trip_status_id',1);
                //    if (count($trips)>0) 
                //    {
                //        $trips_array = array();
                //        $index = 0;
                //        foreach($trips as $trip) 
                //        { 
                //            $trips_array[$index]['trip_ID']    = $trip->trip_ID; 
                //            $trips_array[$index]['trip_title'] = $trip->trip_title; 
                //            $trips_array[$index]['trip_dateFrom'] = $trip->trip_dateFrom; 
                //            $trips_array[$index]['trip_dateTo'] = $trip->trip_dateTo; 
                //            $trips_array[$index]['mainSyndicate_id'] = $trip->mainSyndicate_id; 
                //            $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                //            $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                //            $trips_array[$index]['trip_image'] =url('/').'/'.$trip->trip_image; 
                //            $trips_array[$index]['year'] = $trip->year; 
                //            $trips_array[$index]['notes'] = $trip->notes; 
                //            $trips_array[$index]['price'] = $trip->price; 
                //            $trips_array[$index]['person_price'] = $trip->person_price; 
                //            $trips_array[$index]['child_price']  = $trip->child_price; 
                //            $index++;
                //        }
                //        $_response['status'] = 200;
                //        $_response['status_message_en'] = "Found";
                //        $_response['status_message_ar'] = "وجدت";
                //        $_response['data'] = $trips_array;
                //        return response()->json($_response, 200);
                //    } 
                //    else {
                //        $_response['status'] = 204;
                //        $_response['status_message_en'] = "Empty Data";
                //        $_response['status_message_ar'] = "لا يوجد بيانات";
                //        $_response['data'] = "";
                //        return response()->json($_response, 204);
                //    }
                   break;

               case '5':
                   # all By sub & place type
                   $trips = trips::All()
                            ->where('subSyndicate_id','=',$request->sub_syndicate)
                            ->where('placeType_id','=',$request->place_type)
                            ->where('trip_status_id',1);

                   if (count($trips)>0) 
                   {
                       $trips_array = array();
                       $index = 0;
                       foreach($trips as $trip) 
                       { 
                           $trips_array[$index]['trip_ID']    = $trip->trip_ID; 
                           $trips_array[$index]['trip_title'] = $trip->trip_title; 
                           $trips_array[$index]['trip_dateFrom'] = $trip->trip_dateFrom; 
                           $trips_array[$index]['trip_dateTo'] = $trip->trip_dateTo; 
                           $trips_array[$index]['mainSyndicate_id'] = $trip->mainSyndicate_id; 
                           $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                           $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                           $trips_array[$index]['trip_image'] = url('/').'/'.$trip->trip_image; 
                           $trips_array[$index]['year'] = $trip->year; 
                           $trips_array[$index]['notes'] = $trip->notes; 
                           $trips_array[$index]['price'] = $trip->price; 
                           $trips_array[$index]['person_price'] = $trip->person_price; 
                           $trips_array[$index]['child_price']  = $trip->child_price; 
                           $index++;
                       }
                       $_response['status'] = 200;
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $trips_array;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = 204;
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 204);
                   }
                   break;

               case '6':
                   # all By sub & trip type
                   $trips = trips::All()
                            ->where('subSyndicate_id','=',$request->sub_syndicate)
                            ->where('main_trip_type','=',$request->trip_type)
                            ->where('trip_status_id',1);
                   if (count($trips)>0) 
                   {
                       $trips_array = array();
                       $index = 0;
                       foreach($trips as $trip) 
                       { 
                           $trips_array[$index]['trip_ID']    = $trip->trip_ID; 
                           $trips_array[$index]['trip_title'] = $trip->trip_title; 
                           $trips_array[$index]['trip_dateFrom'] = $trip->trip_dateFrom; 
                           $trips_array[$index]['trip_dateTo'] = $trip->trip_dateTo; 
                           $trips_array[$index]['mainSyndicate_id'] = $trip->mainSyndicate_id; 
                           $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                           $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                           $trips_array[$index]['trip_image'] = url('/').'/'.$trip->trip_image;  
                           $trips_array[$index]['year'] = $trip->year; 
                           $trips_array[$index]['notes'] = $trip->notes; 
                           $trips_array[$index]['price'] = $trip->price; 
                           $trips_array[$index]['person_price'] = $trip->person_price; 
                           $trips_array[$index]['child_price']  = $trip->child_price; 
                           $index++;
                       }
                       $_response['status'] = 200;
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $trips_array;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = 204;
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 204);
                   }
                   break;
                   
               case '7':
                   # all By sub & season
                   $trips = trips::All()
                            ->where('subSyndicate_id','=',$request->sub_syndicate)
                            ->where('season_id','=',$request->season)
                            ->where('trip_status_id',1);
                   if (count($trips)>0) 
                   {
                       $trips_array = array();
                       $index = 0;
                       foreach($trips as $trip) 
                       { 
                           $trips_array[$index]['trip_ID']    = $trip->trip_ID; 
                           $trips_array[$index]['trip_title'] = $trip->trip_title; 
                           $trips_array[$index]['trip_dateFrom'] = $trip->trip_dateFrom; 
                           $trips_array[$index]['trip_dateTo'] = $trip->trip_dateTo; 
                           $trips_array[$index]['mainSyndicate_id'] = $trip->mainSyndicate_id; 
                           $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                           $trips_array[$index]['subSyndicate_id'] = $trip->subSyndicate_id; 
                           $trips_array[$index]['trip_image'] = url('/').'/'.$trip->trip_image; 
                           $trips_array[$index]['year'] = $trip->year; 
                           $trips_array[$index]['notes'] = $trip->notes; 
                           $trips_array[$index]['price'] = $trip->price; 
                           $trips_array[$index]['person_price'] = $trip->person_price; 
                           $trips_array[$index]['child_price']  = $trip->child_price; 
                           $index++;
                       }
                       $_response['status'] = 200;
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data'] = $trips_array;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = 204;
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 204);
                   }
                   break;

               case '8':
                   # By trip Id
                //    $trip          = trips::where('trip_ID',$request->trip_id)->where('trip_status_id',1)->get()->first();
                   $trip = Trip::where('id',$request->trip_id)->where('trip_status_id',1)->
                   get([
                    'trips.id AS trip_ID','trips.trip_title','trips.trip_dateFrom','trips.trip_dateTo','trips.mainSyndicate_id','trips.subSyndicate_id',
                    'trips.trip_desc','trips.trip_counter','trips.year','trips.cohorts','trips.notes','trips.n_days','trips.n_visits','trips.place_id',
                     DB::raw('CONCAT("'.URL('/').'", trip_image) AS trip_image'),
                    'trips.year','trips.notes','trips.price','trips.person_price','trips.child_price'
                    ])->first();    
                   $place       = Place::where('id',$trip->place_id)->get()->first();  
                   $imagesModel = Image::where('model_id',$place->id)->get(['images.image']);
                   $images = array();
                   foreach ($imagesModel as $key => $value) {
                       $images[$key] = URL('/').$value->image;
                   }

                   $regiments = TripRegiment::where('trip_id',$trip->trip_ID)->get();

                   $trips = array();
                   $trips["trip_title"]    = $trip->trip_title;
                   $trips["trip_dateFrom"] = $trip->trip_dateFrom;
                   $trips["trip_dateTo"]   = $trip->trip_dateTo;
                   $trips["trip_desc"]     = $trip->trip_desc;
                   $trips["trip_image"]    = $trip->trip_image;
                   $trips["trip_counter"]  = $trip->trip_counter;
                   $trips["year"]          = $trip->year;
                   $trips["cohorts"]       = $trip->cohorts;
                   $trips["notes"]         = $trip->notes;
                   $trips["n_days"]        = $trip->n_days;
                   $trips["n_visits"]      = $trip->n_visits;
                   $trips["place_id"]      = $trip->place_id;
                   $trips['price']         = $trip->price; 
                   $trips["place"]         = $place;
                   $trips["images"]        = $images;
                   $trips["regiments"]     = $regiments;
               
                   if (isset($trips))
                   {
                       $_response['status'] = 200;
                       $_response['status_message_en'] = "Found";
                       $_response['status_message_ar'] = "وجدت";
                       $_response['data']              = $trips;
                       return response()->json($_response, 200);
                   } 
                   else {
                       $_response['status'] = 204;
                       $_response['status_message_en'] = "Empty Data";
                       $_response['status_message_ar'] = "لا يوجد بيانات";
                       $_response['data'] = "";
                       return response()->json($_response, 204);
                   }
                   break;
                   
               
               default:
                    $_response['status'] = 204;
                    $_response['status_message_en'] = "fail : Unkown Action Key";
                    $_response['status_message_ar'] = "خطأ فى بيانات";
                    $_response['data'] = "";
                    return response()->json($_response, 204);
                   break;
           }
        } 
        else 
        {
            $_response['status'] = config('constants.Unauthorized');
            $_response['status_message_en'] = "fail : missing paramters";
            $_response['status_message_ar'] = "missing paramters";
            $_response['data'] = "";
            return response()->json($_response, config('constants.Unauthorized'));
        }       
    }

    public function get_request(Request $request)
    {
        if (isset($request->user_number)) 
        {
            $my_requests = tripRequest::where('syndicate_user_number',$request->user_number)
                           ->orderBy('created_at','DESC')->get();            
            $request_array = array();
            $index = 0;            
            foreach ($my_requests as $my_request) 
            {
                $doc_index=1;      
                //////////////////////////////////////////////////////////////////////////////////////////
                $request_array[$index]['id'] = $my_request->id;
                $temp = explode(' ',$my_request->created_at);
                $request_array[$index]['syndicate_user_number'] = $my_request->syndicate_user_number;
                $request_array[$index]['trip']     = $my_request->trip->trip_title;
                $request_array[$index]['regiment'] = $my_request->regiment->date_from;            
    
                if ($my_request->status == 0 || $my_request->status == NULL) {
                    $status = 'طلبكم تحت الدراسة';
                }
                else if($my_request->status == 1) {
                    $status = 'تم قبول الطلب';
                }
                else if($my_request->status == 2) {
                    $status = 'تم رفض الطلب';
                }
                else {
                    $status = NULL;
                }                
                $request_array[$index]['status']                = $status;                
                $request_array[$index]['approval_ammount_cost'] = $my_request->approval_ammount_cost;
                $request_array[$index]['comment']               = $my_request->comment;
                $request_array[$index]['housing_type']          = $my_request->housing_type;
                $request_array[$index]['num_child']             = $my_request->num_child;
                $request_array[$index]['name']                  = $my_request->name;
                $request_array[$index]['date']                  = $my_request->created_at == null ? "" : $temp[0];
                $request_array[$index]['time']                  = $my_request->created_at == null ? "" : date("g:i a", strtotime($temp[1]));          
                $request_array[$index]['status']                = $status;
                
                $index++;
                $message = "نقابتى : $status";                
                
            }
            if (count($request_array) > 0) 
            {
                return response()->json($request_array, 200);
            } 
            else {
                $response['status']  = 200;
                $response['status_message_en'] = 'no data found';
                $response['status_message_ar'] = 'لا يوجد بيانات';
                return response()->json($response, 200);
            }
            
        } 
        else {
                $response['status']  = 200;
                $response['status_message_en'] = 'missed paramters';
                $response['status_message_ar'] = 'حقول ناقصة';
                return response()->json($response, 200);
        }
        
    }

    public function receive_request(Request $request)
    {
        # code
        if(isset($request->json_request))
        {
            $request_array = json_decode($request->json_request);
            if( isset($request_array->syndicate_user_number) && isset($request_array->phone) && isset($request_array->docs_num))
            {
                # code
                $tripRequest = new tripRequest();
                $tripRequest->main_syndicate_id     = isset($request_array->main_syndicate_id) ? $request_array->main_syndicate_id : 0;
                $tripRequest->sub_syndicate_id      = isset($request_array->sub_syndicate_id) ? $request_array->sub_syndicate_id : 0;
                $tripRequest->syndicate_user_number = isset($request_array->syndicate_user_number) ? $request_array->syndicate_user_number : 0;
                $tripRequest->phone                 = isset($request_array->phone) ? $request_array->phone : 0;
                $tripRequest->trip_id               = isset($request_array->trip_id) ? $request_array->trip_id : 0;
                $tripRequest->status                = 0;
                $tripRequest->approval_ammount_cost = 0;
                $tripRequest->comment               = '';
                $tripRequest->last_view             = now();
                $tripRequest->view_by               = 0;
                $tripRequest->regiment_id           = isset($request_array->regiment_id) ? $request_array->regiment_id : 0;
                $tripRequest->regiment_date         = isset($request_array->regiment_date) ? $request_array->regiment_date : 0;
                $tripRequest->housing_type          = isset($request_array->housing_type) ? $request_array->housing_type : 0;
                $tripRequest->num_child             = isset($request_array->num_child) ? $request_array->num_child : 0;
                $tripRequest->ages                  = isset($request_array->ages) ? $request_array->ages : 0;
                $tripRequest->name                  = isset($request_array->name) ? $request_array->name : "";
                $tripRequest->division              = isset($request_array->division) ? $request_array->division : "";
                $tripRequest->address               = isset($request_array->address) ? $request_array->address : "";

                if($tripRequest->save())
                {
                    $index = 1;
                    for ($i=0; $i < $request_array->docs_num ; $i++) 
                    { 
                        $file_name = "doc".$index;
                        if(!empty($request->file($file_name)))
                        {
                            if(File::exists(public_path('/upload/TripRequests/'.$tripRequest->id)) == false ){File::makeDirectory(public_path('/upload/TripRequests/'.$tripRequest->id,0777,true));}
                            // $picture = Image::make($request->file($file_name));
                            
                            
                            $image = $request->file($file_name);
                            $name = time().'.'.$image->getClientOriginalExtension();
                            $destinationPath = public_path('/upload/TripRequests/'.$tripRequest->id.'/');
                            $path = '/upload/TripRequests/'.$tripRequest->id.'/'.$name;
                            $image->move($destinationPath, $name);
                            
                              $medical_request_docs = new tripRequestDoc();
                              // uploadImage();  
                              $medical_request_docs->trip_request_id = $tripRequest->id;
                              $medical_request_docs->doc                = $path;
                              $medical_request_docs->save();
                        }
                        
                        
                        
                        $index++;   
                        
                    }
                    if(isset($request_array->json_persons))
                    {
                        $persons = $request_array->json_persons;
                        foreach($persons as $person)
                        {
                            $trip_request_person = new \App\TripRequestPerson();
                            $trip_request_person->request_id   = $tripRequest->id;
                            $trip_request_person->name         = $person->name;
                            $trip_request_person->relationship = $person->relationship;
                            $trip_request_person->birth_date   = $person->birth_date;
                            $trip_request_person->age_on_trip  = $person->age_on_trip;
                            $trip_request_person->save();
                        }
                                    
                    }
                    $_response['status'] = 200;
                    $_response['status_message_en'] = "thanks , we will response you soon";
                    $_response['status_message_ar'] = "تم إستلام طلبكم بنجاح وسيتم الرد عليكم خلال 48 ساعة";
                    return response()->json($_response, 200);

                }
                else{
                    $_response['status'] = 200;
                    $_response['status_message_en'] = "Error , please try again";
                    $_response['status_message_ar'] = "حدث خطأ برجاء المحاولة مرة اخرى";
                    return response()->json($_response, 200);
                }
            }
            else{
                $response['status']  = 200;
                $response['status_message_ar'] = 'missed paramters in json';
                $response['status_message_en'] = 'missed paramters in json';
                return response()->json($response, 200);
            }
        }
        else{
            $response['status']  = 200;
            $response['status_message_ar'] = 'missed json_request';
            $response['status_message_en'] = 'missed json_request';
            return response()->json($response, 200);
        }
    }
}
