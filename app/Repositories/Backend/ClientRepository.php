<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\Client;

/**
 * Class ClientRepository.
 */
class ClientRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Client::class;
    }
}