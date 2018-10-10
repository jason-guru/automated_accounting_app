<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Http\Requests\SearchRequest;
use App\Models\Country;
use App\Models\CompanyType;

class ClientSearchController extends Controller
{
    protected $client;
    protected $api_key;
    protected $countries;
    protected $companies;
    protected $company_types;

    public function __construct()
    {   
        $this->api_key = config('services.company_house.secret');
        $this->client = new Client([
            'base_uri' => "https://api.companieshouse.gov.uk"
        ]);
        $this->countries = Country::all();
        $this->company_types = CompanyType::all();
    }

    /**
     * @return View
     * The client search index
    */
    public function show_search()
    {
        return view('backend.clients.search');
    }

    /**
     * @param SearchRequest $request
     * Fetch the data from company house and displays the result here.
    */
    public function show_search_result(SearchRequest $request)
    {
        try{
            $countries = $this->countries;
            $company_types = $this->company_types;
            $company_number = trim($request->company_number);
            $response = $this->client->request('GET', '/company/'.$company_number, [
                'auth' => [$this->api_key, '']
            ]);
            if($response->getStatusCode() == 200){
                $client_data = json_decode($response->getBody()->getContents(), true);
                return view('backend.clients.search-result', compact('client_data', 'countries', 'company_types'));
            }
        }catch(\Exception $exception)
        {
            //return $exception->getMessage();
            return redirect()->back()->withFlashDanger('Invalid client Id entered, please check the id and try again');
        }
    }
}
