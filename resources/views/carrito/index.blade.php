@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-sm p-8 mt-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-700">Tu Carrito de Compras</h1>
            <p class="text-sm text-gray-500">Práctica 18 - Gestión de Sesiones</p>
        </div>
        <a href="{{ route('productos.index') }}" class="border border-slate-200 text-slate-600 px-6 py-2 rounded-xl text-sm font-bold hover:bg-slate-50 transition">
            ← Volver a Productos
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-sm rounded-r-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-100">
        <table class="w-full text-left">
            <thead class="bg-slate-700 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="p-4 font-semibold">Producto</th>
                    <th class="p-4 font-semibold text-center">Precio</th>
                    <th class="p-4 font-semibold text-center">Cantidad</th>
                    <th class="p-4 font-semibold text-center">Subtotal</th>
                    <th class="p-4 font-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php $total = 0; @endphp
                @forelse ($carrito as $id => $item)
                    @php 
                        $subtotal = $item['precio'] * $item['cantidad']; 
                        $total += $subtotal;
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-4 font-bold text-slate-700">{{ $item['nombre'] }}</td>
                        <td class="p-4 text-center text-slate-600">${{ number_format($item['precio'], 2) }}</td>
                        <td class="p-4 text-center">
                            <form method="POST" action="{{ route('carrito.actualizar', $id) }}" class="flex items-center justify-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" 
                                    class="w-16 text-center border border-gray-200 rounded-lg p-1 text-sm focus:ring-2 focus:ring-sky-500 outline-none">
                                <button type="submit" class="text-sky-500 hover:text-sky-700 p-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </form>
                        </td>
                        <td class="p-4 text-center font-bold text-emerald-500">${{ number_format($subtotal, 2) }}</td>
                        <td class="p-4 text-center">
                            <form method="POST" action="{{ route('carrito.eliminar', $id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 font-semibold hover:text-red-600 transition">
                                    Quitar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-400 italic">
                            El carrito está vacío. ¡Añade algunos productos!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(count($carrito) > 0)
        <div class="mt-8 flex flex-col items-end gap-4">
            <div class="text-right">
                <p class="text-gray-500 text-sm">Resumen de compra</p>
                <h3 class="text-3xl font-bold text-slate-800">Total: ${{ number_format($total, 2) }}</h3>
            </div>
            
            <div class="flex gap-3">
                <form method="POST" action="{{ route('carrito.vaciar') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-orange-50 text-orange-500 px-6 py-3 rounded-xl font-bold text-sm hover:bg-orange-100 transition">
                        Vaciar Carrito
                    </button>
                </form>

                <button class="bg-emerald-500 text-white px-8 py-3 rounded-xl font-bold text-sm hover:bg-emerald-600 shadow-md shadow-emerald-100 transition">
                    Finalizar Compra
                </button>
            </div>
        </div>
    @endif
</div>
@endsection