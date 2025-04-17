<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseStocksResource\Pages;
use App\Filament\Resources\WarehouseStocksResource\RelationManagers;
use App\Models\WarehouseStock;
use App\Models\Warehouse;
use App\Models\Products;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WarehouseStocksResource extends Resource
{
    protected static ?string $model = WarehouseStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông Tin Chung')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('warehouse_id')
                            ->label('Kho Hàng')
                            ->relationship('warehouse', 'name') // Hiển thị tên kho
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('product_id')
                            ->label('Sản Phẩm')
                            ->relationship('product', 'name') // Hiển thị tên sản phẩm
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Số Lượng')
                            ->numeric()
                            ->required()
                            ->minValue(1),
                    ]),
                Forms\Components\Section::make('Thời Gian')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Ngày Tạo')
                            ->default(now())
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('updated_at')
                            ->label('Ngày Cập Nhật')
                            ->disabled(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('warehouse.name')
                    ->label('Kho Hàng')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Sản Phẩm')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Số Lượng'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ngày Cập Nhật')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('warehouse')
                    ->label('Kho Hàng')
                    ->form([
                        Forms\Components\Select::make('warehouse_id')
                            ->label('Kho Hàng')
                            ->relationship('warehouse', 'name')
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['warehouse_id'] ?? null,
                            fn (Builder $query, $warehouseId): Builder => $query->where('warehouse_id', $warehouseId)
                        );
                    }),

                Tables\Filters\Filter::make('product')
                    ->label('Sản Phẩm')
                    ->form([
                        Forms\Components\Select::make('product_id')
                            ->label('Sản Phẩm')
                            ->relationship('product', 'name')
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['product_id'] ?? null,
                            fn (Builder $query, $productId): Builder => $query->where('product_id', $productId)
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make()
                    ->label('Xem')
                    ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteAction::make()
                    ->label('Xóa')
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Xóa Hàng Loạt')
                        ->icon('heroicon-o-trash')
                        ->requiresConfirmation()
                        ->modalHeading('Xác Nhận Xóa')
                        ->modalSubheading('Bạn có chắc chắn muốn xóa các mục đã chọn không?'),
                ]),
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
            'index' => Pages\ListWarehouseStocks::route('/'),
            'create' => Pages\CreateWarehouseStocks::route('/create'),
            'edit' => Pages\EditWarehouseStocks::route('/{record}/edit'),
        ];
    }
}
