<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Muestra el listado de usuarios.
     */
    public function index()
    {
        $usuarios = Usuario::all(); // Recupera todos los registros [cite: 84]
        return view('usuarios.index', compact('usuarios')); // Carga la vista de lista [cite: 85]
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('usuarios.create'); // Carga el formulario de creación [cite: 87]
    }

    /**
     * Almacena un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Validamos que los datos cumplan con lo requerido en la práctica [cite: 90]
        $request->validate([
            'nombre' => 'required|string|max:255', // [cite: 92]
            'email' => 'required|email|unique:usuarios,email', // [cite: 93]
        ]);

        Usuario::create($request->all()); // Crea el registro [cite: 94]

        return redirect()->route('usuarios.index') // Redirige al listado [cite: 95]
            ->with('success', '¡Usuario creado correctamente!'); // Mensaje de éxito [cite: 96]
    }

    /**
     * Muestra los detalles de un usuario específico.
     */
    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario')); // Carga la vista de detalle [cite: 98]
    }

    /**
     * Muestra el formulario para editar un usuario.
     */
    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario')); // Carga el formulario de edición [cite: 101]
    }

    /**
     * Actualiza los datos del usuario en la base de datos.
     */
    public function update(Request $request, Usuario $usuario)
    {
        // Validamos asegurando que el email sea único, excepto para el usuario actual [cite: 104, 108]
        $request->validate([
            'nombre' => 'required|string|max:255', // [cite: 105]
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id, // [cite: 108]
        ]);

        $usuario->update($request->all()); // Actualiza los datos [cite: 108]

        return redirect()->route('usuarios.index') // [cite: 109]
            ->with('success', '¡Usuario actualizado correctamente!'); // [cite: 110]
    }

    /**
     * Elimina un usuario de la base de datos.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete(); // Elimina el registro [cite: 112]

        return redirect()->route('usuarios.index') // [cite: 113]
            ->with('success', 'Usuario eliminado correctamente!'); // [cite: 114]
    }
}