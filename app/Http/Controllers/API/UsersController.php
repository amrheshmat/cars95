<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrganizationMember;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use DB;

class UsersController extends Controller
{
    public function sign_up(Request $request)
    {
        if (isset($request->mobile) && isset($request->mobile_token) && isset($request->main_syndicate) && isset($request->sub_syndicate) ) 
        {
            $user = OrganizationMember::where('mobile', '=', $request->mobile)->first();
            if ($user === null) 
            {
                $token  = Password::getRepository()->createNewToken();
                $verification_code = rand();
                $member = new OrganizationMember();
                $member->mobile = isset($request->mobile) ? $request->mobile : NULL;
                $member->main_syndicate_id = isset($request->main_syndicate_id) ? $request->main_syndicate_id : NULL;
                $member->sub_syndicate_id = isset($request->sub_syndicate_id) ? $request->sub_syndicate_id : NULL;
                $member->user_number = isset($request->syndicate_user_number) ? $request->syndicate_user_number : NULL;
                $member->verification_code = $verification_code;
                $member->password = isset($request->password) ? Hash::make($request->password) : Hash::make($verification_code);
                $member->user_token = $token;
                $member->mobile_token = isset($request->mobile_token) ? $request->mobile_token : NULL;
                if($member->save())
                {
                    $_response['status'] = 200;
                    $_response['status_message_en'] = "user created successfully";
                    $_response['status_message_ar'] = "تم إنشاء المستخدم بنجاح";
                    return response()->json($_response, 200);
                }
                else{
                    $_response['status'] = 204;
                    $_response['status_message_en'] = "Error";
                    $_response['status_message_ar'] = "خطأ فى حفظ البيانات";
                    return response()->json($_response, 200);                    
                }
                
            }else{
                DB::table('organization_members')->where('mobile', '=', $request->mobile )->update(['main_syndicate_id'       => isset($request->main_syndicate) ? $request->main_syndicate : "",'sub_syndicate_id'        => isset($request->sub_syndicate)  ? $request->sub_syndicate  : "",            'mobile_token'            => isset($request->mobile_token) ? $request->mobile_token : 'false',]);
                 $_response['status'] = 200;
                 $_response['status_message_en'] = "user updated successfully";
                 $_response['status_message_ar'] = "تم تحديث المستخدم بنجاح";
                 return response()->json($_response, 200);
            }          
        }else{
            $_response['status'] = 200;
            $_response['status_message_en'] = "fail : missing paramters";
            $_response['status_message_ar'] = "خطأ غير معلوم";
            $_response['data'] = "";
            return response()->json($_response, 200);
        }
    }
}
