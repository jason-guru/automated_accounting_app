<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Attribute\ReferenceNumberAttribute;

class ReferenceNumber extends Model
{
    use ReferenceNumberAttribute;
    protected $fillable = [
        'client_id', 'name', 'reference_number', 'amount', 'attachment_path', 'is_active', 'reference_number_id'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
