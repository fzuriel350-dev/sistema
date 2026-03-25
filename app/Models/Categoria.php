<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Esto permite guardar cualquier dato desde Tinker o formularios
    protected $guarded = [];

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}