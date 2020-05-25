<?php

use Illuminate\Database\Seeder;

class A002RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('roles')->insert([
                ['name' => 'Admin','slug' => 'admin','description'=>'Have full access','level' => 1],
                ['name' => 'Opener','slug' => 'opener','description'=>'Have opener access','level' => 2],
                ['name' => 'Verifier','slug' => 'verifier','description'=>'Have verifier access','level' => 3],
                ['name' => 'Sales','slug' => 'sales','description'=>'Have sales access','level' => 4],
                ['name' => 'Advisor' ,'slug' => 'advisor' ,'description'=>'Have advisor access','level' => 5]
            ]
        );
    }
}
