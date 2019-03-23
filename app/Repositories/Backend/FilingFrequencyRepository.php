<?php

namespace App\Repositories\Backend;

use App\Models\FilingFrequency;
use App\Repositories\BaseRepository;

/**
 * Class FilingFrequencyRepository.
 */
class FilingFrequencyRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return FilingFrequency::class;
    }
}