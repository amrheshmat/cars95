<?php

use Illuminate\Database\Seeder;

class MigrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x = collect(glob('database/migrations/*.php'))->map(function($path){
            $file = explode('.',explode('/',$path)[2])[0];
            $migrationExists = DB::table('migrations')->where('migration', $file)->exists();
            if(!$migrationExists){
                DB::table('migrations')->insert([
                    'migration' => $file,
                    'batch' => 0
                ]);
            }
        });
    }
}
