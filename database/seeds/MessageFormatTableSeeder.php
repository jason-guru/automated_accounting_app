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
        $sms_body = 'Hi %mail_to,
        With regards to your tax payment, please use the following info to make the payment:
        Reference: %reference_number
        Amount: %amount
        Thanks and kind regards,
        Nathan';
        $email_body = 'Hi %mail_to,
        With regards to your tax payment, please use the following info to make the payment:
        Reference: %reference_number
        Amount: %amount
        Thanks and kind regards,
        Nathan';
        DB::table('message_formats')->insert(['name'=> "Sample Message Format",'sms_format' => $sms_body, 'email_format' => $email_body]);
    }
}
