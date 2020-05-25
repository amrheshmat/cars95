<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\OrganizationMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpgradeController extends Controller
{

    /**
     * Login using verification_code
     *
     * @return void
     */
    public function UpgradeToClient(Request $request)
    {
        $member = $request->user();
        $this->validate($request, [
            'user_number' => 'required',
            //'token' => 'required'
        ]);

        isset($request->mobile_token) ? $mobile_token = $request->mobile_token : $mobile_token= " ";

        if($request->user_number == '333')
            return response()->json(['error' => 'Invalid user unmber'], 400);
      
        if(!$member)
            return response()->json(['error' => 'User does not exist'], 400);

        if ($member->type != 'visitor')
            return response()->json(['error' => 'Invalid user type'], 400);
        
        $member->user_number = $request->user_number;
        $member->type = 'client';
        $member->mobile_token = $mobile_token;
        $member->save();
        return response()->json(['data' => 
            [
                'token' => $member->api_token,
                'type' => $member->type,
                'name' => 'Mona'
            ]
        ]);
    }
           
}
