<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\ReferenceNumber;

/**
 * Class ReferenceNumberRepository.
 */
class ReferenceNumberRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ReferenceNumber::class;
    }
}