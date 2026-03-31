<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Nombre de la tabla en la base de datos de la UPTex.
     */
    protected $table = 'usuarios'; //

    /**
     * Atributos asignables masivamente.
     * Se usa 'nombre' en lugar de 'name'.
     */
    protected $fillable = [
        'nombre', //
        'email',
        'password',
        'rol',
    ];

    /**
     * Atributos ocultos para la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atributos virtuales que se añaden al JSON del modelo.
     */
    protected $appends = ['name'];

    /**
     * Conversión de tipos de atributos.
     */
    protected function casts(): array
    {
        return [
            // Se comenta email_verified_at porque tu tabla no tiene esa columna
            // 'email_verified_at' => 'datetime', 
            'password' => 'hashed',
        ];
    }

    /**
     * Accessor: Permite obtener el valor de 'nombre' usando $user->name.
     * Esto evita errores en componentes internos de Laravel.
     */
    public function getNameAttribute()
    {
        return $this->nombre;
    }

    /**
     * Mutator: Permite asignar un valor a 'nombre' usando $user->name = 'Valor'.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['nombre'] = $value;
    }

    /**
     * Indica a Laravel que el identificador de autenticación es 'id'.
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }
}