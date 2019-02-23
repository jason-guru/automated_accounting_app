<?php

use Faker\Generator as Faker;
use App\Models\Deadline;

$factory->define(Deadline::class, function (Faker $faker) {
    return [
       'name' => 'Vat',
       'message_format_id' => 1,
       'code' => 'VAT'
    ];
});
