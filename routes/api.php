<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Importamos el controlador que maneja la lógica de la API
use App\Http\Controllers\Api\ProductoApiController;

/*
|--------------------------------------------------------------------------
| API Routes - Práctica 9
|--------------------------------------------------------------------------
|
| Aquí registramos las rutas para la API de tu aplicación. 
| Laravel añade automáticamente el prefijo "/api" a estas rutas.
| Ejemplo: http://127.0.0.1:8000/api/productos
|
*/

/**
 * Route::apiResource crea automáticamente las siguientes rutas:
 * GET    /api/productos          -> index()   (Listar todos)
 * POST   /api/productos          -> store()   (Crear uno nuevo)
 * GET    /api/productos/{id}     -> show()    (Ver detalle de uno)
 * PUT    /api/productos/{id}     -> update()  (Actualizar uno)
 * DELETE /api/productos/{id}     -> destroy() (Eliminar uno)
 */
Route::apiResource('productos', ProductoApiController::class);

// Ruta adicional para obtener los datos del usuario autenticado (opcional)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');