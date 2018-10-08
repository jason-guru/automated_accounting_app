<?php

use Illuminate\Database\Seeder;

class CompanyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_types = [
            'Limited', 'Sole Trader', 'Partnership', 'Limited Liability Partnership', 'Trust', 'Individual', 'Charity'
        ];
        foreach($company_types as $company_type):
            DB::table('company_types')->insert(['name' => $company_type]);
        endforeach;
    }
}
