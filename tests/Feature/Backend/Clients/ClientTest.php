<?php
namespace Tests\Feature\Backend\Clients;
 
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Deadline;
use App\Models\Auth\User;
use App\Repositories\Backend\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
Class ClientTest extends TestCase
{
    use RefreshDatabase;
    private $clientData;
    private $clientRepository;
    protected function setUp()
    {
        $this->clientData = [
            'company_number' => 1234,
            'company_name' => "Larasoft",
            'company_type_id' => 1,
            'accounts_next_due' => Carbon::parse('+1 year'),
            'accounts_overdue' => false,
            'country_id' => 1,
            'phone' => "8794515903",
            'email' => "admin@admin.com",
        ];
        parent::setUp();
        $this->clientRepository = $this->app->make(ClientRepository::class);
    }

   /** @test */
   public function store_client_deadline_relation_when_client_is_created()
   {   
        $deadline1 = factory(Deadline::class)->create();
        $deadline2 = factory(Deadline::class)->create(['name'=> 'Confirmation Statement']);
        $deadline3 = factory(Deadline::class)->create(['name'=> 'Annual Accounts']);
        $deadline4 = factory(Deadline::class)->create(['name'=> 'Paye']);
        $deadline5 = factory(Deadline::class)->create(['name'=> 'Cis']);
        $this->loginAsAdmin();
        $response = $this->post('/admin/clients', $this->clientData);
        $response->assertSessionHas(['flash_success' => 'Client created successfully']);

        $client = $this->clientRepository->getById(1);

        $this->assertDatabaseHas('client_deadline', [
            'client_id' => $client->id,
            'deadline_id' => $deadline1->id
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'client_id' => $client->id,
            'deadline_id' => $deadline2->id
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'client_id' => $client->id,
            'deadline_id' => $deadline3->id
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'client_id' => $client->id,
            'deadline_id' => $deadline4->id
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'client_id' => $client->id,
            'deadline_id' => $deadline5->id
        ]);
   }

   /** @test */
   public function store_client_deadline_fields_for_aa_cs_if_client_is_api_based()
   {
        /**
         * To determine if a client is created via api, a is_api flag is added
         */
        $this->loginAsAdmin();
        $deadline1 = factory(Deadline::class)->create();
        $deadline2 = factory(Deadline::class)->create(['name'=> 'Confirmation Statement', 'code' => 'CS']);
        $deadline3 = factory(Deadline::class)->create(['name'=> 'Annual Accounts', 'code' => 'AA']);
        $deadline4 = factory(Deadline::class)->create(['name'=> 'Paye', 'code' => 'PAYE']);
        $deadline5 = factory(Deadline::class)->create(['name'=> 'Cis', 'code' => 'CIS']);
        /**
         * This below array keys is submitted along with the form.
         * Now the controller must handle this data and insert them in the client_deadline pivot table
         */
        $this->clientData['is_api'] = true;
        $this->clientData['aa_from'] = Carbon::parse('-1 year');
        $this->clientData['aa_to'] = Carbon::parse('+2 year');
        $this->clientData['aa_due'] = Carbon::parse('+1 year');
        $this->clientData['aa_overdue'] = true;
        $this->clientData['cs_from'] = Carbon::parse('-1 year');
        $this->clientData['cs_to'] = Carbon::parse('+2 year');
        $this->clientData['cs_due'] = Carbon::parse('+1 year');
        $this->clientData['cs_overdue'] = true;

        $response = $this->post('/admin/clients', $this->clientData);
        $this->assertDatabaseHas('clients', ['is_api' => true]);

        $this->assertDatabaseHas('client_deadline', [
            'deadline_id' => $deadline2->id,
            'from' =>  $this->clientData['cs_from'],
            'to' => $this->clientData['cs_to'],
            'due_on' => $this->clientData['cs_due']
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'deadline_id' => $deadline3->id,
            'from' =>  $this->clientData['aa_from'],
            'to' => $this->clientData['aa_to'],
            'due_on' => $this->clientData['aa_due']
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'deadline_id' => $deadline4->id,
            'from' =>  null,
            'to' => null,
            'due_on' => null
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'deadline_id' => $deadline5->id,
            'from' =>  null,
            'to' => null,
            'due_on' => null
        ]);

        $this->assertDatabaseHas('client_deadline', [
            'deadline_id' => $deadline1->id,
            'from' =>  null,
            'to' => null,
            'due_on' => null
        ]);

   }

   /** @test */
   public function check_reminder_toggle()
   {
       $client = factory(Client::class)->create();
       $this->loginAsAdmin();
       $response = $this->put('admin/clients/1/switch', [
        'switch_value_update' => true,
        'switch_value' => true
       ]);

       $response->assertStatus(200);
       $response->assertJson([
           'success' => true
       ]);
   }
    
}