<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Syndicate;
use App\SubSyndicate;
use DB;

class SyndicatesController extends Controller
{
    public function all_syndicates()
    {
        # Get All Syndicates with it`s sub syndicates
        $syndicates = Syndicate::where('syndicate_parent_id','<>',0)->where('syndicate_level',3)->get([
            'id AS syndicate_id','syndicate_desc_ar','syndicate_desc_en','governorate_id','syndicate_parent_id','syndicate_level',
            'syndicate_address','syndicate_phoneNumber','syndicate_email',
            DB::raw('CONCAT("'.URL('/').'", syndicate_logo) AS syndicate_logo'),
            'created_by','updated_by', 'created_at', 'updated_at',   'syndicate_fax', 'syndicate_mobile', 'captain',  'cashier',
            'assistant_secretary_general','assistant_cashier', 'members', 'syndicate_agent','secretary_general', 'bio',
        ]);
        $all_syndicates = array();
        $index_main = 0;
        $index_sub  = 0;
        // foreach ($syndicates as $main_syndicates) 
        // {
        //     $sub_syndicates = SubSyndicate::where('syndicate_level',4)
        //                       ->where('syndicate_parent_id',$main_syndicates->syndicate_id)->get();

        //     $all_syndicates[$index_main]['syndicate_id'] = $main_syndicates->id;
        //     $all_syndicates[$index_main]['syndicate_desc_ar'] = $main_syndicates->syndicate_desc_ar;
        //     $all_syndicates[$index_main]['syndicate_desc_en'] = $main_syndicates->syndicate_desc_en;
        //     $all_syndicates[$index_main]['syndicate_address'] = $main_syndicates->syndicate_address;
        //     $all_syndicates[$index_main]['syndicate_phoneNumber'] = $main_syndicates->syndicate_phoneNumber;
        //     $all_syndicates[$index_main]['syndicate_email'] = $main_syndicates->syndicate_email;
        //     $all_syndicates[$index_main]['governorate_id'] = $main_syndicates->governorate_id;
        //     $all_syndicates[$index_main]['syndicate_logo'] = url('/').$main_syndicates->syndicate_logo;
        //     $all_syndicates[$index_main]['syndicate_fax'] = $main_syndicates->syndicate_fax;
        //     $all_syndicates[$index_main]['syndicate_mobile'] = $main_syndicates->syndicate_mobile;
        //     $all_syndicates[$index_main]['captain'] = $main_syndicates->captain;
        //     $all_syndicates[$index_main]['cashier'] = $main_syndicates->cashier;
        //     $all_syndicates[$index_main]['assistant_secretary_general'] = $main_syndicates->assistant_secretary_general;
        //     $all_syndicates[$index_main]['assistant_cashier'] = $main_syndicates->assistant_cashier;
        //     $all_syndicates[$index_main]['members'] = $main_syndicates->members;
        //     $all_syndicates[$index_main]['syndicate_agent'] = $main_syndicates->syndicate_agent;
        //     $all_syndicates[$index_main]['secretary_general'] = $main_syndicates->secretary_general;
        //     $all_syndicates[$index_main]['bio'] = $main_syndicates->bio;
        //     $all_syndicates[$index_main]['sub_sundicates'] = $sub_syndicates;
        //     $index_main++;
        // }
        
        $_response['status']            = 200;
        $_response['status_message_en'] = "Found";
        $_response['status_message_ar'] = "وجدت";
        $_response['data'] = $syndicates;
        
        return response()->json($_response, 200);
    }

    public function all_mainSyndicates()
    {
        $syndicates = Syndicate::where('syndicate_level','=',3)->get([
            'id AS syndicate_id','syndicate_desc_ar','syndicate_desc_en','governorate_id','syndicate_parent_id','syndicate_level',
            'syndicate_address','syndicate_phoneNumber','syndicate_email',
            DB::raw('CONCAT("'.URL('/').'", syndicate_logo) AS syndicate_logo'),
            'created_by','updated_by', 'created_at', 'updated_at',   'syndicate_fax', 'syndicate_mobile', 'captain',  'cashier',
            'assistant_secretary_general','assistant_cashier', 'members', 'syndicate_agent','secretary_general', 'bio',
        ]);
        if (count($syndicates)>0) 
        {
            $_response['status'] = 200;
            $_response['status_message_en'] = "Found";
            $_response['status_message_ar'] = "وجدت";
            $_response['data'] = $syndicates;
            return response()->json($_response, 200);
        } 
        else {
            $_response['status'] = 200;
            $_response['status_message_en'] = "Empty Data";
            $_response['status_message_ar'] = "لا يوجد بيانات";
            $_response['data'] = "";
            return response()->json($_response, 200);
        }      
    }

