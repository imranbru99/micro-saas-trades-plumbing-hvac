<?php

namespace App\Filament\Resources\AiAssistSessions;

use App\Filament\Resources\AiAssistSessions\Pages\ManageAiAssistSessions;
use App\Models\AiAssistSession;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class AiAssistSessionResource extends Resource
{
    protected static ?string $model = AiAssistSession::class;

    protected static ?string $navigationLabel = 'AI Assistant';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'AI';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('ai_assistant');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')->relationship('user', 'name')->searchable(),
            Select::make('service_job_id')->relationship('serviceJob', 'number')->searchable(),
            Select::make('purpose')->options([
                'diagnose' => 'Diagnose',
                'estimate_draft' => 'Estimate draft',
                'customer_sms' => 'Customer SMS',
                'job_summary' => 'Job summary',
            ])->required()->default('diagnose'),
            Select::make('status')->options([
                'queued' => 'Queued',
                'completed' => 'Completed',
                'failed' => 'Failed',
            ])->required()->default('completed'),
            TextInput::make('tokens_used')->numeric(),
            Textarea::make('prompt')->columnSpanFull(),
            Textarea::make('response')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purpose')->badge(),
                TextColumn::make('serviceJob.number')->label('Job')->placeholder('—'),
                TextColumn::make('user.name')->label('User'),
                TextColumn::make('status')->badge(),
                TextColumn::make('tokens_used'),
                TextColumn::make('created_at')->since(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAiAssistSessions::route('/'),
        ];
    }
}
