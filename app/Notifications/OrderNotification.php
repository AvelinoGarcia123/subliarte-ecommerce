<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderNotification extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database']; // ✅ Se guarda en la base de datos
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => '¡Nuevo Pedido Online!',
            'body' => "Pedido #{$this->order->id} de {$this->order->customer_name} por \${$this->order->total}.",
            'icon' => 'heroicon-o-shopping-cart',
            'iconColor' => 'success',
            'actions' => [
                [
                    'name' => 'ver_pedido',
                    'label' => 'Ver Pedido',
                    'url' => \App\Filament\Resources\OrderResource::getUrl('edit', ['record' => $this->order->id]),
                    'isButton' => true,
                ]
            ],
        ];
    }
}
