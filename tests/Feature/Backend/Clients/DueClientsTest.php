<?php

namespace Tests\Feature\Backend;


use Tests\TestCase;
use App\Models\Client;
use Illuminate\Support\Carbon;
use App\Repositories\Backend\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Business\Api\CompanyHouse\CompanyProfile;
use App\Fake\API\CompanyHouse\CompanyProfile as CompanyFakeProfile;

class DueClientsTest extends TestCase
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
    public function check_if_chart_data_is_correct()
    {
        //Create Clients
        factory(Client::class)->create(
            ['company_number' => 10202689]
        );
        factory(Client::class)->create(
            ['company_number' => 11141106]
        );
        factory(Client::class)->create(
            ['company_number' => 9608793]
        );
        factory(Client::class)->create(
            ['company_number' => 10924993]
        );

        $csAaChartData = $this->clientRepository->fetchAaCs($this->profile);
        dd(json_decode($csAaChartData->getContent(),true));
        //the first thing to check is cs due it should be 2
        $this->assertContains([
            'chartdata'
        ],json_decode($csAaChartData->getContent(),true));
    }
    
    /** @test*/
    public function check_if_clients_are_returned_via_api_url(){
        //Create Clients
        factory(Client::class)->create(
            ['company_number' => 10202689]
        );
        factory(Client::class)->create(
            ['company_number' => 11141106]
        );

        $clients = Client::all()->pluck('id')->toArray();
        $response = $this->post('/api/deadline/clients/fetch', $clients);
        $responseData = json_decode($response->content(), true);
        $prepResponse = $this->post('/api/deadline/clients/prepare', $responseData);
        dd($prepResponse->content());
    }
}