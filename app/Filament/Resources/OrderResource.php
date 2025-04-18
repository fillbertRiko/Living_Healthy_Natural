<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Chi tiết đơn hàng')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Thông tin chung')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Tên khách hàng')
                                    ->options(User::pluck('name', 'id')->toArray())
                                    ->searchable()
                                    ->required(),
                                Forms\Components\DatePicker::make('order_date')
                                    ->label('Ngày đặt hàng')
                                    ->required(),
                                Forms\Components\Select::make('status')
                                    ->label('Trạng thái')
                                    ->options([
                                        'pending' => 'Đang chờ xử lý',
                                        'processing' => 'Đang xử lý',
                                        'completed' => 'Hoàn thành',
                                        'cancelled' => 'Đã hủy',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('total')
                                    ->label('Tổng cộng')
                                    ->numeric()
                                    ->required(),
                                Forms\Components\TextInput::make('payment_method')
                                    ->label('Phương thức thanh toán'),
                                Forms\Components\TextInput::make('tracking_number')
                                    ->label('Mã theo dõi'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Thông tin vận chuyển')
                            ->schema([
                                Forms\Components\Textarea::make('shipping_address')
                                    ->label('Địa chỉ giao hàng')
                                    ->required(),
                                Forms\Components\TextInput::make('shipping_method')
                                    ->label('Phương thức vận chuyển'),
                                Forms\Components\TextInput::make('shipping_cost')
                                    ->label('Chi phí vận chuyển')
                                    ->numeric(),
                                Forms\Components\Textarea::make('billing_address')
                                    ->label('Địa chỉ thanh toán'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Thông tin bổ sung')
                            ->schema([
                                Forms\Components\TextInput::make('coupon_code')
                                    ->label('Mã giảm giá'),
                                Forms\Components\TextInput::make('discount')
                                    ->label('Giảm giá')
                                    ->numeric(),
                                Forms\Components\Textarea::make('notes')
                                    ->label('Ghi chú'),
                                Forms\Components\DateTimePicker::make('created_at')
                                    ->label('Ngày tạo')
                                    ->disabled(),
                                Forms\Components\DateTimePicker::make('updated_at')
                                    ->label('Ngày cập nhật')
                                    ->disabled(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('user.name')->label('Khách hàng')->sortable()->searchable(),
                TextColumn::make('order_date')->label('Ngày đặt hàng')->date()->sortable(),
                TextColumn::make('status')->label('Trạng thái')->sortable(),
                TextColumn::make('total')->label('Tổng cộng')->money('VND')->sortable(),
                TextColumn::make('shipping_address')->label('Địa chỉ giao hàng')->limit(50),
                TextColumn::make('payment_method')->label('Phương thức thanh toán'),
                TextColumn::make('tracking_number')->label('Mã theo dõi'),
                TextColumn::make('created_at')->label('Ngày tạo')->dateTime()->sortable(),
                TextColumn::make('updated_at')->label('Ngày cập nhật')->dateTime()->sortable(),
            ])
            ->filters([
                Filter::make('completed')->label('Hoàn thành')->query(fn(Builder $query) => $query->where('status', 'completed')),
                Filter::make('pending')->label('Đang chờ xử lý')->query(fn(Builder $query) => $query->where('status', 'pending')),
                Filter::make('processing')->label('Đang xử lý')->query(fn(Builder $query) => $query->where('status', 'processing')),
                Filter::make('cancelled')->label('Đã hủy')->query(fn(Builder $query) => $query->where('status', 'cancelled')),
            ])
            ->actions([
                EditAction::make()->label('Chỉnh sửa')->icon('heroicon-o-pencil')->color('primary'),
                ViewAction::make()->label('Xem chi tiết')->icon('heroicon-o-eye')->color('success'),
                DeleteAction::make()
                    ->label('Xóa')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Xác nhận xóa')
                    ->modalDescription('Bạn có chắc chắn muốn xóa đơn hàng này?')
                    ->action(fn($record) => $record->delete()),
            ])
            ->bulkActions([
                BulkAction::make('markAsCompleted')
                    ->label('Đánh dấu là hoàn thành')
                    ->action(fn(Collection $records) => $records->each->update(['status' => 'completed']))
                    ->requiresConfirmation()
                    ->color('success'),
                BulkAction::make('markAsCancelled')
                    ->label('Đánh dấu là đã hủy')
                    ->action(fn(Collection $records) => $records->each->update(['status' => 'cancelled']))
                    ->requiresConfirmation()
                    ->color('danger'),
                BulkAction::make('markAsProcessing')
                    ->label('Đánh dấu là đang xử lý')
                    ->action(fn(Collection $records) => $records->each->update(['status' => 'processing']))
                    ->requiresConfirmation()
                    ->color('warning'),
                BulkAction::make('markAsPending')
                    ->label('Đánh dấu là đang chờ xử lý')
                    ->action(fn(Collection $records) => $records->each->update(['status' => 'pending']))
                    ->requiresConfirmation()
                    ->color('secondary'),
            ])
            ->searchable()
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Không có đơn hàng nào')
            ->emptyStateDescription('Hiện tại không có đơn hàng nào trong hệ thống.');
    }

    public static function getRelations(): array
    {
        return [
            // Thêm các quan hệ nếu cần
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
