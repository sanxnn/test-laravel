<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'price',
        'stock',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
