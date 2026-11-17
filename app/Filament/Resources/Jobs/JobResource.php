<?php

namespace App\Filament\Resources\Jobs;

use App\Filament\Resources\Jobs\Pages\ManageJobs;
use App\Models\ServiceJob;
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class JobResource extends Resource
{
    protected static ?string $model = ServiceJob::class;

    protected static ?string $navigationLabel = 'Dispatch Jobs';

    protected static ?string $modelLabel = 'Job';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('dispatch');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('number')->required()->unique(ignoreRecord: true)->maxLength(40),
            TextInput::make('title')->required()->maxLength(200),
            Select::make('customer_id')->relationship('customer', 'name')->searchable()->required(),
            Select::make('property_id')->relationship('property', 'label')->searchable(),
            Select::make('technician_id')->relationship('technician', 'name')->searchable(),
            Select::make('trade_type')->options(config('trades.trade_types'))->required()->default('plumbing'),
            Select::make('priority')->options([
                'low' => 'Low',
                'normal' => 'Normal',
                'high' => 'High',
                'emergency' => 'Emergency',
            ])->required()->default('normal'),
            Select::make('status')->options([
                'unassigned' => 'Unassigned',
                'scheduled' => 'Scheduled',
                'en_route' => 'En route',
                'on_site' => 'On site',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ])->required()->default('unassigned'),
            TextInput::make('quoted_amount')->numeric()->prefix('$'),
            DateTimePicker::make('scheduled_at'),
            DateTimePicker::make('eta_at'),
            Textarea::make('description')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable()->sortable(),
                TextColumn::make('title')->limit(32)->searchable(),
                TextColumn::make('trade_type')->badge(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('technician.name')->label('Tech')->placeholder('—'),
                TextColumn::make('priority')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('scheduled_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('trade_type')->options(config('trades.trade_types')),
                SelectFilter::make('status')->options([
                    'unassigned' => 'Unassigned',
                    'scheduled' => 'Scheduled',
                    'en_route' => 'En route',
                    'on_site' => 'On site',
                    'completed' => 'Completed',
                ]),
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
            'index' => ManageJobs::route('/'),
        ];
    }
}
