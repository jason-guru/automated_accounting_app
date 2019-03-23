<?php

namespace App\Business\Services\DueDateUpdate\Traits;

use Illuminate\Support\Facades\Log;
/**
 * Conatins all the method related to api based due date method in Computations class
 */
trait ApiBasedMethods
{
    /**
     * Api Based Next Due Date Finder
     * @return Array
     */
    public function apiBased($companyNumber)
    {
        try{
            $this->companyHouseDueDates = $this->getcompanyHouseDueDates($companyNumber);
            $results = $this->processCompanyHouseDeadlines($companyNumber);
            $this->sortAndUpdate($results);
        }catch(Exception $ex){
            return $ex->getMessage();
        }
       
    }

    private function getCompanyHouseDueDates($companyNumber)
    {
        $companyProfile = $this->companyHouse->fetch($companyNumber);
        return collect([
            'cs_due' => $companyProfile['body']['confirmation_statement']['next_due'],
            'aa_due' => $companyProfile['body']['accounts']['next_due']
        ]);
    }

    /**
     * @param String The company number to find out the client details, stored in the database
     * @return Array Return the comparision result and Value
     */
    private function processCompanyHouseDeadlines($companyNumber)
    {
        try {
            $result = [];
            $this->load();
            if(!is_null($this->client)){
                foreach($this->client->deadlines as $deadline){
                    $this->deadline = $deadline;
                    $this->deadlineCode = $this->deadline->code;
                        switch($this->deadlineCode){
                            case config('deadline.code.0'):
                                $result['aa_due'] = $this->compare('aa_due');
                            case config('deadline.code.1'):
                                $result['cs_due'] = $this->compare('cs_due');
                        }
                   
                }
                return $result;
            }
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Compares between Due Date at database and Company House Due Date
     * @return Array Outdated Information that is comparision result and value
     */
    private function compare($deadlineType)
    {
        $companyHouseDueDate = carbon_parse($this->companyHouseDueDates->only($deadlineType)->first());
        $recordDue = $this->deadline->pivot->due_on;
        if($recordDue <= $companyHouseDueDate){
            return [
                'outdated' => true,
                'date' => $companyHouseDueDate
        ];
        }else{
            return;
        }
    }

    /**
     * Sorts the deadline type and updates the database with latest date if outdated
     * @param Array Company House Deadline types
     * @return Session Information about result of the action
     */
    private function sortAndUpdate($results)
    {
        try {
        collect($results)->each(function($result){
            if($result['outdated']){
                $this->update($result['date']);
            }
        });
    }catch(Exception $ex){
        return $ex->getMessage();
        }
    }
}
