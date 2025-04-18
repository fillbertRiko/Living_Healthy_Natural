<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên Tài Khoản')
                    ->required()
                    ->placeholder('Nhập tên tài khoản')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Địa chỉ Email')
                    ->email()
                    ->required()
                    ->placeholder('Nhập địa chỉ email')
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('role')
                    ->label('Vai trò')
                    ->options(User::query()->distinct()->pluck('role', 'role')->toArray())
                    ->default('user')
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Mật Khẩu')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateUser)
                    ->dehydrated(fn($state) => filled($state))
                    ->placeholder('Nhập mật khẩu'),
                Forms\Components\TextInput::make('phone')
                    ->label('Số Điện Thoại')
                    ->placeholder('Nhập số điện thoại')
                    ->tel()
                    ->maxLength(15),
                Forms\Components\TextInput::make('address')
                    ->label('Địa Chỉ')
                    ->placeholder('Nhập địa chỉ')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('avatar')
                    ->label('Ảnh Đại Diện')
                    ->image()
                    ->directory('avatars')
                    ->placeholder('Tải lên ảnh đại diện'),
                Forms\Components\DateTimePicker::make('created_at')
                    ->label('Email Được Tạo Lúc')
                    ->default(now())
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên Tài Khoản')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Địa chỉ Email')
                    ->searchable()
                    ->sortable(),
                BadgeColumn::make('role')
                    ->label('Vai Trò')
                    ->colors([
                        'primary' => 'user',
                        'success' => 'admin',
                        'danger' => 'super_admin',
                    ])
                    ->formatStateUsing(fn($state) => ucfirst(str_replace('_', ' ', $state)))
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Số Điện Thoại')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Địa Chỉ')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Ngày Cập Nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Lọc theo vai trò')
                    ->options(User::query()->distinct()->pluck('role', 'role')->toArray()),
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make()->label('Xóa hàng loạt')->requiresConfirmation(),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Không có dữ liệu')
            ->emptyStateDescription('Hiện tại không có dữ liệu nào trong hệ thống.')
            ->emptyStateIcon('heroicon-o-database');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user instanceof \App\Models\User && $user->isSuperAdmin();
    }

    public static function getNavigationItems(): array
    {
        $items = parent::getNavigationItems();
        $user = Auth::user();
        // Kiểm tra xem user có phải là super admin không
        $isSuperAdmin = $user instanceof \App\Models\User && $user->isSuperAdmin();

        // Nếu user là super admin, trả về tất cả navigation items
        if ($isSuperAdmin) {
            return $items;
        }

        // Nếu không, lọc bỏ các mục có nhãn 'Quản lý hệ thống'
        return collect($items)
            ->reject(fn($item) => in_array($item['label'], ['Quản lý hệ thống']))
            ->all();
    }
}
