<?php

namespace App\Filament\Resources\ModuleSettings;

use App\Enums\UserRole;
use App\Filament\Resources\ModuleSettings\Pages\ManageModuleSettings;
use App\Models\ModuleSetting;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class ModuleSettingResource extends Resource
{
    protected static ?string $model = ModuleSetting::class;

    protected static ?string $navigationLabel = 'Modules';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    protected static string|UnitEnum|null $navigationGroup = 'Platform';

    protected static ?int $navigationSort = 1;

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user?->role instanceof UserRole && $user->role->canManageModules();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('key')->disabled(),
            TextInput::make('name')->required(),
            TextInput::make('category'),
            TextInput::make('hours_saved_weekly')->numeric(),
            Toggle::make('enabled'),
            Toggle::make('is_core')->disabled(),
            Textarea::make('description')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->searchable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('category')->badge(),
                IconColumn::make('enabled')->boolean(),
                IconColumn::make('is_core')->boolean()->label('Core'),
                TextColumn::make('hours_saved_weekly')->label('Hrs/wk'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageModuleSettings::route('/'),
        ];
    }
}
