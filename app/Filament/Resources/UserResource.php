<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Actions\ActionGroup;
use Filament\Actions\Modal\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\Filter;


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
                    ->options([
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->default('user') // Đặt giá trị mặc định là 'user'
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Mật Khẩu')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                    ->dehydrated(fn ($state) => filled($state))
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
                TextColumn::make('role')
                    ->label('Vai Trò')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                        'user' => 'User',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Số Điện Thoại')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('address')
                    ->label('Địa Chỉ')
                    ->searchable()
                    ->limit(50), // Giới hạn hiển thị 50 ký tự
                TextColumn::make('created_at')
                    ->label('Ngày Tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('updated_at')
                    ->label('Ngày Cập Nhật')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Lọc theo vai trò')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                        'user' => 'User',
                    ]),
                TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                DeleteBulkAction::make()->label('Xóa hàng loạt')->requiresConfirmation(),
            ])
            ->searchable()
            ->defaultSort('created_at', 'desc')
            ->emptyStateHeading('Không có dữ liệu')
            ->emptyStateDescription('Hiện tại không có dữ liệu nào trong hệ thống.')
            ->emptyStateIcon('heroicon-o-database');
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'super_admin';
    }
    public static function getNavigationItems(): array
    {
        return Auth::user()?->role === 'super_admin'
            ? parent::getNavigationItems()
            : collect(parent::getNavigationItems())->reject(fn ($item) => in_array($item['label'], ['Quản lý hệ thống']));
    }
}
