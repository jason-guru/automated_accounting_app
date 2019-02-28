<?php

use Faker\Generator as Faker;
use App\Models\Client;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'company_number' => mt_rand(10000000, 99999999),
        'company_name' => $faker->company,
        'company_type_id' => 1,
        'accounts_next_due' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'accounts_overdue' => false,
        'country_id' => 4,
        'phone' => '+918794515903',
        'email' => 'jobmails1689@gmail.com'
    ];
});
