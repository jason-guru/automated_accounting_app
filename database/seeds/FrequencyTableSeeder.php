<?php

use Illuminate\Database\Seeder;

class FrequencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frequencies = [
            'Once per Year', 'Twice per Year', 'Thrice per Year'
        ];
        foreach($frequencies as $key => $frequency):
            if($key == 2){
                $active = true;
            }else{
                $active = false;
            }
            DB::table('frequencies')->insert(['name' => $frequency, 'is_active' => $active]);
        endforeach;
    }
}
