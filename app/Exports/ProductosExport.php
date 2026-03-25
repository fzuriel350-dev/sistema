<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Traemos todos los productos con su categoría para evitar errores
        return Producto::with('categoria')->get();
    }

    /**
     * Definimos los encabezados de las columnas en el Excel
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre del Producto',
            'Categoría',
            'Precio',
            'Stock',
            'Fecha de Registro',
        ];
    }

    /**
     * Mapeamos los datos para que cada columna tenga lo que queremos
     * @param mixed $producto
     */
    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->nombre,
            $producto->categoria ? $producto->categoria->nombre : 'Sin Categoría',
            '$' . number_format($producto->precio, 2),
            $producto->stock,
            $producto->created_at->format('d/m/Y'),
        ];
    }
}