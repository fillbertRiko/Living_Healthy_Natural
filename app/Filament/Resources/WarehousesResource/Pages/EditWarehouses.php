<?php

namespace App\Filament\Resources\WarehousesResource\Pages;

use App\Filament\Resources\WarehousesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarehouses extends EditRecord
{
    protected static string $resource = WarehousesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
