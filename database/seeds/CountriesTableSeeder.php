<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = new Client();
        $countries = $clients->get('https://restcountries.eu/rest/v2/all')->getBody()->getContents();
        foreach(json_decode($countries, true) as $country):
            DB::table('countries')->insert(['name' => $country['name'], 'code' => $country['alpha3Code']]);
        endforeach;
    }
}
