<?php

use Illuminate\Database\Seeder;

class MessageFormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('message_formats')->insert(['sms_format' => "Hello %s, this is an account filing reminder. Your account's next due date is on %s.", 'email_format' => "Hello %s, 
        this is an account filing reminder. 
        Your account's next due date is on %s."]);
    }
}
