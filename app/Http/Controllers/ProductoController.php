<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

// Importaciones para la Práctica 11 (Reportes)
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

// Importaciones para la Práctica 12 (Notificaciones)
use App\Notifications\ProductoCreado;
use App\Notifications\StockBajoDB; // <--- ASEGÚRATE DE TENER ESTA LÍNEA

class ProductoController extends Controller
{
    /**
     * Muestra la tabla principal con paginación y carga las notificaciones
     */
    public function index()
    {
        $productos = Producto::with('categoria')->paginate(10);

        // PRÁCTICA 12: Obtener las notificaciones del usuario autenticado
        $notificaciones = [];
        if (Auth::check()) {
            // Usamos unreadNotifications para ver solo las nuevas. 
            // Si quieres ver todas (leídas y no leídas), cambia a: Auth::user()->notifications
            $notificaciones = Auth::user()->unreadNotifications;
        }

        return view('productos.index', compact('productos', 'notificaciones'));
    }

    /**
     * Muestra el formulario para crear un producto nuevo
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Guarda el producto nuevo con imagen y dispara notificación
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'categoria_id' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image'
        ]);

        $path = $request->hasFile('imagen') ? $request->file('imagen')->store('productos', 'public') : null;

        // Creamos el producto
        $producto = Producto::create(array_merge($request->all(), ['imagen' => $path]));

        // PRÁCTICA 12: Enviar notificación al usuario autenticado (Creación)
        if (Auth::check()) {
            Auth::user()->notify(new ProductoCreado($producto));
        }

        return redirect()->route('productos.index')->with('success', 'Producto creado y notificación enviada');
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Procesa la actualización, maneja imágenes y alerta de Mailtrap + Base de Datos
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $stockAnterior = $producto->stock;

        // Validación básica
        $request->validate([
            'stock' => 'required|integer',
            // ... otras validaciones si son necesarias
        ]);

        // Manejo de nueva imagen si se sube una
        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $path = $request->file('imagen')->store('productos', 'public');
            $producto->imagen = $path;
        }

        $producto->update($request->except('imagen'));

        // --- LÓGICA DE NOTIFICACIONES ---

        // 1. Alerta de Mailtrap (Cuando llega a 0)
        if ($producto->stock <= 0 && $stockAnterior > 0) {
            try {
                Mail::raw("Alerta Uptex: Stock agotado para {$producto->nombre}.", function ($message) {
                    $message->to('admin@uptex.edu.mx')->subject('Stock Agotado');
                });
            } catch (\Exception $e) {
                \Log::error("Error Mailtrap: " . $e->getMessage());
            }
        }

        // 2. PRÁCTICA 12: Notificación de Base de Datos (Cuando el stock es bajo, ej. menos de 5)
        // Agregamos esta lógica que faltaba en tu código
        if ($producto->stock <= 5) {
            if (Auth::check()) {
                Auth::user()->notify(new StockBajoDB($producto));
            }
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    /**
     * Elimina el producto y su imagen asociada
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado');
    }

    public function exportPdf()
    {
        $productos = Producto::with('categoria')->get();
        $pdf = Pdf::loadView('reportes.productos-pdf', compact('productos'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->download('Reporte_Productos_' . date('d_m_Y') . '.pdf');
    }

    /**
     * Genera y descarga el reporte en formato Excel
     */
    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'Reporte_Productos_' . date('d_m_Y') . '.xlsx');
    }
}