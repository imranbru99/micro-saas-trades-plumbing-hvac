<?php

namespace App\Filament\Resources\Properties;

use App\Filament\Resources\Properties\Pages\ManageProperties;
use App\Models\Property;
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

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHomeModern;

    protected static string|UnitEnum|null $navigationGroup = 'CRM';

    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('customers');
    }

    public static function canAccess(): bool
    {
        return static::shouldRegisterNavigation();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('customer_id')->relationship('customer', 'name')->searchable()->required(),
            TextInput::make('label')->required()->maxLength(120),
            TextInput::make('address_line')->maxLength(200),
            TextInput::make('city')->maxLength(80),
            TextInput::make('region')->maxLength(80),
            TextInput::make('postal_code')->maxLength(20),
            Select::make('property_type')->options([
                'home' => 'Home',
                'apartment' => 'Apartment',
                'office' => 'Office',
                'retail' => 'Retail',
                'industrial' => 'Industrial',
            ])->default('home'),
            Textarea::make('access_notes'),
            Textarea::make('equipment_notes'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('label')->searchable(),
                TextColumn::make('customer.name')->label('Customer'),
                TextColumn::make('city'),
                TextColumn::make('property_type')->badge(),
                TextColumn::make('address_line')->limit(28),
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
            'index' => ManageProperties::route('/'),
        ];
    }
}
