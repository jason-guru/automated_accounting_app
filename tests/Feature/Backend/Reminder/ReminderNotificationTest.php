<?php

namespace Tests\Feature\Backend\Reminder;
 
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Deadline;
use App\Fake\ReminderData;
use App\Models\MessageFormat;
use App\Business\MessageFormatOptions;
use GuzzleHttp\Client as SmsCient;
use App\Events\Backend\ReminderEvent;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\ReminderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Backend\MessageFormatRepository;
 
Class ReminderNotificationTest extends TestCase
{
    use RefreshDatabase;
    protected $code;
    protected $smsClient;
    protected $smsApiKey;
    protected $reminderRepository;
    protected $messageFormatRepository;
    protected $clientData;
    protected $messageFormatOptions;
    protected $fakeReminderData;

    protected function setUp()
    {
        parent::setUp();
        $this->code = config('deadline.code.2');
        $this->smsApiKey = config('services.bulletin_sms.secret');
        $this->smsClient =  new SmsCient();
        $this->reminderRepository = $this->app->make(ReminderRepository::class);
        $this->messageFormatRepository = $this->app->make(MessageFormatRepository::class);
        $this->messageFormatOptions = $this->app->make(MessageFormatOptions::class);
        $this->fakeReminderData = $this->app->make(ReminderData::class);
        $this->clientData = [
            'company_number' => 1234,
            'company_name' => "Larasoft",
            'company_type_id' => 1,
            'accounts_next_due' => Carbon::parse('+1 year'),
            'accounts_overdue' => false,
            'country_id' => 1,
            'phone' => "+918794515903",
            'email' => "jobmails1689@gmail.com",
        ];
        
        $this->clientRepository = $this->app->make(ClientRepository::class);
    }

    /** @test */
    public function reminder_can_be_created()
    {
        $this->loginAsAdmin();
        $this->post('/admin/clients', $this->clientData);
        $client = $this->clientRepository->getById(1);
        $deadline = factory(Deadline::class)->create([
            'code' => $this->code
        ]);

        $response = $this->post('api/reminders', $this->fakeReminderData->fetch($client, $deadline));
        $this->assertEquals($response->content(), 'success');
    }

    /** @test */
    public function authorized_user_can_send_dynamic_notifications()
    {
        //Creation Phase
        $this->loginAsAdmin();
        $messageFormat = $this->messageFormatOptions->select($this->code);
        $deadline = factory(Deadline::class)->create([
            'message_format_id' => $messageFormat->id,
            'code' => $this->code
        ]);
        $this->post('/admin/clients', $this->clientData);
        $client = $this->clientRepository->getById(1);
        $this->post('/admin/client/deadline', [
            'client_id' => $client->id,
            'deadline_id'=> $deadline->id,
            'from' => Carbon::parse('-1 year'),
            'to' => Carbon::parse('+1 year'),
            'due_on' => Carbon::parse('+6 months')
        ]);
        $this->post('api/reminders', $this->fakeReminderData->fetch($client, $deadline));

        //Action Phase
        $response = event(new ReminderEvent());

        $this->assertDatabaseHas('reminders', [
            'counter' => 1
        ]);
    }
}