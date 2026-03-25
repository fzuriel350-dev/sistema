<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // Esta línea es la que soluciona el error
    protected $fillable = ['nombre', 'email'];
}