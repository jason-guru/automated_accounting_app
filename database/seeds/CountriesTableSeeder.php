<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
                'Wales',
                'England',
                'Scotland',
                'Great Britain',
                'Not specified',
                'United Kingdom',
                'Northern Ireland'
        ];
        foreach($countries as $country):
            DB::table('countries')->insert(['name' => $country]);
        endforeach;
    }
}
