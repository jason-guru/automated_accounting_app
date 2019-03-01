<?php

use Illuminate\Database\Seeder;
use App\Business\MessageFormatOptions;
use App\Repositories\Backend\MessageFormatRepository;


class MessageFormatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messageOptions = new MessageFormatOptions();
        $messageFormatRepository = new MessageFormatRepository();
        for($i=0; $i<5; $i++){
            $code = config('deadline.code.'.$i);
            $formatData = $messageOptions->select($code);
        }
    }
}
