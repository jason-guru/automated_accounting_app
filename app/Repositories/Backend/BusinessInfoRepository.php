<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\BusinessInfo;

/**
 * Class BusinessInfoRepository.
 */
class BusinessInfoRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return BusinessInfo::class;
    }
}