<?php

use Faker\Generator as Faker;

$factory->define(App\MedicalRequest::class, function (Faker $faker) {
    return [
        //
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone'=>  $faker->e164PhoneNumber,
                'status'=>0,
                'created_at' => now(),
                'updated_at' => now(),
                'view_by' => 0,
                'main_syndicate_id'=> 5,
                'syndicate_user_number'=> 254851,
                'area_id'=>0,
                'provider_type_id'=>1,
                'provider_id'=>1,
    ];
});
