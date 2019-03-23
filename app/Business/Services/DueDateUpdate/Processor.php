<?php

namespace App\Business\Services\DueDateUpdate;


use Exception;
use Carbon\Carbon;
use App\Repositories\Backend\ClientRepository;
use App\Repositories\Backend\DeadlineRepository;
use App\Business\Services\CompanyHouse\CompanyProfile;
use App\Business\Services\DueDateUpdate\Traits\ApiBasedMethods;
use App\Business\Services\DueDateUpdate\Traits\TimerBasedMethods;

class Processor
{
    use ApiBasedMethods, 
    TimerBasedMethods;
    private $companyHouse;
    private $clientRepository;
    private $deadlineRepository; 
    private $companyHouseDueDates;
    private $deadline;
    private $deadlineCode;
    private $client;
    private $clientDeadline;
    public function __construct()
    {
        $this->companyHouse = new CompanyProfile();
        $this->clientRepository = new ClientRepository();
        $this->deadlineRepository = new DeadlineRepository();
    }

    private function load()
    {
        $this->client = $this->clientRepository->where('company_number', $companyNumber)->where('is_api', true)->first();
    }

    /**
     * Next quater due date finder
     * @return String
     */
    private function quaterly($dueDate)
    {
        return Carbon::parse($dueDate)->addMonths('3')->format('d-m-Y');
    }

    /**
     * Next Month due date
     * @return String
     */
    private function monthly($dueDate)
    {
        return Carbon::parse($dueDate)->addMonth('1')->format('d-m-Y');
    }

    private function update($date)
    {
        try {
            
            $this->client->deadlines()->updateExistingPivot($this->deadline->id, [
                'due_on' => carbon_parse($date)
            ]);
            return;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
        
    }
}
