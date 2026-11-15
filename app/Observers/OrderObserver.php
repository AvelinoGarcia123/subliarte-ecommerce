<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\User;
use Filament\Notifications\Notification;

class OrderObserver
{
    public function created(Order $order): void
    {
        if ($order->sale_type === 'online') {
            $admins = User::where('role', 'admin')->get();
            
            foreach ($admins as $admin) {
                Notification::make()
                    ->title('Prueba Básica')
                    ->body('Esto es una prueba de la campanita.')
                    ->sendToDatabase($admin);
            }
        }
        if ($order->sale_type === 'online') {
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::make()
                    ->title('¡Nuevo Pedido Online!')
                    ->body("Pedido #{$order->id} de {$order->customer_name} por \${$order->total}.")
                    ->icon('heroicon-o-shopping-cart')
                    ->iconColor('success')
                    ->sendToDatabase($admin);
            }
        }
    }

    // ✅ NUEVO MÉTODO: Se ejecuta cuando el admin edita un pedido
    public function updated(Order $order): void
    {
        // Si el estado cambió y el pedido tiene un cliente registrado
        if ($order->isDirty('status') && $order->user_id) {
            $order->user->notify(new \App\Notifications\OrderStatusUpdated($order, $order->status));
        }
    }
}