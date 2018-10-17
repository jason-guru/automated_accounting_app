<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\Deadline;

/**
 * Class DeadlineRepository.
 */
class DeadlineRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Deadline::class;
    }
}