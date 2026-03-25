<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    /**
     * Transformar el recurso en un array para la respuesta JSON.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'nombre'      => $this->nombre,
            'precio'      => $this->precio,
            'stock'       => $this->stock,
            'descripcion' => $this->descripcion,
            'url_imagen'  => $this->url_imagen,
            'creado_el'   => $this->created_at ? $this->created_at->format('d/m/Y') : null,
        ];
    }
}