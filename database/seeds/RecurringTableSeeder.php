<?php

use Illuminate\Database\Seeder;

class RecurringTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'daily','weekly', 'monthly', 'half-yearly', 'yearly'
        ];
        foreach($names as $name){
            DB::table('recurrings')->insert(['name' => $name]);
        }
    }
}
