<?php

namespace Tests\Unit\Refactored;
 
use Tests\TestCase;
use App\Business\Services\DueDateUpdate\Computations;
 
Class QuaterlyCalculateTest extends TestCase
{
    /** @test */
    public function check_if_next_quaterly_due_date_for_a_due_date_is_calculated()
    {
        $compute = new Computations();
        $nextDueDate = $compute->quaterly('20-03-2019');
        $this->assertEquals($nextDueDate, '20-06-2019');
    }
}