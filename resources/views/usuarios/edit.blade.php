@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0">Editar Usuario</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
            @csrf
            @method('PUT') {{-- Esto es vital para que Laravel sepa que es una actualización --}}
            
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-edit"></i> Actualizar Usuario
            </button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection