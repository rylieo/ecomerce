<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Daftar kebijakan untuk aplikasi.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Daftarkan semua kebijakan atau kebijakan khusus aplikasi.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Contoh: Mendefinisikan Gate untuk menentukan akses tertentu
        // Gate::define('update-post', function ($user, $post) {
        //     return $user->id === $post->user_id;
        // });
    }
}