    public function sub_syndicates(Request $request)
    {
        if (isset($request->action)) 
        {
            switch ($request->action) {
                case '1':
                    $syndicates = SubSyndicate::where('id',$request->main_syndicate)->get(['id AS syndicate_id','sub_syndicate_name_ar as syndicate_desc_en','sub_syndicate_name_en as syndicate_desc_en','sub_governorate_id as governorate_id','sub_syndicate_parent_id as sub_syndicate_parent_id','sub_syndicate_level as syndicate_level',                        'sub_syndicate_address as syndicate_address',                        'sub_syndicate_phoneNumber as syndicate_phoneNumber',                        'sub_syndicate_email as syndicate_email',                         DB::raw('CONCAT("'.URL('/').'", sub_syndicate_logo) AS syndicate_logo'),                        'created_by','updated_by', 'created_at', 'updated_at',                           'sub_syndicate_fax as syndicate_fax',                         'sub_syndicate_email as syndicate_mobile',                         'sub_captain as captain',                          'sub_cashier as cashier', 'sub_assistant_secretary_general as assistant_secretary_general','sub_assistant_cashier as assistant_cashier','sub_members as members','sub_syndicate_agent as syndicate_agent', 'sub_secretary_general as secretary_general','sub_bio as bio',]);
                    if (count($syndicates)>0) 
                    {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Found";
                        $_response['status_message_ar'] = "وجدت";
                        $_response['data'] = $syndicates;
                        return response()->json($_response, 200);
                    } 
                    else {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Empty Data";
                        $_response['status_message_ar'] = "لا يوجد بيانات";
                        $_response['data'] = "";
                        return response()->json($_response, 200);
                    }
                    break;
                case '2':
                    # all sub by gov
                    $syndicates = SubSyndicate::where('governorate_id','=',$request->gov)
                                            ->where('syndicate_level','=',4)->get(['id AS syndicate_id','sub_syndicate_name_ar as syndicate_desc_en','sub_syndicate_name_en as syndicate_desc_en','sub_governorate_id as governorate_id','sub_syndicate_parent_id as sub_syndicate_parent_id','sub_syndicate_level as syndicate_level',                        'sub_syndicate_address as syndicate_address',                        'sub_syndicate_phoneNumber as syndicate_phoneNumber',                        'sub_syndicate_email as syndicate_email',                         DB::raw('CONCAT("'.URL('/').'", sub_syndicate_logo) AS syndicate_logo'),                        'created_by','updated_by', 'created_at', 'updated_at',                           'sub_syndicate_fax as syndicate_fax',                         'sub_syndicate_email as syndicate_mobile',                         'sub_captain as captain',                          'sub_cashier as cashier', 'sub_assistant_secretary_general as assistant_secretary_general','sub_assistant_cashier as assistant_cashier','sub_members as members','sub_syndicate_agent as syndicate_agent', 'sub_secretary_general as secretary_general','sub_bio as bio',]);
                    if (count($syndicates)>0) 
                    {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Found";
                        $_response['status_message_ar'] = "وجدت";
                        $_response['data'] = $syndicates;
                        return response()->json($_response, 200);
                    } 
                    else {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Empty Data";
                        $_response['status_message_ar'] = "لا يوجد بيانات";
                        $_response['data'] = "";
                        return response()->json($_response, 200);
                    }
                    break;
                case '3':
                    # all sub by main and gov
                    $syndicates = SubSyndicate::where('governorate_id','=',$request->gov)
                                            ->where('syndicate_parent_id','=',$request->main_syndicate)
                                            ->where('syndicate_level','=',4)->get(['id AS syndicate_id','sub_syndicate_name_ar as syndicate_desc_en','sub_syndicate_name_en as syndicate_desc_en','sub_governorate_id as governorate_id','sub_syndicate_parent_id as sub_syndicate_parent_id','sub_syndicate_level as syndicate_level',                        'sub_syndicate_address as syndicate_address',                        'sub_syndicate_phoneNumber as syndicate_phoneNumber',                        'sub_syndicate_email as syndicate_email',                         DB::raw('CONCAT("'.URL('/').'", sub_syndicate_logo) AS syndicate_logo'),                        'created_by','updated_by', 'created_at', 'updated_at',                           'sub_syndicate_fax as syndicate_fax',                         'sub_syndicate_email as syndicate_mobile',                         'sub_captain as captain',                          'sub_cashier as cashier', 'sub_assistant_secretary_general as assistant_secretary_general','sub_assistant_cashier as assistant_cashier','sub_members as members','sub_syndicate_agent as syndicate_agent', 'sub_secretary_general as secretary_general','sub_bio as bio',]);
                    if (count($syndicates)>0) 
                    {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Found";
                        $_response['status_message_ar'] = "وجدت";
                        $_response['data'] = $syndicates;
                        return response()->json($_response, 200);
                    } 
                    else {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Empty Data";
                        $_response['status_message_ar'] = "لا يوجد بيانات";
                        $_response['data'] = "";
                        return response()->json($_response, 200);
                    }
                    break;
                case '4':
                    # all sub by main 
                    $syndicates = SubSyndicate::where('id','=',$request->main_syndicate)->get(['id AS syndicate_id','sub_syndicate_name_ar as syndicate_desc_en','sub_syndicate_name_en as syndicate_desc_en','sub_governorate_id as governorate_id','sub_syndicate_parent_id as sub_syndicate_parent_id','sub_syndicate_level as syndicate_level',                        'sub_syndicate_address as syndicate_address',                        'sub_syndicate_phoneNumber as syndicate_phoneNumber',                        'sub_syndicate_email as syndicate_email',                         DB::raw('CONCAT("'.URL('/').'", sub_syndicate_logo) AS syndicate_logo'),                        'created_by','updated_by', 'created_at', 'updated_at',                           'sub_syndicate_fax as syndicate_fax',                         'sub_syndicate_email as syndicate_mobile',                         'sub_captain as captain',                          'sub_cashier as cashier', 'sub_assistant_secretary_general as assistant_secretary_general','sub_assistant_cashier as assistant_cashier','sub_members as members','sub_syndicate_agent as syndicate_agent', 'sub_secretary_general as secretary_general','sub_bio as bio',]);
                    if (count($syndicates)>0) 
                    {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Found";
                        $_response['status_message_ar'] = "وجدت";
                        $_response['data'] = $syndicates;
                        return response()->json($_response, 200);
                    } 
                    else {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Empty Data";
                        $_response['status_message_ar'] = "لا يوجد بيانات";
                        $_response['data'] = "";
                        return response()->json($_response, 200);
                    }
                    break;
                case '5':
                    # sub by id 
                    $syndicates = SubSyndicate::where('id','=',$request->syndicate_id)
                                            ->where('syndicate_level','=',4)->get(['id AS syndicate_id','sub_syndicate_name_ar as syndicate_desc_en','sub_syndicate_name_en as syndicate_desc_en','sub_governorate_id as governorate_id','sub_syndicate_parent_id as sub_syndicate_parent_id','sub_syndicate_level as syndicate_level',                        'sub_syndicate_address as syndicate_address',                        'sub_syndicate_phoneNumber as syndicate_phoneNumber',                        'sub_syndicate_email as syndicate_email',                         DB::raw('CONCAT("'.URL('/').'", sub_syndicate_logo) AS syndicate_logo'),                        'created_by','updated_by', 'created_at', 'updated_at',                           'sub_syndicate_fax as syndicate_fax',                         'sub_syndicate_email as syndicate_mobile',                         'sub_captain as captain',                          'sub_cashier as cashier', 'sub_assistant_secretary_general as assistant_secretary_general','sub_assistant_cashier as assistant_cashier','sub_members as members','sub_syndicate_agent as syndicate_agent', 'sub_secretary_general as secretary_general','sub_bio as bio',])->first();
                    if (count($syndicates)>0) 
                    {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Found";
                        $_response['status_message_ar'] = "وجدت";
                        $_response['data'] = $syndicates;
                        return response()->json($_response, 200);
                    } 
                    else {
                        $_response['status'] = 200;
                        $_response['status_message_en'] = "Empty Data";
                        $_response['status_message_ar'] = "لا يوجد بيانات";
                        $_response['data'] = "";
                        return response()->json($_response, 200);
                    }
                    break;            
                default:
                    # code...
                    break;
            }
        }
        else{
            $_response['status'] = config('constants.Unauthorized');
            $_response['status_message_en'] = "fail : missing paramters";
            $_response['status_message_ar'] = "خطأ غير معلوم";
            $_response['data'] = "";
            return response()->json($_response, 200);
        }        
    }

