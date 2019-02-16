<?php

namespace App\Repositories\Backend;

use Carbon\Carbon;
use App\Models\Client;
use App\Repositories\BaseRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;
use App\Repositories\Backend\Traits\Methods\AaCs;
use App\Repositories\Backend\Traits\Methods\ApiDueCalculator;

/**
 * Class ClientRepository.
 */
class ClientRepository extends BaseRepository
{
    use ApiDueCalculator;
    use AaCs;
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Client::class;
    }

    private function getClients()
    {
        return $this->where('company_type_id', 1)->get();
    }

    private function prepPath($path)
    {
        return explode(', ', $path);
    }
}