<?php

namespace Tests\Unit;


use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Fake\API\CompanyHouse\CompanyProfile;
use App\Models\Client;

class CompanyHouseApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_get_company_profile()
    {
        $profile = new CompanyProfile();
        $companyProfile = $profile->fetch(10924993, "2018-09-01", "2019-08-31", "2019-09-03", "2019-05-31");
        $companyProfile = json_decode($companyProfile, true);
        $this->assertContains([
            'company_number'=> 10924993,
            'period_start_on' => "2018-09-01", //from
            'period_end_on' => "2019-08-31", //to
            'confirmation_statement' => [
                'next_due' => "2019-09-03"
            ],
            'accounts' => [
                'next_due' => "2019-05-31"
            ]
            ],$companyProfile);
    }
}