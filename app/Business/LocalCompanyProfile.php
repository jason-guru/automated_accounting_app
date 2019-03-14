<?php

namespace App\Business;

use Carbon\Carbon;

class LocalCompanyProfile
{
    public function fetch($client)
    {
        $data = [
            "client_id" => $client->id,
            "date_of_creation"=> $client->business_start_date,
            "type"=> $client->company_type->name,
            "aa" => [
                "overdue" => $this->calculateOverDue($client, config('deadline.code.0')),
                "due"=> $this->getDueOnDate($client,config('deadline.code.0')),
                'from' => $this->getFromDate($client, config('deadline.code.0')),
                'to' => $this->getToDate($client, config('deadline.code.0')),
            ],
            "cs" => [
                "overdue" => $this->calculateOverDue($client, config('deadline.code.1')),
                "due"=> $this->getDueOnDate($client,config('deadline.code.1')),
                'from' => $this->getFromDate($client, config('deadline.code.1')),
                'to' => $this->getToDate($client, config('deadline.code.1')),
            ],
            "vat" => [
                "overdue"=> $this->calculateOverDue($client, config('deadline.code.2')),
                "due"=> $this->getDueOnDate($client,config('deadline.code.2')),
                'from' => $this->getFromDate($client, config('deadline.code.2')),
                'to' => $this->getToDate($client, config('deadline.code.2')),
              ],
            "paye" => [
                "overdue"=> $this->calculateOverDue($client, config('deadline.code.3')),
                "due"=> $this->getDueOnDate($client,config('deadline.code.3')),
                'from' => $this->getFromDate($client, config('deadline.code.3')),
                'to' => $this->getToDate($client, config('deadline.code.3')),
            ],
            "cis" => [
                "overdue"=> $this->calculateOverDue($client, config('deadline.code.4')),
                "due"=> $this->getDueOnDate($client,config('deadline.code.4')),
                'from' =>$this->getFromDate($client, config('deadline.code.4')),
                'to' => $this->getToDate($client, config('deadline.code.4')),
            ],
              "company_name"=> $client->company_name,
        ];

        return [
            'status' => 200,
            'body' => $data
        ];
    }

    public function calculateOverDue($client, $code)
    {
        $due_on = !is_null($client->deadlines->where('code', $code)->first()->pivot->due_on) ? Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format('Y-m-d') : null;
        $today = Carbon::now();
        if(!is_null($due_on)){
            if($due_on <= $today){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    private function getDueOnDate($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->due_on))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->due_on)->format('Y-m-d');
        }else{
            return null;
        }
    }

    private function getFromDate($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->from))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->from)->format('Y-m-d');
        }else{
            return null;
        }
    }

    private function getToDate($client, $code)
    {
        if(!is_null($client->deadlines->where('code', $code)->first()->pivot->to))
        {
            return Carbon::parse($client->deadlines->where('code', $code)->first()->pivot->to)->format('Y-m-d');
        }else{
            return null;
        }
    }
}