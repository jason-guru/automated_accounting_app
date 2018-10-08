<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Http\Requests\SearchRequest;


class ClientSearchController extends Controller
{
    protected $client;
    protected $api_key;
    protected $countries;

    public function __construct()
    {   
        $this->api_key = config('services.company_house.secret');
        $this->client = new Client([
            'base_uri' => "https://api.companieshouse.gov.uk"
        ]);
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
            $client_id = $request->client_id;
            $response = $this->client->request('GET', '/company/'.$client_id, [
                'auth' => [$this->api_key, '']
            ]);
            if($response->getStatusCode() == 200){
                $client_data = json_decode($response->getBody()->getContents(), true);
                return view('backend.clients.search-result', compact('client_data'));
            }
        }catch(\Exception $exception)
        {
            //return $exception->getMessage();
            return redirect()->back()->withFlashDanger('Invalid client Id entered, please check the id and try again');
        }
    }

    /**
     * @param Request $request
     * @return 
     * Stores the search result and additional data to the record
    */
    public function store_search_result(Request $request)
    {
        try{
            
        }catch(\Exception $exception)
        {
            return $exception->getMessage();
        }
    }
}
