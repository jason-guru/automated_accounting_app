<?php

namespace App\Listeners\Backend;

use GuzzleHttp\Client;
use App\Events\Backend\AccountStatus;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\FrequencyRepository;
use App\Repositories\Backend\ReminderRepository;

class AccountManager
{
    protected $client_repository;
    protected $frequency_repository;
    protected $reminder_repository;
    protected $api_key;
    protected $client_api;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ClientRepository $client_repository, FrequencyRepository $frequency_repository, ReminderRepository $reminder_repository)
    {
        $this->frequency_repository = $frequency_repository;
        $this->client_repository = $client_repository;
        $this->reminder_repository = $reminder_repository;
        $this->api_key = config('services.company_house.secret');
        $this->client_api = new Client([
            'base_uri' => "https://api.companieshouse.gov.uk"
        ]);
    }

    /**
     * Handle the event.
     *
     * @param  AccountStatus  $event
     * @return void
     */
    public function handle(AccountStatus $event)
    {
        $clients = $this->client_repository->all();
        $clients_data = [];
        foreach($clients as $client):
            $company_number = $client->company_number;
            $response = $this->client_api->request('GET', '/company/'.$company_number, [
                'auth' => [$this->api_key, '']
            ]);
            $client_api_data = json_decode($response->getBody()->getContents(), true);
            $clients_data[] = [
                'company_number' => $company_number,
                'accounts_next_due' => $client_api_data['accounts']['next_due']
            ];
        endforeach;
        
        foreach($clients_data as $client_data):
            $client = $this->client_repository->where('company_number',  $client_data['company_number'])->get()->first();
            // Date comparator
            if($client->accounts_next_due != $client_data['accounts_next_due']):
                //update the record
                $this->client_repository->updateById($client->id, ['accounts_next_due' => $client_data['accounts_next_due']]);
                $active_frequency = $this->frequency_repository->where('is_active', 1)->get()->first();
                $get_reminder_id = $this->reminder_repository->where('client_id', $client->id)->where('manual_mode', 0)->get()->first()->id;

                $this->reminder_repository->set_reminders($client->id, $client_data['accounts_next_due'], $active_frequency, $get_reminder_id);
            endif;
        endforeach;
    }
}
