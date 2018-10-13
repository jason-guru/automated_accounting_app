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
            'ltd' => "Private limited company",
            'str' => "Sole Trader",
            'prt' => "Partnership",
            'trt' => "Trust",
            'llp' => "Limited liability partnership",
            'ind' => "Individual",
            'cry' => "Charity"
        ];
        foreach($company_types as $key => $company_type):
            DB::table('company_types')->insert(['code' => $key, 'name' => $company_type]);
        endforeach;
    }
}
