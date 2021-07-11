<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    use HasFactory;
    protected $table = 'item_prices';
    protected $fillable = [
        'unit_price'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function articles(){
        return $this->hasMany(Article::class);
    }
}
