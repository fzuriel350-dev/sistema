<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Práctica 11</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.85; }
        }
        .animate-pulse-subtle {
            animation: pulse-subtle 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        /* Animación para la etiqueta NUEVA */
        @keyframes mini-bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-2px); }
        }
        .animate-mini-bounce {
            animation: mini-bounce 1s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-100 p-4 md:p-10 font-sans">

<div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-sm p-8">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <!-- Icono de Campana con Contador Dinámico -->
            <div class="relative p-2 bg-slate-50 rounded-full border border-slate-200">
                <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-0 right-0 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white ring-2 ring-white">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </div>

            <div>
                <p class="text-sm text-gray-500">Bienvenido, <span class="font-bold text-slate-800">{{ auth()->user()->name ?? 'Usuario' }}</span> <span class="bg-sky-500 text-white text-[10px] px-2 py-0.5 rounded font-bold ml-1">ADMIN</span></p>
                <h1 class="text-2xl font-bold text-slate-700 mt-1">Gestión de Productos (Práctica 11)</h1>
            </div>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="border border-orange-400 text-orange-500 px-6 py-2 rounded-xl text-sm font-bold hover:bg-orange-50 transition">
                Cerrar Sesión
            </button>
        </form>
    </div>

    <!-- SECCIÓN DE ALERTAS DE NOTIFICACIÓN (Stock Bajo) -->
    @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
        <div class="mb-8 space-y-3">
            @foreach(auth()->user()->unreadNotifications as $notification)
                @php
                    // Lógica para determinar si es "Nueva" (menos de 10 minutos)
                    $esNueva = $notification->created_at->diffInMinutes() < 10;
                @endphp
                <div class="relative flex items-center justify-between p-4 {{ $esNueva ? 'bg-red-50 border-red-500' : 'bg-white border-gray-200' }} border-l-4 rounded-r-xl shadow-sm transition-all {{ $esNueva ? 'animate-pulse-subtle' : '' }} border">
                    
                    <div class="flex items-center">
                        <div class="bg-red-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <p class="text-xs font-black text-red-800 uppercase tracking-tighter">Alerta de Stock Crítico</p>
                                
                                {{-- ETIQUETA NUEVA --}}
                                @if($esNueva)
                                    <span class="bg-red-600 text-white text-[9px] px-1.5 py-0.5 rounded font-black animate-mini-bounce shadow-sm">
                                        NUEVA
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-700 font-medium">
                                {{ $notification->data['mensaje'] ?? 'Un producto requiere tu atención.' }} 
                                <span class="text-red-600 font-bold underline">{{ $notification->data['nombre_producto'] ?? '' }}</span>
                            </p>
                            <p class="text-[10px] text-gray-400 italic">
                                Hace {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('notificaciones.leer', $notification->id) }}" class="text-[10px] bg-slate-800 hover:bg-black text-white px-4 py-2 rounded-lg font-bold transition uppercase shadow-sm">
                        Entendido
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <div class="flex flex-wrap gap-3 mb-8">
        <a href="{{ route('productos.create') }}" class="bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-emerald-600 transition flex items-center shadow-md shadow-emerald-100">
            + Nuevo Producto
        </a>

        <div class="flex gap-2">
            <a href="{{ route('productos.pdf') }}" class="bg-red-500 text-white px-4 py-2 rounded-xl font-bold text-sm hover:bg-red-600 transition flex items-center shadow-sm">
                PDF
            </a>
            <a href="{{ route('productos.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded-xl font-bold text-sm hover:bg-green-700 transition flex items-center shadow-sm">
                Excel
            </a>
        </div>

        <form action="{{ route('productos.index') }}" method="GET" class="flex-1 min-w-[300px] flex gap-2">
            <input type="text" name="buscar" placeholder="Buscar por nombre..." value="{{ request('buscar') }}" class="flex-1 border border-gray-200 rounded-xl px-4 py-2 bg-gray-50 outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-sky-500 text-white px-8 py-2 rounded-xl font-bold text-sm hover:bg-sky-600 transition">Buscar</button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-sm rounded-r-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-100">
        <table class="w-full text-left">
            <thead class="bg-slate-700 text-white text-xs uppercase tracking-wider">
                <tr>
                    <th class="p-4 font-semibold">ID</th>
                    <th class="p-4 font-semibold">Imagen</th>
                    <th class="p-4 font-semibold">Producto</th>
                    <th class="p-4 font-semibold">Categoría</th>
                    <th class="p-4 font-semibold text-center">Stock</th>
                    <th class="p-4 font-semibold text-center">Precio</th>
                    <th class="p-4 font-semibold text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($productos as $producto)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 text-gray-400 text-sm">{{ $producto->id }}</td>
                    <td class="p-4">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-[10px] text-gray-400 font-bold">N/A</div>
                        @endif
                    </td>
                    <td class="p-4 font-bold text-slate-700">{{ $producto->nombre }}</td>
                    <td class="p-4">
                        <span class="bg-gray-100 text-gray-500 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-tight">
                            {{ $producto->categoria->nombre ?? 'Sin Categoría' }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="{{ $producto->stock <= 5 ? 'text-red-600 font-bold' : 'text-slate-600' }}">
                            {{ $producto->stock }}
                        </span>
                    </td>
                    <td class="p-4 font-bold text-emerald-500 text-center">${{ number_format($producto->precio, 2) }}</td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center gap-4 text-sm">
                            <a href="{{ route('productos.edit', $producto->id) }}" class="text-sky-500 font-semibold hover:underline">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirm('¿Eliminar producto?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-orange-400 font-semibold hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-8 text-center text-gray-400 text-xs italic">
        Mostrando del <b>{{ $productos->firstItem() }}</b> al <b>{{ $productos->lastItem() }}</b> de <b>{{ $productos->total() }}</b> productos.
        <div class="mt-4 text-left">
            {{ $productos->links() }}
        </div>
    </div>

</div>

</body>
</html>