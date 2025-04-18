<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\Widget;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\CreateAction;

class OrderOverview extends Widget
{
    protected static string $view = 'filament.resources.order-resource.widgets.order-overview';

    public array $data = [];

    public function mount(): void
    {
        $this->data = [
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
            'cancelledOrders' => Order::where('status', 'cancelled')->count(),
            'totalRevenue' => Order::sum('total'),
            'recentOrders' => Order::latest()->take(5)->get(),
            'averageOrderValue' => Order::avg('total'),
            'orderStatusDistribution' => Order::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'paymentMethodDistribution' => Order::selectRaw('payment_method, COUNT(*) as count')
                ->groupBy('payment_method')
                ->get(),
        ];
    }
}

class OrderReview extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderOverview::class,
        ];
    }
}
