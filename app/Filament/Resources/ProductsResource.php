<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Filament\Forms\Components\{Select, Section, Grid, TextInput, FileUpload, MarkdownEditor, Toggle};
use Filament\Tables\Columns\{TextColumn, BooleanColumn};
use Filament\Tables\Filters\SelectFilter;

class ProductsResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin sản phẩm')->schema([
                    TextInput::make('name')
                        ->label('Tên sản phẩm')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('sku')
                        ->label('Mã sản phẩm')
                        ->maxLength(50),

                    TextInput::make('barcode')
                        ->label('Mã vạch')
                        ->maxLength(50),

                    Select::make('category_id')
                        ->label('Danh mục')
                        ->required()
                        ->searchable()
                        ->relationship('category', 'name')
                        ->preload(),

                    MarkdownEditor::make('description')
                        ->label('Mô tả sản phẩm')
                        ->columnSpanFull(),

                    FileUpload::make('image')
                        ->label('Hình ảnh')
                        ->image()
                        ->directory('products'),
                ])->columns(2),

                Section::make('Thông tin bổ sung')->schema([
                    TextInput::make('brand')
                        ->label('Thương hiệu'),

                    TextInput::make('model')
                        ->label('Mẫu mã'),

                    TextInput::make('color')
                        ->label('Màu sắc'),

                    TextInput::make('size')
                        ->label('Kích thước'),

                    TextInput::make('weight')
                        ->label('Cân nặng'),

                    TextInput::make('dimensions')
                        ->label('Kích thước (DxRxC)'),

                    TextInput::make('material')
                        ->label('Chất liệu'),

                    TextInput::make('warranty')
                        ->label('Bảo hành'),
                ])->columns(2),

                Section::make('Giá và trạng thái')->schema([
                    TextInput::make('price')
                        ->label('Giá')
                        ->numeric()
                        ->required()
                        ->prefix('VND'),

                    TextInput::make('quantity')
                        ->label('Số lượng')
                        ->numeric()
                        ->required(),

                    Toggle::make('is_active')
                        ->label('Kích hoạt')
                        ->default(true),

                    Toggle::make('is_featured')
                        ->label('Nổi bật'),

                    Toggle::make('is_on_sale')
                        ->label('Đang giảm giá'),

                    Toggle::make('is_new')
                        ->label('Sản phẩm mới'),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable(),

                TextColumn::make('category.name')
                    ->label('Danh mục')
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Giá')
                    ->money('VND')
                    ->sortable(),

                BooleanColumn::make('is_active')
                    ->label('Kích hoạt'),

                BooleanColumn::make('is_featured')
                    ->label('Nổi bật'),

                BooleanColumn::make('is_on_sale')
                    ->label('Giảm giá'),

                BooleanColumn::make('is_new')
                    ->label('Mới'),

                TextColumn::make('created_at')
                    ->label('Tạo lúc')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Chỉnh sửa gần nhất')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('Category')
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('Delete')
                    ->label('Xóa sản phẩm')
                    ->action(fn(Collection $records) => $records->each->delete())
                    ->requiresConfirmation()
                    ->icon('heroicon-o-trash'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}