    public function main_syndicates(Request $request)
    {
        if (isset($request->syndicate_id)) 
        {
            $syndicates = Syndicate::where('syndicate_level','=',3)
                          ->where('id',$request->syndicate_id)->get([
                            'id AS syndicate_id','syndicate_desc_ar','syndicate_desc_en','governorate_id','syndicate_parent_id','syndicate_level',
                            'syndicate_address','syndicate_phoneNumber','syndicate_email',
                            DB::raw('CONCAT("'.URL('/').'", syndicate_logo) AS syndicate_logo'),
                            'created_by','updated_by', 'created_at', 'updated_at',   'syndicate_fax', 'syndicate_mobile', 'captain',  'cashier',
                            'assistant_secretary_general','assistant_cashier', 'members', 'syndicate_agent','secretary_general', 'bio',
                        ])->first();        
            if (isset($syndicates)) 
            {
                $_response['status'] = 200;
                $_response['status_message_en'] = "Found";
                $_response['status_message_ar'] = "وجدت";
                $_response['data'] = $syndicates;
                return response()->json($_response, 200);
            } 
            else {
                $_response['status'] = 200;
                $_response['status_message_en'] = "Empty Data";
            $_response['status_message_ar'] = "لا يوجد بيانات";
                $_response['data'] = "";
                return response()->json($_response, 200);
            }
        } 
        else 
        {
            $_response['status'] = 200;
            $_response['status_message'] = "fail : missing paramters";
            $_response['data'] = "";
            return response()->json($_response, 200);
        }
               
    }

