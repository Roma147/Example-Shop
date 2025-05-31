<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'image_url',
        'category', // Убедитесь, что 'category' здесь есть
    ];

    /**
     * Получить все уникальные категории товаров.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getUniqueCategories()
    {
        return self::distinct('category')->pluck('category')->filter()->sort();
    }
}