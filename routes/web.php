<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController; 
use App\Http\Controllers\CarritoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirección inicial al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Ruta del dashboard (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Cierre de sesión manual para depuración
Route::get('/force-logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

// Rutas protegidas por autenticación 
Route::middleware('auth')->group(function () {
    
    // --- PRÁCTICA 15: HISTORIAL DE ACTIVIDAD ---
    Route::get('/historial', function () {
        $logs = ActivityLog::with('user')->latest()->paginate(15);
        return view('logs.index', compact('logs'));
    })->name('logs.index');

    // --- REPORTES Y EXPORTACIÓN (Prácticas 11 y 16) ---
    Route::get('productos/exportar/pdf', [ProductoController::class, 'exportPdf'])->name('productos.pdf');
    Route::get('productos/exportar/excel', [ProductoController::class, 'exportExcel'])->name('productos.excel');
    Route::post('/reportes/csv', [ProductoController::class, 'exportarCsv'])->name('reportes.csv'); 

    // --- PRÁCTICA 18: CARRITO DE COMPRAS CON SESSION --- [cite: 120]
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index'); // [cite: 124]
    Route::post('/carrito/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar'); // [cite: 127]
    Route::patch('/carrito/{id}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar'); // [cite: 129]
    Route::delete('/carrito/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar'); // [cite: 130]
    Route::delete('/carrito', [CarritoController::class, 'vaciar'])->name('carrito.vaciar'); // 

    // --- PRÁCTICA 19: LIVEWIRE (Componentes Dinámicos) --- [cite: 160]
    // Generalmente Livewire no requiere rutas adicionales si los componentes 
    // se embeben en vistas existentes, pero puedes crear una página dedicada:
    Route::get('/interactivo', function () {
        return view('interactivo.index'); 
    })->name('livewire.index');

    // Rutas del Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Productos
    Route::resource('productos', ProductoController::class);
});

require __DIR__.'/auth.php';