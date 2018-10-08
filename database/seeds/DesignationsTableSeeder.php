<?php

use Illuminate\Database\Seeder;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            'Director', 'Staff', 'Partner', 'Representative', 'Owner', 'Other'
        ];
        foreach($designations as $designation):
            DB::table('designations')->insert(['name' => $designation]);
        endforeach;
    }
}
