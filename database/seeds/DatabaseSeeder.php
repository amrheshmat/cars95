<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\News::class, 10000)->create();
        factory(App\MedicalRequest::class, 10000)->create();
        /*
            $this->call(A001UsersTableSeeder::class);
            $this->call(A002RolesTableSeeder::class);
            $this->call(A003RoleUserTableSeeder::class);
            $this->call(A004CallcentersTableSeeder::class);
            $this->call(A005CallcenterUserTableSeeder::class);
            $this->call(A006IpsTableSeeder::class);
            $this->call(A007IprelationsTableSeeder::class);
            $this->call(A008DispatchesTableSeeder::class);
            $this->call(A009TitlesTableSeeder::class);
            $this->call(A010StatesTableSeeder::class);
            $this->call(A008CitiesTableSeeder::class);
            $this->call(A009RegionsTableSeeder::class);
            $this->call(A010DonationTypesTableSeeder::class);
            $this->call(A011GuidanceAreasTableSeeder::class);
            $this->call(A012SourcesTableSeeder::class);
            $this->call(A013CurrenciesTableSeeder::class);
            $this->call(A013CustomersTableSeeder::class);
        */
    }
}