<?php

namespace App\Filament\Resources\CartItemsResource\Pages;

use App\Filament\Resources\CartItemsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCartItems extends CreateRecord
{
    protected static string $resource = CartItemsResource::class;
}
