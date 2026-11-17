<?php

namespace App\Filament\Resources\Invoices;

use App\Filament\Resources\Invoices\Pages\ManageInvoices;
use App\Models\Invoice;
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

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static string|UnitEnum|null $navigationGroup = 'Finance';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return app(ModuleManager::class)->enabled('invoicing');
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
            Select::make('estimate_id')->relationship('estimate', 'number')->searchable(),
            Select::make('created_by')->relationship('creator', 'name')->searchable(),
            Select::make('status')->options([
                'draft' => 'Draft',
                'sent' => 'Sent',
                'partial' => 'Partial',
                'paid' => 'Paid',
                'void' => 'Void',
            ])->required()->default('draft'),
            TextInput::make('subtotal')->numeric()->prefix('$'),
            TextInput::make('tax_amount')->numeric()->prefix('$'),
            TextInput::make('total')->numeric()->prefix('$'),
            TextInput::make('amount_paid')->numeric()->prefix('$'),
            TextInput::make('balance_due')->numeric()->prefix('$'),
            DateTimePicker::make('issued_at'),
            DateTimePicker::make('due_at'),
            DateTimePicker::make('paid_at'),
            TextInput::make('pdf_path')->maxLength(255),
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
                TextColumn::make('status')->badge(),
                TextColumn::make('total')->money('USD'),
                TextColumn::make('balance_due')->money('USD'),
                TextColumn::make('due_at')->date(),
            ])
            ->filters([
                SelectFilter::make('status')->options([
                    'draft' => 'Draft',
                    'sent' => 'Sent',
                    'partial' => 'Partial',
                    'paid' => 'Paid',
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
            'index' => ManageInvoices::route('/'),
        ];
    }
}
