<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController; 
use App\Http\Controllers\UsuarioController; 

/**
 * 1. INICIO Y LOGIN
 */
Route::get('/', function () { 
    return redirect()->route('login'); 
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/**
 * 2. RUTA DE DIAGNÓSTICO DE CORREO
 */
Route::get('/test-mail', function () {
    try {
        Mail::raw('Hola, esta es una prueba de Mailtrap desde Uptex', function ($message) {
            $message->to('prueba@ejemplo.com')
                    ->subject('Prueba de Conexión Mailtrap');
        });
        return "¡Correo enviado con éxito! Revisa tu bandeja de entrada en Mailtrap.";
    } catch (\Exception $e) {
        return "Error detallado al enviar: " . $e->getMessage();
    }
});

/**
 * 3. RUTAS PROTEGIDAS POR AUTENTICACIÓN
 */
Route::middleware(['auth'])->group(function () {
    
    // Lista de productos
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

    /**
     * PRÁCTICA 12: RUTAS DE NOTIFICACIONES
     */
    // Corregido: Se quitó el @if de Blade que causaba error
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notificaciones/{id}/leer', [NotificationController::class, 'leer'])->name('notificaciones.leer');

    /**
     * PRÁCTICA 11: RUTAS DE EXPORTACIÓN (PDF Y EXCEL)
     */
    Route::get('/productos/descargar-pdf', [ProductoController::class, 'exportPdf'])->name('productos.pdf');
    Route::get('/productos/descargar-excel', [ProductoController::class, 'exportExcel'])->name('productos.excel');

    /**
     * 4. RUTAS SOLO PARA ADMIN (PRÁCTICA 6)
     */
    Route::middleware(['checkRol:admin'])->group(function () {
        Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
        Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
        
        Route::get('/productos/{id}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
        Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    });
});

/**
 * NUEVA PRÁCTICA: CRUD DE USUARIOS (Paso 7 de la Guía)
 */
Route::resource('usuarios', UsuarioController::class);