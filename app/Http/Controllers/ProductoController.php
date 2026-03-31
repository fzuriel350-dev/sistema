<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Evento para la Auditoría (Práctica 15)
use App\Events\ProductoGuardado;

// Herramientas para Reportes (Práctica 11)
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

// Job para Colas (Práctica 16)
use App\Jobs\GenerarReporteCsv;

// Notificaciones
use App\Notifications\ProductoCreado;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos con paginación.
     */
    public function index()
    {
        $productos = Producto::with('categoria')->paginate(10);
        $notificaciones = Auth::check() ? Auth::user()->unreadNotifications : []; 

        return view('productos.index', compact('productos', 'notificaciones'));
    }

    /**
     * Formulario para crear un nuevo producto.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    /**
     * Guarda el producto y dispara el log de creación.
     */
    public function store(Request $request)
    {
        // --- CORRECCIÓN PRÁCTICA 17: AUTORIZACIÓN ---
        // Se coloca al inicio para responder con 403 antes de validar datos
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No tienes permisos para crear productos.');
        }

        // Validación de campos requeridos
        $request->validate([
            'nombre' => 'required|unique:productos,nombre',
            'categoria_id' => 'required|exists:categorias,id',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $path = $request->hasFile('imagen') 
            ? $request->file('imagen')->store('productos', 'public') 
            : null;

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'categoria_id' => $request->categoria_id,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'descripcion' => $request->descripcion,
            'imagen' => $path
        ]);

        // Registro de Auditoría (P15)
        event(new ProductoGuardado($producto, 'creado', Auth::user()));

        // Notificación al usuario
        Auth::user()->notify(new ProductoCreado($producto));

        // Redirección explícita al index para evitar el error de URL
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Actualiza el producto y registra el cambio en el historial.
     */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $stockAnterior = $producto->stock;

        $request->validate([
            'nombre' => 'required|unique:productos,nombre,'.$id,
            'categoria_id' => 'required|exists:categorias,id',
            'stock' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048'
        ]);

        $datos = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($datos);

        event(new ProductoGuardado($producto, 'actualizado', Auth::user()));

        // Alerta de Stock Agotado
        if ($producto->stock <= 0 && $stockAnterior > 0) {
            try {
                Mail::raw("Alerta: Stock agotado para {$producto->nombre}.", function ($message) {
                    $message->to('admin@uptex.edu.mx')->subject('Stock Agotado');
                });
            } catch (\Exception $e) {
                Log::error("Error en envío de correo: " . $e->getMessage());
            }
        }

        return redirect()->route('productos.index')->with('success', 'Cambios guardados correctamente.');
    }

    /**
     * Elimina el producto.
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        event(new ProductoGuardado($producto, 'eliminado', Auth::user()));

        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }

    /**
     * Exportación a PDF (Práctica 11).
     */
    public function exportPdf()
    {
        $productos = Producto::with('categoria')->get();
        $pdf = Pdf::loadView('reportes.productos-pdf', compact('productos'));
        return $pdf->download('Reporte_Productos.pdf');
    }

    /**
     * Exportación a Excel (Práctica 11).
     */
    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'Reporte_Productos.xlsx');
    }

    /**
     * PRÁCTICA 16: Generación de Reporte CSV mediante Jobs y Colas.
     */
    public function exportarCsv(Request $request)
    {
        $filtro = $request->input('search', '');
        GenerarReporteCsv::dispatch(auth()->user(), $filtro)->onQueue('reportes');
        return back()->with('success', 'El reporte se está generando en segundo plano.');
    }
}