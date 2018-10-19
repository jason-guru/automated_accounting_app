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
        DB::table('deadlines')->insert(['name'=> "Sample Deadline", 'message_format_id' => 1]);
    }
}
