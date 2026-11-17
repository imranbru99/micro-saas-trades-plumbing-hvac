<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'sku', 'slug', 'name', 'trade_type', 'category', 'unit_cost', 'unit_price',
    'stock_qty', 'supplier', 'is_active', 'notes',
])]
class Part extends Model
{
    protected function casts(): array
    {
        return [
            'unit_cost' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'stock_qty' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
