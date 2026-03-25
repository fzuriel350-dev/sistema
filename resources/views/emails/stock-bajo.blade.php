<x-mail::message>
# ⚠️ Alerta de Stock Bajo

El producto **{{ $producto->nombre }}** ha alcanzado un nivel crítico de inventario.

<x-mail::panel>
**Detalles del Producto:**
- **Stock Actual:** {{ $producto->stock }} unidades.
- **Precio:** ${{ number_format($producto->precio, 2) }}
- **Categoría:** {{ $producto->categoria->nombre ?? 'General' }}
</x-mail::panel>

Es necesario reabastecer este artículo lo antes posible para evitar falta de disponibilidad.

<x-mail::button :url="route('productos.edit', $producto->id)">
Ver Producto en el Sistema
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>