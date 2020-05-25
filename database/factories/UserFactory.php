<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
/*
$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

*/

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
    	'title_id'         => $faker->numberBetween($min = 1, $max = 4),
    	'state_id'         => $faker->numberBetween($min = 1, $max = 51),
        'first_name'       => $faker->name,
        'middle_initial'   => $faker->name,
        'last_name'        => $faker->name,
        'email'            => $faker->unique()->safeEmail,
        'address1'         => $faker->address,
        'address2'         => $faker->address,
        'apt_unit'         => $faker->postcode,
        'zip'              => $faker->postcode,
        'city'             => $faker->city,
        'fax'              => $faker->phoneNumber,
    	'date_of_birth'    => $faker->dateTime($max = '2008-04-25 08:37:17', $timezone = null),
    	'ssn'	           => $faker->areaCode,
    	'has_internet_access' =>$faker->randomElement($array = array ('on',' ')),
        'has_email' =>$faker->randomElement($array = array ('on',' ')),
        'has_cell' =>$faker->randomElement($array = array ('on',' ')),
        'has_checking' =>$faker->randomElement($array = array ('on',' ')),
    	'notes'=> $faker->text,
    	'callcenter_id' => $faker->numberBetween($min = 1, $max = 2),
    	'dispatch_id' => $faker->numberBetween($min = 1, $max = 3),
        'dispatch_level' => $faker->numberBetween($min = 1, $max = 3),
    	'created_by' => $faker->numberBetween($min = 1, $max = 5),
        'created_at'    => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+2 day', $timezone = null) // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
    ];
});
$factory->define(App\Phone::class, function (Faker $faker) {
    return [
         'customer_id' => function () {
            return factory(App\Customer::class)->create()->id;
        },
        'phone'         => $faker->unique()->e164PhoneNumber,
        'created_by' => $faker->numberBetween($min = 1, $max = 5),
        'created_at'    => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+2 day', $timezone = null) // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
    ];
});

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
         'customer_id' => function () {
            return factory(App\Customer::class)->create()->id;
        },
        'customer_note'         => $faker->text,
        'created_by' => $faker->numberBetween($min = 1, $max = 5),
        'created_at'    => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+2 day', $timezone = null) // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
    ];
});
$factory->define(App\Financial::class, function (Faker $faker) {
    return [
         'customer_id' => function () {
            return factory(App\Customer::class)->create()->id;
        },


        'account_number'         => $faker->unique()->e164PhoneNumber,
        'bank_name'         => $faker->name,
        'bank_country'      => $faker->country,
        'amount_available'  => $faker->numberBetween($min = 1000, $max = 2000),
        'amount_available'  => $faker->numberBetween($min = 100, $max = 1000),
        'expiry_month' => $faker->month($max = '12'),
        'expiry_year'  => $faker->numberBetween($min = 18, $max = 25),
        'cvv'          => $faker->numberBetween($min = 100, $max = 999),
        'created_by' => $faker->numberBetween($min = 1, $max = 5),
        'created_at'    => $faker->dateTimeBetween($startDate = '-1 years', $endDate = '+2 day', $timezone = null) // DateTime('2003-03-15 02:00:49', 'Africa/Lagos')
    ];
});




