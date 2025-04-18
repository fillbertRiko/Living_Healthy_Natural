<?php

namespace App\Filament\Resources\LogResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CheckRelationManager extends RelationManager
{
    protected static string $relationship = 'logs'; // Đảm bảo tên quan hệ đúng với model

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('action') // Đảm bảo tên cột đúng với model
                    ->label('Action')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ip_address') // Đảm bảo tên cột đúng với model
                    ->label('IP Address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('device') // Đảm bảo tên cột đúng với model
                    ->label('Device')
                    ->maxLength(255),
                Forms\Components\TextInput::make('browser') // Đảm bảo tên cột đúng với model
                    ->label('Browser')
                    ->maxLength(255),
                Forms\Components\TextInput::make('platform') // Đảm bảo tên cột đúng với model
                    ->label('Platform')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('action') // Đảm bảo tên cột đúng với model
            ->columns([
                Tables\Columns\TextColumn::make('action') // Đảm bảo tên cột đúng với model
                    ->label('Action'),
                Tables\Columns\TextColumn::make('ip_address') // Đảm bảo tên cột đúng với model
                    ->label('IP Address'),
                Tables\Columns\TextColumn::make('device') // Đảm bảo tên cột đúng với model
                    ->label('Device'),
                Tables\Columns\TextColumn::make('browser') // Đảm bảo tên cột đúng với model
                    ->label('Browser'),
                Tables\Columns\TextColumn::make('platform') // Đảm bảo tên cột đúng với model
                    ->label('Platform'),
            ])
            ->filters([
                // Thêm bộ lọc nếu cần
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
