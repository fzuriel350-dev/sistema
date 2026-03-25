<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Producto;

class ProductoCreado extends Notification
{
    use Queueable;

    protected $producto;

    public function __construct(Producto $producto)
    {
        $this->producto = $producto;
    }

    public function via($notifiable)
    {
        return ['database'];
    }
    public function toArray($notifiable)
    {
        return [
            'mensaje' => 'Se ha creado un nuevo producto: ' . $this->producto->nombre,
            'producto_id' => $this->producto->id,
            'precio' => $this->producto->precio,
            'autor' => auth()->user()->name ?? 'Sistema',
            'tipo' => 'NUEVO'
        ];
    }
}