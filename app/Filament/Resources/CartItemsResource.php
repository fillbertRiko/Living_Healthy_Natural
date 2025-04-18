<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartItemsResource\Pages;
use App\Models\CartItem;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CartItemsResource extends Resource
{
    protected static ?string $model = CartItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('cart_id')
                    ->relationship('cart', 'id')
                    ->required()
                    ->label('ID Giỏ Hàng'),
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->label('Sản Phẩm'),
                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    ->label('Số Lượng'),
                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->label('Giá'),
                TextInput::make('discount_price')
                    ->numeric()
                    ->label('Giá Giảm'),
                TextInput::make('currency')
                    ->required()
                    ->label('Tiền Tệ'),
                TextInput::make('status')
                    ->required()
                    ->label('Trạng Thái'),
                TextInput::make('product_name')
                    ->required()
                    ->label('Tên Sản Phẩm'),
                TextInput::make('product_sku')
                    ->label('Mã SKU Sản Phẩm'),
                TextInput::make('product_image')
                    ->label('Hình Ảnh Sản Phẩm'),
                TextInput::make('product_description')
                    ->label('Mô Tả Sản Phẩm'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('cart.id')->label('ID Giỏ Hàng')->sortable(),
                TextColumn::make('product.name')->label('Tên Sản Phẩm')->sortable(),
                TextColumn::make('quantity')->label('Số Lượng')->sortable(),
                TextColumn::make('price')->label('Giá')->sortable(),
                TextColumn::make('discount_price')->label('Giá Giảm')->sortable(),
                TextColumn::make('currency')->label('Tiền Tệ'),
                TextColumn::make('status')->label('Trạng Thái'),
            ])
            ->filters([
                // Thêm bộ lọc nếu cần
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
            // Định nghĩa quan hệ nếu cần
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCartItems::route('/'),
            'create' => Pages\CreateCartItems::route('/create'),
            'edit' => Pages\EditCartItems::route('/{record}/edit'),
        ];
    }
}
