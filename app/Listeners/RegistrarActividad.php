<?php

namespace App\Listeners;

use App\Events\ProductoGuardado;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegistrarActividad
{
    public function handle(ProductoGuardado $event): void
    {
        // Buscamos un ID de usuario válido para evitar el error 1452
        $userId = $event->usuario->id 
                  ?? Auth::id() 
                  ?? User::where('rol', 'admin')->first()?->id 
                  ?? User::first()?->id;

        // Si no hay ningún usuario en la base de datos, no podemos guardar el log
        if (!$userId) {
            return;
        }

        ActivityLog::create([
            'user_id'         => $userId,
            'accion'          => $event->accion,
            'producto_nombre' => $event->producto->nombre,
            'descripcion'     => "El producto {$event->producto->nombre} fue {$event->accion} por el sistema.",
        ]);
    }
}