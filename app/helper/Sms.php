<?php 

namespace App\helper;
use Auth;
use Carbon\Carbon;
Class  Sms{
    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function sendSms($SMSText,$SMSLang,$SMSReceiver)
    {
        // SMSLang=e
        // $link = config("app.SMSL").'?UserName='.config("app.SMSU").'&Password='.config("app.SMSP").'&SMSText='.$SMSText.'&SMSLang='.$SMSLang.'&SMSSender=NEQABTY&SMSReceiver='.$SMSReceiver;
        if(\App\SmsLog::whereDate('created_at', Carbon::today())->where('phone_number',(int)$SMSReceiver)->count() < 5 ){
            $link   = config("app.SMSL").'?';
            $options= array("UserName"=>config("app.SMSU"),"Password"=>config("app.SMSP"),"SMSText"=>$SMSText,"SMSLang"=>$SMSLang,"SMSSender"=>'NEQABTY',"SMSReceiver"=>$SMSReceiver);
            $link  .= http_build_query($options,'','&');
            $sms    = file_get_contents($link) or die(print_r(error_get_last()));
            $sms    = json_decode(json_encode($sms));        
            $SmsLog = \App\SmsLog::create(['phone_number'=>$SMSReceiver,'message'=>$SMSText,'sms_result'=>$sms,'created_by'=>@Auth::user()->id]);
            return Response()->json($sms);
        }
        return Response()->json(100);
    }
        


}
