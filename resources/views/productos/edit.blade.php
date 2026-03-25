<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Producto - Práctica 8</title>
<!-- Se utiliza Tailwind CSS para un diseño rápido y moderno -->
<script src="https://www.google.com/search?q=https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

<div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
    <div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Editar Producto
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Modifica la información necesaria del formulario
        </p>
    </div>

    <!-- El action usa la ruta update y enviamos el ID del producto -->
    <form class="mt-8 space-y-6" action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
        <!-- Token de seguridad y método PUT (obligatorios en Laravel para updates) -->
        @csrf
        @method('PUT')

        <div class="rounded-md shadow-sm space-y-4">
            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Producto</label>
                <input id="nombre" name="nombre" type="text" required 
                    value="{{ old('nombre', $producto->nombre) }}"
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Categoría -->
            <div>
                <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select id="categoria_id" name="categoria_id" required
                    class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Precio -->
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                    <input id="precio" name="precio" type="number" step="0.01" required 
                        value="{{ old('precio', $producto->precio) }}"
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <!-- Stock -->
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input id="stock" name="stock" type="number" required 
                        value="{{ old('stock', $producto->stock) }}"
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <!-- Imagen -->
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Imagen del Producto</label>
                
                @if($producto->imagen)
                    <div class="mb-3 p-2 bg-gray-50 border border-dashed border-gray-300 rounded-lg flex flex-col items-center">
                        <span class="text-xs text-gray-400 mb-1">Imagen Actual:</span>
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Actual" class="h-24 w-auto rounded shadow-sm">
                    </div>
                @endif

                <input type="file" name="imagen" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-gray-400 italic">Solo sube un archivo si deseas cambiar la imagen actual.</p>
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 mt-6">
            <a href="{{ route('productos.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                ← Volver
            </a>
            <button type="submit" 
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Actualizar Cambios
            </button>
        </div>
    </form>
</div>


</body>
</html>