<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialsOrder extends Model
{
    protected $table = 'materials_order';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    use HasFactory;
    protected $fillable = [
        'request_amount',
        'details',
        'article_id'
    ];
    public function articles()
    {
        return $this->belongsTo('App\Article');
    }
}
