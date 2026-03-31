<?php

namespace App\Events;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductoGuardado
{
    use Dispatchable, SerializesModels;

    public $producto;
    public $accion;
    public $usuario;

    public function __construct(Producto $producto, $accion, User $usuario = null)
    {
        $this->producto = $producto;
        $this->accion = $accion;
        $this->usuario = $usuario ?? auth()->user();
    }
}