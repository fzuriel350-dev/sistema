<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    // Muestra la vista del carrito
    public function index() {
        $carrito = session()->get('carrito', []);
        return view('carrito.index', compact('carrito'));
    }

    // Agregar producto al carrito [cite: 41-57]
    public function agregar(Request $request, Producto $producto) {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad']++;
        } else {
            $carrito[$producto->id] = [
                'producto_id' => $producto->id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1
            ];
        }

        session()->put('carrito', $carrito);
        return back()->with('success', 'Producto agregado al carrito.');
    }

    // Actualizar cantidad [cite: 66-70]
    public function actualizar(Request $request, $id) {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id])) {
            $carrito[$id]['cantidad'] = max(1, (int) $request->cantidad);
            session()->put('carrito', $carrito);
        }
        return back();
    }

    // Eliminar un producto [cite: 71-75]
    public function eliminar($id) {
        $carrito = session()->get('carrito', []);
        unset($carrito[$id]);
        session()->put('carrito', $carrito);
        return back()->with('success', 'Producto eliminado.');
    }

    // Vaciar todo el carrito [cite: 76-82]
    public function vaciar() {
        session()->forget('carrito');
        return redirect()->route('carrito.index');
    }
}