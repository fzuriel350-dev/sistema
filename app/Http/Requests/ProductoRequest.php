<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }

    /**
     * Personalizar los mensajes de error.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del producto es obligatorio.',
            'precio.required' => 'Debes ingresar un precio.',
            'precio.numeric'  => 'El precio debe ser un número válido.',
            'stock.required'  => 'El stock no puede estar vacío.',
            'stock.integer'   => 'El stock debe ser un número entero.',
            
            // Mensajes para la Categoría (Práctica 5)
            'categoria_id.required' => 'Por favor, selecciona una categoría.',
            'categoria_id.exists'   => 'La categoría seleccionada no es válida.',
        ];
    }
}