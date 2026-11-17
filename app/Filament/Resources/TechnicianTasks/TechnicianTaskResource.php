<?php

namespace App\Filament\Resources\TechnicianTasks;

use App\Filament\Resources\TechnicianTasks\Pages\ManageTechnicianTasks;
use App\Models\TechnicianTask;
use App\Services\ModuleManager;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class TechnicianTaskResource extends Resource
{
    protected static ?string $model = TechnicianTask::class;

    protected static ?string $navigationLabel = 'Technician App';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDevicePhoneMobile;

    protected static string|UnitEnum|null $navigationGroup = 'Field';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('technician_app');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('service_job_id')->relationship('serviceJob', 'number')->searchable()->required(),
            Select::make('technician_id')->relationship('technician', 'name')->searchable()->required(),
            Select::make('status')->options([
                'queued' => 'Queued',
                'checked_in' => 'Checked in',
                'in_progress' => 'In progress',
                'completed' => 'Completed',
            ])->required()->default('queued'),
            DateTimePicker::make('checked_in_at'),
            DateTimePicker::make('checked_out_at'),
            TextInput::make('completion_pct')->numeric()->minValue(0)->maxValue(100)->suffix('%'),
            Textarea::make('field_notes'),
            Textarea::make('parts_used'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('serviceJob.number')->label('Job'),
                TextColumn::make('technician.name')->label('Tech'),
                TextColumn::make('status')->badge(),
                TextColumn::make('completion_pct')->suffix('%'),
                TextColumn::make('checked_in_at')->dateTime(),
                TextColumn::make('field_notes')->limit(24)->placeholder('—'),
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
            'index' => ManageTechnicianTasks::route('/'),
        ];
    }
}
