<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\ReminderDate;

/**
 * Class ReminderDateRepository.
 */
class ReminderDateRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ReminderDate::class;
    }
}