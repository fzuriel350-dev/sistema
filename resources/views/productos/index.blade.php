<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - UPTex</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes pulse-subtle {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.85; }
        }
        .animate-pulse-subtle {
            animation: pulse-subtle 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="bg-slate-100 p-4 md:p-10 font-sans">

<div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-sm p-8">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
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
                <p class="text-sm text-gray-500">Bienvenido, <span class="font-bold text-slate-800">{{ auth()->user()->nombre ?? 'Zuriel' }}</span> <span class="bg-sky-500 text-white text-[10px] px-2 py-0.5 rounded font-bold ml-1">ADMIN</span></p>
                <h1 class="text-2xl font-bold text-slate-700 mt-1">Gestión de Productos</h1>
            </div>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="border border-orange-400 text-orange-500 px-6 py-2 rounded-xl text-sm font-bold hover:bg-orange-50 transition">
                Cerrar Sesión
            </button>
        </form>
    </div>

    @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
        <div class="mb-8 space-y-3">
            @foreach(auth()->user()->unreadNotifications as $notification)
                <div class="relative flex items-center justify-between p-4 bg-red-50 border-red-500 border-l-4 rounded-r-xl shadow-sm border animate-pulse-subtle">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-black text-red-800 uppercase tracking-tighter">Alerta de Sistema</p>
                            <p class="text-sm text-gray-700 font-medium">
                                {{ $notification->data['mensaje'] ?? 'Actualización de stock detectada.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="flex flex-wrap gap-3 mb-8 items-center">
        <a href="{{ route('productos.create') }}" class="bg-emerald-500 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-emerald-600 transition flex items-center shadow-md shadow-emerald-100">
            + Nuevo Producto
        </a>

        <a href="{{ route('carrito.index') }}" class="bg-sky-600 text-white px-6 py-2 rounded-xl font-bold text-sm hover:bg-sky-700 transition flex items-center shadow-md shadow-sky-100">
            🛒 Ver Carrito ({{ is_array(session('carrito')) ? count(session('carrito')) : 0 }})
        </a>

        <div class="flex gap-2">
            <a href="{{ route('productos.pdf') }}" class="bg-red-500 text-white px-4 py-2 rounded-xl font-bold text-sm hover:bg-red-600 transition flex items-center shadow-sm">PDF</a>
            <a href="{{ route('productos.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded-xl font-bold text-sm hover:bg-green-700 transition flex items-center shadow-sm">Excel</a>
            
            <form action="{{ route('reportes.csv') }}" method="POST">
                @csrf
                <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-xl font-bold text-sm hover:bg-slate-900 transition flex items-center shadow-sm">
                    CSV (Colas)
                </button>
            </form>
        </div>
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
                        <span class="bg-blue-50 text-blue-600 text-[10px] px-3 py-1 rounded-full font-bold uppercase tracking-tight">
                            {{ $producto->categoria->nombre ?? 'General' }}
                        </span>
                    </td>
                    <td class="p-4 text-center">
                        <span class="{{ $producto->stock <= 5 ? 'text-red-600 font-bold' : 'text-slate-600' }}">
                            {{ $producto->stock }}
                        </span>
                    </td>
                    <td class="p-4 font-bold text-emerald-500 text-center">${{ number_format($producto->precio, 2) }}</td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center items-center gap-3 text-sm">
                            <form action="{{ route('carrito.agregar', $producto->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-emerald-600 font-bold hover:text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg transition">
                                    + Carrito
                                </button>
                            </form>
                            
                            <div class="h-4 w-[1px] bg-gray-200"></div>

                            <a href="{{ route('productos.edit', $producto->id) }}" class="text-sky-500 font-semibold hover:underline">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
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

    <div class="mt-8">
        <div class="flex flex-col items-center">
            <span class="text-sm text-gray-700">
                Mostrando <span class="font-semibold text-slate-900">{{ $productos->firstItem() }}</span> 
                a <span class="font-semibold text-slate-900">{{ $productos->lastItem() }}</span> 
                de <span class="font-semibold text-slate-900">{{ $productos->total() }}</span> productos
            </span>
            <div class="mt-4">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</div>

</body>
</html>