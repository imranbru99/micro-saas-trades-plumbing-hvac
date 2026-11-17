<?php

namespace App\Filament\Widgets;

use App\Models\ServiceJob;
use App\Services\ModuleManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class DispatchBoardWidget extends TableWidget
{
    protected static ?string $heading = 'Today\'s dispatch board';

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return app(ModuleManager::class)->enabled('dispatch');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ServiceJob::query()
                    ->with(['customer', 'technician'])
                    ->whereNotIn('status', ['cancelled'])
                    ->latest('scheduled_at')
                    ->limit(8)
            )
            ->columns([
                TextColumn::make('number')->label('Job'),
                TextColumn::make('title')->limit(28),
                TextColumn::make('trade_type')->badge(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('technician.name')->label('Tech')->placeholder('Unassigned'),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('scheduled_at')->dateTime()->since(),
            ])
            ->paginated(false);
    }
}
