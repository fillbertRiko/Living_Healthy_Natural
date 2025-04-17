<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Filament\Resources\WarehouseResource\RelationManagers;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Name'),
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->label('Location'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->columnSpan(2),
                    ]),
                Section::make('Timestamps')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Created At')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('updated_at')
                            ->label('Updated At')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->label('Created At')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                    }),
                Tables\Filters\Filter::make('location')
                    ->label('Location')
                    ->form([
                        Forms\Components\TextInput::make('location')
                            ->label('Location'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['location'], fn (Builder $query, $location): Builder => $query->where('location', 'like', "%{$location}%"));
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->label('Delete Selected')
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->searchable()
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Không có dữ liệu')
            ->emptyStateDescription('Hiện tại không có dữ liệu nào trong hệ thống.');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
