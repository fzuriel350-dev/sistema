<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Marca una notificación como leída y redirige atrás.
     */
    public function leer($id)
    {
        // Buscamos la notificación en las no leídas del usuario
        $notificacion = Auth::user()->unreadNotifications->where('id', $id)->first();

        if ($notificacion) {
            $notificacion->markAsRead();
        }

        return redirect()->back()->with('status', 'Notificación marcada como leída.');
    }

    /**
     * Opcional: Marcar todas como leídas
     */
    public function leerTodas()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}