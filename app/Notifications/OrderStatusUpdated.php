<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    public $order;
    public $status;

    public function __construct(Order $order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        // Traducimos el estado a un mensaje amigable
        $statusMessages = [
            'pagado' => '¡Tu pago ha sido validado!',
            'en_produccion' => '¡Tu pedido ya está en producción (diseñando)!',
            'entregado' => '¡Tu pedido ha sido entregado!',
            'cancelado' => 'Tu pedido ha sido cancelado.',
        ];

        $body = $statusMessages[$this->status] ?? "El estado de tu pedido cambió a: {$this->status}";

        return [
            'title' => "Actualización de Pedido #{$this->order->id}",
            'body' => $body,
            'icon' => 'heroicon-o-truck',
            'iconColor' => 'info',
        ];
    }
}