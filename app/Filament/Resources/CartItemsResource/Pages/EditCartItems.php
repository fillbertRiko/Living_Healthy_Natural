<?php

namespace App\Filament\Resources\CartItemsResource\Pages;

use App\Filament\Resources\CartItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCartItems extends EditRecord
{
    protected static string $resource = CartItemsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
