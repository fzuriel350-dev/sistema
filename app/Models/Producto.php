<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Esto permite guardar cualquier dato desde Tinker o formularios
    protected $guarded = [];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}