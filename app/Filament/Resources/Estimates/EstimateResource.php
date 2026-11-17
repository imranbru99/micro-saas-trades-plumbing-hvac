<?php

namespace App\Filament\Resources\Estimates;

use App\Filament\Resources\Estimates\Pages\ManageEstimates;
use App\Models\Estimate;
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

class EstimateResource extends Resource
{
    protected static ?string $model = Estimate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('estimates');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('number')->required()->unique(ignoreRecord: true)->maxLength(40),
            TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(160),
            TextInput::make('title')->required()->maxLength(200),
            Select::make('customer_id')->relationship('customer', 'name')->searchable()->required(),
            Select::make('service_job_id')->relationship('serviceJob', 'number')->searchable(),
            Select::make('created_by')->relationship('creator', 'name')->searchable(),
            Select::make('trade_type')->options(config('trades.trade_types'))->required(),
            Select::make('status')->options([
                'draft' => 'Draft',
                'sent' => 'Sent',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'converted' => 'Converted',
            ])->required()->default('draft'),
            TextInput::make('subtotal')->numeric()->prefix('$'),
            TextInput::make('tax_amount')->numeric()->prefix('$'),
            TextInput::make('total')->numeric()->prefix('$'),
            TextInput::make('deposit_required')->numeric()->prefix('$'),
            DateTimePicker::make('valid_until'),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->searchable()->sortable(),
                TextColumn::make('title')->limit(28),
                TextColumn::make('customer.name'),
                TextColumn::make('trade_type')->badge(),
                TextColumn::make('status')->badge(),
                TextColumn::make('total')->money('USD'),
                TextColumn::make('valid_until')->date(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'draft' => 'Draft',
                    'sent' => 'Sent',
                    'approved' => 'Approved',
                    'converted' => 'Converted',
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
            'index' => ManageEstimates::route('/'),
        ];
    }
}
