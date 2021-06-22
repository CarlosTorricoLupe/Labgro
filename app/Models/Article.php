<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'articles';

    protected $fillable = [
        'nombre_articulo',
        'categoria',
        'unidad_medida',
        'cantidad'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
}
