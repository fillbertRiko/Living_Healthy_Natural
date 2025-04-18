<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Người dùng')
                    ->required(),

                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('Sản phẩm')
                    ->required(),

                Textarea::make('content')
                    ->label('Nội dung')
                    ->required(),

                TextInput::make('comment_title')
                    ->label('Tiêu đề'),

                TextInput::make('comment_image')
                    ->label('URL Hình ảnh'),

                TextInput::make('comment_video')
                    ->label('URL Video'),

                Forms\Components\Toggle::make('is_approved')
                    ->label('Đã duyệt'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Người dùng')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('product.name')
                    ->label('Sản phẩm')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('content')
                    ->label('Nội dung')
                    ->limit(50)
                    ->searchable(),

                BooleanColumn::make('is_approved')
                    ->label('Đã duyệt'),

                TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('approved')
                    ->query(fn(Builder $query) => $query->where('is_approved', true))
                    ->label('Đã duyệt'),
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
            // Ví dụ: CommentResource::class => CommentResource::class,
            // Hoặc các resource khác nếu cần
            // CommentResource::class => CommentResource::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
            'view' => Pages\ViewComment::route('/{record}'),
        ];
    }
}
