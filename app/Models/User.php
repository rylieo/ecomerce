<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'name',
        'email',
        'password',
        'plain_password',
        'phone',
        'jenis_kelamin',  // Pastikan kolom ini ada di tabel 'users'
        'tanggal_lahir',  // Pastikan kolom ini ada di tabel 'users'
        'alamat',         // Pastikan kolom ini ada di tabel 'users'
        'profile_picture', // Pastikan kolom ini ada di tabel 'users'
        'verification_token', // Pastikan kolom ini ada di tabel 'users'
        'role',
    ];

    // Kolom yang akan disembunyikan dari array dan JSON
    protected $hidden = [
        'password',
    ];

    // Mengatur format kolom
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_lahir' => 'date', // Format tanggal untuk 'tanggal_lahir'
    ];

    // Mengirim notifikasi email verifikasi
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmailNotification());
    }
}
