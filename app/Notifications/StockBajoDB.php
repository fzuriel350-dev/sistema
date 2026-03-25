<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StockBajoDB extends Notification
{
    use Queueable;

    protected $producto;

    public function __construct($producto)
    {
        $this->producto = $producto;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'mensaje' => '¡Alerta! Stock bajo en: ' . $this->producto->nombre,
            'stock_actual' => $this->producto->stock,
            'url' => route('productos.edit', $this->producto->id),
            'tipo' => 'alerta_stock'
        ];
    }
}