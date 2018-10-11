<?php

namespace App\Repositories\Backend;

use App\Repositories\BaseRepository;
use App\Models\MessageFormat;

/**
 * Class MessageFormatRepository.
 */
class MessageFormatRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return MessageFormat::class;
    }
}