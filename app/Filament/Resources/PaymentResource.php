<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payments;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payments::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->required()
                    ->numeric()
                    ->label('Order ID'),
                Forms\Components\DatePicker::make('payment_date')
                    ->required()
                    ->label('Payment Date'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->label('Amount'),
                Forms\Components\Select::make('payment_method')
                    ->options(array_combine(Payments::PAYMENT_METHODS, Payments::PAYMENT_METHODS))
                    ->required()
                    ->label('Payment Method'),
                Forms\Components\Select::make('status')
                    ->options(array_combine(Payments::STATUSES, Payments::STATUSES))
                    ->required()
                    ->label('Status'),
                Forms\Components\TextInput::make('transaction_id')
                    ->label('Transaction ID'),
                Forms\Components\TextInput::make('currency')
                    ->required()
                    ->label('Currency'),
                Forms\Components\TextInput::make('payment_gateway')
                    ->label('Payment Gateway'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id')->label('Order ID')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('payment_date')->label('Payment Date')->date()->sortable(),
                Tables\Columns\TextColumn::make('amount')->label('Amount')->sortable(),
                Tables\Columns\TextColumn::make('payment_method')->label('Payment Method')->sortable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->sortable(),
                Tables\Columns\TextColumn::make('transaction_id')->label('Transaction ID')->searchable(),
                Tables\Columns\TextColumn::make('currency')->label('Currency'),
                Tables\Columns\TextColumn::make('payment_gateway')->label('Payment Gateway'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options(array_combine(Payments::PAYMENT_METHODS, Payments::PAYMENT_METHODS))
                    ->label('Payment Method'),
                Tables\Filters\SelectFilter::make('status')
                    ->options(array_combine(Payments::STATUSES, Payments::STATUSES))
                    ->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Define relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
