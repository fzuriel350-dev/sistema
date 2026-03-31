<?php

use Livewire\Component;
use App\Models\Producto;
use Illuminate\View\View;

new class extends Component
{
    /**
     * Propiedad reactiva vinculada al input mediante wire:model.live
     */
    public string $busqueda = '';

    /**
     * Ejecuta la lógica de búsqueda y retorna los datos a la vista
     */
    public function with(): array
    {
        return [
            'productos' => Producto::where('nombre', 'LIKE', '%' . $this->busqueda . '%')
                ->limit(10)
                ->get(),
        ];
    }
};
?>

<div class="p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Buscador de Productos (Livewire)</h2>
    
    <input 
        wire:model.live="busqueda" 
        type="text" 
        placeholder="Escribe para buscar..." 
        class="w-full p-2 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500 focus:outline-none"
    />

    <div class="mt-4">
        @if($busqueda)
            <p class="text-sm text-gray-500 mb-2">Mostrando resultados para: <strong>{{ $busqueda }}</strong></p>
        @endif

        <ul class="space-y-2">
            @foreach($productos as $producto)
                <li class="p-2 hover:bg-gray-50 border-b border-gray-100 flex justify-between">
                    <span>{{ $producto->nombre }}</span>
                    <span class="font-semibold text-green-600">${{ number_format($producto->precio, 2) }}</span>
                </li>
            @endforeach
        </ul>

        @if($productos->isEmpty() && $busqueda)
            <p class="text-red-500 mt-2">No se encontraron productos.</p>
        @endif
    </div>
</div>