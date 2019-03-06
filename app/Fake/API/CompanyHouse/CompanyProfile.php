<?php 

namespace App\Fake\API\CompanyHouse;
use Faker\Factory as Faker;

class CompanyProfile 
{

    protected $faker;
    public function __construct()
    {
        $this->faker = Faker::create();
    }

    
    public function fetch($companyNumber)
    {
        $data = [
            "links"=> [
                "self"=> "/company/".$companyNumber,
                "persons_with_significant_control_statements"=> "/company/".$companyNumber."/persons-with-significant-control-statements",
                "filing_history"=> "/company/".$companyNumber."/filing-history",
                "officers"=> "/company/".$companyNumber."/officers"
                ],
                "has_charges"=> false,
                "sic_codes"=> [
                "80100"
            ],
            "confirmation_statement" => [
                "last_made_up_to" => $this->faker->date($format = 'Y-m-d', $max = 'now'),
                "next_made_up_to" => $this->faker->date($format = 'Y-m-d', $max = 'now'),
                "next_due" => '2019-03-6',
                "overdue" => true
            ],
            "undeliverable_registered_office_address"=> false,
            "has_insolvency_history"=> false,
            "registered_office_is_in_dispute"=> false,
            "company_number"=> "10924993",
            "date_of_creation"=> "2017-08-21",
            "jurisdiction"=> "england-wales",
            "etag"=> "4ecd9293952740770b07f537991cc62d19cadbe7",
            "type"=> "ltd",
            "accounts" => [
                "last_accounts"=> [
                  "period_end_on"=> "2018-08-31",
                  "type"=> "micro-entity",
                  "made_up_to"=> "2018-08-31",
                  "period_start_on"=> "2017-08-21"
                ],
                "accounting_reference_date"=> [
                  "day"=> "31",
                  "month"=> "08"
                ],
                "overdue"=> true,
                "next_due"=> "2019-03-6",
                "next_accounts"=> [
                  "period_start_on"=> $this->faker->date($format = 'Y-m-d', $max = 'now'),
                  "overdue"=> true,
                  "due_on"=> "2019-03-6",
                  "period_end_on"=> $this->faker->date($format = 'Y-m-d', $max = 'now')
                ],
                "next_made_up_to"=> "2019-08-31"
              ],
              "registered_office_address"=> [
                "locality"=> "Farnborough",
                "address_line_1"=> "36 Yeovil Road Yeovil Road",
                "country"=> "United Kingdom",
                "postal_code"=> "GU14 6LB"
              ],
              "company_status"=> "active",
              "company_name"=> $this->faker->company,
              "can_file"=> true
        ];

        return [
            'status' => 200,
            'body' => $data
        ];
    }
}
