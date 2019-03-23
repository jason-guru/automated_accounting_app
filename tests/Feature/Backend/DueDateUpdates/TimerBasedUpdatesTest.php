<?php

namespace Tests\Feature\Backend\DueDateUpdates;
 
use Tests\TestCase;
use App\Business\Services\DueDateUpdate\Processor;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
Class TimerBasedUpdatesTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function check_if_new_expiration_date_is_updated_for_timer_based_types()
    {
        $client = $this->setUpNonApiClientWithDeadline();
        $processor = new Processor();
        $nextDueDate = $processor->timerBased();

        $this->assertDatabaseHas('client_deadline', [
            'due_on' => '21-04-2019'
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'due_on' => '21-06-2019'
        ]);
    }
}