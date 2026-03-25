@extends('layouts.app')

@section('content')

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-9">
<div class="card border-0 shadow-sm">
<!-- Encabezado de la Tarjeta -->
<div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
<h5 class="mb-0 fw-bold text-primary">
<i class="bi bi-bell-fill me-2"></i> Centro de Notificaciones
</h5>
<span class="badge bg-primary rounded-pill">
{{ $notifications->count() }} Mensajes
</span>
</div>

            <!-- Lista de Notificaciones -->
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse ($notifications as $notification)
                        @php
                            $data = $notification->data;
                            $isUnread = $notification->unread();
                        @endphp

                        <div class="list-group-item list-group-item-action border-start-4 {{ $isUnread ? 'bg-light border-primary' : 'border-transparent' }} py-3">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <!-- Icono según el tipo de mensaje -->
                                    <div class="rounded-circle bg-opacity-10 p-3 me-3 {{ $isUnread ? 'bg-primary text-primary' : 'bg-secondary text-secondary' }}">
                                        <i class="bi {{ $isUnread ? 'bi-envelope-fill' : 'bi-envelope-open' }}"></i>
                                    </div>
                                    
                                    <div>
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-1 fw-bold {{ $isUnread ? 'text-dark' : 'text-muted' }}">
                                                {{ $data['mensaje'] ?? 'Actualización del sistema' }}
                                            </h6>
                                            @if($isUnread)
                                                <span class="badge bg-danger ms-2 px-2 shadow-sm" style="font-size: 0.65rem;">NUEVA</span>
                                            @endif
                                        </div>
                                        <p class="mb-1 text-muted small">
                                            Producto ID: <span class="badge bg-secondary">{{ $data['producto_id'] ?? 'N/A' }}</span>
                                        </p>
                                        <small class="text-muted">
                                            <i class="bi bi-clock-history me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>

                                @if(isset($data['color']))
                                    <div class="text-end d-none d-sm-block">
                                        <span class="badge bg-{{ $data['color'] }} text-uppercase px-3">
                                            Prioridad {{ $data['color'] == 'danger' ? 'Alta' : 'Normal' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-chat-left-dots text-muted display-1"></i>
                            <p class="mt-3 fs-5 text-muted">No tienes notificaciones en este momento.</p>
                            <a href="{{ url('/home') }}" class="btn btn-primary mt-2">Volver al inicio</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Paginación si existe -->
            @if($notifications instanceof \Illuminate\Pagination\LengthAwarePaginator && $notifications->hasPages())
                <div class="card-footer bg-white py-3">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>

        <p class="text-center mt-4 text-muted small">
            <i class="bi bi-info-circle me-1"></i> 
            Las notificaciones se marcan como leídas automáticamente al entrar a esta sección.
        </p>
    </div>
</div>


</div>

<style>
/* Estilos personalizados para cumplir con la distinción visual /
.border-start-4 {
border-left: 4px solid transparent !important;
}
.border-primary {
border-left-color: #0d6efd !important; / Azul de Bootstrap */
}
.list-group-item {
transition: background-color 0.3s ease;
}
.list-group-item:hover {
background-color: #f1f4f9;
}
.bg-light {
background-color: #f8f9fa !important;
}
</style>

@endsection