<?php

use Illuminate\Database\Seeder;

class VatSubmitTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vat_submit_types = [
            'Monthly', 'Quaterly', 'Yearly'
        ];
        foreach($vat_submit_types as $vat_submit_type):
            DB::table('vat_submit_types')->insert(['name' => $vat_submit_type]);
        endforeach;
    }
}
