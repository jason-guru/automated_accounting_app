<?php

namespace App\Business;

class LocalCompanyProfile
{
    public function fetch($client)
    {
        $data = [
            "client_id" => $client->id,
            "date_of_creation"=> $client->business_start_date,
            "type"=> $client->company_type->name,
            "vat" => [
                "overdue"=> $client->accounts_overdue,
                "due"=> $client->accounts_next_due,
                'from' => $client->book_start_date,
                'to' => $client->year_end_date,
              ],
              "company_name"=> $client->company_name,
        ];

        return [
            'status' => 200,
            'body' => $data
        ];
    }
}