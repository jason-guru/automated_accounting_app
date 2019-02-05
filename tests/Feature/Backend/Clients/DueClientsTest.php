<?php

namespace Tests\Feature\Backend;


use Tests\TestCase;
use App\Models\Client;
use Illuminate\Support\Carbon;
use App\Repositories\Backend\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Business\Api\CompanyHouse\CompanyProfile;
use App\Fake\API\CompanyHouse\CompanyProfile as CompanyFakeProfile;

class DueClientsTestTest extends TestCase
{
    use RefreshDatabase;
     /**
     * @var ClientRepository
     */
    protected $clientRepository;
    protected $profile;
    protected $fakeProfile;

    protected function setUp()
    {
        parent::setUp();
        $this->clientRepository = $this->app->make(ClientRepository::class);
        $this->profile = new CompanyProfile();
        $this->fakeProfile = new CompanyFakeProfile();
    }

    /** @test */
    public function get_this_year_cs_due_clients_count_for_private_limited_only()
    {
        //Create Clients
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );

        $csDueCounter = $this->clientRepository->getCsDueCounter($this->profile);
        
        $this->assertEquals($csDueCounter, 2);
    }

    /** @test */
    public function get_this_year_cs_overdue_clients_count_for_private_limited_only()
    {
        //Create Clients
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );

        $csOverDueCounter = $this->clientRepository->getCsOverDueCounter($this->profile);
        
        $this->assertEquals($csOverDueCounter, 0);
    }

    /** @test */
    public function get_this_year_aa_due_clients_count_for_private_limited_only()
    {
        //Create Clients
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );

        $aaDueCounter = $this->clientRepository->getAaDueCounter($this->profile);
        
        $this->assertEquals($aaDueCounter, 0);
    }

    /** @test */
    public function get_this_year_aa_overdue_clients_count_for_private_limited_only()
    {
        //Create Clients
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );

        $aaOverDueCounter = $this->clientRepository->getAaOverDueCounter($this->profile);
        
        $this->assertEquals($aaOverDueCounter, 0);
    }

    
}