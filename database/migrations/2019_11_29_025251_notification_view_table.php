<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NotificationViewTable extends Migration
{    
    public function up()
    {
          
        DB::statement('CREATE VIEW notifications AS SELECT `medical_requests`.`request_id` as request_id, 1 as notification_type_id , "مطالبات طبية" as notification_type ,  "مقدم الخدمة" as requester_title , statuses.name as status_name , DATE(medical_requests.created_at) as date ,   DATE_FORMAT(`medical_requests`.`created_at`,"%h:%i %p") as time , `medical_requests`.`mobile_view` as mobile_view  ,  `medical_requests`.`syndicate_user_number` as user_number  , `medical_requests`.`name`  as requester_name , `medical_requests`.`created_at` as created_at   FROM medical_requests            Right join statuses on statuses.id = medical_requests.status             
        UNION SELECT `trips_requests`.`id` as request_id, 2 as notification_type_id , "الرحلات" as notification_type ,  "طالب الخدمة" as requester_title , statuses.name as status_name , DATE(`trips_requests`.`created_at`) as date ,              DATE_FORMAT(`trips_requests`.`created_at`,"%h:%i %p") as time ,`trips_requests`.`mobile_view` as mobile_view  ,`trips_requests`.`syndicate_user_number` as user_number      , `trips_requests`.`name` as  requester_name  ,  `trips_requests`.`created_at` as created_at   FROM trips_requests    Right join statuses on statuses.id = trips_requests.status              
        UNION SELECT `engineering_records_requests`.`request_id` as request_id, 3 as notification_type_id , "السجلات الهندسية" as notification_type ,              "طالب الخدمة" as requester_title , statuses.name as status_name ,              DATE(`engineering_records_requests`.`created_at`) as date ,              DATE_FORMAT(`engineering_records_requests`.`created_at`,"%h:%i %p") as time ,`engineering_records_requests`.`mobile_view` as mobile_view     ,`engineering_records_requests`.`syndicate_user_number`  , `engineering_records_requests`.`name`  as requester_name  ,   `engineering_records_requests`.`created_at` as created_at   FROM engineering_records_requests            Right join statuses on statuses.id = engineering_records_requests.status        
        ');
    }
    
    public function down()
    {
        DB::statement( 'DROP VIEW notifications' );
    }
}
