<?php

use Illuminate\Database\Seeder;

class A007IprelationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('iprelations')->insert([
                ['ip_id'=>'1','iprelation_id'=>'1','iprelation_type'=>'App\User'],
                ['ip_id'=>'1','iprelation_id'=>'1','iprelation_type'=>'App\Callcenter'],
                ['ip_id'=>'2','iprelation_id'=>'1','iprelation_type'=>'App\Callcenter'],
                ['ip_id'=>'2','iprelation_id'=>'1','iprelation_type'=>'App\User'],
                
            ]
        );
    }
}
