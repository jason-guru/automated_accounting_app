<?php

namespace Tests\Featured\DueDateUpdates;
 
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Business\Services\DueDateUpdate\Processor;
 
Class APiBasedUpdatesTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function check_if_new_expiration_date_is_updated_for_outdated_due_dates()
    {
        $companyNumber = '11141106';
        $client = $this->setUpClientWithDeadline($companyNumber);
        $this->get('api/deadlines/auto/update');
        // $processor = new Processor();
        // $nextDueDate = $processor->apiBased($companyNumber);
        $this->assertDataBaseHas('client_deadline',[
            'due_on' => '2020-01-22'
        ]);
    }


}