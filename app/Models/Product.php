<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Properti $fillable untuk mass assignment
    protected $fillable = ['name', 'description', 'price', 'category_id', 'photo', 'stock'];

    // Relasi ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Metode boot untuk validasi sebelum menyimpan data
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            // Pastikan stok tidak negatif
            if ($product->stock < 0) {
                throw new \Exception('Stock cannot be negative.');
            }
        });
    }
}
