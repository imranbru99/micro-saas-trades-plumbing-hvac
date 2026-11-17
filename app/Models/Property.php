<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'customer_id', 'label', 'address_line', 'city', 'region', 'postal_code',
    'country', 'property_type', 'access_notes', 'equipment_notes',
])]
class Property extends Model
{
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(ServiceJob::class);
    }
}
