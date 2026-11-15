<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\ExchangeRate;

class MyOrders extends Component
{
    public $tasaBcv = 0;

    public function mount()
    {
        $activeRate = ExchangeRate::getActiveRate();
        $this->tasaBcv = $activeRate ? $activeRate->rate : 0;
    }

    public function cancelOrder($orderId)
    {
        $order = Order::where('id', $orderId)->where('user_id', auth()->id())->first();
        
        // Solo se puede cancelar si está pendiente o pagado
        if ($order && in_array($order->status, ['pendiente', 'pagado'])) {
            
            // Devolvemos el stock al inventario
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('stock', $item->quantity);
                }
            }

            $order->update(['status' => 'cancelado']);
            session()->flash('message', 'Pedido cancelado correctamente y stock devuelto.');
        }
    }

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->get();

        return view('livewire.my-orders', [
            'orders' => $orders
        ])->layout('components.layouts.app');
    }
}