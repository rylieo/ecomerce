<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    // Menambahkan properti fillable
    protected $fillable = [
        'title',       // Menambahkan title agar bisa diisi secara massal
        'file_path',   // Pastikan file_path juga ada di sini
        'type',        // Jika Anda menggunakan kolom ini, tambahkan juga
    ];

    // Jika Anda menggunakan 'casts', tambahkan di sini
    // protected $casts = [
    //     'type' => 'string',
    // ];
}
