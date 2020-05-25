<?php

use Illuminate\Database\Seeder;

class A006IpsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ips')->insert([
                ['ip'=>'127.0.0.1'],
                ['ip'=>'192.168.1.1'],
            ]
        );
    }
}
