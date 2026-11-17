<?php

namespace App\Filament\Resources\TechnicianTasks\Pages;

use App\Filament\Resources\TechnicianTasks\TechnicianTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTechnicianTasks extends ManageRecords
{
    protected static string $resource = TechnicianTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
