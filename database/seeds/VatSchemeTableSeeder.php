<?php

use Illuminate\Database\Seeder;

class VatSchemeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vat_schemes = [
            'Non-Vat Registered', 'Accrual Based', 'Case Based Normal Scheme', 'Flat Rate Accrual Based', 'Flat Rate Cash Based'
        ];
        foreach($vat_schemes as $vat_scheme):
            DB::table('vat_schemes')->insert(['name' => $vat_scheme]);
        endforeach;
    }
}
