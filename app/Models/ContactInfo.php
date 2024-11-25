<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'contact_info'; // Nama tabel jika berbeda dari nama model
    protected $fillable = [
        'email',
        'phone',
    ];


}