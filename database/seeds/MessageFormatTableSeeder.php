<?php

use Illuminate\Database\Seeder;


class MessageFormatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sms_body = 'Hello %s, this is a filing reminder for your accounts, which is due on %s. Thanks';
        $email_body = 'Hello %s, 
                       this is a filing reminder for your accounts, which is due on %s. Thanks';
        DB::table('message_formats')->insert(['name'=> "Sample Message Format",'sms_format' => $sms_body, 'email_format' => $email_body]);
    }
}
