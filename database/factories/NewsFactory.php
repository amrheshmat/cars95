<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        //
        'title' =>  $faker->title,
        'img'   => '/upload/News/10/News.jpg',
        'desc'  => $faker->paragraph,
        'source'=> 'https://www.facebook.com/eea.org.eg/posts/2756932334330449',
        'news_type_id'=>$faker->numberBetween($min = 1, $max = 5),
        'main_syndicate_id'=>5,
        'sub_syndicate_id'=>5,
        'created_at'=>now(),
        'created_by'=>$faker->numberBetween($min = 1, $max = 3),
    ];
});