    public function all_main()
    {
        # Get All Syndicates with it`s sub syndicates
        $syndicates = Syndicate::where('syndicate_parent_id','<>',0)->where('syndicate_level',3)->get([
            'id AS syndicate_id','syndicate_desc_ar','syndicate_desc_en','governorate_id','syndicate_parent_id','syndicate_level',
            'syndicate_address','syndicate_phoneNumber','syndicate_email',
            DB::raw('CONCAT("'.URL('/').'", syndicate_logo) AS syndicate_logo'),
            'created_by','updated_by', 'created_at', 'updated_at',   'syndicate_fax', 'syndicate_mobile', 'captain',  'cashier',
            'assistant_secretary_general','assistant_cashier', 'members', 'syndicate_agent','secretary_general', 'bio',
        ]);
        $all_syndicates = array();
        $index_main = 0;
        $index_sub  = 0;
        foreach ($syndicates as $main_syndicates) 
        {
            $sub_syndicates = SubSyndicate::where('sub_syndicate_level',4)
                              ->where('sub_syndicate_parent_id',$main_syndicates->syndicate_id)->get();

            $all_syndicates[$index_main]['syndicate_id'] = $main_syndicates->id;
            $all_syndicates[$index_main]['syndicate_desc_ar'] = $main_syndicates->syndicate_desc_ar;
            $all_syndicates[$index_main]['syndicate_desc_en'] = $main_syndicates->syndicate_desc_en;
            $all_syndicates[$index_main]['syndicate_address'] = $main_syndicates->syndicate_address;
            $all_syndicates[$index_main]['syndicate_phoneNumber'] = $main_syndicates->syndicate_phoneNumber;
            $all_syndicates[$index_main]['syndicate_email'] = $main_syndicates->syndicate_email;
            $all_syndicates[$index_main]['governorate_id'] = $main_syndicates->governorate_id;
            $all_syndicates[$index_main]['syndicate_logo'] = url('/').$main_syndicates->syndicate_logo;
            $all_syndicates[$index_main]['syndicate_fax'] = $main_syndicates->syndicate_fax;
            $all_syndicates[$index_main]['syndicate_mobile'] = $main_syndicates->syndicate_mobile;
            $all_syndicates[$index_main]['captain'] = $main_syndicates->captain;
            $all_syndicates[$index_main]['cashier'] = $main_syndicates->cashier;
            $all_syndicates[$index_main]['assistant_secretary_general'] = $main_syndicates->assistant_secretary_general;
            $all_syndicates[$index_main]['assistant_cashier'] = $main_syndicates->assistant_cashier;
            $all_syndicates[$index_main]['members'] = $main_syndicates->members;
            $all_syndicates[$index_main]['syndicate_agent'] = $main_syndicates->syndicate_agent;
            $all_syndicates[$index_main]['secretary_general'] = $main_syndicates->secretary_general;
            $all_syndicates[$index_main]['bio'] = $main_syndicates->bio;
            $all_syndicates[$index_main]['sub_sundicates'] = $sub_syndicates;
            $index_main++;
        }
        
        $_response['status']            = 200;
        $_response['status_message_en'] = "Found";
        $_response['status_message_ar'] = "وجدت";
        $_response['data'] = $all_syndicates;
        
        return response()->json($_response, 200);  
    }


    
    

}
