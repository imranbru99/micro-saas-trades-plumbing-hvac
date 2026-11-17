<?php

namespace App\Filament\Resources\AiAssistSessions\Pages;

use App\Filament\Resources\AiAssistSessions\AiAssistSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageAiAssistSessions extends ManageRecords
{
    protected static string $resource = AiAssistSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
