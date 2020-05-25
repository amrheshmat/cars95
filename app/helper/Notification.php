<?php 

namespace App\helper;
Class  Notification{
    /**
     * @param array $params
     * @return array
     * @throws Exception
     */
    public static function pushNotification($tokens,$message_title,$message,$request_id,$service_id)
    {
        // define( 'API_ACCESS_KEY', 'AAAAKgieLR4:APA91bFklpH4iAgJ_1tPb0BpjAkQy4g5_7P---IZtMj703d8ThFNv1E4tx2RnNYJ0fL2QyWHjZ1LN6lqfjtUmkweX1OuBJ8Pd8-tYmngCv0xhA_dojHdwlqVBFBz74nf5R2UIRao7e1p');
        // $registrationIds = $tokens;
        // $data = array();
        // $data['title'] = $message_title;
        // $data['body']  = $message;
        // $data['request_id'] = $request_id;        
        // $data['service_id'] = $service_id;        
        // $fields     = array('data'=> $data,'registration_ids' => $registrationIds,'priority'=> 'high');
        // $headers    = array('Authorization: key=' . API_ACCESS_KEY,'Content-Type: application/json'); 
        // $ch = curl_init();
        // curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        // curl_setopt( $ch,CURLOPT_POST, true );
        // curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        // curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        // curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
        // $result = curl_exec($ch );
        // curl_close( $ch );
        

        
        $fields_string = "";
        $postfields = array(
            'tokens' => $tokens[0],
            'message_title' => $message_title,
            'message' => $message,
            'request_id' => $request_id,
            'service_id' => $service_id,
        );
       


        foreach($postfields as $key => $value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');

        



        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, config('app.front_server').'/firebase');
        curl_setopt( $ch,CURLOPT_POST, true );
        // curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch,CURLOPT_POST, count($postfields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        echo $result = curl_exec($ch );
        curl_close( $ch );
    }


}
