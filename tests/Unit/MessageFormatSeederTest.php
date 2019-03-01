<?php

namespace Tests\Unit;
 
use Tests\TestCase;
use App\Business\MessageFormatOptions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Backend\MessageFormatRepository;
 
Class MessageFormatSeederTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function check_if_looping_get_the_desired_output()
    {
        $messageOptions = new MessageFormatOptions();
        $messageFormatRepository = new MessageFormatRepository();
        //5 default deadline types
        for($i=0; $i<5; $i++){
            $code = config('deadline.code.'.$i);
            $formatData = $messageOptions->select($code);
        }

        $this->assertDatabaseHas('message_formats',[
            'name' => 'Annual Accounts Format',
            'name' => 'Confirmation Statement Format',
            'name' => 'VAT Format',
            'name' => 'PAYE Format',
            'name' => 'CIS Format'
        ]);
        
    }
}