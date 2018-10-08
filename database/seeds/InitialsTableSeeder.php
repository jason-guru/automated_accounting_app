<?php

use Illuminate\Database\Seeder;

class InitialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $initials = [
            'Mr', 'Mrs', 'Miss', 'Ms', 'Dr', 'Sir', 'Lord', 'Lady', 'Dame'
        ];
        foreach($initials as $initial):
            DB::table('initials')->insert(['name' => $initial]);
        endforeach;
    }
}
