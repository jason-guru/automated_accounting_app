<?php

use Illuminate\Database\Seeder;

class DeadlineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('deadlines')->insert(['name'=> "Annual Accounts", 'message_format_id' => 1, 'code' => 'AA']);
        DB::table('deadlines')->insert(['name'=> "Confirmation Statement", 'message_format_id' => 2, 'code' => 'CS']);
        DB::table('deadlines')->insert(['name'=> "VAT", 'message_format_id' => 3, 'code' => 'VAT']);
        DB::table('deadlines')->insert(['name'=> "Paye", 'message_format_id' => 4, 'code' => 'PAYE']);
        DB::table('deadlines')->insert(['name'=> "CIS", 'message_format_id' => 5, 'code' => 'CIS']);
    }
}
