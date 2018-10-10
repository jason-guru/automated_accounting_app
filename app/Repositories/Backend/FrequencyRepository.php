<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\Frequency;

/**
 * Class FrequencyRepository.
 */
class FrequencyRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Frequency::class;
    }
}