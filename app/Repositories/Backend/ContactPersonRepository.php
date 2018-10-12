<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\ContactPerson;

/**
 * Class ContactPersonRepository.
 */
class ContactPersonRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ContactPerson::class;
    }
}