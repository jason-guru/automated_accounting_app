<?php

namespace Tests\Feature\Backend;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Deadline;
use App\Repositories\Backend\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeadlineTest extends TestCase
{
    use RefreshDatabase;
    protected $clientRepository;

    protected function setUp()
    {
        parent::setUp();
        $this->clientRepository = $this->app->make(ClientRepository::class);
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
    }
    
    /** @test */
    public function unauthorized_user_cannot_view_client_deadline()
    {
        $response = $this->get('/admin/client/deadline');
        $response->assertStatus(302);
    }

    /** @test */
    public function authorized_user_can_view_client_deadline()
    {
        $this->loginAsAdmin();
        $deadline = factory(Deadline::class)->create([
            'name' => 'Vat'
        ]);
        $clientResponse = $this->post('/admin/clients', $this->clientData);
        $client = $this->clientRepository->getById(1);

        $response = $this->get('/admin/client/deadline');

        $response->assertStatus(200);
        $response->assertSee($client->company_name);
        $response->assertSee($deadline->name);
    }

    /** @test */
    public function authorized_user_can_insert_client_deadline_details()
    {
        $this->loginAsAdmin();
        $deadline = factory(Deadline::class)->create([
            'name' => 'Vat'
        ]);
        $clientResponse = $this->post('/admin/clients', $this->clientData);
        $client = $this->clientRepository->getById(1);

        $response = $this->post('/admin/client/deadline', [
            'client_id' => $client->id,
            'deadline_id'=> $deadline->id,
            'from' => Carbon::parse('-1 year'),
            'to' => Carbon::parse('+1 year'),
            'due_on' => Carbon::parse('+1 year')
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('client_deadline', [
            'from' => Carbon::parse('-1 year'),
            'to' => Carbon::parse('+1 year'),
            'due_on' => Carbon::parse('+1 year')
        ]);
    }
}