<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'jobs',
            'sessions',
        ]);

        $this->call(AuthTableSeeder::class);
        $this->call(CompanyTypesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(DesignationsTableSeeder::class);
        $this->call(InitialsTableSeeder::class);
        $this->call(VatSchemeTableSeeder::class);
        $this->call(VatSubmitTypeTableSeeder::class);
        $this->call(FrequencyTableSeeder::class);

        Model::reguard();
    }
}
