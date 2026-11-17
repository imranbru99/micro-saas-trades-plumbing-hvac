<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'number', 'customer_id', 'property_id', 'technician_id', 'title', 'trade_type',
    'priority', 'status', 'description', 'scheduled_at', 'eta_at', 'started_at',
    'completed_at', 'quoted_amount',
])]
class ServiceJob extends Model
{
    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'eta_at' => 'datetime',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'quoted_amount' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function estimates(): HasMany
    {
        return $this->hasMany(Estimate::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function technicianTask(): HasOne
    {
        return $this->hasOne(TechnicianTask::class);
    }

    public function aiSessions(): HasMany
    {
        return $this->hasMany(AiAssistSession::class);
    }
}
