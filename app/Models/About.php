<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    // Daftar atribut yang dapat diisi secara mass assignment
    protected $fillable = [
        'title',
        'description',
        'image', // Menambahkan kolom foto
    ];
}
