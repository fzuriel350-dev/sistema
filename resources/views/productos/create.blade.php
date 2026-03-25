@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Nuevo Producto</h1>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- IMPORTANTE: Se agregó enctype="multipart/form-data" para permitir subir la imagen --}}
    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Nombre del Producto:</label><br>
            <input type="text" name="nombre" value="{{ old('nombre') }}" style="width: 100%; padding: 8px;">
            @error('nombre')
                <span style="color:red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Categoría:</label><br>
            <select name="categoria_id" style="width: 100%; padding: 8px;">
                <option value="">-- Selecciona una categoría --</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <span style="color:red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Precio:</label><br>
            <input type="number" name="precio" step="0.01" value="{{ old('precio') }}" style="width: 100%; padding: 8px;">
            @error('precio')
                <span style="color:red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Stock:</label><br>
            <input type="number" name="stock" value="{{ old('stock') }}" style="width: 100%; padding: 8px;">
            @error('stock')
                <span style="color:red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group" style="margin-bottom: 15px;">
            <label>Descripción:</label><br>
            <textarea name="descripcion" style="width: 100%; padding: 8px; height: 100px;">{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <span style="color:red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        {{-- NUEVO CAMPO: Imagen del Producto (Requisito Práctica 8) --}}
        <div class="form-group" style="margin-bottom: 20px;">
            <label>Imagen del Producto:</label><br>
            <input type="file" name="imagen" accept="image/*" style="width: 100%; padding: 8px; border: 1px dashed #ccc;">
            <small style="color: #666;">Formatos: jpg, png, jpeg. Máx: 2MB.</small>
            @error('imagen')
                <br><span style="color:red; font-size: 0.8em;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" style="background-color: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
            Guardar Producto
        </button>
        <a href="{{ route('productos.index') }}" style="margin-left: 10px; color: #666; text-decoration: none;">Cancelar</a>
    </form>
</div>
@endsection