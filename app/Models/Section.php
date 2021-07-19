<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','Active'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

}
