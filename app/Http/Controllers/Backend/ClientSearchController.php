<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Http\Requests\SearchRequest;
use App\Models\Country;
use App\Models\CompanyType;
use App\Models\Designation;
use App\Models\Initial;
use App\Models\VatScheme;
use App\Models\VatSubmitType;

class ClientSearchController extends Controller
{
    protected $client;
    protected $api_key;
    protected $countries;
    protected $companies;
    protected $company_types;
    protected $designations;
    protected $initials;
    protected $vat_schemes;
    protected $vat_submit_types;

    public function __construct()
    {   
        $this->api_key = config('services.company_house.secret');
        $this->client = new Client([
            'base_uri' => "https://api.companieshouse.gov.uk"
        ]);
        $this->countries = Country::all();
        $this->company_types = CompanyType::all();
        $this->designations = Designation::all();
        $this->initials = Initial::all();
        $this->vat_schemes = VatScheme::all();
        $this->vat_submit_types = VatSubmitType::all();
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
            $designations = $this->designations;
            $initials = $this->initials;
            $vat_schemes = $this->vat_schemes;
            $vat_submit_types = $this->vat_submit_types;
            $company_number = trim($request->company_number);
            $is_api = true;
            $response = $this->client->request('GET', '/company/'.$company_number, [
                'auth' => [$this->api_key, '']
            ]);
            if($response->getStatusCode() == 200){
                $client_data = json_decode($response->getBody()->getContents(), true);
                return view('backend.clients.search-result', compact('client_data', 'countries', 'company_types', 'designations', 'initials', 'vat_submit_types', 'vat_schemes', 'is_api'));
            }
        }catch(\Exception $exception)
        {
            //return $exception->getMessage();
            return redirect()->back()->withFlashDanger('Invalid client Id entered, please check the id and try again');
        }
    }

    public function prep_contact_person_view(Request $request)
    {
        $form_data = $request->all();
        return response()->json([
            'view' => view('backend.clients.show.partials.contact-person', compact('form_data'))->render()
        ]);
    }
}
