<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Models\Cart;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('customer_id')
                    ->label('Mã khách hàng')
                    ->numeric()
                    ->required(),
                TextInput::make('session_id')
                    ->label('Mã phiên')
                    ->maxLength(255),
                TextInput::make('ip_address')
                    ->label('Địa chỉ IP')
                    ->maxLength(45),
                TextInput::make('user_agent')
                    ->label('User Agent')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Đang chờ',
                        'completed' => 'Hoàn thành',
                        'cancelled' => 'Đã hủy',
                    ])
                    ->required(),
                TextInput::make('total_items')
                    ->label('Tổng số lượng')
                    ->numeric(),
                TextInput::make('total_price')
                    ->label('Tổng giá')
                    ->numeric(),
                TextInput::make('discount_code')
                    ->label('Mã giảm giá')
                    ->maxLength(50),
                TextInput::make('discount_amount')
                    ->label('Số tiền giảm giá')
                    ->numeric(),
                TextInput::make('currency')
                    ->label('Tiền tệ')
                    ->maxLength(10),
                TextInput::make('shipping_method')
                    ->label('Phương thức vận chuyển')
                    ->maxLength(50),
                TextInput::make('shipping_cost')
                    ->label('Chi phí vận chuyển')
                    ->numeric(),
                Select::make('payment_status')
                    ->label('Trạng thái thanh toán')
                    ->options([
                        'unpaid' => 'Chưa thanh toán',
                        'paid' => 'Đã thanh toán',
                        'refunded' => 'Đã hoàn tiền',
                    ]),
                Select::make('payment_method')
                    ->label('Phương thức thanh toán')
                    ->options([
                        'credit_card' => 'Thẻ tín dụng',
                        'paypal' => 'PayPal',
                        'bank_transfer' => 'Chuyển khoản ngân hàng',
                        'cash_on_delivery' => 'Thanh toán khi nhận hàng',
                    ])
                    ->required(),
                Textarea::make('shipping_address')
                    ->label('Địa chỉ giao hàng'),
                Textarea::make('billing_address')
                    ->label('Địa chỉ thanh toán'),
                Textarea::make('notes')
                    ->label('Ghi chú'),
                TextInput::make('gift_message')
                    ->label('Tin nhắn quà tặng')
                    ->maxLength(255),
                BooleanColumn::make('gift_wrap')
                    ->label('Gói quà'),
                TextInput::make('loyalty_points_used')
                    ->label('Điểm trung thành đã sử dụng')
                    ->numeric(),
                TextInput::make('loyalty_points_earned')
                    ->label('Điểm trung thành đã nhận')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('customer_id')->label('Mã khách hàng')->sortable(),
                TextColumn::make('status')->label('Trạng thái')->sortable(),
                TextColumn::make('total_items')->label('Tổng số lượng')->sortable(),
                TextColumn::make('total_price')->label('Tổng giá')->sortable()->money('USD'),
                TextColumn::make('payment_status')->label('Trạng thái thanh toán'),
                BooleanColumn::make('gift_wrap')->label('Gói quà'),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime(),
                TextColumn::make('updated_at')->label('Ngày cập nhật')->dateTime(),
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
            // Định nghĩa các quan hệ nếu cần
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarts::route('/'),
            'create' => Pages\CreateCart::route('/create'),
            'edit' => Pages\EditCart::route('/{record}/edit'),
        ];
    }
}
