<?php

namespace App\Filament\Resources\WarehouseStocksResource\Pages;

use App\Filament\Resources\WarehouseStocksResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWarehouseStocks extends EditRecord
{
    protected static string $resource = WarehouseStocksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
