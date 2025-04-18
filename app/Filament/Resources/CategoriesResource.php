<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoriesResource\Pages;
use App\Models\Categories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class CategoriesResource extends Resource
{
    protected static ?string $model = Categories::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->label('Tên Danh Mục Sản Phẩm')
                                    ->required()
                                    ->maxlength(255)
                                    ->live(),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxlength(255)
                                    ->unique(Categories::class, 'slug', ignoreRecord: true),

                                TextInput::make('description')
                                    ->label('Thông tin chi tiết danh mục')
                                    ->required()
                                    ->maxlength(255),

                                TextInput::make('meta_title')
                                    ->label('Meta Title')
                                    ->maxlength(255),

                                TextInput::make('meta_description')
                                    ->label('Meta Description')
                                    ->maxlength(255),
                            ]),
                        FileUpload::make('image')
                            ->label('Hình Ảnh Sản Phẩm')
                            ->image()
                            ->directory('categories'),

                        Toggle::make('active')
                            ->label('Sản phẩm đang bán')
                            ->required()
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên danh mục')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Thông tin chi tiết danh mục')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('Hình ảnh'),
                Tables\Columns\IconColumn::make('active')
                    ->label('Hoạt động')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tạo lúc')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Chỉnh sửa gần nhất')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Đang hoạt động')
                    ->query(fn(Builder $query) => $query->where('active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategories::route('/create'),
            'edit' => Pages\EditCategories::route('/{record}/edit'),
        ];
    }
}
