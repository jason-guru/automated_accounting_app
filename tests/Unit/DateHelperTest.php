<?php

namespace Tests\Unit;
 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
Class DateHelperTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function check_if_helper_is_working()
    {   
        $date = carbon_parse('19-12-15');
        $this->assertEquals(
            $date, "2019-12-15"
        );
    }
}