<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    // 1. Definimos los campos que se pueden llenar (Mass Assignment)
    protected $fillable = [
        'user_id', 
        'descripcion', 
        'producto_nombre', 
        'accion'
    ];

    /**
     * 2. Relación: Un log pertenece a un Usuario.
     * Esto permite que en la vista pongas $log->user->name
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}