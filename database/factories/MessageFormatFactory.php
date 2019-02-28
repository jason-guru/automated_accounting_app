<?php

use App\Models\MessageFormat;
use Faker\Generator as Faker;

$factory->define(MessageFormat::class, function (Faker $faker) {
    return [
        'name' => 'Sample Message Format',
        'sms_format' => 'Hi %mail_to,
                        With regards to your tax payment, please use the following info to make the payment:
                        Reference: %reference_number
                        Amount: %amount
                        Thanks and kind regards,
                        Nathan',
        'email_format' => 'Hi %mail_to,
                        With regards to your tax payment, please use the following info to make the payment:
                        Reference: %reference_number
                        Amount: %amount
                        Thanks and kind regards,
                        Nathan',
        'is_active' => 1
    ];
});
