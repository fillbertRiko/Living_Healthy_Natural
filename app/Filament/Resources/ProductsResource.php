<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductsResource\Pages;
use App\Filament\Resources\ProductsResource\RelationManagers;
use App\Models\Products;
use Filament\Forms\Components\Select;
use App\Models\Categories;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker; 
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class ProductsResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Thông tin sản phẩm')->schema([
                        TextInput::make('name')
                            ->label('Tên sản phẩm')
                            ->required()
                            ->maxLength(255),

                        Select::make('category_id')
                            ->label('Danh mục')
                            ->required()
                            ->searchable()
                            ->relationship('categories', 'name')
                            ->preload()
                            ->afterStateUpdated(fn ($state, $set) =>$set('slug', 
                                Categories::find($state)?->slug ?? '')),

                        MarkdownEditor::make('description')
                            ->label('Thông tin về sản phẩm')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('products')
                        ])->columns(2),

                    Section::make('Hình ảnh sản phẩm')->schema([
                        FileUpload::make('image')
                            ->image()
                            ->directory('products'),
                                 
                        ]),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Giá tiền')->schema([
                        TextInput::make('price')
                            ->label('Giá')
                            ->numeric()
                            ->required()
                            ->prefix('VND'),

                        TextInput::make('quantity')
                            ->label('Số lượng')
                            ->numeric()
                            ->required()
                            ->prefix('Thùng'),
                    ]),

                    Section::make('Trạng thái sản phẩm')->schema([
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Tên sản phẩm')
                    ->searchable(),

                TextColumn::make('slug')
                    ->label('Tên danh mục')
                    ->sortable(),

                TextColumn::make('price')
                    ->money('VND')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tạo lúc')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                
                TextColumn::make('updated_at')
                    ->label('Chỉnh sửa gần nhất')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProducts::route('/create'),
            'edit' => Pages\EditProducts::route('/{record}/edit'),
        ];
    }
}
