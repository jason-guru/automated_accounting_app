<?php

namespace App\Business\Services\CompanyHouse;

use GuzzleHttp\Client;

class CompanyProfile
{
    protected $api_key;
    protected $client;
    public function __construct()
    {
        $this->api_key = config('services.company_house.secret');
        $this->client = new Client([
            'base_uri' => "https://api.companieshouse.gov.uk"
        ]);
    }
    
    public function fetch($companyNumber)
    {
        try{
            $response = $this->client->request('GET', '/company/'.$companyNumber, [
                'auth' => [$this->api_key, '']
            ]);
            if($response->getStatusCode() == 200){
                return [
                'status' => 200,
                'body' => json_decode($response->getBody()->getContents(), true) 
                ];
            }
        }catch(\Exception $ex){
            return [
                'status' => 404
            ];
        }
    }
}
