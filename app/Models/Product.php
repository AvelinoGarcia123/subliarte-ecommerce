<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Campos permitidos para guardar
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'image_path',
        'is_customizable',
    ];

    // Relación: Un producto pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}