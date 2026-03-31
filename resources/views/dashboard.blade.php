<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Control - UPTex') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Corrección: Cambiado max-row-7xl por max-w-7xl --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-[#00602F]">
                <div class="p-8 text-center">
                    {{-- Logo institucional --}}
                    <img src="{{ asset('img/logo-uptex.jpeg') }}" alt="Logo UPTex" class="mx-auto h-32 w-auto mb-6">
                    
                    <h1 class="text-4xl font-bold text-[#00602F] mb-2">
                        ¡BIENVENIDO A SISTEMAS WEB!
                    </h1>
                    
                    <p class="text-2xl text-gray-700">
                        Usuario: <span class="font-extrabold text-[#C71C41]">{{ Auth::user()->nombre }}</span>
                    </p>

                    {{-- Contenedor del Buscador en tiempo real --}}
                    <div class="mt-8 max-w-2xl mx-auto text-left">
                        <livewire:buscador-productos />
                    </div>

                    {{-- Cuadro de estatus de la práctica --}}
                    <div class="mt-8 p-6 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                        <p class="text-lg text-gray-600 italic">
                            "Práctica 19: Buscador en tiempo real con Livewire finalizado con éxito."
                        </p>
                    </div>

                    {{-- Botón de navegación --}}
                    <div class="mt-10">
                        <a href="{{ route('productos.index') }}" class="inline-flex items-center px-6 py-3 bg-[#00602F] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#004d26] focus:bg-[#004d26] active:bg-[#003d1e] transition ease-in-out duration-150">
                            Ir a Gestión de Productos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>