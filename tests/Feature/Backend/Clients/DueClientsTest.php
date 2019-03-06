<?php

namespace Tests\Feature\Backend;


use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Deadline;
use App\Repositories\Backend\ClientRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
    public function check_if_chart_data_is_correct_api_based()
    {
        //Create Clients
        factory(Client::class)->create(
            [
                'company_number' => 10202689,
                'is_api' => true
            ]
        );
        factory(Client::class)->create(
            [
                'company_number' => 11141106,
                'is_api' => true    
            ]
        );
        factory(Client::class)->create(
            [
                'company_number' => 9608793,
                'is_api' => true    
            ]
        );
        factory(Client::class)->create(
            [
                'company_number' => 10924993,
                'is_api' => true
            ]
        );
        $filterValue = config('filter.value.0');
        $csAaChartData = $this->clientRepository->fetchAaCs($this->fakeProfile, $filterValue);
        //dd(json_decode($csAaChartData->getContent(),true));
        //the first thing to check is cs due it should be 2
        $this->assertArrayHasKey(
            'chartdata',json_decode($csAaChartData->getContent(),true));
        $this->assertEquals(4, json_decode($csAaChartData->getContent(),true)['chartdata']['datasets'][0]['data'][0]);
        $this->assertEquals(4, json_decode($csAaChartData->getContent(),true)['chartdata']['datasets'][0]['data'][1]);
    }

    /** @test */
    public function check_if_chart_data_is_correct_for_vat()
    {
        $this->loginAsAdmin();
        $deadline = factory(Deadline::class)->create([
            'name' => 'Vat'
        ]);
        $this->post('/admin/clients', [
            'company_number' => 1234,
            'company_name' => "Oxmonk",
            'company_type_id' => 1,
            'accounts_next_due' => Carbon::parse('+1 year'),
            'accounts_overdue' => false,
            'country_id' => 1,
            'phone' => "8794515903",
            'email' => "admin@admin.com",
        ]);
        $clientA = $this->clientRepository->getById(1);

        $this->post('/admin/clients', [
            'company_number' => 1234,
            'company_name' => "Larasoft",
            'company_type_id' => 1,
            'accounts_next_due' => Carbon::parse('+1 year'),
            'accounts_overdue' => false,
            'country_id' => 1,
            'phone' => "8794515903",
            'email' => "admin@admin.com",
        ]);
        $clientB = $this->clientRepository->getById(2);


        $this->post('/admin/client/deadline', [
            'client_id' => $clientA->id,
            'deadline_id'=> $deadline->id,
            'from' => Carbon::parse('-1 year'),
            'to' => Carbon::parse('+1 year'),
            'due_on' => Carbon::now()
        ]);
        $this->post('/admin/client/deadline', [
            'client_id' => $clientB->id,
            'deadline_id'=> $deadline->id,
            'from' => Carbon::parse('-1 year'),
            'to' => Carbon::parse('+1 year'),
            'due_on' => Carbon::now()
        ]);
        $this->assertDatabaseHas('client_deadline', [
            'from' => Carbon::parse('-1 year'),
            'to' => Carbon::parse('+1 year'),
            'due_on' => Carbon::now()
        ]);
        
        $filterValue = config('filter.value.2');
        $vatChartData = $this->clientRepository->fetchVat($filterValue);
        //dd(json_decode($vatChartData->getContent(),true));
        //the first thing to check is cs due it should be 2
        $this->assertArrayHasKey(
            'chartdata',json_decode($vatChartData->getContent(),true));
        $this->assertEquals(2, json_decode($vatChartData->getContent(),true)['chartdata']['datasets'][0]['data'][0]);
    }
    
    /** @test*/
    public function check_if_clients_are_returned_via_api_url(){
        //Create Clients
        factory(Client::class)->create(
            [
                'company_number' => 10202689,
                'is_api' => true
            ]
        );
        factory(Client::class)->create(
            [
                'company_number' => 11141106,
                'is_api' => true
            ]
        );

        $clients = Client::all()->pluck('id')->toArray();
        $response = $this->post('/api/deadline/clients/fetch', $clients);
        $responseData = json_decode($response->content(), true);
        $prepResponse = $this->post('/api/deadline/clients/prepare', $responseData);
        $prepResponse->assertJsonFragment(
            [
                'company_name' => 'A.E VAN HIRE LIMITED'
            ]
        );
    }

    /** @test */
    public function check_if_clients_can_be_picked_by_filter()
    {
        //Create Clients
        factory(Client::class)->create(
            [
                'company_number' => 10202689,
                'is_api' => true
            ]
        );
        factory(Client::class)->create(
            [
                'company_number' => 11141106,
                'is_api' => true
            ]
        );

        $clients = Client::all()->pluck('id')->toArray();
    }


}