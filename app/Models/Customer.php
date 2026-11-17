<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'contact_name', 'email', 'phone', 'account_type', 'status', 'notes'])]
class Customer extends Model
{
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(ServiceJob::class);
    }

    public function estimates(): HasMany
    {
        return $this->hasMany(Estimate::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
