<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('invoice_number')->required()->unique(ignoreRecord: true)->default(fn () => 'INV-'.now()->format('ymd').'-'.random_int(100,999)),
            Forms\Components\Select::make('customer_id')->relationship('customer', 'name')->searchable()->preload()->required(),
            Forms\Components\Select::make('project_id')->relationship('project', 'title')->searchable()->preload(),
            Forms\Components\DatePicker::make('issue_date')->required()->default(now()),
            Forms\Components\DatePicker::make('due_date'),
            Forms\Components\TextInput::make('subtotal')->numeric()->prefix('$')->required(),
            Forms\Components\TextInput::make('tax')->numeric()->prefix('$')->default(0),
            Forms\Components\TextInput::make('total')->numeric()->prefix('$')->required(),
            Forms\Components\TextInput::make('amount_paid')->numeric()->prefix('$')->default(0),
            Forms\Components\Select::make('status')->options([
                'draft' => 'Draft', 'sent' => 'Sent', 'partial' => 'Partial', 'paid' => 'Paid', 'overdue' => 'Overdue',
            ])->default('draft')->required(),
            Forms\Components\Textarea::make('notes')->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('invoice_number')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('customer.name')->searchable(),
            Tables\Columns\TextColumn::make('issue_date')->date(),
            Tables\Columns\TextColumn::make('total')->money('USD'),
            Tables\Columns\TextColumn::make('amount_paid')->money('USD'),
            Tables\Columns\BadgeColumn::make('status')->colors([
                'gray' => 'draft', 'info' => 'sent', 'warning' => 'partial', 'success' => 'paid', 'danger' => 'overdue',
            ]),
        ])->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}