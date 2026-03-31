<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Producto;
use Illuminate\View\View;

class BuscadorProductos extends Component
{
    /**
     * Propiedad reactiva que se vincula con el input de la vista
     * mediante wire:model.live
     */
    public string $busqueda = '';

    /**
     * Renderiza la vista del componente y ejecuta la búsqueda
     */
    public function render(): View 
    {
        // Consulta para filtrar productos por nombre según lo que escribas
        $productos = Producto::where('nombre', 'LIKE', '%' . $this->busqueda . '%')
            ->limit(10)
            ->get();

        /**
         * SOLUCIÓN DEFINITIVA: 
         * Como tu archivo está en la carpeta 'components' (según tu captura),
         * usamos 'components.buscador-productos' para que lo encuentre.
         */
     return view('livewire.buscador-productos', compact('productos'));
    }
}