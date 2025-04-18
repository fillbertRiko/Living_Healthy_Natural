<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Filament\Widgets\Widget;

class OrderOverview extends Widget
{
    protected static string $view = 'filament.resources.order-resource.widgets.order-overview';

    public array $data = [];

    public function mount(): void
    {
        // Example: Fetch data to pass to the view
        $this->data = [
            'totalOrders' => 120, // Replace with actual logic to fetch total orders
            'pendingOrders' => 30, // Replace with actual logic to fetch pending orders
        ];
    }
}
