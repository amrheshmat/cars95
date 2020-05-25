<?php

use Illuminate\Database\Seeder;

class A001UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
                ['name' => 'Admin','username' => 'admin','email' => 'Admin@gmail.com','password' => bcrypt('welcome'), 'usertype' =>'superadmin'],
                ['name' => 'Opener','username' => 'opener','email' => 'Opener@gmail.com','password' => bcrypt('welcome'),'usertype' =>'user'],
                ['name' => 'Opener2','username' => 'opener2','email' => 'Opener2@gmail.com','password' => bcrypt('welcome'),'usertype' =>'user'],
                ['name' => 'Verifier','username' => 'Verifier','email' => 'Verifier@gmail.com','password' => bcrypt('welcome'),'usertype' =>'user'],
                ['name' => 'Sales','username' => 'Sales','email' => 'Sales@gmail.com','password' => bcrypt('welcome'),'usertype' =>'user'],
                ['name' => 'Advisor','username' => 'Advisor','email' => 'Advisor@gmail.com','password' => bcrypt('welcome'),'usertype' =>'user']
            ]
        );
    }
}
