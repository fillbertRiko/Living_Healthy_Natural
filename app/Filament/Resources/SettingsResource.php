<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SettingsResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Khóa')
                    ->required()
                    ->unique(Setting::class, 'key'),

                Forms\Components\TextInput::make('value')
                    ->label('Giá trị')
                    ->required(),

                Forms\Components\Select::make('type')
                    ->label('Loại')
                    ->options([
                        'string' => 'Chuỗi',
                        'integer' => 'Số nguyên',
                        'boolean' => 'Boolean',
                        'json' => 'JSON',
                    ])
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->label('Mô tả'),

                Forms\Components\Toggle::make('is_visible')
                    ->label('Hiển thị'),

                Forms\Components\Toggle::make('is_editable')
                    ->label('Có thể chỉnh sửa'),

                Forms\Components\Toggle::make('is_required')
                    ->label('Bắt buộc'),

                Forms\Components\TextInput::make('default_value')
                    ->label('Giá trị mặc định'),

                Forms\Components\TextInput::make('group')
                    ->label('Nhóm'),

                Forms\Components\TextInput::make('category')
                    ->label('Danh mục'),

                Forms\Components\TextInput::make('section')
                    ->label('Phần'),

                Forms\Components\TextInput::make('subsection')
                    ->label('Phần con'),

                Forms\Components\TextInput::make('icon')
                    ->label('Biểu tượng'),

                Forms\Components\FileUpload::make('image')
                    ->label('Hình ảnh'),

                Forms\Components\TextInput::make('url')
                    ->label('URL'),

                Forms\Components\ColorPicker::make('color')
                    ->label('Màu sắc'),

                Forms\Components\TextInput::make('font')
                    ->label('Phông chữ'),

                Forms\Components\TextInput::make('size')
                    ->label('Kích thước'),

                Forms\Components\TextInput::make('style')
                    ->label('Kiểu'),

                Forms\Components\TextInput::make('position')
                    ->label('Vị trí'),

                Forms\Components\TextInput::make('alignment')
                    ->label('Căn chỉnh'),

                Forms\Components\TextInput::make('animation')
                    ->label('Hoạt ảnh'),

                Forms\Components\TextInput::make('transition')
                    ->label('Chuyển tiếp'),

                Forms\Components\Toggle::make('visibility')
                    ->label('Hiển thị'),

                Forms\Components\TextInput::make('access_level')
                    ->label('Cấp độ truy cập'),

                Forms\Components\TextInput::make('access_group')
                    ->label('Nhóm truy cập'),

                Forms\Components\TextInput::make('access_role')
                    ->label('Vai trò truy cập'),

                Forms\Components\TextInput::make('access_permission')
                    ->label('Quyền truy cập'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Khóa')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Giá trị')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Loại')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_visible')
                    ->label('Hiển thị'),

                Tables\Columns\BooleanColumn::make('is_editable')
                    ->label('Có thể chỉnh sửa'),

                Tables\Columns\TextColumn::make('group')
                    ->label('Nhóm'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Danh mục'),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_visible')
                    ->label('Hiển thị')
                    ->query(fn(Builder $query) => $query->where('is_visible', true)),

                Tables\Filters\Filter::make('is_editable')
                    ->label('Có thể chỉnh sửa')
                    ->query(fn(Builder $query) => $query->where('is_editable', true)),
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
            // Thêm các quan hệ nếu cần
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSettings::route('/create'),
            'edit' => Pages\EditSettings::route('/{record}/edit'),
        ];
    }
}
