<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin khách hàng')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('full_name')
                                    ->label('Họ và tên')
                                    ->required()
                                    ->maxlength(255),

                                TextInput::make('email')
                                    ->label('Email')
                                    ->required()
                                    ->email()
                                    ->maxlength(255),

                                TextInput::make('phone')
                                    ->label('Số điện thoại')
                                    ->maxlength(255),

                                Textarea::make('address')
                                    ->label('Địa chỉ')
                                    ->rows(3)
                                    ->maxlength(500),

                                TextInput::make('loyalty_card_number')
                                    ->label('Số thẻ thành viên'),

                                TextInput::make('loyalty_points')
                                    ->label('Điểm tích lũy')
                                    ->numeric(),

                                Select::make('membership_level')
                                    ->label('Cấp độ thành viên')
                                    ->options([
                                        'bronze' => 'Bronze',
                                        'silver' => 'Silver',
                                        'gold' => 'Gold',
                                        'platinum' => 'Platinum',
                                    ]),

                                DatePicker::make('date_of_birth')
                                    ->label('Ngày sinh'),

                                Select::make('gender')
                                    ->label('Giới tính')
                                    ->options([
                                        'male' => 'Nam',
                                        'female' => 'Nữ',
                                        'other' => 'Khác',
                                    ]),

                                TextInput::make('referral_code')
                                    ->label('Mã giới thiệu'),

                                TextInput::make('preferred_contact_method')
                                    ->label('Phương thức liên hệ ưu tiên'),

                                TextInput::make('preferred_language')
                                    ->label('Ngôn ngữ ưu tiên'),

                                TextInput::make('preferred_currency')
                                    ->label('Tiền tệ ưu tiên'),

                                Textarea::make('notes')
                                    ->label('Ghi chú')
                                    ->rows(3),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Họ và tên')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Số điện thoại'),
                Tables\Columns\TextColumn::make('loyalty_points')
                    ->label('Điểm tích lũy'),
                Tables\Columns\TextColumn::make('membership_level')
                    ->label('Cấp độ thành viên'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tạo lúc')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_today')
                    ->label('Tạo hôm nay')
                    ->query(fn(Builder $query) => $query->whereDate('created_at', now()->toDateString())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
