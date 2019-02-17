<?php

namespace App\Repositories\Backend;

use Carbon\Carbon;
use App\Models\Client;
use App\Repositories\BaseRepository;
use App\Business\Api\CompanyHouse\CompanyProfile;
use App\Repositories\Backend\Traits\Deadline\Vat;
use App\Repositories\Backend\Traits\Deadline\AaCs;
use App\Repositories\Backend\Traits\Methods\CommonDueCalculatorMethods;
use App\Repositories\Backend\Traits\Methods\PrivateLimitedDueCalculator;
use App\Repositories\Backend\Traits\Methods\NonPrivateLimitedDueCalculator;
use App\Repositories\Backend\Traits\Deadline\PayeCis;

/**
 * Class ClientRepository.
 */
class ClientRepository extends BaseRepository
{
    use CommonDueCalculatorMethods;
    use PrivateLimitedDueCalculator;
    use NonPrivateLimitedDueCalculator;
    use AaCs;
    use Vat;
    use PayeCis;
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Client::class;
    }
}