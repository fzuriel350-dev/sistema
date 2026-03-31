<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-2xl font-bold mb-4">Buscador de Productos (Livewire)</h2>
    
    <input wire:model.live="busqueda" type="text" 
           placeholder="Escribe el nombre de un producto..." 
           class="w-full p-2 border rounded shadow-sm focus:ring focus:ring-indigo-200">

    <div class="mt-6">
        @if($busqueda)
            <p class="text-gray-600 mb-2">Resultados para: <strong>{{ $busqueda }}</strong></p>
        @endif

        <ul class="divide-y divide-gray-100">
            @foreach($productos as $p)
                <li class="py-3 flex justify-between items-center">
                    <span class="font-medium text-gray-900">{{ $p->nombre }}</span>
                    <span class="text-green-600 font-bold">${{ number_format($p->precio, 2) }}</span>
                </li>
            @endforeach
        </ul>

        @if($productos->isEmpty() && $busqueda)
            <div class="bg-yellow-50 p-4 rounded text-yellow-700">
                No se encontraron productos que coincidan con "{{ $busqueda }}".
            </div>
        @endif
    </div>
</div>