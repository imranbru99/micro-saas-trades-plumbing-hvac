<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\ServiceJob;
use App\Services\ModuleManager;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TradeFlowStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $hours = app(ModuleManager::class)->weeklyHoursSaved();

        return [
            Stat::make('Open jobs', (string) ServiceJob::query()->whereNotIn('status', ['completed', 'cancelled'])->count())
                ->description('Dispatch queue')
                ->color('primary'),
            Stat::make('Customers', (string) Customer::query()->count())
                ->description('Active book of business')
                ->color('success'),
            Stat::make('Open estimates', (string) Estimate::query()->whereIn('status', ['draft', 'sent'])->count())
                ->description('Awaiting approval')
                ->color('warning'),
            Stat::make('Balance due', '$'.number_format((float) Invoice::query()->sum('balance_due'), 0))
                ->description("Modules reclaim ~{$hours}h/week")
                ->color('danger'),
        ];
    }
}
