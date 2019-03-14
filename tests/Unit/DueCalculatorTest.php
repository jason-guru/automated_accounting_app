<?php 

namespace Tests\Unit;
 
use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Deadline;
use App\Repositories\Backend\ClientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
Class DueCalculatorTest extends TestCase
{
    use RefreshDatabase;
    protected $clientRepository;

    protected function setUp()
    {
        parent::setUp();
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
        $this->clientRepository = $this->app->make(ClientRepository::class); 
    }
    
    /** @test */
    public function check_if_due_is_filtered_correctly()
    {
        $this->loginAsAdmin();
        $deadline1 = factory(Deadline::class)->create();
        $deadline2 = factory(Deadline::class)->create(['name'=> 'Confirmation Statement', 'code' => 'CS']);
        $deadline3 = factory(Deadline::class)->create(['name'=> 'Annual Accounts', 'code' => 'AA']);
        $deadline4 = factory(Deadline::class)->create(['name'=> 'Paye', 'code' => 'PAYE']);
        $deadline5 = factory(Deadline::class)->create(['name'=> 'Cis', 'code' => 'CIS']);
        $this->clientData['is_api'] = true;
        $this->clientData['aa_from'] = Carbon::parse('-1 year');
        $this->clientData['aa_to'] = Carbon::parse('+2 year');
        $this->clientData['aa_due'] = Carbon::parse('2019-09-03');
        $this->clientData['aa_overdue'] = true;
        $this->clientData['cs_from'] = Carbon::parse('-1 year');
        $this->clientData['cs_to'] = Carbon::parse('+2 year');
        $this->clientData['cs_due'] = Carbon::parse('2019-09-03');
        $this->clientData['cs_overdue'] = true;
        $response = $this->post('/admin/clients', $this->clientData);
        $this->assertDatabaseHas('client_deadline', [
            'deadline_id' => $deadline3->id,
            'from' =>  $this->clientData['aa_from'],
            'to' => $this->clientData['aa_to'],
            'due_on' => $this->clientData['aa_due']
        ]);
        $code = config('deadline.code.1');
        $filterValue = config('filter.value.1');
        $clientIds = $this->calculateDue($code, $filterValue);
        $this->assertEquals($clientIds, []);
    }

    private function calculateDue($code, $filterValue)
    {
        $whenAndFormat = $this->getWhenAndFormat($filterValue);
        $clientIds = [];
        $clients = $this->getLocalClients();
        if(count($clients) > 0){
            foreach($clients as $client){
                $nextDue = $this->getDueOn($client, $code, $whenAndFormat, $filterValue);
                if(!is_null($nextDue)){
                    if(!is_null($whenAndFormat['parentYear'])){
                        if(!is_null($whenAndFormat['parentMonth'])){
                            //This week filter
                            if($whenAndFormat['when'] >= $nextDue && $whenAndFormat['parentYear'] == $this->getDueYear($client, $code) && $whenAndFormat['parentMonth'] == $this->getDueMonth($client, $code)){
                                array_push($clientIds, $client->id);
                            }else{
                                break;
                            }
                        }else{

                            if($whenAndFormat['when'] >= $nextDue && $whenAndFormat['parentYear'] == $this->getDueYear($client, $code)){
                                array_push($clientIds, $client->id);
                            }else{
                                break;
                            }
                        }
                        
                    }else{
                        if($whenAndFormat['when'] >= $nextDue){
                            array_push($clientIds, $client->id);
                        }else{
                            break;
                        }
                    }
                   
                }
            }
        }
        return $clientIds;
    }

    private function getLocalClients()
    {
        return $this->clientRepository->all();
    }

    private function getWhenAndFormat($filterValue)
    {
        $format = null;
        $when = null;
        $parentMonth = null;
        $parentYear = null;
        if($filterValue == config('filter.value.0') || $filterValue == null){
            $when = Carbon::now()->format('Y');
            $format = 'Y';
        }elseif($filterValue == config('filter.value.1')){
            $when = Carbon::now()->format('m');
            $format = 'm';
            $parentYear = Carbon::now()->format('Y');
        }elseif($filterValue == config('filter.value.2')){
            $when = Carbon::now()->weekOfYear;
            $parentMonth = Carbon::now()->format('M');
            $parentYear = Carbon::now()->format('Y');
        }
       
        return [
            'when' => $when,
            'format' =>$format,
            'parentMonth' => $parentMonth,
            'parentYear' => $parentYear
        ];
    }

    private function getDueOn($client, $code, $whenAndFormat, $filterValue)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            if($filterValue != config('filter.value.2')){
                return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format($whenAndFormat['format']);
            }else{
                return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->weekOfYear;
            }
        }else{
            return null;
        }
    }

    private function getDueYear($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format('Y');
        }else{
            return null;
        }
    }

    private function getDueMonth($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format('M');
        }else{
            return null;
        }
    }
}   