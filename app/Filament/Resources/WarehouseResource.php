<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;

/**
 * Quản lý tài nguyên kho hàng
 */
class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông Tin Chung')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Tên'),
                        Forms\Components\TextInput::make('location')
                            ->required()
                            ->label('Vị Trí'),
                        Forms\Components\TextInput::make('manager')
                            ->label('Quản Lý'),
                        Forms\Components\TextInput::make('contact_number')
                            ->label('Số Điện Thoại'),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->label('Email'),
                        Forms\Components\Textarea::make('description')
                            ->label('Mô Tả')
                            ->columnSpan(2),
                    ]),
                Section::make('Chi Tiết Kho')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('capacity')
                            ->numeric()
                            ->label('Sức Chứa'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Hoạt Động',
                                'inactive' => 'Không Hoạt Động',
                                'maintenance' => 'Bảo Trì',
                            ])
                            ->label('Trạng Thái'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Hoạt Động'),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Nổi Bật'),
                        Forms\Components\Toggle::make('is_on_sale')
                            ->label('Đang Giảm Giá'),
                        Forms\Components\Toggle::make('is_new')
                            ->label('Mới'),
                    ]),
                Section::make('Thông Tin SEO')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Tiêu Đề SEO'),
                        Forms\Components\Textarea::make('meta_description')
                            ->label('Mô Tả SEO')
                            ->columnSpan(2),
                    ]),
                Section::make('Thời Gian')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Ngày Tạo')
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->label('Vị Trí')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager')
                    ->label('Quản Lý'),
                Tables\Columns\TextColumn::make('contact_number')
                    ->label('Số Điện Thoại'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Trạng Thái')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Hoạt Động'),
                Tables\Columns\BooleanColumn::make('is_featured')
                    ->label('Nổi Bật'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Ngày Cập Nhật')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('status')
                    ->label('Trạng Thái')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Hoạt Động',
                                'inactive' => 'Không Hoạt Động',
                                'maintenance' => 'Bảo Trì',
                            ])
                            ->label('Trạng Thái'),
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query->when($data['status'], fn(Builder $query, $status): Builder => $query->where('status', $status))),
                Tables\Filters\Filter::make('created_at')
                    ->label('Ngày Tạo')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Từ Ngày'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Đến Ngày'),
                    ])
                    ->query(fn(Builder $query, array $data): Builder => $query
                        ->when($data['created_from'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                        ->when($data['created_until'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date))),
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
                    ->label('Xóa Đã Chọn')
                    ->requiresConfirmation()
                    ->color('danger'),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Không Có Dữ Liệu')
            ->emptyStateDescription('Hiện tại, không có dữ liệu trong hệ thống.');
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
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
